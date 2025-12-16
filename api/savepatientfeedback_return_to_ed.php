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
	$patientname = $data['patientname'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];

	$initial_consultation = $data['initial_assessment_hr1'];
	$complaintConsultation = $data['complaintAdmit'];
	$treatmentConsultation = $data['treatment_name'];

	$revisit_time = $data['initial_assessment_hr2'];
	$calculatedResult = $data['calculatedResultTime'];

	$complaintReconsultation = $data['complaint'];

	$comments = $data['dataAnalysis'];

    
	

	

   $query = 'INSERT INTO `bf_feedback_return_to_ed` (`name`,`patientid`,`patientname`,`mobile`,`email`,`datetime`,`datet`,`initial_consultation`,`complaintConsultation`,`treatmentConsultation`,`revisit_time`,`time_duration`,`complaintReconsultation`,`comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $patientname . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $initial_consultation. '","' . $complaintConsultation. '","' . $treatmentConsultation. '","' . $revisit_time. '","' . $calculatedResult. '","' . $complaintReconsultation. '","' . $comments. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
