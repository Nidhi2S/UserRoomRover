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
    <title>Admin Panel - New Bookings </title>
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
                <h3 class="mb-4">New Bookings </h3>

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
                                        <th scope="col">Booking Details</th>
                                        <th scope="col" class="text-center">Action</th>
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


    <!-- Assign ROOM no Modal   -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5">Assign Room </h5>
                    
                    </div>
                    <div class="modal-body">

                        <div class="mb-3 ">
                            <label class="form-label fw-bold">Room Number</label>
                            <input name="room_no" type="text" class="form-control shadow-none" required>

                            <span class="badge text-bg-light mb-3 text-wrap lh-base">
                                Note: Assign Room Number only when user has been arrived.
                            </span>
                        </div>

                        <input type="hidden" name="booking_id" >

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Script file -->
    <?php require("include/scripts.php"); ?>
    <script src="./scripts/new_bookings.js"></script>
</body>

</html>