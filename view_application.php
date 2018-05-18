<?php
include('template/header.php');
include('class/view.php');
$display= new display();
if(isset($_GET['app_id'])){
$app_id   =$_GET['app_id'];
$tab_name ='application';
$cndtn    ="app_id='$app_id'";
$result=$display->display_table_cndtn($tab_name,$cndtn);
$row=mysqli_fetch_assoc($result);
$err=$_SESSION['err']??null;
unset($_SESSION['err']);
}
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard
    </a>
  </li>
  <li class="breadcrumb-item">
    <a  href="application_list.php">Application list
    </a>
  </li>
  <li class="breadcrumb-item active">Application Details
  </li>
</ol>
<nav class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-expanded="true">Application details
  </a>
  <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile">Module list
  </a>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- Form Begins-->
    <form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" id="myform" action='action/new_application.php'>
      <div class="form-group row">
        <div class="col-sm-3">
        </div>
        <?php echo "$err"; ?>
      </div>
      <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <label for="inputAppstatus" class="col-sm-2 col-form-label">Application Status
        </label>
        <div class="col-sm-6 ">
          <input type="text" class="form-control <?php if($row['status']=='tested'){echo 'bg-success';}else{echo 'bg-dark';} ?> text-light" placeholder="Application name" required="required" value="<?php echo $row['status']; ?>" readonly>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <label for="inputAppType" class="col-sm-2 col-form-label">Aplication type
        </label>
        <div class="col-sm-6">
          <select class="form-control" id="inputAppType" name="inputAppType" data-validation="required" data-validation-error-msg="Please select and option." disabled>
            <option disabled selected value="">Select
            </option>
            <option value="Online" 
                    <?php if($row['app_type']=='Online'){echo 'selected';} ?>>Online
            </option>
          <option value="Offline" 
                  <?php if($row['app_type']=='Offline'){echo 'selected';} ?>>Offline
          </option>
        <option value="SaaS" 
                <?php if($row['app_type']=='SaaS'){echo 'selected';} ?>>SaaS
        </option>
      <option value="Remote" 
              <?php if($row['app_type']=='Remote'){echo 'selected';} ?>>Remote
      </option>
    <option value="ERP" 
            <?php if($row['app_type']=='ERP'){echo 'selected';} ?>>ERP
    </option>
  </select>
</div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputAppName" class="col-sm-2 col-form-label">Application name
  </label>
  <div class="col-sm-6 ">
    <input type="text" class="form-control" id="inputAppName" data-validation="required custom" data-validation-regexp="^([A-Za-z ]+)$" data-sanitize="trim" name="inputAppName" placeholder="Application name" required="required" value="<?php echo $row['app_name']; ?>" readonly>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputDescription" class="col-sm-2 col-form-label">Description
  </label>
  <div class="col-sm-6">
    <textarea name="inputDescription" required="required" data-validation="required" data-sanitize="trim" placeholder="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>
      <?php echo $row['app_desc']; ?>
    </textarea>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputAccessibility" class="col-sm-2 col-form-label">Accessibility
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="inputAccessibility" name="inputAccessibility" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" placeholder="Accessibility" required="required" value="<?php echo $row['app_accs']; ?>" readonly>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputAppurl" class="col-sm-2 col-form-label">Application URL
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="inputAppurl" name="inputAppurl" data-validation="url" placeholder="URL" required="required" value="<?php echo $row['app_url']; ?>" readonly>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputDev" class="col-sm-2 col-form-label">Developer
  </label>
  <div class="col-sm-6">
    <select class="form-control" id="inputDev" name="inputDev" data-validation="required" data-validation-error-msg="Please select and option." disabled>
      <option disabled selected value="">Select
      </option>
      <?php
$result1=$display->display_table_cndtn("employee","emp_type='Developer'");
while($row1=mysqli_fetch_assoc($result1)){ ?>
      <option value="<?php echo $row1['emp_id']; ?>" 
              <?php if($row['app_dev']==$row1['emp_id']){ echo 'selected'; } ?>> 
      <?php echo $row1['emp_name']; ?> 
      </option>
    <?php } ?> 
    </select>
  <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the developer
  </small>
</div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputTester" class="col-sm-2 col-form-label">Tester
  </label>
  <div class="col-sm-6">
    <select class="form-control" id="inputTester" name="inputTester" data-validation="required" data-validation-error-msg="Please select and option." disabled>
      <option disabled selected value="">Select
      </option>
      <?php
$result2=$display->display_table_cndtn("employee","emp_type='Tester'");
while($row2=mysqli_fetch_assoc($result2)){ ?>
      <option value="<?php echo $row2['emp_id']; ?>" 
              <?php if($row['app_tester']==$row2['emp_id']){ echo 'selected'; } ?>> 
      <?php echo $row2['emp_name']; ?> 
      </option>
    <?php } ?> 
    </select>
  <small id="inputUserIdhelp" class="form-text text-muted">Employee id of the assigned tester
  </small>
</div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputUserId" class="col-sm-2 col-form-label">User id
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="inputUserId" name="inputUserId" placeholder="User id" value="<?php echo $row['test_user_id']; ?>" readonly>
    <small id="inputUserIdhelp" class="form-text text-muted">User id to access the application.
    </small>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
  </div>
  <label for="inputPassword" class="col-sm-2 col-form-label">Password
  </label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" value="<?php echo $row['test_user_pswd']; ?>" readonly>
    <small id="inputPasswordhelp" class="form-text text-muted">Password to access the application.
    </small>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-3">
  </div>
  <?php if($_SESSION['login_user_type']=='admin'){ ?>
  <div class="col-sm-3">
    <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='edit_application.php?app_id=<?php echo $app_id; ?>'">Edit
    </button>
  </div>
  <div class="col-sm-3">
    <button type="button" class="btn btn-danger btn-block">Delete
    </button>
  </div>
  <?php } ?>
</div>
</form>
<!-- Form Ends-->
</div>
<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <!-- Module list Begins-->
  <div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table">
      </i>
      List of modules
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>Module id
              </th>
              <th>Module name
              </th>
              <th>Last Updated on
              </th>
              <th>App name
              </th>
              <th>Bug Status
              </th>
              <th>View
              </th>
              <?php if($_SESSION['login_user_type']=="admin"){ ?>
              <th>Edit
              </th>
              <th>Delete
              </th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php $result_mod=$display->display_table_cndtn("application_module_list","app_id='$app_id'"); ?>
            <?php while($row_mod=mysqli_fetch_assoc($result_mod)){ ?>
            <tr>
              <td>
                <?php echo $row_mod['app_mod_id']; ?>
              </td>
              <td>
                <?php echo $row_mod['app_mod_name']; ?>
              </td>
              <td>
                <?php echo $row_mod['last_updated']; ?>
              </td>
              <?php $result1 = $display->display_table_cndtn("application","app_id='$app_id'"); 
$row1=mysqli_fetch_assoc($result1); ?>
              <td>
                <?php echo $row1['app_name']; ?>
              </td>
              <td>
                <?php if($row_mod['bug_status']==null){echo "N/A";}else{echo $row_mod['bug_status'];} ?>
              </td>
              <td>
                <a href='view_module_details.php?mod_id=<?php echo $row_mod['app_mod_id']; ?>'>
                  <button type='button' class='btn btn-primary btn-sm col-sm-10'>View details
                  </button>
                </a>
              </td>
              <?php if($_SESSION['login_user_type']=="admin"){ ?>
              <td>
                <a href='edit_module.php?mod_id=<?php echo $row_mod['app_mod_id']; ?>'>
                  <button type='button' class='btn btn-info btn-sm col-sm-10'>Edit
                  </button>
                </a>
              </td>
              <td>
                <a href='delete_module.php?mod_id=<?php echo $row_mod['app_mod_id']; ?>'>
                  <button type='button' class='btn btn-danger btn-sm col-sm-10'>Delete
                  </button>
                </a>
                <?php } ?>
              </td>
            </tr> 
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">  $.validate();
</script>
<?php include('template/footer.php'); ?>
