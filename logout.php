<?php

session_start();

unset($_SESSION['email']); 


session_destroy();


header("Location: middle.html"); 
exit;
?>
