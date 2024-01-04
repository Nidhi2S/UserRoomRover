<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// files for database configuration and essential functions
require("../admin/include/db_config.php");
require("../admin/include/essentials.php");
date_default_timezone_set('asia/Kolkata');
if (!(isset($_SESSION['login']) && $_SESSION['login'] == 'true')) {
    redirect('index.php');
}


if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `id`=? AND `user_id`=?";
    $values = ['cancelled', 0, $frm_data['id'], $_SESSION['uId']];
    $result = update($query, $values, 'siii');
    echo $result;
}
