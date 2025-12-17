<?php
// Include your database connection file
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

// Construct the SQL query to retrieve beds and nurses for the ICU ratio table
$sql1 = "SELECT * FROM `bf_feedback_nurse_patients_ratio_ward` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result1 = mysqli_query($con, $sql1);

$totalBeds = 0;
$totalNurses = 0;
$num1 = 0;

if ($result1) {
    // Fetch the result as an associative array
    while ($row = mysqli_fetch_object($result1)) {

        $dataset = json_decode($row->dataset);

        // Accumulate the count of beds and nurses
        $totalBeds   += isset($dataset->beds) ? (int)$dataset->beds : 0;
        $totalNurses += isset($dataset->nurses) ? (int)$dataset->nurses : 0;
    }

    // Count the number of rows retrieved
    $num1 += mysqli_num_rows($result1);
}

// Prepare data to be returned as JSON
$data['total_beds'] = $totalBeds;
$data['total_nurses'] = $totalNurses;
$data['total_records'] = $num1;

// Output data as JSON
echo json_encode($data);

// Close the database connection
mysqli_close($con);
