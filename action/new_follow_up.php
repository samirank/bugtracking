<?php
/*To add a new follow up message*/
include ('../class/insert.php');
include ('../class/update.php');
session_start();
if (isset($_POST['submit'])) {

  $bug_id     = $_POST['hiddenValue'];
  $message    = $_POST['inputMessage'];
  $page_name  = basename($_POST['page_name']);
  $msg_by     = $_SESSION['login_emp_id'];

  $create     = new insert();
  if ($result     = $create->new_follow_up($bug_id, $message, $msg_by)) {
    $update     = new update_data();
    if (isset($_POST['inputBugStatus'])) {
      $bug_status = $_POST['inputBugStatus'];
      $update->update_bug_status($bug_id, $bug_status);
    }
    else {
      $update->update_bug_status($bug_id, "active");
    }

    $_SESSION['err'] = "Follow up message posted successfully";
    if ($page_name == "view_bug.php") {
      header("location: ../" . $page_name . "?bug_id=" . $bug_id);
    }
    else {
      header("location: ../" . $page_name);
    }
  }

}
?>
