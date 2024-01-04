<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// files for database configuration and essential functions
require("../admin/include/db_config.php");
require("../admin/include/essentials.php");
date_default_timezone_set('asia/Kolkata');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require("../include/php_mailer/Exception.php");
require("../include/php_mailer/PHPMailer.php");
require("../include/php_mailer/SMTP.php");

// SEND MAIL
function send_mail($email,  $token, $type)
{
    if ($type == "email_confirmation") {
        $page = "email_confirm.php";
        $subject = "Account verification link";
        $content = "Confirm your email";
    } else {
        $page = "index.php";
        $subject = "Account reset link";
        $content = "reset your account";
    }
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;

        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'nidhi.mind2web@gmail.com';                     //SMTP username
        $mail->Password   = 'obeddsqsycszrspv';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;


        //Recipients
        $mail->setFrom(SEND_EMAIL, SEND_NAME);
        $mail->addAddress($email);     //Add a recipient  

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "$subject";
        $mail->Body = " Click the link to $content : <br>
                         <a href=" . SITE_URL . "$page?$type&email=$email&token=$token" . ">
                            CLICK ME
                         </a>
                      ";

        if ($mail->send()) {
            return 1;
        } else {
            return 0;
        }
    } catch (Exception $e) {
        return 0;
    }
}
// USER REGISTER
if (isset($_POST['register'])) {
    $data = filteration($_POST);

    //password and cpassword
    if ($data['pass'] != $data['cpass']) {
        echo "password_mismatch";
        exit;
    }

    // check user exist
    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `email` =? OR `phonenum` = ? LIMIT 1",
        [$data['email'], $data['phonenum']],
        "ss"
    );


    if (mysqli_num_rows($u_exist) != 0) {

        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email'] ? 'email_already' : 'phone_already');
        exit;
    }

    //upload image user to srever
    $img = uploadUserImage($_FILES['profile']);
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }
    // send confirmation link
    $token = bin2hex(random_bytes(16));
    if (!send_mail($data['email'], $token, "email_confirmation")) {
        echo "mail_failed";
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
    $query  = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`,  `token`)
    VALUES (?,?,?,?,?,?,?,?,?)";
    $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['dob'], $img, $enc_pass, $token];
    if (insert($query, $values, 'sssssssss')) {
        echo 1;
    } else {
        echo "ins_failed";
    }
}
// USER LOGIN
if (isset($_POST['login'])) {
    $data = filteration($_POST);

    // check user exist
    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `email` =? OR `phonenum` = ? LIMIT 1",
        [$data['email_mob'], $data['email_mob']],
        "ss"
    );

    if (mysqli_num_rows($u_exist) == 0) {
        echo "inv_email_mob";
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo "not_verified";
        } else if ($u_fetch['status'] == 0) {
            echo "inactive";
        } else {
            if (!password_verify($data['pass'], $u_fetch['password'])) {
                echo "invalid_pass";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;
            }
        }
    }
}
// FORGOT PASSWORD
if (isset($_POST['forgot_pass'])) {

    $data = filteration($_POST);
    // check user exist
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email` =?  LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        echo "inv_email";
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);

        if ($u_fetch['is_verified'] == 0) {
            echo "not_verified";
        } else if ($u_fetch['status'] == 0) {
            echo "inactive";
        } else {
            // send reset link to email
            $token = bin2hex(random_bytes(16));
            if (!send_mail($data['email'], $token, "account_recovery")) {
                echo "mail_failed";
            } else {
                $date = date("Y-m-d");
                // $query =   mysqli_query($con, "UPDATE `user_cred` SET `token`='$token',`token_expire`='$date' WHERE 'id' = '$u_fetch[id]");
                $query = mysqli_query($con, "UPDATE `user_cred` SET `token`='$token', `token_expire`='$date' WHERE `id` = '$u_fetch[id]'");

                if ($query) {
                    echo 1;
                } else {
                    echo "upd_failed";
                }
            }
        }
    }
}

// Reset Email
if (isset($_POST['recover_user'])) {
    $data = filteration($_POST);
    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
    $query = "UPDATE `user_cred` SET `password` = ?, `token` = ?, `token_expire` = ? WHERE `email` = ? AND `token` = ?";
    $values = [$enc_pass, null, null, $data['email'], $data['token']];
    if (update($query, $values, 'sssss')) {
        echo 1;
    } else {
        echo 'failed';
    }
}
