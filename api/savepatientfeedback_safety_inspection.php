<?php
include('db.php');

$patient_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
	date_default_timezone_set('Asia/Kolkata');
	$data['name'] = strtoupper($data['name']);
	$today = date('Y-m-d');

	$name = $data['name'];
	$email = $data['email'];
	$contactnumber = $data['contactnumber'];
	$dep = $data['dep'];



	

	$comment = $data['dataAnalysis'];


	// Convert the associative array to a JSON string
	$dataset_json = json_encode($dataset);

	// Insert the JSON string into the 'dataset' column
    $query = 'INSERT INTO `bf_feedback_safety_inspection` (`name`,`mobile`,`email`,`department`,`datetime`,`datet`,`comment`,`dataset`) 
    VALUES ("' . $name . '","' . $contactnumber . '","' . $email . '","' . $dep . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $comment . '","'.mysqli_real_escape_string($con,json_encode($data)).'")';

	$result = mysqli_query($con, $query);
	$fid = mysqli_insert_id($con);

	$response['status'] = 'success';
	$response['message'] = 'Data saved successfully';

	echo json_encode($response);

	mysqli_close($con);
}

// TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
