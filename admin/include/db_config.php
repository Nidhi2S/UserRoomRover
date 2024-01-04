<?php

// Database connection parameters
$hname = "localhost";
$uname = "phpmyadmin";
$pass = "root";
$db = "mywebsite";

// Establishing a database connection
$con = mysqli_connect($hname, $uname, $pass, $db);
if (!$con) {
    // Display an error message if the connection fails
    die("cannot Connect to database" . mysqli_connect_error());
}
// Function to filter input data to prevent SQL injection and other security issues
function filteration($data)
{
    foreach ($data as $key => $value) {
        // Trim whitespace
        $value = trim($value);
        // Remove backslashes
        $value = stripslashes($value);
        // Remove HTML and PHP tags
        $value = strip_tags($value);
        // Convert special characters to HTML entities
        $value = htmlspecialchars($value);

        $data[$key] = $value;
    }
    return $data;
}
// Function to select all records from a specified table
function selectAll($table)
{
    // Execute a SELECT query and return the result
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
}

// // Function to execute a SELECT query with parameters
// function select($sql, $values, $datatypes)
// {
//     $con = $GLOBALS['con'];
//     // Prepare and execute a SELECT query with parameters
//     if ($stmt = mysqli_prepare($con, $sql)) {
//         mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
//         if (mysqli_stmt_execute($stmt)) {
//             // Get the result of the query
//             $res = mysqli_stmt_get_result($stmt);
//             mysqli_stmt_close($stmt);
//             return $res;
//         } else {
//             // Display an error message if the query execution fails
//             mysqli_stmt_close($stmt);
//             die("Query can not be executed - Select ");
//         }
//     } else {
//         // Display an error message if the query preparation fails
//         die("Query can not be prepared - Select ") . mysqli_error($con);
//     }
// }

function select($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    // Prepare and execute a SELECT query with parameters
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            // Get the result of the query
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            // Display an error message if the query execution fails
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Select ");
        }
    } else {
        // Display an error message if the query preparation fails
        die("Query can not be prepared - Select ") . mysqli_error($con);
    }
}

// Function to execute an UPDATE query with parameters
function update($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            // Get the number of affected rows
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Update ");
        }
    } else {
        die("Query can not be prepared - Update " . mysqli_error($con));
    }
}
// Function to execute a INSERT query with parameters
function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Insert ");
        }
    } else {
        // die("Query can not be prepared - Insert ");
        die("Query can not be prepared - Insert: " . mysqli_error($con));
    }
}

function delete($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can not be executed - Delete ");
        }
    } else {
        die("Query can not be prepared - Delete " . mysqli_error($con));
    }
}
