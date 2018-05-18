<?php
	include("class/view.php");
	$from_date=date("Y-m-d");
	$to_date=date("Y-m-d");
	$date_form=null;
	if(isset($_POST['submit'])){
		$date_form=$_POST['daterange'];
		$date=explode(" - ", $date_form);
		$from_date = date("Y-m-d", strtotime($date[0]));
		$to_date = date("Y-m-d", strtotime($date[1]));
	}
	$display = new display();
	$result=$display->app_report($from_date,$to_date);
?>

<?php include('template/header.php');?>

<form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" action="application_report.php">
	<div class="form-group row required">
   <div class="col-sm-1"></div>
    <label for="daterange" class="col-sm-2 col-form-label">Date Range</label>
    <div class="col-sm-6">
     <input type="text" class="form-control" id="daterange" name="daterange" value="<?php echo $date_form; ?>">
     </div>
     <div class="col col-sm-1">
     	<input class="btn btn-primary" type="submit" name="submit">
     </div>
    </div>
</form>


<div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Application tested
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Application name</th>
                    <th>Application type</th>
                    <th>Bug status</th>
                    <th>Bugs found</th>
                    <th>Bugs fixed</th>
                    <th>Tester</th>
                    <th>Developer</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row=mysqli_fetch_assoc($result)){ ?>
                  	<tr>
                  		<td><?php echo $row['app_name']; ?></td>
                  		<td><?php echo $row['app_type']; ?></td>
                  		<td><?php echo $row['status']; ?></td>
                  		<td><?php echo $row['total_bugs']; ?></td>
                  		<td><?php echo ($row['total_bugs']-$row['bug_counter']); ?></td>

                  		<?php $tstr_name=$display->display_table_cndtn("employee","emp_id='{$row['app_tester']}'");
                  		$row_tst=mysqli_fetch_assoc($tstr_name); ?>
                  		<td><?php echo $row_tst['emp_name']; ?></td>

                  		<?php $dev_name=$display->display_table_cndtn("employee","emp_id='{$row['app_dev']}'");
                  		$row_dev=mysqli_fetch_assoc($dev_name); ?>
                  		<td><?php echo $row_dev['emp_name']; ?></td>
                  	</tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<?php include('template/footer.php');?>