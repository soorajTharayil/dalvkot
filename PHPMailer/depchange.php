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
$mail->Host = "mail.efeedor.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "app@efeedor.com";
//Password to use for SMTP authentication 
$mail->Password = "admin#@12399";
//Set who the message is to be sent from
$mail->setFrom('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
//Set an alternative reply-to address
$mail->addReplyTo('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
//Set who the message is to be sent to

//Set the subject line
$mail->Subject = 'Ticket Department changed- feedback System';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('examples/contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('examples/images/phpmailer_mini.png');

include('../api/db.php');
$query = 'SELECT * FROM  ticket_message  WHERE action LIKE  "%Moved From%" AND emailstatus=0';
$flore = mysqli_query($con,$query);
while($r = mysqli_fetch_object($flore)){
	$query = 'SELECT * FROM  tickets  inner JOIN bf_feedback ON bf_feedback.id = tickets.feedbackid   WHERE  tickets.id = '.$r->ticketid;
	$f = mysqli_query($con,$query);
	$fc = mysqli_fetch_object($f);
	$num = $r->ticketid;
	$num_padded = $num;
	$ticid = 'TID-'.$num_padded;
	//$ticid = $r->message;
	$message = 'Hi, <br /><br />';
	$message .= 'Below ticket was changed to a different department.<br /><br />';
	$message .= 'TID:'.$ticid.' of PID:'.$fc->patientid.' '.$r->action.'<br /><br />';
	$messaged = '';
	$messages .='<br /><br />Kindly click the below link to view the same.<br />'.$link.'<br /><br />';	
	$message .='Regards,<br />'.$hospitalname;
	$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  tickets.id = '.$r->ticketid;
	$derp = mysqli_query($con, $query);
	
	$d = mysqli_fetch_object($derp);
	
	$mail->addAddress($d->email, $d->name);
	$mail->msgHTML($message);
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
	$quiery = 'Update ticket_message set emailstatus = 1 WHERE id='.$r->id;
	mysqli_query($con,$quiery);
	
	$quiery = 'Update bf_feedback set messagestatus = 0 WHERE id='.$r->ticketid;
	mysqli_query($con,$quiery);
	
}
	



//send the message, check for errors

