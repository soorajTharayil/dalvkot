<?php
include('db.php');

$patinet_id = $_GET['patient_id'];

$month = $_GET['month'];  // e.g., "January"
$year = $_GET['year'];    // e.g., "2024"

$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
	date_default_timezone_set('Asia/Kolkata');
	$data['name'] = strtoupper($data['name']);

	// Convert month name to number
	$monthNumber = date('m', strtotime($month));  // Converts "January" to "01", etc.

	// Get the current day and time
	$currentDay = date('d');  // Get the current day
	$currentTime = date('H:i:s');  // Get the current time

	// Construct `datet` and `datetime`
	$datet = $year . '-' . $monthNumber . '-' . $currentDay;  // Constructs the date as "YYYY-MM-01"
	$datetime = $year . '-' . $monthNumber . '-' . $currentDay . ' ' . $currentTime;  // Constructs the datetime as "YYYY-MM-DD HH:MM:SS"

	$actual_deaths_icu =	$data['initial_assessment_hr'];
	$predicted_deaths_icu =	$data['total_admission'];
	$dataAnalysis =	$data['dataAnalysis'];
	$correctiveAction =	$data['correctiveAction'];
	$preventiveAction =	$data['preventiveAction'];
	$calculatedResult =	$data['calculatedResult'];
	$benchmark =	$data['benchmark'];
	$name =	$data['name'];
	$email =	$data['email'];
	$patientid =	$data['patientid'];
	$contactnumber =	$data['contactnumber'];





    $query = 'INSERT INTO `bf_feedback_42PSQ3a` (`name`,`email`,`patientid`,`mobile`,`actual_deaths_icu`, `predicted_deaths_icu`, `percentage_of_mortality_ratio`, `bench_mark_time`, `data_analysis`,`corrective_action`,`preventive_action`, `dataset`,`datet`,`datetime`) 
	VALUES ("' . $name . '","' . $email . '","' . $patientid . '","' . $contactnumber . '","' . $actual_deaths_icu . '","' . $predicted_deaths_icu . '","' . $calculatedResult . '","' . $benchmark . '","' . $dataAnalysis . '","' . $correctiveAction . '","' . $preventiveAction . '","' . mysqli_real_escape_string($con, json_encode($data)) . '","' . $datet . '","' . $datetime . '")';

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
