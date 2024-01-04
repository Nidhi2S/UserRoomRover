<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


// files for database configuration and essential functions
require("../include/db_config.php");
require("../include/essentials.php");
// Function to check if user is logged in as an admin
adminLogin();

// Get users
if (isset($_POST['get_users'])) {
    $res = selectAll('user_cred');
    $i = 1;

    $path = USERS_IMG_PATH;

    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "      <button onclick = 'remove_user($row[id])' type='button' class='btn btn-danger shadow-none btn-sm ' data-bs-toggle='modal' data-bs-target='#'>
        <i class='bi bi-trash'></i> 
        </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        if ($row['is_verified']) {
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></span>";
            $del_btn = " ";
        }
        $status = "<button class = 'btn btn-dark btn-sm shadow-none' onclick = 'toggle_status($row[id],0)'>
            active
        </button>";
        if (!$row['status']) {
            $status = "<button class = 'btn btn-danger btn-sm shadow-none' onclick = 'toggle_status($row[id],1)'>
                inactive
            </button>";
        }
        $date = date('d-m-Y', strtotime($row['date&time']));
        $data .= "
        <tr>
        <td>$i</td>
        <td>
        <img src='$path$row[profile]' width ='55px'><br>
            $row[name]
        </td>
        <td>$row[email]</td>
        <td>$row[phonenum]</td>
        <td>$row[address]</td>
        <td>$row[dob]</td>
        <td>$verified</td>
        <td>$status</td>
        <td>$date</td>
        <td>$del_btn</td>

        
        </tr>
        ";
        $i++;
    }
    echo $data;
}
// Toggle status
if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);
    $q = "UPDATE `user_cred` SET `status`=? WHERE id = ?";
    $values  = [$frm_data['value'], $frm_data['toggle_status']];;

    if (update($q, $values, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}
// Remove User
if (isset($_POST['remove_user'])) {
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `user_cred` WHERE `id` = ? AND `is_verified` = ?", [$frm_data['user_id'], 0], 'ii');

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}
// Search User
if (isset($_POST['search_user'])) {
    $frm_data = filteration($_POST);
    $query = " SELECT * FROM `user_cred` WHERE `name` LIKE ?";
    $res = select($query, ["%{$frm_data['name']}%"], 's');

    $i = 1;
    $path = USERS_IMG_PATH;

    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button onclick = 'remove_user($row[id])' type='button' class='btn btn-danger shadow-none btn-sm ' data-bs-toggle='modal' data-bs-target='#'>
                        <i class='bi bi-trash'></i> 
                    </button>";
        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

        if ($row['is_verified']) {
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></span>";
            $del_btn = " ";
        }
        $status = "<button class = 'btn btn-dark btn-sm shadow-none' onclick = 'toggle_status($row[id],0)'>
                        active
                </button>";
        if (!$row['status']) {
            $status = "<button class = 'btn btn-danger btn-sm shadow-none' onclick = 'toggle_status($row[id],1)'>
                         inactive
                    </button>";
        }
        $date = date('d-m-Y', strtotime($row['date&time']));
        $data .= "
        <tr>
        <td>$i</td>
        <td>
            <img src='$path$row[profile]' width ='55px'><br>
            $row[name]
        </td>
        <td>$row[email]</td>
        <td>$row[phonenum]</td>
        <td>$row[address]</td>
        <td>$row[dob]</td>
        <td>$verified</td>
        <td>$status</td>
        <td>$date</td>
        <td>$del_btn</td>
        </tr>";

        $i++;
    }
    echo $data;
}
