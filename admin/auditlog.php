<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
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
								<h4>Audit Log</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Audit Log</li>
								</ol>
							</nav>
						</div>
				</div>
			</div>
				
			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">SYSTEM LOG</h2>
						
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">NO.</th>
								<th>DATE AND TIME</th>
								<th>ACTION MADE</th>
                                <th>USER </th>
                                <th>DEPARTMENT </th>
                                <th>ROLE </th>

							</tr>
						</thead>
						<tbody>
							<tr>
								
								<?php 
								$sql = "SELECT auditlog.id as aid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id, auditlog.Action, auditlog.PostingDate , auditlog.Actor_ID, auditlog.User, auditlog.Department, auditlog.role, auditlog.Recipient_ID from auditlog join tblemployees on auditlog.Actor_ID=tblemployees.emp_id  order by aid DESC";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									$cnt=1;
									while ($row = mysqli_fetch_array($query)) {
								 ?>  
					           <td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										
										<div class="txt">
											<div class="weight-600"><?php echo $cnt ?></div>
										</div>
									</div>
								</td>
								
								<td >
									<div>
										
										<div class="txt">
											<div class="weight-600"><?php echo $row['PostingDate']?></div>
										</div>
									</div>
								</td>
                                <td>
                                        <div class="txt">
											<div class="weight-600"><?php echo $row['Action']?></div>
										</div>
                                </td>
							    <td>
                                        <div class="txt">
											<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
										</div>
                                </td> 
                                <td>
                                        <div class="txt">
											<div class="weight-600"><?php echo $row['Department']?></div>
										</div>
                                </td>
                                <td>
                                        <div class="txt">
											<div class="weight-600"><?php echo $row['role']?></div>
										</div>
                                </td>
								
							</tr>
							<?php 
							    $cnt++;
							}?>
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