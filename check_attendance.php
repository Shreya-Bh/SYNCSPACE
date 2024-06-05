<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['email'])) {
    die("User is not logged in.");
}


$email = $_SESSION['email'];


$currentDate = date('Y-m-d');


$sql = "SELECT * FROM attendance WHERE email = ? AND DATE(time) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $currentDate);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo "<script>alert('You have already marked the attendance for today.'); window.location.href='dashboard.html';</script>";
} else {

    header("Location: attendance.html");
}


$stmt->close();
$conn->close();
?>
