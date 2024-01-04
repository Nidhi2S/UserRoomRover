// Get users
function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('get_users');
}
// Toggle room status
function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status toggled');
            get_users();
        } else {
            alert('error', 'Server down!');
        }
    }

    // Use '&' to separate parameters
    xhr.send('toggle_status=' + id + '&value=' + val);
}
// Remove user
function remove_user(user_id) {
    if (confirm("Are you sure ,you want to remove this user?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.responseText == 1) {
                alert('success', 'User removed!');
                get_users();


            } else {
                alert('error', 'User removal failed');
            }
        }
        xhr.send(data);
    }
}
// Search user
function search_user(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('search_user&name=' + username);
}

window.onload = function () {
    get_users();
}
