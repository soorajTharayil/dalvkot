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
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];

	$site = $data['site'];
	$ward = $data['ward'];
	$icu = $data['icu'];
	$patient_status = $data['department'];
	$beds = $data['beds'];
	$nurses = $data['nurses'];
	
	$comments = $data['dataAnalysis'];
	
	

   $query = 'INSERT INTO `bf_feedback_nurse_patients_ratio` (`name`,`mobile`,`email`,`datetime`,`datet`,`site`,`ward`,`icu`,`patient_status`,`beds`,`nurses`,`comments`, `dataset`) 
   VALUES ("' . $name . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $site . '","'. $ward . '","'. $icu . '","'. $patient_status . '","'. $beds . '","'. $nurses . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
