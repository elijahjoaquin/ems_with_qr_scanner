
<?php
$status=3; 
$query = "SELECT tblovertime.id as oid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblovertime.PostingDate,tblovertime.num_hrs,tblovertime.FromDate,tblovertime.Status,tblovertime.admin_status from tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id where tblovertime.Status= '$status' order by oid desc";
$results = mysqli_query($conn, $query) or die("database error:". mysqli_error($conn));
$allOrders = array();
while( $order = mysqli_fetch_assoc($results) ) {
	$allOrders[] = $order;
}
$startDateMessage = '';
$endDate = '';
$noResult2 ='';

if(isset($_POST["export5"])){
 if(empty($_POST["fromDate"])){
  $startDateMessage = '<label class="text-danger">Select start date.</label>';
 }else if(empty($_POST["toDate"])){
  $endDate = '<label class="text-danger">Select end date.</label>';
 } else { 
  $orderQuery = "
  SELECT tblovertime.id as oid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblovertime.PostingDate,tblovertime.num_hrs,tblovertime.FromDate,tblovertime.Status,tblovertime.admin_status from tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id WHERE tblovertime.Status= '$status' AND tblovertime.PostingDate >= '".$_POST["fromDate"]."' AND tblovertime.PostingDate <= '".$_POST["toDate"]."' and tblemployees.role = 'HOD' order by PostingDate desc ";
  $orderResult = mysqli_query($conn, $orderQuery) or die("database error:". mysqli_error($conn));
  $filterOrders = array();
  while( $order = mysqli_fetch_assoc($orderResult) ) {
	$filterOrders[] = $order;
  }
  if(count($filterOrders)) {
	ob_end_clean();
	  $fileName = "overtime_export_manager_".date('Y-m-d') . ".csv";
	  header("Content-Description: File Transfer");
	  header("Content-Disposition: attachment; filename=$fileName");
	  header("Content-Type: application/csv;");
	  $file = fopen('php://output', 'w');
	  $header = array("Emp ID", "First Name", "Last Name", "Posting Date", "No. of Hours", "Date of Overtime", "Admin Status");
	  fputcsv($file, $header);  
	  foreach($filterOrders as $order) {
	   $orderData = array();
	   $orderData[] = $order["emp_id"];
	   $orderData[] = $order["FirstName"];
       $orderData[] = $order["LastName"];
	   $orderData[] = $order["PostingDate"];
       $orderData[] = $order["num_hrs"];
	   $orderData[] = $order["FromDate"];
       $orderData[] = $order["admin_status"];
	   fputcsv($file, $orderData);
	  }
	  fclose($file);
	  exit;
  } else {
	 $noResult2 = '<label class="text-danger">There are no records that exist with this date range. Please choose a different date range.</label>';  
  }
 }
}
?>