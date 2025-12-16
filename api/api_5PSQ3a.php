<?php
// Include database connection
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


// Initialize variables
$chartsReviewedCount = 0;
$errorProneAbbreviationCount = 0;


// Query to retrieve data from bf_feedback_mrd_audit table
$sql = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_object($result)) {
        // Extract necessary information
        $chartsReviewedCount++;

        // Assuming the column name for abbreviation error flag is 'error_prone'
        if ($row->error_prone === 'yes') {
            $errorProneAbbreviationCount++;
        }
    }
}

// Construct data array
$data['charts_reviewed_count'] = $chartsReviewedCount;
$data['error_prone_abbreviation_count'] = $errorProneAbbreviationCount;

// Output the result
echo json_encode($data);

// Close database connection
mysqli_close($con);
?>
