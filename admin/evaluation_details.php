<?php include('../includes/session.php')?>
<?php include('includes/header.php')?>

<?php $get_id = $_GET['edit']; ?>
<?php
    date_default_timezone_set('Asia/Manila');
    
	if(isset($_POST['add_staff']))
	{
	
	

	$question1=$_POST['question1'];
	$question2=$_POST['question2'];
	$question3=$_POST['question3'];
	$question4=$_POST['question4'];
	$question5=$_POST['question5'];
	$remarks=$_POST['remarks'];
	$datePosting = date("Y-m-d");
	$empid=$get_id;
	    
	    $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Administrator Applied Manager Evaluation', '$PostingDate', '$session_id', '$session_depart', 'Admin') 
		") or die(mysqli_error()); 
		
	    $sql="INSERT INTO tblevaluation(Question1, Question2, Question3, Question4, Question5, Remarks, PostingDate,  empid) VALUES(:question1,:question2,:question3,:question4,:question5,:remarks, :datePosting,:empid)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':question1',$question1,PDO::PARAM_STR);
		$query->bindParam(':question2',$question2,PDO::PARAM_STR);
		$query->bindParam(':question3',$question3,PDO::PARAM_STR);
		$query->bindParam(':question4',$question4,PDO::PARAM_STR);
		$query->bindParam(':question5',$question5,PDO::PARAM_STR);
		$query->bindParam(':remarks',$remarks,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);

		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		
		if ($sql){
		
		echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'evaluation.php'; </script>";
	} else{
	  die(mysqli_error($conn));    
		}
		    



//$result = mysqli_query($conn,"update tblevaluation set  Question1= '$question1', Question2= '$question2',   where emp_id='$get_id'         
		//"); 		
	/*if ($result) {
     	echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'evaluation.php'; </script>";
	} else{
	  die(mysqli_error());
   }*/
		
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
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Evaluation</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Evaluate HOD</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									/*$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>

								
								
									<!--<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Question 1 :</label>
											<select name="question1" class="custom-select form-control" required="true" autocomplete="off">
												<?php/*
													$query_staff = mysqli_query($conn,"select * from tblemployees join tblquestions where emp_id = '$get_id'")or die(mysqli_error());
													$row_staff = mysqli_fetch_array($query_staff);
													
												 ?>
													
													<?php
													$query = mysqli_query($conn,"select * from tblquestions");
													while($row = mysqli_fetch_array($query)){
													
													?>
													<option value="<?php echo $row['Question1']; ?>"><?php echo $row['Question1']; ?></option>
													<?php } */?>
													
											</select>
										</div>
									</div> 
									
									
									<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="form-group">
											<label>Does the employee show strong initiative?</label>
											<select name="question1" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select Answer...</option>
											<?php $sql = "SELECT  Question1 from tblquestions";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>                                            
											<option value="<?php echo htmlentities($result->Question1);?>"><?php echo htmlentities($result->Question1);?></option>
											<?php }} ?>
											</select>
										</div>
									</div>
								</div>
								
									<div class="row">
									<div class="col-md-7 col-sm-13">
										<div class="form-group">
											<label> Does the employee stay focused on the tasks at hand? </label>
											<select name="question2" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select Answer...</option>
											<?php $sql = "SELECT  Question2 from tblquestions";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>                                            
											<option value="<?php echo htmlentities($result->Question2);?>"><?php echo htmlentities($result->Question2);?></option>
											<?php }} ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-7 col-sm-13">
										<div class="form-group">
											<label> Does the employee have good communication with coworkers? </label>
											<select name="question3" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select Answer...</option>
											<?php $sql = "SELECT  Question3 from tblquestions";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>                                            
											<option value="<?php echo htmlentities($result->Question3);?>"><?php echo htmlentities($result->Question3);?></option>
											<?php }} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-7 col-sm-13">
										<div class="form-group">
											<label> Does the employee arrive on time every day? </label>
											<select name="question4" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select Answer...</option>
											<?php $sql = "SELECT  Question4 from tblquestions";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>                                            
											<option value="<?php echo htmlentities($result->Question4);?>"><?php echo htmlentities($result->Question4);?></option>
											<?php }} ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-7 col-sm-13">
										<div class="form-group">
											<label> Is the employee dependable? </label>
											<select name="question5" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select Answer...</option>
											<?php $sql = "SELECT  Question5 from tblquestions";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>                                            
											<option value="<?php echo htmlentities($result->Question5);?>"><?php echo htmlentities($result->Question5);?></option>
											<?php }} ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
								<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label>Remarks</label>
											<textarea id="textarea1" name="remarks" class="form-control" required length="150" maxlength="150" required="true" autocomplete="off"></textarea>
										</div>
									</div>
						</div>
					
								
								

								<?php
									/*$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$new_row = mysqli_fetch_array($query);
									*/?> 
								<div class="row">
									
									

									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Submit Evaluation</button>
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