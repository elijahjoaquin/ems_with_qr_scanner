<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php 
	 if (isset($_GET['delete'])) {
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
 if(isset($_POST['add']))
{
	 $department=$_POST['department'];
	$time=$_POST['time'];
    $day=$_POST['day'];

     $query = mysqli_query($conn,"select * from schedule where Department = '$department'")or die(mysqli_error());
	 $count = mysqli_num_rows($query);
     
     if ($count > 0){ 
     	echo "<script>alert('Schedule Already exist');</script>";
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
						
						<center><div class="col-lg-8 col-md-6 col-sm-12 mb-30"></center>
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
											
										</tr>
										</thead>
										<tbody>

										<?php $query= mysqli_query($conn,"select * from schedule join tblemployees where emp_id = '$session_id'")or die(mysqli_error());
										$row = mysqli_fetch_array($query);
										?> 

											<tr>
												<td> <?php echo $row['id'];;?></td>
	                                            <td><?php echo $row['Department'];?></td>
	                                            <td><?php echo $row['Time'];?></td>
                                                <td><?php echo $row['Day'];?></td>
												
											</tr>

											

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<br>
				<?php include('includes/footer.php'); ?>
				</div>

			
		</div>
	</div>

	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>