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
								<h4>Evaluation History</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Evaluations</li>
								</ol>
							</nav>
						</div>
				</div>
			</div>
				
			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL EVALUATIONS</h2>
						
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">DATE</th>
								
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								
								<?php 
								$sql = "SELECT tblevaluation.id as eid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblevaluation.Question1,tblevaluation.Question2,tblevaluation.PostingDate from tblevaluation join tblemployees on tblevaluation.empid=tblemployees.emp_id where tblemployees.role = 'HOD' and tblemployees.Department = '$session_depart' and empid = '$session_id' order by id desc";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {
	
								 ?>  
					
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										
										<div class="txt">
											<div class="weight-600"><?php echo $row['PostingDate']?></div>
										</div>
									</div>
								</td>
							
								
								<td>
									<div class="table-actions">
										
										
											<a  href="view_evaluation.php?edit=<?php echo $row['eid']; ?>" data-color="#265ed7"> <i class="dicon-copy dw dw-eye"></i></a>
											
										
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