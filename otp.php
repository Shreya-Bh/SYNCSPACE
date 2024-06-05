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


if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}
$email = $_SESSION['email'];


$otp = mt_rand(100000, 999999);
$_SESSION['otp'] = $otp;


$subject = "OTP for SyncSpace";
$message = "Your OTP is: $otp";


$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your gmail'; 
    $mail->Password = 'your app pw'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    
    $mail->setFrom('your gmail', 'SyncSpace');
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $message;

    
    if ($mail->send()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to send OTP']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Mailer Error: ' . $mail->ErrorInfo]);
}


$conn->close();
?>
