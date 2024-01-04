<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <?php require("include/links.php") ?>
    <title><?php echo $settings_r['site_title'] ?>- PROFILE</title>

</head>

<body class="bg-light">
    <!-- Header file -->
    <?php require("include/header.php");
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect("rooms.php");
    }

    $query = "SELECT *FROM `user_cred` WHERE id =$_SESSION[uId] LIMIT 1";
    $u_exist = mysqli_query($con, $query);
    if (mysqli_num_rows($u_exist) == 0) {
        header('location:index.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exist);

    ?>

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold "> PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Profile</a>

                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form" method="post">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4  mb-3 ">
                                <label class="form-label">Name</label>
                                <input name="name" value="<?php echo $u_fetch['name']; ?>" type="text" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4  mb-3 ">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" value="<?php echo $u_fetch['phonenum']; ?>" type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label ">Date of birth</label>
                                <input name="dob" value="<?php echo $u_fetch['dob']; ?>" type="date" class="form-control shadow-none">
                            </div>
                            <div class="col-md-4  mb-4 ">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" value="<?php echo $u_fetch['pincode']; ?>" type="number" class="form-control shadow-none">
                            </div>

                            <div class="col-md-8  mb-3 ">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1"><?php echo $u_fetch['address']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-8 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form" method="post">
                        <h5 class="mb-3 fw-bold"> Picture </h5>
                        <img src="<?php echo USERS_IMG_PATH . $u_fetch['profile'] ?>" class=" rounded-circle img-fluid">
                        <label class="form-label "></label>
                        <input name="profile" type="file" class="form-control shadow-none mb-4" accept=".jpg, .png, .jpeg, .webp">
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form" method="post">
                        <h5 class="mb-3 fw-bold"> Change Password </h5>
                        <!-- <div class="row">
                            <div class="col-md-6  mb-3 ">
                                <label class="form-label">New Password</label>
                                <input name="new_pass" type="password" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6  mb-4 ">
                                <label class="form-label">Confirm Password</label>
                                <input name="confirm_pass" type="password" class="form-control shadow-none">
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-6 mb-3 position-relative">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input name="new_pass" type="password" class="form-control shadow-none" id="newPassInput">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" onclick="togglePassword('newPassInput')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 position-relative">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input name="confirm_pass" type="password" class="form-control shadow-none" id="confirmPassInput">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" onclick="togglePassword('confirmPassInput')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

        </div>



        <!-- Footer File -->
        <?php require("include/footer.php"); ?>

        <?php
        if (isset($_GET['cancel_status'])) {
            alert('success', 'Booking cancelled');
        }
        ?>
</body>

<script>
    // sending data of user
    let info_form = document.getElementById('info-form');
    info_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('info-form', '');
        data.append('name', info_form.elements['name'].value);
        data.append('phonenum', info_form.elements['phonenum'].value);
        data.append('dob', info_form.elements['dob'].value);
        data.append('pincode', info_form.elements['pincode'].value);
        data.append('address', info_form.elements['address'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.status === 200) {
                if (this.responseText == 'phone_already') {
                    alert('error', 'Phone number already exists!');
                } else if (this.responseText == '0') {
                    alert('error', 'No changes made');
                } else {
                    alert('success', 'Changes saved!');
                }
            } else {
                alert('error', 'Error during the request.');
            }
        }

        xhr.onerror = function() {
            alert('error', 'Error during the request.');
        }

        xhr.send(data);
    });

    // sending image of user
    let profile_form = document.getElementById('profile-form');
    profile_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('profile_form', ''); // Omit if not needed
        data.append('profile', profile_form.elements['profile'].files[0]);


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.status === 200) {
                if (this.responseText == 'inv_img') {
                    alert('error', 'only webp,png,jpg images are allowed');
                } else if (this.responseText == 'upd_failed') {
                    alert('error', 'image updload failed');
                } else if (this.responseText == 0) {
                    alert('error', 'updation failed');
                } else {
                    alert('success', 'Changes saved!');
                }

            } else {
                window.location.href = window.location.pathname;
            }
        }

        xhr.onerror = function() {
            alert('error', 'Error during the request.');
        }

        xhr.send(data);
    });

    // sending password of image

    let pass_form = document.getElementById('pass-form');

    pass_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let new_pass = pass_form.elements['new_pass'].value;
        let confirm_pass = pass_form.elements['confirm_pass'].value;

        if (new_pass != confirm_pass) {
            alert('error', "Passwords do not match!");
            return false;
        }
        let data = new FormData();
        data.append('pass_form', '');
        data.append('new_pass', new_pass);
        data.append('confirm_pass', confirm_pass);


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.status === 200) {
                if (this.responseText == 'mismatch') {
                    alert('error', "password do not match !");
                } else if (this.responseText == 'upd_failed') {
                    alert('error', 'image updload failed');
                } else if (this.responseText == 0) {
                    alert('error', 'updation failed');
                } else {
                    alert('success', 'Changes saved!');
                    pass_form.reset();
                }

            }
        }

        xhr.onerror = function() {
            alert('error', 'Error during the request.');
        }

        xhr.send(data);
    });
</script>

<!-- FOR EYE BUTTON -->
<script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const toggleButton = passwordInput.nextElementSibling;

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            toggleButton.innerHTML = '<i class="bi bi-eye"></i>';
        }
    }
</script>

</html>