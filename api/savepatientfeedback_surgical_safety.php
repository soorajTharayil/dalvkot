<?php
include('db.php');

$patinet_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
	date_default_timezone_set('Asia/Kolkata');
	$data['name'] = strtoupper($data['name']);
	$today = date('Y-m-d');


	
	$name =	$data['name'];
	$patientid =	$data['patientid'];
	$surgeryname =	$data['surgeryname'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	$date_of_surgery =	$data['initial_assessment_hr1'];
	$antibiotic = $data['gloves'];
	$checklist = $data['mask'];
	$bundle_care = $data['cap'];
	$time_out = $data['apron'];
	$unplanned_return = $data['xrayBarrior'];
	
	$comments = $data['dataAnalysis'];
	
	




   $query = 'INSERT INTO `bf_feedback_surgical_safety` (`name`,`patientid`,`surgeryname`,`mobile`,`email`,`datetime`,`datet`,`date_of_surgery`,`antibiotic`,`checklist`,`bundle_care`,`time_out`,`unplanned_return`, `comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $surgeryname . '","'  . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $date_of_surgery . '","' . $antibiotic . '","'. $checklist . '","'. $bundle_care . '","'. $time_out . '","'. $unplanned_return . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

  $result = mysqli_query($con, $query);
  $fid = mysqli_insert_id($con);

	$response['status'] = 'success';
	$response['message'] = 'Data saved sucessfully';

	echo json_encode($response);


	mysqli_close($con);
}


//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
