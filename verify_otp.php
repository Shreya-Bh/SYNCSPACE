<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


date_default_timezone_set('Asia/Kolkata');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$otp = $_POST['otp'];

if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']) {
    
    $email = $_SESSION['email'];
    
    
    $sql_select = "SELECT id, name FROM registration WHERE email = '$email'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $name = $row["name"];
        
        
        $current_datetime = date('Y-m-d H:i:s');

        
        $sql_insert = "INSERT INTO attendance (id, name, email, attendance, time) VALUES ('$id', '$name', '$email', 'present', '$current_datetime')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo 'Attendance marked successfully. Redirecting...';
        } else {
            echo 'Error marking attendance: ' . $conn->error;
        }
    } else {
        echo "User details not found.";
    }
} else {
    echo 'Invalid OTP.';
}

mysqli_close($conn);
?>
