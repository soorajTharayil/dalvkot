<?php
date_default_timezone_set("Asia/Calcutta");
include('../api/db.php');

include('/var/www/html/globalconfig.php');
function formate_string($feedback, $ward, $department)
{
	$set = json_decode($feedback->dataset);
	$string = '';
	$string .=	substr($set->name, 0, 7);
	$string .= "," . substr($set->patientid, -4);
	if ($ward != '' && $ward != null) {
		$string .= "," . substr($ward, 0, 4);
	}
	if ($set->bedno != '' && $set->bedno != null) {
		$string .= "," . substr($set->bedno, 0, 4);
	}
	if ($department != '' && $department != null) {
		$string .= "," . substr($department, 0, 7);
	}
	return $string;
}

$query = 'SELECT * FROM `escalation` WHERE section="INTERIM"';
$escilation = mysqli_fetch_object(mysqli_query($con, $query));
if ($escilation->status != 'ACTIVE') {
	///exit;
	$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus = 0';
	$flore = mysqli_query($con, $query);
	while ($r = mysqli_fetch_object($flore)) {
		$quiery = 'Update bf_feedback_int set escilationstatus = -1 WHERE id=' . $r->id;
		mysqli_query($con, $quiery);
	}
}

//when sms button is turn off in escalation page
// if ($escilation->level1_sms_alert == 'NO' || $escilation->level2_sms_alert == 'NO') {

// 	$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus = 0';
// 	$flore = mysqli_query($con, $query);
// 	while ($r = mysqli_fetch_object($flore)) {
// 		$quiery = 'Update bf_feedback_int set escilationstatus = -1 WHERE id=' . $r->id;
// 		mysqli_query($con, $quiery);
// 	}
// }


$sql1 = 'SELECT mobile,email,department FROM user where user_id IN (' . implode(",", json_decode($escilation->level1_escalate_to)) . ')';
$sql2 = 'SELECT mobile,email,department FROM user where user_id IN (' . implode(",", json_decode($escilation->level2_escalate_to)) . ')';
$sql3 = 'SELECT mobile,email,department FROM user where user_id IN (' . implode(",", json_decode($escilation->dept_level_escalation_to)) . ')';
$escilate_level_one_to =  mysqli_query($con, $sql1);
$escilate_to_one = array();
$escilate_to_two = array();
$escilate_to_department = array();
while ($e1 = mysqli_fetch_object($escilate_level_one_to)) {
	$e1->department = json_decode($e1->department, true);
	$escilate_to_one[] = $e1;
}

$escilate_level_tow_to =  mysqli_query($con, $sql2);
while ($e1 = mysqli_fetch_object($escilate_level_tow_to)) {
	$e1->department = json_decode($e1->department, true);
	$escilate_to_two[] = $e1;
}

$escilate_level_departmenthead =  mysqli_query($con, $sql3);
while ($e1 = mysqli_fetch_object($escilate_level_departmenthead)) {
	$e1->department = json_decode($e1->department, true);
	$escilate_to_department[] = $e1;
}

$query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus = 0';

$flore = mysqli_query($con, $query);



while ($r = mysqli_fetch_object($flore)) {

	$ward_floor = $r->ward;
	$parameter = json_decode($r->dataset);

	$patient_name = $parameter->name;
	$patient_uhid = $parameter->patientid;
	$patient_ward = $parameter->ward;
	$patient_bedno = $parameter->bedno;


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

	while ($t = mysqli_fetch_object($ticket)) {
		$meta_data['ticket'] = $t;
		$meta_data['config_set_url'] = $config_set['BASE_URL'];
		$meta_data['config_set_domain'] = $config_set['DOMAIN'];
		$ticketgen = true;

		$query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $r->id . ' AND department.description="' . $t->description . '"';


		$department = $t->description;

		$department_time = $t->dept_level_escalation;
		$level_one_time = $t->close_time;
		$level_two_time = $t->close_time_l2;

		$escilate_level_one_time = date("Y-m-d H:i:s", strtotime("+" . $level_one_time . " seconds"));
		$escilate_level_two_time = date("Y-m-d H:i:s", strtotime("+" . $level_two_time . " seconds"));
		$escilate_level_departmnet_time = date("Y-m-d H:i:s", strtotime("+" . $department_time . " seconds"));


		$tic = mysqli_query($con, $query);

		$TID = $t->id;
		$ticcount = mysqli_num_rows($tic);
		$department_head_link = $config_set['BASE_URL'] . 'pc/track/' . $TID;
		$Concern_Category = $t->description;
		$Concern_Area = $t->name;

		if ($ticcount > 1) {

			$k = 1;
		} else {

			$k = '';
		}

		$query = 'SELECT * FROM  bf_ward  WHERE title = "' . $p->ward . '"';

		$patient = mysqli_query($con, $query);

		$f = mysqli_fetch_object($patient);


		$formate_string = formate_string($r, $f->smallname, $t->description);
		$message = "ATTENTION!%0aLevel 2 Escalation.%0aInpatient Issue not addressed.%0a" . $formate_string . "%0aLogin to view details:%0a" . $link . "%0a-ITATONE";
		$message = str_replace('&', 'and', str_replace(' ', '%20', $message));
		foreach ($escilate_to_department as $e3) {
			$number = $e3->mobile;

			$setArray = explode(',', $e3->department['interim'][$t->setkey]);


			if (in_array($t->slug, $setArray)) {
				if ($escilation->dept_level_sms_alert == 'YES') {
					// $query = 'INSERT INTO `notification_escilation`
					// 		(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`sheduled_at`,meta)
					// 		VALUES 
					// 		("message","' . $message . '",0,"' . $e3->mobile . '","1607100000000259026","' . $HID . '","' . $escilate_level_departmnet_time . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '")';

					// $conn_g->query($query);
				}
				if ($escilation->dept_level_whatsapp_alert == 'YES') {
					$destination = '91' . $number;
					$userName = 'ITATONE POINT CONSULTING LLP 7345';
					$campaignName = 'level1_patientcomplaint_escalationalert';
					$templateParams = json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $department_head_link, $hospitalname], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
					$source = 'new-landing-page form';
					$media = '{}';
					$buttons = '[]';
					$carouselCards = '[]';
					$location = '{}';
					$paramsFallbackValue = json_encode(["FirstName" => "user"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
					$status = 'pending';
					$scheduled_at = $escilate_level_departmnet_time;
					// JSON-encode and escape meta_data for insertion
					$meta_json = mysqli_real_escape_string($con, json_encode($meta_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

					// Prepare the SQL query
					$insert_notification_query = "INSERT INTO whatsapp_escalation (
					destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status, sheduled_at, meta
				) VALUES (
					'$destination', '$userName', '$campaignName', '$templateParams', '$source', '$media', '$buttons', '$carouselCards', '$location', '$paramsFallbackValue', '$status', '$scheduled_at', '$meta_json'
				)";
					// Execute the second query
					if ($conn_g->query($insert_notification_query) === TRUE) {
						echo "Data inserted into notifications table successfully.<br>";
					} else {
						echo "Error: " . $con->error . "<br>";
					}
				}
			}
		}

		$message = "WARNING!%0aLevel 1 Escalation.%0aInpatient Issue not addressed.%0a" . $formate_string . "%0aLogin to view details:%0a" . $link . "%0a-ITATONE";
		$message = str_replace('&', 'and', str_replace(' ', '%20', $message));
		foreach ($escilate_to_one as $e1) {
			$number = $e1->mobile;
			if ($escilation->level1_sms_alert == 'YES') {
				// $query = 'INSERT INTO `notification_escilation`
				// 				(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`sheduled_at`,meta)
				// 				VALUES 
				// 				("message","' . $message . '",0,"' . $e1->mobile . '","1607100000000259025","' . $HID . '","' . $escilate_level_one_time . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '")';

				// $conn_g->query($query);
			}
			if ($escilation->level1_whatsapp_alert == 'YES') {
				$destination = '91' . $number;
				$userName = 'ITATONE POINT CONSULTING LLP 7345';
				$campaignName = 'level2_patientcomplaint_escalationalert';
				$templateParams = json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $department_head_link, $hospitalname], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				$source = 'new-landing-page form';
				$media = '{}';
				$buttons = '[]';
				$carouselCards = '[]';
				$location = '{}';
				$paramsFallbackValue = json_encode(["FirstName" => "user"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				$status = 'pending';
				$scheduled_at = $escilate_level_one_time;
				// JSON-encode and escape meta_data for insertion
				$meta_json = mysqli_real_escape_string($con, json_encode($meta_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

				// Prepare the SQL query
				$insert_notification_query = "INSERT INTO whatsapp_escalation (
					destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status, sheduled_at, meta
				) VALUES (
					'$destination', '$userName', '$campaignName', '$templateParams', '$source', '$media', '$buttons', '$carouselCards', '$location', '$paramsFallbackValue', '$status', '$scheduled_at', '$meta_json'
				)";
				// Execute the second query
				if ($conn_g->query($insert_notification_query) === TRUE) {
					echo "Data inserted into notifications table successfully.<br>";
				} else {
					echo "Error: " . $con->error . "<br>";
				}
			}
		}

		$message = "ATTENTION!%0aLevel 2 Escalation.%0aInpatient Issue not addressed.%0a" . $formate_string . "%0aLogin to view details:%0a" . $link . "%0a-ITATONE";
		$message = str_replace('&', 'and', str_replace(' ', '%20', $message));
		foreach ($escilate_to_two as $e2) {
			$number = $e2->mobile;
			if ($escilation->level2_sms_alert == 'YES') {
				// $query = 'INSERT INTO `notification_escilation`
				// 			(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`sheduled_at`,meta)
				// 			VALUES 
				// 			("message","' . $message . '",0,"' . $e2->mobile . '","1607100000000259026","' . $HID . '","' . $escilate_level_one_time . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '")';

				// $conn_g->query($query);
			}
			if ($escilation->level2_whatsapp_alert == 'YES') {
				$destination = '91' . $number;
				$userName = 'ITATONE POINT CONSULTING LLP 7345';
				$campaignName = 'level3_patientcomplaint_escalationalert';
				$templateParams = json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $department_head_link, $hospitalname], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				$source = 'new-landing-page form';
				$media = '{}';
				$buttons = '[]';
				$carouselCards = '[]';
				$location = '{}';
				$paramsFallbackValue = json_encode(["FirstName" => "user"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				$status = 'pending';
				$scheduled_at = $escilate_level_two_time;
				// JSON-encode and escape meta_data for insertion
				$meta_json = mysqli_real_escape_string($con, json_encode($meta_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

				// Prepare the SQL query
				$insert_notification_query = "INSERT INTO whatsapp_escalation (
					destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status, sheduled_at, meta
				) VALUES (
					'$destination', '$userName', '$campaignName', '$templateParams', '$source', '$media', '$buttons', '$carouselCards', '$location', '$paramsFallbackValue', '$status', '$scheduled_at', '$meta_json'
				)";
				// Execute the second query
				if ($conn_g->query($insert_notification_query) === TRUE) {
					echo "Data inserted into notifications table successfully.<br>";
				} else {
					echo "Error: " . $con->error . "<br>";
				}
			}
		}
	}







	/*FOR Patient Message */





	/*FOR Admin Alert Message */


	/* FOr Admin Alert Message  */

	$quiery = 'Update bf_feedback_int set escilationstatus = 5 WHERE id=' . $r->id;

	mysqli_query($con, $quiery);
}

$conn_g->close();

// send the message, check for errors
