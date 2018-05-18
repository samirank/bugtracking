<?php
/*To authunticated user to log into the system*/
/*used by index.php and login.php*/
include ('../class/validate.php');
session_start();
if (isset($_POST['submit'])) {
  $user     = $_POST['uname' ?? null];
  $pswd     = $_POST['enc'] ?? null;
  $pswd     = md5($pswd);

  $validate = new validate();
  if ($validate->validate_login($user, $pswd)) {
    $_SESSION['login_user_id']          = $user;
    header("location: ../dashboard.php");
  }
  else {
    $_SESSION['err'] = 1;
    header("location: ../index.php");
  }
}
else{
  $_SESSION['err'] = 1;
  header("location: ../index.php");
}
?>
