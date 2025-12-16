<?php

include('db.php');



$patinet_id = $_GET['patient_id'];

$d = file_get_contents('php://input');



$data = json_decode($d, true);



if (count($data) > 1) {

	date_default_timezone_set('Asia/Kolkata');

	$data['name'] = strtoupper($data['name']);

	$bed = $data['bedno'];



	$ward = $data['ward'];

	$sql = 'SELECT * FROM `bf_departmentop` WHERE title="' . $ward . '"';

	$ward = mysqli_query($con, $sql);

	$wardd = mysqli_fetch_object($ward);

	$today = date('Y-m-d');

	$query = 'SELECT * FROM  `bf_opatients` WHERE patient_id="' . $data['patientid'] . '"';

	$res = mysqli_query($con, $query);

	if ($res->num_rows == 0) {



		$query = 'INSERT INTO `bf_opatients` (`guid`, `name`, `patient_id`, `mobile`, `email`,`admited_date`,`ward`,`bed_no`) VALUES ("' . time() . '","' . $data['name'] . '","' . $data['patientid'] . '","' . $data['contactnumber'] . '","' . $data['email'] . '","' . date('Y-m-d H:i:s') . '","' . $wardd->title . '","' . $bed . '")';

		$result = mysqli_query($con, $query);

		$rid = mysqli_insert_id($con);
	} else {

		$patient_detail = mysqli_fetch_object($res);

		if ($patient_detail->datedischarged == 0) {

			// $query = 'UPDATE `bf_patients` SET datedischarged= "' . date('Y-m-d H:i:s') . '"   WHERE  patient_id="' . $data['patientid'] . '"';

			// mysqli_query($con, $query);

		}

		$rid = $patient_detail->id;
	}

	$patinet_id = $data['patientid'];

	$query = 'SELECT * FROM  `bf_outfeedback` WHERE  patientid="' . $patinet_id . '"';

	$res = mysqli_query($con, $query);

	if (mysqli_fetch_object($res)) {

		/*$response['status'] = 'fail';

			$response['message'] = 'Data was already submitted for this patient';

			echo json_encode($response);

			exit;*/
	}

	$query = 'SELECT * FROM  `setupop` WHERE 1';



	$overall = mysqli_query($con, $query);

	$prcount = 0;

	$overalltotal = 0;

	while ($pr = mysqli_fetch_object($overall)) {



		if ($data[$pr->shortkey] >= 1) {

			$overalltotal += $data[$pr->shortkey];

			$prcount++;
		} else {

			$data[$pr->shortkey] = '';
		}
	}



	if ($prcount == 0) {

		$data['overallScore'] = '';
	} else {

		$data['overallScore'] = round($overalltotal / $prcount);
	}


	if (isset($data['source']) && $data['source'] == 'WLink') {
		$source = 'Link';
	} elseif (isset($data['source']) && $data['source'] != 'WLink') {
		$source = $data['source'];
	} else {
		$source = 'APP';
	}

	$query = 'INSERT INTO `bf_outfeedback`(`datetime`,`datet`,`remarks`, `nurseid`, `patientid`, `dataset`, `source`,`ward`,`bed_no`,`pid`,`consultant_cat`,`consultant_doc`) VALUES ("' . date('Y-m-d H:i:s') . '","' . $today . '","' . $data['remarks'] . '","' . $_GET['administratorId'] . '","' . $patinet_id . '","' . mysqli_real_escape_string($con, json_encode($data)) . '","' . $source . '","' . $wardd->title . '","' . $bed . '","' . $rid . '","' . $data['consultant_cat'] . '","' . $data['consultant_doc'] . '")';



	$result = mysqli_query($con, $query);

	$fid = mysqli_insert_id($con);



	$query = 'SELECT * FROM department WHERE type="outpatient"';

	$result = mysqli_query($con, $query);

	while ($r = mysqli_fetch_object($result)) {

		//	print_r($r);

		foreach ($data as $key => $value) {

			if ($r->slug == $key) {

				if ($value == 2 || $value == 1) {

					$query = 'INSERT INTO `ticketsop`(`created_by`, `departmentid`, `rating`, `anymessage`, `feedbackid`,`ward`) VALUES ("' . $patinet_id . '","' . $r->dprt_id . '","' . $value . '","' . $data['comments'] . '","' . $fid . '","' . $wardd->title . '")';
					mysqli_query($con, $query);
				}
			}
		}
	}

	$response['status'] = 'success';

	$response['message'] = 'Data saved sucessfully';



	echo json_encode($response);





	mysqli_close($con);
}



// $curl = curl_init();

// curl_setopt($curl, CURLOPT_URL, $baseurl . 'messages/alertfeedbackop.php');

// $result = curl_exec($curl);





// $curl = curl_init();

// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// curl_setopt($curl, CURLOPT_URL, $baseurl . 'PHPMailer/mailop.php');

// $result = curl_exec($curl);

//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
