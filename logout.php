<?php
session_start();
$con = mysqli_connect("localhost","blurhync_bts","XRfuE,JIvW8)","blurhync_bts");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$emp = $_SESSION['login_emp_id'];
mysqli_query($con,"UPDATE employee SET status = 'offline' WHERE emp_id = '$emp'");
if(session_destroy()) {
	header("Location: index.php");
}
?>