<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $page_name; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="sb_admin/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="sb_admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="sb_admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sb_admin/css/admin.css" rel="stylesheet">

    <!-- Datepicker CSS -->
    <link href="sb_admin/css/daterangepicker.css" rel="stylesheet">

  </head>

  <body class="fixed-nav" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="index.html"><img src="logo.svg" width="30" height="30" alt="brand_name"> Bug Tracking System</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="dashboard.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="dashboard.php">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">
                Dashboard</span>
            </a>
          </li>
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="create_account.php" || basename($_SERVER['PHP_SELF'])=="user_accounts.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="Accounts">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseuser">
              <i class="fa fa-fw fa-users"></i>
              <span class="nav-link-text">
                User accounts</span>
            </a>
             <ul class="sidenav-second-level collapse" id="collapseuser">
              <li>
                <a href="create_account.php">Create account</a>
              </li>
              <li>
                <a href="user_accounts.php">View Users</a>
              </li>
            </ul>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Application">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseapplication">
              <i class="fa fa-fw fa-code"></i>
              <span class="nav-link-text">
                Application</span>
            </a>
             <ul class="sidenav-second-level collapse" id="collapseapplication">
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="add_application.php"){echo "active";} ?>">
                <a href="add_application.php">Add application</a>
              </li>
              
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="application_list.php"){echo "active";} ?>">
                <a href="application_list.php">List of applications</a>
              </li>
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="add_application_module.php"){echo "active";} ?>">
                <a href="add_application_module.php">Add application module</a>
              </li>
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="view_application_module.php"){echo "active";} ?>">
                <a href="view_application_module.php">View application module</a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="view_bug_list.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="Bugs">
            <a class="nav-link" href="view_bug_list.php">
              <i class="fa fa-fw fa-bug"></i>
              <span class="nav-link-text">
                View bugs</span>
            </a>
          </li>
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="follow_up.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="Follow up">
            <a class="nav-link" href="follow_up.php">
              <i class="fa fa-fw fa-comments"></i>
              <span class="nav-link-text">
                Follow up</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reports">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsereports">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">
                Reports</span>
            </a>
             <ul class="sidenav-second-level collapse active" id="collapsereports">
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="application_report.php"){echo "active";} ?>">
                <a href="application_report.php">Application report</a>
              </li>
              
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="tester_performance.php"){echo "active";} ?>">
                <a href="tester_performance.php">Tester performance</a>
              </li>
              <li class="<?php if(basename($_SERVER['PHP_SELF'])=="developer_performance.php"){echo "active";} ?>">
                <a href="developer_performance.php">Developer performance</a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="inbox.php" || basename($_SERVER['PHP_SELF'])=="outbox.php" || basename($_SERVER['PHP_SELF'])=="create_message.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="Message">
            <a class="nav-link" href="inbox.php">
              <i class="fa fa-fw fa-envelope"></i>
              <span class="nav-link-text">
                Message</span>
            </a>
          </li>
          <li class="nav-item <?php if(basename($_SERVER['PHP_SELF'])=="my_profile.php"){echo "active";} ?>" data-toggle="tooltip" data-placement="right" title="My profile">
            <a class="nav-link" href="my_profile.php">
              <i class="fa fa-fw fa-user"></i>
              <span class="nav-link-text">
                My profile</span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <div class="nav-item nav-link nav-link-text">
            <div class="h6 text-light"><small class="text-muted">Welcome, </small><?php echo $_SESSION['login_user_id']; ?></div>
          </div>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    
      <div class="content-wrapper py-3">
      <div class="container-fluid">