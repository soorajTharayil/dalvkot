<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//email to department head(ip) when ticket is OPEN            
//email to department head(op) when ticket is OPEN            
//email to department head(interim) when ticket is OPEN       
//email to  department head(isr) when ticket is OPEN          

include('../api/db.php');
include('/var/www/html/globalconfig.php');
include('get_user.php');
//email to department head  when they are created 

$user_query = 'SELECT * FROM `user` WHERE `departmenthead_email` = 0  AND `user_role` = 4';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $permission = json_decode($user_object->departmentpermission);

    $email = $user_object->email;
    $password = $permission->password;
    $name = $user_object->firstname;

    $Subject = 'Welcome to Efeedor - Your Account is Now Active!';
    $message1 = 'Dear ' . $name . ', <br /><br />';
    $message1 .= 'We are delighted to welcome you aboard! <br /><br />';
    $message1 .= 'Your account is now active on Efeedor Healthcare Experience Management Software at  <b>' . $hospitalname . '</b> . You can now access the dashboard to review concerns raised for your departments, take relevant actions, and receive alerts to ensure smooth service resolution. <br /><br />';
    $message1 .= 'Getting Started: <br /><br />';
    $message1 .= 'Access the Dashboard: ' . $link . ' <br /><br />';
    $message1 .= 'Username: ' . $email . ' <br />';
    $message1 .= 'Default Password: ' . $password . ' <br /><br />';
    $message1 .= 'Important: For security purposes, please update your default password in the "Edit Profile" section at the top-right of your dashboard. <br /><br />';
    $message1 .= 'To familiarize yourself with the application and understand how to address concerns efficiently, we recommend reviewing the guide below: <br />';
    $message1 .= 'Ticket Closing Guide: https://rebrand.ly/Efeedor_Ticket_Closing_Guide  <br /><br />';
    $message1 .= 'If you have any questions or need assistance, feel free to reach out to your Software Admin. <br /><br />';
    $message1 .= 'Welcome aboard — we look forward to your journey with Efeedor! <br /><br />';
    $message1 .= 'Best regards, <br /><br />';
    $message1 .= $hospitalname;

    $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
    $conn_g->query($query);

    $query = 'UPDATE user SET `departmenthead_email` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

$user_query = 'SELECT * FROM `user` WHERE `patient_coordinator_email` = 0  AND `user_role` = 8';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $permission = json_decode($user_object->departmentpermission);

    $email = $user_object->email;
    $password = $permission->password;
    $name = $user_object->firstname;

    $Subject = 'Welcome to Efeedor - Your Account is Now Active!';
    $message1 = 'Dear ' . $name . ', <br /><br />';
    $message1 .= 'We are delighted to welcome you aboard! <br /><br />';
    $message1 .= 'Your account is now active on Efeedor Healthcare Experience Management Software at <b>' . $hospitalname . '</b>  You can now collect patient feedback using the Efeedor Mobile App with the credentials provided below: <br /><br />';
    $message1 .= 'Username: ' . $email . ' <br />';
    $message1 .= 'Default Password: ' . $password . ' <br /><br />';
    $message1 .= 'Alternatively, you can use the following link and the same credentials to log in and record data: <br /><br />';
    $message1 .= 'Web Link: <a href="' . $link . '/form_login">' . $link . '/form_login</a> <br /><br />';
    $message1 .= 'Learn How to Collect Patient Feedback <br /><br />';
    $message1 .= 'To familiarize yourself with collecting patient feedback, complaints, and requests, we recommend reviewing the manuals below: <br />';
    $message1 .= 'Patient Feedback System Manual:  <br />';
    $message1 .= 'https://rebrand.ly/Efeedor_Patient_Feedback_System_Manual <br />';
    $message1 .= 'Patient Complaint System Manual:  <br />';
    $message1 .= 'https://rebrand.ly/Efeedor_Patient_Compliant_System_Manual<br />';
    $message1 .= 'If you have any questions or need assistance, feel free to reach out to your Software Admin. <br /><br />';
    $message1 .= 'Welcome aboard — we look forward to your journey with Efeedor! <br /><br />';
    $message1 .= 'Best regards, <br /><br />';
    $message1 .= $hospitalname;

    $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
    $conn_g->query($query);

    $query = 'UPDATE user SET `departmenthead_email` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

$user_query = 'SELECT * FROM `user` WHERE `departmenthead_email` = 0  AND `user_role` = 10';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $permission = json_decode($user_object->departmentpermission);

    $email = $user_object->email;
    $password = $permission->password;
    $name = $user_object->firstname;

    $Subject = ' Welcome to Efeedor - Your Account is Now Active!';
    $message1 = 'Dear ' . $name . ', <br /><br />';
    $message1 .= 'We are delighted to welcome you aboard! <br /><br />';
    $message1 .= 'Your account is now active on Efeedor Healthcare Experience Management Software at <b>' . $hospitalname . '</b> .You can now raise concerns such as internal service requests and incident reports using the link below: <br /><br />';
    $message1 .= 'Web Link: <a href="' . $link . '/form_login">' . $link . '/form_login</a> <br /><br />';
    $message1 .= 'Username: ' . $email . ' <br />';
    $message1 .= 'Default Password: ' . $password . ' <br /><br />';
    $message1 .= 'Alternatively, you can also use the Efeedor Android mobile app with the same credentials to log in, record data, and monitor activity on the go. <br /><br />';
    $message1 .= 'To familiarize yourself with submitting internal service requests, reporting incidents, and collecting feedback, we recommend reviewing the manuals below: <br />';
    $message1 .= 'Internal Service Request Manual:  <br />';
    $message1 .= 'https://rebrand.ly/Efeedor_Internal_Service_Request_Manual <br />';
    $message1 .= 'Incident Reporting System Manual: <br />';
    $message1 .= 'https://rebrand.ly/Efeedor_Incident_Reporting_System_Manual <br />';
    $message1 .= 'If you have any questions or need assistance, feel free to reach out to your Software Admin. <br /><br />';
    $message1 .= 'Welcome aboard — we look forward to your journey with Efeedor! <br /><br />';
    $message1 .= 'Best regards, <br /><br />';
    $message1 .= $hospitalname;

    $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_object->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
    $conn_g->query($query);

    $query = 'UPDATE user SET `departmenthead_email` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

//email to department head(interim) when ticket is OPEN  
echo 'hi';
$Subject = 'Urgent: Complaint reported by InPatient at ' . $hospitalname . ' - Action Required';
$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE departmenthead_emailstatus = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);

while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

    $param_int = json_decode($feedback_int_object->dataset);

    $ward_floor = $param_int->ward ?? null;

    $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
    $tickets_int_result = mysqli_query($con, $tickets_int_query);
    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);
    $tickets_int_generate = false;
    $total_int_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {

        $tickets_int_generate = true;
        $number = $tickets_int_object->mobile;
        $department = $tickets_int_object->description;
        echo 'nn';
        echo 'mm';
        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND department.description="' . $tickets_int_object->description . '"';
        echo 'oo';

        $department_result = mysqli_query($con, $department_query);
        echo 'pp';

        $department_rowcount = mysqli_num_rows($department_result);
        echo 'qq';

        $department_object = mysqli_fetch_object($department_result);
        echo 'rr';

      
        echo 'vv';

        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        echo 'zz';

        $TID = $department_object->id;
        echo 'xx';

        $department_head_link = $config_set['BASE_URL'] . 'pc/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        echo 'la';
        $message1 = 'Dear Team, <br /><br />';
        echo 'ba';

        $message1 .= 'We would like to bring to your attention a recent complaint reported by an inpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';

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
                <td width="80%">Source</td>
                <td width="20%">' . $feedback_int_object->source . '</td>
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
                <td width="80%">Assigned to</td>
                <td width="20%">' . $department_object->pname . '</td>
            </tr>';



        $message1 .= '</table>';


        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        $user_list = get_user_by_question($tickets_int_object->slug, $con);
        echo 'mooo';
        foreach ($user_list as $row) {
            $floor_wards = json_decode($row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('PCF-EMAIL-DEPTHEAD', $con);
                if (!empty($users_dept)) {
                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($row->email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                    $conn_g->query($query1);

                    // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($tickets_int_object->alternate_email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                    // $conn_g->query($query2);
                }
            }
        }
        echo 'naa';
    }

    echo 'bo';

    $update_query = 'Update bf_feedback_int set departmenthead_emailstatus = 1 WHERE id=' . $feedback_int_object->id;
    mysqli_query($con, $update_query);
}

//email to department head(ip) when ticket is OPEN  

$Subject = 'Alert: Negative feedback Report from Discharged Inpatient at ' . $hospitalname . ' - Action Required';
$feedback_query = 'SELECT * FROM  bf_feedback  WHERE departmenthead_emailstatus = 0';
$feedback_result = mysqli_query($con, $feedback_query);

while ($feedback_object = mysqli_fetch_object($feedback_result)) {

    $param_ip = json_decode($feedback_object->dataset);
    $ward_floor = $param_ip->ward;
    $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
    $tickets_result = mysqli_query($con, $tickets_query);
    $tickets_rowcount = mysqli_num_rows($tickets_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_object = mysqli_fetch_object($tickets_result)) {

        $tickets_generate = true;
        $number = $tickets_object->mobile;
        $department = $tickets_object->description;
        $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND department.description="' . $tickets_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();

        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'ipd/track/' . $TID;   //pointing to public_html/ticket

        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent negative feedback reported by a Discharged Inpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';
        $message1 .= '<strong>Ticket ID:</strong> IPDT-' . $department_object->id . ' <br />';
        $message1 .= '<strong>Patient Name: </strong>' . $param_ip->name . ' <br />';
        $message1 .= '<strong>UHID: </strong>' . $param_ip->patientid . ' <br />';
        $message1 .= '<strong>Floor/Ward:</strong> ' . $feedback_object->ward . ' <br />';
        $message1 .= '<strong>Source:</strong> ' . $feedback_object->source . ' <br />';
        $message1 .= '<strong>Room/Bed No:</strong> ' . $feedback_object->bed_no . '<br />';
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


        $message1 .= '<br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';


        $user_list = get_user_by_question($tickets_object->slug, $con);

        foreach ($user_list as $user_row) {
            $floor_wards = json_decode($user_row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('IP-EMAIL-DEPTHEAD', $con);
                if (!empty($users_dept)) {
                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($user_row->email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                    $conn_g->query($query1);

                    // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($message1) . '",0,"' . $conn_g->real_escape_string($tickets_object->alternate_email) . '","' . $conn_g->real_escape_string($Subject) . '","' . $HID . '")';
                    // $conn_g->query($query2);
                    // $conn_g->query($query2);
                }
            }
        }
    }

    $update_query = 'Update bf_feedback set departmenthead_emailstatus = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);
}

//email to department head(op) when ticket is OPEN  

$Subject = 'Alert: Negative feedback Report from  Outpatient at ' . $hospitalname . ' - Action Required';
$feedbackop_query = 'SELECT * FROM  bf_outfeedback  WHERE departmenthead_emailstatus = 0';
$feedbackop_result = mysqli_query($con, $feedbackop_query);

while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {
    $param_op = json_decode($feedbackop_object->dataset);
    $ward_floor = $param_op->ward;

    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' GROUP BY  department.description';
    $ticketsop_result = mysqli_query($con, $ticketsop_query);
    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);
    $ticketsop_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {

        $ticketsop_generate = true;
        $number = $ticketsop_object->mobile;
        $department = $ticketsop_object->description;
        $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' AND department.description="' . $ticketsop_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();

        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'opf/track/' . $TID;   //pointing to public_html/ticket

        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent negative feedback reported by a  Outpatient at ' . $hospitalname . '. Below are the ticket details: <br /><br />';
        $message1 .= '<strong>Ticket ID:</strong> OPT-' . $department_object->id . ' <br />';
        $message1 .= '<strong>Patient Name: </strong>' . $param_op->name . ' <br />';
        $message1 .= '<strong>UHID: </strong>' . $param_op->patientid . '<br />';
        $message1 .= '<strong>Speciality:</strong> ' . $feedbackop_object->ward . ' <br />';
        $message1 .= '<strong>Source:</strong> ' . $feedbackop_object->source . ' <br />';

        $message1 .= '<strong>Assigned To:</strong> ' . $department_object->pname . ' <br />';
        $message1 .= '<strong>Department:</strong> ' . $department . ' <br />';
        $message1 .= '<strong>Parameter: </strong>' . $department_object->name . '';
        if ($department_rowcount == 1) {


            $setup_query = "SELECT * FROM setupop WHERE parent = 0 ";
            $setup_result = mysqli_query($con, $setup_query);

            while ($setup_object = mysqli_fetch_object($setup_result)) {

                $keys[$setup_object->shortkey] = $setup_object->title;
                $res[$setup_object->shortkey] = $setup_object->question;
                $titles[$setup_object->title] = $setup_object->title;
                $zz[$setup_object->type] = $setup_object->title;
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
        $message1 .= '<br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        $user_list = get_user_by_question($ticketsop_object->slug, $con);
        foreach ($user_list as $row) {
            $floor_wards = json_decode($row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            $users_dept = get_user_by_sms_activity('OP-EMAIL-DEPTHEAD', $con);
            if (!empty($users_dept)) {
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($row->email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                $conn_g->query($query1);

                // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($ticketsop_object->alternate_email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                // $conn_g->query($query2);
            }

        }
    }

    $update_query = 'Update bf_outfeedback set departmenthead_emailstatus = 1 WHERE id=' . $feedbackop_object->id;
    mysqli_query($con, $update_query);
}



//email to department head(isr) when ticket is OPEN  

$Subject = 'Urgent: Service Request reported by an Employee at ' . $hospitalname . ' - Action Required';
$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE departmenthead_emailstatus = 0';
$feedback_isr_result = mysqli_query($con, $feedback_isr_query);

while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {
    $param_isr = json_decode($feedback_isr_object->dataset);
    $ward_floor = $param_isr->ward;

    $tickets_isr_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' GROUP BY  department.description';
    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);
    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);
    $tickets_isr_generate = false;
    $total_isr_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {

        $tickets_isr_generate = true;
        $number = $tickets_isr_object->mobile;
        $department = $tickets_isr_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND department.description="' . $tickets_isr_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'isr/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
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
                  <td width="80%">Email ID</td>
                  <td width="20%">' . $param_isr->email . '</td>
              </tr>
              <tr>
                  <td width="80%">Assigned to</td>
                  <td width="20%">' . $department_object->pname . '</td>
              </tr>';



        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        $user_list = get_user_by_question($tickets_isr_object->slug, $con);
        foreach ($user_list as $row) {
            $floor_wards = json_decode($row->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('ISR-EMAIL-DEPTHEAD', $con);
                if (!empty($users_dept)) {
                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($row->email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                    $conn_g->query($query1);

                    // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($tickets_isr_object->alternate_email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                    // $conn_g->query($query2);
                }
            }
        }
    }

    $update_query = 'Update bf_feedback_esr set departmenthead_emailstatus = 1 WHERE id=' . $feedback_isr_object->id;
    mysqli_query($con, $update_query);
}

//email to department head(incident) when ticket is OPEN  

$Subject = 'Urgent: Incident reported by an Employee at ' . $hospitalname . ' - Action Required';
$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE departmenthead_emailstatus = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {

    $param_incident = json_decode($feedback_incident_object->dataset);
    $ward_floor = $param_incident->ward;

    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $total_incident_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent incident reported by an employee at ' . $hospitalname . '. Below are the incident details: <br /><br />';


        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
          <table border="1" cellpadding="5">
              <tr>
                <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
             </tr>
              <tr>
                <td width="40%">Time & Date</td>
                <td width="60%">' . $created_on . '</td>
              </tr>
              <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
             </tr>
              <tr>
                 <td width="40%">Incident</td>
                 <td width="60%">' . $department_object->name . '</td>
             </tr>
              <tr>
                 <td width="40%">Category</td>
                 <td width="60%">' . $department . '</td>
             </tr>
              <tr>
                 <td width="40%">Incident Occured On</td>
                 <td width="60%">' . $department_object->incident_occured_in . '</td>
             </tr>
            
              <tr>
                 <td width="40%">Assigned Risk</td>
                 <td width="60%">' . $param_incident->risk_matrix->level . '</td>
             </tr>
              <tr>
                 <td width="40%">Assigned Priority</td>
                 <td width="60%">' . $param_incident->priority . '</td>
             </tr>
             <tr>
                 <td width="40%">Assigned Severity</td>
                 <td width="60%">' . $param_incident->incident_type . '</td>
             </tr>
            
            ';

        if ($param_incident->other) {
            $message1 .= '
              <tr>
                  <td width="40%">Description</td>
                  <td width="60%">' . $param_incident->other . '</td>
              </tr>';
        }

        $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
              </tr>
              <tr>
                  <td width="40%">Floor/Ward</td>
                  <td width="60%">' . $feedback_incident_object->ward . '</td>
              </tr>
              <tr>
                  <td width="40%">Site</td>
                  <td width="60%">' . $feedback_incident_object->bed_no . '</td>
              </tr>
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
              </tr>
              <tr>
                  <td width="40%">Employee name</td>
                  <td width="60%">' . $param_incident->name . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee ID</td>
                  <td width="60%">' . $param_incident->patientid . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee role</td>
                  <td width="60%">' . $param_incident->role . '</td>
              </tr>
              <tr>
                  <td width="40%">Mobile number</td>
                  <td width="60%">' . $param_incident->contactnumber . '</td>
              </tr>
              <tr>
                  <td width="40%">Email ID</td>
                  <td width="60%">' . $param_incident->email . '</td>
              </tr>
             ';

        if ($param_incident->tag_name) {
            $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
              </tr>
              <tr>
                  <td width="40%">Patient name</td>
                  <td width="60%">' . $param_incident->tag_name . '</td>
              </tr>
              <tr>
                  <td width="40%">Patient ID</td>
                  <td width="60%">' . $param_incident->tag_patientid . '</td>
              </tr>
            ';
        }

        $message1 .= '</table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        $user_list = get_user_by_question($tickets_incident_object->slug, $con);
        foreach ($user_list as $row) {
            $floor_wards = json_decode($row->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($ward_floor, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('INC-EMAIL-DEPTHEAD', $con);
                if (!empty($users_dept)) {
                    // Use helper function for proper UTF-8 encoding
                    EmailTemplateHelper::insertNotification(
                        $conn_g,
                        'email',
                        $message1,
                        $row->email,
                        $Subject,
                        $HID
                    );

                    // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $conn_g->real_escape_string($tickets_incident_object->alternate_email) . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                    // $conn_g->query($query2);
                }
            }
        }
    }

    $update_query = 'Update bf_feedback_incident set departmenthead_emailstatus = 1 WHERE id=' . $feedback_incident_object->id;
    mysqli_query($con, $update_query);
}

//Email for assigned user for incident
$feedback_incident_query = "SELECT * FROM tickets_incident WHERE status = 'Assigned' AND assigned_email = 0";
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $Subject1 = 'Action Required: Incident Assigned to You as Team Leader at ' . $hospitalname . '';
    $Subject2 = 'Action Required: Incident Assigned to You as Process Monitor at ' . $hospitalname . '';
    $Subject3 = 'Action Required: Incident Assigned to You as Team Member at ' . $hospitalname . '';

    $tickets_incident_query = "SELECT * FROM tickets_incident INNER JOIN department ON department.dprt_id = tickets_incident.departmentid INNER JOIN bf_feedback_incident ON bf_feedback_incident.id = tickets_incident.feedbackid WHERE tickets_incident.feedbackid = " . $feedback_incident_object->id . " GROUP BY department.description";



    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $total_incident_ticket = 0;
    $department = '';
    $message = '';
    // Step 1: Build user_id → firstname map
    $user_query = "SELECT user_id, firstname FROM user WHERE user_id != 1";
    $user_result = mysqli_query($con, $user_query);

    $userMap = [];
    while ($row = mysqli_fetch_assoc($user_result)) {
        $userMap[$row['user_id']] = $row['firstname'];
    }
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $param_incident = json_decode($tickets_incident_object->dataset);
        // print_r($param_incident);exit;
        $ward_floor = $param_incident->ward;
        $bednumb = $param_incident->bedno;
        $priority = $param_incident->priority;
        $incident_type = $param_incident->incident_type;

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        // Step 2: Convert comma-separated IDs into arrays
        $assign_for_process_monitor_ids = !empty($department_object->assign_for_process_monitor)
            ? explode(',', $department_object->assign_for_process_monitor)
            : [];

        $assign_to_ids = !empty($department_object->assign_to)
            ? explode(',', $department_object->assign_to)
            : [];

        $assign_for_team_member_ids = !empty($department_object->assign_for_team_member)
            ? explode(',', $department_object->assign_for_team_member)
            : []; // 🆕

        // Step 3: Map IDs → names
        $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id); // normalize
            return isset($userMap[$id]) ? $userMap[$id] : $id; // fallback to ID if not found
        }, $assign_for_process_monitor_ids);

        $assign_to_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return isset($userMap[$id]) ? $userMap[$id] : $id;
        }, $assign_to_ids);

        $assign_for_team_member_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return isset($userMap[$id]) ? $userMap[$id] : $id;
        }, $assign_for_team_member_ids); // 🆕

        // Step 4: Join into comma-separated strings (for email content)
        $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
        $names = implode(', ', $assign_to_names);
        $actionText_team_member = implode(', ', $assign_for_team_member_names); // 🆕


        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to inform you that a new incident has been assigned to you as Team Leader at ' . $hospitalname . '. <br />';


        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
          <table border="1" cellpadding="5">
              <tr>
                <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
             </tr>
              <tr>
                <td width="40%">Time & Date</td>
                <td width="60%">' . $created_on . '</td>
              </tr>
              <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
             </tr>
              <tr>
                 <td width="40%">Incident</td>
                 <td width="60%">' . $department_object->name . '</td>
             </tr>
              <tr>
                 <td width="40%">Category</td>
                 <td width="60%">' . $department . '</td>
             </tr>
              <tr>
                 <td width="40%">Incident Occured On</td>
                 <td width="60%">' . $department_object->incident_occured_in . '</td>
             </tr>
            
              <tr>
                 <td width="40%">Assigned Risk</td>
                 <td width="60%">' . $param_incident->risk_matrix->level . '</td>
             </tr>
              <tr>
                 <td width="40%">Assigned Priority</td>
                 <td width="60%">' . $param_incident->priority . '</td>
             </tr>
             <tr>
                 <td width="40%">Assigned Severity</td>
                 <td width="60%">' . $param_incident->incident_type . '</td>
             </tr>
            
            ';

        if ($param_incident->other) {
            $message1 .= '
              <tr>
                  <td width="40%">Description</td>
                  <td width="60%">' . $param_incident->other . '</td>
              </tr>';
        }

        $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
              </tr>
              <tr>
                  <td width="40%">Floor/Ward</td>
                  <td width="60%">' . $feedback_incident_object->ward . '</td>
              </tr>
              <tr>
                  <td width="40%">Site</td>
                  <td width="60%">' . $param_incident->bedno . '</td>
              </tr>
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
              </tr>
              <tr>
                  <td width="40%">Employee name</td>
                  <td width="60%">' . $param_incident->name . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee ID</td>
                  <td width="60%">' . $param_incident->patientid . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee role</td>
                  <td width="60%">' . $param_incident->role . '</td>
              </tr>
              <tr>
                  <td width="40%">Mobile number</td>
                  <td width="60%">' . $param_incident->contactnumber . '</td>
              </tr>
              <tr>
                  <td width="40%">Email ID</td>
                  <td width="60%">' . $param_incident->email . '</td>
              </tr>
             ';

        if ($param_incident->tag_name) {
            $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
              </tr>
              <tr>
                  <td width="40%">Patient name</td>
                  <td width="60%">' . $param_incident->tag_name . '</td>
              </tr>
              <tr>
                  <td width="40%">Patient ID</td>
                  <td width="60%">' . $param_incident->tag_patientid . '</td>
              </tr>
            ';
        }

        $message1 .= '
               <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
  
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';

        $message1 .= '</table>';


        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        // echo $message1;
        // exit;



        $message2 = 'Dear Team, <br /><br />';
        $message2 .= 'We would like to inform you that a new incident has been assigned to you as Process Monitor at ' . $hospitalname . '. <br />';

        //message2 will insert when there is only ONE TICKET
        $message2 .= '
  <table border="1" cellpadding="5">
      <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
     </tr>
      <tr>
        <td width="40%">Time & Date</td>
        <td width="60%">' . $created_on . '</td>
      </tr>
      <tr>
         <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
     </tr>
      <tr>
         <td width="40%">Incident</td>
         <td width="60%">' . $department_object->name . '</td>
     </tr>
      <tr>
         <td width="40%">Category</td>
         <td width="60%">' . $department . '</td>
     </tr>
      <tr>
         <td width="40%">Incident Occured On</td>
         <td width="60%">' . $department_object->incident_occured_in . '</td>
     </tr>
    
      <tr>
         <td width="40%">Assigned Risk</td>
         <td width="60%">' . $param_incident->risk_matrix->level . '</td>
     </tr>
      <tr>
         <td width="40%">Assigned Priority</td>
         <td width="60%">' . $param_incident->priority . '</td>
     </tr>
     <tr>
         <td width="40%">Assigned Severity</td>
         <td width="60%">' . $param_incident->incident_type . '</td>
     </tr>
    
    ';

        if ($param_incident->other) {
            $message2 .= '
      <tr>
          <td width="40%">Description</td>
          <td width="60%">' . $param_incident->other . '</td>
      </tr>';
        }

        $message2 .= '
      <tr>
          <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
      </tr>
      <tr>
          <td width="40%">Floor/Ward</td>
          <td width="60%">' . $feedback_incident_object->ward . '</td>
      </tr>
      <tr>
          <td width="40%">Site</td>
          <td width="60%">' . $param_incident->bedno . '</td>
      </tr>
     
      <tr>
          <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
      </tr>
      <tr>
          <td width="40%">Employee name</td>
          <td width="60%">' . $param_incident->name . '</td>
      </tr>
      <tr>
          <td width="40%">Employee ID</td>
          <td width="60%">' . $param_incident->patientid . '</td>
      </tr>
      <tr>
          <td width="40%">Employee role</td>
          <td width="60%">' . $param_incident->role . '</td>
      </tr>
      <tr>
          <td width="40%">Mobile number</td>
          <td width="60%">' . $param_incident->contactnumber . '</td>
      </tr>
      <tr>
          <td width="40%">Email ID</td>
          <td width="60%">' . $param_incident->email . '</td>
      </tr>
     ';

        if ($param_incident->tag_name) {
            $message2 .= '
      <tr>
          <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
      </tr>
      <tr>
          <td width="40%">Patient name</td>
          <td width="60%">' . $param_incident->tag_name . '</td>
      </tr>
      <tr>
          <td width="40%">Patient ID</td>
          <td width="60%">' . $param_incident->tag_patientid . '</td>
      </tr>
    ';
        }

        $message2 .= '
        <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
 
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';

        $message2 .= '</table>';

        $message2 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message2 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message2 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';



        $message3 = 'Dear Team, <br /><br />';
        $message3 .= 'We would like to inform you that a new incident has been assigned to you as Team Member at ' . $hospitalname . '. <br />';

        // message3 will insert when there is only ONE TICKET
        $message3 .= '
<table border="1" cellpadding="5">
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
    </tr>
    <tr>
        <td width="40%">Time & Date</td>
        <td width="60%">' . $created_on . '</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
    </tr>
    <tr>
        <td width="40%">Incident</td>
        <td width="60%">' . $department_object->name . '</td>
    </tr>
    <tr>
        <td width="40%">Category</td>
        <td width="60%">' . $department . '</td>
    </tr>
    <tr>
        <td width="40%">Incident Occured On</td>
        <td width="60%">' . $department_object->incident_occured_in . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Risk</td>
        <td width="60%">' . $param_incident->risk_matrix->level . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Priority</td>
        <td width="60%">' . $param_incident->priority . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Severity</td>
        <td width="60%">' . $param_incident->incident_type . '</td>
    </tr>
';

        if ($param_incident->other) {
            $message3 .= '
    <tr>
        <td width="40%">Description</td>
        <td width="60%">' . $param_incident->other . '</td>
    </tr>';
        }

        $message3 .= '
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
    </tr>
    <tr>
        <td width="40%">Floor/Ward</td>
        <td width="60%">' . $feedback_incident_object->ward . '</td>
    </tr>
    <tr>
        <td width="40%">Site</td>
        <td width="60%">' . $param_incident->bedno . '</td>
    </tr>
    
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
    </tr>
    <tr>
        <td width="40%">Employee name</td>
        <td width="60%">' . $param_incident->name . '</td>
    </tr>
    <tr>
        <td width="40%">Employee ID</td>
        <td width="60%">' . $param_incident->patientid . '</td>
    </tr>
    <tr>
        <td width="40%">Employee role</td>
        <td width="60%">' . $param_incident->role . '</td>
    </tr>
    <tr>
        <td width="40%">Mobile number</td>
        <td width="60%">' . $param_incident->contactnumber . '</td>
    </tr>
    <tr>
        <td width="40%">Email ID</td>
        <td width="60%">' . $param_incident->email . '</td>
    </tr>
   ';

        if ($param_incident->tag_name) {
            $message3 .= '
    <tr>
        <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
    </tr>
    <tr>
        <td width="40%">Patient name</td>
        <td width="60%">' . $param_incident->tag_name . '</td>
    </tr>
    <tr>
        <td width="40%">Patient ID</td>
        <td width="60%">' . $param_incident->tag_patientid . '</td>
    </tr>
    ';
        }

        $message3 .= '
     <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
  
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';
        $message3 .= '</table>';


        $message3 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message3 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message3 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';











        // Get the list of assigned users
        $assign_to_users = explode(',', $feedback_incident_object->assign_to);


        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject1) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        $assign_to_users_assign_for_process_monitor = explode(',', $tickets_incident_object->assign_for_process_monitor);
        foreach ($assign_to_users_assign_for_process_monitor as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message2) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject2) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        $assign_to_users_assign_for_team_member = explode(',', $tickets_incident_object->assign_for_team_member);
        foreach ($assign_to_users_assign_for_team_member as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message3) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject3) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }


        $update_query = 'UPDATE tickets_incident SET assigned_email = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}

//Email for re-assigned user for incident
$feedback_incident_query = "SELECT * FROM tickets_incident WHERE status = 'Re-assigned' AND reassigned_email = 0";
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $Subject1 = 'Action Required: Incident Re-Assigned to You as Team Leader at ' . $hospitalname . '';
    $Subject2 = 'Action Required: Incident Re-Assigned to You as Process Monitor at ' . $hospitalname . '';
    $Subject3 = 'Action Required: Incident Re-Assigned to You as Team Member at ' . $hospitalname . '';

    $tickets_incident_query = "SELECT * FROM tickets_incident INNER JOIN department ON department.dprt_id = tickets_incident.departmentid INNER JOIN bf_feedback_incident ON bf_feedback_incident.id = tickets_incident.feedbackid WHERE tickets_incident.feedbackid = " . $feedback_incident_object->id . " GROUP BY department.description";
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $total_incident_ticket = 0;
    $department = '';
    $message = '';
    // Step 1: Build user_id → firstname map
    $user_query = "SELECT user_id, firstname FROM user WHERE user_id != 1";
    $user_result = mysqli_query($con, $user_query);

    $userMap = [];
    while ($row = mysqli_fetch_assoc($user_result)) {
        $userMap[$row['user_id']] = $row['firstname'];
    }
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $param_incident = json_decode($tickets_incident_object->dataset);
        // print_r($param_incident);exit;
        $ward_floor = $param_incident->ward;
        $bednumb = $param_incident->bedno;
        $priority = $param_incident->priority;
        $incident_type = $param_incident->incident_type;

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        // Step 2: Convert comma-separated IDs into arrays
        $assign_for_process_monitor_ids = !empty($department_object->assign_for_process_monitor)
            ? explode(',', $department_object->assign_for_process_monitor)
            : [];

        $assign_to_ids = !empty($department_object->assign_to)
            ? explode(',', $department_object->assign_to)
            : [];

        $assign_for_team_member_ids = !empty($department_object->assign_for_team_member)
            ? explode(',', $department_object->assign_for_team_member)
            : []; // 🆕

        // Step 3: Map IDs → names
        $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id); // normalize
            return isset($userMap[$id]) ? $userMap[$id] : $id; // fallback to ID if not found
        }, $assign_for_process_monitor_ids);

        $assign_to_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return isset($userMap[$id]) ? $userMap[$id] : $id;
        }, $assign_to_ids);

        $assign_for_team_member_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return isset($userMap[$id]) ? $userMap[$id] : $id;
        }, $assign_for_team_member_ids); // 🆕

        // Step 4: Join into comma-separated strings (for email content)
        $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
        $names = implode(', ', $assign_to_names);
        $actionText_team_member = implode(', ', $assign_for_team_member_names); // 🆕


        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to inform you that a new incident has been Re-assigned to you as Team Leader at ' . $hospitalname . '. <br />';


        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
          <table border="1" cellpadding="5">
              <tr>
                <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
             </tr>
              <tr>
                <td width="40%">Time & Date</td>
                <td width="60%">' . $created_on . '</td>
              </tr>
              <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
             </tr>
              <tr>
                 <td width="40%">Incident</td>
                 <td width="60%">' . $department_object->name . '</td>
             </tr>
              <tr>
                 <td width="40%">Category</td>
                 <td width="60%">' . $department . '</td>
             </tr>
              <tr>
                 <td width="40%">Incident Occured On</td>
                 <td width="60%">' . $department_object->incident_occured_in . '</td>
             </tr>
            
              <tr>
                 <td width="40%">Assigned Risk</td>
                 <td width="60%">' . $param_incident->risk_matrix->level . '</td>
             </tr>
              <tr>
                 <td width="40%">Assigned Priority</td>
                 <td width="60%">' . $param_incident->priority . '</td>
             </tr>
             <tr>
                 <td width="40%">Assigned Severity</td>
                 <td width="60%">' . $param_incident->incident_type . '</td>
             </tr>
            
            ';

        if ($param_incident->other) {
            $message1 .= '
              <tr>
                  <td width="40%">Description</td>
                  <td width="60%">' . $param_incident->other . '</td>
              </tr>';
        }

        $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
              </tr>
              <tr>
                  <td width="40%">Floor/Ward</td>
                  <td width="60%">' . $feedback_incident_object->ward . '</td>
              </tr>
              <tr>
                  <td width="40%">Site</td>
                  <td width="60%">' . $param_incident->bedno . '</td>
              </tr>
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
              </tr>
              <tr>
                  <td width="40%">Employee name</td>
                  <td width="60%">' . $param_incident->name . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee ID</td>
                  <td width="60%">' . $param_incident->patientid . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee role</td>
                  <td width="60%">' . $param_incident->role . '</td>
              </tr>
              <tr>
                  <td width="40%">Mobile number</td>
                  <td width="60%">' . $param_incident->contactnumber . '</td>
              </tr>
              <tr>
                  <td width="40%">Email ID</td>
                  <td width="60%">' . $param_incident->email . '</td>
              </tr>
             ';

        if ($param_incident->tag_name) {
            $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
              </tr>
              <tr>
                  <td width="40%">Patient name</td>
                  <td width="60%">' . $param_incident->tag_name . '</td>
              </tr>
              <tr>
                  <td width="40%">Patient ID</td>
                  <td width="60%">' . $param_incident->tag_patientid . '</td>
              </tr>
            ';
        }

        $message1 .= '
               <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
  
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';

        $message1 .= '</table>';


        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';
        // echo $message1;
        // exit;



        $message2 = 'Dear Team, <br /><br />';
        $message2 .= 'We would like to inform you that a new incident has been Re-assigned to you as Process Monitor at ' . $hospitalname . '. <br />';

        //message2 will insert when there is only ONE TICKET
        $message2 .= '
  <table border="1" cellpadding="5">
      <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
     </tr>
      <tr>
        <td width="40%">Time & Date</td>
        <td width="60%">' . $created_on . '</td>
      </tr>
      <tr>
         <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
     </tr>
      <tr>
         <td width="40%">Incident</td>
         <td width="60%">' . $department_object->name . '</td>
     </tr>
      <tr>
         <td width="40%">Category</td>
         <td width="60%">' . $department . '</td>
     </tr>
      <tr>
         <td width="40%">Incident Occured On</td>
         <td width="60%">' . $department_object->incident_occured_in . '</td>
     </tr>
    
      <tr>
         <td width="40%">Assigned Risk</td>
         <td width="60%">' . $param_incident->risk_matrix->level . '</td>
     </tr>
      <tr>
         <td width="40%">Assigned Priority</td>
         <td width="60%">' . $param_incident->priority . '</td>
     </tr>
     <tr>
         <td width="40%">Assigned Severity</td>
         <td width="60%">' . $param_incident->incident_type . '</td>
     </tr>
    
    ';

        if ($param_incident->other) {
            $message2 .= '
      <tr>
          <td width="40%">Description</td>
          <td width="60%">' . $param_incident->other . '</td>
      </tr>';
        }

        $message2 .= '
      <tr>
          <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
      </tr>
      <tr>
          <td width="40%">Floor/Ward</td>
          <td width="60%">' . $feedback_incident_object->ward . '</td>
      </tr>
      <tr>
          <td width="40%">Site</td>
          <td width="60%">' . $param_incident->bedno . '</td>
      </tr>
      <tr>
          <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
      </tr>
      <tr>
          <td width="40%">Employee name</td>
          <td width="60%">' . $param_incident->name . '</td>
      </tr>
      <tr>
          <td width="40%">Employee ID</td>
          <td width="60%">' . $param_incident->patientid . '</td>
      </tr>
      <tr>
          <td width="40%">Employee role</td>
          <td width="60%">' . $param_incident->role . '</td>
      </tr>
      <tr>
          <td width="40%">Mobile number</td>
          <td width="60%">' . $param_incident->contactnumber . '</td>
      </tr>
      <tr>
          <td width="40%">Email ID</td>
          <td width="60%">' . $param_incident->email . '</td>
      </tr>
    ';

        if ($param_incident->tag_name) {
            $message2 .= '
      <tr>
          <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
      </tr>
      <tr>
          <td width="40%">Patient name</td>
          <td width="60%">' . $param_incident->tag_name . '</td>
      </tr>
      <tr>
          <td width="40%">Patient ID</td>
          <td width="60%">' . $param_incident->tag_patientid . '</td>
      </tr>
    ';
        }

        $message2 .= '
        <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
  
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';

        $message2 .= '</table>';

        $message2 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message2 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message2 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';



        $message3 = 'Dear Team, <br /><br />';
        $message3 .= 'We would like to inform you that a new incident has been Re-assigned to you as Team Member at ' . $hospitalname . '. <br />';

        // message3 will insert when there is only ONE TICKET
        $message3 .= '
<table border="1" cellpadding="5">
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
    </tr>
    <tr>
        <td width="40%">Time & Date</td>
        <td width="60%">' . $created_on . '</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
    </tr>
    <tr>
        <td width="40%">Incident</td>
        <td width="60%">' . $department_object->name . '</td>
    </tr>
    <tr>
        <td width="40%">Category</td>
        <td width="60%">' . $department . '</td>
    </tr>
    <tr>
        <td width="40%">Incident Occured On</td>
        <td width="60%">' . $department_object->incident_occured_in . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Risk</td>
        <td width="60%">' . $param_incident->risk_matrix->level . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Priority</td>
        <td width="60%">' . $param_incident->priority . '</td>
    </tr>
    <tr>
        <td width="40%">Assigned Severity</td>
        <td width="60%">' . $param_incident->incident_type . '</td>
    </tr>
';

        if ($param_incident->other) {
            $message3 .= '
    <tr>
        <td width="40%">Description</td>
        <td width="60%">' . $param_incident->other . '</td>
    </tr>';
        }

        $message3 .= '
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
    </tr>
    <tr>
        <td width="40%">Floor/Ward</td>
        <td width="60%">' . $feedback_incident_object->ward . '</td>
    </tr>
    <tr>
        <td width="40%">Site</td>
        <td width="60%">' . $param_incident->bedno . '</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
    </tr>
    <tr>
        <td width="40%">Employee name</td>
        <td width="60%">' . $param_incident->name . '</td>
    </tr>
    <tr>
        <td width="40%">Employee ID</td>
        <td width="60%">' . $param_incident->patientid . '</td>
    </tr>
    <tr>
        <td width="40%">Employee role</td>
        <td width="60%">' . $param_incident->role . '</td>
    </tr>
    <tr>
        <td width="40%">Mobile number</td>
        <td width="60%">' . $param_incident->contactnumber . '</td>
    </tr>
    <tr>
        <td width="40%">Email ID</td>
        <td width="60%">' . $param_incident->email . '</td>
    </tr>
   ';

        if ($param_incident->tag_name) {
            $message3 .= '
    <tr>
        <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
    </tr>
    <tr>
        <td width="40%">Patient name</td>
        <td width="60%">' . $param_incident->tag_name . '</td>
    </tr>
    <tr>
        <td width="40%">Patient ID</td>
        <td width="60%">' . $param_incident->tag_patientid . '</td>
    </tr>
    ';
        }

        $message3 .= '
     <tr>
        <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
    </tr>
    <tr>
        <td width="40%">Team Leader</td>
        <td width="60%">' . $names . '</td>
    </tr>
   
    <tr>
        <td width="40%">Process Monitor</td>
        <td width="60%">' . $actionText_process_monitor . '</td>
    </tr>
';

        $message3 .= '</table>';

        $message3 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message3 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message3 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';









        // Get the list of assigned users
        $assign_to_users = explode(',', $feedback_incident_object->reassign_to);


        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject1) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }
        $assign_to_users_assign_for_process_monitor = explode(',', $tickets_incident_object->reassign_for_process_monitor);
        foreach ($assign_to_users_assign_for_process_monitor as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message2) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject2) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        $assign_to_users_assign_for_team_member = explode(',', $tickets_incident_object->reassign_for_team_member);
        foreach ($assign_to_users_assign_for_team_member as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message3) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject3) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        $update_query = 'UPDATE tickets_incident SET reassigned_email = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}


//Email for assigned user for isr
$feedback_incident_query = "SELECT * FROM tickets_esr WHERE status = 'Assigned' AND assigned_email = 0";
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $Subject = 'Urgent: Internal Request assigned to an Employee at ' . $hospitalname . ' - Action Required';
    $param_isr = json_decode($feedback_incident_object->dataset);

    $tickets_incident_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $total_incident_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'isr/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention a recent service request reported by an employee at ' . $hospitalname . '.  <br />';

        //message1 will insert when there is only ONE TIKECT


        $message1 .= '<br /><br />To view more details and take necessary action, please follow the below link:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';

        // Get the list of assigned users
        $assign_to_users = explode(',', $feedback_incident_object->assign_to);


        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }
        $update_query = 'UPDATE tickets_esr SET assigned_email = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}


//Email for described user 
$feedback_incident_query = "SELECT * FROM tickets_incident WHERE status = 'Described' AND describe_email = 0";
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $Subject = 'Incident Described by Staff at ' . $hospitalname . ' - Action Required';

    $tickets_incident_query = "SELECT * FROM tickets_incident INNER JOIN department ON department.dprt_id = tickets_incident.departmentid INNER JOIN bf_feedback_incident ON bf_feedback_incident.id = tickets_incident.feedbackid WHERE tickets_incident.feedbackid = " . $feedback_incident_object->id . " GROUP BY department.description";
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_incident_generate = false;
    $total_incident_ticket = 0;
    $department = '';
    $message = '';

    // Step 1: Build user_id → firstname map
    $user_query = "SELECT user_id, firstname FROM user WHERE user_id != 1";
    $user_result = mysqli_query($con, $user_query);

    $userMap = [];
    while ($row = mysqli_fetch_assoc($user_result)) {
        $userMap[$row['user_id']] = $row['firstname'];
    }






    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $param_incident = json_decode($tickets_incident_object->dataset);
        // print_r($param_incident);exit;
        $ward_floor = $param_incident->ward;
        $bednumb = $param_incident->bedno;
        $priority = $param_incident->priority;
        $incident_type = $param_incident->incident_type;

        $param_incident = json_decode($tickets_incident_object->dataset);
        $ward_floor = $param_incident->ward;

        $tickets_incident_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        // $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        // Step 2: Convert comma-separated IDs into arrays
        $assign_for_process_monitor_ids = !empty($department_object->assign_for_process_monitor)
            ? explode(',', $department_object->assign_for_process_monitor)
            : [];

        $assign_to_ids = !empty($department_object->assign_to)
            ? explode(',', $department_object->assign_to)
            : [];

        $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id); // normalize
            return $userMap[$id] ?? $id; // fallback to ID if not found
        }, $assign_for_process_monitor_ids);

        $assign_to_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return $userMap[$id] ?? $id;
        }, $assign_to_ids);
        // Step 4: Join into comma-separated strings (for email content)
        $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
        $names = implode(', ', $assign_to_names);






        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;   //pointing to public_html/ticket
        $keys = array();
        $res = array();
        $titles = array();
        $zz = array();
        $message1 = 'Dear Team, <br /><br />';
        $message1 .= 'We would like to bring to your attention that a recent incident has been described by an employee at ' . $hospitalname . '. <br />';

        //message1 will insert when there is only ONE TIKECT
        $message1 .= '
          <table border="1" cellpadding="5">
              <tr>
                <td colspan="2" style="text-align:center;"><b>Incident reported on</b></td>
             </tr>
              <tr>
                <td width="40%">Time & Date</td>
                <td width="60%">' . $created_on . '</td>
              </tr>
              <tr>
                 <td colspan="2" style="text-align:center;"><b>Incident details</b></td>
             </tr>
              <tr>
                 <td width="40%">Incident</td>
                 <td width="60%">' . $department_object->name . '</td>
             </tr>
              <tr>
                 <td width="40%">Category</td>
                 <td width="60%">' . $department . '</td>
             </tr>
              <tr>
                 <td width="40%">Incident Occured On</td>
                 <td width="60%">' . $department_object->incident_occured_in . '</td>
             </tr>
            
              <tr>
                 <td width="40%">Assigned Risk</td>
                 <td width="60%">' . $param_incident->risk_matrix->level . '</td>
             </tr>
              <tr>
                 <td width="40%">Assigned Priority</td>
                 <td width="60%">' . $param_incident->priority . '</td>
             </tr>
             <tr>
                 <td width="40%">Assigned Severity</td>
                 <td width="60%">' . $param_incident->incident_type . '</td>
             </tr>
            
            ';

        if ($param_incident->other) {
            $message1 .= '
              <tr>
                  <td width="40%">Description</td>
                  <td width="60%">' . $param_incident->other . '</td>
              </tr>';
        }

        $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported in</b></td>
              </tr>
              <tr>
                  <td width="40%">Floor/Ward</td>
                  <td width="60%">' . $feedback_incident_object->ward . '</td>
              </tr>
              <tr>
                  <td width="40%">Site</td>
                  <td width="60%">' . $param_incident->bedno . '</td>
              </tr>
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Incident reported by</b></td>
              </tr>
              <tr>
                  <td width="40%">Employee name</td>
                  <td width="60%">' . $param_incident->name . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee ID</td>
                  <td width="60%">' . $param_incident->patientid . '</td>
              </tr>
              <tr>
                  <td width="40%">Employee role</td>
                  <td width="60%">' . $param_incident->role . '</td>
              </tr>
              <tr>
                  <td width="40%">Mobile number</td>
                  <td width="60%">' . $param_incident->contactnumber . '</td>
              </tr>
              <tr>
                  <td width="40%">Email ID</td>
                  <td width="60%">' . $param_incident->email . '</td>
              </tr>
              ';

        if ($param_incident->tag_name) {
            $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Patient Details</b></td>
              </tr>
              <tr>
                  <td width="40%">Patient name</td>
                  <td width="60%">' . $param_incident->tag_name . '</td>
              </tr>
              <tr>
                  <td width="40%">Patient ID</td>
                  <td width="60%">' . $param_incident->tag_patientid . '</td>
              </tr>
            ';
        }

        $message1 .= '
              <tr>
                  <td colspan="2" style="text-align:center;"><b>Assigned Details</b></td>
              </tr>
              <tr>
                  <td width="40%">Team Leader</td>
                  <td width="60%">' . $names . '</td>
              </tr>
              <tr>
                  <td width="40%">Process Monitor</td>
                  <td width="60%">' . $actionText_process_monitor . '</td>
              </tr>
            ';

        $message1 .= '</table>';


        $message1 .= '<br /><br />To view more details and take necessary action, please follow the link below: <br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial in ensuring that we provide the highest quality of care and service to our patients.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';

        // Get the list of assigned users
        $assign_by_users = explode(',', $feedback_incident_object->assign_by);


        foreach ($assign_by_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        $users = get_user_by_sms_activity('IN-EMAIL-RCA-INCIDENTS', $con);
        if (!empty($users)) {

            foreach ($users as $user_object) {
                // Check if $patient_ward matches any value in $floor_wards
                $email = $user_object->email;

                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
                $conn_g->query($query1);

            }
        }

        $update_query = 'UPDATE tickets_incident SET describe_email = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}




//Email for transferring asset
$feedback_asset_query = "SELECT * FROM tickets_asset WHERE status = 'Pending Transfer' AND transfer_email_status = 0";
$feedback_asset_result = mysqli_query($con, $feedback_asset_query);

while ($feedback_asset_object = mysqli_fetch_object($feedback_asset_result)) {
    $Subject = 'Asset Transfer Request Pending Your Approval';
    $param_incident = json_decode($feedback_asset_object->dataset, true);

    // Get transfer details
    $transferFromDepartment = $param_incident['depart'] ?? 'N/A';
    $transferFromUser = $param_incident['assignee'] ?? 'N/A';

    // Get transfer to details from replymessage
    $transferToDepartment = 'N/A';
    $transferToUser = 'N/A';
    if (!empty($feedback_asset_object->replymessage)) {
        $replyMessages = json_decode($feedback_asset_object->replymessage);
        if (is_array($replyMessages)) {
            $replyMessages = array_reverse($replyMessages);
            foreach ($replyMessages as $r) {
                if (!empty($r->depart) && !empty($r->action)) {
                    $transferToDepartment = $r->depart;
                    $transferToUser = $r->action;
                    break;
                }
            }
        }
    }

    $TID = $feedback_asset_object->id;
    $department_head_link = $config_set['BASE_URL'] . 'asset/track/' . $TID;

    $message1 = 'Dear ,<br /><br />';
    $message1 .= 'You have a pending request awaiting your approval for the transfer of an asset. Please find the details below:<br /><br />';

    $message1 .= '<strong>Asset Transfer Request Details:</strong><br /><br />';

    $message1 .= '<strong>Transfer From:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferFromDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferFromUser) . '<br /><br />';

    $message1 .= '<strong>Transfer To:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferToDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferToUser) . '<br /><br />';

    $message1 .= 'To review and take action on this request, please click the link below:<br />';
    $message1 .= $department_head_link . '<br /><br />';

    $message1 .= 'Your timely response is appreciated.<br /><br />';
    $message1 .= '<strong>Thank You,</strong><br />' . $hospitalname;

    // Get the list of assigned users
    $users_dept = get_user_by_sms_activity('ASSET-APPROVAL-EMAIL', $con);

    if (!empty($users_dept)) {
        foreach ($users_dept as $user) {
            $email = $user->email;
            $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
            $conn_g->query($query1);
        }
    }
    $update_query = 'UPDATE tickets_asset SET transfer_email_status = 1 WHERE id=' . $feedback_asset_object->id;
    mysqli_query($con, $update_query);
}



// Email for accepting transferring asset request
$feedback_asset_query = "SELECT * FROM tickets_asset WHERE status = 'Approved by Admin' AND transfer_approval_status = 'approved_by_admin'";
$feedback_asset_result = mysqli_query($con, $feedback_asset_query);

while ($feedback_asset_object = mysqli_fetch_object($feedback_asset_result)) {
    $Subject = 'Asset Transfer Request Approved';
    $param_incident = json_decode($feedback_asset_object->dataset, true);

    // Get transfer from details
    $transferFromDepartment = $param_incident['depart'] ?? 'N/A';
    $transferFromUser = $param_incident['assignee'] ?? 'N/A';

    // Get transfer to details from replymessage
    $transferToDepartment = 'N/A';
    $transferToUser = 'N/A';
    if (!empty($feedback_asset_object->replymessage)) {
        $replyMessages = json_decode($feedback_asset_object->replymessage);
        if (is_array($replyMessages)) {
            $replyMessages = array_reverse($replyMessages);
            foreach ($replyMessages as $r) {
                if (!empty($r->depart) && !empty($r->action)) {
                    $transferToDepartment = $r->depart;
                    $transferToUser = $r->action;
                    break;
                }
            }
        }
    }

    $TID = $feedback_asset_object->id;
    $department_head_link = $config_set['BASE_URL'] . 'asset/track/' . $TID;

    $message1 = 'Dear ' . htmlspecialchars($transferFromUser) . ',<br /><br />';
    $message1 .= 'Your request to transfer the asset has been approved. Please find the approved transfer details below:<br /><br />';

    $message1 .= '<strong>Asset Transfer Details:</strong><br /><br />';

    $message1 .= '<strong>Transferred From:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferFromDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferFromUser) . '<br /><br />';

    $message1 .= '<strong>Transferred To:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferToDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferToUser) . '<br /><br />';

    $message1 .= 'You may now proceed with the physical transfer of the asset as per the above information.<br />';
    $message1 .= 'Kindly ensure proper documentation and handover is completed.<br /><br />';

    $message1 .= 'If you have any questions or need further assistance, please feel free to reach out.<br /><br />';
    $message1 .= '<strong>Best Regards,</strong><br />' . $hospitalname;


    // Fetch the email address of the user who initiated the transfer
    $transferFromUserEmail = '';
    $fetch_user_query = "SELECT email FROM users WHERE username = '" . mysqli_real_escape_string($con, $transferFromUser) . "' LIMIT 1";
    $user_result = mysqli_query($con, $fetch_user_query);
    if ($user_row = mysqli_fetch_assoc($user_result)) {
        $transferFromUserEmail = $user_row['email'];
    }

    if (!empty($transferFromUserEmail)) {
        // Send email notification only to the user who initiated the transfer
        $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $transferFromUserEmail . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
        $conn_g->query($query1);
    }

    // Update email status
    $update_query = 'UPDATE tickets_asset SET transfer_email_status = 1 WHERE id=' . $feedback_asset_object->id;
    mysqli_query($con, $update_query);
}


// Email for dening transferring asset request
$feedback_asset_query = "SELECT * FROM tickets_asset WHERE transfer_approval_status = 'denied'";
$feedback_asset_result = mysqli_query($con, $feedback_asset_query);

while ($feedback_asset_object = mysqli_fetch_object($feedback_asset_result)) {
    $Subject = 'Asset Transfer Request Rejected';
    $param_incident = json_decode($feedback_asset_object->dataset, true);

    // Get transfer from details
    $transferFromDepartment = $param_incident['depart'] ?? 'N/A';
    $transferFromUser = $param_incident['assignee'] ?? 'N/A';

    // Get transfer to details from replymessage
    $transferToDepartment = 'N/A';
    $transferToUser = 'N/A';
    if (!empty($feedback_asset_object->replymessage)) {
        $replyMessages = json_decode($feedback_asset_object->replymessage);
        if (is_array($replyMessages)) {
            $replyMessages = array_reverse($replyMessages);
            foreach ($replyMessages as $r) {
                if (!empty($r->depart) && !empty($r->action)) {
                    $transferToDepartment = $r->depart;
                    $transferToUser = $r->action;
                    break;
                }
            }
        }
    }

    $TID = $feedback_asset_object->id;
    $department_head_link = $config_set['BASE_URL'] . 'asset/track/' . $TID;

    $message1 = 'Dear ' . htmlspecialchars($transferFromUser) . ',<br /><br />';
    $message1 .= 'Your request to transfer the asset has been rejected. Please find the request details below for your reference:<br /><br />';

    $message1 .= '<strong>Asset Transfer Request Details:</strong><br /><br />';

    $message1 .= '<strong>Requested Transfer From:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferFromDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferFromUser) . '<br /><br />';

    $message1 .= '<strong>Requested Transfer To:</strong><br />';
    $message1 .= 'Department: ' . htmlspecialchars($transferToDepartment) . '<br />';
    $message1 .= 'User: ' . htmlspecialchars($transferToUser) . '<br /><br />';

    $message1 .= 'If you require further clarification or would like to discuss this decision, please reach out to the approving authority or the asset management team.<br /><br />';
    $message1 .= 'Thank you for your understanding.<br /><br />';
    $message1 .= '<strong>Thank You,</strong><br />' . $hospitalname;

    // Fetch the email address of the user who initiated the transfer
    $transferFromUserEmail = '';
    $fetch_user_query = "SELECT email FROM users WHERE username = '" . mysqli_real_escape_string($con, $transferFromUser) . "' LIMIT 1";
    $user_result = mysqli_query($con, $fetch_user_query);
    if ($user_row = mysqli_fetch_assoc($user_result)) {
        $transferFromUserEmail = $user_row['email'];
    }

    if (!empty($transferFromUserEmail)) {
        // Send email notification only to the user who initiated the transfer
        $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $transferFromUserEmail . '", "' . $conn_g->real_escape_string($Subject) . '", "' . $HID . '")';
        $conn_g->query($query1);
    }

    // Update email status
    $update_query = 'UPDATE tickets_asset SET transfer_email_status = 1 WHERE id=' . $feedback_asset_object->id;
    mysqli_query($con, $update_query);
}





$conn_g->close();
$con->close();
echo 'department head message end';
