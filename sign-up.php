<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function fetchDepartments($conn) {
    $departments = array();
    $sql = "SELECT department FROM department";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $departments[] = $row['department'];
        }
    }
    return $departments;
}


function insertRegistration($conn, $name, $email, $number, $password, $selected_department) {
    $sql_check_email = "SELECT * FROM registration WHERE email = '$email'";
    $result = $conn->query($sql_check_email);
    if (!$result) {
        echo "Error: " . $sql_check_email . "<br>" . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            echo '<script>';
            echo 'alert("Email already exists. Please choose a different email.");';
            echo 'window.location = "enter.html";'; 
            echo '</script>';
        } else {
            
            $sql_department_id = "SELECT id FROM department WHERE department = '$selected_department'";
            $result_department_id = $conn->query($sql_department_id);
            if ($result_department_id->num_rows > 0) {
                $row = $result_department_id->fetch_assoc();
                $department_id = $row['id'];
                
                $sql_insert_user = "INSERT INTO registration (name, email, number, department_id, password) VALUES ('$name', '$email', '$number', '$department_id', '$password')";
                if ($conn->query($sql_insert_user) === TRUE) {
                    header('Location: enter.html');
                    exit;
                } else {
                    echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
                }
            } else {
                echo "Department not found.";
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $selected_department = $_POST['department'];

    
    insertRegistration($conn, $name, $email, $number, $password, $selected_department);
} else {
    
    $departments = fetchDepartments($conn);
    echo json_encode(array("departments" => $departments));
}

$conn->close();
?>
