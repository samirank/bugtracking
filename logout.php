<?php
   include('config.php');
   session_start();
   $emp = $_SESSION['login_emp_id'];
   mysqli_query($con,"UPDATE employee SET status = 'offline' WHERE emp_id = '$emp'");
   if(session_destroy()) {
        header("Location: index.php");
   }
?>