<?php 	include('template/header.php');
		include('class/view.php');
    	$display = new display();
      if($_SESSION['login_user_type']=="Tester"){
        $result =  $display->display_table_cndtn('application',"app_tester='{$_SESSION['login_emp_id']}'");
      }
      else if($_SESSION['login_user_type']=="Developer"){
        $result =  $display->display_table_cndtn('application',"app_dev='{$_SESSION['login_emp_id']}'"); 
      }
      else if($_SESSION['login_user_type']=="admin"){
        $result =  $display->display_table('application');
      }
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">View application modules</li>
</ol>

<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i>
    List of application
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
        <thead>
          <tr>
            <th>Application id</th>
            <th>Application name</th>
            <th>Added on</th>
            <th>Developer</th>
            <th>Tester</th>
            <th>View modules</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($result)){ ?>
          	<tr>
          		<td><?php echo $row['app_id']; ?></td>
          		<td><?php echo $row['app_name']; ?></td>
          		<td><?php echo $row['added_on']; ?></td>

          		<?php $result1 = $display->display_table_cndtn("employee","emp_id='{$row['app_dev']}'"); 
          			  $row1=mysqli_fetch_assoc($result1); ?>
          		<td><?php echo $row1['emp_name']; ?></td>


          		<?php $result2 = $display->display_table_cndtn("employee","emp_id='{$row['app_tester']}'"); 
          			  $row2=mysqli_fetch_assoc($result2); ?>
          		<td><?php echo $row2['emp_name']; ?></td>
          		<td>
          			<a href='view_module_list.php?app_id=<?php echo $row['app_id']; ?>'><button type='button' class='btn btn-info btn-sm col-sm-10'>View modules</button></a>
          		</td>	
          	</tr>	
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include('template/footer.php'); ?>