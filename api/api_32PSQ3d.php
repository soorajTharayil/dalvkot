<?php
// Include database connection
include('db.php');

// Initialize variables
$prescriptionsCount = 0;
$capitalCount = 0;


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

// Query to retrieve data from bf_feedback_mrd_audit table
 $sql = "SELECT * FROM `bf_feedback_prescriptions` WHERE YEAR(datetime) = $selectedYear AND MONTH(datetime) = $selectedMonth";
$result = mysqli_query($con, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_object($result)) {
        // Extract necessary information
        $prescriptionsCount++;

        if ($row->identification_details === 'yes') {
            $capitalCount++;
        }
    }
}

// Construct data array
$data['prescriptionsCount'] = $prescriptionsCount;
$data['capitalCount'] = $capitalCount;

// Output the result
echo json_encode($data);

// Close database connection
mysqli_close($con);
?>
