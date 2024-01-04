<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('asia/Kolkata');
require_once('vendor/autoload.php');
require('./include/config.php');
require("./admin/include/db_config.php");
require("./admin/include/essentials.php");

echo '<pre>';
\Stripe\Stripe::setVerifySslCerts(false);
print_r($_POST);
$token = $_POST['stripeToken'];
var_dump($token);

$token = isset($_POST['stripeToken']) ? $_POST['stripeToken'] : '';
if (empty($token)) {
    echo 'Error: Stripe token is missing.';
    exit;
}

function regenrate_session($uid)
{
    $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uid], "i");
    $user_fetch  =  mysqli_fetch_assoc($user_q);

    $_SESSION['login'] = true;
    $_SESSION['uId']   = $user_fetch['id'];
    $_SESSION['uName'] = $user_fetch['name'];
    $_SESSION['uProfile'] = $user_fetch['profile'];
    $_SESSION['uPhone'] = $user_fetch['phonenum'];
}


// Check if the user is logged in and has a valid ID in the session
if (isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_SESSION['uId'])) {
    $uid = $_SESSION['uId'];
    regenrate_session($uid);
}

$total_amount = $_POST['total_amount'];

$selected_date_count = $_POST['selected_date_count'];

$final_amount = $total_amount * $selected_date_count;


try {
    $data = \Stripe\Charge::create(array(
        "amount" => $final_amount * 100,
        "currency" => "inr",
        "description" => " Successfully paid ",
        "source" => $token,

    ));
   
    $_SESSION['payment_data'] = array(
        'data_id' => $data['id'],
        'data_trnsId' => $data['balance_transaction'],
        'data_status' => $data['status'],
        'data_response' => $data['outcome']['seller_message'],
        'txn_amount' => $data['amount'] / 10,
    );

    // Insertion code
    $frm_data = filteration($_POST);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(1111111, 99999999);
        $CUST_ID = $_SESSION['uId'];
        $TXN_AMOUNT = $_SESSION['room']['payment'];
        $frm_data = filteration($_POST);

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) VALUES (?,?,?,?,?)";
        insert($query1, [$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID], 'issss');

        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,`user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
        insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['phonenum'], $frm_data['address']], 'issssss');

        // If insertion is successful, redirect to pay_response.php
        header("Location: pay_response.php?order=" . urlencode($ORDER_ID));
        exit; 
    }
} catch (\Stripe\Exception\CardException $e) {
    echo 'Card Error: ' . $e->getError()->message;
} catch (\Stripe\Exception\RateLimitException $e) {
    echo 'Rate Limit Error: ' . $e->getError()->message;
} catch (\Stripe\Exception\InvalidRequestException $e) {
    echo 'Invalid Request Error: ' . $e->getError()->message;
} catch (\Stripe\Exception\AuthenticationException $e) {
    echo 'Authentication Error: ' . $e->getError()->message;
} catch (\Stripe\Exception\ApiConnectionException $e) {
    echo 'API Connection Error: ' . $e->getError()->message;
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo 'Stripe API Error: ' . $e->getError()->message;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

