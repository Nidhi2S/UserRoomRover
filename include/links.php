<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;500&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<link rel="stylesheet" href="./CSS/common.css">

<?php
session_start();
date_default_timezone_set('asia/Kolkata');

require("admin/include/db_config.php");
require("admin/include/essentials.php");

$contact_q = "SELECT * FROM `contact_details` WHERE id =?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));

$settings_q = "SELECT * FROM `settings` WHERE id =?";
$settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

if ($settings_r['shutdown']==1) {
    echo <<<alertbar
            <div class="bg-danger text-center p-2 fw-bold" >
            <i class="bi bi-exclamation-triangle-fill"></i> Bookings are temporary closed!
            </div>
            alertbar;
}

?>