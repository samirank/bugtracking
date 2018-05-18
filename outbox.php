<?php include('template/header.php');?>



<?php
	include('class/view.php');
	$display 	= new display();
	$tab_name 	= "message_box";
	$cndtn   	= "msg_from=".$_SESSION['login_emp_id'];
	$result  	= $display->display_table_cndtn($tab_name, $cndtn);
 ?>


<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="inbox.php">Inbox</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="outbox.php">Outbox</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="create_message.php">Create Message</a>
  </li>
</ul>




<div class="card mb-3">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover" width="100%" id="dataTable" cellspacing="0">
        <thead>
          <tr>
            <th>Message to</th>
            <th>Title</th>
            <th>Date</th>
            <th>Status</th>
            <th>Open</th>
          </tr>
        </thead>
        <tbody>
          	<?php while($row=mysqli_fetch_assoc($result)){ ?>
          	<tr>
	    		<td>
	    			<?php $result2 = $display->display_table_cndtn('employee',"emp_id={$row['msg_to']}");
		    			 $emp_name = mysqli_fetch_assoc($result2);
		    			 echo $emp_name['emp_name'];
	    			?>
	    		</td>
	    		<td><?php echo $row['msg_title'] ?></td>
	    		<td><?php echo $row['msg_date'] ?></td>
	    		<td><?php echo $row['msg_status'] ?></td>
	    		<td><a href='view_message.php?msg_id=<?php echo $row['msg_id']; ?>'><button type='button' class='btn btn-primary btn-sm col-sm-10'>Open</button></a></td>
    		</tr>
    		<?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<?php include('template/footer.php');?>