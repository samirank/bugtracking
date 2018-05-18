<?php 	
include('template/header.php');
include('class/view.php');
$display=new display();
$result	=$display->edit_account($_SESSION['login_emp_id']);
$row=mysqli_fetch_assoc($result);

$err=$_SESSION['err']??null;
?>

	<form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" action='action/edit_account_action.php'>
    	<div class="form-group row">
        	<div class="col-sm-3"></div>
      		<?php echo "$err"; ?>
      	</div>
    <div class="form-group row">
	    <div class="col-sm-1"></div>
	    	<label for="inputName" class="col-sm-2 col-form-label">Employee ID</label>
		    <div class="col-sm-6">
		      <input disabled type="text" class="form-control" id="inputName" name="inputName" data-validation="required custom" data-validation-regexp="^([A-Za-z ]+)$" data-sanitize="trim upper" placeholder="Employee ID" value="<?php echo $row['emp_id']; ?>" required="required">
	    </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-1"></div>
      <label for="accountType" class="col-sm-2 col-form-label">Role</label>
      <div class="col-sm-6 ">
      <select class="form-control" id="accountType" name="accountType" disabled>
        <option <?php if($row['emp_type']=='Developer') echo "selected"; ?>>Developer</option>
        <option <?php if($row['emp_type']=='Tester') echo "selected"; ?>>Tester</option>
        <option <?php if($_SESSION['login_user_type']=='admin') echo "selected"; ?>>Admin</option>
      </select>
      </div>
  </div>
   <div class="form-group row">
   <div class="col-sm-1"></div>
    <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
    <div class="col-sm-6 ">
     <input disabled type="text" class="form-control" id="inputUsername" name="inputUsername" data-validation="required alphanumeric" data-validation-allowing="_" value='<?php echo $row['user_id'];?>' required="required">
     </div>
    </div>
   
    <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-6">
      <input disabled type="text" class="form-control" id="name" name="name" data-validation="required custom" data-validation-regexp="^([A-Za-z ]+)$" data-sanitize="trim upper" placeholder="Name" value="<?php echo $row['emp_name']; ?>" required="required">
    </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-6">
        <input disabled type="email" class="form-control" id="inputEmail" name="inputEmail" data-validation="required email" placeholder="Email" value="<?php echo $row['email_id'];?>" required="required">
      </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputContact" class="col-sm-2 col-form-label">Contact Number</label>
      <div class="col-sm-6">
        <input disabled type="text" class="form-control" id="inputContact" name="inputContact" data-validation="required number" placeholder="Contact" value="<?php echo $row['emp_cntct']?>" required="required">
      </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputDOJ" class="col-sm-2 col-form-label">Date of joining</label>
      <div class="col-sm-6">
        <input disabled type="text" class="form-control" id="inputDOJ" name="inputDOJ" placeholder="Date of joining" value="<?php echo $row['doj']?>" required="required">
      </div>
    </div>

    <div class="form-group row">
    	<dir class="col-sm-3"></dir>
    	<div class="col-sm-6"><a href="edit_account.php?emp_id=<?php echo $_SESSION['login_emp_id']; ?>" class="btn btn-primary btn-large btn-block">Edit account</a></div>
    </div>
  </form>

<?php include('template/footer.php'); ?>