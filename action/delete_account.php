<?php
include('../class/update.php');
$emp_id=$_GET['emp_id']??null;
$err=null;
if($emp_id){
	$delete = new update_data();
	if($err=$delete->delete_account($emp_id)){
		if($err){
			echo "account with employee id ".$emp_id." deleted.";
		}
	}
}
?>