<?php
session_start();
require 'vendor/autoload.php'; 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_SESSION['email'];


$otp = mt_rand(100000, 999999);
$_SESSION['otp'] = $otp;


$subject = "OTP for Attendance System";
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

    
    $mail->send();
    echo 'OTP sent successfully.';
} catch (Exception $e) {
    echo 'Error sending OTP: ' . $mail->ErrorInfo;
}


$conn->close();
?>
