<?php include('template/header.php');?>

<?php

$inputModuleName  =$_SESSION['inputModuleName']??null;
$inputDescription =$_SESSION['inputDescription']??null;
$inputAppid =$_SESSION['inputAppid']??null;
unset($_SESSION['inputModuleName'],$_SESSION['inputDescription'],$_SESSION['inputAppid']);


if(empty($inputAppid)){
  $inputAppid = $_GET['app_id']??null;
}

$err = $_GET['err']??null;
if($err){
  $err= "<div class='col-sm-6 text-success'><b>Module added successfully</b></div>";
}
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
        <form class="bg-light h-100 mt-4 pl-5 pt-3" id="myform" method="POST" action='action/new_module.php' enctype="multipart/form-data">
        <div class="form-group row">
        <div class="col-sm-3"></div>
      <?php echo "$err"; ?>
      </div>
    
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <input type="hidden" name="inputAppid" value="<?php echo $inputAppid; ?>">
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
    <label for="inputModuleName" class="col-sm-2 col-form-label">Module name</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputModuleName" name="inputModuleName" placeholder="Module name" value="<?php echo $inputModuleName ?>" required="required" data-validation="required custom" data-validation-regexp="^([A-Za-z0-9_ ]+)$" data-sanitize="trim">
    </div>
    </div>

    <div class="form-group row required">
    <div class="col-sm-1"></div>
      <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-6">
        <textarea name="inputDescription" required="required" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" data-validation="required" value="<?php echo $inputDescription; ?>" ></textarea>
      </div>
    </div>

     <div class="form-group row">
    <div class="col-sm-1"></div>
      <label for="  " class="col-sm-2 col-form-label">Test Data</label>
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

  <script type="text/javascript">  $.validate(); </script>
  <script type="text/javascript">  $.passwordStrengthMeter(); </script>

<?php include('template/footer.php');?>