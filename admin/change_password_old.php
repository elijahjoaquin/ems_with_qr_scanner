<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_staff']))
	{
		//get POST data
		$old = $_POST['old'];
		$new = $_POST['new'];
		$retype = $_POST['retype'];
		$password=md5($_POST['password']); 
		
		//create a session for the data incase error occurs
		$_SESSION['old'] = $old;
		$_SESSION['new'] = $new;
		$_SESSION['retype'] = $retype;

		//connection
		$conn = new mysqli('localhost', 'root', '', 'leave_staff');

		//get user details
		$sql = "SELECT * FROM tblemployees WHERE emp_id = '".$_SESSION['alogin']."'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		//check if old password is correct
		if(password_verify($old, $row['{Password'])){
			//check if new password match retype
			if($new == $retype){
				//hash our password
				$password = password_hash($new, PASSWORD_DEFAULT);

				//update the new password
				$sql = "UPDATE tblemployees SET Password = '$password' WHERE emp_id = '".$_SESSION['alogin']."'";
				if($conn->query($sql)){
					$_SESSION['success'] = "Password updated successfully";
					//unset our session since no error occured
					unset($_SESSION['old']);
					unset($_SESSION['new']);
					unset($_SESSION['retype']);
				}
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
			else{
				$_SESSION['error'] = "New and retype password did not match";
			}
		}
		else{
			$_SESSION['error'] = "Incorrect Old Password";
		}
	}
	else{
		$_SESSION['error'] = "Input needed data to update first";
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
								<h4>Staff Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff Edit</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Edit Staff</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>

								<!--
                                    <div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >First Name :</label>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $row['FirstName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Last Name :</label>
											<input name="lastname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Email Address :</label>
											<input name="email" type="email" class="form-control" required="true" autocomplete="off" value="<?php echo $row['EmailId']; ?>">
										</div>
									</div>
								</div>
                            -->
									<div class="row">
										<div class="col-md-4 col-md-5">
											<div class="form-group">
											<label>Old Password :</label>
											<input name="old" type="password" id="old" class="form-control" value="<?php echo (isset($_SESSION['old'])) ? $_SESSION['old'] : ''; ?>">
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 col-md-12">
											<div class="form-group">
											<label>New Password :</label>
											<input name="new" type="password" id="new" class="form-control" value="<?php echo (isset($_SESSION['new'])) ? $_SESSION['new'] : ''; ?>">
										</div>
									</div>
                                    
									<div class="col-md-4 col-md-12">
										<div class="form-group">
											<label>Confirm  New Password :</label>
											<input name="retype" type="password" id="retype" class="form-control" value="<?php echo (isset($_SESSION['retype'])) ? $_SESSION['retype'] : ''; ?>">
										</div>
									</div>
                                    
									<!--
                                    <div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Gender :</label>
											<select name="gender" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $row['Gender']; ?>"><?php echo $row['Gender']; ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Phone Number :</label>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['Phonenumber']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Date Of Birth :</label>
											<input name="dob" type="text" class="form-control date-picker" required="true" autocomplete="off"value="<?php echo $row['Dob']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Address :</label>
											<input name="address" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['Address']; ?>">
										</div>
									</div>
                            -->
                            <!--
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Department :</label>
											<select name="department" class="custom-select form-control" required="true" autocomplete="off">
												<?php
													$query_staff = mysqli_query($conn,"select * from tblemployees join  tbldepartments where emp_id = '$get_id'")or die(mysqli_error());
													$row_staff = mysqli_fetch_array($query_staff);
													
												 ?>
												<option value="<?php echo $row_staff['DepartmentShortName']; ?>"><?php echo $row_staff['DepartmentName']; ?></option>
													<?php
													$query = mysqli_query($conn,"select * from tbldepartments");
													while($row = mysqli_fetch_array($query)){
													
													?>
													<option value="<?php echo $row['DepartmentShortName']; ?>"><?php echo $row['DepartmentName']; ?></option>
													<?php } ?>
											</select>
										</div>
									</div>
                            -->    
								</div>

								<?php
									$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$new_row = mysqli_fetch_array($query);
	                     	    ?>
                                <!--
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Staff Leave Days :</label>
											<input name="leave_days" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $new_row['Av_leave']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Staff Overtime :</label>
											<input name="overtime_hours" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $new_row['Av_overtime']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>User Role :</label>
											<select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $new_row['role']; ?>"><?php echo $new_row['role']; ?></option>
												<option value="Admin">Admin</option>
												<option value="HOD">HOD</option>
												<option value="Staff">Staff</option>
											</select>
										</div>
									</div>
                                -->
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Update&nbsp;Staff</button>
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