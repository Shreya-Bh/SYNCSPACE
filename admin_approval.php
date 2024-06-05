<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
   $userId = $_POST['user_id'];
   $stmt = $conn->prepare("UPDATE user_form SET user_type = 'admin' WHERE id = ?");
   $stmt->bind_param('i', $userId);
   $stmt->execute(); 
   echo "Admin approved successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Approval</title>
   <link rel="stylesheet" href="depatten.css">
</head>
<body>
<nav class="navbar" id="navbar">
        <div class="navbar-container">
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="admin_page.php">Back</a></li>
            </ul>
            <div class="navbar-toggle" id="navbar-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

   <h2>Admin Approval</h2>
   <table>
      <tr>
         <th>Name</th>
         <th>Email</th>
         <th>Action</th>
      </tr>
      <?php
      $sql = "SELECT * FROM user_form WHERE user_type='waiting'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
         echo "<tr>";
         echo "<td>" . $row['name'] . "</td>";
         echo "<td>" . $row['email'] . "</td>";
         echo "<td><form method='post' action='admin_approval.php'>
               <input type='hidden' name='user_id' value='" . $row['id'] . "'>
               <button type='submit' name='approve'>Approve</button>
               </form></td>";
         echo "</tr>";
      }
      ?>
   </table>
  
</body>
</html>
