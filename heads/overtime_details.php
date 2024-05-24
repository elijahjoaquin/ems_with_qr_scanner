<?php error_reporting(0);?>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
	// code for update the read notification status
	$isread=1;
	$did=intval($_GET['overtimeid']);  
	date_default_timezone_set('Asia/Manila');
	$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
	$sql="update tblovertime set IsRead=:isread where id=:did";
	$query = $dbh->prepare($sql);
	$query->bindParam(':isread',$isread,PDO::PARAM_STR);
	$query->bindParam(':did',$did,PDO::PARAM_STR);
	$query->execute();

	// code for action taken on leave
	if(isset($_POST['update']))
	{ 
		$did=intval($_GET['overtimeid']);
		$description=$_POST['description'];
		$status=$_POST['status'];   
		$av_overtime=$_POST['av_overtime'];
		$num_hrs=$_POST['num_hrs'];

		// $REMLEAVE = $av_leave - $num_days;
		$reg_remarks = 'Overtime was Rejected. Registra/Registry will not see it';
		$reg_status = 2;
		date_default_timezone_set('Asia/Manila');
		$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));

		if ($status === '2') {
		    $date = date('Y-m-d H:i:s');
		mysqli_query($conn,"INSERT INTO auditlog(Action, PostingDate, Actor_ID, Department, Role, Recipient_ID) VALUES('Manager Rejected Overtime', '$date', '$session_id', '$session_depart', 'HOD', '$did')         
		") or die(mysqli_error());
			$result = mysqli_query($conn,"update tblovertime, tblemployees set tblovertime.AdminRemark='$description',tblovertime.Status='$status',tblovertime.AdminRemarkDate='$admremarkdate', tblovertime.registra_remarks = '$reg_remarks', tblovertime.admin_status = '$reg_status' where tblovertime.empid = tblemployees.emp_id AND tblovertime.id='$did'");

				if ($result) {
			     	echo "<script>alert('Overtime updated Successfully');</script>";
					} else{
					  die(mysqli_error());
				   }
		}
		elseif ($status === '1') {
		    $date = date('Y-m-d H:i:s');
		mysqli_query($conn,"INSERT INTO auditlog(Action, PostingDate, Actor_ID, Department, Role, Recipient_ID) VALUES('Manager Approved Overtime', '$date', '$session_id', '$session_depart', 'HOD', '$did')         
		") or die(mysqli_error());
				$result = mysqli_query($conn,"update tblovertime, tblemployees set tblovertime.AdminRemark='$description',tblovertime.Status='$status',tblovertime.AdminRemarkDate='$admremarkdate' where tblovertime.empid = tblemployees.emp_id AND tblovertime.id='$did'");

				if ($result) {
			     	echo "<script>alert('Overtime updated Successfully');</script>";
					} else{
					  die(mysqli_error());
				   }
		}
		elseif ($status === '0') {
				$result = mysqli_query($conn,"update tblovertime, tblemployees set tblovertime.AdminRemark='$description',tblovertime.Status='$status',tblovertime.AdminRemarkDate='$admremarkdate' where tblovertime.empid = tblemployees.emp_id AND tblovertime.id='$did'");

				if ($result) {
			     	echo "<script>alert('Overtime updated Successfully');</script>";
					} else{
					  die(mysqli_error());
				   }
		}
	
	}

		// date_default_timezone_set('Asia/Kolkata');
		// $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));

		// $sql="update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";

		// $query = $dbh->prepare($sql);
		// $query->bindParam(':description',$description,PDO::PARAM_STR);
		// $query->bindParam(':status',$status,PDO::PARAM_STR);
		// $query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
		// $query->bindParam(':did',$did,PDO::PARAM_STR);
		// $query->execute();
		// echo "<script>alert('Leave updated Successfully');</script>";

?>

<style>
	input[type="text"]
	{
	    font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
	  color: #fff;
	  background-color: #524d7d;
	  border-color: #524d7d; 
	}

	textarea { 
		font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	textarea.text_area{
        height: 8em;
        font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
      }

	</style>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>OVERTIME DETAILS</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Overtime</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Overtime Details</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<form method="post" action="">

						<?php 
						if(!isset($_GET['overtimeid']) && empty($_GET['overtimeid'])){
							header('Location: admin_dashboard.php');
						}
						else {
						
						$oid=intval($_GET['overtimeid']);
						$sql = "SELECT tblovertime.id as oid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_overtime,tblovertime.FromDate,tblovertime.Description,tblovertime.PostingDate,tblovertime.Status,tblovertime.AdminRemark,tblovertime.admin_status,tblovertime.registra_remarks,tblovertime.AdminRemarkDate,tblovertime.num_hrs,tblovertime.start_time,tblovertime.end_time from tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id where tblovertime.id=:oid";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':oid',$oid,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result)
						{         
						?>  

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Full Name</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->FirstName." ".$result->LastName);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Email Address</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->EmailId);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Phone Number</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->Phonenumber);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied Date</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->PostingDate);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Available No. of Overtime Hours</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly name="av_overtime" value="<?php echo htmlentities($result->Av_overtime);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied No. of Overtime Hours</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly name="num_hrs" value="<?php echo htmlentities($result->num_hrs);?>">
								</div>
							</div>				
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Date of Overtime</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->FromDate);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Start Time</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->start_time);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>End Time</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->end_time);?>">
								</div>
							</div>
						</div>
						<div class="form-group row">
								<label style="font-size:16px;" class="col-sm-12 col-md-2 col-form-label"><b>Overtime Reason</b></label>
								<div class="col-sm-12 col-md-10">
									<textarea name=""class="form-control text_area" readonly type="text"><?php echo htmlentities($result->Description);?></textarea>
								</div>
						</div>
						<div class="form-group row">
								<label style="font-size:16px;" class="col-sm-12 col-md-2 col-form-label"><b>HOD Remarks</b></label>
								<div class="col-sm-12 col-md-10">
									<?php
									if ($result->AdminRemark==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Waiting for Approval"; ?>">
									<?php else: ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->AdminRemark); ?>">
									<?php endif ?>
								</div>
						</div>
						<div class="form-group row">
								<label style="font-size:16px;" class="col-sm-12 col-md-2 col-form-label"><b>Admin Remarks</b></label>
								<div class="col-sm-12 col-md-10">
									<?php
									if ($result->registra_remarks==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Waiting for Approval"; ?>">
									<?php else: ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->registra_remarks); ?>">
									<?php endif ?>
								</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								   <label style="font-size:16px;"><b>Action Taken Date</b></label>
								   <?php
									if ($result->AdminRemarkDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->AdminRemarkDate); ?>">
									<?php endif ?>

								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size:16px;"><b>Overtime Status From HOD</b></label>
									<?php $stats=$result->Status;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size:16px;"><b>Registra/Registry Status</b></label>
									<?php $ad_stats=$result->admin_status;?>
									<?php
									if ($ad_stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($ad_stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<?php 
							if(($stats==0 AND $ad_stats==0))
							  {

							 ?>
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size:16px;"><b></b></label>
									<div class="modal-footer justify-content-center">
										<button class="btn btn-primary" id="action_take" data-toggle="modal" data-target="#success-modal">Take&nbsp;Action</button>
									</div>
								</div>
							</div>
							
							<form name="adminaction" method="post">
  								<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 class="mb-20">Overtime take action</h4>
												<select name="status" required class="custom-select form-control">
													<option value="">Choose your option</option>
				                                          <option value="1">Approved</option>
				                                          <option value="2">Rejected</option>
				                                          <option value="0">Pending</option>
												</select>

												<div class="form-group">
													<label></label>
													<textarea id="textarea1" name="description" class="form-control" required placeholder="Description" length="300" maxlength="300"></textarea>
												</div>
											</div>
											<div class="modal-footer justify-content-center">
												<input type="submit" class="btn btn-primary" name="update" value="Submit">
											</div>
										</div>
									</div>
								</div>
  							</form>

							<?php }?>
						</div>

						<?php $cnt++;} } }?>
					</form>
				</div>

			</div>
			
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>