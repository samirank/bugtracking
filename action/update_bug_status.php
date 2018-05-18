<?php
/*To change the bug status*/
include ('../class/update.php');
if (isset($_POST['submit'])) {
  $bug_id         = $_POST['bug_id'];
  $inputBugStatus = $_POST['inputBugStatus'];
  $update         = new update_data();
  $result         = $update->update_bug_status($bug_id, $inputBugStatus);
  if ($result) {
    session_start();
    $_SESSION['err'] = "Bug status updated successfully";
    header("location: ../view_bug.php?bug_id=" . $bug_id);
  }
}
?>
