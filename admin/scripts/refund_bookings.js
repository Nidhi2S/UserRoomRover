// Get Bookings
function get_bookings(search = '') {
    console.log("hihi");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_bookings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search=' + search);
}


// Refund BOOKING
function refund_booking(id) {
    if (confirm("you want to refund this booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('refund_booking', '');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_bookings_crud.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.responseText == 1) {
                alert('success', 'Money Refunded!');
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
