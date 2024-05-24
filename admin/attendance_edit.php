<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['edit_attendance']))
	{
	$date=date('Y-m-d', strtotime($date=$_POST['date']));
	
	$timein=$_POST['time_in'];
	$time_in = date('H:i:s', strtotime($timein));
	$timeout=$_POST['time_out'];
	$time_out = date('H:i:s', strtotime($timeout));


	$result = mysqli_query($conn,"update attendance set date='$date', time_in='$timein', time_out='$timeout' where id='$get_id'         
		"); 		
	if ($result) {
     	echo "<script>alert('Attendance Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'attendance.php'; </script>";
	} else{
	  die(mysqli_error());
   }
		
}
	if(isset($_POST['cancel_update']))
	{
		echo "<script type='text/javascript'> document.location = 'attendance.php'; </script>";
	}
	
?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Attendance Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Attendance Update</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Update Attendance</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									$query = mysqli_query($conn,"select * from attendance where id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Time in :</label>
											<input name="time_in" type="time" class="form-control" required="true" autocomplete="off" value="<?php echo $row['time_in']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Time out :</label>
											<input name="time_out" type="time" class="form-control" required="true" autocomplete="off" value="<?php echo $row['time_out']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Date :</label>
											<input name="date" type="date" class="form-control date-picker" required="true" autocomplete="off" value="<?php echo $row['date']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="edit_attendance" id="edit_attendance" data-toggle="modal">Update&nbsp;Attendance</button>
												<button class="btn btn-primary" name="cancel_update" id="cancel_update" data-toggle="modal">Cancel&nbsp;</button>
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