<?php
// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");
// Function to check if user is logged in as an admin
adminLogin();

// Check if the request is to get general settings
if (isset($_POST['get_general'])) {
    $q = "SELECT * FROM `settings` WHERE `id`=?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}

//  to update general settings
if (isset($_POST['upd_general'])) {
    //to filter the form data
    $frm_data = filteration($_POST);
    $q = "UPDATE `settings` SET `site_title`= ? ,`site_about`= ? WHERE `id`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
    $res = update($q, $values, "ssi");
    echo $res;
}

//  update shutdown feature whhile we clicked on button
if (isset($_POST['upd_shutdown'])) {
    $frm_data = ($_POST['upd_shutdown'] == 0) ? 1 : 0;
    $q = "UPDATE `settings` SET `shutdown`= ? WHERE `id`=?";
    $values = [$frm_data, 1];
    $res = update($q, $values, "ii");
    echo $res;
}
//  to get contact details
if (isset($_POST['get_contacts'])) {
    $q = "SELECT * FROM `contact_details` WHERE `id`=?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}

// to update contact details
if (isset($_POST['upd_contacts'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `contact_details` SET`address`= ? ,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`insta`=?,`tw`=?,`iframe`=? WHERE `id` =?";
    $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'], $frm_data['email'], $frm_data['fb'], $frm_data['insta'], $frm_data['tw'], $frm_data['iframe'], 1];
    $res = update($q, $values, "sssssssssi");
    echo $res;
}

// add member in mangement team 
if (isset($_POST['add_member'])) {
    $frm_data = filteration($_POST);
    $img_r =  uploadImage($_FILES['picture'], UPLOAD_IMAGE_PATH . ABOUT_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
        $values = [$frm_data['name'], $img_r];
        $res = insert($q, $values, 'ss');
        echo $res;
    }
}

// fetched data of members
if (isset($_POST['get_members'])) {
    $res = selectAll('team_details');
    while ($row = mysqli_fetch_assoc($res)) {
        $path = ABOUT_IMG . $row['picture'];
        echo <<<data
                <div class="col-md-2 mb-3">
                    <div class="card text-bg-dark text-white">
                        <img src='$path' class="card-img">
                        <div class="card-img-overlay text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete$row[id]">
                        <i class="bi bi-trash3"></i> Delete
                        </button>
                        </div>
                        <p class="card-text text-center px-3 py-2"><small></small>$row[name]</p>
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
                        <h6 class = "text-body-tertiary">Do you realy want to delete this record from the database? This action can not be undone. </h6>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick ="rem_member($row[id])" class="btn btn-danger"><i class="bi bi-trash3"></i>Delete</button>
                    </div>
                    </div>
                </div>
                </div>
               data;
    }
}

// Remove members 
if (isset($_POST['rem_member'])) {
    $frm_data = filteration($_POST);
  
    $values = [intval($frm_data['rem_member'])];


    $pre_q = "SELECT * FROM `team_details` WHERE id = ?";
    $res = select($pre_q, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if (deleteImage($img['picture'], ABOUT_FOLDER)) {
        $q = "DELETE FROM `team_details` WHERE id = ?";
        $res = delete($q, $values, 'i');
        echo 1;
    } else {
        echo 0;
    }
}

