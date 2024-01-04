<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// files for database configuration and essential functions
require("../admin/include/db_config.php");
require("../admin/include/essentials.php");
date_default_timezone_set('asia/Kolkata');

if (isset($_POST['check_availability'])) {
    $frm_data = filteration($_POST);

    $status = "";
    $result = "";

    // check in and out validations

    $today_date = new DateTime(date('Y-m-d'));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    if ($checkin_date == $checkout_date) {
        $status = 'check_in_out_equal';
        $result = json_encode(["status" => $status]);
    } else if ($checkin_date > $checkout_date) {
        $status = 'check_out_earlier';
        $result = json_encode(["status" => $status]);
    } else if ($checkin_date < $today_date) {
        $status = 'check_in_earlier';
        $result = json_encode(["status" => $status]);
    }

    //check booking availability if status is blank else return the error
    if ($status != '') {
        echo $result;
    } else {

        $roomID = (int) $_SESSION['room']['id'];

        // run query to check room availability
        $tb_query  = "SELECT COUNT(*) AS total_bookings FROM `booking_order` WHERE `booking_status`='booked' AND room_id = '$roomID' AND check_out >'$frm_data[check_in]'";
        $tb_fetch = mysqli_fetch_assoc(mysqli_query($con, $tb_query));

        $rq_result = "SELECT `quantity` FROM `rooms` WHERE `id` = '$roomID'";
        $rq_fetch_run = mysqli_fetch_assoc(mysqli_query($con, $rq_result));

        if (($rq_fetch_run['quantity'] - $tb_fetch['total_bookings']) <= 0) {
            $status = "unavailable";
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        }

        $count_days = date_diff($checkin_date, $checkout_date)->days;
        $payment = $_SESSION['room']['price'] * $count_days;

        $_SESSION['room']['payment'] = $payment;
        $_SESSION['room']['available'] = true;

        $result = json_encode(["status" => 'available', "days" => $count_days, "payment" => $payment]);
        echo $result;
    }
}
