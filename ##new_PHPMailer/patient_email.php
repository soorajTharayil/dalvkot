<?php

include('../api/db.php');
include('/home/efeedor/globalconfig.php');
include('email_template_helper.php');

// Ensure UTF-8 encoding for database connections
if (method_exists($conn_g, 'set_charset')) {
    $conn_g->set_charset('utf8mb4');
} else {
    //$conn_g->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
}

//welcome email to patient with interim link
$welcome_message_query = 'SELECT * FROM patients_from_admission WHERE email_status = 0';
$welcome_message_result = mysqli_query($con, $welcome_message_query);
while ($welcome_message_object = mysqli_fetch_object($welcome_message_result)) {

    $name = $welcome_message_object->name;
    $guid = $welcome_message_object->guid;

    $interim_link = $config_set['BASE_URL'] . 'pcf/?patient_id=' . $guid;

    // Use template
    $emailData = EmailTemplateHelper::render('patient.welcome', [
        'name' => $name,
        'hospitalname' => $hospitalname,
        'interim_link' => $interim_link
    ]);

    // Insert notification with proper encoding
    EmailTemplateHelper::insertNotification(
        $conn_g,
        'email',
        $emailData['body'],
        $welcome_message_object->email,
        $emailData['subject'],
        $HID
    );

    $update_query = 'UPDATE patients_from_admission SET email_status = 1 WHERE id=' . $welcome_message_object->id;
    mysqli_query($con, $update_query);
}

//discharge email to patient with ip link
$discharge_message_query = 'SELECT * FROM `patient_discharge` WHERE  email_status = 0';
$discharge_message_result = mysqli_query($con, $discharge_message_query);
while ($discharge_message_object = mysqli_fetch_object($discharge_message_result)) {

    $name = $discharge_message_object->name;
    $guid = $discharge_message_object->guid;
    $ip_link = $config_set['BASE_URL'] . 'ip/?patient_id=' . $guid;

    // Use template
    $emailData = EmailTemplateHelper::render('patient.discharge', [
        'name' => $name,
        'hospitalname' => $hospitalname,
        'ip_link' => $ip_link
    ]);

    // Insert notification with proper encoding
    EmailTemplateHelper::insertNotification(
        $conn_g,
        'email',
        $emailData['body'],
        $discharge_message_object->email,
        $emailData['subject'],
        $HID
    );

    $update_query = 'UPDATE patient_discharge SET `email_status` = 1 WHERE id=' . $discharge_message_object->id;
    mysqli_query($con, $update_query);
}

//ip emails to patient
// $feedback_query = 'SELECT * FROM  bf_feedback  WHERE emailstatus = 0';
// $feedback_result = mysqli_query($con, $feedback_query);
// while ($feedback_object = mysqli_fetch_object($feedback_result)) {
//     $param_ip = json_decode($feedback_object->dataset);

//     $email = $param_ip->email;
//     $name = $param_ip->name;

//     print_r($email);
//     $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
//     $tickets_result = mysqli_query($con, $tickets_query);
//     $tickets_rowcount = mysqli_num_rows($tickets_result);


//     $tickets_generate = false;
//     $total_ticket = 0;
//     $department = '';
//     $message1 = '';

//     while ($tickets_object = mysqli_fetch_object($tickets_result)) {

//         $tickets_generate = true;
//         $department = $tickets_object->description;
//         $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND department.description="' . $tickets_object->description . '"';
//         $department_result = mysqli_query($con, $department_query);
//         $department_rowcount = mysqli_num_rows($department_result);
//         $department_object = mysqli_fetch_object($department_result);
//         if ($department_rowcount > 1) {
//             $k = 1;
//         } else {
//             $k = '';
//         }
//     }

//     if ($tickets_generate == false) {
//         //google review email
//         $Subject = 'Rate ' . $hospitalname . ' on Google';
//         $message1 = 'Dear <strong>' . $name . '</strong>, <br /><br />';
//         $message1 .= 'Thank you for taking the time to provide feedback about your experience at ' . $hospitalname . '. Your satisfaction is our top priority, and we genuinely appreciate your valuable input.<br /><br />';
//         $message1 .= 'To further assist us in spreading the word about the positive experiences our patients have, we kindly request you to share your thoughts on Google by clicking the link below:<br /><br />';
//         $message1 .= '<a href="' . $slink . '">Click here</a><br /><br />';
//         $message1 .= 'Your rating and comments will not only help us understand the aspects you found beneficial but will also guide other patients in choosing ' . $hospitalname . ' for their healthcare needs.<br /><br />';
//         $message1 .= 'Once again, thank you for choosing ' . $hospitalname . '. We are grateful for the opportunity to serve you<br /><br />';
//         $message1 .= '<strong>Best Regards,</strong><br /><br />' . $hospitalname . ' ';
//     } else {
//         //negative email
//         $Subject = 'Your Feedback Matters: Commitment to Improvement at ' . $hospitalname . '';
//         $message1 = 'Dear <strong>' . $name . '</strong>, <br /><br />';
//         $message1 .= 'Thank you for taking the time to submit your feedback at ' . $hospitalname . '. We sincerely apologize for any inconvenience you may have experienced in certain areas of our services. Your satisfaction is our utmost priority, and we genuinely appreciate your valuable input.<br /><br />';
//         $message1 .= 'Your ratings and comments are essential to us, as they not only help us understand your concerns but also contribute to building a better environment that ensures high patient satisfaction and safety.<br /><br />';
//         $message1 .= 'Once again, we apologize for any inconvenience caused and appreciate your understanding. Thank you for choosing Suyog Hospital. We are grateful for the opportunity to serve you, and your feedback is instrumental in our continuous efforts to provide excellent healthcare services.<br /><br />';
//         $message1 .= '<strong>Best Regards,</strong><br /><br />' . $hospitalname . ' ';
//     }
//     $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
//     $conn_g->query($query);

//     $update_query = 'Update bf_feedback set emailstatus = 1 WHERE id=' . $feedback_object->id;
//     mysqli_query($con, $update_query);
// }


// $outfeedback_query = 'SELECT * FROM  bf_outfeedback  WHERE emailstatus = 0';
// $outfeedback_result = mysqli_query($con, $outfeedback_query);
// while ($outfeedback_object = mysqli_fetch_object($outfeedback_result)) {

//     $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $outfeedback_object->id . ' GROUP BY  department.description';
//     $ticketsop_result = mysqli_query($con, $ticketsop_query);
//     $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);

//     $opatient_query = 'SELECT * FROM  bf_opatients  WHERE id = "' . $outfeedback_object->pid . '"';
//     $opatient_result = mysqli_query($con, $opatient_query);
//     $opatient_object = mysqli_fetch_object($opatient_result);
//     $number = $opatient_object->mobile;

//     $tickets_generate = false;
//     $total_ticket = 0;
//     $department = '';
//     $message = '';

//     while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {

//         $tickets_generate = true;
//         $department = $ticketsop_object->description;
//         $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $outfeedback_object->id . ' AND department.description="' . $ticketsop_object->description . '"';
//         $department_result = mysqli_query($con, $department_query);
//         $department_rowcount = mysqli_num_rows($department_result);
//         $department_object = mysqli_fetch_object($department_result);
//         if ($department_rowcount > 1) {
//             $k = 1;
//         } else {
//             $k = '';
//         }
//     }

//     if ($tickets_generate == false) {
//         //google review email
//         $Subject = 'Rate ' . $hospitalname . ' on Google';
//         $message1 = 'Dear <strong>' . $name . '</strong>, <br /><br />';
//         $message1 .= 'Thank you for taking the time to provide feedback about your experience at ' . $hospitalname . '. Your satisfaction is our top priority, and we genuinely appreciate your valuable input.<br /><br />';
//         $message1 .= 'To further assist us in spreading the word about the positive experiences our patients have, we kindly request you to share your thoughts on Google by clicking the link below:<br /><br />';
//         $message1 .= '<a href="' . $slink . '">Click here</a><br /><br />';
//         $message1 .= 'Your rating and comments will not only help us understand the aspects you found beneficial but will also guide other patients in choosing ' . $hospitalname . ' for their healthcare needs.<br /><br />';
//         $message1 .= 'Once again, thank you for choosing ' . $hospitalname . '. We are grateful for the opportunity to serve you<br /><br />';
//         $message1 .= '<strong>Best Regards,</strong><br /><br />' . $hospitalname . ' ';
//     } else {
//         //negative email
//         $Subject = 'Your Feedback Matters: Commitment to Improvement at ' . $hospitalname . '';
//         $message1 = 'Dear <strong>' . $name . '</strong>, <br /><br />';
//         $message1 .= 'Thank you for taking the time to submit your feedback at ' . $hospitalname . '. We sincerely apologize for any inconvenience you may have experienced in certain areas of our services. Your satisfaction is our utmost priority, and we genuinely appreciate your valuable input.<br /><br />';
//         $message1 .= 'Your ratings and comments are essential to us, as they not only help us understand your concerns but also contribute to building a better environment that ensures high patient satisfaction and safety.<br /><br />';
//         $message1 .= 'Once again, we apologize for any inconvenience caused and appreciate your understanding. Thank you for choosing Suyog Hospital. We are grateful for the opportunity to serve you, and your feedback is instrumental in our continuous efforts to provide excellent healthcare services.<br /><br />';
//         $message1 .= '<strong>Best Regards,</strong><br /><br />' . $hospitalname . ' ';
//     }
//     $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
//     $conn_g->query($query);

//     $update_query = 'Update bf_outfeedback set emailstatus = 1 WHERE id=' . $outfeedback_object->id;
//     mysqli_query($con, $update_query);
// }


// $feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE emailstatus = 0';
// $feedback_int_result = mysqli_query($con, $feedback_int_query);
// while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

//     $param_int = json_decode($feedback_int_object->dataset);
//     $email = $param_int->email;
//     $name = $param_int->name;

//     $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
//     $tickets_int_result = mysqli_query($con, $tickets_int_query);
//     $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);

//     $patient_query = 'SELECT * FROM  bf_patients  WHERE id = "' . $feedback_int_object->pid . '"';
//     $patient_result = mysqli_query($con, $patient_query);
//     $patient_object = mysqli_fetch_object($patient_result);
//     $number = $patient_object->mobile;

//     $tickets_generate = false;
//     $total_ticket = 0;
//     $department = '';
//     $message = '';
//     while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {
//         $tickets_generate = true;
//         $department = $tickets_int_object->description;
//         $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND department.description="' . $tickets_int_object->description . '"';
//         $department_result = mysqli_query($con, $department_query);
//         $department_rowcount = mysqli_num_rows($department_result);
//         $department_object = mysqli_fetch_object($department_result);
//         if ($department_rowcount > 1) {
//             $k = 1;
//         } else {
//             $k = '';
//         }


//         $TID = $department_object->id;

//         $pcf_link = $config_set['BASE_URL'] . 'track/pc/' . $TID;

//         $Subject = 'Acknowledgment of Your Concern at ' . $hospitalname . '';
//         $message1 = 'Dear <strong>' . $name . '</strong>, <br /><br />';
//         $message1 .= 'Thank you for bringing your concern to our attention at ' . $hospitalname . '. Your well-being is our top priority, and we are committed to addressing your request promptly.<br /><br />';
//         $message1 .= 'To track the status of your concern and stay updated on its progress, please use the following link:<br /><br />';
//         $message1 .= '<a href="' . $pcf_link . '">Click here</a><br /><br />';
//         $message1 .= '<strong>Best Regards,</strong><br /><br />' . $hospitalname . ' ';

//         $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
//         $conn_g->query($query);

//         $update_query = 'Update bf_feedback_int set emailstatus = 1 WHERE id=' . $feedback_int_object->id;
//         mysqli_query($con, $update_query);
//     }
// }


$conn_g->close();
$con->close();
