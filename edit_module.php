<?php include('template/header.php');
	  include('class/view.php');
	  $mod_id=$_GET['mod_id']??$_SESSION['mod_id'];
	  unset($_SESSION['mod_id']);
	  $display=new display();
	  $result=$display->display_table_cndtn("application_module_list","app_mod_id='$mod_id'");
	  $row=mysqli_fetch_assoc($result);
	  $err=$_GET['err']??null;
 ?>

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="application_list.php">Applications</a></li>
          <li class="breadcrumb-item active">Add Module</li>
        </ol>

        <!-- Form -->
        <form class="bg-light h-100 mt-4 pl-5 pt-3" id="myform" method="POST" action='action/update_module.php' enctype="multipart/form-data">
        <div class="form-group row">
        <div class="col-sm-3"></div>
      <?php echo "$err"; ?>
      </div>
    
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <input type="hidden" name="inputModId" value="<?php echo $mod_id; ?>">
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputModuleName" class="col-sm-2 col-form-label">Module name</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputModuleName" name="inputModuleName" placeholder="Module name" value="<?php echo $row['app_mod_name'] ?>" required="required" data-validation="required custom" data-validation-regexp="^([A-Za-z0-9_ ]+)$" data-sanitize="trim">
    </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-6">
        <textarea name="inputDescription" required="required" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" data-validation="required"><?php echo $row['app_mod_desc']; ?></textarea>
      </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="  " class="col-sm-2 col-form-label">Test Data</label>
      <div class="col-sm-6">
      	<a href="<?php echo $row['test_data']; ?>"><img src="<?php echo $row['test_data']; ?>"></a>
        <input type="file" class="form-control" name="inputFile" id="inputFile">
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

<?php include('template/footer.php');?>