<?php include('template/header.php');
      include('class/view.php');
      $display=new display();
?>
<?php

$mod_id=$_GET['mod_id']??null;
if(isset($_GET['app_id'])){
  $app_id=$_GET['app_id'];
}else{
if(isset($_GET['mod_id'])){
  $result_app=$display->display_table_cndtn("application_module_list","app_mod_id='{$_GET['mod_id']}'");
  $row_app=mysqli_fetch_assoc($result_app);
  $app_id=$row_app['app_id'];
}else{
  die("Application module details not found");
}
}
$result=$display->display_table_cndtn("application_module_list","app_id='$app_id'");

$err=$_SESSION['err']??null;
unset($_SESSION['err']);
if($err==1){
  $err="<div class='alert alert-success alert-dismissible fade show col-sm-11' role='alert'>Bug updated successfully!
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
}
?>
<form class="bg-light h-100 mt-4 pl-5 pt-3" id="myform" method="POST" action="action/new_bug.php" enctype="multipart/form-data">
    <div class="form-group row">
      <?php echo "$err"; ?>
    </div>
    
		<div class="form-group row">
      	<div class="col-sm-3"></div>
     		<input type="hidden" name="inputAppid" value="<?php echo $app_id; ?>">
    </div>

    <div class="form-group row required">
      <div class="col-sm-1"></div>
      <label for="inputModId" class="col-sm-2 col-form-label"> Select Module</label>
      <div class="col-sm-6">
        <select <?php if($mod_id){echo "disabled";} ?> class="form-control" id="inputModId" name="inputModId" data-validation="required" data-validation-error-msg="Please select and option.">
        <option disabled selected value="">Select</option>
        <?php while($row=mysqli_fetch_assoc($result)){ ?>
          <option <?php if($row['app_mod_id']==$mod_id){echo "selected";} ?> value="<?php echo $row['app_mod_id']; ?>"><?php echo $row['app_mod_name']; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

 	<div class="form-group row required">
    <div class="col-sm-1"></div>
	    <label for="inputBugTitle" class="col-sm-2 col-form-label">Bug Title</label>
	    <div class="col-sm-6 ">
	     <input type="text" class="form-control" id="inputBugTitle" name="inputBugTitle" data-validation="required alphanumeric"  data-validation-allowing="_ " placeholder="Bug Title" required="required">
    </div>
  </div>

  <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-6">
        <textarea name="inputDescription" required="required" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" data-validation="required"></textarea>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="inputUrl" class="col-sm-2 col-form-label">Bug URL</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="inputUrl" name="inputUrl" data-validation="url" placeholder="URL">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="appearedOn" class="col-sm-2 col-form-label">Bug appeared on</label>
      <div class="col-sm-6">
        <input type="date" class="form-control" id="appearedOn" name="appearedOn" data-validation="date" placeholder="Date">
      </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-1"></div>
    <label for="  " class="col-sm-2 col-form-label">Bug screenshot</label>
    <div class="col-sm-6">
        <input type="file" data-validation="required" class="form-control" name="inputFile" id="inputFile">
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
<?php include('template/footer.php');?>