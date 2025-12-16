<?php
include('db.php'); 

// Initialize an array to store the fetched asset details
$data = array();

// Check if the patientid is set in the request
if (isset($_GET['patientid'])) {
    $patientId = $_GET['patientid'];  

    // Query to fetch asset details based on the patientid
    $sql = "SELECT patientid, assetname, ward, component, depart, assignee, locationsite, bedno, preventive_maintenance_date 
            FROM bf_feedback_asset_creation 
            WHERE patientid = '$patientId'";  
} 
// Check if the assetname is set in the request
elseif (isset($_GET['assetname'])) {
    $assetName = $_GET['assetname'];  

    // Query to fetch asset details based on assetname
    $sql = "SELECT patientid, assetname, ward, component, depart, assignee, locationsite, bedno, preventive_maintenance_date 
            FROM bf_feedback_asset_creation 
            WHERE assetname = '$assetName'";  // Using LIKE for partial match
} else {
    // If neither patientid nor assetname is provided, return an empty result
    echo json_encode([]);
    exit;
}

// Execute the query
$result = mysqli_query($con, $sql);

// Check if the query returned any rows
if (mysqli_num_rows($result) > 0) {
    // Fetch each row and store it in the data array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Return the data as a JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($con);
?>
