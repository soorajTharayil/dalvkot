<?php
include("../env.php");
ini_set('display_errors', 'Off');
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$active_group = 'default';
$active_record = TRUE;


$link = $config_set['DOMAIN'];

$db['hostname'] = $config_set['DBHOST'];
$db['username'] = $config_set['DBUSER'];
$db['password'] = $config_set['DBPASSWORD'];
$db['database'] = $config_set['DBNAME'];
$baseurl = $config_set['BASE_URL'];

/* End of file database.php */
/* Location: ./application/config/database.php */
$con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database'])
	or die('Could not connect to the database server' . mysqli_connect_error());

mysqli_query($con, 'SET character_set_results=utf8');
mysqli_query($con, 'SET names=utf8');
mysqli_query($con, 'SET character_set_client=utf8');
mysqli_query($con, 'SET character_set_connection=utf8');
mysqli_query($con, 'SET character_set_results=utf8');
mysqli_query($con, 'SET collation_connection=utf8_general_ci');

$sql = 'SELECT * FROM `setting` WHERE 1';
$result = mysqli_query($con, $sql);
$reviewlink = mysqli_fetch_object($result);
$slink = $reviewlink->google_review_link;
$hospitalname = $reviewlink->title;
$HID = $reviewlink->description;
$COMPANYNAME = '-%20ITATONE';
?>
