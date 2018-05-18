<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - update_account()
* - update_app()
* - delete_account()
* - delete_application()
* - block_account()
* - update_bug_status()
* - bug_counter()
* - update_bug_stat()
* Classes list:
* - update_data
*/
/*This class is used to alter existing data in the database*/
include_once ('config.php');
class update_data {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }
  /*
   *
   *	UPDATE ACCOUNT */
  function update_account($emp_id, $utype, $uid, $name, $email, $cntct) {
    $err          = 0;
    $mysqli       = $this->mysqli;
    $mysqli->autocommit(false);
    if (!$mysqli->query("UPDATE users SET user_id='$uid', user_type='$utype', email_id='$email' where emp_id='$emp_id';")) {
      $err = $mysqli->error;
      $mysqli->rollback();
      return $err;
    }
    else {
      $new_emp_id = $mysqli->insert_id;
      if (!$mysqli->query("UPDATE employee SET emp_name='$name', emp_type='$utype', emp_cntct='$cntct' where emp_id='$emp_id';")) {
        $err        = $mysqli->error;
        $mysqli->rollback();
        return $err;
      }
      else {
        $mysqli->commit();
        return true;
      }
    }
  }
  /*
   *
   *	UPDATE APPLICATION */
  function update_app($app_id, $app_type, $app_name, $app_desc, $app_accs, $app_url, $app_dev, $app_tester, $test_uid, $test_upsd) {
    $mysqli = $this->mysqli;
    $sql    = "UPDATE application SET app_type='$app_type',app_name='$app_name',app_desc='$app_desc',app_accs='$app_accs',app_url='$app_url',app_dev='$app_dev',app_tester='$app_tester',test_user_id='$test_uid',test_user_pswd='$test_upsd',updated_on=now() where app_id='$app_id'";
    if ($mysqli->query($sql)) {
      return 1;
    }
    else {
      return $mysqli->error;
    }
  }
  /*
   *	DELETE ACCOUNT
  */
  function delete_account($emp_id) {
    $err    = 0;
    $mysqli = $this->mysqli;
    $mysqli->autocommit(false);
    if (!$mysqli->query("DELETE FROM `users` WHERE `users`.`emp_id` = $emp_id")) {
      echo $mysqli->error;
      $mysqli->rollback();
      return false;
    }
    else {
      if (!$mysqli->query("DELETE FROM `employee` WHERE `employee`.`emp_id` = $emp_id")) {
        echo $mysqli->error;
        $mysqli->rollback();
        return false;
      }
      else {
        $mysqli->commit();
        return true;
      }
    }
  }
  /*
   *	DELETE APPLICATION */
  function delete_application($tab_name, $app_id) {
    $mysqli = $this->mysqli;
    if ($mysqli->query("DELETE FROM `application` WHERE `application`.`app_id` = $app_id")) {
      $err    = 'account deleted successfully';
      return true;
    }
    else {
      echo $mysqli->error;
      return false;
    }
  }
  /*
   *	UPDATE ACCOUNT */
  function block_account($tab_name, $emp_id) {
    $err    = 0;
    $mysqli = $this->mysqli;
    if ($mysqli->query("UPDATE users SET status='blocked' where emp_id='$emp_id';")) {
      $err    = 'account blocked successfully';
      return $err;
    }
    else {
      $mysqli->error;
      return "unable to block";
    }
  }
  /*
   *	UPDATE BUG STATUS */
  function update_bug_status($bug_id, $inputBugStatus) {
    $mysqli         = $this->mysqli;
    $app_mod_id     = "SELECT app_mod_id FROM bug_report WHERE bug_id='$bug_id'";
    $app_id         = mysqli_fetch_assoc($mysqli->query("SELECT app_id FROM application_module_list WHERE app_mod_id=($app_mod_id)"));
    $app_id         = $app_id['app_id'];
    $err            = 0;
    $sql            = "SELECT bug_status FROM bug_report WHERE bug_id='$bug_id'";
    if (!($current_status = $mysqli->query($sql))) {
      $err            = 1;
      echo $mysqli->error;
    }
    $current_status = mysqli_fetch_assoc($current_status);
    $current_status = $current_status['bug_status'];
    $sql            = "UPDATE bug_report SET bug_status='$inputBugStatus', last_updated_on=now() where bug_id='$bug_id'";
    if (!$mysqli->query($sql)) {
      $err            = 1;
      echo $mysqli->error;
    }
    if ($inputBugStatus == "completed") {
      /*******   to check application   *******/
      $sql    = "SELECT bug_id FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id='$app_id') AND NOT bug_status='completed';";
      if (!($result = $mysqli->query($sql))) {
        $err    = 1;
        echo $mysqli->error;
      }
      if (mysqli_num_rows($result) == 0) {
        $sql    = "UPDATE application SET status='tested' where app_id='$app_id';";
        if (!($result = $mysqli->query($sql))) {
          $err    = 1;
          echo $mysqli->error;
        }
      }
      if ($inputBugStatus != $current_status) {
        $this->bug_counter($app_id, 'sub');
      }
      /*******   to check module   *******/
      $sql    = "SELECT bug_id FROM bug_report WHERE app_mod_id=($app_mod_id) AND NOT bug_status='completed';";
      if (!($result = $mysqli->query($sql))) {
        $err    = 1;
        echo $mysqli->error;
      }
      if (mysqli_num_rows($result) == 0) {
        $sql    = "UPDATE application_module_list SET bug_status='tested' where app_mod_id=($app_mod_id);";
        if (!($result = $mysqli->query($sql))) {
          $err    = 1;
          echo $mysqli->error;
        }
      }
    }
    else {
      $sql    = "UPDATE application SET status='testing' where app_id='$app_id';";
      if (!($result = $mysqli->query($sql))) {
        $err    = 1;
        echo $mysqli->error;
      }
      $sql    = "UPDATE application_module_list SET bug_status='testing' WHERE app_mod_id=($app_mod_id);";
      if (!($result = $mysqli->query($sql))) {
        $err    = 1;
        echo $mysqli->error;
      }
      if ($current_status == 'completed') {
        $this->bug_counter($app_id, 'add');
      }
    }
    if ($err == 0) {
      $this->update_bug_stat($app_id);
      return true;
    }
  }
  /*
   *
   *	UPDATE BUG COUNTER */
  function bug_counter($app_id, $count) {
    $mysqli = $this->mysqli;
    if ($count == "add") {
      $sql    = "UPDATE application SET bug_counter=bug_counter+1 where app_id='$app_id'";
      if ($mysqli->query($sql)) {
        $this->update_bug_stat($app_id);
        return true;
      }
      else {
        echo $mysqli->error;
      }
    }
    if ($count == "sub") {
      $sql = "UPDATE application SET bug_counter=bug_counter-1 where app_id='$app_id'";
      if ($mysqli->query($sql)) {
        $this->update_bug_stat($app_id);
        return true;
      }
      else {
        echo $mysqli->error;
      }
    }
  }
  /*
   *	UPDATE TABLE BUG_STAT */
  function update_bug_stat($app_id) {
    $mysqli = $this->mysqli;
    $sql    = "UPDATE `bug_stat` SET `total_bugs`=(SELECT COUNT(bug_id) AS 'total_bugs' FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id='$app_id')),`bugs_resolved`=(SELECT COUNT(bug_id) AS 'bugs_resolved' FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id='$app_id') AND bug_status='completed') WHERE app_id='$app_id';";
    if (!$mysqli->query($sql)) {
      die($mysqli->error);
    }
  }

  function update_msg_status($msg_id){
    $mysqli = $this->mysqli;
    $sql    = "UPDATE `message_box` SET `msg_status`='read' WHERE `msg_id`";
    if(!$mysqli->query($sql)){
      die($mysqli->error);
    }
  }






  /* END OF CLASS */
}
?>
