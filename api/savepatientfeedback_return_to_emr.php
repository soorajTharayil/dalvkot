<?php
include('db.php');

$patinet_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
	date_default_timezone_set('Asia/Kolkata');
	$data['name'] = strtoupper($data['name']);
	$today = date('Y-m-d');


	
	$name =	$data['name'];
	$patientid =	$data['patientid'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
	$initial_consultaion =	$data['initial_assessment_hr1'];

	$same_op_tf = $data['gloves'];
	$same_op_tf_comment = $data['gloves_comment'];

	$same_op_fe = $data['mask'];
	$same_op_fe_comment = $data['mask_comment'];

	$same_op_st = $data['same_op'];
	$same_op_st_comment = $data['same_op_comment'];

	$re_consultation = $data['condition'];


	$comments = $data['dataAnalysis'];
	
	



   $query = 'INSERT INTO `bf_feedback_return_to_emr` (`name`,`patientid`,`mobile`,`email`,`datetime`,`datet`,`initial_consultaion`,`same_op_tf`,`same_op_tf_comment`,`same_op_fe`,`same_op_fe_comment`, `same_op_st`,`same_op_st_comment`,`re_consultation`, `comments`, `dataset`) 
   VALUES ("' . $name . '","' . $patientid . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $initial_consultaion . '","' . $same_op_tf . '","'. $same_op_tf_comment . '","'. $same_op_fe . '","' . $same_op_fe_comment . '","' . $same_op_st . '","'. $same_op_st_comment . '","' . $re_consultation . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

  $result = mysqli_query($con, $query);
  $fid = mysqli_insert_id($con);

	$response['status'] = 'success';
	$response['message'] = 'Data saved sucessfully';

	echo json_encode($response);


	mysqli_close($con);
}


//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
