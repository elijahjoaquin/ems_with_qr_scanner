<?php
session_start();
	
		include 'conn.php';
		include 'timezone.php';

		$employee = $_POST['employee'];
		$InsertTimeNow =  date('H:i A');
		$sql = "SELECT * FROM tblemployees WHERE qr_id = '$employee'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
			$id = $row['emp_id'];
			$date_now = date('Y-m-d');

			$sql = "SELECT * FROM attendance WHERE qr_id = '$id' AND date = '$date_now' AND status='1'";
			$query = $conn->query($sql);
			if($query->num_rows > 0){
				$_SESSION['error'] = 'You have timed in for today';
			}else{
				
			$sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN tblemployees ON tblemployees.emp_id=attendance.qr_id WHERE attendance.qr_id = '$id' AND date = '$date_now'";
			$query = $conn->query($sql);
			if($query->num_rows >0){
				$row = $query->fetch_assoc();
				$testimeout = date('H:i A');
				$diff = $testimeout - $row['time_in'];
				$hours = abs(floor($diff));
				//$othours = $hours - 9;
				$othours = $testimeout - '17:00:00';
				if ($othours < 0){
					$othours = 0;
				}
				
				$sql = "UPDATE attendance SET time_out ='$testimeout', num_hr='$hours', ot_hrs='$othours'/*, status = '$outstatus'*/ WHERE id = '".$row['uid']."'"; 
				
				if($conn->query($sql)){
					$_SESSION['success'] = 'Time out: '.$row['FirstName'].' '.$row['LastName'];
				}
			
			/*	if($row['time_out'] != '00:00:00'){
					$_SESSION['error'] = 'You have timed out for today';
				}
				else{
					
					$testimeout = date('H:i A');
					$sql = "UPDATE attendance SET time_out ='$testimeout', status = '$outstatus' WHERE id = '".$row['uid']."'";
					if($conn->query($sql)){
						$_SESSION['success'] = 'Time out: '.$row['FirstName'].' '.$row['LastName'];
					}

				}*/
			}else{
			    $testime = date('H:i A');
				$ontime = 0;
				$late = 1;
				
				$Attendance = 1;
				if($testime < '08:00:00'){
					$sql = "INSERT INTO attendance (qr_id, date, time_in, time_out, Tardiness, Present) VALUES ('$id','$date_now','$testime','$testimeout','$ontime','$Attendance')";
						if($conn->query($sql)){
							$_SESSION['success'] = 'Time in: '.$row['FirstName'].' '.$row['LastName'];
						}else{
							$_SESSION['error'] = $conn->error;
						}
					}
				elseif($testime > '08:01:00'){
					$sql = "INSERT INTO attendance (qr_id, date, time_in, time_out, Tardiness, Present) VALUES ('$id','$date_now','$testime','$testimeout','$late','$Attendance')";
						if($conn->query($sql)){
							$_SESSION['success'] = 'Time in: '.$row['FirstName'].' '.$row['LastName']. ' LATE';
						}else{
							$_SESSION['error'] = $conn->error;
						}
					}
			}

			}
						
		}else{
			$_SESSION['error'] = 'Employee ID not found'.$employee;
		}
		
	
	header("location:index.php");
?>