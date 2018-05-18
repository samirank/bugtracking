<?php include('template/header.php');
      include('class/view.php');
?>
<?php
$err=$_GET['err']??null;
if($err){
  $err="<div class='col-sm-6 text-success'><b>Application added successfully</b></div>";
}

$view=new display();
?>
      
<form action="action/new_application.php" method="POST">
      <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
          <?php echo "$err"; ?>
        </div>
      </div>

      <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputName" class="col-sm-2 col-form-label">Aplication type</label>
    <div class="col-sm-6">
      <select class="form-control" id="inputAppType" name="inputAppType" data-validation="required" data-validation-error-msg="Please select an option.">
        <option disabled selected value="">Select</option>
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
        <option value="SaaS">SaaS</option>
        <option value="Remote">Remote</option>
        <option value="ERP">ERP</option>
      </select>
    </div>
    </div>

   <div class="form-group row required">
   <div class="col-sm-1"></div>
    <label for="inputAppName" class="col-sm-2 col-form-label">Application name</label>
    <div class="col-sm-6 ">
     <input type="text" class="form-control" id="inputAppName" data-validation="required custom" data-validation-regexp="^([A-Za-z ]+)$" data-sanitize="trim" name="inputAppName" placeholder="Application name" required="required">
     </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-6">
        <textarea name="inputDescription" required="required" data-validation="required" data-sanitize="trim" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" ></textarea>
      </div>
    </div>

     <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputAccessibility" class="col-sm-2 col-form-label">Accessibility</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputAccessibility" name="inputAccessibility" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" placeholder="Accessibility" required="required">
      </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputAppurl" class="col-sm-2 col-form-label">Application URL</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputAppurl" name="inputAppurl" data-validation="url" placeholder="URL">
      </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputDev" class="col-sm-2 col-form-label">Developer</label>
    <div class="col-sm-6">
      <select class="form-control" id="inputDev" name="inputDev" data-validation="required" data-validation-error-msg="Please select an option.">
        <option disabled selected value="">Select</option>
        <?php
        $result=$view->display_table_cndtn("employee","emp_type='Developer'");
        while($row=mysqli_fetch_assoc($result)){ ?>
        <option value="<?php echo $row['emp_id']; ?>"> <?php echo $row['emp_name']; ?> </option>
        <?php } ?> 
      </select>
      <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the developer</small>
    </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputTester" class="col-sm-2 col-form-label">Tester</label>
    <div class="col-sm-6">
      <select class="form-control" id="inputTester" name="inputTester" data-validation="required" data-validation-error-msg="Please select an option.">
        <option disabled selected value="">Select</option>
        <?php
        $result=$view->display_table_cndtn("employee","emp_type='Tester'");
        while($row=mysqli_fetch_assoc($result)){ ?>
        <option value="<?php echo $row['emp_id']; ?>"> <?php echo $row['emp_name']; ?> </option>
        <?php } ?> 
      </select>
      <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the assigned tester</small>
    </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputUserId" class="col-sm-2 col-form-label">User id</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputUserId" name="inputUserId" placeholder="User id">
      <small id="inputUserIdhelp" class="form-text text-muted">User id to access the application.</small>
    </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
      <small id="inputPasswordhelp" class="form-text text-muted">Password to access the application.</small>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="submit" class="col-sm-2 col-form-label"></label>
      <div class="col-sm-3">
        <input type="submit" class="btn-primary form-control" id="submit" data-validation="required alphanumeric" data-validation-allowing="_" name="submit" value="submit">
      </div>
      <div class="col-sm-3">
        <input type="reset" class="btn-danger form-control" id="reset" name="reset" value="reset">
      </div>
    </div>

  </form>

<script type="text/javascript">  $.validate(); </script>
<?php include('template/footer.php'); ?>