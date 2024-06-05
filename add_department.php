<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
   exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $adminName = $_SESSION['admin_name'];


    $departmentName = $_POST['departmentName'];
    $departmentName = htmlspecialchars($departmentName);

    $sql = "INSERT INTO department (admin, department) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $adminName, $departmentName);

    if ($stmt->execute()) {

        header("location: admin_page.php");
        exit();
    } else {

        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>
