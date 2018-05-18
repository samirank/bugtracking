<?php include('template/header.php');?>
<?php
if(isset($_GET['emp_id'])&&$_SESSION['login_user_type']=="admin"){
$emp_id=$_GET['emp_id'];
}else{
$emp_id=$_SESSION['login_emp_id'];
}
$err=$_SESSION['err']??null;
if($err=='1'){
$err="<div class='col-sm-6 text-success'><b>Account modified successfully</b></div>";
}else if($err){
$err="<div class='col-sm-6 text-danger'><b>".$err."</b></div>";
$emp_id=$_SESSION['emp_id']??null;
}
unset($_SESSION['err']);
include('class/view.php');
$display= new display();
$val=$display->edit_account($emp_id);
$val=mysqli_fetch_assoc($val);
$json = json_encode(array('emp_id'=>$emp_id));
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard
    </a>
  </li>
  <?php if($_SESSION['login_user_type']=='admin'){ ?>
  <li class="breadcrumb-item">
    <a href="user_accounts.php">User Accounts
    </a>
  </li>
  <?php } ?>
  <li class="breadcrumb-item active">Edit Account
  </li>
</ol>
<!-- Form -->
<form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" action='action/edit_account_action.php'>
  <?php if($_SESSION['login_user_type']=='admin'){ ?>
  <div class="form-group row">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-3">
      <button type="button" class="btn btn-info btn-block" onclick="window.location.href = 'action/block_account.php?emp_id=<?php echo $emp_id; ?>'">Block account
      </button>
    </div>
    <div class="col-sm-3">
      <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteAccountModal">Delete account
      </button>
    </div>
  </div>
  <?php } ?>
  <div class="form-group row">
    <div class="col-sm-3">
    </div>
    <?php echo "$err"; ?>
  </div>
  <div class="form-group row">
    <div class="col-sm-3">
    </div>
    <input type="hidden" name="emp_id" value="<?php echo $val['emp_id']; ?>">
  </div>
  <?php if($_SESSION['login_user_type']=='admin'){ ?>
  <div class="form-group row">
    <div class="col-sm-1">
    </div>
    <label for="accountType" class="col-sm-2 col-form-label">Role
    </label>
    <div class="col-sm-6 ">
      <select class="form-control" id="accountType" name="accountType">
        <option 
                <?php if($val['emp_type']=='Developer') echo "selected"; ?>>Developer
        </option>
      <option 
              <?php if($val['emp_type']=='Tester') echo "selected"; ?>>Tester
      </option>
    </select>
  </div>
</div>
<?php } ?>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputUsername" class="col-sm-2 col-form-label">Username
  </label>
  <div class="col-sm-6 ">
    <input type="text" class="form-control" id="inputUsername" name="inputUsername" data-validation="required alphanumeric" data-validation-allowing="_" placeholder="Username" value='<?php echo $val['user_id'];?>' required="required">
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputName" class="col-sm-2 col-form-label">Name
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="name" name="name" data-validation="required custom" data-validation-regexp="^([A-Za-z ]+)$" data-sanitize="trim upper" placeholder="Name" value="<?php echo $val['emp_name']; ?>" required="required">
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputEmail" class="col-sm-2 col-form-label">Email
  </label>
  <div class="col-sm-6">
    <input type="email" class="form-control" id="inputEmail" name="inputEmail" data-validation="required email" placeholder="Email" value="<?php echo $val['email_id'];?>" required="required">
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputContact" class="col-sm-2 col-form-label">Contact Number
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="inputContact" name="inputContact" data-validation="required number" placeholder="Contact" value="<?php echo $val['emp_cntct']?>" required="required">
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="submit" class="col-sm-2 col-form-label">
  </label>
  <div class="col-sm-3">
    <input type="submit" class="btn-primary form-control" id="submit" name="submit" value="Update">
  </div>
  </form>
<div class="col-sm-3">
  <button type="button" class="btn btn-info btn-block" onclick="window.location.href = 'change_password.php?emp_id=<?php echo $emp_id; ?>'">Change password
  </button>
</div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteAccountModalLabel">Are you sure you want to delete this account?
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        Select "Delete" To delete the account permanently
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
        </button>
        <a class="btn btn-primary" href="action/delete.php?<?php echo $emp_id; ?>">Delete
        </a>
      </div>
    </div>
  </div>
</div>
<script>  $.validate();
</script>
<?php include('template/footer.php');?>
