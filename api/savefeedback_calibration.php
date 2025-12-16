<?php
include('db.php');

$d = file_get_contents('php://input');
$data = json_decode($d, true);

// Extract the patient ID and maintenance dates
$patient_id = $data['patientid'];
$assetWithCalibration = $data['assetWithCalibration'];

$asset_calibration_date = $data['lastCalibrationDate'];
$upcoming_calibration_date = $data['upcomingCalibrationDate'];
$setReminderOne = $data['setReminderOne'];
$setReminderTwo = $data['setReminderTwo'];


if (!empty($patient_id)) {
    // Patient ID exists, update maintenance dates
    $update_query = " UPDATE bf_feedback_asset_creation SET assetWithCalibration = '$assetWithCalibration', asset_calibration_date = '$asset_calibration_date', upcoming_calibration_date = '$upcoming_calibration_date' , calibration_reminder_alert_1 = '$setReminderOne' , calibration_reminder_alert_2 = '$setReminderTwo' WHERE patientid = '$patient_id'";

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