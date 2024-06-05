<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}


if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}
$email = $_SESSION['email'];


$name = $_POST['name'];
$number = $_POST['number'];


$stmt = $conn->prepare("UPDATE registration SET name = ?, number = ? WHERE email = ?");
$stmt->bind_param("sss", $name, $number, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update information']);
}

$stmt->close();


$conn->close();
?>
