<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//email to  admins(ip) when ticket is OPEN                                              
//email to  admins(op) when ticket is OPEN                                              
//email to  admins(interim) when ticket is OPEN                                         
//email to  admins(isr) when ticket is OPEN                                         
//email to  admins(incident) when ticket is OPEN                                         
//escalation level 1 and level 2 email to  admins(interim) when ticket is OPEN          


include('../api/db.php');
include('/var/www/html/globalconfig.php');
include('get_user.php');

//email to admin  when they are created 

$user_query = 'SELECT * FROM `user` WHERE `admin_email` = 0  AND  `user_role` = 2';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $permission = json_decode($user_object->departmentpermission);

    $email = $user_object->email;
    $password = $permission->password;
    $name = $user_object->firstname;

    $Subject = 'Welcome to Efeedor - Your Account is Now Active!';
    $message1 = 'Dear ' . $name . ', <br /><br />';
    $message1 .= 'Welcome aboard! <br /><br />';
    $message1 .= 'Your account is now active on Efeedor Healthcare Experience Management Software at <b>' . $hospitalname . '</b>. You can now access the dashboard to explore insights and receive alerts to enhance service delivery. <br /><br />';
    $message1 .= 'Get Started: <br /><br />';
    $message1 .= 'Web Link: ' . $link . ' <br /><br />';
    $message1 .= 'Username: ' . $email . ' <br />';
    $message1 .= 'Default Password: ' . $password . ' <br /><br />';
    $message1 .= 'Important: Please update your default password in the "Edit Profile" section (top-right of your dashboard) for security purposes. <br /><br />';
    $message1 .= 'If you need any assistance, feel free to reach out to your Software Admin. <br /><br />';
    $message1 .= 'We are excited to have you on board—happy exploring! <br /><br />';
    $message1 .= 'Best regards, <br /><br />';
    $message1 .= $hospitalname;


    $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
    $conn_g->query($query);

    $query = 'UPDATE user SET `admin_email` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}


$user_query = 'SELECT * FROM `user` WHERE `admin_email` = 0  AND  `user_role` = 3';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $permission = json_decode($user_object->departmentpermission);

    $email = $user_object->email;
    $password = $permission->password;
    $name = $user_object->firstname;

    $Subject = 'Welcome to Efeedor - Your Admin Account is Now Active!';
    $message1 = 'Dear ' . $name . ', <br /><br />';
    $message1 .= 'We are delighted to welcome you aboard! <br /><br />';
    $message1 .= 'Your account is now active on the Efeedor Healthcare Experience Management Software at <b>' . $hospitalname . '</b> with Admin privileges. You can now access the dashboard to explore insights and receive alerts to enhance service delivery. <br /><br />';
    $message1 .= 'Explore Your Admin Privileges: <br /><br />';
    $message1 .= 'Access the Dashboard: ' . $link . ' <br /><br />';
    $message1 .= 'Username: ' . $email . ' <br />';
    $message1 .= 'Default Password: ' . $password . ' <br /><br />';
    $message1 .= 'Important: For security purposes, please update your default password in the "Edit Profile" section at the top-right of your dashboard. <br /><br />';
    $message1 .= 'To familiarize yourself with the application and understand your admin functionalities, we recommend reviewing the Admin Manual here: <br />';
    $message1 .= 'https://rebrand.ly/Efeedor-AdminDashboard-Manual <br /><br />';
    $message1 .= 'If you have any questions or need assistance, feel free to reach out to your Software Admin. <br /><br />';
    $message1 .= 'Welcome aboard — we look forward to your journey with Efeedor! <br /><br />';
    $message1 .= 'Best regards, <br /><br />';
    $message1 .= $hospitalname;


    $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
    $conn_g->query($query);

    $query = 'UPDATE user SET `admin_email` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}



//email to  admins(ip) for all feedback

$Subject = 'You have received feedback from an inpatient in Efeedor';
$feedback_query = 'SELECT * FROM  bf_feedback  WHERE allfeedback_email_alert = 0';
$feedback_result = mysqli_query($con, $feedback_query);

while ($feedback_object = mysqli_fetch_object($feedback_result)) {
    $param_ip = json_decode($feedback_object->dataset);

    $feedbackid = $feedback_object->id;

    if ($param_ip->recommend1Score > 4) {
        $nps_s = "Satisfied";
    } else {
        $nps = "Unsatisfied";
    }
    $admins_ip_link = $config_set['BASE_URL'] . 'ipd/patient_feedback?id=' . $feedbackid;
    $feedback_details = [];

    $setup_query = "SELECT * FROM setup WHERE parent = 1";
    $setup_result = mysqli_query($con, $setup_query);
    
    while ($setup_object = mysqli_fetch_object($setup_result)) {
        $shortkey = trim($setup_object->shortkey);
        $shortname = trim($setup_object->shortname);
    
        echo "Checking shortkey: " . ($shortkey ?: '[EMPTY]') . "<br>";
    
        if (!empty($shortkey) && isset($param_ip->$shortkey) && $param_ip->$shortkey !== "") {
            $feedback_details[] = "$shortname : {$param_ip->$shortkey}";
        }
    }
    
    // Print feedback details for debugging
    // print_r($feedback_details);
   

    $nps = $param_ip->recommend1Score * 2;
    //message1 will insert when there is only ONE TIKECT
    $nps = $param_ip->recommend1Score * 2;

  // Message for feedback email
$message1 = '<html><body>';
$message1 .= '<div style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto;">';

// Header
$message1 .= '<h2 style="background-color: #0073e6; color: white; padding: 12px; text-align: center; border-radius: 5px;">Patient Feedback Notification</h2>';
$message1 .= '<p>Hi, <br /><br />You have received feedback from a discharged inpatient. Please find the details below:</p>';

// Patient Details Table
$message1 .= '<table border="0" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
$message1 .= '<tr style="background-color: #f8f8f8;"><th colspan="2" style="text-align: left; padding: 12px;">Patient Details</th></tr>';
$message1 .= '<tr><td><strong>Patient Name</strong></td><td>' . htmlspecialchars($param_ip->name) . '</td></tr>';
$message1 .= '<tr style="background-color: #f2f2f2;"><td><strong>Patient UHID</strong></td><td>' . htmlspecialchars($param_ip->patientid) . '</td></tr>';
$message1 .= '<tr><td><strong>Mobile Number</strong></td><td>' . htmlspecialchars($param_ip->contactnumber) . '</td></tr>';
$message1 .= '<tr style="background-color: #f2f2f2;"><td><strong>Email ID</strong></td><td>' . htmlspecialchars($param_ip->email) . '</td></tr>';
$message1 .= '<tr><td><strong>Floor/Ward</strong></td><td>' . htmlspecialchars($param_ip->ward) . '</td></tr>';
$message1 .= '<tr style="background-color: #f2f2f2;"><td><strong>Site</strong></td><td>' . htmlspecialchars($param_ip->bedno) . '</td></tr>';
$message1 .= '<tr style="background-color: #f2f2f2;"><td><strong>Source</strong></td><td>' . htmlspecialchars($feedback_object->source) . '</td></tr>';
$message1 .= '</table><br>';

// Feedback Details Table
$message1 .= '<table border="0" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
$message1 .= '<tr style="background-color: #0073e6; color: white;"><th colspan="2" style="text-align: left; padding: 12px;">Feedback Details</th></tr>';


if (!empty($feedback_details)) {
    $message1 .= '<tr><th style="width: 80%; background-color: #f2f2f2; text-align: left;">Feedback</th>';
    $message1 .= '<th style="width: 20%; background-color: #f2f2f2; text-align: center;">Rating</th></tr>';
    
    foreach ($feedback_details as $feedback) {
        list($label, $rating) = explode(':', $feedback, 2); // Split label and rating
        $message1 .= '<tr>';
        $message1 .= '<td style="border-bottom: 1px solid #ddd; color: #333; padding: 8px; text-align: left;">' . htmlspecialchars(trim($label)) . '</td>';
        $message1 .= '<td style="border-bottom: 1px solid #ddd; color: #333; padding: 8px; text-align: center;">' . htmlspecialchars(trim($rating)) . '</td>';
        $message1 .= '</tr>';
    }
} else {
    $message1 .= '<tr><td colspan="2" style="border-bottom: 1px solid #ddd; color: #999; text-align: center;">No detailed feedback provided.</td></tr>';
}

$message1 .= '<tr style="background-color: #f8f8f8;"><td><strong>Feedback Link</strong></td><td><a href="' . htmlspecialchars($admins_ip_link) . '" style="color: #0073e6;">View Feedback</a></td></tr>';
$message1 .= '<tr><td><strong>Satisfaction Status</strong></td><td>' . htmlspecialchars($nps_s) . '</td></tr>';
$message1 .= '<tr style="background-color: #f8f8f8;"><td><strong>Average Rating</strong></td><td>' . htmlspecialchars($param_ip->overallScore) . '</td></tr>';
$message1 .= '<tr><td><strong>NPS Rating</strong></td><td>' . htmlspecialchars($nps) . '</td></tr>';
$message1 .= '<tr style="background-color: #f8f8f8;"><td><strong>Recognized Staff</strong></td><td>' . htmlspecialchars($param_ip->staffname) . '</td></tr>';
$message1 .= '<tr><td><strong>Other Feedbacks / Suggestions</strong></td><td>' . htmlspecialchars($param_ip->suggestionText) . '</td></tr>';
$message1 .= '</table><br>';

// Call to Action
$message1 .= '<p style="text-align: center;">';
$message1 .= '<a href="' . htmlspecialchars($admins_ip_link) . '" style="background-color: #0073e6; color: white; padding: 10px 20px; text-decoration: none; font-size: 16px; border-radius: 5px; display: inline-block;">View Feedback</a>';
$message1 .= '</p>';

// Signature
$message1 .= '<p><strong>Best Regards,</strong><br>' . $hospitalname . '</p>';
$message1 .= '</div>';
$message1 .= '</body></html>';



    $users = get_user_by_sms_activity('ALL-FEEDBACKS-EMAIL-ALERT', $con);
    foreach ($users as $user_object) {
        $floor_wards = json_decode($user_object->floor_ward, true);
        // Check if $patient_ward matches any value in $floor_wards
        $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
        $conn_g->query($query);
    }

    $update_query = 'Update bf_feedback set allfeedback_email_alert = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);

}


//email to  admins(ip) for all feedback

$Subject = 'You have received feedback from an outpatient in Efeedor';
$feedback_query = 'SELECT * FROM  bf_outfeedback  WHERE allfeedback_email_alert = 0';
$feedback_result = mysqli_query($con, $feedback_query);

while ($feedback_object = mysqli_fetch_object($feedback_result)) {
    $param_ip = json_decode($feedback_object->dataset);

    $feedbackid = $feedback_object->id;

    if ($param_ip->recommend1Score > 4) {
        $nps_s = "Satisfied";
    } else {
        $nps = "Unsatisfied";
    }
    $admins_ip_link = $config_set['BASE_URL'] . 'opf/patient_feedback?id=' . $feedbackid;


    $feedback_details = [];

    $setup_query = "SELECT * FROM setupop WHERE parent = 1";
    $setup_result = mysqli_query($con, $setup_query);
    
    while ($setup_object = mysqli_fetch_object($setup_result)) {
        $shortkey = trim($setup_object->shortkey);
        $shortname = trim($setup_object->shortname);
    
        echo "Checking shortkey: " . ($shortkey ?: '[EMPTY]') . "<br>";
    
        if (!empty($shortkey) && isset($param_ip->$shortkey) && $param_ip->$shortkey !== "") {
            $feedback_details[] = "$shortname : {$param_ip->$shortkey}";
        }
    }
    
    
    $nps = $param_ip->recommend1Score * 2;
    //message1 will insert when there is only ONE TIKECT
    $message1 = 'Hi, <br /><br />';
$message1 .= 'You have received feedback from an outpatient. Please find the details below: <br /><br />';

$message1 .= '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; color: #333;">';

// Patient Details Section
$message1 .= '<tr><th colspan="2" style="background-color: #0073e6; color: #fff; text-align: left; padding: 10px;">Patient Details</th></tr>';
$message1 .= '<tr><td style="width: 40%; font-weight: bold; background-color: #f9f9f9;">Patient Name</td><td>' . htmlspecialchars($param_ip->name) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Patient UHID</td><td>' . htmlspecialchars($param_ip->patientid) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Mobile Number</td><td>' . htmlspecialchars($param_ip->contactnumber) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Email ID</td><td>' . htmlspecialchars($param_ip->email) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Floor/Ward</td><td>' . htmlspecialchars($param_ip->ward) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Speciality</td><td>' . htmlspecialchars($param_ip->bedno) . '</td></tr>';
$message1 .= '<tr style="background-color: #f2f2f2;"><td><strong>Source</strong></td><td>' . htmlspecialchars($feedback_object->source) . '</td></tr>';


// Feedback Details Section
$message1 .= '<tr><th colspan="2" style="background-color: #0073e6; color: #fff; text-align: left; padding: 10px;">Feedback Details</th></tr>';

// Display Feedback Details
if (!empty($feedback_details)) {
    $message1 .= '<tr><th style="width: 80%; background-color: #f2f2f2; text-align: left;">Feedback</th>';
    $message1 .= '<th style="width: 20%; background-color: #f2f2f2; text-align: center;">Rating</th></tr>';
    
    foreach ($feedback_details as $feedback) {
        list($label, $rating) = explode(':', $feedback, 2);
        $message1 .= '<tr>';
        $message1 .= '<td style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;">' . htmlspecialchars(trim($label)) . '</td>';
        $message1 .= '<td style="border-bottom: 1px solid #ddd; padding: 8px; text-align: center;">' . htmlspecialchars(trim($rating)) . '</td>';
        $message1 .= '</tr>';
    }
} else {
    $message1 .= '<tr><td colspan="2" style="border-bottom: 1px solid #ddd; color: #999; text-align: center;">No detailed feedback provided.</td></tr>';
}

// Additional Feedback Info
$message1 .= '<tr style="background-color: #f8f8f8;"><td><strong>Feedback Link</strong></td><td><a href="' . htmlspecialchars($admins_ip_link) . '" style="color: #0073e6;">View Feedback</a></td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Satisfaction Status</td><td>' . htmlspecialchars($nps_s) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Average Rating</td><td>' . htmlspecialchars($param_ip->overallScore) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">NPS Rating</td><td>' . htmlspecialchars($nps) . '</td></tr>';
$message1 .= '<tr><td style="background-color: #f9f9f9;">Other Feedbacks / Suggestions</td><td>' . htmlspecialchars($param_ip->suggestionText) . '</td></tr>';
$message1 .= '</table><br />';

// Feedback link section
$message1 .= 'To view the feedback submitted by the patient, please click on the link below:<br />';
// Call to Action
$message1 .= '<p style="text-align: center;">';
$message1 .= '<a href="' . htmlspecialchars($admins_ip_link) . '" style="background-color: #0073e6; color: white; padding: 10px 20px; text-decoration: none; font-size: 16px; border-radius: 5px; display: inline-block;">View Feedback</a>';
$message1 .= '</p>';
$message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';


    $users = get_user_by_sms_activity('ALL-FEEDBACKS-EMAIL-ALERT-OP', $con);
    foreach ($users as $user_object) {
        $floor_wards = json_decode($user_object->floor_ward, true);
        // Check if $patient_ward matches any value in $floor_wards

        $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
        $conn_g->query($query);

    }

    $update_query = 'Update bf_outfeedback set allfeedback_email_alert = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);

}




//email to  admins(ip) when ticket is OPEN 

$Subject = 'Alert: Negative feedback Report from Discharged Inpatient at ' . $hospitalname . ' - Action Required';
$feedback_query = 'SELECT * FROM  bf_feedback  WHERE admins_emailstatus = 0';
$feedback_result = mysqli_query($con, $feedback_query);

while ($feedback_object = mysqli_fetch_object($feedback_result)) {

    $param_ip = json_decode($feedback_object->dataset);

    $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
    $tickets_result = mysqli_query($con, $tickets_query);
    $tickets_rowcount = mysqli_num_rows($tickets_result);
    $tickets_generate = false;
    $feedbackid = $feedback_object->id;
    $ward_floor = $feedback_object->ward;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_object = mysqli_fetch_object($tickets_result)) {

        $tickets_generate = true;
        $number = $tickets_object->mobile;
        $department = $tickets_object->description;
        $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $admins_ip_link = $config_set['BASE_URL'] . 'track/ipdf/' . $feedbackid;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();

        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent negative feedback reported by a Discharged Inpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';
        $message1 .= '<strong>Ticket ID:</strong> IPDT-' . $department_object->id . ' <br />';
        $message1 .= '<strong>Patient Name: </strong>' . $param_ip->name . ' <br />';
        $message1 .= '<strong>UHID: </strong>' . $param_ip->patientid . '<br />';
        $message1 .= '<strong>Floor/Ward:</strong> ' . $feedback_object->ward . ' <br />';
        $message1 .= '<strong>Room/Bed No:</strong> ' . $feedback_object->bed_no . '<br />';
        $message1 .= '<strong>Source:</strong> ' . $feedback_object->source . '<br />';
        $message1 .= '<strong>Assigned To:</strong> ' . $department_object->pname . ' <br />';
        $message1 .= '<strong>Department:</strong> ' . $department . ' <br />';
        $message1 .= '<strong>Parameter: </strong>' . $department_object->name . '';
        if ($department_rowcount == 1) {


            $setup_query = "SELECT * FROM setup WHERE parent = 0 ";
            $setup_result = mysqli_query($con, $setup_query);

            while ($setup_object = mysqli_fetch_object($setup_result)) {

                $keys[$setup_object->shortkey] = $setup_object->title;
                $res[$setup_object->shortkey] = $setup_object->question;
                $titles[$setup_object->title] = $setup_object->title;
                $zz[$setup_object->type] = $setup_object->title;
            }
            if ($param_ip->reason) {

                foreach ($param_ip->reason as $key1 => $value) {
                    if ($value) {
                        $message1 .= "<br /><strong> Reason: </strong>" . $res[$key1] . " ";
                    }
                }
            }
            if ($param_ip->comment && !empty($param_ip->comment)) {

                foreach ($param_ip->comment as $key2 => $value) {
                    $message1 .= "<br /><strong> Comment: </strong>" . $value . " ";
                }
            }
        }
        if (isset($param_ip->suggestionText) && !empty($param_ip->suggestionText)) {
            $message1 .= '<br /><strong>General Comment:</strong>' . $param_ip->suggestionText . ' <br />';
        }
        $message1 .= '<br />To view more details and take necessary action, please follow the below link:<br />' . $admins_ip_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($tickets_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT
        $message2 = 'Dear Team, <br /><br />';
        $message2 .= 'We would like to bring to your attention a recent negative feedback reported by an Discharged Inpatient at ' . $hospitalname . '. Below are the patient details : <br /><br />';
        $message2 .= '<strong>Patient Name: </strong>' . $param_ip->name . 
        ' <br /><strong>UHID: </strong>' . $param_ip->patientid . 
        ' <br /><strong>Floor/Ward: </strong>' . $feedback_object->ward . 
        ' <br /><strong>Room/Bed No: </strong>' . $feedback_object->bed_no.
        ' <br /><strong>Source: </strong>' . $feedback_object->source;
            $message2 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_ip_link . '<br /><br />';
        $message2 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message2 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    } else {
        $message2 = $message1;
    }

    if ($tickets_rowcount > 0) {

        $users = get_user_by_sms_activity('IP-ALL-TICKETS-EMAILS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {

                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_feedback set admins_emailstatus = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);
}


//email to  admins(op) when ticket is OPEN 

$Subject = 'Alert: Negative feedback Report from Outpatient at ' . $hospitalname . ' - Action Required';
$feedbackop_query = 'SELECT * FROM  bf_outfeedback  WHERE admins_emailstatus = 0';
$feedbackop_result = mysqli_query($con, $feedbackop_query);

while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {

    $param_op = json_decode($feedbackop_object->dataset);
    $ward_floor = $param_op->ward;
    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' GROUP BY  department.description';
    $ticketsop_result = mysqli_query($con, $ticketsop_query);
    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);
    $ticketsop_generate = false;
    $feedbackid = $feedbackop_object->id;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {

        $ticketsop_generate = true;
        $number = $ticketsop_object->mobile;
        $department = $ticketsop_object->description;
        $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $admins_op_link = $config_set['BASE_URL'] . 'track/opf/' . $feedbackid;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();

        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent negative feedback reported by a  Outpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';
        $message1 .= '<strong>Ticket ID:</strong> OPT-' . $department_object->id . ' <br />';
        $message1 .= '<strong>Patient Name: </strong>' . $param_op->name . ' <br />';
        $message1 .= '<strong>UHID: </strong>' . $param_op->patientid . ' <br />';
        $message1 .= '<strong>Speciality:</strong> ' . $feedbackop_object->ward . ' <br />';
        $message1 .= '<strong>Source:</strong> ' . $feedbackop_object->source . ' <br />';
        $message1 .= '<strong>Assigned To:</strong> ' . $department_object->pname . ' <br />';
        $message1 .= '<strong>Department:</strong> ' . $department . ' <br />';
        $message1 .= '<strong>Parameter: </strong>' . $department_object->name . '';
        if ($department_rowcount == 1) {


            $setupop_query = "SELECT * FROM setupop WHERE parent = 0 ";
            $setupop_result = mysqli_query($con, $setupop_query);

            while ($setupop_object = mysqli_fetch_object($setupop_result)) {

                $keys[$setupop_object->shortkey] = $setupop_object->title;
                $res[$setupop_object->shortkey] = $setupop_object->question;
                $titles[$setupop_object->title] = $setupop_object->title;
                $zz[$setupop_object->type] = $setupop_object->title;
            }
            if ($param_op->reason) {

                foreach ($param_op->reason as $key1 => $value) {
                    if ($value) {
                        $message1 .= "<br /><strong> Reason: </strong>" . $res[$key1] . " ";
                    }
                }
            }
            if ($param_op->comment && !empty($param_op->comment)) {

                foreach ($param_op->comment as $key2 => $value) {
                    $message1 .= "<br /><strong> Comment: </strong>" . $value . " ";
                }
            }
        }
        if (isset($param_op->suggestionText) && !empty($param_op->suggestionText)) {
            $message1 .= '<br /><strong>General Comment:</strong>' . $param_op->suggestionText . ' <br />';
        }
        $message1 .= '<br />To view more details and take necessary action, please follow the below link:<br />' . $admins_op_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($ticketsop_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT
        $message2 = 'Dear Team, <br /><br />';
        $message2 .= 'We would like to bring to your attention a recent negative feedback reported by an  Outpatient at ' . $hospitalname . '. Below are the patient details : <br /><br />';
        $message2 .= '<strong>Patient Name: </strong>' . $param_op->name . 
        ' <br /><strong>UHID: </strong>' . $param_op->patientid . 
        ' <br /><strong>Speciality: </strong>' . $feedbackop_object->ward.
        ' <br /><strong>Source: </strong>' . $feedbackop_object->source;
   $message2 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_op_link . '<br /><br />';
        $message2 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message2 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    } else {
        $message2 = $message1;
    }

    if ($ticketsop_rowcount > 0) {

        $users = get_user_by_sms_activity('OP-ALL-TICKETS-EMAILS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {

                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_outfeedback set admins_emailstatus = 1 WHERE id=' . $feedbackop_object->id;
    mysqli_query($con, $update_query);
}

//email to  admins(interim) when ticket is OPEN 

$Subject = 'Urgent: Complaint reported by InPatient at ' . $hospitalname . ' - Action Required';
$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE admins_emailstatus = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);

while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

    $param_int = json_decode($feedback_int_object->dataset);
    $ward_floor = $feedback_int_object->ward;

    $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
    $tickets_int_result = mysqli_query($con, $tickets_int_query);
    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);
    $tickets_int_generate = false;
    $feedbackid = $feedback_int_object->id;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {

        $tickets_int_generate = true;
        $number = $tickets_int_object->mobile;
        $department = $tickets_int_object->description;
        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $admins_int_link = $config_set['BASE_URL'] . 'pc/track/' . $TID;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent complaint reported by an inpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';

        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
        <table border="1" cellpadding="5">
            <tr>
              <td colspan="2" style="text-align:center;"><b>Complaint reported on</b></td>
           </tr>
            <tr>
              <td width="80%">Time & Date</td>
              <td width="20%">' . $created_on . '</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><b>Complaint details</b></td>
            </tr>
           
            <tr>
                <td width="80%">Category</td>
                <td width="20%">' . $department . '</td>
            </tr>
            <tr>
                <td width="80%">Complaint</td>
                <td width="20%">' . $department_object->name . '</td>
            </tr>';


        if ($param_int->other) {
            $message1 .= '
            <tr>
                <td width="80%">Description</td>
                <td width="20%">' . $param_int->other . '</td>
            </tr>';
        }

        $message1 .= '
            <tr>
                <td colspan="2" style="text-align:center;"><b>Complaint raised in </b></td>
            </tr>
            <tr>
                <td width="80%">Floor/Ward</td>
                <td width="20%">' . $feedback_int_object->ward . '</td>
            </tr>
            <tr>
                <td width="80%">Site</td>
                <td width="20%">' . $feedback_int_object->bed_no . '</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><b>Complaint raised by</b></td>
            </tr>
            <tr>
                <td width="80%">Patient name</td>
                <td width="20%">' . $param_int->name . '</td>
            </tr>
            <tr>
                <td width="80%">Patient UHID</td>
                <td width="20%">' . $param_int->patientid . '</td>
            </tr>
          
            <tr>
                <td width="80%">Mobile number</td>
                <td width="20%">' . $param_int->contactnumber . '</td>
            </tr>
            <tr>
                <td width="80%">Source</td>
                <td width="20%">' . $feedback_int_object->source . '</td>
            </tr>
            <tr>
                <td width="80%">Assigned to</td>
                <td width="20%">' . $department_object->pname . '</td>
            </tr>';



        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_int_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($tickets_int_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT


    } else {
        $message2 = $message1;
    }

    if ($tickets_int_rowcount > 0) {


        $users = get_user_by_sms_activity('ALL-PATIENT-COMPLAINTS-EMAILS', $con);

        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_feedback_int set admins_emailstatus = 1 WHERE id=' . $feedback_int_object->id;
    mysqli_query($con, $update_query);
}

//email to  admins(isr) when ticket is OPEN 

$Subject = 'Urgent: Service Request reported by an Employee at ' . $hospitalname . ' - Action Required';
$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE admins_emailstatus = 0';
$feedback_isr_result = mysqli_query($con, $feedback_isr_query);

while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {

    $param_isr = json_decode($feedback_isr_object->dataset);
    $ward_floor = $param_isr->ward;

    $tickets_isr_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' GROUP BY  department.description';
    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);
    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);
    $tickets_isr_generate = false;
    $feedbackid = $feedback_isr_object->id;
    $total_ticket = 0;
    $department = '';
    $message2 = '';
    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {

        $tickets_isr_generate = true;
        $number = $tickets_isr_object->mobile;
        $department = $tickets_isr_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $admins_isr_link = $config_set['BASE_URL'] . 'isr/track/' . $TID;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent service request reported by an employee at ' . $hospitalname . '. Below are the request details: <br /><br />';

        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
        <table border="1" cellpadding="5">
            <tr>
              <td colspan="2" style="text-align:center;"><b>Request reported on</b></td>
           </tr>
            <tr>
              <td width="80%">Time & Date</td>
              <td width="20%">' . $created_on . '</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><b>Service request details</b></td>
            </tr>
           
            <tr>
                <td width="80%">Category</td>
                <td width="20%">' . $department . '</td>
            </tr>
            <tr>
                <td width="80%">Service request</td>
                <td width="20%">' . $department_object->name . '</td>
            </tr>
            <tr>
                <td width="80%">Priority</td>
                <td width="20%">' . $param_isr->priority . '</td>
            </tr>';

        if ($param_isr->other) {
            $message1 .= '
            <tr>
                <td width="80%">Description</td>
                <td width="20%">' . $param_isr->other . '</td>
            </tr>';
        }

        $message1 .= '
            <tr>
                <td colspan="2" style="text-align:center;"><b>Request reported in</b></td>
            </tr>
            <tr>
                <td width="80%">Floor/Ward</td>
                <td width="20%">' . $feedback_isr_object->ward . '</td>
            </tr>
            <tr>
                <td width="80%">Site</td>
                <td width="20%">' . $feedback_isr_object->bed_no . '</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><b>Request reported by</b></td>
            </tr>
            <tr>
                <td width="80%">Employee name</td>
                <td width="20%">' . $param_isr->name . '</td>
            </tr>
            <tr>
                <td width="80%">Employee ID</td>
                <td width="20%">' . $param_isr->patientid . '</td>
            </tr>
            <tr>
                <td width="80%">Employee role</td>
                <td width="20%">' . $param_isr->role . '</td>
            </tr>
            <tr>
                <td width="80%">Mobile number</td>
                <td width="20%">' . $param_isr->contactnumber . '</td>
            </tr>
             <tr>
                <td width="80%">Source</td>
                <td width="20%">' . $feedback_isr_object->source . '</td>
            </tr>
            <tr>
                <td width="80%">Email ID</td>
                <td width="20%">' . $param_isr->email . '</td>
            </tr>
            <tr>
                <td width="80%">Assigned to</td>
                <td width="20%">' . $department_object->pname . '</td>
            </tr>';



        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_isr_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($tickets_isr_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT

    } else {
        $message2 = $message1;
    }

    if ($tickets_isr_rowcount > 0) {

        $users = get_user_by_sms_activity('ALL-REQUEST-NOTIFICATION-EMAILS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_feedback_esr set admins_emailstatus = 1 WHERE id=' . $feedback_isr_object->id;
    mysqli_query($con, $update_query);
}


//email to  admins(incident) when ticket is OPEN 

$Subject = 'Urgent: Incident reported by an Employee at ' . $hospitalname . ' - Action Required';
$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE admins_emailstatus = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {

    $param_incident = json_decode($feedback_incident_object->dataset);
    $ward_floor = $param_incident->ward;
    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $feedbackid = $feedback_incident_object->id;
    $total_ticket = 0;
    $department = '';
    $message2 = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $admins_incident_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent incident reported by an employee at ' . $hospitalname . '. Below are the incident details: <br /><br />';


        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
         <table border="1" cellpadding="5">
             <tr>
               <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
            </tr>
             <tr>
               <td width="80%">Time & Date</td>
               <td width="20%">' . $created_on . '</td>
             </tr>
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
             </tr>
             <tr>
                 <td width="80%">Incident type</td>
                 <td width="20%">' . $param_incident->incident_type . '</td>
             </tr>
             <tr>
                 <td width="80%">Category</td>
                 <td width="20%">' . $department . '</td>
             </tr>
             <tr>
                 <td width="80%">Incident</td>
                 <td width="20%">' . $department_object->name . '</td>
             </tr>
             <tr>
                 <td width="80%">Priority</td>
                 <td width="20%">' . $param_incident->priority . '</td>
             </tr>';

        if ($param_incident->other) {
            $message1 .= '
             <tr>
                 <td width="80%">Description</td>
                 <td width="20%">' . $param_incident->other . '</td>
             </tr>';
        }

        $message1 .= '
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
             </tr>
             <tr>
                 <td width="80%">Floor/Ward</td>
                 <td width="20%">' . $feedback_incident_object->ward . '</td>
             </tr>
             <tr>
                 <td width="80%">Site</td>
                 <td width="20%">' . $feedback_incident_object->bed_no . '</td>
             </tr>
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
             </tr>
             <tr>
                 <td width="80%">Employee name</td>
                 <td width="20%">' . $param_incident->name . '</td>
             </tr>
             <tr>
                 <td width="80%">Employee ID</td>
                 <td width="20%">' . $param_incident->patientid . '</td>
             </tr>
             <tr>
                 <td width="80%">Employee role</td>
                 <td width="20%">' . $param_incident->role . '</td>
             </tr>
             <tr>
                 <td width="80%">Mobile number</td>
                 <td width="20%">' . $param_incident->contactnumber . '</td>
             </tr>
               <tr>
                <td width="80%">Source</td>
                <td width="20%">' . $feedback_incident_object->source . '</td>
            </tr>
             <tr>
                 <td width="80%">Email ID</td>
                 <td width="20%">' . $param_incident->email . '</td>
             </tr>
             <tr>
                 <td width="80%">Assigned to</td>
                 <td width="20%">' . $department_object->pname . '</td>
             </tr>';

        if ($param_incident->tag_name) {
            $message1 .= '
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
             </tr>
             <tr>
                 <td width="80%">Patient name</td>
                 <td width="20%">' . $param_incident->tag_name . '</td>
             </tr>
             <tr>
                 <td width="80%">Patient ID</td>
                 <td width="20%">' . $param_incident->tag_patientid . '</td>
             </tr>
             <tr>
                 <td width="80%">Patient type</td>
                 <td width="20%">' . $param_incident->tag_patient_type . '</td>
             </tr>
             <tr>
                 <td width="80%">Mobile number</td>
                 <td width="20%">' . $param_incident->tag_consultant . '</td>
             </tr>';
        }

        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_incident_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($tickets_incident_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT

    } else {
        $message2 = $message1;
    }

    if ($tickets_incident_rowcount > 0) {

        $users = get_user_by_sms_activity('ALL-INCIDENT-NOTIFICATION-EMAILS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {

                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_feedback_incident set admins_emailstatus = 1 WHERE id=' . $feedback_incident_object->id;
    mysqli_query($con, $update_query);
}

//email to  admins(grievance) when ticket is OPEN 

$Subject = 'Urgent: Grievance reported by an Employee at ' . $hospitalname . ' - Action Required';
$feedback_grievance_query = 'SELECT * FROM  bf_feedback_grievance  WHERE admins_emailstatus = 0';
$feedback_grievance_result = mysqli_query($con, $feedback_grievance_query);

while ($feedback_grievance_object = mysqli_fetch_object($feedback_grievance_result)) {

    $param_grievance = json_decode($feedback_grievance_object->dataset);
    $ward_floor = $param_grievance->ward;
    $tickets_grievance_query = 'SELECT * FROM  tickets_grievance  inner JOIN department ON department.dprt_id = tickets_grievance.departmentid   WHERE  feedbackid = ' . $feedback_grievance_object->id . ' GROUP BY  department.description';
    $tickets_grievance_result = mysqli_query($con, $tickets_grievance_query);
    $tickets_grievance_rowcount = mysqli_num_rows($tickets_grievance_result);
    $tickets_grievance_generate = false;
    $feedbackid = $feedback_grievance_object->id;
    $total_ticket = 0;
    $department = '';
    $message2 = '';
    while ($tickets_grievance_object = mysqli_fetch_object($tickets_grievance_result)) {

        $tickets_grievance_generate = true;
        $number = $tickets_grievance_object->mobile;
        $department = $tickets_grievance_object->description;
        $department_query = 'SELECT * FROM  tickets_grievance  inner JOIN department ON department.dprt_id = tickets_grievance.departmentid   WHERE  feedbackid = ' . $feedback_grievance_object->id . ' GROUP BY  department.description';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $admins_grievance_link = $config_set['BASE_URL'] . 'grievance/track/' . $TID;

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();

        //message1 will insert when there is only ONE TIKECT
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent grievance reported by an employee at ' . $hospitalname . '. Below are the grievance details: <br /><br />';


        $message1 .= '
         <table border="1" cellpadding="5">
             <tr>
               <td colspan="2" style="text-align:center;"><b>Grievance reported on</b></td>
            </tr>
            <tr>
                <td width="80%">Time & Date</td>
                <td width="20%">' . $created_on . '</td>
             </tr>
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Grievance details</b></td>
             </tr>
         
             <tr>
                 <td width="80%">Category</td>
                 <td width="20%">' . $department . '</td>
             </tr>
             <tr>
                 <td width="80%">Grievance</td>
                 <td width="20%">' . $department_object->name . '</td>
             </tr>';


        if ($param_grievance->other) {
            $message1 .= '
             <tr>
                 <td width="80%">Description</td>
                 <td width="20%">' . $param_grievance->other . '</td>
             </tr>';
        }

        $message1 .= '
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Grievance reported in</b></td>
             </tr>
             <tr>
                 <td width="80%">Floor/Ward</td>
                 <td width="20%">' . $feedback_grievance_object->ward . '</td>
             </tr>
             <tr>
                 <td width="80%">Site</td>
                 <td width="20%">' . $feedback_grievance_object->bed_no . '</td>
             </tr>
             <tr>
                 <td colspan="2" style="text-align:center;"><b>Grievance reported by</b></td>
             </tr>
             <tr>
                 <td width="80%">Employee name</td>
                 <td width="20%">' . $param_grievance->name . '</td>
             </tr>
             <tr>
                 <td width="80%">Employee ID</td>
                 <td width="20%">' . $param_grievance->patientid . '</td>
             </tr>
             <tr>
                 <td width="80%">Employee role</td>
                 <td width="20%">' . $param_grievance->role . '</td>
             </tr>
             <tr>
                 <td width="80%">Mobile number</td>
                 <td width="20%">' . $param_grievance->contactnumber . '</td>
             </tr>
             
             <tr>
                 <td width="80%">Email ID</td>
                 <td width="20%">' . $param_grievance->email . '</td>
             </tr>
             <tr>
                 <td width="80%">Assigned to</td>
                 <td width="20%">' . $department_object->pname . '</td>
             </tr>';



        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $admins_grievance_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
    }

    if ($tickets_grievance_rowcount > 1) {
        //message2 will insert when there is  MULTIPLE TIKECT

    } else {
        $message2 = $message1;
    }

    if ($tickets_grievance_rowcount > 0) {

        $users = get_user_by_sms_activity('ALL-GRIEVANCE-NOTIFICATION-EMAILS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {

                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message2) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                $conn_g->query($query);
            }
        }
    }
    $update_query = 'Update bf_feedback_grievance set admins_emailstatus = 1 WHERE id=' . $feedback_grievance_object->id;
    mysqli_query($con, $update_query);
}


//escalation level 1 and level 2 email to  admins(interim) when ticket is OPEN  
//L1 and L2 escalation message
function escalation_int_generateUniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID
    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters
    return $id;
}

$escalation_query = 'SELECT * FROM `escalation` WHERE section="INTERIM"';
$escalation_object = mysqli_fetch_object(mysqli_query($con, $escalation_query));

//when escalation is not enabled
if ($escalation_object->status != 'ACTIVE') {

    $feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';
    $feedback_int_result = mysqli_query($con, $feedback_int_query);
    while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

        $update_query = 'Update bf_feedback_int set escilationstatus_email = -1 WHERE id=' . $feedback_int_object->id;
        mysqli_query($con, $update_query);
    }
}

//when sms button is turn off in escalation page
if ($escalation_object->level1_sms_alert == 'NO' || $escalation_object->level2_sms_alert == 'NO') {

    $feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';
    $feedback_int_result = mysqli_query($con, $feedback_int_query);
    while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

        $update_query = 'Update bf_feedback_int set escilationstatus_email = -1 WHERE id=' . $feedback_int_object->id;
        mysqli_query($con, $update_query);
    }
}

//when escalation is enabled
$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE escilationstatus_email = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);
while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

    $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
    $tickets_int_result = mysqli_query($con, $tickets_int_query);
    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {

        $tickets_generate = true;
        $number = $tickets_int_object->mobile;
        $department = $tickets_int_object->description;
        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND department.description="' . $tickets_int_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $TID = $department_object->id;
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        date_default_timezone_set("Asia/Calcutta");

        $escilate_level_one_time = date("Y-m-d H:i:s", strtotime("+" . $tickets_int_object->close_time . " seconds"));
        $escilate_level_two_time = date("Y/m/d H:i:s", strtotime("+" . $tickets_int_object->close_time_l2 . " seconds"));
        $sql1 = 'SELECT mobile,email FROM user where user_id IN (' . implode(",", json_decode($escalation_object->level1_escalate_to)) . ')';
        $sql2 = 'SELECT mobile,email FROM user where user_id IN (' . implode(",", json_decode($escalation_object->level2_escalate_to)) . ')';
        $escilate_level_one_to = mysqli_query($con, $sql1);
        $escilate_to_one = array();
        $escilate_to_two = array();
        while ($e1 = mysqli_fetch_object($escilate_level_one_to)) {
            $escilate_to_one[] = $e1;
        }
        $escilate_level_tow_to = mysqli_query($con, $sql2);
        while ($e1 = mysqli_fetch_object($escilate_level_tow_to)) {
            $escilate_to_two[] = $e1;
        }


        $admins_int_link = $config_set['BASE_URL'] . 'pc/track/' . $TID;

        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['ticket'] = $tickets_int_object;
        $meta_data['link'] = $config_set['BASE_URL'] . 'pc/track/' . $TID;

        $Subject1 = 'Urgent: Level 1 Escalation - Unresolved Inpatient Complaint at ' . $hospitalname . '(Complaint ID: ' . $department_object->id . ')';
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We must bring to your immediate attention a Level 1 Escalation regarding an unresolved inpatient complaint at  ' . $hospitalname . '.This issue has exceeded the TAT limit and requires urgent action. Here are the details you need: <br /><br />';
        $message1 .= '<strong>Complaint ID:</strong> PCT-' . $department_object->id . ' <br />';
        $message1 .= '<strong>Patient Name: </strong>' . $param_int->name . ' <br />';
        $message1 .= '<strong>UHID: </strong>' . $param_int->patientid . '<br />';
        $message1 .= '<strong>Floor/Ward:</strong> ' . $feedback_int_object->ward . ' <br />';
        $message1 .= '<strong>Room/Bed No:</strong> ' . $feedback_int_object->bed_no . '<br />';
        $message1 .= '<strong>Source:</strong> ' . $feedback_int_object->source . '<br />';
        $message1 .= '<strong>Assigned To:</strong> ' . $department_object->pname . ' <br />';
        $message1 .= '<strong>Created on:</strong> ' . $created_on . ' <br />';
        $message1 .= '<strong>Department:</strong> ' . $department . ' <br />';
        $message1 .= '<strong>Parameter: </strong>' . $department_object->name . '';

        $setup_query = "SELECT * FROM setup_int WHERE parent = 0 ";
        $setup_result = mysqli_query($con, $setup_query);
        while ($setup_object = mysqli_fetch_object($setup_result)) {

            $keys[$setup_object->shortkey] = $setup_object->title;
            $res[$setup_object->shortkey] = $setup_object->question;
            $titles[$setup_object->title] = $setup_object->title;
            $zz[$setup_object->type] = $setup_object->title;
        }

        if ($param_int->comment && !empty($param_int->comment)) {

            foreach ($param_int->comment as $key2 => $value) {
                $message1 .= "<br /><strong> Comment: </strong>" . $value . " ";
            }
        }

        $message1 .= '<br /><br />To review the complete information and take the necessary actions, please click the link below:<br />' . $admins_int_link . '<br /><br />';
        $message1 .= 'Your swift action on this matter is vital to ensure our commitment to delivering the highest standard of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';

        foreach ($escilate_to_one as $e1) {

            $query = 'INSERT INTO `notification_escilation`
                    (`type`, `message`, `status`, `mobile_email`,`subject`,`template_id` ,`HID`,`sheduled_at`,meta,`uuid`)
                    VALUES 
                    ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $e1->email . '","' . $conn_g->real_escape_string($Subject1) . '","1607100000000284568","' . $HID . '","' . $escilate_level_one_time . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
            $conn_g->query($query);
        }

        $Subject2 = 'Urgent: Level 2 Escalation - Unresolved Inpatient Complaint at ' . $hospitalname . '(Complaint ID: ' . $department_object->id . ')';
        $message2 = 'Dear Team, <br /><br />';
        $message2 .= 'We must bring to your immediate attention a Level 2 Escalation regarding an unresolved inpatient complaint at  ' . $hospitalname . '.This issue has exceeded the TAT limit and requires urgent action. Here are the details you need: <br /><br />';
        $message2 .= '<strong>Complaint ID:</strong> PCT-' . $department_object->id . ' <br />';
        $message2 .= '<strong>Patient Name: </strong>' . $param_int->name . ' <br />';
        $message2 .= '<strong>UHID: </strong>' . $param_int->patientid . '<br />';
        $message2 .= '<strong>Floor/Ward:</strong> ' . $feedback_int_object->ward . ' <br />';
        $message2 .= '<strong>Room/Bed No:</strong> ' . $feedback_int_object->bed_no . '<br />';
        $message2 .= '<strong>Source:</strong> ' . $feedback_int_object->source . '<br />';
        $message2 .= '<strong>Assigned To:</strong> ' . $department_object->pname . ' <br />';
        $message2 .= '<strong>Created on:</strong> ' . $created_on . ' <br />';
        $message2 .= '<strong>Department:</strong> ' . $department . ' <br />';
        $message2 .= '<strong>Parameter: </strong>' . $department_object->name . '';
        $setup_query = "SELECT * FROM setup_int WHERE parent = 0 ";
        $setup_result = mysqli_query($con, $setup_query);

        while ($setup_object = mysqli_fetch_object($setup_result)) {

            $keys[$setup_object->shortkey] = $setup_object->title;
            $res[$setup_object->shortkey] = $setup_object->question;
            $titles[$setup_object->title] = $setup_object->title;
            $zz[$setup_object->type] = $setup_object->title;
        }

        if ($param_int->comment && !empty($param_int->comment)) {

            foreach ($param_int->comment as $key2 => $value) {
                $message2 .= "<br /><strong> Comment: </strong>" . $value . " ";
            }
        }

        $message2 .= '<br /><br />To review the complete information and take the necessary actions, please click the link below:<br />' . $admins_int_link . '<br /><br />';
        $message2 .= 'Your swift action on this matter is vital to ensure our commitment to delivering the highest standard of care and service to our patients.';
        $message2 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';

        foreach ($escilate_to_two as $e2) {
            $query = 'INSERT INTO `notification_escilation`
						(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`subject`,`sheduled_at`,meta,`uuid`)
						VALUES 
						("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $e2->email . '","1607100000000284569","' . $HID . '","' . $conn_g->real_escape_string($Subject2) . '","' . $escilate_level_two_time . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
            $conn_g->query($query);
        }
    }

    $update_query = 'Update bf_feedback_int set escilationstatus_email = 1 WHERE id=' . $feedback_int_object->id;
    mysqli_query($con, $update_query);
}


print_r($message2);
$conn_g->close();
$con->close();
echo 'admin email end';
