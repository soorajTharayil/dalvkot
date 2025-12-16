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

	$triple_check = $data['gloves'];
	$medicine_labelled = $data['mask'];
	$file_verified = $data['cap'];
	$six_rights = $data['apron'];
	$administration_documented = $data['lead_apron'];

	$use_xray_barrior = $data['use_xray_barrior'];
	$patient_file = $data['patient_file'];
	$verified = $data['verified'];
	$indication = $data['indication'];
	$medicine = $data['medicine'];
	$alert = $data['alert'];
	$dilution = $data['dilution'];
	$administering = $data['administering'];
	$privacy = $data['privacy'];
	$vials = $data['vials'];
	$cannula = $data['cannula'];
	$flush = $data['flush'];
	$medications = $data['medications'];
	$reassess = $data['reassess'];
	$oral = $data['oral'];
	$discarded = $data['discarded'];
	$handwashing = $data['handwashing'];
	$procedures = $data['procedures'];


	$comments = $data['dataAnalysis'];



	$query = 'INSERT INTO `bf_feedback_medication_administration` (`name`, `patientid`, `mobile`, `email`, `datetime`, `datet`, `triple_check`, `medicine_labelled`, `file_verified`, `six_rights`, `administration_documented`, `use_xray_barrior`, `patient_file`, `verified`, `indication`, `medicine`, `alert`, `dilution`, `administering`, `privacy`, `vials`, `cannula`, `flush`, `medications`, `reassess`, `oral`, `discarded`, `handwashing`, `procedures`, `comments`, `dataset`) 
	VALUES ("' . $name . '", "' . $patientid . '", "' . $contactnumber . '", "' . $email . '", "' . date('Y-m-d H:i:s') . '", "' . $today . '", "' . $triple_check . '", "' . $medicine_labelled . '", "' . $file_verified . '", "' . $six_rights . '", "' . $administration_documented . '", "' . $use_xray_barrior . '", "' . $patient_file . '", "' . $verified . '", "' . $indication . '", "' . $medicine . '", "' . $alert . '", "' . $dilution . '", "' . $administering . '", "' . $privacy . '", "' . $vials . '", "' . $cannula . '", "' . $flush . '", "' . $medications . '", "' . $reassess . '", "' . $oral . '", "' . $discarded . '", "' . $handwashing . '", "' . $procedures . '", "' . $comments . '", "' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
