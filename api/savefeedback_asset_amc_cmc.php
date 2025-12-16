<?php
include('db.php');

$d = file_get_contents('php://input');
$data = json_decode($d, true);

// Extract the patient ID and contract type
$patient_id = $data['patientid'];
$assetWithAmc = $data['assetWithAmc'];

$contract = $data['contract'];

// Separate fields for AMC and CMC
$amc_start_date = $data['amcStartDate'];
$amc_end_date = $data['amcEndDate'];
$amc_service_charges = $data['amcServiceCharges'];

$cmc_start_date = $data['cmcStartDate'];
$cmc_end_date = $data['cmcEndDate'];
$cmc_service_charges = $data['cmcServiceCharges'];

if (!empty($patient_id)) {
    // Step 1: Update contract type
    $update_contract_type_query = "UPDATE bf_feedback_asset_creation SET assetWithAmc = '$assetWithAmc',  contract = '$contract' WHERE patientid = '$patient_id'";

    if (mysqli_query($con, $update_contract_type_query)) {
        // Prepare dataset column data
        $dataset = [
            "contract" => $contract
        ];

        if ($contract === 'AMC') {
            $dataset['amcStartDate'] = $amc_start_date;
            $dataset['amcEndDate'] = $amc_end_date;
            $dataset['amcServiceCharges'] = $amc_service_charges;
        } elseif ($contract === 'CMC') {
            $dataset['cmcStartDate'] = $cmc_start_date;
            $dataset['cmcEndDate'] = $cmc_end_date;
            $dataset['amcServiceCharges'] = $cmc_service_charges;
        }

        // Encode dataset as JSON
        $dataset_json = json_encode($dataset);

        // Step 2: Update contract details and dataset column
        $update_query = "UPDATE bf_feedback_asset_creation SET 
                            contract_start_date = '" . ($contract === 'AMC' ? $amc_start_date : $cmc_start_date) . "', 
                            contract_end_date = '" . ($contract === 'AMC' ? $amc_end_date : $cmc_end_date) . "', 
                            contract_service_charges = '" . ($contract === 'AMC' ? $amc_service_charges : $cmc_service_charges) . "', 
                            dataset = '$dataset_json'
                         WHERE patientid = '$patient_id'";

        if (mysqli_query($con, $update_query)) {
            echo json_encode([
                "status" => "success",
                "message" => "Contract type, details, and dataset updated successfully.",
                "data" => $dataset
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update contract details and dataset."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update contract type."]);
    }
}

mysqli_close($con);

// Trigger CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
curl_close($curl);
