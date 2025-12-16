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


// Initialize variables for each category
$totalHoursGeneral = $totalMinutesGeneral = $totalSecondsGeneral = 0;
$totalHoursInsurance = $totalMinutesInsurance = $totalSecondsInsurance = 0;
$totalHoursCorporate = $totalMinutesCorporate = $totalSecondsCorporate = 0;

// Queries for each patient category
$sql_general = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(time_taken_for_discharge) = $selectedYear AND MONTH(time_taken_for_discharge) = $selectedMonth AND patient_category = 'General'";
$sql_insurance = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(time_taken_for_discharge) = $selectedYear AND MONTH(time_taken_for_discharge) = $selectedMonth AND patient_category = 'Insurance'";
$sql_corporate = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(time_taken_for_discharge) = $selectedYear AND MONTH(time_taken_for_discharge) = $selectedMonth AND patient_category = 'Corporate'";

// Execute queries
$result_general = mysqli_query($con, $sql_general);
$result_insurance = mysqli_query($con, $sql_insurance);
$result_corporate = mysqli_query($con, $sql_corporate);

// Calculate totals for General
if (mysqli_num_rows($result_general) > 0) {
    while ($row = mysqli_fetch_object($result_general)) {
        $datetime = $row->time_taken_for_discharge;
        $dateTimeParts = explode(' ', $datetime);
        if (count($dateTimeParts) == 2) {
            $time = $dateTimeParts[1];
            list($hours, $minutes, $seconds) = explode(':', $time);
            $totalHoursGeneral += (int)$hours;
            $totalMinutesGeneral += (int)$minutes;
            $totalSecondsGeneral += (int)$seconds;
        }
    }
}

// Calculate totals for Insurance
if (mysqli_num_rows($result_insurance) > 0) {
    while ($row = mysqli_fetch_object($result_insurance)) {
        $datetime = $row->time_taken_for_discharge;
        $dateTimeParts = explode(' ', $datetime);
        if (count($dateTimeParts) == 2) {
            $time = $dateTimeParts[1];
            list($hours, $minutes, $seconds) = explode(':', $time);
            $totalHoursInsurance += (int)$hours;
            $totalMinutesInsurance += (int)$minutes;
            $totalSecondsInsurance += (int)$seconds;
        }
    }
}

// Calculate totals for Corporate
if (mysqli_num_rows($result_corporate) > 0) {
    while ($row = mysqli_fetch_object($result_corporate)) {
        $datetime = $row->time_taken_for_discharge;
        $dateTimeParts = explode(' ', $datetime);
        if (count($dateTimeParts) == 2) {
            $time = $dateTimeParts[1];
            list($hours, $minutes, $seconds) = explode(':', $time);
            $totalHoursCorporate += (int)$hours;
            $totalMinutesCorporate += (int)$minutes;
            $totalSecondsCorporate += (int)$seconds;
        }
    }
}

// Convert excess seconds to minutes for each category
$totalMinutesGeneral += floor($totalSecondsGeneral / 60);
$totalSecondsGeneral = $totalSecondsGeneral % 60;
$totalHoursGeneral += floor($totalMinutesGeneral / 60);
$totalMinutesGeneral = $totalMinutesGeneral % 60;

// Repeat the same conversion for the other categories
$totalMinutesInsurance += floor($totalSecondsInsurance / 60);
$totalSecondsInsurance = $totalSecondsInsurance % 60;
$totalHoursInsurance += floor($totalMinutesInsurance / 60);
$totalMinutesInsurance = $totalMinutesInsurance % 60;

$totalMinutesCorporate += floor($totalSecondsCorporate / 60);
$totalSecondsCorporate = $totalSecondsCorporate % 60;
$totalHoursCorporate += floor($totalMinutesCorporate / 60);
$totalMinutesCorporate = $totalMinutesCorporate % 60;

// Prepare data to be returned as JSON
$data = [
    'totalHoursGeneral' => $totalHoursGeneral,
    'totalMinutesGeneral' => $totalMinutesGeneral,
    'totalSecondsGeneral' => $totalSecondsGeneral,
    'totalAdmissionGeneral' => mysqli_num_rows($result_general),

    'totalHoursInsurance' => $totalHoursInsurance,
    'totalMinutesInsurance' => $totalMinutesInsurance,
    'totalSecondsInsurance' => $totalSecondsInsurance,
    'totalAdmissionInsurance' => mysqli_num_rows($result_insurance),

    'totalHoursCorporate' => $totalHoursCorporate,
    'totalMinutesCorporate' => $totalMinutesCorporate,
    'totalSecondsCorporate' => $totalSecondsCorporate,
    'totalAdmissionCorporate' => mysqli_num_rows($result_corporate),
];

echo json_encode($data);
mysqli_close($con);
?>