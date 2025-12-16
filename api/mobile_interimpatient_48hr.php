<?php
error_reporting(0);
include('db.php');
$data = array();

$mobile = $_GET['mobile'];
$time_limit = 24 * 3600; // 24 hours in seconds
$current_time = date('Y-m-d H:i:s');
$time_check = date('Y-m-d H:i:s', strtotime($current_time) - $time_limit);

// Query to count the number of feedbacks within the last 24 hours
$sql = 'SELECT COUNT(*) as feedback_count FROM `bf_feedback_int` 
        WHERE JSON_EXTRACT(dataset, "$.contactnumber") = "' . $mobile . '" 
        AND datetime >= "' . $time_check . '"';
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $feedback_count = $row['feedback_count'];

    if ($feedback_count < 5) {
        $data['pinfo'] = 'NO'; // Allow feedback
    } else {
        $data['pinfo'] = 'YES'; // Feedback limit reached within 24 hours
    }
} else {
    $data['pinfo'] = 'NO'; // No previous record found, allow feedback
}

mysqli_close($con);
echo json_encode($data);
?>
