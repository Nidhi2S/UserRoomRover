<?php
// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");
// Function to check if user is logged in as an admin
adminLogin();

// add images in carousel
if (isset($_POST['add_image'])) {

    $img_r =  uploadImage($_FILES['picture'], UPLOAD_IMAGE_PATH . CAROUSEL_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
        $values = [$img_r];
        $res = insert($q, $values, 's');
        echo $res;
    }
}

// get images of carousel 
if (isset($_POST['get_carousel'])) {
    $res = selectAll('carousel');
    while ($row = mysqli_fetch_assoc($res)) {
        $path = CAROUSEL_IMG_PATH . $row['image'];

        echo <<<data
                <div class="col-md-2 mb-3">
                    <div class="card text-bg-dark text-white">
                        <img src='$path' class="card-img">
                        <div class="card-img-overlay text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete$row[id]">
                        <i class="bi bi-trash3"></i> Delete
                        </button>
                        </div>
                 
                    </div>
                </div>

                

                <!-- Modal -->
                <div class="modal fade" id="delete$row[id]" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirm Deletion</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h3><i class="bi bi-x-circl text-danger mb-3"></i></h3>
                        <h5 class = "mb-3">Are your sure?</h5>
                        <h6 class = "text-body-tertiary">Do you really want to delete this record from the database? This action can not be undone. </h6>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick ="rem_image($row[id])" class="btn btn-danger"><i class="bi bi-trash3"></i>Delete</button>
                    </div>
                    </div>
                </div>
                </div>
               data;
    }
}

// remove carousel images
if (isset($_POST['rem_image'])) {
    $frm_data = filteration($_POST);

    $values = [intval($frm_data['rem_image'])];


    $pre_q = "SELECT * FROM `carousel` WHERE id = ?";
    $res = select($pre_q, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if (deleteImage($img['image'], CAROUSEL_FOLDER)) {
        $q = "DELETE FROM `carousel` WHERE id = ?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo 0;
    }
}
