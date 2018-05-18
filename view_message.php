<?php 
	include('template/header.php');

	$err = $_SESSION['err']??null;
	unset($_SESSION['err']);
	if(isset($_GET['msg_id'])){
		$msg_id = $_GET['msg_id'];
	}
	else{
		$err = "<div class='alert alert-danger alert-dismissible fade show col-sm-11' role='alert'>Message not found.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
	}
 ?>


<?php 
	include('class/view.php');
	$display =  new display();
	$result = $display->display_table_cndtn('message_box',"msg_id='$msg_id'");
	$row=mysqli_fetch_assoc($result);

 ?>

<?php 
	if($row["msg_to"]==$_SESSION['login_emp_id']){
		include('class/update.php');
		$update = new update_data();
		$update->update_msg_status($msg_id);
	}

 ?>





<form class="bg-light h-100 mt-4 pl-5 pt-3">

	<div class="form-group row">
      <?php echo "$err"; ?>
    </div>


    <div class="form-group row">
    	<div class="col-sm-3"></div>
    </div>

	







	<div class="form-group row">
    	<div class="col-sm-1"></div>
    	<label for="msgfrom" class="col-sm-2 col-form-label">From</label>
	    <div class="col-sm-6">
	    	<span class="form-control">
	    		<?php $result2 = $display->display_table_cndtn('employee',"emp_id={$row['msg_from']}");
	    			 $emp_name = mysqli_fetch_assoc($result2);
	    			 echo $emp_name['emp_name'];
	    		?>
	    	</span>
	    </div>
    </div>







    <div class="form-group row">
    	<div class="col-sm-1"></div>
    	<label for="msgto" class="col-sm-2 col-form-label">To</label>
	    <div class="col-sm-6">
	    	<span class="form-control">
	    		<?php $result2 = $display->display_table_cndtn('employee',"emp_id={$row['msg_to']}");
	    			 $emp_name = mysqli_fetch_assoc($result2);
	    			 echo $emp_name['emp_name'];
	    		?>
	    	</span>
	    </div>
    </div>







	<div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="msgdate" class="col-sm-2 col-form-label">Date</label>
	      <div class="col-sm-3">
	        <span class="form-control"><?php echo $row['msg_date'] ?></span>
	      </div>
	      <div class="col-sm-3">
	        <span class="form-control"><?php echo $row['msg_time'] ?></span>
	      </div>
    </div>



	

	<div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="msgtitle" class="col-sm-2 col-form-label">Subject</label>
	      <div class="col-sm-6">
	        <span class="form-control"><?php echo $row['msg_title'] ?></span>
	      </div>
    </div>

	




    <div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="inputMsg" class="col-sm-2 col-form-label">Message</label>
	      <div class="col-sm-6">
	        <span class="form-control"><?php echo $row['msg_desc'] ?></span>
	      </div>
    </div>





    <div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="msgstatus" class="col-sm-2 col-form-label">Status</label>
	      <div class="col-sm-6">
	        <span class="form-control"><?php echo $row['msg_status'] ?></span>
	      </div>
    </div>









    <div class="form-group row">
	    <div class="col-sm-2"></div>
	    <label for="goback" class="col-sm-2 col-form-label"></label>
	    <div class="col-sm-4">
	    	<a href="javascript:history.go(-1)"><input type="button" class="btn-primary form-control" id="goback" name="goback" value="Go to previous page"></a>
	    </div>
    </div>


</form>





 <?php include('template/footer.php'); ?>