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
	$today = date('Y-m-d');


	// Convert month name to number
	$monthNumber = date('m', strtotime($month));  // Converts "January" to "01", etc.

	// Get the current day and time
	$currentDay = date('d');  // Get the current day
	$currentTime = date('H:i:s');  // Get the current time

	// Construct `datet` and `datetime`
	//$datet = $year . '-' . $monthNumber . '-' . $currentDay;  // Constructs the date as "YYYY-MM-01"
	$datetime = $year . '-' . $monthNumber . '-' . $currentDay . ' ' . $currentTime;  // Constructs the datetime as "YYYY-MM-DD HH:MM:SS"



	$no_reporting_error_total =	$data['initial_assessment_hr'];
	$test_performed =	$data['total_admission'];
	$dataAnalysis =	$data['dataAnalysis'];
	$correctiveAction =	$data['correctiveAction'];
	$preventiveAction =	$data['preventiveAction'];
	$calculatedResult =	$data['calculatedResult'];
	$benchmark =	$data['benchmark'];
	$name =	$data['name'];
	$email =	$data['email'];
	$patientid =	$data['patientid'];
	$contactnumber =	$data['contactnumber'];





	$query = 'INSERT INTO `bf_feedback_2PSQ3a`(`name`, `email`, `patientid`, `mobile`, `reporting_errors`, `number_of_test_performed`, `average_no_of_reporting_errors`, `bench_mark_time`, `data_analysis`, `corrective_action`, `preventive_action`, `dataset`, `datet`, `datetime`) 
	VALUES ("' . $name . '", "' . $email . '", "' . $patientid . '", "' . $contactnumber . '", "' . $no_reporting_error_total . '", "' . $test_performed . '", "' . $calculatedResult . '", "' . $benchmark . '", "' . $dataAnalysis . '", "' . $correctiveAction . '", "' . $preventiveAction . '", "' . mysqli_real_escape_string($con, json_encode($data)) . '", "' . $today . '", "' . $datetime . '")';

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
