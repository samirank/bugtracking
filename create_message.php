<?php include('template/header.php');?>


<?php 
$err=$_SESSION['err']??null;
unset($_SESSION['err']);
if($err==1){
  $err="<div class='alert alert-success alert-dismissible fade show col-sm-11' role='alert'>Message sent.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
}

 ?>



<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="inbox.php">Inbox</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="outbox.php">Outbox</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="create_message.php">Create Message</a>
  </li>
</ul>





 <form class="bg-light h-100 mt-4 pl-5 pt-3" method="POST" id="myform" action='action/new_message.php'>

	<div class="form-group row">
      <?php echo "$err"; ?>
    </div>


    <div class="form-group row">
    	<div class="col-sm-3"></div>
    </div>

	






	<?php if($_SESSION['login_user_type']=="admin"){ ?>


	<div class="form-group row required">
    	<div class="col-sm-1"></div>
    	<label for="inputMsgTo" class="col-sm-2 col-form-label">Message to</label>
	    <div class="col-sm-6">
	      <select class="form-control" id="inputMsgTo" name="inputMsgTo" data-validation="required" data-validation-error-msg="Please select an option.">
	      	
	      		
	      		<option disabled selected value="">Select</option>
	        	

	        	<?php
	        		include('class/view.php');
					$display=new display();
					$result=$display->display_table_cndtn("employee","emp_type IN ('Developer','Tester')"); 
	        		while($row=mysqli_fetch_assoc($result)){
		        	$result2=$display->display_table_cndtn("users","emp_id={$row['emp_id']}");
					$row_uid=mysqli_fetch_assoc($result2)
	        	?>
	        	

	        	<option value="<?php echo $row['emp_id']; ?>"><?php echo $row['emp_name']; ?> (<?php echo $row_uid['user_id']; ?>)</option>
	        
	        	<?php } ?>		//End of loop
	      </select>
	    </div>
    </div>

    <?php } ?>






	

	<div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="msgtitle" class="col-sm-2 col-form-label">Subject</label>
	      <div class="col-sm-6">
	        <input type="text" name="msgtitle" placeholder="Write subject" data-validation='required' class="form-control">
	      </div>
    </div>








    <div class="form-group row">
    	<div class="col-sm-1"></div>
      	<label for="inputMsg" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-6">
	        <textarea name="inputMsg" placeholder="Write New Message" class="form-control" id="exampleFormControlTextarea1" rows="3" data-validation="required"  ></textarea>
	      </div>
    </div>









    <div class="form-group row">
	    <div class="col-sm-1"></div>
	    <label for="send" class="col-sm-2 col-form-label"></label>
	    <div class="col-sm-3">
	        <input type="submit" class="btn-primary form-control" id="send" name="send" value="send">
	    </div>
    </div>


</form>








<?php include('template/footer.php');?>