<?php
require("include/essentials.php");
require("./include/db_config.php");
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Refund Bookings </title>
    <link rel="stylesheet" href="./CSS/user_queries.css">

    <?php
    require("include/links.php");
    ?>

</head>

<body class="bg-light">

    <!-- Header amd side bar file -->
    <?php require("include/header.php") ?>

    <div class="container-fluid mt-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden ">
                <h3 class="mb-4">Refund Bookings </h3>

                <!-- User section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <!-- Feature Section -->
                        <div class="text-end mb-4">
                            <input oninput="get_bookings(this.value)" type="text" class="form-control shadow-none w-25 ms-auto" placeholder="search">
                        </div>

                        <div class="table-responsive ">
                            <table class="table table-hover border " style="min-width: 1200px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Refund Amount </th>
                                        <th scope="col" class='text-center'>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Script file -->
    <?php require("include/scripts.php"); ?>
    <script src="./scripts/refund_bookings.js"></script>
</body>

</html>