<?php
	error_reporting(0);
	$i=0;
    include('db.php');
	$data = array();
	$sql = 'SELECT * FROM `patients_from_admission` WHERE mobile="'.$_GET['mobile'].'"' ;			
	$result = mysqli_query($con,$sql);	
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
