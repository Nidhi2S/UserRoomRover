<?php // require("./links.php") 
?>


<nav id="nav-bar" class="navbar navbar-expand-lg bg-body-tertiary bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">

    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"> <?php echo $settings_r['site_title'] ?></a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-5">
                <li class="nav-item">
                    <a class="nav-link me-5" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-5 " href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-5" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-5" href="contact.php">Contact us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-5" href="about.php">About</a>
                </li>

            </ul>
            <div class="d-flex align-items-center" role="search">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                    $path = USERS_IMG_PATH;

                    echo <<<data
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <img src="$path$_SESSION[uPic]" style="height: 25px; width: 25px;" class="me-1" alt=".">
                            $_SESSION[uName]
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    data;
                } else {
                    echo <<<data
                        <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button><div class="d-flex align-items-center" role="search">
                        <button type="button" class="btn btn-outline-dark shadow-none " data-bs-toggle="modal" data-bs-target="#registerModal" >
                            Register
                            </button>
                        </div>
                    data;
                }
                ?>

            </div>

        </div>
    </div>
</nav>

<!--LOGIN Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="login-form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"><i class="bi bi-person-circle fs-3 me-2"></i>User Login</h1>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email/Mobile</label>
                        <input type="text" class="form-control shadow-none" name="email_mob" required>
                    </div>
                    <!-- <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control shadow-none" name="pass" required>
                    </div> -->

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none" name="pass" id="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-fill" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-dark shadow-none">LOGIN</button>
                        <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0 " data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">
                            Forgot Password?
                        </button>
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>

<!-- REGISTER Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="register-form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        <i class="bi bi-person-lines-fill fs-3 me-2"></i>
                        User Registration
                    </h1>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge text-bg-light mb-3 text-wrap lh-base">
                        Note: Your deatails must match with your ID (Aadhaar card, passport,driving license, etc. )
                        that will be require during check-in.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3 ">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label ">Email</label>
                                <input name="email" type="email" class="form-control shadow-none">
                            </div>

                            <div class="col-md-6 ps-0 mb-3 ">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label ">Picture</label>
                                <input name="profile" type="file" class="form-control shadow-none" accept=".jpg, .png, .jpeg, .webp">
                            </div>

                            <div class="col-md-12 ps-0 mb-3 ">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1"></textarea>
                            </div>

                            <div class="col-md-6 ps-0 mb-3 ">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label ">Date of birth</label>
                                <input name="dob" type="date" class="form-control shadow-none">
                            </div>
                            <!-- <div class="col-md-6 ps-0 mb-3 ">
                                <label class="form-label">Password</label>
                                <input name="pass" type="password" class="form-control shadow-none" >
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label ">Confirm Password</label>
                                <input name="cpass" type="password" class="form-control shadow-none" >
                            </div> -->

                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input name="pass" type="password" class="form-control shadow-none" id="passwordInput">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('passwordInput', 'eyeIconPassword')">
                                        <i class="bi bi-eye-fill" id="eyeIconPassword"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input name="cpass" type="password" class="form-control shadow-none" id="confirmPasswordInput">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('confirmPasswordInput', 'eyeIconConfirmPassword')">
                                        <i class="bi bi-eye-fill" id="eyeIconConfirmPassword"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="text-center my-1">
                        <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>

<!-- FORGOT MODAL -->
<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="forgot-form">
                <div class="modal-header">
                    <h5 class="modal-title fs-5"><i class="bi bi-person-circle fs-3 me-2"></i>Forgot Password</h5>
                </div>
                <div class="modal-body">
                    <span class="badge text-bg-light mb-3 text-wrap lh-base">
                        Note: Your link will be send to your registred mail to reset your password .
                    </span>

                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control shadow-none" name="email" required>
                    </div>


                    <div class="mb-2 text-end">
                        <button type="button" class="btn text-secondary shadow-none p-0" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                            CANCEL
                        </button>
                        <button type="submit" class="btn btn-dark text-decoration-none shadow-none">SEND LINK</button>
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>


<!-- <script>
    // Hide the modal when Cancel button is clicked
    $('#cancelButton').on('click', function() {
        $('#forgotModal').modal('hide');
    });

    // prevent pause screen
    let body = document.querySelector("body");
    body.style.removeProperty("overflow");
    body.style.removeProperty("padding-right");
    let modalBackdrop = document.querySelector(".modal-backdrop");
    modalBackdrop.classList.remove("show");

    forgetCloseBtn = document.querySelector(".forgetClose");
    forgetCloseBtn.addEventListener("click", () => {
        document.querySelector(".forgot-form").style.display = "none";
    })
</script> -->