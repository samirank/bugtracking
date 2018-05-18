<?php include('template/header.php');
  include('class/view.php');
?>

<?php
$app_id=$_GET['app_id']??null;

$err=$_SESSION['err']??null;
if($err==1){
  $err="<div class='alert alert-success alert-dismissible fade show col-sm-11' role='alert'>Application details updated successfully!
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
}
unset($_SESSION['err']);

$display = new display();
$result =$display->display_table_cndtn("application","app_id='$app_id'");
$row=mysqli_fetch_assoc($result);
?>

 <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a  href="application_list.php">Application list</a></li>
          <li class="breadcrumb-item active">Edit application</li>
        </ol>

        <!-- Form -->
        <form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" id="myform" action='action/update_application.php'>
        <div class="form-group row">
          <?php echo "$err"; ?>
        </div>

      <div class="form-group row">
          <input type="hidden" name="app_id" value="<?php echo $app_id; ?>">
      </div>

      <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="inputAppType" class="col-sm-2 col-form-label">Aplication type</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputAppType" name="inputAppType" placeholder="Application Type" value="<?php echo $row['app_type']; ?>" required="required">
    </div>
    </div>

   <div class="form-group row">
   <div class="col-sm-1"></div>
    <label for="inputAppName" class="col-sm-2 col-form-label">Application name</label>
    <div class="col-sm-6 ">
     <input type="text" class="form-control" id="inputAppName" name="inputAppName" placeholder="Application name" value="<?php echo $row['app_name']; ?>" required="required">
     </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-6">
        <textarea name="inputDescription" required="required" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $row['app_desc']; ?></textarea>
      </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputAccessibility" class="col-sm-2 col-form-label">Accessibility</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputAccessibility" name="inputAccessibility" placeholder="Accessibility" value="<?php echo $row['app_accs']; ?>" required="required">
      </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputAppurl" class="col-sm-2 col-form-label">Application URL</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputAppurl" name="inputAppurl" placeholder="URL" value="<?php echo $row['app_url']; ?>" required="required">
      </div>
    </div>

   <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="inputDev" class="col-sm-2 col-form-label">Developer</label>
    <div class="col-sm-6">
      <select class="form-control" id="inputDev" name="inputDev" data-validation="required" data-validation-error-msg="Please select and option.">
        <option disabled selected value="">Select</option>
        <?php
        $result1=$display->display_table_cndtn("employee","emp_type='Developer'");
        while($row1=mysqli_fetch_assoc($result1)){ ?>
        <option value="<?php echo $row1['emp_id']; ?>" <?php if($row['app_dev']==$row1['emp_id']){ echo 'selected'; } ?>> <?php echo $row1['emp_name']; ?> </option>
        <?php } ?> 
      </select>
      <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the developer</small>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="inputTester" class="col-sm-2 col-form-label">Tester</label>
    <div class="col-sm-6">
      <select class="form-control" id="inputTester" name="inputTester" data-validation="required" data-validation-error-msg="Please select and option.">
        <option disabled selected value="">Select</option>
        <?php
        $result2=$display->display_table_cndtn("employee","emp_type='Tester'");
        while($row2=mysqli_fetch_assoc($result2)){ ?>
        <option value="<?php echo $row2['emp_id']; ?>" <?php if($row['app_tester']==$row2['emp_id']){ echo 'selected'; } ?>> <?php echo $row2['emp_name']; ?> </option>
        <?php } ?> 
      </select>
      <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the assigned tester</small>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="inputUserId" class="col-sm-2 col-form-label">User id</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputUserId" name="inputUserId" placeholder="User id" value="<?php echo $row['test_user_id'] ?>" required="required">
      <small id="inputUserIdhelp" class="form-text text-muted">User id to access the application.</small>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" value="<?php echo $row['test_user_pswd'] ?>" required="required">
      <small id="inputPasswordhelp" class="form-text text-muted">Password to access the application.</small>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="submit" class="col-sm-2 col-form-label"></label>
      <div class="col-sm-3">
        <input type="submit" class="btn-primary form-control" id="submit" name="submit" value="Update">
      </div>
      <div class="col-sm-3">
        <input type="reset" class="btn-danger form-control" id="reset" name="reset" value="reset">
      </div>
    </div>

  </form>

<?php include('template/footer.php'); ?>