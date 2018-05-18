<?php include('template/header.php');
	include('class/view.php');
	$display = new display();
  $utype  =$_SESSION['login_user_type'];
  $uid    =$_SESSION['login_emp_id'];
	$result  = $display->display_bug_list($utype,$uid);

	$err= $_SESSION['err']??null;
	unset($_SESSION['err']);
 ?>
 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Bugs list</li>
</ol>
<?php if($err){ ?>
<div class='alert alert-success alert-dismissible fade show col-sm-12' role='alert'><?php echo $err; ?>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
<?php } ?>
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
            <th>Module</th>
            <th>Application</th>
            <th>Last update</th>
           	<?php if($_SESSION['login_user_type']!="admin"){ ?>
            <th>Follow up</th>
            <?php } ?>
           	<th></th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
              <td class="<?php if($row['bug_status']=='completed'){echo 'text-success';}else if($row['bug_status']=='resolving'||$row['bug_status']=='resolved'){echo 'text-warning';}else{echo 'text-danger';} ?>"><?php echo $row['bug_title']; ?></td>
              <td><?php echo $row['bug_appeared_on']; ?></td>
              <td><?php echo $row['bug_status']; ?></td>

              <?php $result_mod=$display->display_table_cndtn("application_module_list","app_mod_id='{$row['app_mod_id']}'");
              $row_mod=mysqli_fetch_assoc($result_mod); ?>
              <td><?php echo $row_mod['app_mod_name']; ?></td>

               <?php $result_app=$display->display_table_cndtn("application","app_id='{$row_mod['app_id']}'");
              $row_app=mysqli_fetch_assoc($result_app); ?>
              <td><?php echo $row_app['app_name']; ?></td>

              <td><?php echo $row['last_updated_on']; ?></td>

              <?php if($_SESSION['login_user_type']!="admin"){ ?>
              <td>
                <button type="button" class="btn btn-sm btn-primary followupbutton" data-toggle="modal" data-target="#followupmodal" data-id="<?php echo $row['bug_id']; ?>">Follow up msg</button>
              </td>
              <?php } ?>
              
              <td>
                  <button class="btn btn-primary btn-sm"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.location.href = 'view_bug.php?bug_id=<?php echo $row['bug_id']; ?>'">
                    View bug
                  </button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


	<!-- Follow up Modal -->
    <div class="modal fade" id="followupmodal" tabindex="-1" role="dialog" aria-labelledby="followupmodalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="followupmodalLabel">Write the follow up message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <form class="bg-light h-100 pt-3" method="POST" action='action/new_follow_up.php'>
             	<div class="form-group required">
             		<input type="hidden" name="hiddenValue" id="hiddenValue" value="" />
             		<input type="hidden" name="page_name" value="<?php echo $_SERVER['PHP_SELF']; ?>">
			        <textarea name="inputMessage" required="required" placeholder="Follow up message" class="form-control" rows="3" data-validation="required" ></textarea>
                <?php if($utype=="Developer"){ ?>
                Select Bug Status:
                <select name="inputBugStatus">
                  <option selected disabled>Select</option>
                  <option value="resolving">Resolving</option>
                  <option value="resolved">Resolved</option>
                </select>
                <?php } ?>
			    </div>
             
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input class="btn btn-primary" type="submit" name="submit" value="submit">
          </div>
          </form>
        </div>
      </div>
    </div>

<?php include('template/footer.php'); ?>