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
	$testname =	$data['testname'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	$billing_time = $data['initial_assessment_hr1'];
	$sample_received_time = $data['initial_assessment_hr2'];
	$calculatedResult = $data['calculatedResultTime'];
    $general_comment = $data['dataAnalysis'];
	

	

   $query = 'INSERT INTO `bf_feedback_lab_wait_time` (`name`,`patientid`,`testname`,`mobile`,`email`,`datetime`,`datet`,`billing_time`,`sample_received_time`,`lab_wait_time`,`general_comment`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $testname . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $billing_time. '","' . $sample_received_time. '","' . $calculatedResult. '","' . $general_comment. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
