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
	$staffname =	$data['staffname'];
	$department =	$data['department'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];
    $gloves = $data['gloves'];   
    $mask = $data['mask'];   
    $cap = $data['cap'];   
    $apron = $data['apron'];   
	$leadApron = $data['leadApron'];  
	$xrayBarrior = $data['xrayBarrior'];  
	$tld = $data['tld'];  
    
	$comment = '';
    if (!empty($data['comment_l'])) {
        $comment = $data['comment_l'];
    } elseif (!empty($data['comment_r'])) {
        $comment = $data['comment_r'];
    } elseif (!empty($data['comment_u'])) {
        $comment = $data['comment_u'];
    }

	$general_comment = $data['dataAnalysis'];
     

	

   $query = 'INSERT INTO `bf_feedback_ppe_audit` (`name`,`staffname`,`department`,`mobile`,`email`,`datetime`,`datet`,`gloves`,`mask`,`cap`,`apron`,`leadApron`,`xrayBarrior`,`tld`,`comment`,`general_comment`,`dataset`) 
   VALUES ("' . $name . '","' . $staffname . '","' . $department . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $gloves. '","' . $mask. '","' . $cap. '","' . $apron. '","' . $leadApron. '","' . $xrayBarrior. '","' . $tld. '","' . $comment. '","' . $general_comment. '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

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
