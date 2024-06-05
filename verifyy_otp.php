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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['otp'])) {
        $otp = $_POST['otp'];
        $email = $_SESSION['email'];

        if ($otp == $_SESSION['otp']) {
            header("Location: reset_password.php");
            exit();
        } else {
            echo "Invalid OTP.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="forgotpw.css">
</head>
<body>
<nav class="navbar" id="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <div class="logo">
                    <img src="../MainProject/Media/logo.gif" loop>
                </div>
            </div>
            <ul class="navbar-menu" id="navbar-menu">

                <li><a href="dashboard.html">Back</a></li>
               
            </ul>
            <div class="navbar-toggle" id="navbar-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <div class="sidebar">      
    </div>
    <h2>Verify OTP</h2>
    <form method="post" action="">
        <label for="otp">OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <button type="submit">Verify OTP</button>
    </form>
</body>
</html>
