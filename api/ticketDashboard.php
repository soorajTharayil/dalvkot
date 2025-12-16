<?php
// Include database connection
include "db.php";

// Get the JSON input and convert it to a PHP object
$input = file_get_contents("php://input");
$data = json_decode($input, true);
// User ID from the data array
$userId = $data['uid'];
// Parse the query parameters
$fdate = isset($_GET['fdate']) ? $_GET['fdate'] : null;
$tdate = isset($_GET['tdate']) ? $_GET['tdate'] : null;

// Default to last 30 days if no dates are provided
if (!$fdate || !$tdate) {
	$tdate = date('Y-m-d'); // Today's date
	$fdate = date('Y-m-d', strtotime('-30 days')); // 30 days ago
}
$tdate = date('Y-m-d', strtotime($tdate));
$fdate = date('Y-m-d', strtotime($fdate));



// Check if the module is 'IP'var_dump($data); exit;
if (isset($data["module"]) && $data["module"] == "IP") {

	$url = "http://demo.efeedor.com/TicketManagementApi/ticketdashboard/{$userId}/IP";
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
	$dataSet = json_decode($response);

	// Prepare the response array with the results
	$response = [
		"totalTicket" => $dataSet->totalTicket,
		"openTicket" => $dataSet->openTicket,
		"closedTicket" => $dataSet->closedTicket,
	];
	echo json_encode($response);

} elseif (isset($data["module"]) && $data["module"] == "OP") {
	$url = "http://demo.efeedor.com/TicketManagementApi/ticketdashboard/{$userId}/OP";
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
	$dataSet = json_decode($response);

	// Prepare the response array with the results
	$response = [
		"totalTicket" => $dataSet->totalTicket,
		"openTicket" => $dataSet->openTicket,
		"closedTicket" => $dataSet->closedTicket,
	];
	echo json_encode($response);
} elseif (isset($data["module"]) && $data["module"] == "ISR") {
	$url = "http://demo.efeedor.com/TicketManagementApi/ticketdashboard/{$userId}/ISR";
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
	$dataSet = json_decode($response);

	// Prepare the response array with the results
	$response = [
		"totalTicket" => $dataSet->totalTicket,
		"openTicket" => $dataSet->openTicket,
		"closedTicket" => $dataSet->closedTicket,
	];
	echo json_encode($response);
} elseif (isset($data["module"]) && $data["module"] == "PCF") {
	$url = "http://demo.efeedor.com/TicketManagementApi/ticketdashboard/{$userId}/PCF";
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
	$dataSet = json_decode($response);

	// Prepare the response array with the results
	$response = [
		"totalTicket" => $dataSet->totalTicket,
		"openTicket" => $dataSet->openTicket,
		"closedTicket" => $dataSet->closedTicket,
	];
	echo json_encode($response);
} elseif (isset($data["module"]) && $data["module"] == "INCIDENT") {
	$url = "http://demo.efeedor.com/TicketManagementApi/ticketdashboard/{$userId}/INCIDENT";
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
	$dataSet = json_decode($response);

	// Prepare the response array with the results
	$response = [
		"totalTicket" => $dataSet->totalTicket,
		"openTicket" => $dataSet->openTicket,
		"closedTicket" => $dataSet->closedTicket,
	];
	echo json_encode($response);

} else {
	// If module is not IP, return an error response
	$response = [
		"error" => true,
		"message" => "Invalid module or no module provided",
	];

	// Set the content type to JSON and return the response
	header("Content-Type: application/json");
	echo json_encode($response);
}

// Close the database connection
mysqli_close($con);
