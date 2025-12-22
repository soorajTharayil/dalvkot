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
$query = 'SELECT * FROM notification where type="email" AND status=0 LIMIT 1';
$result = $conn_g->query($query);
date_default_timezone_set('Etc/UTC');
require '/var/www/html/public_html/DEMO/demo8/PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 1;
$mail->Debugoutput = 'html';
$mail->Host = "mail.efeedor.com";
$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->Username = "app@efeedor.com";
$mail->Password = "admin#@12399";
$mail->setFrom('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
$mail->addReplyTo('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
$mail->AltBody = 'This is a plain-text message body';
while ($row = $result->fetch_object()) {
	$mail->Subject = $row->subject;
	$mail->ClearAddresses();
	$mail->addAddress($row->mobile_email, $row->mobile_email);
	$mail->msgHTML($row->message);
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
	$sql = "UPDATE notification SET status = 1 WHERE id=" . $row->id;
	$conn_g->query($sql);

}
$conn_g->close();
?>