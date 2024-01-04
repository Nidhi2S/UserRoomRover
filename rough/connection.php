// Get Bookings
if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);
    var_dump($frm_data);
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.id = bd.booking_id WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) AND (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.id ASC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "booked", 0], "sss");

    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b> No data found</b>";
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
        <td>
            <!-- Button trigger modal -->
            <button type='button' onclick='assign_room($bookingId)' class='btn text-white btn-sm fw-bold custom-bg shadow-none ' data-bs-toggle='modal' data-bs-target='#assign-room'>
                <i class='bi bi-check2-square'></i> Assign Room
            </button>
        
            <br>
            <button type='button'  onclick='cancel_booking($bookingId)' class='btn btn-outline-danger btn-sm fw-bold  shadow-none mt-2 ' data-bs-toggle='modal' data-bs-target='#'>
                <i class='bi bi-trash'></i> Cancel Booking
            </button>
        </td>
        </tr>";
        $i++;
    }
    echo $table_data;
}