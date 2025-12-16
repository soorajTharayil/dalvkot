<?php
	error_reporting(0);
	$i=0;
    include('db.php');
    $mobile = $_GET['mobile'];
    $email = $_GET['email'];

	$data = array();
	   // Prepare SQL statement to prevent SQL injection
       $stmt = mysqli_prepare($con, 'SELECT * FROM `user` WHERE mobile=? OR email=?');
       mysqli_stmt_bind_param($stmt, 'ss', $mobile, $email);
       
       // Execute the query
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_object($result);
	if($result->num_rows > 0){
		$data['pinfo'] = $row;
	}else{
		$data['pinfo'] = 'NO';
	}
	
	//print_r($data); 
	mysqli_close($con);
	echo json_encode($data);
	
?>
