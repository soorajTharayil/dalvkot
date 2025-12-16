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
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	$transfusion = $data['department'];

	$transfusion_request_time = $data['initial_assessment_hr1'];
	$blood_received_time = $data['initial_assessment_hr2'];
	$calculatedResult = $data['calculatedResultTime'];
	$benchmark =	$data['benchmark'];
	$transfusion_started_time = $data['initial_assessment_hr3'];
	$comments = $data['dataAnalysis'];

    


   $query = 'INSERT INTO `bf_feedback_tat_blood` (`name`,`patientid`,`mobile`,`email`,`datetime`,`datet`,`transfusion`,`transfusion_request_time`,`blood_received_time`,`tat_blood`,`benchmark`,`transfusion_started_time`,`comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $transfusion. '","' . $transfusion_request_time. '","' . $blood_received_time. '","' . $calculatedResult. '","' . $benchmark. '","' . $transfusion_started_time. '","' . $comments. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
