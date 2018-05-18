<?php session_start(); 
if(isset($_SESSION['login_user_id'])){
  header('location: dashboard.php');  
}
$err=$_GET['err']??null;
if($err==1){$err='invalid username or password';}
?>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Bug Tracking System</title>
</head>


<body>
  <div class="login">
	<h1>Bug Tracking System</h1>
    <form name="myform" id="myform" method="POST" action="action/login_validate.php">
    	<input type="text" name="uname" placeholder="Username" required="required" />
        <input type="password" name="pass" id="pass" placeholder="Password" required="required" />
        <input type="hidden" name="enc" id="enc" value="">
        <input type="submit" class="btn btn-primary btn-block btn-large" name="submit" value="sign in" onclick="return encrypt();" />
    </form>
<div>
	<p> <?php echo $err; ?><p>
</div>
</div>

<script src="sb_admin/js/aes.js"></script>
<script>
  function encrypt(){
    var pass = document.getElementById("pass").value;
    var hash = CryptoJS.MD5(pass);
    document.getElementById('enc').value = hash;
    return true;
  }
</script>
</body>
</html>