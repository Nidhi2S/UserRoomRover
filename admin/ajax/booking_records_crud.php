<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");


// Get Bookings
if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);

    $limit = 2;
    $page = $frm_data['page'];
    $start = ($page - 1) * $limit;

    // Query to get data from booking order and booking details table to show records 
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.id = bd.booking_id
     WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
     OR(bo.booking_status ='cancelled' AND bo.refund = 1)
     OR(bo.booking_status ='payment failed'))
     AND(bo.order_id LIKE '%$frm_data[search]%' OR bd.phonenum LIKE '%$frm_data[search]%' OR bd.user_name LIKE '%$frm_data[search]%') 
     ORDER BY bo.id DESC";

    $res = mysqli_query($con, $query);

    $limit_query = $query . " LIMIT $start,$limit";
    $limit_res = mysqli_query($con, $limit_query);

    $total_rows = mysqli_num_rows($res);

    // Check if any rows were returned
    if ($total_rows == 0) {
        $output = json_encode(['table-data' => "<b>No data found</b>", "pagination" => '']);
        echo $output;
        exit;
    }

    $i = $start + 1;
    $table_data = "";
    while ($data  = mysqli_fetch_assoc($limit_res)) {

        $date = date("d-m-Y", strtotime($data['date&time']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        $bookingId = $data['booking_id'];
        if ($data['booking_status'] == 'booked') {
            $status_bg = 'bg-success';
        } else  if ($data['booking_status'] == 'cancelled') {
            $status_bg = 'bg-danger';
        } else {
            $status_bg = 'bg-warning text-dark';
        }

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
            <b>Amount : </b> ₹$data[trans_amt]
            <br>
            <b>Date : </b> $date
        </td>
          
        <td class='text-center'> 
        <span class ='badge w-75 $status_bg'>
            $data[booking_status]
        </span>
        </td>
            
        <td class='text-center'>
            <button type='button' onclick='download($bookingId)' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#'>
            <i class='bi bi-file-earmark-arrow-down-fill'></i>
            </button>
        </td>
        </tr>";
        $i++;
    }

    $pagination = "";

    if ($total_rows > $limit) {
        $total_pages = ceil($total_rows / $limit);

        if ($page != 1) {
            $pagination .= " <li class='page-item'>
            <button onclick = 'change_page(1)' class='page-link shadow-none'>First</button>
            </li>";
        }

        $disabled = ($page == 1) ? "disabled" : "";
        $prev = $page - 1;
        $pagination .= " <li class='page-item $disabled'><button onclick = 'change_page($prev)' class='page-link shadow-none'>Prev</button></li>";

        $disabled = ($page == $total_pages) ? "disabled" : "";
        $next = $page + 1;
        $pagination .= " <li class='page-item $disabled'><button onclick = 'change_page($next)' class='page-link shadow-none'>Next</button></li>";

        if ($page != $total_pages) {
            $pagination .= " <li class='page-item'>
            <button onclick = 'change_page($next)' class='page-link shadow-none'>Last</button>
            </li>";
        }
    }

    $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);
    echo $output;
}
