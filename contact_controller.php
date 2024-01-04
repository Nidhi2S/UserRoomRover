<?php
var_dump("hii");
// require("include/header.php"); 
require("include/links.php");
require("./admin/include/db_config.php");

var_dump($_POST);
// if (isset($_POST['send'])) {
    echo "hii";
    $frm_data = filteration($_POST);
    $values = "$frm_data[name],$frm_data[email],$frm_data[subject],$frm_data[message]";
    $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES $values";
    $res = mysqli_query($con,$q);
    if ($res ==1) {
     alert('success','Mail sent!');
    }
    else{
        alert('error',"Not sent");
    }

// }

require("include/footer.php"); 
?>