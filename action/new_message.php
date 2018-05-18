<?php 
session_start();
include('../class/insert.php');
$create = new insert();

if(isset($_POST)){


	$inputMsg = $_POST['inputMsg'];
	$msgtitle = $_POST['msgtitle'];

	if($_SESSION['login_user_type']=='admin'){
		$msgto    = $_POST['inputMsgTo'];	
	}else{
		$msgto    = '1';
	}
	
	$msgfrom  = $_SESSION['login_emp_id'];

	$err = $create->new_msg($inputMsg,$msgtitle,$msgto,$msgfrom);
	if($err){
		$_SESSION['err'] = 1;
      	header("location: ../create_message.php");
	}



}



 ?>