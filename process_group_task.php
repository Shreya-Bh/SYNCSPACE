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
    $assignerEmail = $_SESSION['email']; 
    $taskDescription = $_POST['taskDescription'];
    $assignees = $_POST['assignees'];

     
     $assignerQuery = "SELECT name, id FROM registration WHERE email = '$assignerEmail'";
     $assignerResult = $conn->query($assignerQuery);
     if ($assignerResult->num_rows > 0) {
         $assignerRow = $assignerResult->fetch_assoc();
         $assignerName = $assignerRow['name'];
         $assignerId = $assignerRow['id'];
     } else {
         $assignerName = "Unknown Assigner";
         $assignerId = null;
     }

    
    $assigneeNames = array();
    $assigneeEmails = array();
    foreach ($assignees as $assigneeEmail) {
        $assigneeQuery = "SELECT name FROM registration WHERE email = '$assigneeEmail'";
        $assigneeResult = $conn->query($assigneeQuery);
        if ($assigneeResult->num_rows > 0) {
            $assigneeRow = $assigneeResult->fetch_assoc();
            $assigneeNames[] = $assigneeRow['name'];
        }
        $assigneeEmails[] = $assigneeEmail;
    }
    $assigneeNamesStr = implode(', ', $assigneeNames);
    $assigneeEmailsStr = implode(', ', $assigneeEmails);

    
    $insertGroupTaskQuery = "INSERT INTO group_tasks (assigner_name, assigner_email, assignee_names, assignee_emails, task_description,assigner_id) 
                        VALUES ('$assignerName', '$assignerEmail', '$assigneeNamesStr', '$assigneeEmailsStr', '$taskDescription','$assignerId')";
    if ($conn->query($insertGroupTaskQuery) === TRUE) {
        header('Location: dashboard.html');
    } else {
        echo "Error: " . $insertGroupTaskQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
