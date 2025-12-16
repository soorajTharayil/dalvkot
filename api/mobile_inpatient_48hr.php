<?php
    error_reporting(0);
    include('db.php');
    $data = array();

    $mobile = $_GET['mobile'];
	$sql = 'SELECT * FROM `bf_feedback` WHERE JSON_EXTRACT(dataset, "$.contactnumber") = "' . $mobile . '" ORDER BY id DESC LIMIT 1';
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
	
        $last_feedback_time = $row['datetime'];
        $current_time = date('Y-m-d H:i:s');
        $time_diff = strtotime($current_time) - strtotime($last_feedback_time);

        if ($time_diff > 36 * 3600) { // 36 hours in seconds
            $data['pinfo'] = 'NO'; // Allow feedback
        } else {
            $data['pinfo'] = 'YES'; // Feedback already submitted within 36 hours
        }
    } else {
        $data['pinfo'] = 'NO'; // No previous record found, allow feedback
    }

    mysqli_close($con);
    echo json_encode($data);
?>
