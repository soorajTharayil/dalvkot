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

$ch = curl_init($baseurl . 'SetupEfeeder/questionjson_service?s=SERVICE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

$data['question_set'] = json_decode($output);
$x = count($data['question_set']);


$sql = 'SELECT * FROM `bf_ward` WHERE 1 order by title	 asc';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);

$j = 0;
if ($num1 > 0) {
	while ($row = mysqli_fetch_object($result)) {

		$data['ward'][$j]['title'] = $row->title;
		$data['ward'][$j]['guid'] = $row->guid;

		$i++;
		$j++;
	}
}
mysqli_close($con);
echo json_encode($data);
