<?php
  include('action/session.php');

  $session= new session();

  $session->session_validate();

    //End of session validation



    //Get the page name

  $page_name = basename($_SERVER['PHP_SELF'],".php");

  $page_name = str_replace("_"," ",$page_name);

  $page_name = ucfirst($page_name)." -".$_SESSION['login_user_type'];





    //set active nav-item

  $activeDashboard=null;

  $activeUseraccounts=null;

  $activeApplication=null;



  if($page_name=='Dashboard'){

    $activeDashboard='active';

  }

  if($page_name=='User accounts'||$page_name=='Create account'){

    $activeUseraccounts='active';

  }

  if($page_name=='Application list'||$page_name=='Add application'||$page_name=='Add application module'||$page_name=='Add module'){

    $activeApplication='active';

  }



  if($_SESSION['login_user_type']=='admin'){

    include('admin_header.php');

  }



  if($_SESSION['login_user_type']=='Tester'){

    include('tester_header.php');

  }



  if($_SESSION['login_user_type']=='Developer'){

    include('dev_header.php');

  }

  ?>

