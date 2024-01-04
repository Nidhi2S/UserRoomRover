<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
            <p><?php echo $settings_r['site_about'] ?></p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-2">Follow us</h5>
            <?php
            if ($contact_r['tw'] != '') {
                echo <<<code
                <a href="$contact_r[tw]" class="d-inline-block mb-2 text-dark text-decoration-none">
                    <i class="bi bi-twitter me-1"></i> Twitter
                </a>
                code;
            }
            ?>
            <br>
            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-2 text-dark text-decoration-none">
                <i class="bi bi-facebook me-1"></i> Facebook
            </a><br>
            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i> Instagram
            </a>
        </div>
    </div>
</div>
</div>

<h6 class="text-center bg-dark w-100 text-white p-3 m-0">Designed and Developed by ONE & ONLY HAHAHA
</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script>
    // ALERT
    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
           <div class="alert ${bs_class} alert-dismissible fade show " role="alert">
                <strong class="me-3 ">${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        if (position == 'body') {
            document.body.append(element);
            element.classList.add('custom-alert');

        } else {
            document.getElementById(position).appendChild(element);
        }
        // document.body.append(element);
        setTimeout(remAlert, 5000);
        console.log(type + ': ' + msg);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let a_tags = navbar.getElementsByTagName('a');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];
            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }
    }
    // USER REGISTRATION
    let register_form = document.getElementById('register-form');
    register_form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validation
        if (!validateForm()) {
            return;
        }

        let data = new FormData();
        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phonenum', register_form.elements['phonenum'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('address', register_form.elements['address'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('cpass', register_form.elements['cpass'].value);
        data.append('register', '');
        var modalBackdrop = document.querySelector(".modal-backdrop");
        modalBackdrop.classList.remove("fade");
        modalBackdrop.classList.remove("show");
        modalBackdrop.classList.remove("modal-backdrop");
        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function() {
            if (this.responseText == 'password_mismatch') {
                alert('error', 'password mismatch!');
            } else if (this.responseText == 'email_already') {
                alert('error', 'email already exists');
            } else if (this.responseText == 'phone_already') {
                alert('error', 'phone number already exists!');
            } else if (this.responseText == 'inv_img') {
                alert('error', 'only webp,png,jpg images are allowed');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'image updload failed');
            } else if (this.responseText == 'mail_failed') {
                alert('error', 'failed to send confirmation mail!! SERVER DOWN ');
            } else if (this.responseText == 'ins_failed') {
                alert('error', 'Registration failed ');
            } else {
                alert('success', 'Registred successfully,Confirmation mail sent to your email');
                register_form.reset();
            }


        }

        xhr.send(data);

    });

    // USER LOGIN
    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('email_mob', login_form.elements['email_mob'].value);
        data.append('pass', login_form.elements['pass'].value);
        data.append('login', "");


        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function() {
            if (this.responseText == 'inv_email_mob') {
                alert('error', ' Inavlid email or mobile No.!');
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email is not verified ! ');
            } else if (this.responseText == 'inactive') {
                alert('error', 'Account Suspended!,Please conatct with Admin ');
            } else if (this.responseText == 'invalid_pass') {
                alert('error', 'Please enter valid password');
            } else {
                let fileurl = window.location.href.split('/').pop().split('?').shift();
                if (fileurl = 'room_details.php') {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.pathname;
                }
            }
        }
        xhr.send(data);
    });

    // USER FORGOT PASSWORD
    let forgot_form = document.getElementById('forgot-form');

    forgot_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('email', forgot_form.elements['email'].value);
        data.append('forgot_pass', "");

        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        // xhr.onprogress = function(){
        //     alert('success','link is on process');
        // }
        xhr.onload = function() {
            if (this.responseText == 'inv_email') {
                alert('error', ' Inavlid email !');
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email is not verified Please conatct with admin! ');
            } else if (this.responseText == 'inactive') {
                alert('error', 'Account Suspended!,Please conatct with Admin ');
            } else if (this.responseText == 'mail_failed') {
                alert('error', 'Can not send email');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'Account recovery failed ');
            } else {
                alert('success', 'Reset link sent to your email');
                forgot_form.reset();
            }
        }
        xhr.send(data);
    });

    function checkLoginToBook(status, room_id) {
        if (status) {
            window.location.href = 'confirm_booking.php?id=' + room_id;
        } else {
            alert('error', 'Please login to book room');
        }
    }









































































    // VALIDATIONS
    function validateForm() {
        let name = register_form.elements['name'].value;
        let email = register_form.elements['email'].value;
        let phonenum = register_form.elements['phonenum'].value;
        let profile = register_form.elements['profile'].files[0];
        let address = register_form.elements['address'].value;
        let pincode = register_form.elements['pincode'].value;
        let dob = register_form.elements['dob'].value;
        let pass = register_form.elements['pass'].value;
        let cpass = register_form.elements['cpass'].value;

        // Simple validation
        if (name.trim() === '' || email.trim() === '' || phonenum.trim() === '' ||
            profile === undefined || address.trim() === '' || pincode.trim() === '' ||
            dob.trim() === '' || pass.trim() === '' || cpass.trim() === '') {
            alert('error', 'Please fill in all fields.');
            return false;
        }

        // Validate email format
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('error', 'Invalid email format.');
            return false;
        }

        // Validate pincode length
        if (pincode.length !== 6) {
            alert("error", "Invalid pincode length. Please enter a 6-digit pincode.");
            return false;
        }

        // Validate phone number format
        let phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(phonenum)) {
            alert('error', 'phone number will be in 10 chracters');
            return false;
        }

        // Validate password length
        if (pass.length >= 8 &&
            /[A-Z]/.test(pass) &&
            /[a-z]/.test(pass) &&
            /\d/.test(pass) &&
            /[!@#$%^&*(),.?":{}|<>]/.test(pass)) {

            return true;
        } else {
            alert("error", "Password is not valid. Password should be Like:SecureP@ss123");
            return false;
        }

        // Validate password match
        if (pass !== cpass) {
            alert('error', 'Passwords do not match.');
            return false;
        }



        return true; // All validations passed
    }


    // EYE BUTTON
    function togglePasswordVisibility(fieldId, eyeIconId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(eyeIconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("bi bi-eye-fill");
            eyeIcon.classList.add("bi bi-eye-slash-fill");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("bi bi-eye-slash-fill");
            eyeIcon.classList.add("bi bi-eye-fill");
        }
    }

    // Eye button for login
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });

    setActive();
</script>