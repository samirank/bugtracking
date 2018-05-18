<?php
include("../class/update.php");
if(isset($_POST['submit'])){
	$emp_id = $_POST['emp_id'];
	$enc	= $_POST['enc'];
	$update	= new update_data();
	
}else{
?>
<script>
	window.onload = function() {
	  window.history.back();
	};
</script>

<?php
}
?>