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
    if (isset($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        $email = $_SESSION['email'];

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE registration SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            echo "<script>alert('Password reset successfully.'); window.location.href='enter.html';</script>";
        } else {
            echo "Failed to reset password.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
    <h2>Reset Password</h2>
    <form method="post" action="">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
