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
	$medicinename =	$data['medicinename'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	
	$correct_medicine = $data['gloves'];
	$correct_quantity = $data['mask'];
	$medicine_expiry = $data['cap'];
	
	$comments = $data['dataAnalysis'];
	
	




   $query = 'INSERT INTO `bf_feedback_medicine_dispense` (`name`,`patientid`,`medicinename`,`mobile`,`email`,`datetime`,`datet`,`correct_medicine`,`correct_quantity`,`medicine_expiry`, `comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $medicinename . '","'  . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","'  . $correct_medicine . '","'. $correct_quantity . '","'. $medicine_expiry . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
