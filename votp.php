<?php
session_start();
require 'vendor/autoload.php'; 

header('Content-Type: application/json');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}


if (!isset($_SESSION['email']) || !isset($_SESSION['otp'])) {
    echo json_encode(['success' => false, 'error' => 'OTP verification failed']);
    exit();
}
$email = $_SESSION['email'];
$otp = $_SESSION['otp'];


$user_otp = $_POST['otp']; 
if ($user_otp != $otp) {
    echo json_encode(['success' => false, 'error' => 'Invalid OTP']);
    exit();
}


$stmt = $conn->prepare("SELECT name, number FROM registration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

echo json_encode(['success' => true, 'user' => $user]);


$conn->close();
?>
