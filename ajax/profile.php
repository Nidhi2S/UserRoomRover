<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// files for database configuration and essential functions
require("../admin/include/db_config.php");
require("../admin/include/essentials.php");
date_default_timezone_set('asia/Kolkata');

if (isset($_POST['info-form'])) {

    $frm_data = filteration($_POST);
    // check user exist
    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `email` =? OR `phonenum` = ? AND `id`= ? LIMIT 1",
        [$data['email'], $data['phonenum'], $_SESSION['uId']],
        "sss"
    );

    if (mysqli_num_rows($u_exist) != 0) {
        echo 'phone_already';
        exit;
    }
    $query = "UPDATE `user_cred` SET `name`=?,`address`=?,`phonenum`=?,`pincode`=?,`dob`=? WHERE id =?";
    $values = [$frm_data['name'], $frm_data['address'], $frm_data['phonenum'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uId']];
    var_dump($frm_data['name']);
    $res = update($query, $values, 'ssssss');
    if ($res) {
        $_SESSION['uName'] = $frm_data['name'];
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['profile_form'])) {

    $img = uploadUserImage($_FILES['profile']);
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    // fetching old image
    $u_exist = select("SELECT `profile` FROM `user_cred` WHERE `id`= ? LIMIT 1", [$_SESSION['uId']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);
    // var_dump($u_fetch['profile']);

    deleteImage($u_fetch['profile'], USERS_FOLDER);

    // UPDATE img
    $query = "UPDATE `user_cred` SET `profile`=? WHERE id =?";
    $values = [$img, $_SESSION['uId']];
    $res = update($query, $values, 'ss');
    // if ($res) {
    //     echo "yes";
    // }
    if ($res) {
        $_SESSION['uPic'] = $img;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['pass_form'])) {
    $frm_data = filteration($_POST);

    if ($frm_data['new_pass'] != $frm_data['confirm_pass']) {
        echo "mismatch ";
        exit;
    }

    var_dump($frm_data['new_pass']);
    $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);
    var_dump($enc_pass);

    // UPDATE Password
    $query = "UPDATE `user_cred` SET `password`=? WHERE id =? LIMIT 1";
    $values = [$enc_pass, $_SESSION['uId']];
    $res = update($query, $values, 'ss');
    // if ($res) {
    //     echo "yes";
    // }
    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}
