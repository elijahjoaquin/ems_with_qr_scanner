<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php include('attendance_export_csv.php')?>

<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM attendance where id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Attendance deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'attendance.php'; </script>";	
	}
}

?>
<script>
function confirmationDelete(anchor)
{
   var conf = confirm('Are you sure want to delete this record?');
   if(conf)
      window.location=anchor.attr("href");
}
</script>
<style>
	.row1 {
		width: 50%;
		float: left;
	}	
	.row2 {
		width: 50%;
		float: right;
	}	
</style>
<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="page-header">
				<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Attendance Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">All Attendances</li>
								</ol>
							</nav>
						</div>
				</div>
			</div>

<?php echo $noResult;?>

<div class="row1">
<form method="post">
	<div class="col-md-15 col-sm-12">
		<div class="form-group">
			<label>From Date :</label>
				<input type="date" name="fromDate" class="form-control " value="<?php echo date("Y-m-d"); ?>" />
				<?php echo $startDateMessage; ?>
		</div>
	</div>
	<div class="col-md-15 col-sm-12">
		<div class="form-group">
			<label>To Date :</label>
				<input type="date" name="toDate" class="form-control " value="<?php echo date("Y-m-d"); ?>" />
				<?php echo $endDate; ?>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
				<input name="export" type="submit" class="btn btn-primary" value="Export to CSV"/>
		</div>
	</div>
	</form>
</div>

<div class="row2">
<form method="post" action = "attendance_report.php">
	<div class="col-md-15 col-sm-12">
		<div class="form-group">
			<label>From Date :</label>
				<input type="date" name="fromDate" class="form-control " value="<?php echo date("Y-m-d"); ?>" />
				<?php echo $startDateMessage; ?>
		</div>
	</div>
	<div class="col-md-15 col-sm-12">
		<div class="form-group">
			<label>To Date :</label>
				<input type="date" name="toDate" class="form-control " value="<?php echo date("Y-m-d"); ?>" />
				<?php echo $endDate; ?>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
				<input name="export2" type="submit" class="btn btn-primary" value="Export to PDF"/>
		</div>
	</div>
	</form>
</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ATTENDANCE LIST</h2>
					</div>
				<div class="pb-20">
				
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">#</th>
								<th class="table-plus">STAFF NAME</th>
								<th>QR Code</th>
								<th>DATE</th>
								<th class="datatable-nosort">TIME IN</th>
								<th class="datatable-nosort">TIME OUT</th>
								<th>STATUS</th>
								<th>NO. OF HOURS</th>
								<th>OT HOURS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$status=1;
								$sql = "SELECT tblemployees.qr_id AS empid, attendance.id as aid,tblemployees.FirstName,tblemployees.LastName,
								tblemployees.location,tblemployees.emp_id,attendance.date,attendance.time_in,
								attendance.time_out, attendance.status, attendance.num_hr, attendance.ot_hrs 
								from attendance
								join tblemployees on attendance.qr_id=tblemployees.emp_id 
								order by date desc";
									$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
									$cnt =1;
									while ($row = mysqli_fetch_array($query)) {
										if($row['time_out']=='00:00:00'){
											$timeout='No Out';
										}
										else{
											$timeout =date('H:i A', strtotime($row['time_out']));
										}
										if($row['time_in']>'08:10:00'){
											$status='1';
										}else{
											$status='0';
										}	
									
								 ?>  
								<td><?php echo $cnt;?></td>
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['empid']; ?></td>
								<td><?php echo date('M d, Y', strtotime($row['date']));?></td>
								<td><?php echo date('H:i A', strtotime($row['time_in'])); ?></td>
	                            <td><?php echo $timeout; ?></td>
								<td><?php if($status==0){?>
	                                  <span style="color: green">On-time</span>
	                                  <?php } if($status==1)  { ?>
	                                 <span style="color: orange">Late</span>
									<?php } ?>
								<td><?php echo $row['num_hr']; ?></td>
								<td><?php echo $row['ot_hrs']; ?></td>
								<td>
									<div class="table-actions">
										<a href="attendance_edit.php?edit=<?php echo $row['aid'];?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
										<a onclick='javascript:confirmationDelete($(this));return false;' href="attendance.php?delete=<?php echo $row['aid'] ?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
									</div>
								</td>

							</tr>
							<?php $cnt++;}?>
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- buttons for Export datatable -->
	<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
	
	<script src="../vendors/scripts/datatable-setting.js"></script></body>
</body>
</html>

