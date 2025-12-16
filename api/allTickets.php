<?php
// Include database connection
include('db.php');
ini_set('memory_limit', '-1');

// Set the content type to JSON
header('Content-Type: application/json');

// Get the JSON input and convert it to a PHP object
$input = file_get_contents('php://input');
$data = json_decode($input, true);
// User ID from the data array
$userId = $data['uid'];
$fdate = isset($_GET['fdate']) ? $_GET['fdate'] : null;
$tdate = isset($_GET['tdate']) ? $_GET['tdate'] : null;

// Default to last 30 days if no dates are provided
if (!$fdate || !$tdate) {
	$tdate = date('Y-m-d'); // Today's date
	$fdate = date('Y-m-d', strtotime('-30 days')); // 30 days ago
}
$tdate = date('Y-m-d', strtotime($tdate));
$fdate = date('Y-m-d', strtotime($fdate));
// Build the URL dynamically
$url = "http://demo.efeedor.com/view/user_activity_permission/" . $userId;

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
	echo 'cURL Error: ' . curl_error($ch);
	curl_close($ch);
	exit;
}

// Close cURL resource
curl_close($ch);

// Save the response
$userPermission = json_decode($response, true);


// Check if the necessary fields are present
if (isset($data['module']) && isset($data['section']) && $data["module"] == "IP") {
	$module = $data['module'];
	$section = $data['section'];
	$status = $data['status'];
	$query = 'SELECT * FROM  `setup` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con, $query);
	while ($s = mysqli_fetch_assoc($overall)) {
		$setup[$s['shortkey']] = $s;
	}
	$url = "http://demo.efeedor.com/TicketManagementApi/allTicketDashboard/{$userId}/IP";
	$url .= "?tdate={$fdate}&fdate={$tdate}";

	// Initialize cURL
	$curl = curl_init($url);

	// Set cURL options
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);

	// Execute cURL request
	$response = curl_exec($curl);
	$dataSet = json_decode($response, true);

	if ($status == 'ALL') {
		$tickets = $dataSet['all'];
	}
	if ($status == 'OPEN') {
		$tickets = $dataSet['open'];
	}
	if ($status == 'CLOSED') {
		$tickets = $dataSet['closed'];
	}

	foreach ($tickets as $key => $row) {

		$tickets[$key]['dataset'] = $row['feed'];
		//$row['feed'] = json_decode(json_encode($rowfeed),true);
		$tickets[$key]['patientid'] = $row['patinet']['patient_id'];
		$rset = $row['feed']['reasonSet'][$row['department']['setkey']];

		$setKEYVALUE = '';
		foreach ($rset as $k => $r) {
			if ($r === true) {
				$setKEYVALUE = $k;
				$reasonText = $setup[$k]['question'];
			}
		}
		$tickets[$key]['reasonText'] = $reasonText;
		$tickets[$key]['departDesc'] = $row['department']['name'];
		$tickets[$key]['ticketID'] = $row['id'];
	}
	// Prepare the response
	$response = [
		'error' => false,
		'module' => $module,
		'section' => $status,
		'ticketCount' => count($tickets),
		'tickets' => $tickets
	];

	// Send the response
	echo json_encode($response);


} else if (isset($data['module']) && isset($data['section']) && $data["module"] == "ISR") {
	$module = $data['module'];
	$section = $data['section'];
	$status = $data['status'];
	$query = 'SELECT * FROM  `setup_esr` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con, $query);
	while ($s = mysqli_fetch_assoc($overall)) {
		$setup[$s['shortkey']] = $s;
	}
	//print_r($setup); exit;
	// Initialize the base query with JOINs for feedback and department tables
	$url = "http://demo.efeedor.com/TicketManagementApi/allTicketDashboard/{$userId}/ISR";
	$url .= "?tdate={$fdate}&fdate={$tdate}";

	// Initialize cURL
	$curl = curl_init($url);

	// Set cURL options
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);

	// Execute cURL request
	$response = curl_exec($curl);
	$dataSet = json_decode($response, true);

	if ($status == 'ALL') {
		$tickets = $dataSet['all'];
	}
	if ($status == 'OPEN') {
		$tickets = $dataSet['open'];
	}
	if ($status == 'CLOSED') {
		$tickets = $dataSet['closed'];
	}
	foreach ($tickets as $key => $row) {
		$tickets[$key]['dataset'] = $row['feed'];
		//$row['feed'] = json_decode(json_encode($rowfeed),true);
		$tickets[$key]['patientid'] = $row['patinet']['patient_id'];
		$rset = $row['feed']['reason'];

		$setKEYVALUE = '';
		foreach ($rset as $k => $r) {
			if ($r === true) {
				$setKEYVALUE = $k;
				$reasonText = $setup[$k]['question'];
			}
		}
		$tickets[$key]['reasonText'] = $reasonText;
		$tickets[$key]['departDesc'] = $row['department']['name'];
		$tickets[$key]['ticketID'] = $row['id'];
	}
	// Prepare the response
	$response = [
		'error' => false,
		'module' => $module,
		'section' => $status,
		'ticketCount' => count($tickets),
		'tickets' => $tickets
	];

	// Send the response
	echo json_encode($response);


} else if (isset($data['module']) && isset($data['section']) && $data["module"] == "OP") {
	$module = $data['module'];
	$section = $data['section'];
	$status = $data['status'];
	$query = 'SELECT * FROM  `setupop` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con, $query);
	while ($s = mysqli_fetch_assoc($overall)) {
		$setup[$s['shortkey']] = $s;
	}

	$url = "http://demo.efeedor.com/TicketManagementApi/allTicketDashboard/{$userId}/OP";
	$url .= "?tdate={$fdate}&fdate={$tdate}";

	// Initialize cURL
	$curl = curl_init($url);

	// Set cURL options
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);

	// Execute cURL request
	$response = curl_exec($curl);
	$dataSet = json_decode($response, true);

	if ($status == 'ALL') {
		$tickets = $dataSet['all'];
	}
	if ($status == 'OPEN') {
		$tickets = $dataSet['open'];
	}
	if ($status == 'CLOSED') {
		$tickets = $dataSet['closed'];
	}
	foreach ($tickets as $key => $row) {
		$tickets[$key]['dataset'] = $row['feed'];
		//$row['feed'] = json_decode(json_encode($rowfeed),true);
		$tickets[$key]['patientid'] = $row['patinet']['patient_id'];
		$rset = $row['feed']['reasonSet'][$row['department']['setkey']];

		$setKEYVALUE = '';
		foreach ($rset as $k => $r) {
			if ($r === true) {
				$setKEYVALUE = $k;
				$reasonText = $setup[$k]['question'];
			}
		}
		$tickets[$key]['reasonText'] = $reasonText;
		$tickets[$key]['departDesc'] = $row['department']['name'];
		$tickets[$key]['ticketID'] = $row['id'];
	}
	// Prepare the response
	$response = [
		'error' => false,
		'module' => $module,
		'section' => $status,
		'ticketCount' => count($tickets),
		'tickets' => $tickets
	];

	// Send the response
	echo json_encode($response);

} else if (isset($data['module']) && isset($data['section']) && $data["module"] == "PCF") {
	$module = $data['module'];
	$section = $data['section'];
	$status = $data['status'];
	$query = 'SELECT * FROM  `setup_int` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con, $query);
	while ($s = mysqli_fetch_assoc($overall)) {
		$setup[$s['shortkey']] = $s;
	}

	$url = "http://demo.efeedor.com/TicketManagementApi/allTicketDashboard/{$userId}/PCF";
	$url .= "?tdate={$fdate}&fdate={$tdate}";

	// Initialize cURL
	$curl = curl_init($url);

	// Set cURL options
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);

	// Execute cURL request
	$response = curl_exec($curl);
	$dataSet = json_decode($response, true);

	if ($status == 'ALL') {
		$tickets = $dataSet['all'];
	}
	if ($status == 'OPEN') {
		$tickets = $dataSet['open'];
	}
	if ($status == 'CLOSED') {
		$tickets = $dataSet['closed'];
	}
	foreach ($tickets as $key => $row) {
		$tickets[$key]['dataset'] = $row['feed'];
		//$row['feed'] = json_decode(json_encode($rowfeed),true);
		$tickets[$key]['patientid'] = $row['patinet']['patient_id'];
		$rset = $row['feed']['reason'];

		$setKEYVALUE = '';
		foreach ($rset as $k => $r) {
			if ($r === true) {
				$setKEYVALUE = $k;
				$reasonText = $setup[$k]['question'];
			}
		}
		$tickets[$key]['reasonText'] = $reasonText;
		$tickets[$key]['departDesc'] = $row['department']['name'];
		$tickets[$key]['ticketID'] = $row['id'];


	}
	// Prepare the response
	$response = [
		'error' => false,
		'module' => $module,
		'section' => $status,
		'ticketCount' => count($tickets),
		'tickets' => $tickets
	];

	// Send the response
	echo json_encode($response);


} else if (isset($data['module']) && isset($data['section']) && $data["module"] == "INCIDENT") {
	$module = $data['module'];
	$section = $data['section'];
	$status = $data['status'];
	$query = 'SELECT * FROM  `setup_incident` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con, $query);
	while ($s = mysqli_fetch_assoc($overall)) {
		$setup[$s['shortkey']] = $s;
	}
	$url = "http://demo.efeedor.com/TicketManagementApi/allTicketDashboard/{$userId}/INCIDENT";
	$url .= "?tdate={$fdate}&fdate={$tdate}";

	// Initialize cURL
	$curl = curl_init($url);

	// Set cURL options
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);

	// Execute cURL request
	$response = curl_exec($curl);
	$dataSet = json_decode($response, true);

	if ($status == 'ALL') {
		$tickets = $dataSet['all'];
	}
	if ($status == 'OPEN') {
		$tickets = $dataSet['open'];
	}
	if ($status == 'CLOSED') {
		$tickets = $dataSet['closed'];
	}
	foreach ($tickets as $key => $row) {
		$tickets[$key]['dataset'] = $row['feed'];
		//$row['feed'] = json_decode(json_encode($rowfeed),true);
		$tickets[$key]['patientid'] = $row['patinet']['patient_id'];
		$rset = $row['feed']['reason'];

		$setKEYVALUE = '';
		foreach ($rset as $k => $r) {
			if ($r === true) {
				$setKEYVALUE = $k;
				$reasonText = $setup[$k]['question'];
			}
		}
		$tickets[$key]['reasonText'] = $reasonText;
		$tickets[$key]['departDesc'] = $row['department']['name'];
		$tickets[$key]['ticketID'] = $row['id'];
	}
	// Prepare the response
	$response = [
		'error' => false,
		'module' => $module,
		'section' => $status,
		'ticketCount' => count($tickets),
		'tickets' => $tickets
	];

	// Send the response
	echo json_encode($response);


} else {
	// Invalid input, missing module or section
	echo json_encode([
		'error' => true,
		'message' => 'Invalid input. Both "module" and "section" are required.'
	]);
}

// Close the database connection
mysqli_close($con);
