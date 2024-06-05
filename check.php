<?php

session_start();


if(isset($_SESSION['email'])) {
    
    $userEmail = $_SESSION['email'];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "signup";

   
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql = "SELECT user_type FROM registration WHERE email='$userEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            if ($row["user_type"] === "manager") {
                
                header("Location: assign_task.html");
                exit(); 
            } else {
               
                echo '<script>alert("Sorry, this feature is not available for you."); window.location.href = "dashboard.html";</script>';
               
                header("Refresh: 3; URL=dashboard.html"); 
                exit(); 
            }
        }
    } else {
       
        echo "User not found.";
    }

    $conn->close();
} else {
    
    header("Location: login.html");
    exit(); 
}
?>
