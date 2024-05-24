
<?php
$status=1; 
$query = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.FromDate,tblleaves.ToDate,tblleaves.num_days,tblleaves.Status,tblleaves.admin_status from tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id where tblleaves.Status= '$status' order by lid desc";
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
  SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblemployees.role,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.FromDate,tblleaves.ToDate,tblleaves.num_days,tblleaves.Status,tblleaves.admin_status from tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id WHERE tblleaves.Status= '$status' AND tblleaves.PostingDate >= '".$_POST["fromDate"]."' AND tblleaves.PostingDate <= '".$_POST["toDate"]."' and tblemployees.role = 'Staff' order by PostingDate desc ";
  $orderResult = mysqli_query($conn, $orderQuery) or die("database error:". mysqli_error($conn));
  $filterOrders = array();
  while( $order = mysqli_fetch_assoc($orderResult) ) {
	$filterOrders[] = $order;
  }
  if(count($filterOrders)) {
	ob_end_clean();
	  $fileName = "leave_export_employee_".date('Y-m-d') . ".csv";
	  header("Content-Description: File Transfer");
	  header("Content-Disposition: attachment; filename=$fileName");
	  header("Content-Type: application/csv;");
	  $file = fopen('php://output', 'w');
	  $header = array("Emp ID", "First Name", "Last Name", "Leave Type", "Posting Date", "From Date", "To Date", "No. of Days", "Manager Status", "Admin Status");
	  fputcsv($file, $header);  
	  foreach($filterOrders as $order) {
	   $orderData = array();
	   $orderData[] = $order["emp_id"];
	   $orderData[] = $order["FirstName"];
       $orderData[] = $order["LastName"];
       $orderData[] = $order["LeaveType"];
	   $orderData[] = $order["PostingDate"];
	   $orderData[] = $order["FromDate"];
       $orderData[] = $order["ToDate"];
       $orderData[] = $order["num_days"];
       $orderData[] = $order["Status"];
       $orderData[] = $order["admin_status"];
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