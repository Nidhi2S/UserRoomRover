<?php
session_start();

if (isset($_SESSION['stripe_data'])) {
    $data = $_SESSION['stripe_data'];

    // Now you can use $data as needed

    // Unset the session variable if you no longer need it
    unset($_SESSION['stripe_data']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?>- BOOKING STATUS</title>

</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>
    <?php
    // require("./admin/include/db_config.php");
    // echo "hii";
    ?>


    <div class="container">
        <div class="row">

            <div class="col-12 mb-3 my-5 px-4">
                <h2 class="fw-bold ">PAYMENT STATUS</h2>

                <?PHP

                $data_id = $_SESSION['payment_data']['data_id'];
                $data_trnsId = $_SESSION['payment_data']['data_trnsId'];
                $data_status = $_SESSION['payment_data']['data_status'];
                $data_response = $_SESSION['payment_data']['data_response'];
                $txn_amount = $_SESSION['payment_data']['txn_amount'];


                $frm_data = filteration($_GET);
                // echo "<pre>";
                // var_dump("gettt", $frm_data);
                if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
                    redirect("index.php");
                }

                $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.id = bd.booking_id WHERE bo.order_id = '$frm_data[order]' AND bo.user_id = '$_SESSION[uId]' AND bo.booking_status != 'pending'";

                $booking_res = mysqli_query($con, $booking_q);

                // var_dump("booking reds", $booking_q);

                // $booking_res = mysqli_query($con, $booking_q);

                // Check for errors in the query execution
                if ($booking_res === false) {
                    echo 'Query error: ' . mysqli_error($con);
                    exit;
                }

                // Continue with the rest of your code


                // $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uId'], 'pending'], 'sis');

                if (mysqli_num_rows($booking_res) == 0) {
                    redirect('index.php');
                }

                // echo '<pre>';
                // var_dump($data_status, "data status");
                if ($data_status == "succeeded") {
                    echo <<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Payment done: Booking successful!
                            <br><br>
                            <a href="bookings.php">Go to Bookings</a>
                        </p>
                    </div>
                    data;
                } else {
                    echo <<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Payment failed: $booking_fetch[trans_resp_msg]
                            <br><br>
                            <a href="bookings.php">Go to Bookings</a>
                        </p>
                    </div>
                    data;
                }


                ?>

            </div>
        </div>


        <!-- Footer File -->
        <?php require("include/footer.php"); ?>

</body>


</html>