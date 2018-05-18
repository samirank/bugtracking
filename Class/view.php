<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - display_table()
* - display_table_cndtn()
* - user_accounts()
* - edit_account()
* - follow_up_list()
* - display_bug_list()
* - app_report()
* - tester_performance()
* Classes list:
* - display extends dbconnect
*/
/*This class is used to select data from the database*/
include ('config.php');
class display extends dbconnect {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }
  /*
   *To select all the data from any table
  */
  function display_table($tab_name) {
    $mysqli       = $this->mysqli;
    $sql          = "SELECT * FROM $tab_name";
    if ($val          = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }
  /*
   *To select all from a table with a condition
  */
  function display_table_cndtn($tab_name, $cndtn) {
    $mysqli = $this->mysqli;
    $sql    = "SELECT * FROM $tab_name where $cndtn";
    if ($val    = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }
  /*
   * To display list of all users in user_accounts.php
   * (Requires no parameter)
  */
  function user_accounts() {
    $mysqli = $this->mysqli;
    $sql    = "SELECT `users`.`user_id`, `users`.`email_id`,`users`.`emp_id`, `employee`.`emp_name`,`employee`.`emp_type`,`employee`.`emp_cntct`,`employee`.`doj` FROM employee INNER JOIN users on `employee`.`emp_id`=`users`.`emp_id`";
    $val    = $mysqli->query($sql);
    return $val;
  }
  /*
   *
   * To display details of a user in edit_account.php
  */
  function edit_account($emp_id) {
    $mysqli = $this->mysqli;
    $sql    = "SELECT * FROM employee INNER JOIN users on `employee`.`emp_id`=`users`.`emp_id` where `users`.`emp_id`='$emp_id'";
    if ($val    = $mysqli->query($sql)) {
      return $val;
    }
    else {
      $mysqli->error;
    }
  }
  /*
   *
   Follow up list*/
  function follow_up_list($utype, $uid) {
    $mysqli = $this->mysqli;
    if ($utype == "Tester") {
      $sql    = "SELECT * FROM bug_follow_up WHERE bug_id IN (SELECT `bug_id` FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id IN (SELECT app_id FROM application where app_tester='$uid'))) ORDER BY follow_up_date, follow_up_time DESC;";
    }
    if ($utype == "Developer") {
      $sql    = "SELECT * FROM bug_follow_up WHERE bug_id IN (SELECT `bug_id` FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id IN (SELECT app_id FROM application where app_dev='$uid'))) ORDER BY follow_up_date, follow_up_time DESC;";
    }
    if ($utype == "admin") {
      $sql    = "SELECT * FROM bug_follow_up WHERE bug_id IN (SELECT `bug_id` FROM bug_report WHERE app_mod_id IN (SELECT app_mod_id FROM application_module_list WHERE app_id IN (SELECT app_id FROM application))) ORDER BY follow_up_date, follow_up_time DESC;";
    }
    if ($val    = $mysqli->query($sql)) {
      return $val;
    }
    else {
      echo $mysqli->error;
    }
  }
  /*
   *Display Bug list*/
  function display_bug_list($utype, $uid) {
    $mysqli = $this->mysqli;
    if ($utype == "Developer") {
      $sql    = "SELECT * from bug_report WHERE tested_by IN (SELECT app_tester from application where app_dev='$uid');";
    }
    else if ($utype == "Tester") {
      $sql    = "SELECT * from bug_report WHERE tested_by ='$uid';";
    }
    else if ($utype == "admin") {
      $sql    = "SELECT * from bug_report";
    }
    if ($result = $mysqli->query($sql)) {
      return $result;
    }
    else {
      echo $mysqli->error;
    }
  }
  /*
   *Application Report*/
  function app_report($from_date, $to_date) {
    $mysqli = $this->mysqli;
    $sql    = "SELECT app.`app_name`, app.`app_type`, app.`status`, stat.`total_bugs`, app.`bug_counter`, app.`app_tester`, app.`app_dev` FROM application app JOIN bug_stat stat ON app.`app_id`=stat.`app_id` WHERE (app.`added_on` BETWEEN '$from_date' and '$to_date')";
    if ($result = $mysqli->query($sql)) {
      return $result;
    }
    else {
      die($mysqli->error);
    }
  }
  /*
   *Tester performance*/
  function tester_performance($from_date, $to_date, $tester) {
    $mysqli = $this->mysqli;
    if ($tester == "all") {
      $sql    = "SELECT app.`app_name`,app.`status`, app.`app_tester`, app.`bug_counter`, stat.`total_bugs`, stat.`bugs_resolved` FROM `application` app INNER JOIN bug_stat stat ON app.app_id=stat.app_id WHERE app.app_id IN (SELECT app_id from application_module_list WHERE app_mod_id IN (SELECT app_mod_id FROM `bug_report` WHERE (`bug_appeared_on` BETWEEN '$from_date' AND '$to_date')))";
    }
    else {
      $sql    = "SELECT app.`app_name`,app.`status`, app.`app_tester`, app.`bug_counter`, stat.`total_bugs`, stat.`bugs_resolved` FROM `application` app INNER JOIN bug_stat stat ON app.app_id=stat.app_id WHERE app.app_id IN (SELECT app_id from application_module_list WHERE app_mod_id IN (SELECT app_mod_id FROM `bug_report` WHERE (`bug_appeared_on` BETWEEN '$from_date' AND '$to_date') AND tested_by='$tester'))";
    }
    if ($result = $mysqli->query($sql)) {
      return $result;
    }
    else {
      die($mysqli->error);
    }
  }




  //Developer performance
  function developer_performance($from_date,$to_date,$dev){
    $mysqli = $this->mysqli;
    $mysqli = $this->mysqli;
    if ($dev == "all") {
      $sql    = "SELECT app.`app_name`,app.`status`, app.`app_dev`, app.`bug_counter`, stat.`total_bugs`, stat.`bugs_resolved` FROM `application` app INNER JOIN bug_stat stat ON app.app_id=stat.app_id WHERE app.app_id IN (SELECT app_id from application_module_list WHERE app_mod_id IN (SELECT app_mod_id FROM `bug_report` WHERE (`bug_appeared_on` BETWEEN '$from_date' AND '$to_date')))";
    }
    else {
      $sql    = "SELECT app.`app_name`,app.`status`, app.`app_dev`, app.`bug_counter`, stat.`total_bugs`, stat.`bugs_resolved` FROM `application` app INNER JOIN bug_stat stat ON app.app_id=stat.app_id WHERE app.app_id IN (SELECT app_id from application_module_list WHERE app_mod_id IN (SELECT app_mod_id FROM `bug_report` WHERE (`bug_appeared_on` BETWEEN '$from_date' AND '$to_date') AND tested_by='$dev'))";
    }
    if ($result = $mysqli->query($sql)) {
      return $result;
    }
    else {
      die($mysqli->error);
    }
  }



  /*End of class*/
}
?>
