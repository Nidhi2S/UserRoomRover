<?php include("../rough/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <?php
        $query = "SELECT * FROM `userdata`";
        $result = mysqli_query($conn, $query);

        while ($fetch = mysqli_fetch_assoc($result)) {
            // $id = $fetch['id'];
            $name = $fetch['name'];
            // $picture_name = $fetch['picture']; 
            
            if (file_exists($picture)) {
                echo "File exists!";
            } else {
                echo "File does not exist: $picture";
            }

        ?>
            <div class="id"><?php echo $id ?></div><br>
            <div class="name"><?php echo $name ?></div><br>
            <div class="picture"><?php echo $picture ?></div><br>
            <?php ?>
            <div style="width: 500px;" class="img" ><img src='<?php echo "../uploaded_images/$picture_name" ?>' alt=""></div>
            <br><br>
        <?php
        }


        ?>
    </div>
</body>

</html>