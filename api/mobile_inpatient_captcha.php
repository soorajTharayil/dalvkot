<?php
error_reporting(0);
$i = 0;
include('db.php');
$data = array();

// reCAPTCHA secret key
$secretKey = '6Lc8CkcqAAAAAFeNQ8kPCL1O7DLZOWj8esP1x6Am';

// Get the reCAPTCHA token from the frontend
$recaptchaToken = isset($_GET['recaptcha_token']) ? $_GET['recaptcha_token'] : '';

// Verify the reCAPTCHA token with Google's API
$recaptchaUrl = 'http://www.google.com/recaptcha/api/siteverify';
$recaptchaResponse = file_get_contents($recaptchaUrl . '?secret=' . $secretKey . '&response=' . $recaptchaToken);
$recaptchaData = json_decode($recaptchaResponse);

$data['recaptcha_score'] = $recaptchaData->score ?? 0;

// Check if the token is valid and the score is sufficient (e.g., above 0.8)
if ($recaptchaData->success) {
	if ($recaptchaData->score >= 0.8) {
		$sql = 'SELECT * FROM patients_from_admission WHERE (mobile="' . mysqli_real_escape_string($con, $_GET['mobile']) . '")';
		$result = mysqli_query($con, $sql);

		if ($result && $result->num_rows > 0) {
			$data['pinfo'] = mysqli_fetch_object($result);
		} else {
			$data['pinfo'] = 'NO';
		}
	} else {
		$data['error'] = 'reCAPTCHA score is too low';
	}
} else {
	// reCAPTCHA validation failed
	$data['error'] = 'reCAPTCHA verification failed';
}

//print_r($data); 
mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($data);

?>