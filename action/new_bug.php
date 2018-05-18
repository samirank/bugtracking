 <?php
/*Used to add a new bug to the database
 Can be access by the teter in the bugs moodule*/
include ('../class/insert.php');
include ('../class/update.php');
session_start();

$target_dir       = "../uploads/";
$path_parts       = pathinfo($target_dir . $_FILES["inputFile"]["name"]);
$target_file      = $target_dir . str_replace(" ", "_", $path_parts['filename']) . "_" . $_SESSION['login_emp_id'] . "_" . str_replace(".", "_", microtime(true)) . "." . $path_parts['extension'];
$uploadOk         = 1;
$imageFileType    = pathinfo($target_file, PATHINFO_EXTENSION);

if (isset($_POST['submit'])) {
  $inputAppid       = $_POST['inputAppid'];
  $inputModId       = $_POST['inputModId'];
  $inputBugTitle    = $_POST['inputBugTitle'];
  $inputDescription = $_POST['inputDescription'];
  $inputUrl         = $_POST['inputUrl'];
  $appearedOn       = $_POST['appearedOn'];
  $bugTester        = $_SESSION['login_emp_id'];

  //check if the file is an image
  $check            = getimagesize($_FILES["inputFile"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  }
  else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["inputFile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["inputFile"]["tmp_name"], $target_file)) {
      echo "The file " . basename($_FILES["inputFile"]["name"]) . " has been uploaded.";
    }
    else {
      echo "Sorry, there was an error uploading your file.";
    }

    //Insert data into database
    $create = new insert();
    $err    = $create->new_bug($inputAppid, $inputModId, $inputBugTitle, $inputDescription, $inputUrl, $appearedOn, $target_file, $bugTester);
    if ($err) {
      $update = new update_data();
      $update->bug_counter($inputAppid, "add");
      $_SESSION['err'] = 1;
      header("location: ../update_bug.php?app_id=$inputAppid");
    }
  }

}
?>
