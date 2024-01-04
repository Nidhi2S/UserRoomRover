// Get users
function get_bookings(search = '') {
    console.log("hihi");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search='+search);
}

// ASSIGN ROOM
let assign_room_form = document.getElementById('assign_room_form');
function assign_room(id) {
    assign_room_form.elements['booking_id'].value = id;
}

assign_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    let data = new FormData();
    data.append('room_no', assign_room_form.elements['room_no'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings_crud.php", true);


    xhr.onload = function () {
        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal)
        modal.hide();
        if (this.responseText) {
            alert('success', 'Room Number Alloted: Booking Initialized');
            assign_room_form.reset();
            get_bookings();
        }
        else {
            alert('error', 'Server down');
        }
    }
    xhr.send(data);
});

// CANCEL BOOKING
function cancel_booking(id) {
    if (confirm("Are you sure ,you want to cancel this booking?")) {
        let data = new FormData();
        data.append('booking_id',id);
        data.append('cancel_booking', '');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings_crud.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.responseText == 1) {
                alert('success', 'Booking cancelled!');
                get_bookings();

            } else {
                alert('error', 'Server Down');
            }
        }
        xhr.send(data);
    }
}



window.onload = function () {
    get_bookings();
}
