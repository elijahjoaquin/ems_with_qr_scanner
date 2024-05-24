<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<style>
    .error {
        background: #F2DEDE;
        color: #A94442;
        padding: 10px;
        width: 95%;
        border-radius: 5px;
        margin: 20px auto;
    }

    .success {
        background: #D4EDDA;
        color: #40754C;
        padding: 10px;
        width: 95%;
        border-radius: 5px;
        margin: 20px auto;
    }
</style>
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
									<h4>Change Password</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Change Password</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
            
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<center><h2 class="mb-30 h4">Change Password</h2></center>
								<?php if (isset($_GET['error'])) { ?>
     		                        <p class="error"><?php echo $_GET['error']; ?></p>
     	                        <?php } ?>

     	                        <?php if (isset($_GET['success'])) { ?>
                                <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?>
								<section>
									<form action="change-p.php" name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Old Password</label>
												<input name="op" type="password" class="form-control" required="true" autocomplete="off" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>New Password</label>
												<input name="np" type="password" class="form-control" required="true" autocomplete="off">
											</div>
													
										</div>
									</div>
									<div class="row">
									<div class="col-md-12">
										<div class="form-group">
												<label>Confirm New Password</label>
												<input name="c_np" type="password" class="form-control" required="true" autocomplete="off">
											</div>
									</div>
									<div class="col-sm-12">
										<div class="dropdown">
										   <center><input class="btn btn-primary" type="submit" value="UPDATE" name="add" id="add"></center>
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>