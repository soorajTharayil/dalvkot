<?php
date_default_timezone_set("Asia/Kolkata");
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
$time =  date("Y-m-d H:i:s");
//$time =  date_default_timezone_set("Asia/Calcutta");

$query = 'SELECT * FROM notification where type="email" AND status=0   ORDER BY id DESC LIMIT 1 ';
$result = $conn_g->query($query);

while ($row = $result->fetch_object()) {

	$send_email[] = $row;


	$sql = "UPDATE notification SET status = 1 WHERE id=" . $row->id;
	$conn_g->query($sql);
}




$query1 = 'SELECT * FROM notification_escilation where type="email" AND status=0  AND sheduled_at <= "' . $time . '" ORDER BY sheduled_at ASC';
$result1 = $conn_g->query($query1);

while ($row1 = $result1->fetch_object()) {
	$meta = json_decode($row1->meta);
	$urlstatus = $meta->config_set_url.'/api/ticket_status.php?ticket_id='.$meta->ticket->id.'&section=interim'; // Add the URL for status check

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $urlstatus);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    echo $response_status = curl_exec($curl_handle);
    curl_close($curl_handle);
    $message_status = 2;
    if($response_status === 'OPEN' || $response_status === 'ADDRESSED'){

	$send_email[] = $row1;
	$message_status = 1;

	}

	$sql1 = "UPDATE notification_escilation SET status = ".$message_status." WHERE id = " . $row1->id;
	$conn_g->query($sql1);
}


$conn_g->close();

echo json_encode($send_email);


exit;

