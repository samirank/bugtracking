<?php include("template/header.php"); ?>
<?php if(isset($_GET['emp_id'])&&$_SESSION['login_user_type']=="admin"){
	$emp_id=$_GET['emp_id'];
}else{
	$emp_id=$_SESSION['login_emp_id'];
}
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
  <?php if($_SESSION['login_user_type']=='admin'){ ?>
   <li class="breadcrumb-item"><a href="user_accounts.php">User Accounts</a></li>
  <?php } ?>
  <li class="breadcrumb-item"><a href="edit_account.php<?php if($_SESSION['login_user_type']=='admin'){ echo '?emp_id='.$emp_id; }?>">Edit Account</a></li>
  <li class="breadcrumb-item active">Change Password</li>
</ol>

<!-- Form begin -->
<form class="bg-light h-100 mt-4 pl-5 pt-3" name="myform" id="myform" method="POST" action='action/update_password.php'>
	<div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="emp_id" class="col-sm-2 col-form-label">Employee Name</label>
      <div class="col-sm-6">
<?php 
include("class/view.php");
$display=new display();
$result=$display->display_table_cndtn("employee","emp_id='$emp_id'");
$row=mysqli_fetch_assoc($result);
?>
        <input type="text" class="form-control bg-dark text-light" id="emp_id" name="emp_id" value="<?php echo $row['emp_name']; ?>" readonly>
      </div>
     </div>
	<div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputPassword" class="col-sm-2 col-form-label">New password</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="New password" data-validation="strength" data-validation-strength="2">
      </div>
    </div>
    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm password</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" data-validation="confirmation" data-validation-confirm="inputPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">
      </div>
     </div>
	<input type="hidden" name="enc" id="enc" value="">
	<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
	<div class="form-group row">
	  <div class="col-sm-5"></div>
	  <div class="col-sm-2">
	      <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" onclick="return encr();" value="Change password">
	  </div>
	</div>
</form>

<!-- Change password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="changePasswordModalLabel">Are you sure you want to change password of employee <?php echo $emp_id ?>?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Update" To change password
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" name="updatebtn" id="updatebtn" onclick="return submit_form();">Update</button>
          </div>
        </div>
      </div>
    </div>

<script src="sb_admin/js/aes.js"></script>
<script>
  function encr(){
    var pass = document.getElementById("inputPassword").value;
    var hash = CryptoJS.MD5(pass);
    document.getElementById('enc').value = hash;
    return true;
  }
</script>
<?php include("template/footer.php"); ?>