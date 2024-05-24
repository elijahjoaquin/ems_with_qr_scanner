<?php
	$conn = new mysqli('localhost', 'root', '', 'leave_staff');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>