
<?php
$query = "SELECT tblemployees.qr_id AS empid, attendance.id as aid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,attendance.date,attendance.time_in,attendance.time_out, attendance.status from attendance join tblemployees on attendance.qr_id=tblemployees.emp_id order by aid";
$results = mysqli_query($conn, $query) or die("database error:". mysqli_error($conn));
$allOrders = array();
while( $order = mysqli_fetch_assoc($results) ) {
	$allOrders[] = $order;
}
$startDateMessage = '';
$endDate = '';
$noResult ='';
if(isset($_POST["export"])){
 if(empty($_POST["fromDate"])){
  $startDateMessage = '<label class="text-danger">Select start date.</label>';
 }else if(empty($_POST["toDate"])){
  $endDate = '<label class="text-danger">Select end date.</label>';
 } else {  
  $orderQuery = "
  SELECT tblemployees.qr_id AS empid, attendance.id as aid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,attendance.date,attendance.time_in, attendance.time_out, attendance.status, attendance.num_hr, attendance.ot_hrs from attendance join tblemployees on attendance.qr_id=tblemployees.emp_id WHERE attendance.date >= '".$_POST["fromDate"]."' AND attendance.date <= '".$_POST["toDate"]."'order by date desc ";
  $orderResult = mysqli_query($conn, $orderQuery) or die("database error:". mysqli_error($conn));
  $filterOrders = array();
  while( $order = mysqli_fetch_assoc($orderResult) ) {
	$filterOrders[] = $order;
  }
  if(count($filterOrders)) {
	ob_end_clean();
	  $fileName = "attendance_export_".date('Y-m-d') . ".csv";
	  header("Content-Description: File Transfer");
	  header("Content-Disposition: attachment; filename=$fileName");
	  header("Content-Type: application/csv;");
	  $file = fopen('php://output', 'w');
	  $header = array("Emp ID", "First Name", "Last Name", "Time In", "Time Out", "Date", "No. of Hours", "OT Hours");
	  fputcsv($file, $header);  
	  foreach($filterOrders as $order) {
	   $orderData = array();
	   $orderData[] = $order["emp_id"];
	   $orderData[] = $order["FirstName"];
       $orderData[] = $order["LastName"];
       $orderData[] = $order["time_in"];
	   $orderData[] = $order["time_out"];
	   $orderData[] = $order["date"];
	   $orderData[] = $order["num_hr"];
	   $orderData[] = $order["ot_hrs"];
	   fputcsv($file, $orderData);
	  }
	  fclose($file);
	  exit;
  } else {
	 $noResult = '<label class="text-danger">There are no records that exist with this date range. Please choose a different date range.</label>';  
  }
 }
}
?>