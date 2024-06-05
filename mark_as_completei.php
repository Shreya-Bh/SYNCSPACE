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

if(isset($_POST['id'])) {
    $taskId = $_POST['id'];

    $sql = "UPDATE task_status SET completornot = 1, completed_at = NOW() WHERE id = $taskId";

    if ($conn->query($sql) === TRUE) {
        echo "Task marked as complete successfully";
    } else {
        echo "Error updating task: " . $conn->error;
    }
} else {
    echo "Error: 'id' parameter not set.";
}

$conn->close();
?>
