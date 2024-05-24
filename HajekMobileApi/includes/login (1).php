<?php
  session_start();
  require 'connection.php';
	
  $email=$_POST['email'];
  $password=md5($_POST['password']);

	$sql ="SELECT * FROM tblemployees where EmailId ='$email' AND Password ='$password'";
	$query= mysqli_query($con, $sql);
	$count = mysqli_num_rows($query);
	if($count > 0)
	{
		while ($row = mysqli_fetch_assoc($query)) {
		    if ($row['role'] == 'Staff') {
		    	$response['tblemployees']=$row;
				$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
				$response['error']="200";
				$response['message']="employee login success";
		    }
		    elseif ($row['role'] == 'HOD') {
		    	$response['tblemployees']=$row;
				$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
				$response['error']="205";
				$response['message']="manager login success";
		    }
		    else {
		    	$response['tblemployees']=(object)[];
				$response['error']="400";
				$response['message']="Invalid Credentials";
		    }
		}

	} 
	else{
	  
		$response['tblemployees']=(object)[];
		$response['error']="405";
		$response['message']="user does not exist";

	}

	echo json_encode($response);

  
    
?>