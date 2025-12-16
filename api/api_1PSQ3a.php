<?php

include('db.php');
// Mapping of month names to numbers
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

// Construct the SQL query to retrieve records for the selected month and year
 $sql = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";

$result = $con->query($sql);

if ($result) {
    $num1 = $result->num_rows;

    // Initialize variables to store total hours, minutes, and seconds
    $totalHours = 0;
    $totalMinutes = 0;
    $totalSeconds = 0;

    if ($num1 > 0) {
        while ($row = $result->fetch_object()) {
            // Extract datetime from initial_assessment
            $datetime = $row->initial_assessment;

            // Split datetime string, stored in an array, then extract time part
            $dateTimeParts = explode(' ', $datetime);
            if (count($dateTimeParts) == 2) {
                $time = $dateTimeParts[1];
                list($hours, $minutes, $seconds) = explode(':', $time);

                // Accumulate hours, minutes, and seconds to the totals
                $totalHours += (int)$hours;
                $totalMinutes += (int)$minutes;
                $totalSeconds += (int)$seconds;
            }
        }
    }

    // Convert excess seconds to minutes
    $totalMinutes += floor($totalSeconds / 60);
    $totalSeconds = $totalSeconds % 60;

    // Convert excess minutes to hours
    $totalHours += floor($totalMinutes / 60);
    $totalMinutes = $totalMinutes % 60;

    $data['totalHours'] = $totalHours;
    $data['totalMinutes'] = $totalMinutes;
    $data['totalSeconds'] = $totalSeconds;
    $data['totalAdmission'] = $num1;

    // Return JSON response
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Failed to execute SQL query.']);
}

mysqli_close($con);
