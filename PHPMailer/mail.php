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

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('examples/contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('examples/images/phpmailer_mini.png');

include('../api/db.php');
$mail->Subject = 'HID: '.$HID.' NEW INPATIENT FEEDBACK TICKET- EFEEDOR';
$query = 'SELECT * FROM  bf_feedback  WHERE emailstatus = 0';
$flore = mysqli_query($con,$query);
while($r = mysqli_fetch_object($flore)){
	
	$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = '.$r->id.' GROUP BY  department.description';
	$ticket = mysqli_query($con,$query);
	$rowcount=mysqli_num_rows($ticket);
	$department = '';
	while($t = mysqli_fetch_object($ticket)){
		$message = 'HID: '.$HID.'<br />';
		$message .='Hi,<br /><br />';
	    $message .='A new ticket was generated: <br /><br />';
		$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = '.$r->id.' AND department.description="'.$t->description.'"';
		$department .= $t->description.', ';
		$tic = mysqli_query($con,$query);
		$ticcount=mysqli_num_rows($tic);
		if($ticcount > 1){
			$k=1;
		}else{
			$k = '';
		}
		$query = 'SELECT * FROM  bf_patients  WHERE patient_id = "'.$r->patientid.'"';
		$patient = mysqli_query($con,$query);
		$p = mysqli_fetch_object($patient);
		$query = 'SELECT * FROM  bf_ward  WHERE title = "'.$p->ward.'"';
		$patient = mysqli_query($con,$query);
		$f = mysqli_fetch_object($patient);
		$message .= 'Feedback ticket from <br />Patient: '.$p->name.', <br />PID: '.$p->patient_id.', <br />Floor: '.$f->smallname.' <br />Department: '.$t->description;
		$section = '';
		while($tp = mysqli_fetch_object($tic)){
			if($tp->rating == 2){
				$ratingp = 'Average'; 
			}else{
				$ratingp = 'Poor';
			}
			$section .= ' ,<br />Parameter'.$k.': '.$tp->name.', <br />Rating: '.$ratingp;
			$k++;
		}
		$message .=$section;
		
		$message .='<br /><br />Kindly click the below link to view the same.<br />http://'.$link.' <br /><br />';
		$message .='<br /><br />Regards,<br />'.$hospitalname.' ';
		//exit;
		$mail->ClearAddresses();
		$mail->addAddress($t->email, $t->pname);
		$mail->msgHTML($message);
		if (!$mail->send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			//echo "Message sent!";
		}
		
		
	}
	
	if($rowcount > 1){
			$messages = 'HID: '.$HID.'<br />';
			$messages .='Hi,<br /><br />';
			$messages .='A new ticket was generated: <br /><br />';
			$messages .= 'Feedback ticket from <br />Patient:  '.$p->name.',<br /> PID: '.$p->patient_id.',<br /> Floor: '.$f->smallname; 
			$messages .= ' <br />Department:'.$department;
			$messages .='<br /><br />Kindly click the below link to view the same.<br />http://'.$link.' <br /><br />';			
			$messages .='<br /><br />Regards,<br />'.$hospitalname.' ';
	}else{
			$messages = $message;
	}
	if($rowcount > 0){
		$query = 'SELECT * FROM  user  WHERE 1';
		$patient = mysqli_query($con, $query);
		while($u = mysqli_fetch_object($patient)){
			$permission = json_decode($u->departmentpermission);
			if($permission->email_ticket_ip == 1){
				$mail->ClearAddresses();
				$mail->addAddress($u->email, $u->name);
				$mail->msgHTML($messages);
				if (!$mail->send()) {
					//echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}
			}
		}
	}
	/*if($p->email != NULL && $p->email != ''){
		$mail->Subject = 'Thank you- '.$hospitalname.' ';
		$messages = '';
		$messages .='Hi '.$p->name.',<br /><br />';
		$messages .='Thank you for submitting your feedback at '.$hospitalname.' . Your opinions and comments are very important to us. <br /><br />';
		
		echo $messages .='<br /><br />Regards,<br />'.$hospitalname.' ';
		$mail->ClearAddresses();
		$mail->addAddress($p->email, $p->name);
		$mail->msgHTML($messages);
		if (!$mail->send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			//echo "Message sent!";
		}
	}*/
		
		
		$quiery = 'Update bf_feedback set emailstatus = 1 WHERE id='.$r->id;
		mysqli_query($con,$quiery);
	
}


//send the message, check for errors

