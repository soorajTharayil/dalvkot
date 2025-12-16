<?php
error_reporting(0);
$i = 0;
include('db.php');
$data = array();
$sql = 'SELECT * FROM `healthcare_employees` WHERE (mobile="' . $_GET['mobile'] . '" OR email="' . $_GET['email'] . '")';
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_object($result);
if ($result->num_rows > 0) {
    $data['pinfo'] = $row;

    // Update query to set messagestatus = 0, emailstatus = 0, and pin to NULL
    $update_query = 'UPDATE healthcare_employees SET messagestatus = 0, emailstatus = 0, pin = NULL WHERE id = ' . $row->id;
    mysqli_query($con, $update_query);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
    curl_exec($curl);
} else {
    $data['pinfo'] = 'NO';
}

//print_r($data); 
mysqli_close($con);
echo json_encode($data);
