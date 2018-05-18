
<?php 
	include('template/header.php');
	include('class/view.php');
	$display 	= new display();
	$utype		= $_SESSION['login_user_type'];
	$uid		= $_SESSION['login_emp_id'];
	$result 	= $display->follow_up_list($utype,$uid);

	$err= $_SESSION['err']??null;
	unset($_SESSION['err']);
 ?>
		<ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Bug follow up</li>
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
            Follow up messages
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Message date</th>
                    <th>Message by</th>
                    <th>Message</th>
                    <th>Bug title</th>
                    <th>Module</th>
                    <th>Application</th>
                    <?php if($_SESSION['login_user_id']!='admin'){ ?>
                    <th>Follow up</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>

                <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <tr>
                	<td><?php echo $row['follow_up_date']; ?></td>

                	<?php $result_sender=$display->display_table_cndtn("employee","emp_id='{$row['msg_by']}'");
                		  $row_sender=mysqli_fetch_assoc($result_sender) ?>
                	<td><?php echo $row_sender['emp_name']; ?></td>

                	<td class="bg-light"><?php echo $row['follow_up_msg']; ?></td>

                	<?php $result_bugname=$display->display_table_cndtn("bug_report","bug_id='{$row['bug_id']}'");
                		  $row_bugname=mysqli_fetch_assoc($result_bugname) ?>
                	<td><a href="view_bug.php?bug_id=<?php echo $row['bug_id']; ?>"><?php echo $row_bugname['bug_title']; ?></a></td>

                	<?php $result_modname=$display->display_table_cndtn("application_module_list","app_mod_id='{$row_bugname['app_mod_id']}'");
                		  $row_modname=mysqli_fetch_assoc($result_modname) ?>
                	<td><a href="view_module_details.php?mod_id=<?php echo $row_bugname['app_mod_id']; ?>"><?php echo $row_modname['app_mod_name']; ?></a></td>

                	<?php $result_appname=$display->display_table_cndtn("application","app_id='{$row_modname['app_id']}'");
                		  $row_appname=mysqli_fetch_assoc($result_appname) ?>
                	<td><a href="view_application.php?app_id=<?php echo $row_appname['app_id']; ?>"><?php echo $row_appname['app_name']; ?></a></td>

                  <?php if($_SESSION['login_user_type']!='admin'){ ?>
                	<td>
		               	<button type="button" class="btn btn-sm btn-primary followupbutton" data-toggle="modal" data-target="#followupmodal" data-id="<?php echo $row['bug_id']; ?>" <?php if($row_bugname['bug_status']=="completed"){echo 'disabled';} ?>>Respond</button>
		           	  </td>
                  <?php } ?>

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