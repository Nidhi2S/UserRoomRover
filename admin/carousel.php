<?php
require("include/essentials.php");
adminLogin();
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Carousel</title>
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
                <h3 class="mb-4">Carousel</h3>

                <!-- Carousel section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Images  </h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#carousel-s">
                                <i class="bi bi-person-plus"></i> Add
                            </button>
                        </div>

                        <!-- Display carousel -->
                        <div class="row" id="carousel-data">

                        </div>

                    </div>
                </div>

                <!-- Carousel Modal -->
                <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="carousel_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add image </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3 ">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input name="carousel_picture" id="carousel_picture_inp" type="file" class="form-control shadow-none" accept=".jpg, .png, .webp, .jpeg" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" onclick="" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>








    <!-- Script file -->
    <?php require("include/scripts.php"); ?>
    <script src="./scripts/carousel.js"></script>

</body>

</html>