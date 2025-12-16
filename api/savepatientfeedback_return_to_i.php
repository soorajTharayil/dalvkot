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

	$initial_admission = $data['initial_assessment_hr1'];
	$complaintAdmission = $data['complaintAdmit'];
	$treatmentAdmission = $data['treatment_name'];

	$initial_discharge = $data['initial_assessment_hr2'];
	$re_admission = $data['initial_assessment_hr3'];

	$calculatedResult = $data['calculatedResultTime'];

	$complaintReadmission = $data['complaint'];

	$comments = $data['dataAnalysis'];

    
	

	

   $query = 'INSERT INTO `bf_feedback_return_to_i` (`name`,`patientid`,`mobile`,`email`,`datetime`,`datet`,`initial_admission`,`complaintAdmission`,`treatmentAdmission`,`initial_discharge`,`re_admission`,`time_duration`,`complaintReadmission`,`comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $initial_admission. '","' . $complaintAdmission. '","' . $treatmentAdmission. '","' . $initial_discharge. '","' . $re_admission. '","' . $calculatedResult. '","' . $complaintReadmission. '","' . $comments. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
