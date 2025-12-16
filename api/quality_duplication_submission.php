<?php
include('db.php');

$patient_id = $_GET['patient_id'];

$month = $_GET['month'];  // e.g., "January"
$year = $_GET['year'];    // e.g., "2024"
$table = $_GET['table'];

$monthNumber = (int)date('m', strtotime($month)); // Convert month into integer


$allowedTables = [
	'bf_feedback_1PSQ3a',
	'bf_feedback_2PSQ3a',
	'bf_feedback_3PSQ3a',
	'bf_feedback_4PSQ3a',
	'bf_feedback_5PSQ3a',
	'bf_feedback_6PSQ3a',
	'bf_feedback_7PSQ3a',
	'bf_feedback_8PSQ3a',
	'bf_feedback_9PSQ3a',
	'bf_feedback_10PSQ3a',
	'bf_feedback_11PSQ3a',
	'bf_feedback_12PSQ3a',
	'bf_feedback_13PSQ3b',
	'bf_feedback_14PSQ3b',
	'bf_feedback_15PSQ3b',
	'bf_feedback_16PSQ3b',
	'bf_feedback_17PSQ3b',
	'bf_feedback_18PSQ3b',
	'bf_feedback_19PSQ3c',
	'bf_feedback_20PSQ3c',
	'bf_feedback_21PSQ3c',
	'bf_feedback_21aPSQ3c',
	'bf_feedback_22PSQ3c',
	'bf_feedback_23aPSQ4c',
	'bf_feedback_23bPSQ4c',
	'bf_feedback_23cPSQ4c',
	'bf_feedback_23dPSQ4c',
	'bf_feedback_24PSQ4c',
	'bf_feedback_25PSQ4c',
	'bf_feedback_26PSQ4c',
	'bf_feedback_27PSQ4d',
	'bf_feedback_28PSQ4d',
	'bf_feedback_29PSQ4d',
	'bf_feedback_30PSQ3d',
	'bf_feedback_31PSQ3d',
	'bf_feedback_32PSQ3d',
	'bf_feedback_PSQ3a',
	'bf_feedback_33PSQ3a',
	'bf_feedback_34PSQ3a',
	'bf_feedback_35PSQ3a',
	'bf_feedback_36PSQ3a',
	'bf_feedback_37PSQ3a',
	'bf_feedback_38PSQ3a',
	'bf_feedback_39PSQ3a',
	'bf_feedback_40PSQ3a',
	'bf_feedback_41PSQ3a',
	'bf_feedback_42PSQ3a',
	'bf_feedback_43PSQ3a',
	'bf_feedback_44PSQ3a',
	'bf_feedback_45PSQ3a',
	'bf_feedback_46PSQ3a',
	'bf_feedback_47PSQ3a',
	'bf_feedback_48PSQ3a',
	'bf_feedback_49PSQ3a',
	'bf_feedback_50PSQ3a'

];

if (!in_array($table, $allowedTables)) {
	echo json_encode(["status" => "invalid_table"]);
	exit();
}

$query = "SELECT * FROM `$table` WHERE MONTH(`datet`) = '$monthNumber' AND YEAR(`datet`) = '$year'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
	echo json_encode(["status" => "exists"]);
} else {
	echo json_encode(["status" => "not_exists"]);
}
?>
