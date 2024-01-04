<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?> - ABOUT</title>
    <style>
        .box {
            border-top: 4px solid #000;
        }

        .box:hover {
            border-top: 4px solid teal;
            cursor: pointer;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            Suscipit vero porro eaque, <br> sed quasi exercitationem iusto
            distinctio quisquam inventore quaerat?
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">

            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Lorem ipsum dolor sit</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Illo repellendus eveniet perspiciatis corporis maiores excepturi at.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Illo repellendus eveniet perspiciatis corporis maiores excepturi at.
                </p>
            </div>

            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/about/1.jpg" class="w-100">
            </div>

        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px">
                    <h4 class="mt-3">100+Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow  p-4 text-center box">
                    <img src="images/about/customers.svg" width="70px">
                    <h4 class="mt-3">200+Customers</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow   p-4 text-center box">
                    <img src="images/about/ratings.svg" width="70px">
                    <h4 class="mt-3">150+Reviews</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow  p-4 text-center box">
                    <img src="images/about/staffs.svg" width="70px">
                    <h4 class="mt-3">200+Staffs</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>

    <div class="container px-4">
        <div class="swiper mySwiper ">

            <div class="swiper-wrapper mb-5">
                <?php
                $about_r = selectAll('team_details');
                $path = ABOUT_IMG;
                while ($row = mysqli_fetch_assoc($about_r)) {
                    echo <<<data
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img style"width:450px height:500px" src="$path$row[picture]" class="w-100">
                    <h5 class="mt-2">$row[name]</h5>
                </div> 
                data;
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

    <!-- Footer File -->
    <?php require("include/footer.php"); ?>
    
    </div>



    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
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
    </script>
</body>

</html>