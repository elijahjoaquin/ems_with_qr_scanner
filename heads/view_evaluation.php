<?php include('../includes/session.php')?>
<?php include('includes/header.php')?>

<?php $get_id = $_GET['edit']; ?>
<?php
if(isset($_POST['cancel_update']))
    {
        echo "<script type='text/javascript'> document.location = 'evaluation.php'; </script>";
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
								<h4>Evaluation Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">View Evaluation</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Evaluation</h4>
							<p class="mb-20"></p>
						</div>
						
						
					</div>
					<div class="clearfix">
					<?php
									$query = mysqli_query($conn,"select * from tblevaluation where id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>
						<div class="pull-left">
							<h4 class="text-blue h4">Date Evaluated: <?php echo $row['PostingDate']?></h4>
							
							
						</div>	
						
						
					</div>
					
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									$query = mysqli_query($conn,"select * from tblevaluation where id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>
								
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Does the employee show strong initiative?</label>
											<input name="question1" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Question1']; ?>">
										</div>
									</div>
									
									<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Does the employee stay focused on the tasks at hand?</label>
											<input name="question2" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Question2']; ?>">
										</div>
									</div>
									
									
								</div>
								<div class= "row">
								<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Does the employee have good communication with coworkers?</label>
											<input name="question3" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Question3']; ?>">
										</div>
									</div>
									
									<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Does the employee arrive on time every day?</label>
											<input name="question4" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Question4']; ?>">
										</div>
									</div>
									
									<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Is the employee dependable?</label>
											<input name="question5" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Question5']; ?>">
										</div>
									</div>
									</div>
									
								<div class="form-group row">
								<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<textarea name="remarks"class="form-control text_area" readonly type="text"><?php echo $row['Remarks'];?></textarea>
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="cancel_update" id="cancel_update" data-toggle="modal">Exit&nbsp;</button>
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