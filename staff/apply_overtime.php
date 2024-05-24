<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
    date_default_timezone_set('Asia/Manila');

	if(isset($_POST['apply']))
	{
	$empid=$session_id;
	$fromdate=date('m-d-Y', strtotime($_POST['date_from']));
	$description=$_POST['description'];  
	$status=0;
	$isread=0;
	$overtime_hours=$_POST['overtime_hours'];
	$datePosting = date("Y-m-d");
	//$num_hrs=$_POST['num_hrs'];
	$start_time=$_POST['start_time'];
	$end_time=$_POST['end_time'];
	$num_hrs = $end_time - $start_time;
    $check = is_numeric($num_hrs);
	if($overtime_hours <= 0)
	{
	    echo "<script>alert('You Have Exceeded Your Overtime Limit. Overtime Application Failed');</script>";
	  }
	  
	elseif($check != 1)
	{
		echo "<script>alert('Please enter valid number of hours');</script>";
		}
		
	elseif($num_hrs > $overtime_hours)
	{
		echo "<script>alert('You May Have Exceeded Your Overtime Limit, Please Enter Remaining Hours');</script>";
		}
		
	
		
	elseif($num_hrs <= 0 )
	{
		echo "<script>alert('Number of hours should be greater than zero');</script>";
		}
		
	else {
		
		$DF = date_create($_POST['date_from']);
		
		$PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied for Overtime', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblovertime(FromDate,Description,start_time,end_time,num_hrs,Status,IsRead,empid,PostingDate) VALUES(:fromdate,:description,:start_time,:end_time,:num_hrs,:status,:isread,:empid,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':num_hrs',$num_hrs,PDO::PARAM_STR);
		$query->bindParam(':start_time',$start_time,PDO::PARAM_STR);
		$query->bindParam(':end_time',$end_time,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Overtime Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'overtime_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}

	}

}

?>

<body>


	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pb-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Overtime Application</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Apply for Overtime</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div style="margin-left: 50px; margin-right: 50px;" class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Staff Form</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>

								<?php if ($role_id = 'Staff'): ?>
								<?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
								?>
						
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label >First Name </label>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['FirstName']; ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label >Last Name </label>
											<input name="lastname" type="text" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>Overtime Date :</label>
											<input name="date_from" type="text" class="form-control date-picker" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>Available Overtime Hours </label>
											<input name="overtime_hours" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Av_overtime']; ?>">
										</div>
									</div>
									<?php endif ?>
								</div>
								<div class="row">	
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>Start Time :</label>
											<input name="start_time" type="time" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>End Time :</label>
											<input name="end_time" type="time" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label>Reason For Overtime :</label>
											<textarea id="textarea1" name="description" class="form-control" required length="150" maxlength="150" required="true" autocomplete="off"></textarea>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Apply&nbsp;Overtime</button>
											</div>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php')?>
</body>
</html>