<?php
//message to admin  when they are created                  1607100000000284308
//message to  admins(interim) when ticket is OPEN          1607100000000284458
//message to  admins(ip) when ticket is OPEN               1607100000000292853
//message to  admins(adf) when ticket is OPEN              1607100000000292853
//message to  admins(op) when ticket is OPEN               1607100000000292853
//message to  admins(isr) when ticket is OPEN              1607100000000292999
//message to  admins(incident) when ticket is OPEN         1607100000000288910
//L1 and L2 escalation message

include('../api/db.php');
include('/var/www/html/globalconfig.php');
include('get_user.php');
//message to admin  when they are created 


$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 2';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;
    $email = $user_object->firstname;
    $parameter = json_decode($user_object->departmentpermission);
    $password = $parameter->password;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_superadmin_accountcreation', '" . json_encode([$name, $hospitalname, $link, $email, $password, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}


$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 3';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;
    $email = $user_object->firstname;
    $parameter = json_decode($user_object->departmentpermission);
    $password = $parameter->password;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_admin_accountcreation', '" . json_encode([$name, $hospitalname, $link, $email, $password, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}



$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 4';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;
    $email = $user_object->firstname;
    $parameter = json_decode($user_object->departmentpermission);
    $password = $parameter->password;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_departmenthead_account_creation', '" . json_encode([$name, $hospitalname, $link, $email, $password, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 8';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;
    $email = $user_object->firstname;
    $parameter = json_decode($user_object->departmentpermission);
    $password = $parameter->password;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_patientcoordinator_accountcreation', '" . json_encode([$name, $hospitalname, $email, $password, $link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 10';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;
    $email = $user_object->firstname;
    $parameter = json_decode($user_object->departmentpermission);
    $password = $parameter->password;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_employee_accountcreation', '" . json_encode([$name, $hospitalname, $link, $email, $password, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}



$user_query = 'SELECT * FROM `user` WHERE `message_alert` = 0  AND `user_role` = 3';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;

    $message = "Hi " . $name . ",%0aYour user account is now active on the Efeedor Patient Experience Platform at " . $hospitalname . ". Get your login credentials from the superadmin and access your personalized dashboard at " . $link . ". We're dedicated to enhancing your patient experience! %0a-EFEEDOR";

    $TEMPID = '1607100000000284308';
    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $r;
    $meta_data['sent_time'] = time();
    $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
    // $query = "INSERT INTO `notification`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','user', '" . mysqli_real_escape_string($con, $message) . "', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    // $conn_g->query($query);



    $query = 'UPDATE user SET `message_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}

// for whatsapp user message 


$user_query = 'SELECT * FROM `user` WHERE `whatsapp_alert` = 0  AND `user_role` = 3';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $name = $user_object->firstname;


    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status) 
    VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'usersms_on_useraccountcreation', '" . json_encode([$name, $hospitalname, $link, $hospitalname]) . "', 
    'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending')";

    // Execute the second query
    if ($conn_g->query($insert_notification_query) === TRUE) {
        echo "Data inserted into notifications table successfully.<br>";
    } else {
        echo "Error: " . $con->error . "<br>";
    }

    $query = 'UPDATE user SET `whatsapp_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}


function pdf_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}





//message to  admins(interim) when ticket is OPEN 

function int_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE admins_messagestatus = 0';
$feedback_int_result = mysqli_query($con, $feedback_int_query);

while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {

    $ward_floor = $feedback_int_object->ward;
    $parameter = json_decode($feedback_int_object->dataset);

    $patient_name = $parameter->name;
    $patient_uhid = $parameter->patientid;
    $patient_ward = $parameter->ward;
    $patient_bedno = $parameter->bedno;


    $ward_floor = $feedback_int_object->ward;
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

        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;

        // print_r($department_object);
        // exit;
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'pc/track/' . $TID;
        $uuid = int_admins_tracking_link_UniqueId();
        $admins_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket for sending text sms
        $admins_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message

    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000284458';
        $messages = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000284458';
            $messages = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000284458';
            $messages = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        }
    }
    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {
        // $user_query = 'SELECT * FROM  user  WHERE 1';
        // $user_result = mysqli_query($con, $user_query);
        // while ($user_object = mysqli_fetch_object($user_result)) {

        $users = get_user_by_sms_activity('ALL-PATIENT-COMPLAINTS-SMS', $con);

        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $number = $user_object->mobile;

                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
            }
        }

        $users_whatsapp = get_user_by_sms_activity('PCF-WHATSAPP', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            $floor_wards = json_decode($users_whatsapp_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $number = $users_whatsapp_object->mobile;
                $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_inpatientcomplaint', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $admins_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                // Execute the second query
                if ($conn_g->query($insert_notification_query) === TRUE) {
                    echo "Data inserted into notifications table successfully.<br>";
                } else {
                    echo "Error: " . $con->error . "<br>";
                }
            }
        }

        $update_query = 'Update bf_feedback_int set admins_messagestatus = 1 WHERE id=' . $feedback_int_object->id;
        mysqli_query($con, $update_query);
    }
}

//message to  admins(ip) when ticket is OPEN 

function ip_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedback_query = 'SELECT * FROM  bf_feedback  WHERE admins_messagestatus = 0';
$feedback_result = mysqli_query($con, $feedback_query);

while ($feedback_object = mysqli_fetch_object($feedback_result)) {

    $ward_floor = $feedback_object->ward;
    $parameter = json_decode($feedback_object->dataset);

    $patient_name = $parameter->name;
    $patient_uhid = $parameter->patientid;
    $patient_ward = $parameter->ward;
    $patient_bedno = $parameter->bedno;


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
        $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND department.description="' . $tickets_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_rowcount = mysqli_num_rows($department_result);
        $department_object = mysqli_fetch_object($department_result);
        if ($department_rowcount > 1) {
            $k = 1;
        } else {
            $k = '';
        }

        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;

        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/ipdf/' . $feedbackid;
        $uuid = ip_admins_tracking_link_UniqueId();
        $admins_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $admins_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message
    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000292853';
        $messages = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000292853';
            $messages = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000292853';
            $messages = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
        }
    }
    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {

        $users = get_user_by_sms_activity('IP-ALL-TICKETS-SMS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $number = $user_object->mobile;
                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
            }
        }

        $users_whatsapp = get_user_by_sms_activity('IP-WHATSAPP', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            $floor_wards = json_decode($users_whatsapp_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $number = $users_whatsapp_object->mobile;
                $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsms_alert_for_inpatient_negativeexperiences', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $admins_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                // Execute the second query
                if ($conn_g->query($insert_notification_query) === TRUE) {
                    echo "Data inserted into notifications table successfully.<br>";
                } else {
                    echo "Error: " . $con->error . "<br>";
                }
            }
        }
    }
    $update_query = 'Update bf_feedback set admins_messagestatus = 1 WHERE id=' . $feedback_object->id;
    mysqli_query($con, $update_query);
}


//message to  admins(op) when ticket is OPEN   

function op_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedbackop_query = 'SELECT * FROM  bf_outfeedback  WHERE admins_messagestatus = 0';
$feedbackop_result = mysqli_query($con, $feedbackop_query);

while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {

    $ward_floor = $feedbackop_object->ward;
    $parameter = json_decode($feedbackop_object->dataset);

    $patient_name = $parameter->name;
    $patient_uhid = $parameter->patientid;
    $patient_ward = $parameter->ward;


    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' GROUP BY  department.description';
    $ticketsop_result = mysqli_query($con, $ticketsop_query);
    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $feedbackid = $feedbackop_object->id;
    $department = '';
    $message = '';
    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {

        $tickets_generate = true;
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


        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;

        $TID = $department_object->id;
        $meta_data = array();
        $meta_data['config_set_url'] = $config_set['BASE_URL'];
        $meta_data['config_set_domain'] = $config_set['DOMAIN'];
        $meta_data['link'] = $config_set['BASE_URL'] . 'track/opf/' . $feedbackid;
        $uuid = op_admins_tracking_link_UniqueId();
        $admins_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $admins_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message
    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000292853';
        $messages = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000292853';
            $messages = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000292853';
            $messages = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '%0a-EFEEDOR';
        }
    }

    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {

        $users = get_user_by_sms_activity('OP-ALL-TICKETS-SMS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
                $number = $user_object->mobile;
                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
            
        }

        $users_whatsapp = get_user_by_sms_activity('OP-WHATSAPP', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            $floor_wards = json_decode($users_whatsapp_object->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
                $number = $users_whatsapp_object->mobile;
                $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_negativeexperience_oppatients', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $Concern_Category, $Concern_Area, $admins_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                // Execute the second query
                if ($conn_g->query($insert_notification_query) === TRUE) {
                    echo "Data inserted into notifications table successfully.<br>";
                } else {
                    echo "Error: " . $con->error . "<br>";
                }
            
        }
    }
    $update_query = 'Update bf_outfeedback set admins_messagestatus = 1 WHERE id=' . $feedbackop_object->id;
    mysqli_query($con, $update_query);
}

//message to  admins(isr) when ticket is OPEN 

function isr_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE admins_messagestatus = 0';
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
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {

        $tickets_generate = true;
        $number = $tickets_isr_object->mobile;
        $department = $tickets_isr_object->description;
        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND department.description="' . $tickets_isr_object->description . '"';
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
        $meta_data['link'] = $config_set['BASE_URL'] . 'isr/track/' . $TID;
        $uuid = isr_admins_tracking_link_UniqueId();
        $admins_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $admins_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message
    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000292999';
        $messages = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $admins_link . '%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000292999';
            $messages = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $admins_link . '%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000292999';
            $messages = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $admins_link . '%0a-EFEEDOR';
        }
    }
    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {

        $users = get_user_by_sms_activity('ALL-REQUEST-NOTIFICATION-SMS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $user_object->mobile;
                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
                //     }
                // }
            }
        }

        $users_whatsapp = get_user_by_sms_activity('ISR-WHATSAPP', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            $floor_wards = json_decode($users_whatsapp_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $users_whatsapp_object->mobile;
                $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_servicerequest', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $emp_ward, $emp_bed_no,$emp_ward, $emp_name, $emp_contactnumber, $admins_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                // Execute the second query
                if ($conn_g->query($insert_notification_query) === TRUE) {
                    echo "Data inserted into notifications table successfully.<br>";
                } else {
                    echo "Error: " . $con->error . "<br>";
                }
            }
        }
    }
    $update_query = 'Update bf_feedback_esr set admins_messagestatus = 1 WHERE id=' . $feedback_isr_object->id;
    mysqli_query($con, $update_query);
}



//message to  admins(incident) when ticket is OPEN 

//message to  admins(incident) when ticket is OPEN 

function incident_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE admins_messagestatus = 0';
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {
    $parameter = json_decode($feedback_incident_object->dataset);

    $emp_ward = !empty($parameter->ward) ? $parameter->ward : 'NIL';
    $emp_bed_no = !empty($parameter->bedno) ? $parameter->bedno : 'NIL';
    $emp_name = !empty($parameter->name) ? $parameter->name : 'NIL';
    $emp_contactnumber = !empty($parameter->contactnumber) ? $parameter->contactnumber : 'NIL';
    $incident_type = !empty($parameter->incident_type) ? $parameter->incident_type : 'Unassigned';
    $priority = !empty($parameter->priority) ? $parameter->priority : 'Unassigned';
    $risk_matrix = !empty($parameter->risk_matrix->level) ? $parameter->risk_matrix->level : 'Unassigned';



    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' GROUP BY  department.description';
    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $tickets_generate = true;
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;
        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND department.description="' . $tickets_incident_object->description . '"';
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
        $uuid = incident_admins_tracking_link_UniqueId();
        $admins_link = 'h.efeedor.com/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $admins_link_whatsapp = 'h.efeedor.com/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message
    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000288910';
        $messages = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000288910';
            $messages = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000288910';
            $messages = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        }
    }
    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {

        $users = get_user_by_sms_activity('ALL-INCIDENT-NOTIFICATION-SMS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $user_object->mobile;
                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
                //     }
                // }
            }
        }
        $users_whatsapp = get_user_by_sms_activity('INC-WHATSAPP', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            $floor_wards = json_decode($users_whatsapp_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $users_whatsapp_object->mobile;
                $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'issue_update_staff', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $risk_matrix, $priority, $incident_type, $emp_ward, $emp_bed_no, $emp_name, $emp_contactnumber, $admins_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                // Execute the second query
                if ($conn_g->query($insert_notification_query) === TRUE) {
                    echo "Data inserted into notifications table successfully.<br>";
                } else {
                    echo "Error: " . $con->error . "<br>";
                }
            }
        }
    }
    $update_query = 'Update bf_feedback_incident set admins_messagestatus = 1 WHERE id=' . $feedback_incident_object->id;
    mysqli_query($con, $update_query);
}


//message to  admins(grievance) when ticket is OPEN 

function grievance_admins_tracking_link_UniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}

$feedback_grievance_query = 'SELECT * FROM  bf_feedback_grievance  WHERE admins_messagestatus = 0';
$feedback_grievance_result = mysqli_query($con, $feedback_grievance_query);

while ($feedback_grievance_object = mysqli_fetch_object($feedback_grievance_result)) {
    $parameter = json_decode($feedback_grievance_object->dataset);

    $emp_ward = $parameter->ward;
    $emp_bed_no = $parameter->bedno;
    $emp_name = $parameter->name;
    $incident_type = $parameter->incident_type;
    $emp_contactnumber = $parameter->contactnumber;
    $tickets_grievance_query = 'SELECT * FROM  tickets_grievance  inner JOIN department ON department.dprt_id = tickets_grievance.departmentid   WHERE  feedbackid = ' . $feedback_grievance_object->id . ' GROUP BY  department.description';
    $tickets_grievance_result = mysqli_query($con, $tickets_grievance_query);
    $tickets_grievance_rowcount = mysqli_num_rows($tickets_grievance_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_grievance_object = mysqli_fetch_object($tickets_grievance_result)) {

        $tickets_generate = true;
        $number = $tickets_grievance_object->mobile;
        $department = $tickets_grievance_object->description;
        $department_query = 'SELECT * FROM  tickets_grievance  inner JOIN department ON department.dprt_id = tickets_grievance.departmentid   WHERE  feedbackid = ' . $feedback_grievance_object->id . ' AND department.description="' . $tickets_grievance_object->description . '"';
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
        $meta_data['link'] = $config_set['BASE_URL'] . 'grievance/track/' . $TID;
        $uuid = grievance_admins_tracking_link_UniqueId();
        $admins_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket

    }

    if ($department_rowcount > 1) {
        $TEMPIDALERTT = '1607100000000291671';
        $message = 'Alert: A grievance has been reported by an employee at ' . $hospitalname . '.%0aFollow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
    } else {
        if ($total_ticket > 1) {
            $TEMPIDALERTT = '1607100000000291671';
            $messages = 'Alert: A grievance has been reported by an employee at ' . $hospitalname . '.%0aFollow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        } else {
            $TEMPIDALERTT = '1607100000000291671';
            $messages = 'Alert: A grievance has been reported by an employee at ' . $hospitalname . '.%0aFollow the link for details: ' . $admins_link . '.%0a-EFEEDOR';
        }
    }
    /*FOR Admin Alert Message */
    if ($tickets_generate == true) {

        $users = get_user_by_sms_activity('ALL-GRIEVANCE-NOTIFICATION-SMS', $con);
        foreach ($users as $user_object) {
            $floor_wards = json_decode($user_object->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $user_object->mobile;
                $message = str_replace('&', 'and', str_replace(' ', '%20', $messages));
                // $insert_query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("admins_message","' . $message . '",0,"' . $number . '","' . $TEMPIDALERTT . '","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                // $conn_g->query($insert_query);
            }
        }
    }
    $update_query = 'Update bf_feedback_grievance set admins_messagestatus = 1 WHERE id=' . $feedback_grievance_object->id;
    mysqli_query($con, $update_query);
}



$conn_g->close();
$con->close();
echo 'admin message end';
