<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$otp = $input['otp'] ?? '';

if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid OTP']);
}
?>
