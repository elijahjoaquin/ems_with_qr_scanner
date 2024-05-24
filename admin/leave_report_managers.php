<?php include('../includes/session.php')?>
<?php
	function generateRow($conn){
		$contents = '';
        $status=0;
		$sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.FromDate,tblleaves.ToDate,tblleaves.num_days,tblleaves.Status,tblleaves.admin_status from tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id where tblleaves.Status= '$status' and tblleaves.PostingDate >= '".$_POST["fromDate"]."' and tblleaves.PostingDate <= '".$_POST["toDate"]."' and tblemployees.role = 'HOD' order by PostingDate desc";
		$query = $conn->query($sql);
		$cnt =1;
		
		while($row = $query->fetch_assoc()){
		 $contents .= '
			<tr>
			  <td>'.$cnt.'</td>
              <td>'.$row['FirstName'].' '.$row['LastName'].'</td>
              <td>'.$row['LeaveType'].'</td>
              <td>'.$row['PostingDate'].'</td>
              <td>'.$row['FromDate'].' to '.$row['ToDate'].'</td>
			  <td>'.$row['num_days'].'</td>
              <td>'.$row['admin_status'].'</td>
			</tr>
		  ';
		  $cnt++;
		}
		return $contents;
	}
		
	$date = date('F d, Y');

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Attendance Report: '.$date.'');  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
	
		
				<span align="center">HAJEK Q ENTERPRISES</span><br/>
				
				
			
			<br/>
      	<h4 align="center">[LEAVE REPORTS]</h4>
      	<h4 align="center">'.$date.'</h4>
        <h5>Note for Status: 0 = Pending, 1 = Approved, 2 = Rejected</h5>
      	<table border="1" cellspacing="0" cellpadding="3" width="100%" style="font-size:9pt">
          <thead>
		   <tr border="0">
				<th colspan="7">List of Leave Applications for Managers</th>
			</tr>
			 <tr>
				<th>No.</th>
                <th>Name</th>
                <th>Leave Type</th>
				<th>Applied Date</th>
                <th>Leave Period</th>
				<th>No. of Days</th>
                <th>Admin Status</th>					

			</tr>	

		</thead>  
      ';  
    $content .= generateRow($conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
	ob_end_clean();
    $pdf->Output('leave_summary_managers.pdf', 'I');

?>