<?php
require("include/essentials.php");
require("./include/db_config.php");
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rooms </title>
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
                <h3 class="mb-4">Rooms </h3>

                <!-- Room section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <!-- Feature Section -->
                        <div class="text-end mb-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-person-plus"></i> Add
                            </button>
                        </div>


                        <div class="table-responsive-lg " style="height: 450px; overflow-y: scroll ">
                            <table class="table table-hover border text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add room  Modal   -->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" id="add_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Room </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Area</label>
                                <input name="area" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Price</label>
                                <input name="price" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Quantity</label>
                                <input name="quantity" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Adult(Max.)</label>
                                <input name="adult" min="1" type="number" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Children(Max.)</label>
                                <input name="children" min="1" type="number" class="form-control shadow-none" required>
                            </div>


                            <div class="col-12 md-3 mb-2">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                      <div class='col-md-3 mb-1'>
                                      <label>                                     
                                        <input type='checkbox' name ='features' value ='$opt[id]' class = 'form-check-input shadow-none'>
                                        $opt[name]
                                      </label>
                                      </div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 md-3 mb-2">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                      <div class='col-md-3'>
                                      <label>                                     
                                        <input type='checkbox' name='facilities' value ='$opt[id]' class = 'form-check-input shadow-none'>
                                        $opt[name]
                                      </label>
                                      </div>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" class="form-control shadow-none" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Edit room  Modal   -->
    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" id="edit_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Room </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Area</label>
                                <input name="area" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Price</label>
                                <input name="price" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Quantity</label>
                                <input name="quantity" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Adult(Max.)</label>
                                <input name="adult" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label class="form-label fw-bold">Children(Max.)</label>
                                <input name="children" min="1" type="number" class="form-control shadow-none" required>
                            </div>

                            <div class="col-12 md-3 mb-2">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                      <div class='col-md-3'>
                                      <label>                                     
                                        <input type='checkbox' name='features' value ='$opt[id]' class = 'form-check-input shadow-none'>
                                        $opt[name]
                                      </label>
                                      </div>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 md-3 mb-2">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                      <div class='col-md-3'>
                                      <label>                                     
                                        <input type='checkbox' name='facilities' value ='$opt[id]' class = 'form-check-input shadow-none'>
                                        $opt[name]
                                      </label>
                                      </div>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-12 mb-5">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" class="form-control shadow-none" rows="4" required></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Manage image room  Modal  -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5">Room Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form" action="">
                            <label class="form-label fw-bold">Add Image</label>
                            <input name="image" type="file" class="form-control shadow-none mb-3" accept=".jpg, .png, .webp, .jpeg" required>
                            <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">ADD</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>

                    <div class="table-responsive-lg " style="height: 350px; overflow-y: scroll ">
                        <table class="table table-hover border text-center">
                            <thead class="">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Script file -->
    <?php require("include/scripts.php"); ?>
    <!-- <script>
        let add_room_form = document.getElementById('add_room_form');
        add_room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_rooms();
        })

        function add_rooms() {
            let data = new FormData();
            data.append('add_room', '');
            data.append('name', add_room_form.elements['name'].value);
            data.append('area', add_room_form.elements['area'].value);
            data.append('price', add_room_form.elements['price'].value);
            data.append('quantity', add_room_form.elements['quantity'].value);
            data.append('adult', add_room_form.elements['adult'].value);
            data.append('children', add_room_form.elements['children'].value);
            data.append('desc', add_room_form.elements['desc'].value);

            let features = [];
            Array.from(add_room_form.elements['features']).forEach(el => {
                if (el.checked) {
                    features.push(el.value);
                }
            });

            let facilities = [];
            Array.from(add_room_form.elements['facilities']).forEach(el => {
                if (el.checked) {
                    facilities.push(el.value);
                }
            });

            data.append('features', JSON.stringify(features));
            data.append('facilities', JSON.stringify(facilities));

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.onload = function() {
                console.log(this.responseText); // Log the response to the console
                var myModal = document.getElementById('add-room');
                var modal = bootstrap.Modal.getInstance(myModal)
                modal.hide();

                if (this.responseText.trim() === '1') {
                    alert('success', "New Room Added");
                    add_room_form.reset();
                    get_all_rooms();
                } else {
                    alert('error', 'Unexpected response from the server');
                }
            }

            xhr.send(data);
        }

        function get_all_rooms() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('room-data').innerHTML = this.responseText;
            }

            xhr.send('get_all_rooms');
        }

        let edit_room_form = document.getElementById('edit_room_form');

        function edit_details(id) {
            // let edit_room_form = document.getElementById('edit_room_form');
            // console.log(id);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                edit_room_form.elements['name'].value = data.room_data.name;
                edit_room_form.elements['area'].value = data.room_data.area;
                edit_room_form.elements['price'].value = data.room_data.price;
                edit_room_form.elements['quantity'].value = data.room_data.quantity;
                edit_room_form.elements['adult'].value = data.room_data.adult;
                edit_room_form.elements['children'].value = data.room_data.children;
                edit_room_form.elements['desc'].value = data.room_data.description;
                edit_room_form.elements['room_id'].value = data.room_data.id;

                // console.log("Data Facilities:", data);
                Array.from(edit_room_form.elements['facilities']).forEach(el => {
                    if (data.facilities.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });

                Array.from(edit_room_form.elements['features']).forEach(el => {
                    if (data.features.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });





            }

            // Use '&' to separate parameters
            xhr.send('get_room=' + id);

        }

        edit_room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_rooms();
        })

        function submit_edit_rooms() {
            let data = new FormData();
            data.append('edit_room', '');
            data.append('name', edit_room_form.elements['name'].value);
            data.append('room_id', edit_room_form.elements['room_id'].value);
            data.append('area', edit_room_form.elements['area'].value);
            data.append('price', edit_room_form.elements['price'].value);
            data.append('quantity', edit_room_form.elements['quantity'].value);
            data.append('adult', edit_room_form.elements['adult'].value);
            data.append('children', edit_room_form.elements['children'].value);
            data.append('desc', edit_room_form.elements['desc'].value);

            let features = [];
            Array.from(edit_room_form.elements['features']).forEach(el => {
                if (el.checked) {
                    features.push(el.value);
                }
            });

            let facilities = [];
            Array.from(edit_room_form.elements['facilities']).forEach(el => {
                if (el.checked) {
                    facilities.push(el.value);
                }
            });

            data.append('features', JSON.stringify(features));
            data.append('facilities', JSON.stringify(facilities));
            console.log(data);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.onload = function() {
                console.log(this.responseText); // Log the response to the console
                var myModal = document.getElementById('edit-room');
                var modal = bootstrap.Modal.getInstance(myModal)
                modal.hide();

                if (this.responseText.trim() === '1') {
                    alert('success', "Room data edited");
                    edit_room_form.reset();
                    get_all_rooms();
                } else {
                    alert('error', 'Unexpected response from the server');
                }
            }

            xhr.send(data);
        }

        function room_images(id, name) {
            add_image_form.elements['room_id'].value = id;
        }

        function toggle_status(id, val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert('success', 'Status toggled');
                    get_all_rooms();
                } else {
                    alert('error', 'Server down!');
                }
            }

            // Use '&' to separate parameters
            xhr.send('toggle_status=' + id + '&value=' + val);
        }
        let add_image_form = document.getElementById('add_image_form');
        add_image_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_image();
        })

        function add_image() {
            let data = new FormData();
            data.append('image', add_image_form.elements['image'].files[0]);
            data.append('room_id', add_image_form.elements['room_id'].value);

            data.append('add_image', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);

            xhr.onload = function() {
                console.log(this.responseText);

                if (this.responseText == 'inv_img') {
                    alert('error', 'only JPG,JPEG,WEBP or PNG images are allowed!', 'image-alert');
                    get_general();
                } else if (this.responseText == 'inv_size') {
                    alert('error', 'images should be less than 2MB !', 'image-alert');
                } else if (this.responseText == 'upd_failed') {
                    alert('error', 'image upload failed. SERVER DOWN', 'image-alert');
                } else {
                    alert('success', "New image Added", 'image-alert');

                    room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText);

                    add_image_form.reset();

                }
            }
            xhr.send(data);
        }

        function room_images(id, rname) {
            document.querySelector("#room-images .modal-title").innerText = rname;
            add_image_form.elements['room_id'].value = id;
            add_image_form.elements['image'].value = '';

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('room-image-data').innerHTML = this.responseText;

            }

            // Use '&' to separate parameters
            xhr.send('get_room_images=' + id);



        }

        function rem_image(img_id, room_id) {
            let data = new FormData();
            data.append('image_id', img_id);
            data.append('room_id', room_id);
            data.append('rem_image', '');

            data.append('rem_image', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);

            xhr.onload = function() {
                console.log(this.responseText);

                if (this.responseText == 1) {
                    alert('success', 'image removed!', 'image-alert');
                    room_images(room_id, document.querySelector("#room-images .modal-title").innerText);


                } else {
                    alert('error', 'image removal failed', 'image-alert');
                }
            }
            xhr.send(data);
        }

        function thumb_image(img_id, room_id) {
            let data = new FormData();
            data.append('image_id', img_id);
            data.append('room_id', room_id);
            data.append('thumb_image', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);

            xhr.onload = function() {
                console.log(this.responseText);

                if (this.responseText == 1) {
                    alert('success', 'thumb nail changed!', 'image-alert');
                    room_images(room_id, document.querySelector("#room-images .modal-title").innerText);


                } else {
                    alert('error', 'thumb nail update failed', 'image-alert');
                }
            }
            xhr.send(data);
        }

        function remove_room(room_id) {
            if (confirm("Are you sure ,you want to delete this room?")) {
                let data = new FormData();
                data.append('room_id', room_id);
                data.append('remove_room', '');
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/rooms_crud.php", true);

                xhr.onload = function() {
                    console.log(this.responseText);

                    if (this.responseText == 1) {
                        alert('success', 'Room removed!');
                        get_all_rooms();


                    } else {
                        alert('error', 'Room removal failed');
                    }
                }
                xhr.send(data);
            }
        }
        window.onload = function() {
            get_all_rooms();
        }
    </script> -->

    <script src="./scripts/rooms.js"></script>
</body>

</html>