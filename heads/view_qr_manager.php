<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php include '../admin/qrcode_generate/phpqrcode/qrlib.php'?>
<body>
<style>
    div.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    }
</style>
	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>
    
	<div class="main-container">
    <br>
    
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
			<div class="weight-600 font-30 text-blue"><center>Personal QR Code</center></div>
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">	
				<?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
						?> 
                        
                       <?php

									$serial=$row['qr_id'];
                        
									$file = '../admin/qrcode_generate/images/'.$serial.'.png';
									$ecc = 'H';
									$pixel_size = 20;
									$frame_size = 1;
									QRcode::png($serial, $file, $ecc, $pixel_size, $frame_size);
									echo "<div class='center'><img src='".$file."' width='280' height='280' ></div>";   
					    ?>
                        
				</div>
			</div>
	</div> 
</div>

	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>