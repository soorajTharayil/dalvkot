<?php

$i = 0;
include('db.php');
$sql = 'SELECT * FROM `bf_ward` WHERE 1 order by title	 asc';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);
$j = 0;
if ($num1 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['ward'][$j]['title'] = $row->title;
		$data['ward'][$j]['titlek'] = $row->titlek;
		$data['ward'][$j]['titlem'] = $row->titlem;
		$data['ward'][$j]['guid'] = $row->guid;
		$data['ward'][$j]['bedno'] = explode(',', $row->bed_no);
		$data['ward'][$j]['bednok'] = explode(',', $row->bed_nok);
		$data['ward'][$j]['bednom'] = explode(',', $row->bed_nom);

		$i++;
		$j++;
	}
}

$sql = 'SELECT * FROM `bf_departmentop` WHERE 1 order by title	 asc';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);
$j = 0;
if ($num1 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['consultant'][$j]['title'] = $row->title;
		$data['consultant'][$j]['guid'] = $row->guid;
		$data['consultant'][$j]['bedno'] = explode(',', $row->bed_no);

		$i++;
		$j++;
	}
}



$sql = 'SELECT * FROM `setting` WHERE 1';
$result = mysqli_query($con, $sql);
$data['setting_data'] = mysqli_fetch_object($result);
$path = '../uploads/' . $data['setting_data']->qr_code_image;
$type = pathinfo($path, PATHINFO_EXTENSION);
$datap = file_get_contents($path);
$data['setting_data']->qr_code_image = 'data:image/' . $type . ';base64,' . base64_encode($datap);
$baseurl = $config_set['BASE_URL'];

$path = '../uploads/' . $data['setting_data']->logo;
$type = pathinfo($path, PATHINFO_EXTENSION);
$datap = file_get_contents($path);
$data['setting_data']->logo = 'data:image/' . $type . ';base64,' . base64_encode($datap);


$data['setting_data']->android_apk = 'http://' . $link . '/uploads/' . $data['setting_data']->android_apk;
$ch = curl_init('http://' . $link . '/SetupEfeeder/questionjson_pdf');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);
$data['question_set'] = json_decode($output);

//ip
$sql = 'SELECT * FROM `patient_discharge` WHERE guid="' . $_GET['patientid'] . '" AND check_status="active"';
$result = mysqli_query($con, $sql);
$data['pinfo'] = mysqli_fetch_object($result);
$data['baseurl'] = $baseurl;





echo json_encode($data);
mysqli_close($con);
?>