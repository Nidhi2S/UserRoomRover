<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// unset($_SESSION['room']);
// require('./include/config.php');
require("./admin/include/essentials.php");
require("./admin/include/db_config.php");
date_default_timezone_set('asia/Kolkata');

// require_once('pay_now.php');


// Retrieve values from session
$data_id = $_SESSION['payment_data']['data_id'];
$data_trnsId = $_SESSION['payment_data']['data_trnsId'];
$data_status = $_SESSION['payment_data']['data_status'];
$data_response = $_SESSION['payment_data']['data_response'];
$txn_amount = $_SESSION['payment_data']['txn_amount'];

$ORDER_ID = $_GET['order'];

// echo "<pre>";
// var_dump($_SESSION['payment_data']);

$slct_query = "SELECT * FROM `booking_order` INNER JOIN booking_details ON booking_order.id = booking_details.booking_id WHERE `order_id` = '$ORDER_ID'";

$slct_res = mysqli_query($con, $slct_query);

if (mysqli_num_rows($slct_res) == 0) {
    redirect("index.php");
}

$slct_fetch = mysqli_fetch_assoc($slct_res);

// if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
// }


if ($data_status ==  "succeeded") {
    $upd_query1 = "UPDATE `booking_order`
    SET
        `booking_status` = 'booked',
        `trans_id` = '$data_trnsId',
        `trans_amt` = '$txn_amount',
        `trans_status` = '$data_status',
        `trans_res_msg` = '$data_response'
    WHERE
        id = '$slct_fetch[booking_id]'";
    if(mysqli_query($con, $upd_query1)){
        // var_dump("hello response", $txn_amount);
        redirect('pay_status.php?order=' . $ORDER_ID);
    };
} else {
    $upd_query2 = "UPDATE `booking_order`
    SET
        `booking_status` = 'payment_failed',
        `trans_id` = '$data_trnsId',
        `trans_amt` = '$txn_amount',
        `trans_status` = '$data_status',
        `trans_res_msg` = '$data_response'
    WHERE
        id = '$slct_fetch[booking_id]'";
    if(mysqli_query($con, $upd_query2)){
        redirect('pay_status.php?order=' . $ORDER_ID);
    };
}


