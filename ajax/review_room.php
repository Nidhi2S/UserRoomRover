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


if (isset($_POST['review_form'])) {
    $frm_data = filteration($_POST);
    // var_dump($frm_data);

    $query = "UPDATE `booking_order` SET `rate_review`=? WHERE `id`=? AND `user_id`=?";
    $upd_values = [1, $frm_data['booking_id'], $_SESSION['uId']];
    $upd_result = update($query, $upd_values, 'iii');
    
    $ins_query = "INSERT INTO `rating_review`( `booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?,?,?,?,?)";
    $ins_values = [$frm_data['booking_id'], $frm_data['room_id'], $_SESSION['uId'], $frm_data['rating'], $frm_data['review']];
    $ins_result = insert($ins_query, $ins_values, 'iiiss');

    if ($ins_result) {
        echo $ins_result;
    } else {
        echo "Error inserting data into the database";
    }
}



