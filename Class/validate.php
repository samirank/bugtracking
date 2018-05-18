<?php
/**
* Class and Function List:
* Function list:
* - mysqli()
* - validate_login()
* - validate_username()
* - validate_data()
* - validate_email()
* - validate_contact()
* Classes list:
* - validate
*/
class validate {
  /*
   function to set connection string*/
  private function mysqli() {
    if($mysqli = new mysqli('localhost', 'bts_samiran', 'pMsSodmG9fzc6KLL', 'bts_samiran'))
      return $mysqli;
    else
      die($mysqli->error);
  }
  /*
   function to validate login page*/
  function validate_login($user, $pswd) {
    $mysqli = $this->mysqli();
    $u_name = $mysqli->real_escape_string($user);
    $pass   = $mysqli->real_escape_string($pswd);
    $sql    = "SELECT user_id FROM users WHERE user_id='$u_name' and password='$pass'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      //$mysqli->query("UPDATE users SET status = 'online' WHERE user_id = '$user'");
      $mysqli->query("UPDATE employee SET status = 'online' WHERE emp_id in (SELECT emp_id from users where user_id = '$u_name')");
      return true;
    }
    else {
      return false;
    }
  }
  /*
   function to validate username*/
  function validate_username($user) {
    $mysqli = $this->mysqli();
    $u_name = $mysqli->real_escape_string($user);
    $sql    = "SELECT user_id FROM users WHERE user_id='$u_name'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }
  /*
   function to validate form data */
  function validate_data($data) {
    $mysqli = $this->mysqli();
    $data   = $mysqli->real_escape_string(trim($data));
    $data   = strip_tags($data);
    return $data;
  }
}
?>
