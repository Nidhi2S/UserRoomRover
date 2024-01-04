let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');


feature_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_feature();
});
// Add Features
function add_feature() {
    let data = new FormData();
    data.append('name', feature_s_form.elements['feature_name'].value);
    data.append('add_feature', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);

    xhr.onload = function () {
        console.log(this.responseText); // Log the response to the console
        var myModal = document.getElementById('feature-s');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if (this.responseText.trim() === '1') { // Trim to remove whitespace
            alert('success', "New Feature Added");
            feature_s_form.elements['feature_name'].value = '';
            get_features();
        } else {
            alert('error', 'Unexpected response from the server');
        }
    }

    xhr.send(data);
}

//Get Feature Data
function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('features-data').innerHTML = this.responseText;

    }
    xhr.send('get_features');
}

// Remove Member
function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log(this.responseText);

    xhr.onload = function () {
        let body = document.querySelector("body");
        body.style.removeProperty("overflow");
        body.style.removeProperty("padding-right");
        let modalBackdrop = document.querySelector(".modal-backdrop");
        modalBackdrop.classList.remove("show");
        if (this.responseText == 1) {
            alert('success', 'Feature removed!');
            get_features();
        } else if (this.responseText == 'room_added') {
            alert('error', 'Feature is added in room');
        } else {
            alert('error', 'Server Down');
        }
    }

    // Prepare your data as key-value pairs
    var data = 'rem_feature=' + val;

    // Send the request with the data
    xhr.send(data);
}

facility_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_facility();
});
// add facility
function add_facility() {
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);

    xhr.onload = function () {
        console.log(this.responseText);
        var myModal = document.getElementById('facility-s');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only SVG images are allowed!');
            get_general();
        } else if (this.responseText == 'inv_size') {
            alert('error', 'images should be less than 1MB!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'image upload failed. SERVER DOWN');
        } else {
            alert('success', "New Facility Added");
            facility_s_form.reset();
            get_facilities();

        }
    }

    xhr.send(data);
}

//Get Facility Data
function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('facilities-data').innerHTML = this.responseText;

    }
    xhr.send('get_facilities');
}

// Remove Member
function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/feature_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log(this.responseText);

    xhr.onload = function () {
        let body = document.querySelector("body");
        body.style.removeProperty("overflow");
        body.style.removeProperty("padding-right");
        let modalBackdrop = document.querySelector(".modal-backdrop");
        modalBackdrop.classList.remove("show");

        if (this.responseText == 1) {
            alert('success', 'Facility removed!');
            get_facilities();
        } else if (this.responseText == 'room_added') {
            alert('error', 'Facility is added in room');
        } else {
            alert('error', 'Server Down');
        }
    }

    // Prepare your data as key-value pairs
    var data = 'rem_facility=' + val;

    // Send the request with the data
    xhr.send(data);
}

window.onload = function () {
    get_features();
    get_facilities();
}

