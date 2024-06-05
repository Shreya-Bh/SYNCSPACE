
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

$taskId = $_POST['id'];

$sql = "UPDATE tasks SET is_completed = 1, task_completed_at = NOW() WHERE id = $taskId";

if ($conn->query($sql) === TRUE) {
    echo "Task marked as complete successfully";
} else {
    echo "Error updating task: " . $conn->error;
}
$conn->close();
?>
