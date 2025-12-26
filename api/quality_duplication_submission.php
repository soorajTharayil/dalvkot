<?php
// Force JSON output
// Force JSON output
header('Content-Type: application/json');

// Disable PHP default error output (prevents HTML)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

/**
 * Convert PHP errors to JSON responses
 */
set_error_handler(function ($severity, $message, $file, $line) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'type'   => 'php_error',
        'message'=> $message,
        'file'   => basename($file),
        'line'   => $line
    ]);
    exit;
});

/**
 * Handle uncaught exceptions
 */
set_exception_handler(function ($exception) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'type'    => 'exception',
        'message' => $exception->getMessage(),
        'file'    => basename($exception->getFile()),
        'line'    => $exception->getLine()
    ]);
    exit;
});

/**
 * Catch fatal errors (parse error, fatal error, etc.)
 */
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo json_encode([
            'status'  => 'error',
            'type'    => 'fatal_error',
            'message' => $error['message'],
            'file'    => basename($error['file']),
            'line'    => $error['line']
        ]);
        exit;
    }
});

include('db.php');

$patient_id = $_GET['patient_id'];

$month = $_GET['month'];  // e.g., "January"
$year = $_GET['year'];    // e.g., "2024"
$table = $_GET['table'];

$monthMap = [
    'January' => 1, 'February' => 2, 'March' => 3,
    'April' => 4, 'May' => 5, 'June' => 6,
    'July' => 7, 'August' => 8, 'September' => 9,
    'October' => 10, 'November' => 11, 'December' => 12
];

if (!isset($monthMap[$month])) {
    echo json_encode([
        'status' => 'error',
        'stage'  => 'month_validation',
        'message'=> 'Invalid month value',
        'month'  => $month
    ]);
    exit;
}

$monthNumber = $monthMap[$month];


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

$query = " SELECT * FROM `$table` WHERE MONTH(`datetime`) = '$monthNumber' AND YEAR(`datetime`) = '$year' AND (`status` IS NULL OR `status` != 'Deleted')";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
	echo json_encode(["status" => "exists"]);
} else {
	echo json_encode(["status" => "not_exists"]);
}
?>
