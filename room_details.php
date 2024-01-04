<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?>- ROOM DETAILS</title>



</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>

    <?php
    if (!isset($_GET['id'])) {
        redirect("rooms.php");
    }

    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id` = ? AND `status` = ? AND `removed` = ?", [$data['id'], 1, 0], 'iii');
    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);

    ?>




    <div class="container">
        <div class="row">

            <div class="col-12 mb-4 my-5 px-4">
                <h2 class="fw-bold "><?php echo $room_data['name'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>

                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <?php

                        // get thumb nail of image

                        $room_img = ROOMS_IMG_PATH . "thumb_nail.png";
                        $img_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]'");
                        if (mysqli_num_rows($img_q) > 0) {
                            $active_class = "active";
                            while ($img_res = mysqli_fetch_assoc($img_q)) {
                                echo "<div class='carousel-item $active_class'>
                                    <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded'>
                                </div> ";
                                $active_class = "";
                            }

                            $room_img = ROOMS_IMG_PATH . $img_res['image'];
                        } else {
                            echo "  <div class='carousel-item active'>
                                        <img src='$room_img' class='d-block w-100'>
                                    </div>";
                        }

                        ?>

                        <div class="carousel-item">
                            <img src="..." class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="..." class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<price
                        <h4>₹ $room_data[price] per night</h6>
                        price;

                        echo <<<rating
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning "></i>
                            <i class="bi bi-star-fill text-warning "></i>
                            <i class="bi bi-star-fill text-warning "></i>
                            <i class="bi bi-star-fill text-warning "></i>
                            <i class="bi bi-star-fill text-warning "></i>
                        </div>
                        rating;

                        // get features of rooms
                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features`f
                         INNER JOIN `room_features`rfea ON f.id = rfea.features_id
                         WHERE `room_id` = '$room_data[id]'");

                        $features_data = "";
                        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                            $features_data .= "<span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>
                                $fea_row[name]
                            </span>";
                        }

                        echo <<<features
                        <div class=" mb-3">
                            <h6 class="mb-1">Features</h6>
                            $features_data
                        </div>
                        features;

                        // get facilities of rooms
                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities`f
                            INNER JOIN `room_facilities`rfac ON f.id = rfac.facilities_id
                            WHERE `room_id` = '$room_data[id]'");

                        $facilities_data = "";
                        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>
                                $fac_row[name]
                            </span>";
                        }
                        echo <<<facilities
                       <div class="facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            $facilities_data
                        </div>
                       facilities;

                        echo <<<guests
                       <div class="mb-4 ">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                $room_data[adult] Adults
                            </span>
                            <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                $room_data[children] Children
                                </span>
                        </div>
                       guests;

                        echo <<<area
                       <div class=" mb-3">
                            <h6 class="mb-1">Area</h6>
                            <span class='badge rounded-pill text-dark bg-light text-wrap '>
                                $room_data[area] sq ft.
                            </span>
                         
                        </div>
                       area;


                        // if site is shutdown 
                        if (!$settings_r['shutdown']) {
                            $login = 0;
                            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                                $login = 1;
                            }
                            echo <<<book
                                    <button onclick ='checkLoginToBook($login,$room_data[id])' class="btn w-100 text-white custom-bg shadow-none mb-1">Book Now</button>
                                    book;
                        }
                        ?>
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

</body>

</html>