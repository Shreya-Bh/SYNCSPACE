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


$loggedInUserEmail = $_SESSION['email'];
$departmentIdQuery = "SELECT department_id FROM registration WHERE email = '$loggedInUserEmail'";
$departmentIdResult = $conn->query($departmentIdQuery);
if ($departmentIdResult->num_rows > 0) {
    $departmentIdRow = $departmentIdResult->fetch_assoc();
    $departmentId = $departmentIdRow['department_id'];
} else {
   
    $departmentId = 0; 
}


$sql = "SELECT name, email FROM registration WHERE department_id = '$departmentId' AND email != '$loggedInUserEmail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    echo json_encode(array("message" => "No users found"));
}

$conn->close();
?>
