<?php include('template/header.php');
    include('class/view.php');

    $mod_id=$_GET['mod_id']??null;

    $display=new display();
    $result=$display->display_table_cndtn("application_module_list","app_mod_id='$mod_id'");
    $row=mysqli_fetch_assoc($result);
 ?>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item"><a href="view_application_module.php">View application modules</a></li>
  <li class="breadcrumb-item"><a href="view_module_list.php?app_id=<?php echo $row['app_id']; ?>">Module list</a></li>
  <li class="breadcrumb-item active">Module details</li>
</ol>


<nav class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-expanded="true">Module details</a>
  <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile">List of bugs</a>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<!--Module details starts-->
  <div class="card mb-3">
    <div class="card-body">
    <div class="row">
      <div class="table-responsive table-hover col-sm-6">
        <table class="table table-bordered align-self" width="100%" id="dataTable" cellspacing="0">
          
          <tbody>
            	<tr>
                <th>Module id:</th>
            		<td><?php echo $row['app_mod_id']; ?></td>
              </tr>
              <tr>
                <th>Module name:</th>
                <td><?php echo $row['app_mod_name']; ?></td>
              </tr>
              <tr>
                <th>Module description:</th>
                <td><?php echo $row['app_mod_desc']; ?></td>
              </tr>
              <tr>
                <th>Application name:</th>
                <?php $result1 = $display->display_table_cndtn("application","app_id='{$row['app_id']}'"); 
                    $row1=mysqli_fetch_assoc($result1); ?>
                <td><?php echo $row1['app_name']; ?></td>
              </tr>
              <tr>
                <th>Bug Status</th>
                <td><?php if($row['bug_status']==null){echo "N/A";}else{echo $row['bug_status'];} ?></td>
              </tr>
              <tr>
                <th>Last updated on</th>
                <td><?php echo $row['last_updated']; ?></td>
              </tr>
              <?php if($_SESSION['login_user_type']=="admin"){ ?>
              <tr>
                <td><a href='edit_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-info btn-sm col-sm-10'>Edit</button></a></td>
                <td><a href='delete_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-danger btn-sm col-sm-10'>Delete</button></a></td>
              </tr>
              <?php } ?>
              </tbody
          </tbody>
        </table>
      </div>
      <div class="card-body float-right col-sm-6">
        <div class="row"><span>Module files: </span></div>
        <div class="row"><a href="<?php echo $row['test_data']; ?>"><img class="img-fluid" src="<?php echo $row['test_data']; ?>"></a></div>
      </div>
      </div>
    </div>
  </div>
  <!--Module details ends-->

  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <!--Bugs list starts-->
  <?php $result_bug=$display->display_table_cndtn("bug_report","app_mod_id='$mod_id'"); ?>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            List of bugs
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Bug title</th>
                    <th>Appeared on</th>
                    <th>Status</th>
                    <th>Tester</th>
                    <th>Last update</th>
                    <th>View</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row_bug = mysqli_fetch_assoc($result_bug)){ ?>
                    <tr>
                      <td><?php echo $row_bug['bug_title']; ?></td>
                      <td><?php echo $row_bug['bug_appeared_on']; ?></td>
                      <td><?php echo $row_bug['bug_status']; ?></td>

                      <?php $result_tester=$display->display_table_cndtn("employee","emp_id='{$row_bug['tested_by']}'");
                      		$row_tester=mysqli_fetch_assoc($result_tester); ?>
                      <td><?php echo $row_tester['emp_name']; ?></td>
                      <td><?php echo $row_bug['last_updated_on']; ?></td>

                      <td>
                          <button class="btn btn-primary"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.location.href = 'view_bug.php?bug_id=<?php echo $row_bug['bug_id']; ?>'">
                            View details
                          </button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
  <!--Bugs list ends-->
  </div>
</div>

<?php include('template/footer.php'); ?>