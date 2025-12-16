<?php
//Message to employee when isr ticket is open          1607100000000284455
//Message to employee when incident ticket is open      1607100000000284455


include('../api/db.php');
include('/var/www/html/globalconfig.php');


//Thankyou message to  employee (isr)- tracking link  

function isr_employee_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}


$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE messagestatus = 0';
$feedback_isr_result = mysqli_query($con, $feedback_isr_query);
while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {

    $parameter = json_decode($feedback_isr_object->dataset);

    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $emp_contactnumber = $parameter->contactnumber;

    $tickets_isr_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' GROUP BY  department.description';
    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);
    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);

    $patient_query = 'SELECT * FROM  bf_employees_esr  WHERE id = "' . $feedback_isr_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {
        $tickets_generate = true;
        $department = $tickets_isr_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND department.description="' . $tickets_isr_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/isr/' . $TID;
        $uuid = isr_employee_tracking_link_UniqueId();
        $employee_tracking_link = '10.10.10.103/tkt/?p=' . $uuid;     //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = "Thank you for raising your concern at " . $hospitalname . ". Track the progress of your request here: " . $employee_tracking_link . "%0a -EFEEDOR";
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284455';

        $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("employee_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
        $conn_g->query($insert_query);

        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffacknowledgementsms_for_requestsubmission', '" . json_encode([$emp_name, $hospitalname, $employee_tracking_link_whatsapp]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }

        $update_query = 'Update bf_feedback_esr set messagestatus = 1 WHERE id=' . $feedback_isr_object->id;
        mysqli_query($con, $update_query);
    }
}

//Thankyou message to  employee (isr)- tracking link  

function isr_assigned_employee_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}


$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE whatsapp_assign_status = 0';
$feedback_isr_result = mysqli_query($con, $feedback_isr_query);
while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {

    $parameter = json_decode($feedback_isr_object->dataset);

    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $emp_contactnumber = $parameter->contactnumber;

    $tickets_isr_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE tickets_esr.status = "Assigned" AND tickets_esr.assigned_message = 0 AND feedbackid = ' . $feedback_isr_object->id . ' GROUP BY  department.description';
    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);
    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);

    $patient_query = 'SELECT * FROM  bf_employees_esr  WHERE id = "' . $feedback_isr_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {
        $tickets_generate = true;
        $department = $tickets_isr_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE tickets_esr.status = "Assigned" AND tickets_esr.assigned_message = 0 AND feedbackid = ' . $feedback_isr_object->id . ' AND department.description="' . $tickets_isr_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;

        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/isr/' . $TID;
        $uuid = isr_assigned_employee_tracking_link_UniqueId();
        $employee_tracking_link = '10.10.10.103/tkt/?p=' . $uuid;     //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = "Thank you for raising your concern at " . $hospitalname . ". Track the progress of your request here: " . $employee_tracking_link . "%0a -EFEEDOR";
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284455';

       $assign_to_users = explode(',', $tickets_isr_object->assign_to);
        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_object($user_result)) {
                $number = $user_row->mobile;
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                $conn_g->query($query);
            }
            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'assigning_servicerequest_for_staffsms', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $emp_ward, $emp_bed_no,$emp_ward,$emp_name, $emp_contactnumber, $employee_tracking_link_whatsapp]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }

        $update_query1 = 'UPDATE tickets_esr SET assigned_message = 1 WHERE id=' . $tickets_isr_object->id;
        mysqli_query($con, $update_query1);

        $update_query = 'Update bf_feedback_esr set whatsapp_assign_status = 1 WHERE id=' . $feedback_isr_object->id;
        mysqli_query($con, $update_query);
    }
}




//Thankyou message to  employee (incident)- tracking link  

function incident_employee_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}


$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE messagestatus = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);
while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {

    $parameter = json_decode($feedback_incident_object->dataset);

    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $emp_contactnumber = $parameter->contactnumber;

    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);

    $patient_query = 'SELECT * FROM  bf_employees_incident  WHERE id = "' . $feedback_incident_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {
        $tickets_generate = true;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }


        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/inc/' . $TID;
        $uuid = incident_employee_tracking_link_UniqueId();
        $employee_tracking_link = '10.10.10.103/tkt/?p=' . $uuid;     //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = "Thank you for reporting the incident at " . $hospitalname . ". Please follow the link to track the status of the incident:%0a" . $employee_tracking_link . "%0a -EFEEDOR";
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000288912';

        $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("employee_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
        $conn_g->query($insert_query);

        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffacknowledgementsms_for_incidentreporting', '" . json_encode([$emp_name, $hospitalname, $employee_tracking_link_whatsapp, $hospitalname]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    }

    $update_query = 'Update bf_feedback_incident set messagestatus = 1 WHERE id=' . $feedback_incident_object->id;
    mysqli_query($con, $update_query);
}

//incident  departmenthead(incident) message when ticket is ASSIGNED ..................................................................................................

function incident_departmenthead_tracking_link_UniqueId()

{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}

// Assigned sms and whatsapp message for incident 
function incident_assigned_departmenthead_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID
    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters
    return $id;
}

$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE whatsapp_assign_status = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);
while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $parameter = json_decode($feedback_incident_object->dataset);
    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $incident_type = $parameter->incident_type;
    $priority = $parameter->priority;
    $emp_contactnumber= $parameter->contactnumber;
    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Assigned" AND tickets_incident.assigned_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {
        $tickets_generate = true;
        // $number = $tickets_incident_object->mobile;
        $alternate_number = $tickets_incident_object->alternate_mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Assigned" AND tickets_incident.assigned_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'incident/track/' . $TID;
        $uuid = incident_assigned_departmenthead_tracking_link_UniqueId();
        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        // Retrieve the list of users for the new condition
        // Get the list of assigned users
        $assign_to_users = explode(',', $tickets_incident_object->assign_to);
        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_object($user_result)) {
                $number = $user_row->mobile;
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                $conn_g->query($query);
            }
            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffalertsms_for_incidentassigning', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $incident_type, $priority, $emp_ward, $emp_bed_no, $employee_tracking_link_whatsapp, $hospitalname]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }
        $update_query1 = 'UPDATE tickets_incident SET assigned_message = 1 WHERE id=' . $tickets_incident_object->id;
        mysqli_query($con, $update_query1);

        $update_query = 'Update bf_feedback_incident set whatsapp_assign_status = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}


//incident  departmenthead(incident) message when ticket is RE-ASSIGNED ..................................................................................................

function incident_reassigned_departmenthead_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID
    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters
    return $id;
}
$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE whatsapp_reassign_status = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);
while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $parameter = json_decode($feedback_incident_object->dataset);
    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $incident_type = $parameter->incident_type;
    $priority = $parameter->priority;
    $emp_contactnumber= $parameter->contactnumber;
    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Re-assigned" AND tickets_incident.reassigned_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {
        $tickets_generate = true;
        // $number = $tickets_incident_object->mobile;
        $alternate_number = $tickets_incident_object->alternate_mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Re-assigned" AND tickets_incident.reassigned_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'incident/track/' . $TID;
        $uuid = incident_reassigned_departmenthead_tracking_link_UniqueId();
        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        // Retrieve the list of users for the new condition
        // Get the list of assigned users
        $assign_to_users = explode(',', $tickets_incident_object->reassign_to);
        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_object($user_result)) {
                $number = $user_row->mobile;
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                $conn_g->query($query);
            }
            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffalertsms_on_incidentassigning', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $incident_type, $priority, $emp_ward, $emp_bed_no, $emp_name, $emp_contactnumber, $employee_tracking_link_whatsapp, $hospitalname]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }
        $update_query1 = 'UPDATE tickets_incident SET reassigned_message = 1 WHERE id=' . $tickets_incident_object->id;
        mysqli_query($con, $update_query1);

        $update_query = 'Update bf_feedback_incident set whatsapp_reassign_status = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}

//incident  departmenthead(incident) message when ticket is DESCRIBED ..................................................................................................

function incident_describe_departmenthead_tracking_link_UniqueId()

{

    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID
    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters
    return $id;
}
$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE whatsapp_describe_status = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);
while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $parameter = json_decode($feedback_incident_object->dataset);
    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $incident_type = $parameter->incident_type;
    $priority = $parameter->priority;
    $emp_contactnumber= $parameter->contactnumber;
    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Described" AND tickets_incident.describe_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {
        $tickets_generate = true;
        // $number = $tickets_incident_object->mobile;
        $alternate_number = $tickets_incident_object->alternate_mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE tickets_incident.status = "Described" AND tickets_incident.describe_message = 0 AND tickets_incident.feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'incident/track/' . $TID;
        $uuid = incident_describe_departmenthead_tracking_link_UniqueId();
        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $employee_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        // Retrieve the list of users for the new condition
        // Get the list of assigned users
        $assign_to_users = explode(',', $tickets_incident_object->assign_by);
        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_object($user_result)) {
                $number = $user_row->mobile;
                $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                $conn_g->query($query);
            }
            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffalertsms_for_incidentdescription', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $incident_type, $priority, $emp_ward, $emp_bed_no, $employee_tracking_link_whatsapp, $hospitalname]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }
        $update_query1 = 'UPDATE tickets_incident SET describe_message = 1 WHERE id=' . $tickets_incident_object->id;
        mysqli_query($con, $update_query1);

        $update_query = 'Update bf_feedback_incident set whatsapp_describe_status = 1 WHERE id=' . $feedback_incident_object->id;
        mysqli_query($con, $update_query);
    }
}





$conn_g->close();
$con->close();
echo 'employee message end';
