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



	$sum_of_discharge_time =	$data['initial_assessment_total'];
	$no_of_patients_discharged =	$data['total_admission'];
	$calculatedResult =	$data['calculatedResult'];
	$benchmark =	$data['benchmark'];
	$excessTimeTaken = $data['excessTimeText'];

	
	$sum_of_discharge_time_ins =	$data['initial_assessment_total2'];
	$no_of_patients_discharged_ins =	$data['total_admission2'];
	$calculatedResult_ins =	$data['calculatedResult2'];
	$benchmark_ins =	$data['benchmark2'];
	$excessTimeTaken_ins = $data['excessTimeText2'];

	
	$sum_of_discharge_time_cop =	$data['initial_assessment_total3'];
	$no_of_patients_discharged_cop =	$data['total_admission3'];
	$calculatedResult_cop =	$data['calculatedResult3'];
	$benchmark_cop =	$data['benchmark3'];
	$excessTimeTaken_cop = $data['excessTimeText3'];

	$dataAnalysis =	$data['dataAnalysis'];
	$correctiveAction =	$data['correctiveAction'];
	$preventiveAction =	$data['preventiveAction'];
	$name =	$data['name'];
	$email =	$data['email'];
	$patientid =	$data['patientid'];
	$contactnumber =	$data['contactnumber'];





	$query = 'INSERT INTO `bf_feedback_24PSQ4c` (`name`, `email`, `patientid`, `mobile`, `sum_of_discharge_time`, `no_of_patients_discharged`, `avg_discharge_time`, `bench_mark_time`, `excess_time_taken`, `sum_of_discharge_time_ins`, `no_of_patients_discharged_ins`, `avg_discharge_time_ins`, `bench_mark_time_ins`, `excess_time_taken_ins`, `sum_of_discharge_time_cop`, `no_of_patients_discharged_cop`, `avg_discharge_time_cop`, `bench_mark_time_cop`, `excess_time_taken_cop`, `data_analysis`, `corrective_action`, `preventive_action`, `dataset`, `datet`, `datetime`) 
	VALUES ("' . $name . '", "' . $email . '", "' . $patientid . '", "' . $contactnumber . '", "' . $sum_of_discharge_time . '", "' . $no_of_patients_discharged . '", "' . $calculatedResult . '", "' . $benchmark . '", "' . $excessTimeTaken . '", "' . $sum_of_discharge_time_ins . '", "' . $no_of_patients_discharged_ins . '", "' . $calculatedResult_ins . '", "' . $benchmark_ins . '", "' . $excessTimeTaken_ins . '", "' . $sum_of_discharge_time_cop . '", "' . $no_of_patients_discharged_cop . '", "' . $calculatedResult_cop . '", "' . $benchmark_cop . '", "' . $excessTimeTaken_cop . '", "' . $dataAnalysis . '", "' . $correctiveAction . '", "' . $preventiveAction . '", "' . mysqli_real_escape_string($con, json_encode($data)) . '", "' . $datet . '", "' . $datetime . '");';
	
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
