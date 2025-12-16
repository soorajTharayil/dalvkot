<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$all_pending_email = file_get_contents('http://10.10.10.103/pendingemail.php');
$all_email_array = json_decode($all_pending_email, false);


if (count($all_email_array) > 0) {
	foreach ($all_email_array as $row) {
		$EMAIL_CONTENT = $row;
		date_default_timezone_set('Etc/UTC');

		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 2;
		$mail->Debugoutput = 'html';
		$mail->Host = "smtp.zeptomail.in";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "durga@dalvkot.com";
		$mail->Password = "HYrpFVYYcnT4";
		$mail->setFrom('durga@dalvkot.com', 'DALVKOT HXMS');
		$mail->addReplyTo('durga@dalvkot.com', 'DALVKOT HXMS');
		$mail->AltBody = $EMAIL_CONTENT->message;
		$mail->Subject = $EMAIL_CONTENT->subject;
		$messages = $EMAIL_CONTENT->message;
		$mail->ClearAddresses();
		$mail->addAddress($EMAIL_CONTENT->mobile_email, $EMAIL_CONTENT->mobile_email);
		$mail->msgHTML($messages);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
}*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 🔹 Instead of fetching from API, use hardcoded test data
$all_pending_email = json_encode([
    [
        "mobile_email" => "dreamvishnu@gmail.com",
        "subject"      => "Test Email",
        "message"      => "This is a test message sent using PHPMailer."
    ]
]);

$all_email_array = json_decode($all_pending_email, false);

if (count($all_email_array) > 0) {
    foreach ($all_email_array as $row) {
        $EMAIL_CONTENT = $row;
        date_default_timezone_set('Etc/UTC');

        require 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.zeptomail.com";
		$mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "durga@dalvkot.com";
        $mail->Password = "wSsVR61y8xT2DK94mD2vdO85n15cUlv1HUl4jVP16nGoHPHE9MdtkELKUwOmG6QcGTE6F2RH9uh/nBxWhDEPiNkuwl0BCCiF9mqRe1U4J3x17qnvhDzPVm9akhGMLIgKxwpjn2JpE80l+g==";
        $mail->setFrom('durga@dalvkot.com', 'DALVKOT HXMS');
        $mail->addReplyTo('durga@dalvkot.com', 'DALVKOT HXMS');
        $mail->AltBody = $EMAIL_CONTENT->message;
        $mail->Subject = $EMAIL_CONTENT->subject;
        $messages = $EMAIL_CONTENT->message;

        $mail->ClearAddresses();
        $mail->addAddress($EMAIL_CONTENT->mobile_email, $EMAIL_CONTENT->mobile_email);
        $mail->msgHTML($messages);

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}
?>

