<?php

class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
 
/*function loginUser($email,$password){
	$stmt = $this->con->prepare("SELECT * FROM tblemployees WHERE EmailId = ? AND Password = ? AND (role ='Staff' OR role ='HOD')");
	$stmt->bind_param("ss", $email,$password);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;
	if($rows != 0){
		return true;
	}else{
		return false;
	}
	
	
}*/

function getUserDetails($email,$password){
	$stmt = $this->con->prepare("SELECT emp_id, qr_id, FirstName, LastName, EmailId, Password, Gender, Dob, Department, 
	Address, Av_leave,Leave_Vacation, Leave_Emergency, Leave_Paternity, Leave_Maternity, Av_overtime, Phonenumber, Status, RegDate, 
	role, location FROM tblemployees WHERE EmailId = ? AND Password = ? AND (role ='Staff' or role = 'HOD')");
    $stmt->bind_param("ss", $email,$password);
    $stmt->execute();    
    $stmt->bind_result($emp_id,$qr_id,$FirstName,$LastName,$EmailId,$Password,$gender,$bday,$department,$address,$avleave,
	$Leave_Vacation,$Leave_Emergency, $Leave_Paternity,$Leave_Maternity,$avovertime,$phonenumber,$status,$regdate,$role,$profilepic,);

    $loggeduser = array();
    $user = array();   
    while($stmt->fetch()){
        $user['emp_id'] = $emp_id;
        $user['qr_id'] = $qr_id;
        $user['FirstName'] = $FirstName;
        $user['LastName'] = $LastName;
        $user['EmailId'] = $EmailId;
        $user['Password'] = $Password;
		$user['Department'] = $department;
		// continue this
        $user['Gender'] = $gender;
		$user['Dob'] = $bday;
        $user['Address'] = $address;
		$user['Av_leave'] = $avleave;
		$user['Leave_Vacation'] = $Leave_Vacation;
		$user['Leave_Emergency'] = $Leave_Emergency;
		$user['Leave_Paternity'] = $Leave_Paternity;
		$user['Leave_Maternity'] = $Leave_Maternity;
		$user['Av_overtime'] = $avovertime;
		$user['Phonenumber'] = $phonenumber;
		$user['RegDate'] = $regdate;
		$user['role'] = $role;
		$imagelink = "https://hajekqenterprises.com/uploads/".$profilepic;
		$user['location'] = $imagelink;
        array_push($loggeduser, $user);
    }
    return $loggeduser;
}

function getUserSchedule($department){
	$stmt = $this->con->prepare("SELECT * FROM schedule WHERE Department = ?");
    $stmt->bind_param("s", $department);
    $stmt->execute();    
    $stmt->bind_result($id, $department, $time, $day, $timein, $timeout);
    $schedule = array();
    while($stmt->fetch()){
		$user = array();  
        $user['id'] = $id;
        $user['Department'] = $department;
        $user['Time'] = $time;
        $user['Day'] = $day;
		$user['Time_in'] = $timein;
		$user['Time_out'] = $timeout;
        array_push($schedule, $user);
    }
    return $schedule;
}

function getUserQR($qr_id){
	$stmt = $this->con->prepare("SELECT qr_id FROM tblemployees WHERE qr_id = ?");
    $stmt->bind_param("s", $qr_id);
    $stmt->execute();    
    $stmt->bind_result($qr_id);
    $qrarray = array();
    while($stmt->fetch()){
		$qr = array();  
        $imagelink = "https://hajekqenterprises.com/admin/qrcode_generate/images/".$qr_id.".png";
        $qr['qr_id'] = $imagelink;
        
		array_push($qrarray, $qr);
    }
    return $qrarray;
}

function ViewQR(){
    $stmt = $this->con->prepare("SELECT qr_id FROM tblemployees");
    $stmt->execute();
    $stmt->bind_result($qr_id);
    $qrarray = array();
    while($stmt->fetch()){
		$qr = array();
        $imagelink = "https://hajekqenterprises.com/admin/qrcode_generate/images/".$qr_id.".png";
        $qr['qr_id'] = $imagelink;

        array_push($qrarray,$qr);
    }    
    return $qrarray;
} 

// Prioritize View Leave and Overtime History

function viewLeaveHistory($empid){
	$stmt = $this->con->prepare("SELECT * FROM tblleaves WHERE empid = ?");
    $stmt->bind_param("s", $empid);
    $stmt->execute();    
    $stmt->bind_result($id, $leavetype, $todate, $fromdate, $description, $postingdate, 
	$adminremark, $registraremark, $adminremarkdate, $status, $admin_status, $isread, $empid, $num_days);
    $leaves = array();
	
	
	
    while($stmt->fetch()){
		$user = array();  
		
        $user['id'] = $id;
        $user['LeaveType'] = $leavetype;
		$user['ToDate'] = $todate;
		$user['FromDate'] = $fromdate;
		$user['Description'] = $description;
		$user['PostingDate'] = $postingdate;
		$user['AdminRemark'] = $adminremark;
		$user['registra_remarks'] = $registraremark;
		$user['AdminRemarkDate'] = $adminremarkdate;
		$user['Status'] = $status;	
		$user['admin_status'] = $admin_status;
		$user['IsRead'] = $isread;
        $user['empid'] = $empid;
        $user['num_days'] = $num_days;
        array_push($leaves, $user);
    }
    return $leaves;
}

function viewOvertimeHistory($empid){
	$stmt = $this->con->prepare("SELECT * FROM tblovertime WHERE empid = ?");
    $stmt->bind_param("s", $empid);
    $stmt->execute();    
    $stmt->bind_result($id, $fromdate, $description, $postingdate,$adminremark, $registraremark, $adminremarkdate, $status, $admin_status, $isread, $empid, $num_hrs);
    $overtime = array();
    while($stmt->fetch()){
		$user = array();  
        $user['id'] = $id;
		$user['FromDate'] = $fromdate;
		$user['Description'] = $description;
		$user['PostingDate'] = $postingdate;
		$user['AdminRemark'] = $adminremark;
		$user['registra_remarks'] = $registraremark;
		$user['AdminRemarkDate'] = $adminremarkdate;
		$user['Status'] = $status;
		$user['admin_status'] = $admin_status;
		$user['IsRead'] = $isread;
        $user['empid'] = $empid;
        $user['num_hrs'] = $num_hrs;
        array_push($overtime, $user);
    }
    return $overtime;
}


    
}




?>
