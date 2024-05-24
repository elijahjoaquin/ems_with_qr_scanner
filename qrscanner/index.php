<?php 
session_start();
$date = new DateTime();
$datenow = $date->format('l, F jS, Y');  
include 'timezone.php';
?>
<html>
    <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Hajek Q Enterprise QR Scanner</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/hajek16x16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/hajek16x16.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/hajek16x16.png">
		<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">

		<style>
		body, html{
			margin: auto;
			background: #032b07;
			/*background-image:url("barcode.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center center;
			background-attachment: fixed;
			height: 100%;
			overflow: hidden;   /*  hide scrollbars */
		}
		</style>
		<script type="text/javascript" src="css/instascan.min.js"></script>
    </head>
    <body>
       <div class="container" style="margin-top:1%"> 
		   <div class="wrapper">
            <div class="row">
				<div class="col-md-3">
				<canvas id="my_canvas"  width="520" height="510"  ></canvas>
				</div>
				<div class="col-md-6">
				
				<h3 style="color:#fff;text-align: center">Hajek Q Enterprise Attendance Scanner</h3>
				</div>
                <div class="col-md-6">
				<nav class="navbar navbar-default" >
				<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#"><i class="glyphicon glyphicon-qrcode"></i> TAP QRCODE</a>
				</div>
					<ul class="nav navbar-nav navbar-right">
					<li><a href="../index.php"> <span class="glyphicon glyphicon-calendar"></span> Admin</a></li>
					</ul>
					
				<video id="preview" width="520px" height="510px" style="border-radius:10px;"></video>
				</div>
				<form action="attendance.php" method="post" class="form-horizontal" style="border-radius: 5px;padding:10px;background:#fff;display:none">
                     <i class="glyphicon glyphicon-qrcode"></i> <label>QRCODE OUTPUT</label><p></p>
                    <input type="hidden" name="employee" id="text" placeholder="scan qrcode" class="form-control" autofocus>
                </form>
				</nav>
				
				<center><small style="font-size:18pt;color:#fff;text-align: center;background:none;color:#fff;border:none" class="alert alert-danger "><span id="tick2" >
				  </span>&nbsp;|   <span class="text-uppercase"><?php echo $datenow; ?></span>
					</small></center><br>
				 <div class="row">
					<div class="col-md-12">
						<?php
					if(isset($_SESSION['error'])){
					  echo "
						<div id='alert' class='alert alert-danger' style='background:#eb3b5a;color:#fff;border:none'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h4><i class='icon fa fa-warning'></i> ERROR!</h4>
						  ".$_SESSION['error']."
						</div>
					  ";
					  unset($_SESSION['error']);
					}
					if(isset($_SESSION['success'])){
					  echo "
						<div id='alert' class='alert alert-success' style='background:#20bf6b;color:#fff;border:none'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h4><i class='icon fa fa-check'></i> SUCCESS!</h4>
						  ".$_SESSION['success']."
						</div>
					  ";
					  unset($_SESSION['success']);
					}
					
					if(isset($_SESSION['TIMELEFT'])){
					  echo "
						<div id='alert' class='alert alert-info' style='background:#5f27cd;color:#fff;border:none'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h4><i class='icon fa fa-check'></i> INTERVAL!</h4>
						  ".$_SESSION['TIMELEFT']."
						</div>
					  ";
					  unset($_SESSION['TIMELEFT']);
					}
				  ?>
					</div>
				</div>
				 <div class="row">
					<div class="col-md-12">
					 <label style="color:#fff">Legend: </label>
						<label class="label label-primary">ATTENDANCE CHECKED</label>
						<label class="label label-Success"> IN/OUT</label>
						<label class="label label-danger">NOT FOUND / ERROR</label>
					</div>
				</div>
						
                </div>
            </div>			
        </div>	
		</div>			
		<script src="plugins/jquery/jquery.min.js"></script>
		 <script src="plugins/jquery/jquery.js"></script>
		<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	 <script>
		    let opts = ({ continuous: true, video: document.getElementById('preview'), refractoryPeriod: 10000, scanPeriod: 2});
           let scanner = new Instascan.Scanner(opts)
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('text').value=c;
               document.forms[0].submit();
           });
        </script>
	
          <script type="text/javascript">
			$(document).ready(function () {
			window.setTimeout(function() {
				$("#alert").fadeTo(1000, 0).slideUp(1000, function(){
					$(this).remove(); 
				});
			}, 5000);
			
			});
			</script>
		
<script type="text/javascript" > 
     $(function () {
         $(".select2").select2();
     });

function show2(){
    $("#none").focus();
    if (!document.all&&!document.getElementById)
    return
    thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
    var Digital=new Date()
    var hours=Digital.getHours()
    var minutes=Digital.getMinutes()
    var seconds=Digital.getSeconds()
    var dn="PM"
    if (hours<12)
    dn="AM"
    if (hours>12)
    hours=hours-12
    if (hours==0)
    hours=12
    if (minutes<=9)
    minutes="0"+minutes
    if (seconds<=9)
    seconds="0"+seconds
    var ctime=hours+":"+minutes+":"+seconds+" "+dn
    thelement.innerHTML=ctime
    setTimeout("show2()",1000)
    }
  window.onload=show2
</script> 
    </body>
</html>