<?php
include('../class/update.php');
$app_id=$_GET['app_id']??null;
$err=null;
if($app_id){
	$delete = new update_data();
	if ($err=$delete->delete_application("application",$app_id)) {
		echo "application deleted";
	}else{
		echo "unable to delete application";

	}
}
?>