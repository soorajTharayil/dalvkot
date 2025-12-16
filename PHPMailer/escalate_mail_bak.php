<?php
date_default_timezone_set("Asia/Calcutta");
$servername = "localhost";
$username = "efeedor_core";
$password = "Vishnu99%";
$dbname = "efeedor_EM_notification";

// Create connection
$conn_g = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn_g->connect_error) {
  die("Connection failed: " . $conn_g->connect_error);
}
require 'PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = "efeedor.com";
$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->Username = "app@efeedor.com";
$mail->Password = "admin#@12399";

$mail->setFrom('app@efeedor.com', 'Patients Feedback');
$mail->addReplyTo('app@efeedor.com', 'Patients Feedback');

$mail->AltBody = 'This is a plain-text message body';

$servername = "localhost";
$username = "efeedor_core";
$password = "Vishnu99%";
$dbname = "efeedor_EM_notification";
$time =  date("Y-m-d H:i:s");
$query = 'SELECT * FROM notification_escilation where type="email" AND status=0 AND sheduled_at <= "'.$time.'"  ORDER BY id DESC LIMIT 1 ';
$result = $conn_g->query($query);
 while($row = $result->fetch_object()) {

		$TEMPID = $row->template_id;
		$mail->Subject = $TEMPID.' '.date('d M, Y');
		$email = $row->mobile_email;
		$message = $row->message;
		
		$mail->ClearAddresses();

		

		$mail->msgHTML($message);
		$mail->ClearAddresses();

		$mail->addAddress($email, 'Info');
		if (!$mail->send()) {

			echo "Mailer Error: " . $mail->ErrorInfo;

		} else {

			echo "Message sent!";

		}
		$sql = "UPDATE notification_escilation SET status = 1 WHERE id=".$row->id;
		$conn_g->query($sql);
			
}
$conn_g->close();




exit;

	

//send the message, check for errors



