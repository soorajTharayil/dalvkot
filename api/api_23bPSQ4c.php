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


// Construct the SQL query to retrieve records for the current month
$sql = "SELECT * FROM `bf_feedback_xray_wait_time` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);

// Initialize variables to store total hours, minutes, and seconds
$totalHours = 0;
$totalMinutes = 0;
$totalSeconds = 0;

if ($num1 > 0) {
    while ($row = mysqli_fetch_object($result)) {
        // Extract datetime from initial_assessment
        $time = $row->xray_wait_time;

        list($hours, $minutes, $seconds) = explode(':', $time);

        // Accumulate hours, minutes, and seconds to the totals
        $totalHours += (int)$hours;
        $totalMinutes += (int)$minutes;
        $totalSeconds += (int)$seconds;
    }
}

// Convert excess seconds to minutes
$totalMinutes += floor($totalSeconds / 60);
$totalSeconds = $totalSeconds % 60;

// Convert excess minutes to hours
$totalHours += floor($totalMinutes / 60);
$totalMinutes = $totalMinutes % 60;

$data['initial_assessment_hr'] = $totalHours;
$data['initial_assessment_min'] = $totalMinutes;
$data['initial_assessment_sec'] = $totalSeconds;
$data['total_admission'] = $num1;

echo json_encode($data);
mysqli_close($con);
