<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(array('error' => 'Session email not set'));
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(array('error' => 'Database connection failed: ' . $conn->connect_error));
    exit;
}

$email = $_SESSION['email'];

$sql_assigned_to_me = "SELECT * FROM tasks WHERE assignee_email = '$email'";
$result_assigned_to_me = $conn->query($sql_assigned_to_me);

$sql_assigned_by_me = "SELECT * FROM tasks WHERE assigner_email = '$email'";
$result_assigned_by_me = $conn->query($sql_assigned_by_me);

$conn->close();

$tasks_assigned_to_me = array();
$tasks_assigned_by_me = array();

if ($result_assigned_to_me->num_rows > 0) {
    while ($row = $result_assigned_to_me->fetch_assoc()) {
        $tasks_assigned_to_me[] = $row;
    }
}

if ($result_assigned_by_me->num_rows > 0) {
    while ($row = $result_assigned_by_me->fetch_assoc()) {
        $tasks_assigned_by_me[] = $row;
    }
}

echo json_encode(array(
    'assigned_to_me' => $tasks_assigned_to_me,
    'assigned_by_me' => $tasks_assigned_by_me
));
?>
