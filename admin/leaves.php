<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php include('leave_export_employee_csv.php')?>
<?php include('leave_export_manager_csv.php')?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM tblleaves where id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Leave deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'leaves.php'; </script>";
		
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
								<h4>Leave Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">All Leave</li>
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
<form method="post" action = "leave_report_employees.php">
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
						<h2 class="text-blue h4">ALL LEAVE APPLICATIONS OF EMPLOYEES</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>HOD STATUS</th>
								<th>ADMIN STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$status=1;
								$sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.Status, tblleaves.admin_status from tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id where tblleaves.Status= '$status' order by lid ";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {

								 ?>  

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
								<td><?php echo $row['LeaveType']; ?></td>
	                            <td><?php echo $row['PostingDate']; ?></td>
								<td><?php $stats=$row['Status'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
	                            <td><?php $stats=$row['admin_status'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="leave_details.php?leaveid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i> View</a>
											<a onclick='javascript:confirmationDelete($(this));return false;' class="dropdown-item" href="leaves.php?delete=<?php echo $row['lid'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
											
										</div>
									</div>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
			   </div>
			</div>

<?php echo $noResult2;?>

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
				<input name="export3" type="submit" class="btn btn-primary" value="Export to CSV"/>
		</div>
	</div>
	</form>
</div>

<div class="row2">
<form method="post" action = "leave_report_managers.php">
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
						<h2 class="text-blue h4">ALL LEAVE APPLICATIONS OF MANAGERS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>ADMIN STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$status=0;
								$sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.Status, tblleaves.admin_status from tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id where tblleaves.Status= '$status' and tblemployees.role = 'HOD' order by lid desc";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {

								 ?>  

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
								<td><?php echo $row['LeaveType']; ?></td>
	                            <td><?php echo $row['PostingDate']; ?></td>
	                            <td><?php $stats=$row['admin_status'];
	                             if($stats==1){
	                              ?>
	                                  <span style="color: green">Approved</span>
	                                  <?php } if($stats==2)  { ?>
	                                 <span style="color: red">Rejected</span>
	                                  <?php } if($stats==0)  { ?>
	                             <span style="color: blue">Pending</span>
	                             <?php } ?>
	                            </td>
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="leave_details_manager.php?leaveid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i> View</a>
											<a onclick='javascript:confirmationDelete($(this));return false;'class="dropdown-item" href="leaves.php?delete=<?php echo $row['lid'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
											
										</div>
									</div>
								</td>
							</tr>
							<?php }?>
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