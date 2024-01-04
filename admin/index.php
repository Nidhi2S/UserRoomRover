<?php

require("include/db_config.php");


require("include/essentials.php");

session_start();

if (!(isset($_SESSION['adminLogin']) && ($_SESSION['adminLogin'] == true))) {
    redirect('dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require("include/links.php") ?>
    <style>
        div.login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;

        }
    </style>
</head>

<body class="bg-light">

    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form action="" method="POST">
            <h4 class="bg-dark text-white py-4">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['login'])) {
        $frm_data = filteration($_POST);
        $query = "SELECT * FROM `admin_crud` WHERE `admin_name`=? AND `admin_pass` =?";
        $values = [$frm_data['admin_name'], $frm_data['admin_pass']];

        $res =  select($query, $values, "ss");
        if ($res->num_rows == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['id'];
            redirect('dashboard.php');
        } else {
            alert('erroe', 'Login failed - Invalid Creditionals!');
        }
    }

    ?>
    <?php require("include/scripts.php") ?>


</body>

</html>