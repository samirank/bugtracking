<?php include('template/header.php'); ?>
<?php include('class/view.php');
    $bug_id=$_GET['bug_id'];
    $display=new display();
    $result=$display->display_table_cndtn("bug_report","bug_id='$bug_id'");
    $row=mysqli_fetch_assoc($result);

    $utype    = $_SESSION['login_user_type'];
    $uid    = $_SESSION['login_emp_id'];
    $result_buglist   = $display->follow_up_list($utype,$uid);


    $err= $_SESSION['err']??null;
    unset($_SESSION['err']);
 ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item"><a href="view_bug_list.php">View bug list</a></li>
  <li class="breadcrumb-item active">Bug details</li>
</ol>

<?php if($err){ ?>
  <div class='alert alert-info alert-dismissible fade show col-sm-12' role='alert'><?php echo $err; ?>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>
<?php } ?>


<nav class="nav nav-pills nav-justified" id="myTab" role="tablist">
  <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-expanded="true">Bug details</a>
  <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile">Follow up details</a>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<!--Module details starts-->
<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="table-responsive table-hover col-sm-6">
        <table class="table table-bordered align-self">
          <tbody>
            <tr>
              <th>Change bug status</th>
              <td>
                <form action="action/update_bug_status.php" method="POST">
                  <input type="hidden" name="bug_id" value="<?php echo $row['bug_id']; ?>">
                  <select name="inputBugStatus">
                    <?php if($_SESSION['login_user_type']=="Developer"){ ?>
                    <option value="resolving"><?php echo "Resolvng"; ?></option>
                    <option value="resolved"><?php echo "Resolved"; ?></option>
                    <?php }else{ ?>
                    <option value="active"><?php echo "Active"; ?></option>
                    <option value="completed"><?php echo "Completed"; ?></option>
                    <?php } ?>
                  </select>
                  <input type="submit" name="submit" id="submit_bug_status" value="change">
                </form>
              </td>
            </tr>

            <tr>
                <th>Bug id:</th>
                <td><?php echo $row['bug_id']; ?></td>
              </tr>
              <tr>
                <th>Bug title:</th>
                <td><?php echo $row['bug_title']; ?></td>
              </tr>
              <tr>
                <th>Bug description:</th>
                <td><?php echo $row['bug_desc']; ?></td>
              </tr>

              <tr>
                <th>Bug URL</th>
                <td><?php echo $row['bug_url']; ?></td>
              </tr>

              <tr>
                <th>Module name:</th>
                <?php $result_mod= $display->display_table_cndtn("application_module_list","app_mod_id='{$row['app_mod_id']}'");
                    $row_mod=mysqli_fetch_assoc($result_mod); ?>
                <td><?php echo $row_mod['app_mod_name']; ?></td>
              </tr>

              <tr>
                <th>Appeared on:</th>
                <td><?php echo $row['bug_appeared_on']; ?></td>
              </tr>

              <tr>
                <th>Bug status:</th>
                <td><?php echo $row['bug_status']; ?></td>
              </tr>

              <tr>
                <th>Tested by:</th>
                <?php $result_emp= $display->display_table_cndtn("employee","emp_id='{$row['tested_by']}'");
                    $row_emp=mysqli_fetch_assoc($result_emp); ?>
                <td><?php echo $row_emp['emp_name']; ?></td>
              </tr>

              <tr>
                <th>Last updated on:</th>
                <td><?php echo $row['last_updated_on']; ?></td>
              </tr>

              <?php if($_SESSION['login_user_type']=="admin"){ ?>
              <tr>
                <td><a href='edit_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'><button type='button' class='btn btn-info btn-sm col-sm-10'>Edit</button></a></td>
                <td>
                  <a href='delete_module.php?mod_id=<?php echo $row['app_mod_id']; ?>'>
                    <button type='button' class='btn btn-danger btn-sm col-sm-10'>Delete
                    </button>
                  </a>
                </td>
              </tr>                 
              <?php } ?>

          </tbody>
        </table>
      </div>
      <div class="card-body float-right col-sm-6">
        <a href="<?php echo $row['bug_scr']; ?>"><img class="img-fluid" src="<?php echo $row['bug_scr']; ?>"></a>
        <h5 class="header text-center">Bug screenshot</h5>
      </div>
    </div>
  </div>
</div>
    
<!--Module details ends-->


  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <!--Bugs list starts-->

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
                    <th>Follow up</th>
                  </tr>
                </thead>
                <tbody>

                <?php while($row_bug=mysqli_fetch_assoc($result_buglist)){ ?>
                <?php if($row_bug['bug_id']==$bug_id){ ?>
                <tr>
                  <td><?php echo $row_bug['follow_up_date']; ?></td>

                  <?php $result_sender=$display->display_table_cndtn("employee","emp_id='{$row_bug['msg_by']}'");
                      $row_sender=mysqli_fetch_assoc($result_sender) ?>
                  <td><?php echo $row_sender['emp_name']; ?></td>

                  <td><?php echo $row_bug['follow_up_msg']; ?></td>

                  <?php $result_bugname=$display->display_table_cndtn("bug_report","bug_id='{$row_bug['bug_id']}'");
                      $row_bugname=mysqli_fetch_assoc($result_bugname); ?>
                  <td><a href="view_bug.php?bug_id=<?php echo $row_bug['bug_id']; ?>"><?php echo $row_bugname['bug_title']; ?></a></td>

                  <?php $result_modname=$display->display_table_cndtn("application_module_list","app_mod_id='{$row_bugname['app_mod_id']}'");
                      $row_modname=mysqli_fetch_assoc($result_modname); ?>
                  <td><a href="view_module_details.php?mod_id=<?php echo $row_bugname['app_mod_id']; ?>"><?php echo $row_modname['app_mod_name']; ?></a></td>

                  <?php $result_appname=$display->display_table_cndtn("application","app_id='{$row_modname['app_id']}'");
                      $row_appname=mysqli_fetch_assoc($result_appname); ?>
                  <td><a href="view_application.php?app_id=<?php echo $row_appname['app_id']; ?>"><?php echo $row_appname['app_name']; ?></a></td>

                  <td>
                    <button type="button" class="btn btn-sm btn-primary followupbutton" data-toggle="modal" data-target="#followupmodal" data-id="<?php echo $row_bug['bug_id']; ?>">New msg</button>
                  </td>
                </tr>
                  <?php } ?>
                <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

  <!--Bugs list ends-->
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
          <form class="bg-light h-100 pt-3" method="POST" action='action/new_follow_up.php'>
          <div class="modal-body">
              <div class="form-group required">
                <input type="hidden" name="hiddenValue" id="hiddenValue" value="">
                <input type="hidden" name="page_name" value="<?php echo $_SERVER['PHP_SELF']; ?>">
                <textarea name="inputMessage" required="required" placeholder="Follow up message" class="form-control" rows="3" data-validation="required" ></textarea>
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