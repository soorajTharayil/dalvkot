<?php 
exit;
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
$queryUpdateStatus404 = 'UPDATE notification SET status = 404 where (mobile_email IS NULL OR mobile_email = "") AND status = 0';
$conn_g->query($queryUpdateStatus404);

$query = "SELECT * FROM notification WHERE (type = 'user' OR type = 'patient_message' OR type = 'department_message' OR type = 'admins_message' OR type = 'employee_message') AND status = 0 ORDER BY id DESC LIMIT 5";
$result = $conn_g->query($query);
 while($row = $result->fetch_object()) {
		$TEMPID = $row->template_id;
		$number = $row->mobile_email;
		$message = $row->message;
		$url = 'http://sms.digimiles.in/bulksms/bulksms?username=di78-ehrapp&password=Ehandor8&type=0&dlr=1&tmid=1201159118005685119,1602100000000009244&entityid=1201159118005685119&tempid='.$TEMPID.'&destination='.$number.'&source=EFEDOR&message='.$message;
		
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,$url);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		if (empty($buffer)){
			  print "Nothing returned from url.<p>";
		}else{
			  echo 'Done';
			  print $buffer;
		}
		$sql = "UPDATE notification SET status = 1 WHERE id=".$row->id;
		$conn_g->query($sql);
			
}
$conn_g->close();
