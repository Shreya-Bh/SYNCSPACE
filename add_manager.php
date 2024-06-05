<?php
session_start();
@include 'config.php'; 


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerId = $_POST['managerId'];


    $updateQuery = "UPDATE registration SET user_type = 'manager' WHERE id = '$managerId'";
    $updateResult = mysqli_query($conn, $updateQuery);
    if (!$updateResult) {
        die("Error in update query: " . mysqli_error($conn));
    }


    header("Location: admin_page.php");
    exit();
}

mysqli_close($conn);
?>
