<?php
session_start();
@include 'config.php'; 


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT id, name, email FROM registration WHERE user_type != 'manager' OR user_type IS NULL";
$result = mysqli_query($conn, $query);

if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($users);
} else {
    echo json_encode([]);
}

mysqli_close($conn);
?>
