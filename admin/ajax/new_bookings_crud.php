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

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.id = bd.booking_id WHERE (bo.order_id LIKE '%$frm_data[search]%' OR bd.phonenum LIKE '%$frm_data[search]%' OR bd.user_name LIKE '%$frm_data[search]%') AND (bo.booking_status = 'booked' AND bo.arrival = 0) ORDER BY bo.id ASC";
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
        <td><span class='badge bg-primary'>
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
            <b>Price : </b> ₹$data[price]
        </td>

        <td> 
        <b>Checkin : </b> $checkin
            <br>
        <b>Checkout : </b> $checkout
        <br>
            <b>Paid : </b> ₹$data[trans_amt]
            <br>
            <b>Date : </b> $date
        </td>
        <td class = 'text-center'>
            <!-- Button trigger modal -->
            <button type='button' onclick='assign_room($bookingId)' class='btn text-white w-75 text-center btn-sm fw-bold custom-bg shadow-none ' data-bs-toggle='modal' data-bs-target='#assign-room'>
                <i class='bi bi-check2-square'></i> Assign Room
            </button>
        
            <br>
            <button type='button' onclick='cancel_booking($bookingId)' class='btn btn-outline-danger w-75 text-center btn-sm fw-bold  shadow-none mt-2 ' data-bs-toggle='modal' data-bs-target='#'>
                <i class='bi bi-trash'></i> Cancel Booking
            </button>
        </td>
        </tr>";
        $i++;
    }
    echo $table_data;
}

// ASSIGN ROOM(Admin)
if (isset($_POST['assign_room'])) {
    $frm_data = filteration($_POST);
    var_dump("hechgchggdc", $frm_data);

    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd  ON bo.id = bd.booking_id SET bo.arrival = ? ,bo.rate_review=?, bd.room_no= ? WHERE bo.id = ?";
    $values = [1, 0, $frm_data['room_no'], $frm_data['booking_id']];
    $res = update($query, $values, 'iisi');
    echo ($res == 2) ? 1 : 0; // update 2 rows it will return 2
}


// Remove ROOM(admin)
if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET  `booking_status`=?,`refund`= ? WHERE `id` = ?";
    $values = ['cancelled', 0, $frm_data['booking_id']];
    $res = update($query, $values, 'sii');

    if ($res === false) {
        // Log the error or handle it appropriately
        echo "Error updating database.";
    } else {
        echo $res; // update 1 row, it will return 1
    }
}

