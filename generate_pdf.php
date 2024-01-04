<?php
session_start();
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
require("admin/include/essentials.php");
require("admin/include/db_config.php");
// for mpdf downloader
require("admin/include/mpdf/vendor/autoload.php");

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect("rooms.php");
}

if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {
    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, bd.*, uc.email FROM `booking_order` bo 
    INNER JOIN `booking_details` bd ON bo.id = bd.booking_id
    INNER JOIN `user_cred` uc ON bo.user_id = uc.id
    WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
    OR (bo.booking_status ='cancelled' AND bo.refund = 1)
    OR (bo.booking_status ='payment failed'))
    AND bo.id = '$frm_data[id]'";


    $res = mysqli_query($con, $query);
    // var_dump($res);
    $total_rows = mysqli_num_rows($res);

    // var_dump($total_rows);

    // Check if any rows were returned
    if ($total_rows == 0) {
        header('location:index.php');
        exit;
    }

    $data  = mysqli_fetch_assoc($res);
    $date = date("h:ia | d-m-Y", strtotime($data['date&time']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));
    // echo $date;
    $table_data = "
    <h2>Booking Receipt</h2>
    <table border='1'>
        <tr>
            <td>ORDER ID : $data[order_id]</td>
            <td>Booking Date : $date</td>

        </tr>
        <tr>
            <td> Status : $data[booking_status]</td>
        </tr>
        <tr>
            <td> Name : $data[user_name]</td>
            <td> Email : $data[email]</td>
        </tr>
        <tr>
            <td> Phone Number : $data[user_name]</td>
            <td> Address : $data[address]</td>
        </tr>
        <tr>
            <td> Room Name : $data[room_name]</td>
            <td> Price : ₹$data[price] per night</td>
        </tr>
        <tr>
            <td> Check In : $data[check_in]</td>
            <td> Check out :$data[check_out]</td>
        </tr>
      
    ";

    if ($data['booking_status'] == 'cancelled') {
        $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";
        $table_data .= "<tr>
            <td> Amount Paid : $data[trans_amt] </td>
            <td> Refund: $refund </td>
       </tr>";
    } else if ($data['booking_status'] == 'payment failed') {
        $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";
        $table_data .= "<tr>
            <td>Transaction Amount  : $data[trans_amt] </td>
            <td> Failure Response : $data[trans_resp_msg] </td>
       </tr>";
    } else {
        $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";
        $table_data .= "<tr>
            <td>Room Number  : $data[room_no] </td>
            <td>Amount Paid : $data[trans_amt] </td>
       </tr>";
    }

    $table_data .= "  </table>";
    echo $table_data;
    // Create an instance of the class:
    $mpdf = new \Mpdf\Mpdf();

    // Write some HTML code:
    $mpdf->WriteHTML($table_data);

    // Output a PDF file directly to the browser with a specific filename
    $mpdf->Output($data['order_id'] . '.pdf', 'D');
} else {
    header('location: index.php');
}
?>
<a href="index.php"></a>