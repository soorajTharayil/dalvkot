<?php
// Include database connection
include('db.php');

// Initialize variables
$chartsReviewedCount = 0;
$consentVerifiedCount = 0;

// Get the current month
$currentYear = date('Y');
$currentMonth = date('m');

// Query to retrieve data from bf_feedback_mrd_audit table
$sql = "SELECT * FROM `bf_feedback_mrd_audit` WHERE YEAR(datetime) = $currentYear AND MONTH(datetime) = $currentMonth";
$result = mysqli_query($con, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_object($result)) {
        // Extract necessary information
        $chartsReviewedCount++;

        // Assuming the column name for abbreviation error flag is 'error_prone'
        if ($row->consent_verified === 'no') {
            $consentVerifiedCount++;
        }
    }
}

// Construct data array
$data['charts_reviewed_count'] = $chartsReviewedCount;
$data['error_prone_abbreviation_count'] = $consentVerifiedCount;

// Output the result
echo json_encode($data);

// Close database connection
mysqli_close($con);
?>
