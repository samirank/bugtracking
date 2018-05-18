<?php include('template/header.php');
	  include('class/view.php');

	  $app_id=$_GET['app_id']??null;

	  $display=new display();
	  $result=$display->display_table_cndtn("application_module_list","app_id='$app_id'");
 ?>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item"><a href="view_application_module.php">View application modules</a></li>
  <li class="breadcrumb-item active">Module list</li>
</ol>

<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i>
    List of modules
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
        <thead>
          <tr>
            <th>Module id</th>
            <th>Module name</th>
            <th>Last Updated on</th>
            <th>App name</th>
            <th>Bug Status</th>
            <th>View</th>
            <?php if($_SESSION['login_user_type']=="admin"){ ?>
            <th>Edit</th>
            <th>Delete</th>
            <?php } ?>
            <?php if($_SESSION['login_user_type']=="Tester"){ ?>
            <th>Bug update</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($result)){ ?>
          	<tr>
          		<td><?php echo $row['app_mod_id']; ?></td>
          		<td><?php echo $row['app_mod_name']; ?></td>
          		<td><?php echo $row['last_updated']; ?></td>

          		<?php $result1 = $display->display_table_cndtn("application","app_id='$app_id'"); 
          			  $row1=mysqli_fetch_assoc($result1); ?>
          		<td><?php echo $row1['app_name']; ?></td>

          		<td><?php if($row['bug_status']==null){echo "N/A";}else{echo $row['bug_status'];} ?></td>

          		<td>
          			<a href='view_module_details.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-primary btn-sm col-sm-10'>View details</button></a>
          		</td>
          		<?php if($_SESSION['login_user_type']=="admin"){ ?>
              <td>
                <a href='edit_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-info btn-sm col-sm-10'>Edit</button></a>
              </td>
              <td>
                <a href='delete_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-danger btn-sm col-sm-10'>Delete</button></a>
              </td>
              <?php } ?>
              <?php if($_SESSION['login_user_type']=="Tester"){ ?>
              <td>
                <a href='update_bug.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-primary btn-sm col-sm-10'>New bug</button></a>
              </td>
              <?php } ?>
          	</tr>	
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('template/footer.php'); ?>