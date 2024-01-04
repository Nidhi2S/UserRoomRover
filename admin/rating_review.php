<?php
require("include/essentials.php");
require("./include/db_config.php");
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen` = ?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen` = ? WHERE id = ?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('error', 'Operation failed');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All data deleted!');
        } else {
            alert('error', 'Operation failed: ' . mysqli_error($con));
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE id = ?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deletd!');
        } else {
            alert('error', 'Operation failed');
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ratings & Reviews</title>
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
                <h3 class="mb-4">Ratings & Reviews</h3>

                <!-- Carousel section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none">
                                <i class="bi bi-check-all"></i> Mark all read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none">
                                <i class="bi bi-trash3-fill"> </i>Delete all
                            </a>

                        </div>
                        <div class="table-responsive-md ">
                            <table class="table table-hover border">

                                <thead class="sticky-top table_head table-dark">
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col" >Rating</th>
                                        <th scope="col" width="30%" >Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" >Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    // fetching room data and review data to show the reviews and ratings
                                    $q = "SELECT rr.*, uc.name AS uname, r.name AS rname FROM `rating_review` rr 
                                    INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                                    INNER JOIN `rooms` r ON rr.room_id = r.id
                                    ORDER BY `id` DESC";
                              
                                    $data = mysqli_query($con, $q);

                                    if ($data) {
                                        echo "hii succesful";
                                    } else {
                                        echo "byy";
                                    }


                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        
                                        $date = date('d-m-Y',strtotime($row['date&time']));
                                        // var_dump($row['date&time']);
                                        // var_dump("hiihjgdcud");
                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[id]' class = 'btn w-100 btn-sm rounded-pill btn-primary'>Mark as read</a><br>";
                                        }
                                        $seen .= "<a href='?del=$row[id]' class = 'btn w-100 btn-sm rounded-pill btn-danger mt-2'>Delete</a>";

                                        echo <<<query
                                        <tr class = "text-center" >
                                            <td>$i</td>
                                            <td>$row[rname]</td>
                                            <td>$row[uname]</td>
                                            <td>$row[rating]</td>
                                            <td>$row[review]</td>
                                            <td>$date</td> 
                                            <td>$seen</td>                                                                                  
                                        </tr>
                                     query;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
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

</body>

</html>