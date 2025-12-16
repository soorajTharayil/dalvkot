<?php
//Welcome message to patient- pc feedback link '            1607100000000284453
//Discharge message to patient- ip feedback link            1607100000000284454
//Thankyou message to patient- tracking link  '             1607100000000284455
//Thanku message to inpatient (happy)-google review link   1607100000000284456
//Thanku message to inpatient (unhappy)- sorry message     1607100000000284459
//Thanku message to outpatient (happy)-google review link  1607100000000284456
//Thanku message to outpatient (unhappy)- sorry message    1607100000000284459

//Message to patient when interim ticket is closed          1607100000000280135


include('../api/db.php');
include('/var/www/html/globalconfig.php');

//Welcome message to patient- pc feedback link 
function welcome_message_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$welcome_message_query = 'SELECT * FROM patients_from_admission WHERE welcome_message = 0';
$welcome_message_result = mysqli_query($con, $welcome_message_query);
while ($welcome_message_object = mysqli_fetch_object($welcome_message_result)) {

    $welcome_message_for_patient = '';
    $number = $welcome_message_object->mobile;
    $name = $welcome_message_object->name;
    $uuid = welcome_message_UniqueId();
    $interim_link = '10.10.10.103/patpcrf/?p=' . $uuid;   //pointing to public_html/pat 

    $welcome_message_for_patient = 'Hi ' . $name . ',
Thank you for choosing ' . $hospitalname . '. Kindly click the link to register any concern during your stay. 
' . $interim_link . '
-EFEEDOR';
    $TEMPID = '1607100000000284453';


    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $welcome_message_object;

    // $insert_query = "INSERT INTO `notification_patient`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','message', '$welcome_message_for_patient', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    // $conn_g->query($insert_query);


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'patient_sms_on_admission', '" . json_encode([$name, $hospitalname, $interim_link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }


    $update_query = 'UPDATE patients_from_admission SET welcome_message = 1 WHERE id=' . $welcome_message_object->id;
    mysqli_query($con, $update_query);
}

//Welcome message to patient- pc feedback link 
function welcome_op_message_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$welcome_message_query = 'SELECT * FROM patients_from_admission_op WHERE welcome_message = 0';
$welcome_message_result = mysqli_query($con, $welcome_message_query);
while ($welcome_message_object = mysqli_fetch_object($welcome_message_result)) {

    $welcome_message_for_patient = '';
    $number = $welcome_message_object->mobile;
    $name = $welcome_message_object->name;
    $uuid = welcome_op_message_UniqueId();
    $op_link = '10.10.10.103/opopfb/?p=' . $uuid;   //pointing to public_html/pat 

    $welcome_message_for_patient = 'Hi ' . $name . ',
Thank you for choosing ' . $hospitalname . '. Kindly click the link to register any concern during your stay. 
' . $op_link . '
-EFEEDOR';
    $TEMPID = '1607100000000284453';

    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $welcome_message_object;


    $insert_query = "INSERT INTO `notification_patient`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','message', '$welcome_message_for_patient', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    $conn_g->query($insert_query);


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'patientsms_on_discharge', '" . json_encode([$name, $hospitalname, $op_link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }


    $update_query = 'UPDATE patients_from_admission_op SET welcome_message = 1 WHERE id=' . $welcome_message_object->id;
    mysqli_query($con, $update_query);
}



//Discharge message to patient- ip feedback link  

function discharge_message_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$discharge_message_query = 'SELECT * FROM `patient_discharge` WHERE check_status="active" AND messagestatus=0';
$discharge_message_result = mysqli_query($con, $discharge_message_query);
while ($discharge_message_object = mysqli_fetch_object($discharge_message_result)) {

    $discharge_message_for_patient = '';
    $number = $discharge_message_object->mobile;
    $name = $discharge_message_object->name;
    $uuid = discharge_message_UniqueId();
    $ip_link = '10.10.10.103/dipipfb/?p=' . $uuid;    //pointing to public_html/dip

    $discharge_message_for_patient = 'Hi ' . $name . ',
Thank you for choosing ' . $hospitalname . '. Kindly click the link and share your experience on our services.
' . $ip_link . '
-EFEEDOR';
    $TEMPID = '1607100000000284454';

    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $discharge_message_object;


    $insert_query = "INSERT INTO `notification_patient`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','message', '$discharge_message_for_patient', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    $conn_g->query($insert_query);


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'patientsms_on_discharge', '" . json_encode([$name, $hospitalname, $ip_link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending' ,'" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $update_query = 'UPDATE patient_discharge SET `messagestatus` = 1 WHERE id=' . $discharge_message_object->id;
    mysqli_query($con, $update_query);
}

//Thankyou message to  patient(interim)- tracking link  

function patient_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}


$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE messagestatus = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);
while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

    $ward_floor = $feedback_int_object->ward;
    $parameter = json_decode($feedback_int_object->dataset);
    $patient_name = $parameter->name;

    $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' GROUP BY  department.description';
    $tickets_int_result = mysqli_query($con, $tickets_int_query);
    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);

    $patient_query = 'SELECT * FROM  bf_patients  WHERE id = "' . $feedback_int_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {
        $tickets_generate = true;
        $department = $tickets_int_object->description;
        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND department.description="' . $tickets_int_object->description . '"';
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
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/pc/' . $TID;
        $uuid = patient_tracking_link_UniqueId();
        $patient_tracking_link = '10.10.10.103/tkt/?p=' . $uuid;     //pointing to public_html/ticket
        $patient_tracking_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;     //pointing to public_html/ticket

        $message = "Thank you for raising your concern at " . $hospitalname . ". Track the progress of your request here: " . $patient_tracking_link . "%0a -EFEEDOR";
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284455';

        // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("patient_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
        // $conn_g->query($insert_query);

        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
        VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatientacknowledgmentsms_for_compliantsubmission', '" . json_encode([$patient_name, $hospitalname, $patient_tracking_link_whatsapp]) . "', 
        'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    }

    $update_query = 'Update bf_feedback_int set messagestatus = 1 WHERE id=' . $feedback_int_object->id;
    mysqli_query($con, $update_query);
}

//Thanku message to inpatient (happy)-google review link   
//Thanku message to inpatient (unhappy)- sorry message 

$feedback_query = 'SELECT * FROM  bf_feedback  WHERE messagestatus = 0';
$feedback_result = mysqli_query($con, $feedback_query);
while ($feedback_object = mysqli_fetch_object($feedback_result)) {

    $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
    $tickets_result = mysqli_query($con, $tickets_query);
    $tickets_rowcount = mysqli_num_rows($tickets_result);

    $patient_query = 'SELECT * FROM  bf_patients  WHERE id = "' . $feedback_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;
    $name = $patient_object->name;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';

    while ($tickets_object = mysqli_fetch_object($tickets_result)) {

        $tickets_generate = true;
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
    }

    if ($tickets_generate == false) {
        $message = 'Thank you for sharing your feedback at ' . $hospitalname . '. Please take a moment to rate us on Google by clicking the link: ' . $slink . ' %0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284456';


        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatient_service_response', '" . json_encode([$name, $hospitalname, $slink]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    } else {
        $message = 'We appreciate your feedback at ' . $hospitalname . '. Your opinion is incredibly important to us, and it drives us to constantly improve our services.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284459';


        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatientsms_for_unsatisfied_patient', '" . json_encode([$name, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    }
    // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("patient_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
    // $conn_g->query($insert_query);

    $update_query = 'Update bf_feedback set messagestatus = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);
}

//Thanku message to inpatient adf (happy)-google review link   
//Thanku message to inpatient adf (unhappy)- sorry message 

$feedback_query = 'SELECT * FROM  bf_feedback_adf  WHERE messagestatus = 0';
$feedback_result = mysqli_query($con, $feedback_query);
while ($feedback_object = mysqli_fetch_object($feedback_result)) {

    $tickets_query = 'SELECT * FROM  tickets_adf  inner JOIN department ON department.dprt_id = tickets_adf.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' GROUP BY  department.description';
    $tickets_result = mysqli_query($con, $tickets_query);
    $tickets_rowcount = mysqli_num_rows($tickets_result);

    $patient_query = 'SELECT * FROM  bf_patients  WHERE id = "' . $feedback_object->pid . '"';
    $patient_result = mysqli_query($con, $patient_query);
    $patient_object = mysqli_fetch_object($patient_result);
    $number = $patient_object->mobile;

    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';

    while ($tickets_object = mysqli_fetch_object($tickets_result)) {

        $tickets_generate = true;
        $department = $tickets_object->description;
        $department_query = 'SELECT * FROM  tickets_adf  inner JOIN department ON department.dprt_id = tickets_adf.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND department.description="' . $tickets_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
    }

    if ($tickets_generate == false) {
        $message = 'Thank you for sharing your feedback at ' . $hospitalname . '. Please take a moment to rate us on Google by clicking the link: ' . $slink . ' %0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284456';
    } else {
        $message = 'We appreciate your feedback at ' . $hospitalname . '. Your opinion is incredibly important to us, and it drives us to constantly improve our services.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284459';
    }
    // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("patient_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
    // $conn_g->query($insert_query);

    $update_query = 'Update bf_feedback_adf set messagestatus = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);
}

//Thanku message to outpatient (happy)-google review link   
//Thanku message to outpatient (unhappy)- sorry message 

$outfeedback_query = 'SELECT * FROM  bf_outfeedback  WHERE messagestatus = 0';
$outfeedback_result = mysqli_query($con, $outfeedback_query);
while ($outfeedback_object = mysqli_fetch_object($outfeedback_result)) {

    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $outfeedback_object->id . ' GROUP BY  department.description';
    $ticketsop_result = mysqli_query($con, $ticketsop_query);
    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);

    $opatient_query = 'SELECT * FROM  bf_opatients  WHERE id = "' . $outfeedback_object->pid . '"';
    $opatient_result = mysqli_query($con, $opatient_query);
    $opatient_object = mysqli_fetch_object($opatient_result);
    $number = $opatient_object->mobile;
    $name = $opatient_object->name;
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';

    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {

        $tickets_generate = true;
        $department = $ticketsop_object->description;
        $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $outfeedback_object->id . ' AND department.description="' . $ticketsop_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }
    }

    if ($tickets_generate == false) {
        $message = 'Thank you for sharing your feedback at ' . $hospitalname . '. Please take a moment to rate us on Google by clicking the link: ' . $slink . ' %0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284456';


        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'outpatient_service_response', '" . json_encode([$name, $hospitalname, $slink]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    } else {
        $message = 'We appreciate your feedback at ' . $hospitalname . '. Your opinion is incredibly important to us, and it drives us to constantly improve our services.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $TEMPID = '1607100000000284459';

        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'outpatientsms_for_unsatisfiedpatient', '" . json_encode([$name, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    }
    // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("patient_message","' . $message . '",0,"' . $number . '","' . $TEMPID . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
    // $conn_g->query($insert_query);

    $update_query = 'Update bf_outfeedback set messagestatus = 1 WHERE id=' . $outfeedback_object->id;
    mysqli_query($con, $update_query);
}

//Message to patient when ip ticket is closed  

$feedback_int_query = 'SELECT * FROM  tickets  WHERE closed_ticket_alert = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);

while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {
    $ticket_close_query = 'SELECT * FROM  tickets  inner JOIN bf_feedback ON tickets.feedbackid = bf_feedback.id   WHERE  tickets.closed_ticket_alert = 0 ';
    $ticket_close_result = mysqli_query($con, $ticket_close_query);

    while ($ticket_close_object = mysqli_fetch_object($ticket_close_result)) {
        $message = '';
        $parameter = json_decode($ticket_close_object->dataset);
        $number = $parameter->contactnumber;
        $name = $parameter->name;



        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['patient_detail'] = $ticket_close_object;
        $TID = $feedback_int_object->id;

        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'acknowledgmentsms_afterclosing_ticket_for_unsatisfiedpatient', '" . json_encode([$name, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }


    }
    $update_query = 'UPDATE tickets SET closed_ticket_alert = 1 WHERE closed_ticket_alert = 0';
    mysqli_query($con, $update_query);
}




//Message to patient when interim ticket is closed  
function int_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique I
    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters
    return $id;
}

$feedback_int_query = 'SELECT * FROM  tickets_int  WHERE closed_ticket_alert = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);

while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {
    $ticket_close_query = 'SELECT * FROM  tickets_int  inner JOIN bf_feedback_int ON tickets_int.feedbackid = bf_feedback_int.id   WHERE  tickets_int.closed_ticket_alert = 0 ';
    $ticket_close_result = mysqli_query($con, $ticket_close_query);

    while ($ticket_close_object = mysqli_fetch_object($ticket_close_result)) {
        $message = '';
        $parameter = json_decode($ticket_close_object->dataset);
        $number = $parameter->contactnumber;
        $name = $parameter->name;


        $message = 'Dear ' . $name . ',%0aThe concern raised by you at ' . $hospitalname . ' has been successfully resolved. %0a%0a-EFEEDOR';

        $TEMPID = '1607100000000280135';

        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['patient_detail'] = $ticket_close_object;
        $TID = $feedback_int_object->id;

        $department_head_link = $config_set['BASE_URL'] . 'track/pc/' . $TID;
        $messages = str_replace('&', 'and', str_replace(' ', '%20', $message));
        // $insert_query = "INSERT INTO `notification`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','patient_message', '$messages', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
        // $conn_g->query($insert_query);

        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatientacknowledgmentsms_for_compliant_closed', '" . json_encode([$name, $hospitalname, $department_head_link]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully.<br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }


    }
    $update_query = 'UPDATE tickets_int SET closed_ticket_alert = 1 WHERE closed_ticket_alert = 0';
    mysqli_query($con, $update_query);
}



//Thankyou message to  patient(esr)- tracking link  

$feedback_esr_query = 'SELECT * FROM  tickets_esr  WHERE closed_ticket_alert = 0';
$feedback_esr_result = mysqli_query($con, $feedback_esr_query);

while ($feedback_esr_object = mysqli_fetch_object($feedback_esr_result)) {
    $ticket_close_query_esr = 'SELECT * FROM  tickets_esr  inner JOIN bf_employees_esr ON tickets_esr.created_by = bf_employees_esr.patient_id  WHERE  tickets_esr.closed_ticket_alert = 0 AND tickets_esr.feedbackid = bf_employees_esr.id';
    $ticket_close_result_esr = mysqli_query($con, $ticket_close_query_esr);
    while ($ticket_close_object_esr = mysqli_fetch_object($ticket_close_result_esr)) {
        $message = '';
        $number = $ticket_close_object_esr->mobile;
        $name = $ticket_close_object_esr->name;
        $TID = $feedback_esr_object->id;

        $department_head_link = $config_set['BASE_URL'] . 'track/isr/' . $TID;
        // SQL query to insert one notification at a time
        // Second query: Insert data into notifications table
        $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'isr_staffacknowledgmentsms_on_compliant_closedd', '" . json_encode([$name, $hospitalname, $department_head_link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

        // Execute the second query
        if ($conn_g->query($insert_notification_query) === TRUE) {
            echo "Data inserted into notifications table successfully. esrrrrrrrrr <br>";
        } else {
            echo "Error: " . $con->error . "<br>";
        }


    }
    $update_query_esr = 'UPDATE tickets_esr SET closed_ticket_alert = 1 WHERE closed_ticket_alert = 0';
    mysqli_query($con, $update_query_esr);
}




$conn_g->close();
$con->close();
echo 'patient message end';
