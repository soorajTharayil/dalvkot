<?php 
date_default_timezone_set("Asia/Calcutta");
$servername = "localhost";
$username = "myapp_user";
$password = "strong_password";
$dbname = "myapp_db";

// Create connection
$conn_g = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn_g->connect_error) {
  die("Connection failed: " . $conn_g->connect_error);
}
$pat =  $_GET['p'];
 $query = 'SELECT * FROM notification_patient where uuid="'.$pat.'"';
$result = $conn_g->query($query);
$patient = $result->fetch_object();
$meta_data = json_decode($patient->meta);
 
if(isset($meta_data->link)){
  $url = $meta_data->link;
  header("Location: ".$url);
}else{
    $url = $meta_data->config_set_url.'opfb?patient_id='.$meta_data->patient_detail->guid;
    header("Location: ".$url);
}
?>
