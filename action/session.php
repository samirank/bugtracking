<?php
/**
* Class and Function List:
* Function list:
* - session_validate()
* Classes list:
* - session
*/
/*to start and validate current session*/
session_start();
class session {
  function session_validate() {
    if (!isset($_SESSION['login_user_id'])) {
      header("location:index.php");
    }
    $mysqli     = new mysqli('localhost', 'bts_samiran', 'pMsSodmG9fzc6KLL', 'bts_samiran');
    $check_user = $_SESSION['login_user_id'];
    $row        = mysqli_fetch_object($mysqli->query("SELECT user_id, user_type, emp_id from users where user_id = '$check_user'"));
    $_SESSION['login_user_type']            = $row->user_type;
    $_SESSION['login_emp_id']            = $row->emp_id;
  }
}
?>
