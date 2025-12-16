<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "efeedor.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "app@efeedor.com";
//Password to use for SMTP authentication 
$mail->Password = "admin#@12399";
//Set who the message is to be sent from
$mail->setFrom('app@efeedor.com', 'Patients Feedback');
//Set an alternative reply-to address
$mail->addReplyTo('app@efeedor.com', 'Patients Feedback');
//Set who the message is to be sent to

//Set the subject line
$mail->Subject = 'New Ticket- Patient feedback System';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('examples/contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('examples/images/phpmailer_mini.png');


	$mail->Subject = 'Thank you- ABC Hospitals';
	$messages = '';
	$messages .='Hi '.$p->name.',<br /><br />';
	$messages .='Thank you for submitting your feedback at ABC Hospitals. Your opinions and comments are very important to us. <br /><br />';
	
	echo $messages .='<br /><br />Regards,<br />ABC Hospitals';
	$mail->ClearAddresses();
	$mail->addAddress('dreamvishnu@gmail.com', 'dreamvishnu@gmail.com');
	$mail->msgHTML($messages);
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

		
		
	
	



//send the message, check for errors

