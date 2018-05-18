<?php include('template/header.php');
      include('class/view.php');
      $display = new display();
      $result =  $display->user_accounts();
?>

        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">User accounts</li>
        </ol>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            User Accounts
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Emp id</th>
                    <th>User id</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email id</th>
                    <th>Contact</th>
                    <th>Joined on</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                      <td><?php echo $row['emp_id']; ?></td>
                      <td><?php echo $row['user_id']; ?></td>
                      <td><?php echo $row['emp_name']; ?></td>
                      <td><?php echo $row['emp_type']; ?></td>
                      <td><?php echo $row['email_id']; ?></td>
                      <td><?php echo $row['emp_cntct']; ?></td>
                      <td><?php echo $row['doj']; ?></td>
                      <td>
                      <div class="btn-group">
                        <a href='edit_account.php?emp_id={$row->emp_id}'>
                          <button class="btn btn-primary btn-sm"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.location.href = 'edit_account.php?emp_id=<?php echo $row['emp_id']; ?>'">
                            Edit
                          </button>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href='action/block_account.php?emp_id=<?php echo $row['emp_id']; ?>'>Block</a>
                          <a class="dropdown-item" href='action/delete_account.php?emp_id=<?php echo $row['emp_id']; ?>'>Delete</a>
                        </div>
                      </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<?php include('template/footer.php');?>