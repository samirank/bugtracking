<?php
/*
* Function list:
* - set_data()
*Used in the Account module to submit account creation form*/
include ('../class/insert.php');

if (isset($_POST['submit'])) {
  $create = new insert();
  $utype  = $_POST['accountType'];
  $uid    = $_POST['inputUsername'];
  $fname  = $_POST['inputFirstName'];
  $lname  = $_POST['inputLastName'];
  $email  = $_POST['inputEmail'];
  $cntct  = $_POST['inputContact'];
  $pass   = $_POST['inputPassword'];
  $pass   = md5(md5($pass));
  $name   = $fname . " " . $lname;

  function set_data($utype, $uid, $fname, $lname, $pass, $email, $cntct) {
    session_start();
    $_SESSION['accountType']      = $utype;
    $_SESSION['inputUsername']    = $uid;
    $_SESSION['inputFirstName']   = $fname;
    $_SESSION['inputLastName']    = $lname;
    $_SESSION['inputEmail']       = $email;
    $_SESSION['inputContact']     = $cntct;
  }

  if ($err = $create->new_account($utype, $uid, $name, $pass, $email, $cntct)) {
    if (!is_numeric($err)) {
      set_data($utype, $uid, $fname, $lname, $pass, $email, $cntct);
    }
    header("location:../create_account.php?err=" . $err);
  }
}
?>
