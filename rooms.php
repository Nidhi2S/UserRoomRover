<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?> - ROOMS</title>


</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>

    <div class="container mt-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-0 ">
                    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                        <div class="container-fluid flex-lg-column align-items-stretch">
                            <h4 mt-2>FILTERS</h4>
                            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>
                                    <label class="form-label ">Check-in</label>
                                    <input type="date" class="form-control shadow-none mb-3">
                                    <label class="form-label ">Check-out</label>
                                    <input type="date" class="form-control shadow-none">
                                </div>
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
                                    <div class="mb-2">
                                        <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                        <label class="form-check-label" for="f1">Facility one</label>
                                    </div>

                                    <div class="mb-2">
                                        <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                        <label class="form-check-label" for="f2">Facility two</label>
                                    </div>

                                    <div class="mb-2">
                                        <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                        <label class="form-check-label" for="f3">Facility three</label>
                                    </div>

                                </div>
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">GUESTS</h5>
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <label class="form-label ">Adults</label>
                                            <input type="number" class="form-control shadow-none">
                                        </div>
                                        <div>
                                            <label class="form-label ">Children</label>
                                            <input type="number" class="form-control shadow-none">
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </nav>

                </div>


                <div class="col-lg-9 col-md-12 px-4">
                    <?php

                    $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `removed` = ? ORDER BY `id` DESC", [1, 0], 'ii');
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

                            $book_btn = "<button onclick ='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
                        }
                        //print cards
                        echo <<< data
                        <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                <img src="$room_thumb" class="img-fluid rounded">
                            </div>
                            <div class="col-md-5 px-lg-3 px-0">
                                <h5 class="mb-3">$room_data[name]</h5>
                                <div class="features mb-3">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                                <div class="facilities mb-3">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                                <div class="guests ">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                        $room_data[adult] Adults
                                    </span>
                                    <span class="badge rounded-pill text-dark bg-light text-wrap ">
                                        $room_data[children] Children
                                    </span>

                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <h6 class="mb-4">₹ $room_data[price] per night</h6>
                                    $book_btn
                                <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                                
                            </div>
                            </div>
                        </div>
                        data;
                    }
                    ?>
                </div>

            </div>
        </div>
    <!-- Footer File -->
    <?php require("include/footer.php"); ?>
    </div>


</body>

</html>