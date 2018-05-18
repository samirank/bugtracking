<?php session_start();
if(isset($_SESSION['login_user_id'])){
  header('location: dashboard.php');
}else{
session_destroy();
}
?>
<?php $err=$_SESSION['err']??null;
unset($_SESSION['err']);
if($err==1){
  $err="<br><span style='color: red; padding: 10px'>Login failed</span>";
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>Bug tracking system</title>

    <!-- Bootstrap core CSS -->
    <link href="sb_admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="sb_admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="sb_admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sb_admin/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="sb_admin/css/style.css">


</head>
<body>
<a class="navbar-brand" href="">
        <img src="logo.svg" width="30" height="30" alt="">
  </a>
<div class="topnav" id="myTopnav">
  <a href="#contact">Contact</a>
  <a href="#about">About</a>
  <a class="active" href="#home">Home</a>
</div>
<section class="intro" id="home">
  <div class="inner">
    <div class="content">
      <h1>Bug tracking System</h1>
      <a class="bttn" href="#" data-toggle="modal" data-target="#login-modal">Sign in</a>
      <?php echo $err; ?>
    </div>
  </div>





</section>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
        <div class="loginmodal-container">
          <h1>Login to Your Account</h1><br>
          <form method="POST" action="action/login_validate.php">
          <input type="text" name="uname" placeholder="Username" required="required">
          <input type="password" name="pass" id="pass" placeholder="Password" required="required">
          <input type="submit" name="submit" class="login loginmodal-submit" value="Login" onclick="return encr();">
          <input type="hidden" name="enc" id="enc" value="">
          </form>
          
          <div class="login-help">
          </div>
        </div>
      </div>
      </div>

    <!-- Bootstrap core JavaScript -->
    <script src="sb_admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb_admin/vendor/popper/popper.min.js"></script>
    <script src="sb_admin/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="sb_admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="sb_admin/vendor/chart.js/Chart.min.js"></script>
    <script src="sb_admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="sb_admin/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for this template -->
    <script src="sb_admin/js/sb-admin.min.js"></script>

    <script src="sb_admin/js/aes.js"></script>
    <script>
      function encr(){
        var pass = document.getElementById("pass").value;
        var hash = CryptoJS.MD5(pass);
        document.getElementById('enc').value = hash;
        return true;
      }
    </script>

</body>
</html>