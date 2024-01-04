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
    <title>Admin Panel - Features $ Facilities </title>
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
                <h3 class="mb-4">FEATURES & FACILITIES </h3>

                <!-- Feature section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <!-- Feature Section -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features </h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#feature-s">
                                <i class="bi bi-person-plus"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-md " style="height: 350px; overflow-y: scroll ">
                            <table class="table table-hover border">
                                <thead class=" table_head table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>


                                <tbody id="features-data">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- Facilities Section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <!-- Facilities Section -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities </h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#facility-s">
                                <i class="bi bi-person-plus w-75"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-md " style="height: 350px; overflow-y: scroll ">
                            <table class="table table-hover border">
                                <thead class="table_head table-dark" >
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Description</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>


                                <tbody id="facilities-data">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

               
            </div>
        </div>
    </div>


    <!-- Feature Modal   -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Feature </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3 ">
                            <label class="form-label fw-bold">Name</label>
                            <input name="feature_name" type="text" class="form-control shadow-none" required>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Facility Modal   -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="facility_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Facility Member </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3 ">
                            <label class="form-label fw-bold">Name</label>
                            <input name="facility_name" id="facility_name_inp" type="text" class="form-control shadow-none" required>
                        </div>

                        <div class="mb-3 ">
                            <label class="form-label fw-bold">Icon</label>
                            <input name="facility_icon" id="facility_icon_inp" type="file" class="form-control shadow-none" accept=".svg" required>
                        </div>

                        <div class="mb-3 ">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Script file -->
    <?php require("include/scripts.php"); ?>
    <script src="./scripts/features_facilities.js"></script>
</body>

</html>