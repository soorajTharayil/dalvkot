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
$staffAdheringCount = 0;
$staffAuditedCount = 0;


// Query to retrieve data from bf_feedback_ppe_audit table
$sql = "SELECT * FROM `bf_feedback_ppe_audit` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_object($result)) {
		// Extract necessary information
		$staffAuditedCount++;

		// Assuming the column name for safety precautions is 'safety_precautions'
		if ($row->department === 'Lab' || $row->department === 'USG') {
			// Conditions for Lab and USG departments
			if ($row->gloves === 'yes' && $row->mask === 'yes' && $row->cap === 'yes' && $row->apron === 'yes') {
				$staffAdheringCount++;
				

			}
		} else {
			// Conditions for Radiology department
			if ($row->gloves === 'yes' && $row->mask === 'yes' && $row->cap === 'yes' && $row->leadApron === 'yes' && $row->xrayBarrior === 'yes' && $row->tld === 'yes') {
				$staffAdheringCount++;
				

			}
		}
	}
}

//echo "safety precaution count in the current month: " . $staffAdheringCount;

// Construct data array
$data['staff_audited_count'] = $staffAuditedCount;
$data['staff_adhering_to_safety_precautions'] = $staffAdheringCount;

// Output the result
echo json_encode($data);

// Close database connection
mysqli_close($con);
