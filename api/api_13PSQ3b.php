<?php

$i = 0;
include('db.php');

$monthNames = array(
    "January" => 1,
    "February" => 2,
    "March" => 3,
    "April" => 4,
    "May" => 5,
    "June" => 6,
    "July" => 7,
    "August" => 8,
    "September" => 9,
    "October" => 10,
    "November" => 11,
    "December" => 12
);

// Retrieve parameters from the query string
$selectedMonthName = isset($_GET['month']) ? $_GET['month'] : date('F');
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Convert month name to its numeric value
$selectedMonth = $monthNames[$selectedMonthName];

// Escape variables to prevent SQL injection
$selectedMonth = mysqli_real_escape_string($con, $selectedMonth);
$selectedYear = mysqli_real_escape_string($con, $selectedYear);



$sql = "SELECT * FROM `bf_feedback_incident` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);


$errorsCount = 0; // Initialize the count variable for both Diagnostic Errors and Reporting Errors

$j = 0;

if ($num1 > 0) {
    while ($row = mysqli_fetch_object($result)) {
        $parameter = json_decode($row->dataset)->checkedParameter;
		$category = $parameter->question;

        // Extract the month from the datetime field
        $incidentMonth = date('m', strtotime($row->datetime));

        // Check if the incident belongs to the current month and the category is either "Diagnostic Errors" or "Reporting Errors"
        if (($category === 'Catheter-associated Urinary Tract Infections (CAUTI)') && $incidentMonth === $selectedMonth) {
            $errorsCount++;
		
        }

        $data['incident'][$j]['datetime'] = $row->datetime;
        $data['incident_count'] = $num1;
        $data['errors_count'] = $errorsCount;

        $i++;
        $j++;
    }
    
}

echo json_encode($data);
mysqli_close($con);
?>
