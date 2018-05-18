<?php
/*Used in the User Account Module to edit a user account*/
/*included by the edit_account.php page*/
require_once ('../class/validate.php');
include ('../class/update.php');
session_start();
if (isset($_POST['submit']))
{
    $validate = new validate();
    $update = new update_data();
    $utype = $validate->validate_data($_POST['accountType']);
    $uid = $validate->validate_data($_POST['inputUsername']);
    $name = $validate->validate_data($_POST['name']);
    $email = $validate->validate_email($_POST['inputEmail']);
    $cntct = $validate->validate_contact($_POST['inputContact']);
    $emp_id = $_POST['emp_id'];
    if ($err = $update->update_account($emp_id, $utype, $uid, $name, $email, $cntct))
    {
        $_SESSION['err'] = $err;
        header("location: ../edit_account.php?emp_id=" . $emp_id);
    }
}
?>
