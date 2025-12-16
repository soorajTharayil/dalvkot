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
	$department =	$data['department'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	$register_time = $data['initial_assessment_hr1'];
	$room_enter_time = $data['initial_assessment_hr2'];
	$calculatedResult = $data['calculatedResultTime'];
	$general_comment = $data['dataAnalysis'];
    
	

	

   $query = 'INSERT INTO `bf_feedback_consultation_time` (`name`,`patientid`,`department`,`mobile`,`email`,`datetime`,`datet`,`register_time`,`room_enter_time`,`consultation_wait_time`,`general_comment`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $department . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $register_time. '","' . $room_enter_time. '","' . $calculatedResult. '","' . $general_comment. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
