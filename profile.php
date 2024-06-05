<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Styling Example</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


session_start();




if (!isset($_SESSION['email'])) {
    header('Location: enter.html'); 
    exit;
}


$email = $_SESSION['email']; 


$sql_fetch_user = "SELECT * FROM registration WHERE email = '$email'";
$result = $conn->query($sql_fetch_user);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $name = $row['name'];
    $number = $row['number'];

    echo "<p class='z'>$name</p>";
    echo "<p class='line'></p>";
    echo "<div class='email-wrapper'>";
    echo "<p class='y'>Email:</p>";
    echo "<p class='email'>$email</p>";
    echo "</div>";
    echo "<div class='number-wrapper'>";
    echo "<p class='x'>Phone Number:</p>";
    echo "<p class='number'>$number</p>";
    echo "</div>";

} else {
   
    echo "User not found.";
}

$conn->close();
?>
</body>
</html>