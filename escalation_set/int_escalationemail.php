<?php
	date_default_timezone_set("Asia/Calcutta");
	include ('../api/db.php');

	include('/var/www/html/globalconfig.php');
	
	
	$query = 'SELECT * FROM `escalation` WHERE section="INTERIM"';
	$escilation = mysqli_fetch_object(mysqli_query($con, $query));
	if($escilation->status != 'ACTIVE'){
		//exit;
		$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';
		$flore = mysqli_query($con, $query);
		while ($r = mysqli_fetch_object($flore)){
			$quiery = 'Update bf_feedback_int set escilationstatus_email = -1 WHERE id=' . $r->id;
			mysqli_query($con, $quiery);	
		}
	}

	//when email button is turn off in escalation page
	if($escilation->level1_email_alert == 'NO'|| $escilation->level1_email_alert == 'NO') {

		$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';
	$flore = mysqli_query($con, $query);
	while ($r = mysqli_fetch_object($flore)){
		$quiery = 'Update bf_feedback_int set escilationstatus_email = -1 WHERE id=' . $r->id;
		mysqli_query($con, $quiery);	
	}
	} 

	$escilate_level_one_time = date("Y-m-d H:i:s", strtotime("+".$escilation->level1_duration_min." minutes"));
	$escilate_level_two_time = date("Y/m/d H:i:s", strtotime("+".$escilation->level2_duration_min." minutes"));
	$sql1 = 'SELECT mobile,email FROM user where user_id IN ('.implode(",",json_decode($escilation->level1_escalate_to)).')';
	$sql2 = 'SELECT mobile,email FROM user where user_id IN ('.implode(",",json_decode($escilation->level2_escalate_to)).')';
	$escilate_level_one_to =  mysqli_query($con,$sql1);
	$escilate_to_one = array();
	$escilate_to_two = array();
	while($e1 = mysqli_fetch_object($escilate_level_one_to)){
		$escilate_to_one[] = $e1;
	}
	
	$escilate_level_tow_to =  mysqli_query($con,$sql2);
	while($e1 = mysqli_fetch_object($escilate_level_tow_to)){
		$escilate_to_two[] = $e1;
	}
	$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';

	$flore = mysqli_query($con, $query);


   
	while ($r = mysqli_fetch_object($flore)){

		$message = '';

		$query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $r->id . ' GROUP BY  department.description';

		$ticket = mysqli_query($con, $query);

		$rowcount = mysqli_num_rows($ticket);

		$department = '';

		$query = 'SELECT * FROM  bf_patients WHERE id = "' . $r->pid . '"';

		$patient = mysqli_query($con, $query);

		$p = mysqli_fetch_object($patient);

		$ticketgen = false;

		$total_ticket = 0;
$meta_data = array();
		while ($t = mysqli_fetch_object($ticket)){$meta_data['ticket'] = $t;		$meta_data['config_set_url'] = $config_set['BASE_URL'];			$meta_data['config_set_domain'] = $config_set['DOMAIN'];			

			$ticketgen = true;

			$query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $r->id . ' AND department.description="' . $t->description . '"';

			$department = $t->description ;

			$tic = mysqli_query($con, $query);

			$ticcount = mysqli_num_rows($tic);

			if ($ticcount > 1){

				$k = 1;

			}else{

				$k = '';

			}

			$query = 'SELECT * FROM  bf_ward  WHERE title = "' . $p->ward . '"';

			$patient = mysqli_query($con, $query);

			$f = mysqli_fetch_object($patient);
			$subject_1 = 'Level 1 ESCALATION- HID: '.$HID.'- COMPLAINT FROM INTERIM FEEDBACK TICKET- EFEEDOR';
			$subject_2 = 'Level 2 ESCALATION- HID: '.$HID.'- COMPLAINT FROM INTERIM FEEDBACK TICKET- EFEEDOR';
			
			$message_1 = '<h3>Level 1 ESCLATION for the below ticket:</h3>';
			$message_1 .= '<h3>HID: '.$HID.'</h3>';
			$message_1 .= '<p>Hi,</p>';
			$message_1 .= '<p>Feedback ticket from</p>';
			$message_1 .= '<p>Patient: '.$p->name.'</p>';
			$message_1 .= '<p>PID: '.$p->patient_id.'</p>'; 
			$message_1 .= '<p>Floor: '.$f->smallname.'</p>';
			$message_1 .= '<p>Department: '.$t->description.'</p>';
			$message_1 .= '<p>Kindly click the below link to view the same.</p>';
			$message_1 .= '<p><a href="'.$link.'">'.$link.'</a></p>';
			$message_1 .= '<p>Regards,</p>';
			$message_1 .= '<p>'.$hospitalname.'</p>';
			
			
			$message_2 = '<h3>Level 2 ESCLATION for the below ticket:</h3>';
			$message_2 .= '<h3>HID: '.$HID.'</h3>';
			$message_2 .= '<p>Hi,</p>';
			$message_2 .= '<p>Feedback ticket from</p>';
			$message_2 .= '<p>Patient: '.$p->name.'</p>';
			$message_2 .= '<p>PID: '.$p->patient_id.'</p>'; 
			$message_2 .= '<p>Floor: '.$f->smallname.'</p>';
			$message_2 .= '<p>Department: '.$t->description.'</p>';
			$message_2 .= '<p>Kindly click the below link to view the same.</p>';
			$message_2 .= '<p><a href="'.$link.'">'.$link.'</a></p>';
			$message_2 .= '<p>Regards,</p>';
			$message_2 .= '<p>'.$hospitalname.'</p>';

			
			//$message.= $section.' in '. $t->description;

			//$message.='%0a'.$COMPANYNAME;

			

			$number = $t->mobile;

			$message = str_replace('&', 'and', str_replace(' ', '%20', $message));
			foreach($escilate_to_one as $e1){
			
				echo $query = 'INSERT INTO `notification_escilation`
						(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`sheduled_at`,meta_data)
						VALUES 
						("email","'.mysqli_real_escape_string($con,$message_1).'",0,"'.$e1->email.'","'.$subject_1.'","'.$HID.'","'.$escilate_level_one_time.'","'.mysqli_real_escape_string($con,json_encode($meta_data)).'")'; 
				
				$conn_g->query($query);
			}

			foreach($escilate_to_two as $e2){

				$query = 'INSERT INTO `notification_escilation`
						(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`sheduled_at`,meta_data)
						VALUES 
						("email","'.mysqli_real_escape_string($con,$message_2).'",0,"'.$e2->email.'","'.$subject_2.'","'.$HID.'","'.$escilate_level_two_time.'","'.mysqli_real_escape_string($con,json_encode($meta_data)).'")';

				$conn_g->query($query);
			}
			

		}



		



	/*FOR Patient Message */

	

	

	/*FOR Admin Alert Message */


		/* FOr Admin Alert Message  */

		$quiery = 'Update bf_feedback_int set escilationstatus_email = 1 WHERE id=' . $r->id;

		mysqli_query($con, $quiery);

	}

$conn_g->close();

// send the message, check for errors





