<?php
var_dump($_FILES);
if (isset($_POST)) {
    $base_directory = $_SERVER['DOCUMENT_ROOT'] . "/images/about/";
    var_dump($base_directory);

    // Create the user-specific directory if it doesn't exist
    $user_directory = $base_directory . $_POST['member_name'] . "/";

    // Check if file exists or not
    if (!file_exists($user_directory)) {
        mkdir($user_directory, 0755, true);
    }

    $file_extension = pathinfo($_FILES["member_picture"]["name"], PATHINFO_EXTENSION);

    // Image Naming
    $date = date("m-d-y_G-i-s", time());
    $randomVal = rand();
    pathinfo($_FILES["member_picture"]["name"])['filename'];
    $image_name = pathinfo($_FILES["member_picture"]["name"])['filename'] . "_" . $randomVal . "_" . $date;


    $new_file_name = $image_name . "." . $file_extension;
    // Specify the complete path to store the file
    $target_upload_path = $user_directory . $new_file_name;
    $temp = $files["displayImage"]["tmp_name"];

    move_uploaded_file($temp, $target_upload_path);
}
