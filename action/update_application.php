<?php
include ('../class/update.php');
$update     = new update_data();
$app_id     = $_POST['app_id'];
$app_type   = $_POST['inputAppType'];
$app_name   = $_POST['inputAppName'];
$app_desc   = $_POST['inputDescription'];
$app_accs   = $_POST['inputAccessibility'];
$app_url    = $_POST['inputAppurl'];
$app_dev    = $_POST['inputDev'];
$app_tester = $_POST['inputTester'];
$test_uid   = $_POST['inputUserId'];
$test_upsd  = $_POST['inputPassword'];
session_start();
$result = $update->update_app($app_id, $app_type, $app_name, $app_desc, $app_accs, $app_url, $app_dev, $app_tester, $test_uid, $test_upsd);
if ($result) {
  $_SESSION['err']        = $result;
  header("location: ../edit_application.php?app_id=" . $app_id);
}
?>
