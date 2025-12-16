<?php

$i = 0;
include('db.php');

// Get the current year and month
$currentYear = date('Y');
$currentMonth = date('m');

$sql = "SELECT * FROM `bf_feedback_incident` WHERE YEAR(datetime) = $currentYear AND MONTH(datetime) = $currentMonth";
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);

$currentMonth = date('m'); // Get the current month in numeric format (01 to 12)
$errorsCount = 0; // Initialize the count variable for both Diagnostic Errors and Reporting Errors

$j = 0;

if ($num1 > 0) {
    while ($row = mysqli_fetch_object($result)) {
        $parameter = json_decode($row->dataset)->checkedParameter;
		$category = $parameter->question;

        // Extract the month from the datetime field
        $incidentMonth = date('m', strtotime($row->datetime));

        // Check if the incident belongs to the current month and the category is either "Diagnostic Errors" or "Reporting Errors"
        if (($category === 'Needle stick injury') && $incidentMonth === $currentMonth) {
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
