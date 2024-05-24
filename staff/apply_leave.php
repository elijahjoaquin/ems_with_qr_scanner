//try add filter dito sa pag apply
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
date_default_timezone_set('Asia/Manila');
	if(isset($_POST['apply']))
	{
	$empid=$session_id;
	$leave_type=$_POST['leave_type'];
	$fromdate=date('Y-m-d', strtotime($_POST['date_from']));
	$todate=date('Y-m-d', strtotime($_POST['date_to']));
	$description=$_POST['description'];  
	$status=0;
	$isread=0;
	$Gender=$_POST['Gender']; 
	$leave_days=$_POST['leave_days'];
	$leave_type=$_POST['leave_type'];
	$LeaveType=$_POST['LeaveType'];
	$Leave_Business=$_POST['Leave_Business'];
	$Leave_Emergency=$_POST['Leave_Emergency'];
	$Leave_Vacation=$_POST['Leave_Vacation'];
	$Leave_Paternity=$_POST['Leave_Paternity'];
	$Leave_Maternity=$_POST['Leave_Maternity'];
	$datePosting = date("Y-m-d");
    
    if($leave_type== 'Maternity Leave'&& $Gender == 'male'){
        echo "<script>alert('You cannot file this leave type');</script>";
        
    }
    elseif($leave_type== 'Paternity Leave'&& $Gender == 'female'){
        echo "<script>alert('You cannot file this leave type');</script>";
        
    }
    else{
    
	if($fromdate > $todate)
	{
	    echo "<script>alert('End Date should be greater than Start Date');</script>";
	  }
	  
	elseif( $leave_type== 'Vacation Leave' && $Leave_Vacation <= 0  )
	{
	    echo "<script>alert('You Have Exceeded Your Vacation Leave Limit. Leave Application Failed');</script>";
	  }
	  
	elseif( $leave_type== 'Emergency Leave' && $Leave_Emergency <= 0  )
	{
	    echo "<script>alert('You Have Exceeded Your Emergency Leave Limit. Leave Application Failed');</script>";
	  }
	  
    elseif( $leave_type== 'Paternity Leave' && $Leave_Paternity <= 0  )
	{
	    echo "<script>alert('You Have Exceeded Your Paternity Leave Limit. Leave Application Failed');</script>";
	  }
	  
	elseif( $leave_type== 'Maternity Leave' && $Leave_Maternity <= 0  )
	{
	    echo "<script>alert('You Have Exceeded Your Maternity Leave Limit. Leave Application Failed');</script>";
	  }
	  
	  
	  
    //Vacation Leave	  
	elseif($leave_type== 'Vacation Leave' && $Leave_Vacation > 0){
	    
	    $DF = date_create($_POST['date_from']);
		$DT = date_create($_POST['date_to']);

		$diff =  date_diff($DF , $DT );
		$num_days = (1 + $diff->format("%a"));
		
        if($num_days > $Leave_Vacation)
        {
             echo "<script>alert('Applied Days Exceeds Vacation Leave Limit. Leave Application Failed');</script>";
        }
        else
        {
            
        $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied Vacation Leave', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblleaves(LeaveType,FromDate,ToDate,Description,Status,IsRead,empid,num_days,PostingDate) VALUES(:leave_type,:fromdate,:todate,:description,:status,:isread,:empid,:num_days,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':leave_type',$leave_type,PDO::PARAM_STR);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':todate',$todate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':num_days',$num_days,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Vacation Leave Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}
	}
	
	//Emergency Leave
		elseif($leave_type== 'Emergency Leave' && $Leave_Emergency > 0){
	    
	    $DF = date_create($_POST['date_from']);
		$DT = date_create($_POST['date_to']);

		$diff =  date_diff($DF , $DT );
		$num_days = (1 + $diff->format("%a"));
		
        if($num_days > $Leave_Emergency)
        {
             echo "<script>alert('Applied Days Exceeds Emergency Leave Limit. Leave Application Failed');</script>";
        }
        else
        {
            
        $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied Emergency Leave', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) VALUES(:leave_type,:fromdate,:todate,:description,:status,:isread,:empid,:num_days,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':leave_type',$leave_type,PDO::PARAM_STR);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':todate',$todate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':num_days',$num_days,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Emergency Leave Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}
	}
	//Paternity Leave
		elseif($leave_type== 'Paternity Leave' && $Leave_Paternity > 0){
	    
	    $DF = date_create($_POST['date_from']);
		$DT = date_create($_POST['date_to']);

		$diff =  date_diff($DF , $DT );
		$num_days = (1 + $diff->format("%a"));
		
        if($num_days > $Leave_Paternity)
        {
             echo "<script>alert('Applied Days Exceeds Paternity Leave Limit. Leave Application Failed');</script>";
        }
        else
        {
            
        $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied Paternity Leave', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) VALUES(:leave_type,:fromdate,:todate,:description,:status,:isread,:empid,:num_days,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':leave_type',$leave_type,PDO::PARAM_STR);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':todate',$todate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':num_days',$num_days,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Paternity Leave Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}
	}
	
	//Maternity Leave
		elseif($leave_type== 'Maternity Leave' && $Leave_Maternity > 0){
	    
	    $DF = date_create($_POST['date_from']);
		$DT = date_create($_POST['date_to']);

		$diff =  date_diff($DF , $DT );
		$num_days = (1 + $diff->format("%a"));
		
        if($num_days > $Leave_Maternity)
        {
             echo "<script>alert('Maternity Applied Days Exceeds Maternity Leave Limit. Leave Application Failed');</script>";
        }
        else
        {
            
        $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied Maternity Leave', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) VALUES(:leave_type,:fromdate,:todate,:description,:status,:isread,:empid,:num_days,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':leave_type',$leave_type,PDO::PARAM_STR);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':todate',$todate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':num_days',$num_days,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Leave Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
	}
	}
	
	else {
		
		$DF = date_create($_POST['date_from']);
		$DT = date_create($_POST['date_to']);

		$diff =  date_diff($DF , $DT );
		$num_days = (1 + $diff->format("%a"));

        $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Applied Business Leave', '$PostingDate', '$empid', '$session_depart', 'Staff') 
		") or die(mysqli_error()); 
		
		$sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) VALUES(:leave_type,:fromdate,:todate,:description,:status,:isread,:empid,:num_days,:datePosting)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':leave_type',$leave_type,PDO::PARAM_STR);
		$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
		$query->bindParam(':todate',$todate,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->bindParam(':isread',$isread,PDO::PARAM_STR);
		$query->bindParam(':empid',$empid,PDO::PARAM_STR);
		$query->bindParam(':num_days',$num_days,PDO::PARAM_STR);
		$query->bindParam(':datePosting',$datePosting,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId)
		{
			echo "<script>alert('Business Leave Application was successful.');</script>";
			echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
		}
		else 
		{
			echo "<script>alert('Something went wrong. Please try again');</script>";
		}
		

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
								<h4>Leave Application</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Apply for Leave</li>
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
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label>Email Address</label>
											<input name="email" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['EmailId']; ?>">
										</div>
										
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<!--<label>Gender</label>-->
											<input name="Gender" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Gender']; ?>">
											
										</div>
										
									</div>
										
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
										
								    	    <input name="leave_days" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Av_leave']; ?>">
								    	    <input name="Leave_Business" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Leave_Business']; ?>">
								    	    <input name="Leave_Vacation" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Leave_Vacation']; ?>">
								    	    <input name="Leave_Emergency" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Leave_Emergency']; ?>">
								    	    <input name="Leave_Paternity" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Leave_Paternity']; ?>">
								    	    <input name="Leave_Maternity" type="hidden" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Leave_Maternity']; ?>">
											
									
									</div>
									</div>
									<?php endif ?>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label>Leave Type :</label>
											<select name="leave_type" class="custom-select form-control" required="true" autocomplete="off">
											<option value="">Select leave type...</option>
											<option value="Business Leave">Business Leave</option>
											<option value="Vacation Leave">Vacation Leave</option>
											<option value="Emergency Leave">Emergency Leave</option>
											<option value="Paternity Leave">Paternity Leave</option>
											<option value="Maternity Leave">Maternity Leave</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>Start Leave Date :</label>
											<input name="date_from" type="text" class="form-control date-picker" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label>End Leave Date :</label>
											<input name="date_to" type="text" class="form-control date-picker" required="true" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label>Reason For Leave :</label>
											<textarea id="textarea1" name="description" class="form-control" required length="150" maxlength="150" required="true" autocomplete="off"></textarea>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Apply&nbsp;Leave</button>
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