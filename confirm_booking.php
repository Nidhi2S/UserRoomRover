<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?>- CONFIRM BOOKING</title>

</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>

    <?php
    // ----------------------------------------------------------------------------STRIPE---------------------------------------------------------------------------------
    require('./include/stripe-php-master/init.php');
    $publishable_key = "pk_test_51ONBaqLU1sr7cVCEay81WOQU5EAlLVxoh5no4773KTCXcuttYApeaiOTNI0BN96jd1nlwRUPoCWjisi271Zm3vcf00g3GfjoPs";
    $secret_key = "sk_test_51ONBaqLU1sr7cVCEACStJbjqnvSOQjPoxKQ5CsSOLxrwhnKX18BbVSlMYyXiYa01BDzRjLLD8ARYiTB9yeboWmn000trp5z8Rj";
    \Stripe\Stripe::setApiKey($secret_key);
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    // check room id from url present is not
    // shutdown mode is active or
    // not user log in not
    if (!isset($_GET['id']) || $settings_r['shutdwon'] == true) {
        redirect("rooms.php");
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect("rooms.php");
    }

    // Filter and get room and user data
    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id` = ? AND `status` = ? AND `removed` = ?", [$data['id'], 1, 0], 'iii');
    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);
    // var_dump("nidhi", $room_data['price']);
    $total_amount = $room_data['price'];
    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false
    ];
    // print_r($_SESSION['room']);
    // exit;
    $user_res = select(
        "SELECT * FROM `user_cred` WHERE `id` = ?  LIMIT 1",
        [$_SESSION['uId']],
        "i"
    );
    $user_data = mysqli_fetch_assoc($user_res);
    ?>
    <div class="container">
        <div class="row">

            <div class="col-12 mb-4 my-5 px-4">
                <h2 class="fw-bold ">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Confirm</a>

                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <?php

                // get thumb nail of image
                $room_thumb = ROOMS_IMG_PATH . "thumb_nail.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]' and `thumb` = '1'");
                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }
                echo <<<data
                        <div class="card p-3 shadow-small rounded">
                            <img src="$room_thumb" class="img-fluid rounded mb-3">
                            <h5>$room_data[name]</h5>
                            <h6> ₹ $room_data[price]  per night</h6>
                        </div>
                        data;
                ?>

            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="pay_now.php" id="booking_form" method="post">
                            <h6 class="mb-3">BOOKING DETAILS</h6>

                            <input type="hidden" name="total_amount" value="<?= $total_amount; ?>">

                            <input type="hidden" name="stripeToken" value="tok_123456789">

                            <input type="hidden" name="selected_date_count" id="selected_date_count" value="0">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-1">Name</label>
                                    <input name="name" value="<?php echo $user_data['name'] ?>" type="text" class="form-control shadow-none">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" value="<?php echo $user_data['phonenum'] ?>" type="number" class="form-control shadow-none">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address'] ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label ">Check-in </label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out </label>
                                    <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none">
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger" id="pay_info">Provide check in & check out date !</h6>

                                    <!-- <input type="hidden" name="stripeToken" value="tok_123456789"> -->
                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo $publishable_key; ?>" data-amount="<?= $total_amount * 100 ?>" data-name=" <?php echo $_SESSION['uName'] ?>" data-description="You are paying to :" + <?php $room_data['room_id'] ?> data-image="./images/upload_images/cardpayment.png" data-currency="inr" data-email=" <?php echo $_SESSION['email'] ?>"></script>
                                    <button type="submit" name="pay_now" class="btn w-100 text-white btn-custom custom-bg shadow-none mb-1" disabled>
                                        Pay Now
                                    </button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 px-4 mt-4">
                <div class="mt-4 mb-5">
                    <h5>Description</h5>
                    <p>
                        <?php
                        // var_dump($room_data);
                        echo $room_data['description'];
                        ?>
                    </p>
                </div>
                <div class="review-rating">
                    <h5 class="mb-3">
                        Review & Rating
                    </h5>
                    <div>
                        <div class="swiper-slide bg-white p-4">
                            <div class=" d-flex align-items-center mb-2">
                                <img src="images/features/wifi.svg" width="30px" alt=".">
                                <h6 class="m-0 ms-2">Random user 1</h6>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi iusto et eos nihil pariatur
                                odit repudiandae. Quo dignissimos quod cupiditate, quia quis tempora ad recusandae
                                reiciendis culpa iure in saepe.</p>
                            <div class="rating">
                                <i class="bi bi-star-fill text-warning "></i>
                                <i class="bi bi-star-fill text-warning "></i>
                                <i class="bi bi-star-fill text-warning "></i>
                                <i class="bi bi-star-fill text-warning "></i>
                                <i class="bi bi-star-fill text-warning "></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Footer File -->
        <?php require("include/footer.php"); ?>
        <script>
            let booking_form = document.getElementById('booking_form');
            let info_loader = document.getElementById('info_loader');
            let pay_info = document.getElementById('pay_info');
            // Update the hidden input field with the selected date count
            // booking_form.elements['selected_date_count'].value = selectedDateCount;

            function check_availability() {
                let checkin_val = booking_form.elements['checkin'].value;
                let checkout_val = booking_form.elements['checkout'].value;

                booking_form.elements['pay_now'].setAttribute('disabled', true);
                if (checkin_val != '' && checkout_val != '') {

                    // Calculate the selected date count
                    let startDate = new Date(checkin_val);
                    let endDate = new Date(checkout_val);
                    let timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                    let selectedDateCount = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    // Update the hidden input field with the selected date count
                    booking_form.elements['selected_date_count'].value = selectedDateCount;

                    pay_info.classList.add('d-none');
                    pay_info.classList.replace('text-dark', 'text-danger');
                    info_loader.classList.remove('d-none');

                    let data = new FormData();
                    data.append('check_availability', '');
                    data.append('check_in', checkin_val);
                    data.append('check_out', checkout_val);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/confirm_booking.php", true);
                    xhr.onload = function() {
                        let data = JSON.parse(this.responseText);
                        if (data.status == 'check_in_out_equal') {
                            pay_info.innerText = "You cannot checkout on the same date";
                        } else if (data.status == 'check_out_earlier') {
                            pay_info.innerText = "Checkout date is earlier than the check-in date";
                        } else if (data.status == 'check_in_earlier') {
                            pay_info.innerText = "Check-in date is earlier than today's date";
                        } else if (data.status == 'unavailable') {
                            pay_info.innerText = "Room is not available for this check-in date";
                        } else {

                            pay_info.innerHTML = "No.of days:" + data.days + "<br>Total Amount to Pay: ₹" + data.payment;
                            pay_info.classList.replace('text-danger', 'text-dark');
                            booking_form.elements['pay_now'].removeAttribute('disabled');
                        }
                        pay_info.classList.remove('d-none');
                        info_loader.classList.add('d-none');
                    };
                    xhr.send(data);
                }
            }
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const stripeButton = document.querySelector(".stripe-button-el");

                if (stripeButton) {
                    stripeButton.style.display = "none";
                }
            });
        </script>

</body>


</html>