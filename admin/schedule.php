<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php 
date_default_timezone_set('Asia/Manila');

	 if (isset($_GET['delete'])) {
	     
	     $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Administrator Deleted Existing Schedule', '$PostingDate', '$empid', '$session_depart', 'HOD') 
		") or die(mysqli_error()); 
	     
		$schedule_id = $_GET['delete'];
		$sql = "DELETE FROM schedule where id = ".$schedule_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Schedule deleted Successfully');</script>";
     		echo "<script type='text/javascript'> document.location = 'schedule.php'; </script>";
			
		}
	}
?>

<?php
date_default_timezone_set('Asia/Manila');

 if(isset($_POST['add']))
{
    $PostingDate = date('Y-m-d H:i:s');
        mysqli_query($conn,"INSERT INTO auditlog (Action, PostingDate, Actor_ID, Department, Role) VALUES('Administrator Added New Schedule', '$PostingDate', '$empid', '$session_depart', 'HOD') 
		") or die(mysqli_error());
    
    $department=$_POST['department'];
	$time=$_POST['time'];
    $day=$_POST['day'];

     $query = mysqli_query($conn,"select * from schedule where Department = '$department' ")or die(mysqli_error());
	 $count = mysqli_num_rows($query);
     
     if ($count > 0){ 
     	echo "<script>alert('Schedule Already Exists. Please Try Again');</script>";
      }
      else{
        $query = mysqli_query($conn,"insert into schedule (Department, Time, Day)
  		 values ('$department', '$time', '$day')      
		") or die(mysqli_error()); 

		if ($query) {
			echo "<script>alert('Schedule Added Successfully');</script>";
			echo "<script type='text/javascript'> document.location = 'schedule.php'; </script>";
		}
    }

}

?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Schedule List</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Schedules</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">New Schedule</h2>
								<section>
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Department :</label>
												<select name="department" class="custom-select form-control" required="true" autocomplete="off">
													<option value="">Select Department</option>
													<?php
													$query = mysqli_query($conn,"select * from tbldepartments");
													while($row = mysqli_fetch_array($query)){
													
													?>
													<option><?php echo $row['DepartmentName']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Time in</label>
												<input name="timein" type="text" class="form-control" required="true" autocomplete="off" 
											</div>
													
										</div>
									</div>
									
										<div class="col-md-12">
											<div class="form-group">
												<label>Time out</label>
												<input name="timeout" type="text" class="form-control" required="true" autocomplete="off" >
											</div>
													
										</div>
									
									<div class="col-md-12">
										<div class="form-group">
												<label>Day</label>
												<input name="day" type="text" class="form-control" required="true" autocomplete="off" >
											</div>
									</div>
									<div class="col-md-12">
										<div class="dropdown">
										   <input class="btn btn-primary" type="submit" value="REGISTER" name="add" id="add">
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Schedule</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th>NO.</th>
											<th class="table-plus">DEPARTMENT</th>
											<th>TIME</th>
                                            <th>DAY</th>
											<th class="datatable-nosort">ACTION</th>
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from schedule";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												<td> <?php echo htmlentities($cnt);?></td>
	                                            <td><?php echo htmlentities($result->Department);?></td>
	                                            <td><?php echo htmlentities($result->Time_in);?> <?php echo " - "?><?php echo htmlentities($result->Time_out);?></td>
                                                <td><?php echo htmlentities($result->Day);?></td>
												<td>
													<div class="table-actions">
														<a href="edit_schedule.php?edit=<?php echo htmlentities($result->id);?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
														<a href="schedule.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
													</div>
												</td>
											</tr>

											<?php $cnt++;} }?>  

										</tbody>
									</table>
								</div>
							</div>
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