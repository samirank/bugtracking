<?php
/*Used by the Application to add new new application*/
/*Used in add_application.php*/
include ('../class/insert.php');
if (isset($_POST['submit'])) {
  $inputAppName       = $_POST['inputAppName'];
  $inputAppType       = $_POST['inputAppType'];
  $inputAccessibility = $_POST['inputAccessibility'];
  $inputAppurl        = $_POST['inputAppurl'];
  $inputDev           = $_POST['inputDev'];
  $inputTester        = $_POST['inputTester'];
  $inputUserId        = $_POST['inputUserId'];
  $inputPassword      = $_POST['inputPassword'];
  $inputDescription   = $_POST['inputDescription'];

  $create             = new insert();
  $result             = $create->new_application($inputAppName, $inputAppType, $inputAccessibility, $inputAppurl, $inputDev, $inputTester, $inputUserId, $inputPassword, $inputDescription);
  header("location: ../add_application.php?err=" . $result);
}
?>
