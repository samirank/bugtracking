<?php
/**
* Class and Function List:
* Function list:
* - display()
* - display_app_list()
* - display_tester()
* - display_dev()
* - display_tester_bug()
*/
/*This action is used to display list of application to the user*/
function display() {
  include ('class/view.php');
  $display = new display();
  $result  = $display->display_table('application');
  while ($row     = mysqli_fetch_object($result)) {
    echo "<tr><td>{$row->app_id}</td>";
    echo "<td>{$row->app_name}</td>";
    echo "<td>{$row->added_on}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_dev}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_tester}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";
    echo "<td><a href='view_application.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>View</button></a></td>";
    echo "<td><a href='edit_application.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>Edit</button></a></td>";
    echo "<td><a href='action/delete_application.php?app_id={$row->app_id}'><button type='button' class='btn btn-danger btn-sm col-sm-10'>Delete</button></a>";
    echo "</tr>";
  }
}

function display_app_list() {
  include ('class/view.php');
  $display = new display();
  $result  = $display->display_table('application');
  while ($row     = mysqli_fetch_object($result)) {
    echo "<tr><td>{$row->app_id}</td>";
    echo "<td>{$row->app_name}</td>";
    echo "<td>{$row->added_on}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_dev}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_tester}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";
    echo "<td><a href='add_module.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>Add module</button></a></td>";
    echo "</tr>";
  }
}

function display_tester() {
  include ('class/view.php');
  $display = new display();
  $key     = "app_tester=" . $_SESSION['login_emp_id'];
  $result  = $display->display_table_cndtn('application', $key);
  while ($row     = mysqli_fetch_object($result)) {
    echo "<tr><td>{$row->app_id}</td>";
    echo "<td>{$row->app_name}</td>";
    echo "<td>{$row->added_on}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_dev}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_tester}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";
    echo "<td><a href='view_application.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>View</button></a></td>";
    echo "<td><a href='update_bug.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>Update bug</button></a></td>";
    echo "</tr>";
  }
}

function display_dev() {
  include ('class/view.php');
  $display = new display();
  $key     = "app_dev=" . $_SESSION['login_emp_id'];
  $result  = $display->display_table_cndtn('application', $key);
  while ($row     = mysqli_fetch_object($result)) {
    echo "<tr><td>{$row->app_id}</td>";
    echo "<td>{$row->app_name}</td>";
    echo "<td>{$row->added_on}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_dev}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_tester}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";
    echo "<td><a href='view_application.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>View</button></a></td>";
    echo "</tr>";
  }
}

function display_tester_bug() {
  include ('class/view.php');
  $display = new display();
  $key     = "app_tester=" . $_SESSION['login_emp_id'];
  $result  = $display->display_table_cndtn('application', $key);
  while ($row     = mysqli_fetch_object($result)) {
    echo "<tr><td>{$row->app_id}</td>";
    echo "<td>{$row->app_name}</td>";
    echo "<td>{$row->added_on}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_dev}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";

    $result2 = $display->display_table_cndtn('employee', "emp_id='{$row->app_tester}'");
    $row2    = mysqli_fetch_object($result2);
    echo "<td>{$row2->emp_name}</td>";
    echo "<td><a href='update_bug.php?app_id={$row->app_id}'><button type='button' class='btn btn-info btn-sm col-sm-10'>Update bug</button></a></td>";
    echo "</tr>";
  }
}
?>
