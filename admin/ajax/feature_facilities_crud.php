<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");
// Function to check if user is logged in as an admin
adminLogin();

// To add features
if (isset($_POST['add_feature'])) {
    $frm_data = filteration($_POST);
    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $values = [$frm_data['name']];
    $res = insert($q, $values, 's');
    echo $res;
}

// To get feauitures
if (isset($_POST['get_features'])) {
    $res = selectAll('features');
    $i = 1;
    while ($row = mysqli_fetch_assoc($res)) {

        echo <<<data
                <tr>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td class="text-center">
                    <button type="button" class="btn w-25 btn-danger" data-bs-toggle="modal" data-bs-target="#delete$row[id]">
                    <i class="bi bi-trash pe-2"></i> Delete
                    </button>
                    </td>
                 
                </tr>
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
                        <h6 class = "text-body-tertiary">Do you realy want to delete this record from the database? This action can not be undone. </h6>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick ="rem_feature($row[id])" class="btn btn-danger"><i class="bi bi-trash3"></i>Delete</button>
                    </div>
                    </div>
                </div>
                </div>
               data;
        $i++;
    }
}

// To remove features
if (isset($_POST['rem_feature'])) {
    $frm_data = filteration($_POST);
    $values = [intval($frm_data['rem_feature'])];
    $check_q = select("SELECT * from `room_features` where features_id = ?", [intval($frm_data['rem_feature'])], 'i');
    if (mysqli_num_rows($check_q) == 0) {
        $q = "DELETE FROM `features` WHERE id = ?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo "room_added";
    }
}

// To add facilities
if (isset($_POST['add_facility'])) {
    $frm_data = filteration($_POST);
    $img_r =  uploadSVGImage($_FILES['icon'], UPLOAD_IMAGE_PATH . FACILITIES_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `facilities`( `icon`, `name`, `description`) VALUES (?,?,?)";
        $values = [$img_r, $frm_data['name'], $frm_data['desc']];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}

// To get facilities
if (isset($_POST['get_facilities'])) {
    $res = selectAll('facilities');
    $i = 1;
    $path = FACILITIES_IMG_PATH;
    while ($row = mysqli_fetch_assoc($res)) {

        echo <<<data
                <tr class= "align-middle">
                    <td>$i</td>
                    <td><img src="$path$row[icon]" width=40px alt=""></td>
                    <td class = "">$row[name]</td>
                    <td class = "w-50">$row[description]</td>
                    <td class="text-center">
                    <button type="button" class="btn w-50 btn-danger" data-bs-toggle="modal" data-bs-target="#delete$row[id]">
                    <i class="bi bi-trash pe-2"></i> Delete
                    </button>
                    </td>
                 
                </tr>
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
                        <h6 class = "text-body-tertiary">Do you realy want to delete this record from the database? This action can not be undone. </h6>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick ="rem_facility($row[id])" class="btn btn-danger"><i class="bi bi-trash3"></i>Delete</button>
                    </div>
                    </div>
                </div>
                </div>
               data;
        $i++;
    }
}

// To remove facilities
if (isset($_POST['rem_facility'])) {
    $frm_data = filteration($_POST);
    $values = [intval($frm_data['rem_facility'])];
    $pre_q = "SELECT * FROM `facilities` WHERE id = ?";
    $res = select($pre_q, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if (deleteImage($img['icon'], FACILITIES_FOLDER)) {
        $q = "DELETE FROM `facilities` WHERE id = ?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo 0;
    }
}
