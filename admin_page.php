<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xr5eP9hJwbrp0V4G/qamZUG47fKu6KFHpXLBdsgP32u7DE2ks/7nOcbIrzJueJHJ+qVScXvlPeD2trUF3/bi7A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   
   <link rel="stylesheet" href="admin_page.css">
</head>
<body>
   
<div class="container">
   
   <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
         <h3>Admin Panel</h3>
      </div>
      <ul class="sidebar-menu">
      <li><a href="admin_approval.php">Admin Approval</a></li>
         <li><a href="#" id="add-department"><i class="fas fa-plus"></i> Add Department</a></li>
         <li><a href="#" id="add-manager"><i class="fas fa-user-plus"></i> Add Manager</a></li>
         <li><a href="check_atten.html" id="attendance">Check Attendance</a></li>
         <li><a href="depatten.html" id="attendance">Department Report</a></li>
      </ul>
   </div>

   
   <div class="content" id="content">
      <div class="topbar">
         <div class="topbar-right">
            <a href="logouta.php" class="btn">Logout</a>
         </div>
      </div>
      <h3>Hi, <span>admin</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      <p>This is an admin page</p>
   </div>
</div>

<div class="add-department-form" id="addDepartmentForm">
   <form action="add_department.php" method="post">
      <h2>Add Department</h2>
      <div class="form-group">
         <label for="departmentName">Department Name:</label>
         <input type="text" id="departmentName" name="departmentName" required>
      </div>
      <button type="submit" class="btn">Add Department</button>
   </form>
</div>



<div class="add-manager-form" id="addManagerForm">
   <form action="add_manager.php" method="post">
      <h2>Add Manager</h2>
      <div class="form-group">
         <label for="managerId">Select Manager:</label>
         <select id="selectUserDropdown" name="managerId" required>
            
         </select>
      </div>
      <button type="submit" class="btn">Add Manager</button>
   </form>
</div>




<script src="admin_page.js"></script>

</body>
</html>
