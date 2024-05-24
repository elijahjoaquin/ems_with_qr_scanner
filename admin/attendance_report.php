<?php include('../includes/session.php')?>
<?php
	function generateRow($conn){
		
		$contents = '';
        $status=1;
		$sql = "SELECT tblemployees.qr_id AS empid, attendance.id as aid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,attendance.date,attendance.time_in,attendance.time_out, attendance.status, attendance.num_hr, attendance.ot_hrs from attendance join tblemployees on attendance.qr_id=tblemployees.emp_id WHERE attendance.date >= '".$_POST["fromDate"]."' AND attendance.date <= '".$_POST["toDate"]."' order by date desc";
		$query = $conn->query($sql);
		$cnt =1;
		
		while($row = $query->fetch_assoc()){
			if($row['time_out']=='00:00:00'){
				$timeout='No Out';
			}else{
				$timeout =date('h:i A', strtotime($row['time_in']));
			}
            if($row['time_in']>'08:10:00'){
                $status='1';
            }else{
                $status='0';
            }	
		 $contents .= '
			<tr>
			  <td>'.$cnt.'</td>
              <td>'.$row['FirstName'].' '.$row['LastName'].'</td>
              <td>'.$row['empid'].'</td>
			  <td>'.date('M d, Y', strtotime($row['date'])).'</td>
			  <td>'.date('h:i A', strtotime($row['time_in'])).'</td>
			  <td>'.date('h:i A', strtotime($row['time_out'])).'</td>
              <td>'.$row['status'].'</td>
			  <td>'.$row['num_hr'].'</td>
			  <td>'.$row['ot_hrs'].'</td>
			</tr>
		  ';
		  $cnt++;
		}
		return $contents;
		}
	
	if(isset($_POST["export2"])){	
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
      	<h4 align="center">[ATTENDANCE REPORTS]</h4>
      	<h4 align="center">'.$date.'</h4>
		<h5>Note: 0 = On-time, 1 = Late </h5>
      	<table border="1" cellspacing="0" cellpadding="3" width="100%" style="font-size:9pt">
          <thead>
		   <tr border="0">
				<th colspan="9">List of Attendance</th>
			</tr>
			 <tr>
				<th>No.</th>
                <th>Name</th>
                <th>Emp ID</th>
				<th>Date</th>
				<th>In</th>
				<th>Out</th>	
                <th>Status</th>		
				<th>No. of Hours</th>
				<th>OT Hours</th>			
			</tr>	
		</thead>  
      ';  
    $content .= generateRow($conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
	ob_end_clean();
    $pdf->Output('attendance_report.pdf', 'I');
}
?>