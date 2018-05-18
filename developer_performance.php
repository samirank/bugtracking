<?php
include("class/view.php");
$from_date=date("Y-m-d");
$to_date=date("Y-m-d");
$date_form=null;
$tested=0;
$testing=0;
$totest=0;
$bugs_found=0;
$display = new display();
if(isset($_POST['submit'])){
$date_form=$_POST['daterange'];
$date=explode(" - ", $date_form);
$from_date = date("Y-m-d", strtotime($date[0]));
$to_date = date("Y-m-d", strtotime($date[1]));
$report_result=$display->developer_performance($from_date,$to_date,$_POST['inputDev']);
}
?>
<?php include('template/header.php');?>
<form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" action="developer_performance.php">
  <div class="form-group row required">
    <div class="col-sm-1">
    </div>
    <label for="daterange" class="col-sm-2 col-form-label">Date Range
    </label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="daterange" name="daterange" value="<?php echo $date_form; ?>">
    </div>
    <div class="col col-sm-1">
      <input class="btn btn-primary" type="submit" name="submit">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-1">
    </div>
    <label for="inputDev" class="col-sm-2 col-form-label">
    </label>
    <div class="col-sm-6">
      <select class="form-control" id="inputDev" name="inputDev" data-validation="required" data-validation-error-msg="Please select an option.">
        <option disabled selected value="">Select developer
        </option>
        <option value="all" <?php if($_POST['inputDev']=='all'){echo 'selected';} ?>>All developer
        </option>
        <?php $result=$display->display_table_cndtn("employee","emp_type IN ('Developer')"); 
while($row=mysqli_fetch_assoc($result)){
$result2=$display->display_table_cndtn("users","emp_id={$row['emp_id']}");
$row_uid=mysqli_fetch_assoc($result2)
?>
        <option value="<?php echo $row['emp_id']; ?>" <?php if($row['emp_id']==$_POST['inputDev']){echo 'selected';} ?>>
          <?php echo $row['emp_name']; ?> (
          <?php echo $row_uid['user_id']; ?>)
        </option>
        <?php } ?>
      </select>
    </div>
  </div>
</form>
<?php if(isset($_POST['submit'])){ ?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table">
    </i>
    Application tested
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
        <thead>
          <tr>
            <th>Application name
            </th>
            <th>Application status
            </th>
            <th>Developer
            </th>
            <th>Bug counter
            </th>
            <th>Total Bugs
            </th>
            <th>Bugs fixed
            </th>
          </tr>
        </thead>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($report_result)){ ?>
          <tr>
            <td>
              <?php echo $row['app_name']; ?>
            </td>
            <td>
              <?php echo $row['status']; ?>
            </td>
            <?php $developer_name=$display->display_table_cndtn("employee","emp_id={$row['app_developer']}");
$developer_name=mysqli_fetch_assoc($developer_name); ?>
            <td>
              <?php echo $developer_name['emp_name']; ?>
            </td>
            <td>
              <?php echo $row['bug_counter']; ?>
            </td>
            <td>
              <?php echo $row['total_bugs']; ?>
            </td>
            <td>
              <?php echo $row['bugs_resolved']; ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php } ?>
<?php } ?>
<?php include('template/footer.php');?>