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


$email = $_POST['email'];
$password = $_POST['password'];


$sql_check_email = "SELECT * FROM registration WHERE email = '$email'";
$result = $conn->query($sql_check_email);

if (!$result) {
    echo "Error: " . $sql_check_email . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            
            $_SESSION['email'] = $email; 
            header('Location: main.html');
            exit;
        } else {
            
            echo '<script>';
            echo 'alert("Invalid credentials. Please check your email and password.");';
            echo 'window.location = "enter.html";'; 
            echo '</script>';
    
        }
    } else {
        
        echo '<script>';
        echo 'alert("Email not found. Please sign up first.");';
        echo 'window.location = "enter.html";'; 
        echo '</script>';
      
    }
}

$conn->close();
?>
