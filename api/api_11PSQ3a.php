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


// Construct the SQL query to retrieve count of records for the current month and year
$sql = "SELECT COUNT(*) AS num1 FROM `bf_feedback_return_to_ed` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";


$result = mysqli_query($con, $sql);

$num1 = 0;


if ($result) {
    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Extract the count from the result
    $num1 = isset($row['num1']) ? (int)$row['num1'] : 0;
}

// Prepare data to be returned as JSON
$data['initial_assessment_hr'] = $num1;

// Output data as JSON
echo json_encode($data);

// Close the database connection
mysqli_close($con);
?>
