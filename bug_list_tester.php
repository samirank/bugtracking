<?php include('template/header.php');?>
      	<ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Application list</li>
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
                    <th>Update Bug</th>
                  </tr>
                </thead>
                <tbody>
                  <?php include('action/list_application.php'); 
                  display_tester_bug(); 

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>


	  </div>
<?php include('template/footer.php');?>