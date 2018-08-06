<?php session_start();

class session {

  function session_validate() {

    if (!isset($_SESSION['login_user_id'])) {

      header("location:index.php");

    }

    $mysqli     = new mysqli('localhost', 'blurhync_bts', 'XRfuE,JIvW8)', 'blurhync_bts');

    $check_user = $_SESSION['login_user_id'];

    $row        = mysqli_fetch_object($mysqli->query("SELECT user_id, user_type, emp_id from users where user_id = '$check_user'"));

    $_SESSION['login_user_type']            = $row->user_type;

    $_SESSION['login_emp_id']            = $row->emp_id;

  }

}

?>