<?php
error_reporting(E_ALL);
$i = 0;
include('db.php');



$sql = 'SELECT * FROM `setting` WHERE 1';
$result = mysqli_query($con, $sql);
$data['setting_data'] = mysqli_fetch_object($result);
$path = '../uploads/' . $data['setting_data']->qr_code_image;
$type = pathinfo($path, PATHINFO_EXTENSION);
$datap = file_get_contents($path);
$data['setting_data']->qr_code_image = 'data:image/' . $type . ';base64,' . base64_encode($datap);


$path = '../uploads/' . $data['setting_data']->logo;
$type = pathinfo($path, PATHINFO_EXTENSION);
$datap = file_get_contents($path);
$data['setting_data']->logo = 'data:image/' . $type . ';base64,' . base64_encode($datap);


$data['setting_data']->android_apk = 'http://' . $link . '/uploads/' . $data['setting_data']->android_apk;


$ch = curl_init($baseurl . 'SetupEfeeder/questionjson_esr?s=E-SERVICE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

$data['question_set'] = json_decode($output);
$x = count($data['question_set']);

$sql = 'SELECT * FROM `bf_ward_esr` WHERE 1 order by title	 asc';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);

$j = 0;

if ($num1 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['ward'][$j]['title'] = $row->title;
		$data['ward'][$j]['guid'] = $row->guid;
		$data['ward'][$j]['bedno'] = explode(',', $row->bed_no);
		$i++;
		$j++;
	}
}
$sql = 'SELECT * FROM `user` WHERE 1 ';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);
$j = 0;
if ($num1 > 0) {
	while ($row = mysqli_fetch_object($result)) {
		$data['user'][] = $row;
	}
}
$sql = 'SELECT * FROM `bf_roles` WHERE 1 order by title asc';
$result = mysqli_query($con, $sql);
$num2 = mysqli_num_rows($result);

$j = 0;
if ($num2 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['role'][$j]['title'] = $row->title;
		$data['role'][$j]['guid'] = $row->guid;

		$i++;
		$j++;
	}
}

$sql = 'SELECT * FROM `priority` WHERE 1 order by orderd asc';
$result = mysqli_query($con, $sql);
$num2 = mysqli_num_rows($result);

$j = 0;
if ($num2 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['priority'][$j]['title'] = $row->title;
		$data['priority'][$j]['guid'] = $row->guid;

		$i++;
		$j++;
	}
}

$sql = 'SELECT * FROM `healthcare_employees` WHERE mobile="' . $_GET['mobile'] . '"';
$result = mysqli_query($con, $sql);
$data['pinfo'] = mysqli_fetch_object($result);


// Check for matching asset in bf_feedback_asset_creation table
$assetname = isset($_GET['assetname']) ? $_GET['assetname'] : '';
$assetcode = isset($_GET['assetcode']) ? $_GET['assetcode'] : '';

if (!empty($assetname) && !empty($assetcode)) {
	$sql4 = 'SELECT * FROM `bf_feedback_asset_creation` WHERE assetname = ? AND patientid = ?';
	$stmt = $con->prepare($sql4);
	$stmt->bind_param("ss", $assetname, $assetcode);
	$stmt->execute();
	$result4 = $stmt->get_result();

	if ($result4->num_rows > 0) {
		$data['asset_details'] = $result4->fetch_assoc(); // Return matched asset data
	} else {
		$data['asset_details'] = null; // No match found
	}

	$stmt->close();
}

mysqli_close($con);
echo json_encode($data);
