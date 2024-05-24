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
					$response['message']="Employee Logged in";
				}
				elseif($row['role'] == 'HOD') {
					$response['error']="205";
					$response['message']="Manager Logged in";
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
	
	case 'viewleavehistory':
		$db = new dbOperation();
		if(isset($_GET['empid'])){
		$empid=$_GET['empid'];
		$leaves="SELECT * FROM tblleaves where empid = '$empid' ORDER BY id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime History Fetched";
			}	
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			}
		}
    break;
	
	case 'viewovertimehistory':
		$db = new dbOperation();
		if(isset($_GET['empid'])){
		$empid=$_GET['empid'];
		$overtime="SELECT * FROM tblovertime where empid = '$empid' ORDER BY id DESC";
		$result=mysqli_query($con,$overtime);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime History Fetched";
			}	
		}else{
			$response['error']="400";
			$response['overtime'][]="";
			}
		}
    break;
	
	case 'viewevaluationhistory':
		$db = new dbOperation();
		if(isset($_GET['empid'])){
		$empid=$_GET['empid'];
		$evaluation="SELECT * FROM tblevaluation where empid = '$empid' ORDER BY id DESC";
		$result=mysqli_query($con,$evaluation);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
			$response['evaluation'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime History Fetched";
			
			}	
		}else{
			$response['error']="400";
			$response['evaluation'][]="";
			}
		}
    break;
	
	// Apply Leave and Overtime Starts here
	case 'applyleave':
		isTheseParametersAvailable(array('emp_id'));

		$empid=$_POST['emp_id'];
		$leave_type=$_POST['leave_type'];
		$fromdate=date('Y-m-d', strtotime($_POST['date_from']));
		$todate=date('Y-m-d', strtotime($_POST['date_to']));
		$description=$_POST['description'];  
		$gender=$_POST['gender'];  
		$status=0;
		$isread=0;
		//leave days is only for viewing how many days that leavetype has left
		//$leave_days=$_POST['leave_days'];
		$Leave_Emergency=$_POST['Leave_Emergency'];
		$Leave_Vacation=$_POST['Leave_Vacation'];
		$Leave_Paternity=$_POST['Leave_Paternity'];
		$Leave_Maternity=$_POST['Leave_Maternity'];
		
		//add leavetypes here
		
		$datePosting = date("Y-m-d");
		
		$checkUser="SELECT * from tblemployees WHERE emp_id='$empid'";
		$checkQuery=mysqli_query($con,$checkUser);
		
		if(empty($_POST['date_from']) == 1 && empty($_POST['date_to']) == 1){
			$response['error']="404";
			$response['message']="Please Input Start and End dates";
		}
		
		elseif(empty($_POST['date_from']) == 1){
			$response['error']="405";
			$response['message']="Please Input Start date";
		}
		
		elseif(empty($_POST['date_to']) == 1){
			$response['error']="405";
			$response['message']="Please Input End date";
		}
		
		elseif(empty($_POST['description']) == 1){
			$response['error']="405";
			$response['message']="Please state your reason for leave";
		}
		
		elseif($fromdate > $todate){
			$response['error']="406";
			$response['message']="End Date should be greater than Start Date";
		}
		
		elseif($leave_type == "Select Leave Type"){
			$response['error']="407";
			$response['message']="Please select a leave type";
			
		}
		
		elseif($leave_type == "Vacation Leave" && $Leave_Vacation <= 0){
			$response['error']="408";
			$response['message']="YOU HAVE EXCEEDED YOUR VACATION LEAVE LIMIT. LEAVE APPLICATION FAILED";
			
		}
		
		elseif($leave_type == "Emergency Leave" && $Leave_Emergency <= 0){
			$response['error']="409";
			$response['message']="YOU HAVE EXCEEDED YOUR EMERGENCY LEAVE LIMIT. LEAVE APPLICATION FAILED";
		}
		
		elseif($leave_type == "Paternity Leave" && $Leave_Paternity <= 0){
			$response['error']="410";
			$response['message']="YOU HAVE EXCEEDED YOUR PATERNITY LEAVE LIMIT. LEAVE APPLICATION FAILED";
		}
		
		elseif($leave_type == "Maternity Leave" && $Leave_Maternity <= 0 && $gender == "female"){
			$response['error']="411";
			$response['message']="YOU HAVE EXCEEDED YOUR MATERNITY LEAVE LIMIT. LEAVE APPLICATION FAILED";
		}
		
		elseif($leave_type =="Vacation Leave" && $Leave_Vacation > 0){
			
			$DF = date_create($_POST['date_from']);
			$DT = date_create($_POST['date_to']);

			$diff =  date_diff($DF , $DT );
			$num_days = (1 + $diff->format("%a"));
			
			if($num_days > $Leave_Vacation ){
				$response['error']="410";
				$response['message']="APPLIED DAYS EXCEEDS VACATION LEAVE LIMIT. LEAVE APPLICATION FAILED"; 
			}else{
			$insertQuery="INSERT INTO tblleaves
			(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) 
			VALUES('$leave_type','$todate','$fromdate','$description','$status','$isread','$empid','$num_days','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Vacation Leave Application was successful!";
				$response['leaveapply'][]=$result;
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
			
		}elseif($leave_type =="Emergency Leave" && $Leave_Emergency > 0){
			$DF = date_create($_POST['date_from']);
			$DT = date_create($_POST['date_to']);

			$diff =  date_diff($DF , $DT );
			$num_days = (1 + $diff->format("%a"));
			
			if($num_days > $Leave_Emergency ){
				$response['error']="410";
				$response['message']="APPLIED DAYS EXCEEDS EMERGENCY LEAVE LIMIT. LEAVE APPLICATION FAILED"; 
			}else{
			$insertQuery="INSERT INTO tblleaves
			(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) 
			VALUES('$leave_type','$todate','$fromdate','$description','$status','$isread','$empid','$num_days','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Emergency Leave Application was successful!";
				$response['leaveapply'][]=$result;
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		} 
	}elseif($leave_type =="Business Leave"){
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
				$response['message']="Business Leave Application was successful!";
				$response['leaveapply'][]=$result;
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		 
	}elseif($leave_type =="Paternity Leave" && $Leave_Paternity > 0 && $gender =="male" || $gender =="Male"){
			$DF = date_create($_POST['date_from']);
			$DT = date_create($_POST['date_to']);

			$diff =  date_diff($DF , $DT );
			$num_days = (1 + $diff->format("%a"));
			
			if($num_days > $Leave_Paternity ){
				$response['error']="410";
				$response['message']="APPLIED DAYS EXCEEDS PATERNITY LEAVE LIMIT. LEAVE APPLICATION FAILED"; 
			}else{
			$insertQuery="INSERT INTO tblleaves
			(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) 
			VALUES('$leave_type','$todate','$fromdate','$description','$status','$isread','$empid','$num_days','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Paternity Leave Application was successful!";
				$response['leaveapply'][]=$result;
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		} 
	}elseif($leave_type =="Paternity Leave" && $Leave_Paternity > 0 && $gender =="female"){
			$response['error']="410";
			$response['message']="You are not applicable for this leave type"; 
	}elseif($leave_type =="Maternity Leave" && $Leave_Maternity > 0 && $gender =="female"){
			$DF = date_create($_POST['date_from']);
			$DT = date_create($_POST['date_to']);

			$diff =  date_diff($DF , $DT );
			$num_days = (1 + $diff->format("%a"));
			
			if($num_days > $Leave_Maternity ){
				$response['error']="410";
				$response['message']="APPLIED DAYS EXCEEDS MATERNITY LEAVE LIMIT. LEAVE APPLICATION FAILED"; 
			}else{
			$insertQuery="INSERT INTO tblleaves
			(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid,num_days,PostingDate) 
			VALUES('$leave_type','$todate','$fromdate','$description','$status','$isread','$empid','$num_days','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Maternity Leave Application was successful!";
				$response['leaveapply'][]=$result;
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		} 
	}else{
		$response['error']="410";
		$response['message']="You are not applicable for maternity leave type"; 
	}
	
    break;
	
	case 'applyovertime':
		isTheseParametersAvailable(array('emp_id'));

		$empid=$_POST['emp_id'];
		$fromdate=date('Y-m-d', strtotime($_POST['date_from']));
		$description=$_POST['description'];  
		$status=0;
		$isread=0;
		$overtime_hours=$_POST['overtime_hours'];
		$datePosting = date("Y-m-d");
		$num_hrs=$_POST['num_hrs'];
		
		$check = is_numeric($num_hrs);
		
		$checkUser="SELECT * from tblemployees WHERE emp_id='$empid'";
		$checkQuery=mysqli_query($con,$checkUser);
		
		if(empty($_POST['date_from']) == 1){
			$response['error']="405";
			$response['message']="Please Input Date of Overtime";
		}
		
		elseif(empty($_POST['num_hrs']) == 1){
			$response['error']="406";
			$response['message']="Please Input your Number of Hours";
		}
		
		elseif($_POST['num_hrs'] <= 0){
		    $response['error']="406";
			$response['message']="Please Input valid number of hours";
		}
		
		elseif(empty($_POST['description']) == 1){
			$response['error']="405";
			$response['message']="Please state your reason for overtime";
		}
		
		elseif($check != 1){
			$response['error']="407";
			$response['message']="Please enter valid number of hours";
			
		}
		
		elseif($overtime_hours <= 0){
			$response['error']="406";
			$response['message']="YOU HAVE EXCEEDED YOUR OVERTIME LIMIT. OVERTIME APPLICATION FAILED";
		}
		
		elseif($num_hrs > $overtime_hours){
			$response['error']="407";
			$response['message']="YOU HAVE EXCEEDED YOUR OVERTIME LIMIT, PLEASE ENTER VALID REMAINING HOURS";
			
		}
		else{
			$DF = date_create($_POST['date_from']);
			
			$insertQuery="INSERT INTO tblovertime
			(FromDate,Description,num_hrs,Status,IsRead,empid,PostingDate) 
			VALUES('$fromdate','$description','$num_hrs','$status','$isread','$empid','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Overtime Application was successful!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			} 
	}
    break;
	
	case 'managerapplyovertime':
		isTheseParametersAvailable(array('emp_id'));

		$empid=$_POST['emp_id'];
		$fromdate=date('Y-m-d', strtotime($_POST['date_from']));
		$description=$_POST['description'];  
		$status=3;
		$isread=0;
		$overtime_hours=$_POST['overtime_hours'];
		$datePosting = date("Y-m-d");
		$num_hrs=$_POST['num_hrs'];
		
		$check = is_numeric($num_hrs);
		
		$checkUser="SELECT * from tblemployees WHERE emp_id='$empid'";
		$checkQuery=mysqli_query($con,$checkUser);
		
		if(empty($_POST['date_from']) == 1){
			$response['error']="405";
			$response['message']="Please Input Date of Overtime";
		}
		
		elseif(empty($_POST['num_hrs']) == 1){
			$response['error']="406";
			$response['message']="Please Input your Number of Hours";
		}
		
		elseif($_POST['num_hrs'] <= 0){
			$response['error']="406";
			$response['message']="Please Input valid number of hours";
		}
		
		elseif(empty($_POST['description']) == 1){
			$response['error']="405";
			$response['message']="Please state your reason for overtime";
		}
		
		elseif($check != 1){
			$response['error']="407";
			$response['message']="Please enter valid number of hours";
			
		}
		
		elseif($overtime_hours <= 0){
			$response['error']="406";
			$response['message']="YOU HAVE EXCEEDED YOUR OVERTIME LIMIT. OVERTIME APPLICATION FAILED";
		}
		
		elseif($num_hrs > $overtime_hours){
			$response['error']="407";
			$response['message']="YOU HAVE EXCEEDED YOUR OVERTIME LIMIT, PLEASE ENTER VALID REMAINING HOURS";
			
		}
		else{
			$DF = date_create($_POST['date_from']);
			
			$insertQuery="INSERT INTO tblovertime
			(FromDate,Description,num_hrs,Status,IsRead,empid,PostingDate) 
			VALUES('$fromdate','$description','$num_hrs','$status','$isread','$empid','$datePosting')";
			$result=mysqli_query($con,$insertQuery);
			
			if($result){
				$response['error']="200";
				$response['message']="Overtime Application was successful!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			} 
	}
    break;
	
	// Continue Apply Evaluation Manager Side, then proceed with approving of leaves and overtime of employees
	// Put EditText inputs in the details file of manager employee eval application
	// Include performnetworktask in evaluation application
	
	case 'viewevaluationemployees':
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$applyevallist="SELECT emp_id, FirstName, LastName, EmailId, Department, Role, location
		FROM tblemployees where (department = '$department' && Role ='Staff') ORDER BY emp_id ASC";
		
		$result=mysqli_query($con,$applyevallist);
		
		if(mysqli_num_rows($result)>0){
		
		while($row=$result->fetch_assoc()){
		//employee functions
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['applyevallist'][]=$row;
			$response['error']="200";
			$response['message']="Employee Apply History Fetched";
		}	
		}else{
			$response['error']="400";
			$response['applyevallist'][]="";
			}
		}
    break;
	

	
	case 'applyevaluation':
		$db = new dbOperation();
		
		$empid=$_POST['emp_id'];
		$question1=$_POST['question1'];
		$question2=$_POST['question2'];
		$question3=$_POST['question3'];
		$question4=$_POST['question4'];
		$question5=$_POST['question5'];
		$remarks=$_POST['remarks'];
		$datePosting = date("Y-m-d");
		
		if($question1 == "Select Answer..."){
			$response['error']="407";
			$response['message']="Please fill in your entry for question 1";
			
		}elseif($question2 == "Select Answer..."){
			$response['error']="407";
			$response['message']="Please fill in your entry for question 2";
			
		}elseif($question3 == "Select Answer..."){
			$response['error']="407";
			$response['message']="Please fill in your entry for question 3";
			
		}elseif($question4 == "Select Answer..."){
			$response['error']="407";
			$response['message']="Please fill in your entry for question 4";
			
		}elseif($question5 == "Select Answer..."){
			$response['error']="407";
			$response['message']="Please fill in your entry for question 5";
			
		}elseif(empty($_POST['remarks']) == 1){
			$response['error']="407";
			$response['message']="Please fill in your remarks";
			
		}else{
		
		$applyevaluation="INSERT INTO 
		tblevaluation(Question1, Question2, Question3, Question4, Question5, Remarks, PostingDate, empid) 
		VALUES('$question1','$question2','$question3','$question4','$question5','$remarks', '$datePosting','$empid')";
		
		$result=mysqli_query($con,$applyevaluation);
			
			if($result){
				$response['error']="200";
				$response['message']="Evaluation Applied Successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
    break;
	
	case 'viewemployeeleavespending':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblleaves.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblemployees.Leave_Vacation,
		tblemployees.Leave_Emergency,
		tblemployees.Leave_Maternity,
		tblemployees.Leave_Paternity,
		tblleaves.LeaveType,
		tblleaves.ToDate,
		tblleaves.FromDate,
		tblleaves.PostingDate,
		tblleaves.Description,
		tblleaves.num_days,
		tblleaves.Status,
		tblleaves.admin_status,
		tblleaves.AdminRemark
		FROM tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblleaves.Status = '0' 
		ORDER BY tblleaves.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	case 'viewemployeeleavesapproved':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblleaves.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblemployees.Leave_Vacation,
		tblemployees.Leave_Emergency,
		tblemployees.Leave_Maternity,
		tblemployees.Leave_Paternity,
		tblleaves.LeaveType,
		tblleaves.ToDate,
		tblleaves.FromDate,
		tblleaves.PostingDate,
		tblleaves.Description,
		tblleaves.num_days,
		tblleaves.Status,
		tblleaves.admin_status,
		tblleaves.AdminRemark
		FROM tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblleaves.Status = '1' 
		ORDER BY tblleaves.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	case 'viewemployeeleavesrejected':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblleaves.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblemployees.Leave_Vacation,
		tblemployees.Leave_Emergency,
		tblemployees.Leave_Maternity,
		tblemployees.Leave_Paternity,
		tblleaves.LeaveType,
		tblleaves.ToDate,
		tblleaves.FromDate,
		tblleaves.PostingDate,
		tblleaves.Description,
		tblleaves.num_days,
		tblleaves.Status,
		tblleaves.admin_status,
		tblleaves.AdminRemark
		FROM tblleaves join tblemployees on tblleaves.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblleaves.Status = '2' 
		ORDER BY tblleaves.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	case 'approveleave':
		$db = new dbOperation();
		$isread = 1;
		$leaveid=$_POST['leaveid'];
		$description=$_POST['description'];
		$status=$_POST['status'];  
		$reg_remarks = 'Leave was Rejected. Administrator will not see it';
		$reg_status = 2;
		date_default_timezone_set('Asia/Manila');
		$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
		
		
		if(empty($_POST['status']) == 1 || $status =="Choose your option"){
			$response['error']="405";
			$response['message']="Please select an item in the list";
		}
		
		elseif(empty($_POST['description']) == 1){
			$response['error']="405";
			$response['message']="Please fill out your remarks";
		}
		
		elseif($status === 'Approved') {
		$status = '1';
		$updateleave="UPDATE tblleaves 
		SET AdminRemark='$description', IsRead ='$isread', Status='$status', AdminRemarkDate='$admremarkdate' WHERE id='$leaveid'";
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Leave Approved Successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
		
		elseif ($status == 'Rejected') {
		$status = '2';	
		$updateleave="UPDATE tblleaves 
		SET AdminRemark='$description', IsRead ='$isread', Status='$status', AdminRemarkDate='$admremarkdate', registra_remarks = '$reg_remarks', admin_status = '$reg_status' WHERE id='$leaveid'";
		
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Leave Rejected Successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
		
		elseif($status == 'Pending') {
		$updateleave="UPDATE tblleaves 
		SET AdminRemark='$description', IsRead ='$isread', AdminRemarkDate='$admremarkdate' WHERE id='$leaveid'";
		
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Leave reviewed successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}else{
			$response['error']="400";
				$response['message']="Leave Application Error.";
		}
    break;
	
	case 'viewemployeeovertimepending':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblovertime.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblovertime.FromDate,
		tblovertime.PostingDate,
		tblovertime.Description,
		tblovertime.num_hrs,
		tblovertime.Status,
		tblovertime.admin_status,
		tblovertime.AdminRemark
		FROM tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblovertime.Status = '0' 
		ORDER BY tblovertime.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	
	case 'viewemployeeovertimeapproved':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblovertime.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblovertime.FromDate,
		tblovertime.PostingDate,
		tblovertime.Description,
		tblovertime.num_hrs,
		tblovertime.Status,
		tblovertime.admin_status,
		tblovertime.AdminRemark
		FROM tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblovertime.Status = '1' 
		ORDER BY tblovertime.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	case 'viewemployeeovertimerejected':
	
		$db = new dbOperation();
		if(isset($_GET['department'])){
		$department=$_GET['department'];
		$leaves="SELECT 
		tblovertime.id,
		tblemployees.FirstName,
		tblemployees.LastName,
		tblemployees.location,
		tblemployees.emp_id,
		tblovertime.FromDate,
		tblovertime.PostingDate,
		tblovertime.Description,
		tblovertime.num_hrs,
		tblovertime.Status,
		tblovertime.admin_status,
		tblovertime.AdminRemark
		FROM tblovertime join tblemployees on tblovertime.empid=tblemployees.emp_id 
		WHERE tblemployees.role = 'Staff' and tblemployees.Department = '$department'  and tblovertime.Status = '2' 
		ORDER BY tblovertime.id DESC";
		$result=mysqli_query($con,$leaves);
		if(mysqli_num_rows($result)>0){
		while($row=$result->fetch_assoc()){
		//employee functions
			/* $image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['leaves'][]=$row;
			$response['error']="200";
			$response['message']="Employee Leave List Fetched"; */
			
			if($row['AdminRemark'] == null){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$row['AdminRemark'] = "Waiting for Approval";
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}elseif(!empty($row['AdminRemark'])){
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}else{
			$image = "https://hajekqenterprises.com/uploads/".$row['location'];
			$row['location'] = $image;
			$response['overtime'][]=$row;
			$response['error']="200";
			$response['message']="Employee Overtime List Fetched";
			}
			
		}			
		}else{
			$response['error']="400";
			$response['leaves'][]="";
			$response['message']="Error, did not fetch data";
			}
		}
    break;
	
	case 'approveovertime':
		$db = new dbOperation();
		$isread = 1;
		$overtimeid=$_POST['overtimeid'];
		$description=$_POST['description'];
		$status=$_POST['status'];  
		$reg_remarks = 'Overtime was Rejected. Administrator will not see it';
		$reg_status = 2;
		date_default_timezone_set('Asia/Manila');
		$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
		
		
		if(empty($_POST['status']) == 1 || $status =="Choose your option"){
			$response['error']="405";
			$response['message']="Please select an item in the list";
		}
		
		elseif(empty($_POST['description']) == 1){
			$response['error']="405";
			$response['message']="Please fill out your remarks";
		}
		
		elseif($status === 'Approved') {
		$status = '1';
		$updateleave="UPDATE tblovertime 
		SET AdminRemark='$description', IsRead ='$isread', Status='$status', AdminRemarkDate='$admremarkdate' WHERE id='$overtimeid'";
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Overtime Approved Successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
		elseif ($status == 'Rejected') {
		$status = '2';	
		$updateleave="UPDATE tblovertime
		SET AdminRemark='$description', IsRead ='$isread', Status='$status', AdminRemarkDate='$admremarkdate', registra_remarks = '$reg_remarks', admin_status = '$reg_status' WHERE id='$overtimeid'";
		
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Overtime Rejected Successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}
		elseif($status == 'Pending') {
		$status = '0';
		$updateleave="UPDATE tblovertime
		SET AdminRemark='$description', IsRead ='$isread', Status='$status', AdminRemarkDate='$admremarkdate' WHERE id='$overtimeid'";
		
		$result=mysqli_query($con,$updateleave);
			
			if($result){
				$response['error']="200";
				$response['message']="Overtime reviewed successfully!";
			}else{
				$response['error']="400";
				$response['message']="Something went wrong. Please try again";
			}
		}else{
			$response['error']="400";
			$response['message']="Overtime Application Error.";
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