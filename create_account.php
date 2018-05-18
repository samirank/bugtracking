<?php include('template/header.php');?>

<?php
$accountType =$_SESSION['accountType']??null;
$inputUsername =$_SESSION['inputUsername']??null;
$inputFirstName=$_SESSION['inputFirstName']??null;
$inputLastName=$_SESSION['inputLastName']??null;
$inputEmail=$_SESSION['inputEmail']??null;
$inputContact=$_SESSION['inputContact']??null;
unset($_SESSION['accountType'], $_SESSION['inputUsername'], $_SESSION['inputFirstName'],$_SESSION['inputLastName'], $_SESSION['inputEmail'], $_SESSION['inputContact']);

$err = $_GET['err']??null;
if($err){
  if(!is_numeric($err)){
    $err= "<div class='col-sm-6 text-danger'><b>$err.</b></div>";
  }
  else{
  $err= "<div class='col-sm-6 text-success'><b>Account created successfully. Employee id is ".$err."</b></div>";
  }
}
?>

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">User Accounts</li>
        </ol>

        <!-- Form -->
        <form class="bg-light h-100 mt-4 pl-5 pt-3" id="myform" method="POST" action='action/new_account.php'>
        <div class="form-group row">
        <div class="col-sm-3"></div>
      <?php echo "$err"; ?>
      </div>
    <div class="form-group row required">
      <div class="col-sm-1"></div>
      <label for="accountType" class="col-sm-2
       col-form-label">Account type</label>
      <div class="col-sm-6 ">
      <select class="form-control" id="accountType" name="accountType" data-validation="required" data-validation-error-msg="Please select and option.">
        <option disabled <?php if(empty($accountType)) echo "selected"; ?> required="required" value="">Select</option>
        <option <?php if($accountType=='Developer') echo "selected"; ?>>Developer</option>
        <option <?php if($accountType=='Tester') echo "selected"; ?>>Tester</option>
      </select>
      </div>
  </div>
   <div class="form-group row required">
   <div class="col-sm-1"></div>
    <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
    <div class="col-sm-6 ">
     <input type="text" class="form-control" id="inputUsername" name="inputUsername" data-validation="required alphanumeric server" data-validation-url="action/form_data_validate.php"  data-validation-allowing="_" <?php if($inputUsername) echo "value='$inputUsername'";else echo "placeholder='Username'"; ?> required="required">
     </div>
    </div>
   
    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="First name" value="<?php echo $inputFirstName ?>" required="required" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" data-sanitize="trim upper">
    </div>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Last name" value="<?php echo $inputLastName ?>" required="required" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" data-sanitize="trim upper">
    </div>
    </div>

     <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="inputEmail" data-validation="email"  name="inputEmail" placeholder="Email" value="<?php echo $inputEmail ?>" required="required">
      </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputContact" class="col-sm-2 col-form-label">Contact Number</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputContact" data-validation="number" name="inputContact" placeholder="Contact" value="<?php echo $inputContact ?>" required="required">
      </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-6">
        <small style="color:green" id='result' class="form-text"></small>
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" data-validation="strength" data-validation-strength="2">
      </div>
    </div>
    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm password</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" data-validation="confirmation" data-validation-confirm="inputPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">

      </div>
    </div>
    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="submit" class="col-sm-2 col-form-label"></label>
      <div class="col-sm-3">
        <input type="submit" class="btn-primary form-control" id="submit" name="submit" value="submit">
      </div>
      <div class="col-sm-3">
        <input type="reset" class="btn-danger form-control" id="reset" name="reset" value="reset">
      </div>
    </div>
  </form>

  <script type="text/javascript">  $.validate(); </script>
  <script type="text/javascript">  $.passwordStrengthMeter(); </script>

<?php include('template/footer.php');?>