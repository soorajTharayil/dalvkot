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
$mail->Subject = 'Ticket Ageing Alert '.date('d M, Y');
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('examples/contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('examples/images/phpmailer_mini.png');

include('../api/db.php');
$fdate = date('Y-m-d',time());
$tdate = date('Y-m-d', strtotime('-2 days'));
$tdate7day = date('Y-m-d', strtotime('-7 days'));
$query = 'SELECT * FROM  tickets  WHERE status = "Open" AND created_on <= "'.$tdate.'" AND created_on  > "'.$tdate7day.'"' ;
$tickets = mysqli_query($con,$query);
$html1 ='Hi, This ticket was not closed <br /><br />';
$c = 0;
while($t = mysqli_fetch_object($tickets)){
	if($c == 0){
		$html1 .= '<table border="1" width="100%"  cellpadding="5" cellspacing="0">';
		$html1 .='<tr><td colspan="6" style="text-align:center;"><h2>Tickets open since 48 hours</h2></td></tr>';
		$html1 .='<tr><td>Sl No</td><td>Patient Details</td><td>Rating</td><td>Department</td><td>Assigned to</td><td>Created On</td></tr>';
	}
	$c++;
	$query = 'SELECT * FROM  bf_patients  WHERE patient_id = "'.$t->created_by.'"';
	$patient = mysqli_query($con,$query);
	$p = mysqli_fetch_object($patient);
	//print_r($p);
	$html1 .='<tr><td>'.$c.'</td>';
	$html1 .='<td>'.$p->name.'('.$p->patient_id.')</td>';
	$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  tickets.id = '.$t->id;
	$tic = mysqli_query($con,$query);
	$tp = mysqli_fetch_object($tic);
		
	if($tp->rating == 2){
		$ratingp = 'Average'; 
	}else{
		$ratingp = 'Poor';
	}
	$html1 .='<td>'.$ratingp.'</td>';
	$html1 .='<td>'.$tp->description.'</td>';
	$html1 .='<td>'.$tp->pname.'</td>';
	$html1 .='<td>'.date('d M, Y H:i',strtotime($t->created_on)).'</td></td></tr>';
	
}
$html1 .='</table>';
$c = 0;
$tdate15day = date('Y-m-d', strtotime('-15 days'));
$query = 'SELECT * FROM  tickets  WHERE status = "Open" AND created_on <= "'.$tdate7day.'" AND created_on  > "'.$tdate15day.'"' ;
$tickets = mysqli_query($con,$query);
while($t = mysqli_fetch_object($tickets)){
	if($c == 0){
		$html1 .= '<table  border="1" width="100%"  cellpadding="5" cellspacing="0">';
		$html1 .='<tr ><td colspan="6"  style="text-align:center;"><h2>Tickets open since  7 days</h2></td></tr>';
		$html1 .='<tr><td>Sl No</td><td>Patient Details</td><td>Rating</td><td>Department</td><td>Assigned to</td><td>Created On</td></tr>';
	}
	$c++;
	$query = 'SELECT * FROM  bf_patients  WHERE patient_id = "'.$t->created_by.'"';
	$patient = mysqli_query($con,$query);
	$p = mysqli_fetch_object($patient);
	//print_r($p);
	$html1 .='<tr><td>'.$c.'</td>';
	$html1 .='<td>'.$p->name.'('.$p->patient_id.')</td>';
	$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  tickets.id = '.$t->id;
	$tic = mysqli_query($con,$query);
	$tp = mysqli_fetch_object($tic);
		
	if($tp->rating == 2){
		$ratingp = 'Average'; 
	}else{
		$ratingp = 'Poor';
	}
	$html1 .='<td>'.$ratingp.'</td>';
	$html1 .='<td>'.$tp->description.'</td>';
	$html1 .='<td>'.$tp->pname.'</td>';
	$html1 .='<td>'.date('d M, Y H:i',strtotime($t->created_on)).'</td></td></tr>';
	
}
$html1 .='</table>';

$c = 0;
$query = 'SELECT * FROM  tickets  WHERE status = "Open" AND  created_on  < "'.$tdate15day.'"' ;
$tickets = mysqli_query($con,$query);
while($t = mysqli_fetch_object($tickets)){
	if($c == 0){
		$html1 .= '<table  border="1" width="100%" cellpadding="5" cellspacing="0">';
		$html1 .='<tr><td colspan="6"  style="text-align:center;"><h2>Tickets open since 15 days</h2></td></tr>';
		$html1 .='<tr><td >Sl No</td><td>Patient Details</td><td>Rating</td><td>Department</td><td>Assigned to</td><td>Created On</td></tr>';
	}
	$c++;
	$query = 'SELECT * FROM  bf_patients  WHERE patient_id = "'.$t->created_by.'"';
	$patient = mysqli_query($con,$query);
	$p = mysqli_fetch_object($patient);
	//print_r($p);
	$html1 .='<tr><td>'.$c.'</td>';
	$html1 .='<td>'.$p->name.'('.$p->patient_id.')</td>';
	$query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  tickets.id = '.$t->id;
	$tic = mysqli_query($con,$query);
	$tp = mysqli_fetch_object($tic);
		
	if($tp->rating == 2){
		$ratingp = 'Average'; 
	}else{
		$ratingp = 'Poor';
	}
			
	
	
	$html1 .='<td>'.$ratingp.'</td>';
	$html1 .='<td>'.$tp->description.'</td>';
	$html1 .='<td>'.$tp->pname.'</td>';
	$html1 .='<td>'.date('d M, Y H:i',strtotime($t->created_on)).'</td></td></tr>';
	
}
$html1 .='</table>';
$html1 .='<br /><br />Kindly click the below link to view the same.<br />http://'.$link.'<br /><br />';			
$html1 .='<br /><br />Regards,<br />'.$hospitalname.' ';

$query = 'SELECT * FROM  user  WHERE user_id = 2';
$patient = mysqli_query($con,$query);
$u = mysqli_fetch_object($patient);
$mail->ClearAddresses();
$mail->addAddress($u->email, 'Info');
$mail->msgHTML($html1);
if (!$mail->send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "Message sent!";
}
exit;
	
//send the message, check for errors

