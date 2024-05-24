<?php include '../includes/session.php'; ?>
<?php 
$studid=$_GET['q'];	
$result=mysqli_query($conn, "SELECT * FROM student WHERE ID='$studid'")or die('Error');
$row=mysqli_fetch_array($result);


//load the ar library
include 'phpqrcode/qrlib.php';

//data to be stored in qr
$text = $row['STUDENTID'];
  
//file path
$file = 'images/'.$text.'.png';
  
//other parameters
$ecc = 'H';
$pixel_size = 20;
$frame_size = 0;
  
// Generates QR Code and Save as PNG
QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
  
// Displaying the stored QR code if you want
echo "
<div style='border:0px solid #000;width:310px;height:400px;margin:0 auto'> 
<table>
<tr style='background:#192a56;color:#fff;'>
	<td>".$row['FIRSTNAME'].' '.$row['MNAME'].' '.$row['LASTNAME']."</td>
</tr>
<tr>
	<td><img src='".$file."' width='300' height='300'></td>
</tr>
<tr>
	<td align='center' style='background:#e84118;color:#fff;'><h1>SCAN ME</h1></td>
</tr>
</table>
</div>";

?>