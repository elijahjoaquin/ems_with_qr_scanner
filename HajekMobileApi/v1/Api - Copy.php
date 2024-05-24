<?php 
 //getting the dboperation class
 require_once '../includes/DbOperation.php';
 require_once '../includes/connection.php';
 //function validating all the paramters are available
 //we will pass the required parameters to this function 
 function isTheseParametersAvailable($params){
    //assuming all parameters are available 
    $available = true; 
    $missingparams = ""; 
    
    foreach($params as $param){
    if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
    $available = false; 
    $missingparams = $missingparams . ", " . $param; 
    }
    }
    
    //if parameters are missing 
    if(!$available){
    $response = array(); 
    $response['error'] = true; 
    $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
    
    //displaying error
    echo json_encode($response);
    
    //stopping further execution
    die();
    }
 }
 
 //an array to display response
 $response = array();
 
 //if it is an api call 
 //that means a get parameter named api call is set in the URL 
 //and with this parameter we are concluding that it is an api call
 if(isset($_GET['apicall'])){
 
 switch($_GET['apicall']){
    /*case 'loginuser':
        isTheseParametersAvailable(array('email','password'));
        $db = new DbOperation();
        if($db->loginUser($_POST['email'],md5($_POST['password']))){
            $response['error'] = false; 
            $response['message'] = 'Login Successful';
        }else{
			$response['error'] = true; 
			$response['message'] = 'Invalid Credentials';
        }
    break;   */
	case 'loginuser':
        isTheseParametersAvailable(array('email','password'));
        $db = new DbOperation();
		$email=$_POST['email'];
		$password=md5($_POST['password']);
		
		$sql ="SELECT * FROM tblemployees where EmailId ='$email' AND Password ='$password'";
		$query= mysqli_query($con, $sql);
		$count = mysqli_num_rows($query);
		if($count > 0)
		{
			while ($row = mysqli_fetch_assoc($query)) {
				if ($email && $password && $row['role'] == 'Staff') {
					$response['error']="200";
					$response['message']="Employee login success";
				}
				elseif($row['role'] == 'HOD') {
					$response['error']="205";
					$response['message']="Manager login success";
				}
				else {
					$response['tblemployees']=(object)[];
					$response['error']="400";
					$response['message']="Invalid Username or Password";
				}
			}
			
		}
		else{
		$response['tblemployees']=(object)[];
		$response['error']="405";
		$response['message']="Invalid Credentials";
	}
		
    break; 
	case 'getuserdetails':
        isTheseParametersAvailable(array('email','password'));
        $db = new dbOperation();
        if($db->getUserDetails($_POST['email'],md5($_POST['password']))){
            $response['error'] = false; 
            $response['message'] = 'Data retrieved';
            $response['userdetails'] = $db->getUserDetails($_POST['email'],md5($_POST['password']));
        }else{
            $response['error'] = false;
            $response['message'] = 'Invalid Data';
        }
    break;    
	
	case 'getuserschedule':
        $db = new dbOperation();
        if(isset($_GET['department'])){
            $db = new DbOperation();
            if($db->getUserSchedule($_GET['department'])){
                $response['error'] = false;
                $response['message']= "Request successfully completed";
                $response['schedule'] = $db->getUserSchedule($_GET['department']);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error occurred.';
            }
        }else{
            $response['error'] = true;
            $response['message'] = "No Employee Information";
        }
    break; 
	
	case 'getuserqr':
        $db = new dbOperation();
        if(isset($_GET['qr_id'])){
            $db = new DbOperation();
            if($db->getUserQR($_GET['qr_id'])){
                $response['error'] = false;
                $response['message']= "Request successfully completed";
                $response['qrarray'] = $db->getUserQR($_GET['qr_id']);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error occurred.';
            }
        }else{
            $response['error'] = true;
            $response['message'] = "No Employee Information";
        }
    break;
	
	case 'viewqr':
        $db = new DbOperation();
        $response['error'] = false; 
        $response['message'] = 'Request successfully completed';
        $response['qrarray'] = $db->ViewQR();
    break;
	
	
	
	
	// Prioritize View Leave History
	
	case 'applyleave':
		isTheseParametersAvailable(array('emp_id'));
		$empid=$_POST['emp_id'];
		$leave_type=$_POST['leave_type'];
		$fromdate=date('Y-m-d', strtotime($_POST['date_from']));
		$todate=date('Y-m-d', strtotime($_POST['date_to']));
		$description=$_POST['description'];  
		$status=0;
		$isread=0;
		//leave days is only for viewing how many days that leavetype has left
		$leave_days=$_POST['leave_days'];
		$datePosting = date("Y-m-d");
		
		$checkUser="SELECT * from tblemployees WHERE emp_id='$empid'";
		$checkQuery=mysqli_query($con,$checkUser);
		
		if($fromdate > $todate){
			$response['error']="406";
			$response['message']="End Date should be greater than Start Date";
		}elseif($leave_days <= 0){
			$response['error']="407";
			$response['message']="YOU HAVE EXCEEDED YOUR LEAVE LIMIT. LEAVE APPLICATION FAILED";
		}else{
			
			$DF = date_create($_POST['date_from']);
			$DT = date_create($_POST['date_to']);

			$diff =  date_diff($DF , $DT );
			$num_days = (1 + $diff->format("%a"));
			
			$insertQuery="INSERT INTO tblleaves
			(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) 
			VALUES('$leave_type','$todate','$fromdate','$description','$status','$isread','$empid','$num_days','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
		  if($result){
			$response['error']="200";
			$response['message']="Leave Application was successful!";
		  }else{
			$response['error']="400";
			$response['message']="Something went wrong. Please try again";
			}
		}
    break;
	
	case 'viewleavehistory':
        $db = new dbOperation();
        if(isset($_GET['empid'])){
            $db = new DbOperation();
            if($db->viewLeaveHistory($_GET['empid'])){
                $response['error'] = false;
                $response['message']= "Request successfully completed";
                $response['leaves'] = $db->viewLeaveHistory($_GET['empid']);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error occurred.';
            }
        }else{
            $response['error'] = true;
            $response['message'] = "No Employee Information";
        }
    break;
	
	case 'viewleavehistoryy':
		isTheseParametersAvailable(array('empid'));
        $db = new DbOperation();
		$empid=$_POST['empid'];
		
        $userleave="SELECT * FROM tblleaves where empid = $empid";
		$result=mysqli_query($con,$userleave);
		
		if(mysqli_num_rows($result)>0){


		while($row=$result->fetch_assoc()){

		$response['userleave'][]=$row;
		$response['error']="200";
		}
	}
	else{

		$response['error']="400";
		$response['userleave'][]="";
	}
    break;
	
	
	
	
	case 'viewovertimehistory':
        $db = new dbOperation();
        if(isset($_GET['empid'])){
            $db = new DbOperation();
            if($db->viewOvertimeHistory($_GET['empid'])){
                $response['error'] = false;
                $response['message']= "Request successfully completed";
                $response['overtime'] = $db->viewOvertimeHistory($_GET['empid']);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error occurred.';
            }
        }else{
            $response['error'] = true;
            $response['message'] = "No Employee Information";
        }
    break;
	
 }
 
 }else{
 //if it is not api call 
 //pushing appropriate values to response array 
 $response['error'] = true; 
 $response['message'] = 'Invalid API Call';
 }
 
 //displaying the response in json structure 
 echo json_encode($response);
 header('Content-Type: application/json');

?>