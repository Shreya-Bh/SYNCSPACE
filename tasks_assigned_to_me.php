<?php
session_start();


if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}

$loggedInUserEmail = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT group_tasks.*, task_status.assignee_email, task_status.completornot, task_status.completed_at 
        FROM group_tasks 
        INNER JOIN task_status ON group_tasks.task_id = task_status.task_id
        WHERE group_tasks.task_id IN (
            SELECT task_id FROM group_tasks WHERE assignee_emails LIKE '%$loggedInUserEmail%'
        )";

$result = $conn->query($sql);

$tasks = array();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $task_id = $row['task_id'];
        if (!isset($tasks[$task_id])) {
            $tasks[$task_id] = $row;
            $tasks[$task_id]['assignee_emails'] = explode(", ", $tasks[$task_id]['assignee_emails']);
            $tasks[$task_id]['completed'] = array();
        }

        if ($row['completornot'] == 1) {
            $tasks[$task_id]['completed'][$row['assignee_email']] = $row['completed_at'];
        }
    }

    
    foreach ($tasks as $task) {
        echo '<div class="task">';
        echo '<p class="task-header">Task ID: ' . $task['task_id'] . '</p>';
        echo '<p>Assigner: ' . $task['assigner_name'] . '</p>';
        echo '<p>Assignees: ' . implode(", ", $task['assignee_emails']) . '</p>';
        echo '<p>Description: ' . $task['task_description'] . '</p>';
        echo '<p>Given At: ' . $task['assign_date'] . '</p>';

        
        foreach ($task['assignee_emails'] as $assignee_email) {
            echo '<p>' . $assignee_email . ' - Completed At: ';
            if (isset($task['completed'][$assignee_email])) {
                echo $task['completed'][$assignee_email];
            } else {
                echo 'Not completed';
            }
            echo '</p>';
        }

        echo '</div>';
    }
} else {
    echo "No tasks assigned to you.";
}
$conn->close();
?>
