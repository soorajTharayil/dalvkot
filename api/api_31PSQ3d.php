<?php
// Include database connection
include('db.php');

// Initialize variables
$opportunitiesCount = 0;
$handoverCount = 0;

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
$sql = "SELECT * FROM `bf_feedback_handover` WHERE YEAR(datet) = $selectedYear AND MONTH(datet) = $selectedMonth";
$result = mysqli_query($con, $sql);

// Initialize count variables
$totalNoCount = 0;
$totalNoCount_NA = 0;

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_object($result)) {

        $dataset = json_decode($row->dataset);

        // Loop through the relevant columns and count 'no'
        $columnsToCheck = [
            'identification_details', 
            'vital_signs', 
            'surgery', 
            'complaints_communicated', 
            'intake', 
            'output', 
            'allergies', 
            'medication', 
            'diagnostic', 
            'lab_results', 
            'pending_investigation', 
            'medicine_order', 
            'facility_communicated', 
            'health_education', 
            'risk_assessment', 
            'relevant_details'
        ];

        foreach ($columnsToCheck as $column) {
            if ($dataset->$column === 'no') {
                $totalNoCount++;
            }
        }
        foreach ($columnsToCheck as $column) {
            if ($dataset->$column === 'N/A') {
                $totalNoCount_NA++;
            }
        }
        $opportunitiesCount++;
    }
}

// Construct data array
$data = [
    'handoverCount_NO' => $totalNoCount,
    'handoverCount_NA' => $totalNoCount_NA,
    'opportunitiesCount' => ($opportunitiesCount * 16) - $totalNoCount_NA,// For 1 patient there are 16 opportunities
    'handoverCount' => ($opportunitiesCount * 16) - ($totalNoCount_NA) - $totalNoCount

    // 'handoverCount' => $handoverCount
];

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close database connection
mysqli_close($con);
