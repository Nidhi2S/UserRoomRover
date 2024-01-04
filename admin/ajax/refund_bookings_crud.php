<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");
// Function to check if user is logged in as an admin
adminLogin();

// Get Bookings
if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.id = bd.booking_id WHERE (bo.order_id LIKE '%$frm_data[search]%' OR bd.phonenum LIKE '%$frm_data[search]%' OR bd.user_name LIKE '%$frm_data[search]%') AND (bo.booking_status = 'cancelled' AND bo.refund = 0) ORDER BY bo.id ASC";
    $res = mysqli_query($con, $query);

    $i = 1;
    $table_data = "";

    // Check if any rows were returned
    if (mysqli_num_rows($res) == 0) {
        echo "<b>No data found</b>";
        exit;
    }

    while ($data  = mysqli_fetch_assoc($res)) {

        $date = date("d-m-Y", strtotime($data['date&time']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        $bookingId = $data['booking_id'];
        // var_dump($bookingId);

        $table_data .= " <tr>
        <td>$i</td>
        <td>
            <span class='badge bg-primary'>
                ORDER ID: {$data['order_id']}
            </span>
                <br>
            <b>Name : </b> $data[user_name]
                <br>
            <b>Phone : </b> $data[phonenum]
        </td>

        <td> 
            <b>Room : </b> $data[room_name]
                <br>
            <b>Checkin : </b> $checkin
                <br>
            <b>Checkout : </b> $checkout
                <br>
            <b>Date : </b> $date
        </td>

        <td>
            <b> $data[trans_amt]</b>
        </td>
          
    
        <td class='text-center'>
            <button type='button' onclick='refund_booking($bookingId)' class='btn w-75 btn-success btn-sm fw-bold  shadow-none ' data-bs-toggle='modal' data-bs-target='#'>
                <i class='bi bi-cash-coin pe-2'></i> Refund
            </button>
        </td>
        </tr>";
        $i++;
    }
    echo $table_data;
}

// Refund
if (isset($_POST['refund_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET  `refund`= ? WHERE `id` = ?";
    $values = [1, $frm_data['booking_id']];
    $res = update($query, $values, 'ii');

    if ($res === false) {
        // Log the error or handle it appropriately
        echo "Error updating database.";
    } else {
        echo $res; // update 1 row, it will return 1
    }
}
