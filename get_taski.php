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

$email = $_SESSION['email'];

$sql = "SELECT * FROM task_status WHERE assignee_email = '$email' AND completornot = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
    
    table {
margin-left:-18px !important;
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    button {
        padding: 5px 10px;
        background-color: transparent;
        color: black;
        border-color: black;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: black;
        color: aqua;
    }
    .task-description-column {
        width: 30%; 
    }
    .a{
        width: 20%;
    }
    .b{
        width: 10%;
    }
    .c{
 
        text-align: center;
    }
</style>";
    echo "<table>";
    echo "<tr><th class='b'>Task ID</th><th class='a'>Assigner Name</th><th class='task-description-column'>Task Description</th><th class='c'>Action</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["task_id"] . "</td>";
        echo "<td>" . $row["assigner_name"] . "</td>";
        echo "<td>" . $row["task_description"] . "</td>";
        echo "<td class='c'><button onclick='markAsCompleteGroupWork(" . $row["id"] . ")'>Mark as Complete</button></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No tasks assigned to you.";
}
$conn->close();
?>
