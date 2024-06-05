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
$departmentIdQuery = "SELECT department_id, name, id FROM registration WHERE email = '$loggedInUserEmail'";
$departmentIdResult = $conn->query($departmentIdQuery);
if ($departmentIdResult->num_rows > 0) {
    $departmentIdRow = $departmentIdResult->fetch_assoc();
    $departmentId = $departmentIdRow['department_id'];
    $loggedInUserName = $departmentIdRow['name'];
    $assignerId = $departmentIdRow['id'];
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
    echo "No users found";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignerEmail = $_SESSION['email']; 
    $assigneeEmail = $_POST['assignee'];
    $taskDescription = $_POST['taskDescription'];

    
    $assigneeQuery = "SELECT name, id FROM registration WHERE email = '$assigneeEmail'";
    $assigneeResult = $conn->query($assigneeQuery);
    if (!$assigneeResult) {
        die("Error fetching assignee name: " . $conn->error);
    }
    if ($assigneeResult->num_rows > 0) {
        $assigneeRow = $assigneeResult->fetch_assoc();
        $assigneeName = $assigneeRow['name'];
        $assigneeId = $assigneeRow['id'];
    } else {
        $assigneeName = "Unknown Assignee";
        $assigneeId = null;
    }

    
    $insertTaskQuery = "INSERT INTO tasks (assigner_name, assignee_name, assigner_email, assignee_email, task_description, assigner_id, assignee_id) 
                        VALUES ('$loggedInUserName', '$assigneeName', '$assignerEmail', '$assigneeEmail', '$taskDescription', '$assignerId', '$assigneeId')";
    if ($conn->query($insertTaskQuery) === TRUE) {
        header('Location: dashboard.html');
    } else {
        echo "Error: " . $insertTaskQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
