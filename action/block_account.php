<?php
include('../class/update.php');
$emp_id=$_GET['emp_id']??null;
$err=null;
if($emp_id){
	$delete = new update_data();
	$err=$delete->block_account("users",$emp_id);
}
echo $err;
?>