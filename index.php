<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?> - Home</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
        .availability-form {
            margin-top: -150px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width:575px) {
            .availability-form {
                margin-top: -125px;
                padding: 0 35;
                ;
            }

        }
    </style>
</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>

    <!-- Carousel Section -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper main_slider">

                <?php
                $res = selectAll('carousel');
                while ($row = mysqli_fetch_assoc($res)) {
                    $path = CAROUSEL_IMG_PATH;
                    echo <<<data
                      
                       <div class="swiper-slide">
                            <img class="w-100 d-block swiper_img" src=" $path$row[image]" />
                        </div>
                       data;
                }

                ?>
            </div>
            <!-- <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div> -->
        </div>
    </div>
    <!-- Check Avaialbility form-->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">
                    Check Booking Availability
                </h5>
                <form action="">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label " style="font-weight: 500;">Check-in</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label " style="font-weight: 500;">Check-out</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label " style="font-weight: 500;">Adult</label>
                            <select class="form-select shadow-none">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label " style="font-weight: 500;">Children</label>
                            <select class="form-select shadow-none">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-1 mb-lg-3">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Our Rooms -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">
        OUR ROOMS
    </h2>
    <div class="container">
        <div class="row">

            <?php
            $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `removed` = ? ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');
            while ($room_data = mysqli_fetch_assoc($room_res)) {

                // get feature of rooms
                $fea_q = mysqli_query($con, "SELECT f.name FROM `features`f
                INNER JOIN `room_features`rfea ON f.id = rfea.features_id
                WHERE `room_id` = '$room_data[id]'");

                $features_data = "";
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>
                        $fea_row[name]
                    </span>";
                }
                // get feature of rooms
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities`f
                INNER JOIN `room_facilities`rfac ON f.id = rfac.facilities_id
                WHERE `room_id` = '$room_data[id]'");

                $facilities_data = "";
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>
                        $fac_row[name]
                    </span>";
                }

                // get thumb nail of image
                $room_thumb = ROOMS_IMG_PATH . "thumb_nail.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]' and `thumb` = '1'");
                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }
                // if site is not shutdown
                $book_btn = "";
                // if site is shutdown 
                if (!$settings_r['shutdown']) {
                    $login = 0;
                    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                        $login = 1;
                    }
                    $book_btn = "<button onclick ='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                }
                //print cards
                echo <<< data
                    <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="$room_thumb" class="card-img-top">
                        <div class="card-body">
                            <h5> $room_data[name]</h5>
                            <h6 class="mb-4">₹$room_data[price] per night</h6>
                            <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span>
                                $features_data
                                </span>
                               
                            </div>
                            <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span>
                                $facilities_data
                                </span>
                                
                            </div>
                            <div class="guests mb-4">
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                $room_data[adult]  Adults
                                </span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                $room_data[children]  Children
                                </span>
                            </div>

                            <div class="rating mb-4">
                                <h6 class="mb-1">Rating</h6>
                                <span class="span rounded-pill bg-light">
                                    <i class="bi bi-star-fill text-warning "></i>
                                    <i class="bi bi-star-fill text-warning "></i>
                                    <i class="bi bi-star-fill text-warning "></i>
                                    <i class="bi bi-star-fill text-warning "></i>
                                </span>

                            </div>
                            <div class="d-flex justify-content-evenly mb-2">
                             $book_btn
                                <a href="room_details.php?id=$room_data[id]" class="btn btn-sm  btn-outline-dark shadow-none">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                data;
            }
            ?>

            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More rooms >>>
                </a>
            </div>
            <!-- Our Facilities -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">
                OUR FACILITIES
            </h2>

            <div class="container">
                <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">

                    <?php
                    $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY id DESC LIMIT 5");
                    $path = FACILITIES_IMG_PATH;
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo <<<data

                    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                        <img src="$path$row[icon]" width="60px" alt="">
                        <h5 class="mt-3">$row[name]</h5>
                    </div>
                data;
                    }
                    ?>
                    <div class="col-lg-12 text-center mt-5">
                        <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities
                            >>></a>

                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TESTIMONIALS</h2>
            <div class="container mt-5">
                <div class="swiper swiper-testimonial">
                    <div class="swiper-wrapper mb-5">
                        <div class="swiper-slide bg-white p-4">
                            <div class="profile d-flex align-items-center mb-3">
                                <img src="" width="30px" alt=".">
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
                            </div>
                        </div>
                        <div class="swiper-slide bg-white p-4">
                            <div class="profile d-flex align-items-center mb-3">
                                <img src="images/features/wifi.svg" width="30px" alt="">
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
                            </div>
                        </div>
                        <div class="swiper-slide bg-white p-4">
                            <div class="profile d-flex align-items-center mb-3">
                                <img src="images/features/wifi.svg" width="30px" alt="">
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
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="col-lg-12 text-center mt-5">
                    <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More
                        >>></a>
                </div>
            </div>

            <!-- Reach us -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                        <iframe class="w-100 rounded" src="<?php echo $contact_r['iframe'] ?>" height="350" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="bg-white p-4 rounded mb-4">
                            <h5> Call us</h5>
                            <a href="tel: <?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                            </a>
                            <br>
                            <?php
                            if ($contact_r['pn2'] != '') {
                                echo <<<data
                                <a href="tel: +$contact_r[pn2]" class="d-inline-block  text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                                </a>
                            data;
                            }

                            ?>

                        </div>

                        <div class="bg-white p-4 rounded mb-4">
                            <h5> Follow us</h5>
                            <!-- Twitter -->
                            <?php
                            if ($contact_r['tw'] != '') {
                                echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block mb-3 ">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-twitter me-1"></i> $contact_r[tw] 
                                </span>
                            </a>
                            data;
                            }

                            ?>

                            <br>
                            <!-- Facebook -->
                            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3 ">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-facebook me-1"></i> <?php echo $contact_r['fb'] ?>
                                </span>
                            </a>
                            <br>
                            <!-- Instgram -->
                            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block  ">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-instagram me-1"></i> <?php echo $contact_r['insta'] ?>
                                </span>
                            </a>

                        </div>
                    </div>
                </div>


            </div>

            <!-- PASSWORD RESET MODAL -->
            <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" id="recovery-form">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5"><i class="bi bi-shield-lock fs-3 me-2"></i>Set up new Password</h5>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control shadow-none" name="pass" required>
                                    <input type="hidden" name="email" required>
                                    <input type="hidden" name="token" required>
                                </div>


                                <div class="mb-2 text-end">
                                    <button type="button" class="btn text-secondary shadow-none " data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-dark text-decoration-none shadow-none">SUBMIT</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>

            <!-- Footer File -->
            <?php require("include/footer.php"); ?>
        </div>

    </div>

    <?php
    if (isset($_GET['account_recovery'])) {
        $data = filteration($_GET);
        $t_date = date('Y-m-d');
        $query = select("SELECT * FROM `user_cred` WHERE `email`= ? AND `token`= ? AND `token_expire`= ? LIMIT 1 ", [$data['email'], $data['token'], $t_date], 'sss');

        // Check the number of rows in the result set
        if (mysqli_num_rows($query) == 1) {
            echo <<<showModal
                   <script>
                       var myModal = document.getElementById('recoveryModal');
                       myModal.querySelector("input[name='email']").value = '$data[email]';
                       myModal.querySelector("input[name='token']").value = '$data[token]';
                       var modal = bootstrap.Modal.getOrCreateInstance(myModal)
                       modal.show();
                   </script>                   
                   showModal;
        } else {
            echo alert("error", "invalid or expired link");
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
        });

        var swiper = new Swiper(".swiper-testimonial", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },

            }
        });

        // USER FORGOT PASSWORD
        let recovery_form = document.getElementById('recovery-form');
        recovery_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('email', recovery_form.elements['email'].value);
            data.append('token', recovery_form.elements['token'].value);
            data.append('pass', recovery_form.elements['pass'].value);
            data.append('recover_user', "");

            var myModal = document.getElementById('recoveryModal');
            var modal = bootstrap.Modal.getInstance(myModal)
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);
            // xhr.onprogress = function(){
            //     alert('success','link is on process');
            // }
            xhr.onload = function() {
                if (this.responseText == 'failed') {
                    alert('error', 'Account reset failed ');
                } else {
                    alert('success', 'Account reset successful ');
                    recovery_form.reset();
                }
            }
            xhr.send(data);
        });
    </script>

</body>

</html>