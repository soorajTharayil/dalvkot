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

	$ward = $data['ward'];
	$designation = $data['department'];
	$staffname = $data['staffname'];
	
	$identification_details = $data['identification_details'];
	$vital_signs = $data['vital_signs'];
	$surgery = $data['surgery'];
	$complaints_communicated = $data['complaints_communicated'];
	$intake = $data['intake'];
	$output = $data['output'];
	$allergies = $data['allergies'];
	$medication = $data['medication'];
	$diagnostic = $data['diagnostic'];
	$lab_results = $data['lab_results'];
	$pending_investigation = $data['pending_investigation'];
	$medicine_order = $data['medicine_order'];
	$facility_communicated = $data['facility_communicated'];
	$health_education = $data['health_education'];
	$risk_assessment = $data['risk_assessment'];
	$relevant_details = $data['relevant_details'];

	
	$comments = $data['dataAnalysis'];
	
	

   $query = 'INSERT INTO `bf_feedback_handover` (`name`,`patientid`,`mobile`,`email`,`datetime`,`datet`,`ward`,`designation`,`staffname`,`identification_details`,`vital_signs`,`surgery`,`complaints_communicated`,`intake`,`output`,`allergies`,`medication`,`diagnostic`,`lab_results`,`pending_investigation`,`medicine_order`,`facility_communicated`,`health_education`,`risk_assessment`,`relevant_details`,`comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","'  . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $ward . '","'. $designation . '","'. $staffname . '","'. $identification_details . '","'. $vital_signs . '","'. $surgery . '","'. $complaints_communicated . '","'. $intake . '","'. $output . '","' . $allergies . '","' . $medication . '","' . $diagnostic . '","' . $lab_results . '","' . $pending_investigation . '","' . $medicine_order . '","'. $facility_communicated . '","' . $health_education . '","' . $risk_assessment . '","'. $relevant_details . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
