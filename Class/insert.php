<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - new_account()
* - new_application()
* - new_module()
* - new_bug()
* - new_follow_up()
* Classes list:
* - insert extends dbconnect
*/
/*This class is used to insert new data into the database*/
include_once ('config.php');
class insert extends dbconnect {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }
  /*
   *    New account function
   *
  */
  function new_account($utype, $uid, $name, $pass, $email, $cntct) {
    $mysqli       = $this->mysqli;
    $mysqli->autocommit(false);
    if (!$mysqli->query("INSERT INTO users (user_id, password, user_type, email_id, status, emp_id) VALUES ('$uid', '$pass', '$utype', '$email', NULL, NULL);")) {
      $err = $mysqli->error;
      $mysqli->rollback();
      return $err;
    }
    else {
      $new_emp_id = $mysqli->insert_id;
      if (!$mysqli->query("INSERT INTO employee (emp_id, emp_name, emp_type, emp_cntct, status, doj) VALUES (LAST_INSERT_ID(), '$name', '$utype', '$cntct', NULL, now());")) {
        $err        = $mysqli->error;
        $mysqli->rollback();
        return $err;
      }
      else {
        $mysqli->commit();
        return $new_emp_id;
      }
    }
  }
  /*
   *    New application function*
  */
  function new_application($inputAppName, $inputAppType, $inputAccessibility, $inputAppurl, $inputDev, $inputTester, $inputUserId, $inputPassword, $inputDescription) {
    $mysqli = $this->mysqli;
    $mysqli->autocommit(false);
    if (!$mysqli->query("INSERT INTO application (app_name, app_desc, app_type, app_accs, app_url, app_dev, app_tester,status,added_on,updated_on,test_user_id,test_user_pswd) VALUES ('$inputAppName', '$inputDescription', '$inputAppType', '$inputAccessibility', '$inputAppurl', '$inputDev', '$inputTester', 'active',now(),now(), '$inputUserId', '$inputPassword');")) {
      $err = $mysqli->error;
      $mysqli->rollback();
      die($err);
    }
    else {
      if (!$mysqli->query("INSERT INTO `bug_stat`(`app_id`, `total_bugs`, `bugs_resolved`) VALUES (LAST_INSERT_ID(),0,0);")) {
        $err = $mysqli->error;
        $mysqli->rollback();
        die($err);
      }
      else {
        $mysqli->commit();
        return true;
      }
    }
  }
  /*
   *   Add new application module*
  */
  function new_module($app_id, $inputModuleName, $inputDescription, $target_file) {
    $mysqli      = $this->mysqli;
    $target_file = ltrim($target_file, "../");
    if ($mysqli->query("INSERT INTO `application_module_list` (`app_mod_name`, `app_mod_desc`, `bug_status`, `last_updated`, `app_id`, `test_data`) VALUES ('$inputModuleName', '$inputDescription', null, now(), '$app_id', '$target_file')")) {
      return true;
    }
    else {
      echo $mysqli->error;
    }
  }
  /*
   *   Add new bug
  */
  function new_bug($inputAppid, $inputModId, $inputBugTitle, $inputDescription, $inputUrl, $appearedOn, $target_file, $bugTester) {
    $mysqli      = $this->mysqli;
    $target_file = ltrim($target_file, "../");
    if ($mysqli->query("INSERT INTO `bug_report` (`bug_title`, `bug_desc`, `bug_url`, `bug_scr`, `app_mod_id`, `bug_appeared_on`, `bug_status`, `tested_by`, `last_updated_on`) VALUES ('$inputBugTitle', '$inputDescription', '$inputUrl', '$target_file', '$inputModId', '$appearedOn', 'active', '$bugTester', now())")) {
      if (!$mysqli->query("UPDATE application SET status='testing' where app_id='$app_id'")) {
        die($mysqli->error);
      }
      return true;
    }
    else {
      die($mysqli->error);
    }
  }
  /*
   *   New Follow up message
  */
  function new_follow_up($bug_id, $message, $msg_by) {
    $mysqli = $this->mysqli;
    if ($mysqli->query("INSERT INTO `bug_follow_up` (`follow_up_id`, `bug_id`, `follow_up_msg`, `msg_by`, `follow_up_date`, `follow_up_time`, `status`) VALUES (NULL, '$bug_id', '$message', '$msg_by', now(), now(), NULL)")) {
      return true;
    }
    else {
      echo $mysqli->error;
    }
  }


  /*
   *
   *   New message
  */
  function new_msg($inputMsg,$msgtitle,$msgto,$msgfrom){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `message_box` (`msg_title`, `msg_desc`, `msg_to`, `msg_from`, `msg_date`, `msg_time`) VALUES ('$msgtitle', '$inputMsg', '$msgto', '$msgfrom', now(), now())";
    if($mysqli->query($sql)){
      return true;
    }else{
      echo $mysqli->error;
    }
  }










  /*End of class*/
}
?>
