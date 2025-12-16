<?php
include('db.php');

$patientid = isset($_GET['patientid']) ? $_GET['patientid'] : 0;

if ($patientid) {
    $query = "SELECT * FROM bf_feedback_asset_creation WHERE patientid = '$patientid'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $asset = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'assetDetails' => $asset]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No asset details found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid patient ID']);
}

mysqli_close($con);
?>