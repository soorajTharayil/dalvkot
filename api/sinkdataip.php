<?php
include('db.php');
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

$d = file_get_contents('php://input');  
//file_put_contents("test.txt",$d);
$data = json_decode($d,true);
foreach($data as $r){
	$bed = $r['bedno'];

	$ward = $r['ward'];
	$sql = 'SELECT * FROM `bf_ward` WHERE title="' . $ward . '"';
	$ward = mysqli_query($con, $sql);
	$wardd = mysqli_fetch_object($ward);
	$query = 'SELECT * FROM  `bf_patients` WHERE  patient_id="'.$r['patientid'].'"';
	
	$res = mysqli_query($con,$query);
	//print_r($res);
	//exit;
//	if($res->num_rows == 0){	
//		print_r($res); 
		$ward = $r['ward'];
		
		$query = 'INSERT INTO `bf_patients` (`guid`, `name`, `patient_id`, `mobile`, `email`,`admited_date`,`welcome_message`,`ward`,`bed_no`) VALUES ("' . time() . '","' . $r['name'] . '","' . $r['patientid'] . '","' . $r['contactnumber'] . '","' . $r['email'] . '","' . date('Y-m-d H:i:s') . '","1","' . $wardd->title . '","' . $bed . '")';
		$result = mysqli_query($con, $query);
		$rid = mysqli_insert_id($con);

///	}
	$today = date('Y-m-d');
	$patinet_id = $r['patientid'];
	//$administratorId = $r['administratorId'];
	
	$query = 'SELECT * FROM  `setup` WHERE 1';

	$overall = mysqli_query($con,$query);
	$prcount = 0;
	$overalltotal= 0;
	while($pr = mysqli_fetch_object($overall)){
		
		if($r[$pr->shortkey] >= 1){
			$overalltotal += $r[$pr->shortkey];
			$prcount++;
		}else{
			$r[$pr->shortkey] = '';
		}
	}
	
	if($prcount == 0){
		$r['overallScore'] = '';
	}else{
		$r['overallScore'] = round($overalltotal/$prcount);
	}
	if (isset($data['source']) && $data['source'] == 'WLink') {
		$source = 'Link';
	} elseif (isset($data['source']) && $data['source'] != 'WLink') {
		$source = $data['source'];
	} else {
		$source = 'APP';
	}
	
	$query = 'INSERT INTO `bf_feedback`(`datetime`,`datet`,`remarks`, `nurseid`, `patientid`, `dataset`, `source`,`ward`,`bed_no`,`pid`) VALUES ("' . date('Y-m-d H:i:s') . '","' . $today . '","' . $r['remarks'] . '","' . $_GET['administratorId'] . '","' . $patinet_id . '","' . mysqli_real_escape_string($con, json_encode($r)) . '","' . $source . '","' . $wardd->title . '","' . $bed . '","' . $rid . '")';
	
	$result = mysqli_query($con,$query);
	//var_dump($result);
	$fid = mysqli_insert_id($con);

	 

	$query = 'SELECT * FROM department where type = "inpatient"';

	$result = mysqli_query($con,$query);

	while($rp = mysqli_fetch_object($result)){
		
		foreach($r as $key => $value){

			if($rp->slug == $key){

				if($value == 2 || $value == 1){

					 $query = 'INSERT INTO `tickets`(`created_by`, `departmentid`, `rating`, `anymessage`, `feedbackid`) VALUES ("'.$patinet_id.'","'.$rp->dprt_id.'","'.$value.'","'.$r['comments'].'","'.$fid.'")';

					mysqli_query($con,$query);

				}

			}

		}

	}
}

//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);