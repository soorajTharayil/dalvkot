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


// Query to retrieve data

// USG and X-Ray
$sql = "SELECT * FROM `bf_feedback_ppe_audit` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_object($result)) {
		if ($row->department === 'USG' || $row->department === 'X-Ray') {
			$staffAuditedCount++;
			$param = json_decode($row->dataset, true);
			if (is_array($param) && ($param['gloves'] ?? '') !== 'no' && ($param['mask'] ?? '') !== 'no' && ($param['cap'] ?? '') !== 'no' && ($param['apron'] ?? '') !== 'no' && ($param['leadApron'] ?? '') !== 'no' && ($param['xrayBarrior'] ?? '') !== 'no' && ($param['tld'] ?? '') !== 'no' && ($param['ppe_to_patients'] ?? '') !== 'no') {
				$staffAdheringCount++;
			}
		} else {
			continue;
		}
	}
}


// Lab (no department filter in SQL)
$labSql = "SELECT * FROM `bf_feedback_lab_safety_audit` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$labRes = mysqli_query($con, $labSql);

if (mysqli_num_rows($labRes) > 0) {
	while ($row = mysqli_fetch_object($labRes)) {
		$staffAuditedCount++;
		$param = json_decode($row->dataset, true);
		if (is_array($param) && ($param['gloves'] ?? '') !== 'no' && ($param['mask'] ?? '') !== 'no' && ($param['cap'] ?? '') !== 'no' && ($param['apron'] ?? '') !== 'no' && ($param['lead_apron'] ?? '') !== 'no' && ($param['use_xray_barrior'] ?? '') !== 'no' && ($param['use_tld_badge'] ?? '') !== 'no' && ($param['ppe_to_patients'] ?? '') !== 'no' && ($param['no_recapping'] ?? '') !== 'no' && ($param['pts_disinfection'] ?? '') !== 'no') {
			$staffAdheringCount++;
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
