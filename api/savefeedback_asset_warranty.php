<?php
include('db.php');

$d = file_get_contents('php://input');
$data = json_decode($d, true);

// Extract the patient ID and maintenance dates
$patient_id = $data['patientid'];
$assetWithWarranty = $data['assetWithWarranty'];

$warrantySDate = $data['warrantySDate'];
$warrantyEDate = $data['warrantyEDate'];

if (!empty($patient_id)) {
    // Patient ID exists, update maintenance dates
    $update_query = " UPDATE bf_feedback_asset_creation SET  assetWithWarranty = '$assetWithWarranty',  warrenty = '$warrantySDate', warrenty_end = '$warrantyEDate' WHERE patientid = '$patient_id'";

    if (mysqli_query($con, $update_query)) {
        echo json_encode(["status" => "success", "message" => "Maintenance dates updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update maintenance dates."]);
    }
}

mysqli_close($con);

// Trigger CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
curl_close($curl);
?>