<?php

date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = "mail.efeedor.com";
$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->Username = "app@efeedor.com";
$mail->Password = "admin#@12399";
$mail->setFrom('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
$mail->addReplyTo('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');
$mail->AltBody = 'This is a plain-text message body';
include('../api/db.php');
$mail->Subject = 'HID: '.$HID.' NEW ADMITTED PATIENT FEEDBACK TICKET- EFEEDOR';
$query = 'SELECT * FROM  bf_feedback_int  WHERE emailstatus = 0';
$flore = mysqli_query($con,$query);

while($r = mysqli_fetch_object($flore)){
	
	$query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = '.$r->id.'  AND type="interim" GROUP BY  department.description ';
	$ticket = mysqli_query($con,$query);
	$rowcount=mysqli_num_rows($ticket);
	$department = '';
	while($t = mysqli_fetch_object($ticket)){
		$message = 'HID: '.$HID.'<br />';
		$message .='Hi,<br /><br />';
	    $message .='A new ticket was generated: <br /><br />';
		$query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = '.$r->id.' AND department.description="'.$t->description.'" AND type="interim"';
		$department .= $t->description.', ';
		$tic = mysqli_query($con,$query);
		$ticcount=mysqli_num_rows($tic);
		if($ticcount > 1){
			$k=1;
		}else{
			$k = '';
		}
		$query = 'SELECT * FROM  bf_patients_int  WHERE patient_id = "'.$r->patientid.'"';
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
			if($permission->message_ticket_int == 1){
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

		
		
		$quiery = 'Update bf_feedback_int set emailstatus = 1 WHERE id='.$r->id;
		mysqli_query($con,$quiery);
	
}


//send the message, check for errors

