<?php

//message to department head when they are CREATED              1607100000000284308

//message to department head(interim) when ticket is OPEN       1607100000000284458

//message to department head(interim) when ticket is REOPEN     1607100000000284458

//message to department head(interim) when ticket is TRANSFER   1607100000000284458

//message to department head(adf) when ticket is OPEN            1607100000000292853

//message to department head(adf) when ticket is REOPEN          1607100000000292853

//message to department head(adf) when ticket is TRANSFER        1607100000000292853

//message to department head(ip) when ticket is OPEN            1607100000000292853

//message to department head(ip) when ticket is REOPEN          1607100000000292853

//message to department head(ip) when ticket is TRANSFER        1607100000000292853

//message to department head(op) when ticket is OPEN            1607100000000292853

//message to department head(op) when ticket is REOPEN          1607100000000292853

//message to department head(op) when ticket is TRANSFER        1607100000000292853

//message to  department head(isr) when ticket is OPEN          1607100000000292999

//message to  department head(incident) when ticket is OPEN     1607100000000288910



include('../api/db.php');



include('/var/www/html/globalconfig.php');

include('get_user.php');


//message to department head when they are CREATED................................................................................................................

// $users = get_user_by_sms_activity('ALL-PATIENT-COMPLAINTS-SMS',$con);

// foreach($users as $user_object) {
$user_query = 'SELECT * FROM `user` WHERE `message_alert` = 0  AND `user_role` = 4';
$user_result = mysqli_query($con, $user_query);
while ($user_object = mysqli_fetch_object($user_result)) {
    $message = '';
    $number = $user_object->mobile;
    $alternate_number = $user_object->alternate_mobile;
    $name = $user_object->firstname;
    $message = "Hi " . $name . ",%0aYour user account is now active on the Efeedor Patient Experience Platform at " . $hospitalname . ". Get your login credentials from the superadmin and access your personalized dashboard at " . $link . ". We're dedicated to enhancing your patient experience! %0a-EFEEDOR";
    $TEMPID = '1607100000000284308';
    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $r;
    $meta_data['sent_time'] = time();
    $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
    $query1 = "INSERT INTO `notification`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','user', '" . mysqli_real_escape_string($con, $message) . "', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    $conn_g->query($query1);
    $query = 'UPDATE user SET `message_alert` = 1 WHERE user_id=' . $user_object->user_id;
    mysqli_query($con, $query);
}


//interim departmenthead(interim) message when ticket is OPEN ................................................................................................................



function int_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedback_int_query = 'SELECT * FROM  bf_feedback_int  WHERE departmenthead_messagestatus = 0';

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

        // $number = $tickets_int_object->mobile;

        $alternate_number = $tickets_int_object->alternate_mobile;

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


        $Concern_Category = $department_object->description;
        $Concern_Area = $department_object->name;


        $TID = $department_object->id;



        $meta_data = array();

        $meta_data['config_set_url'] = $config_set['BASE_URL'];

        $meta_data['config_set_domain'] = $config_set['DOMAIN'];

        $meta_data['link'] = $config_set['BASE_URL'] . 'pc/track/' . $TID;

        $uuid = int_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));



        $user_list = get_user_by_question($tickets_int_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $floor_wards = json_decode($user_row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {

                $users_dept = get_user_by_sms_activity('PCF-SMS-DEPTHEAD', $con);
                if (!empty($users_dept)) {

                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`, `meta`, `uuid`) VALUES ("department_message", "' . $message . '", 0, "' . $number . '", "1607100000000284458", "' . $HID . '", "' . mysqli_real_escape_string($con, json_encode($meta_data)) . '", "' . $uuid . '")';
                }
                // Retrieve the list of users for the new condition
                $users_whatsapp = get_user_by_sms_activity('PCF-WHATSAPP-DEPTHEAD', $con);
                if (!empty($users_whatsapp)) {
                    $conn_g->query($query1);

                    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
                 VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_inpatientcomplaint', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $department_head_link_whatsapp]) . "', 
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
    }



    $update_query = 'Update bf_feedback_int set departmenthead_messagestatus = 1 WHERE id=' . $feedback_int_object->id;

    mysqli_query($con, $update_query);
}





//interim departmenthead(interim) message when ticket is REOPEN ......................................................................................................................................

$feedback_int_query = "SELECT * FROM tickets_int WHERE status = 'Reopen'";
$feedback_int_result = mysqli_query($con, $feedback_int_query);
while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {
    $tickets_int_query = 'SELECT tickets_int.*, department.*, bf_feedback.* FROM tickets_int INNER JOIN department ON department.dprt_id = tickets_int.departmentid INNER JOIN bf_feedback ON bf_feedback.id = tickets_int.feedbackid WHERE feedbackid = ' . $feedback_int_object->id . ' AND tickets_int.reopen_ticket_alert = 0 GROUP BY department.description';

    $tickets_int_result = mysqli_query($con, $tickets_int_query);
    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);
    $tickets_generate = false;
    $total_ticket = 0;
    $department = '';
    $message = '';
    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {

        $parameter = json_decode($tickets_int_object->dataset);

        $emp_ward = $parameter->ward;
        $emp_bed_no = $parameter->bedno;
        $emp_name = $parameter->name;
        $patientid = $parameter->patientid;
        $incident_type = $parameter->incident_type;
        $priority = $parameter->priority;
        $emp_contactnumber = $parameter->contactnumber;
        $tickets_generate = true;
        // $number = $tickets_int_object->mobile;
        $department = $tickets_int_object->description;
        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND tickets_int.reopen_ticket_alert = 0 AND department.description="' . $tickets_int_object->description . '"';

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
        $meta_data['link'] = $config_set['BASE_URL'] . 'pc/track/' . $TID;
        $uuid = int_departmenthead_tracking_link_UniqueId();
        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message

        $message = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';
        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_int_object->slug, $con);
        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000284458","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);

            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatientcomplaint_reopen_reques_to_staffsmsalert', '" . json_encode([$hospitalname, $emp_name, $patientid, $emp_ward, $emp_bed_no, $Concern_Category, $Concern_Area, $department_head_link_whatsapp]) . "', 
            'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }

        $users_whatsapp = get_user_by_sms_activity('PCF-REOPEN-WHATSAPP-ALERT-ADMINS', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            // Check if $patient_ward matches any value in $floor_wards
            $number = $users_whatsapp_object->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000284458","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);

            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'inpatientcomplaint_reopen_reques_to_staffsmsalert', '" . json_encode([$hospitalname, $emp_name, $patientid, $emp_ward, $emp_bed_no, $Concern_Category, $Concern_Area, $department_head_link_whatsapp]) . "', 
            'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }

        }
    }
    $update_query = 'Update tickets_int set reopen_ticket_alert = 1 WHERE id=' . $feedback_int_object->id;
    mysqli_query($con, $update_query);
}



//interim departmenthead(interim) message when ticket is TRANSFER........................................................................................................................................



$feedback_int_query = "SELECT * FROM  tickets_int  WHERE status = 'Transfered'";

$feedback_int_result = mysqli_query($con, $feedback_int_query);



while ($feedback_int_object = mysqli_fetch_object($feedback_int_result)) {



    $tickets_int_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND tickets_int.transfer_ticket_alert = 0 GROUP BY  department.description';

    $tickets_int_result = mysqli_query($con, $tickets_int_query);

    $tickets_int_rowcount = mysqli_num_rows($tickets_int_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_int_object = mysqli_fetch_object($tickets_int_result)) {



        $tickets_generate = true;

        // $number = $tickets_int_object->mobile;

        $department = $tickets_int_object->description;

        $department_query = 'SELECT * FROM  tickets_int  inner JOIN department ON department.dprt_id = tickets_int.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_int_object->id . ' AND tickets_int.transfer_ticket_alert = 0 AND department.description="' . $tickets_int_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'pc/track/' . $TID;

        $uuid = int_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: You have received a complaint from an inpatient at ' . $hospitalname . '. Please follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_int_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000284458","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update tickets_int set transfer_ticket_alert = 1 WHERE id=' . $feedback_int_object->id;

    mysqli_query($con, $update_query);
}





//message to department head(adf) when ticket is OPEN  ............................................................................................................



function adf_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}











//message to department head(ip) when ticket is OPEN  ............................................................................................................



function ip_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedback_query = 'SELECT * FROM  bf_feedback  WHERE departmenthead_messagestatus = 0';

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

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_object = mysqli_fetch_object($tickets_result)) {

        //print_r($tickets_object ); exit;
        //TODO

        $tickets_generate = true;

        //$number = $tickets_object->mobile;

        $alternate_number = $tickets_object->alternate_mobile;

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'ipd/track/' . $TID;

        $uuid = ip_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket

        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        // print_r($tickets_object->slug);
        $user_list = get_user_by_question($tickets_object->slug, $con);

        // print_r($user_list);
        // exit;
        foreach ($user_list as $row) {
            $number = $row->mobile;
            $floor_wards = json_decode($row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('IP-SMS-DEPTHEAD', $con);
                if (!empty($users_dept)) {

                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';
                    $conn_g->query($query1);
                }
                // Retrieve the list of users for the new condition
                $users_whatsapp = get_user_by_sms_activity('IP-WHATSAPP-DEPTHEAD', $con);
                if (!empty($users_whatsapp)) {

                    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsms_alert_for_inpatient_negativeexperiences', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $patient_bedno, $Concern_Category, $Concern_Area, $department_head_link_whatsapp]) . "', 
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




        // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $alternate_number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid2 . '")';

        // $conn_g->query($query2);

    }



    $update_query = 'Update bf_feedback set departmenthead_messagestatus = 1 WHERE id=' . $feedback_object->id;

    mysqli_query($con, $update_query);
}







//ip departmenthead(ip) message when ticket is REOPEN ......................................................................................................................................................

$feedback_query = "SELECT * FROM  tickets  WHERE status = 'Reopen'";

$feedback_result = mysqli_query($con, $feedback_query);



while ($feedback_object = mysqli_fetch_object($feedback_result)) {



    $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND tickets.reopen_ticket_alert = 0 GROUP BY  department.description';

    $tickets_result = mysqli_query($con, $tickets_query);

    $tickets_rowcount = mysqli_num_rows($tickets_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_object = mysqli_fetch_object($tickets_result)) {



        $tickets_generate = true;

        // $number = $tickets_object->mobile;

        $department = $tickets_object->description;

        $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid   WHERE  feedbackid = ' . $feedback_object->id . ' AND tickets.reopen_ticket_alert = 0 AND department.description="' . $tickets_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'ipd/track/' . $TID;

        $uuid = int_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update tickets set reopen_ticket_alert = 1 WHERE id=' . $feedback_object->id;

    mysqli_query($con, $update_query);
}



//ip departmenthead(ip) message when ticket is TRANSFER...................................................................................................................



$feedback_query = "SELECT * FROM  tickets  WHERE status = 'Transfered'";

$feedback_result = mysqli_query($con, $feedback_query);



while ($feedback_object = mysqli_fetch_object($feedback_result)) {



    $tickets_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_object->id . ' AND tickets.transfer_ticket_alert = 0 GROUP BY  department.description';

    $tickets_result = mysqli_query($con, $tickets_query);

    $tickets_rowcount = mysqli_num_rows($tickets_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_object = mysqli_fetch_object($tickets_result)) {



        $tickets_generate = true;

        // $number = $tickets_object->mobile;

        $department = $tickets_object->description;

        $department_query = 'SELECT * FROM  tickets  inner JOIN department ON department.dprt_id = tickets.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_object->id . ' AND tickets.transfer_ticket_alert = 0 AND department.description="' . $tickets_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'ipd/track/' . $TID;

        $uuid = int_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: A negative experience has been reported by an inpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));

        $user_list = get_user_by_question($tickets_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;

            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update tickets set transfer_ticket_alert = 1 WHERE id=' . $feedback_object->id;

    mysqli_query($con, $update_query);
}





//message to department head(op) when ticket is OPEN  .............................................................................................................



function op_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedbackop_query = 'SELECT * FROM  bf_outfeedback  WHERE departmenthead_messagestatus = 0';

$feedbackop_result = mysqli_query($con, $feedbackop_query);



while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {

    $ward_floor = $feedbackop_object->ward;
    $parameter = json_decode($feedbackop_object->dataset);

    $patient_name = $parameter->name;
    $patient_uhid = $parameter->patientid;
    $patient_ward = $parameter->ward;
    $patient_bedno = $parameter->bedno;

    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' GROUP BY  department.description';

    $ticketsop_result = mysqli_query($con, $ticketsop_query);

    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {



        $tickets_generate = true;

        // $number = $ticketsop_object->mobile;

        $alternate_number = $ticketsop_object->alternate_mobile;

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'opf/track/' . $TID;

        $uuid = op_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;             //pointing to public_html/ticket

        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));

        $user_list = get_user_by_question($ticketsop_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $floor_wards = json_decode($user_row->floor_ward, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($patient_ward, $floor_wards)) {
                $users_dept = get_user_by_sms_activity('OP-SMS-DEPTHEAD', $con);
                if (!empty($users_dept)) {

                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

                    $conn_g->query($query1);
                }
                // Retrieve the list of users for the new condition
                $users_whatsapp = get_user_by_sms_activity('OP-WHATSAPP-DEPTHEAD', $con);
                if (!empty($users_whatsapp)) {
                    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_negativeexperience_oppatients', '" . json_encode([$hospitalname, $patient_name, $patient_uhid, $patient_ward, $Concern_Category, $Concern_Area, $department_head_link_whatsapp]) . "', 
             'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";

                    // Execute the second query
                    if ($conn_g->query($insert_notification_query) === TRUE) {
                        echo "Data inserted into notifications table successfully.<br>";
                    } else {
                        echo "Error: " . $con->error . "<br>";
                    }
                    // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $alternate_number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

                    // $conn_g->query($query2);
                }
            }
        }
    }



    $update_query = 'Update bf_outfeedback set departmenthead_messagestatus = 1 WHERE id=' . $feedbackop_object->id;

    mysqli_query($con, $update_query);
}



//message to department head(op) when ticket is REOPEN  ..................................................................................................................



$feedbackop_query = "SELECT * FROM  ticketsop  WHERE status = 'Reopen'";

$feedbackop_result = mysqli_query($con, $feedbackop_query);



while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {



    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' AND ticketsop.reopen_ticket_alert = 0 GROUP BY  department.description';

    $ticketsop_result = mysqli_query($con, $ticketsop_query);

    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {



        $tickets_generate = true;

        // $number = $ticketsop_object->mobile;

        $department = $ticketsop_object->description;

        $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid   WHERE  feedbackid = ' . $feedbackop_object->id . ' AND ticketsop.reopen_ticket_alert = 0 AND department.description="' . $ticketsop_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'opf/track/' . $TID;

        $uuid = op_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;             //pointing to public_html/ticket



        $message = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($ticketsop_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;

            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update ticketsop set reopen_ticket_alert = 1 WHERE id=' . $feedbackop_object->id;

    mysqli_query($con, $update_query);
}



//message to department head(op) when ticket is TRANSFERED  ...........................................................................................................



$feedbackop_query = "SELECT * FROM  ticketsop  WHERE status = 'Transfered'";

$feedbackop_result = mysqli_query($con, $feedbackop_query);



while ($feedbackop_object = mysqli_fetch_object($feedbackop_result)) {



    $ticketsop_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid_trasfered   WHERE  feedbackid = ' . $feedbackop_object->id . ' AND ticketsop.transfer_ticket_alert = 0 GROUP BY  department.description';

    $ticketsop_result = mysqli_query($con, $ticketsop_query);

    $ticketsop_rowcount = mysqli_num_rows($ticketsop_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($ticketsop_object = mysqli_fetch_object($ticketsop_result)) {



        $tickets_generate = true;

        // $number = $ticketsop_object->mobile;

        $department = $ticketsop_object->description;

        $department_query = 'SELECT * FROM  ticketsop  inner JOIN department ON department.dprt_id = ticketsop.departmentid_trasfered   WHERE  feedbackid = ' . $feedbackop_object->id . ' AND ticketsop.transfer_ticket_alert = 0 AND department.description="' . $ticketsop_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'opf/track/' . $TID;

        $uuid = op_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;             //pointing to public_html/ticket



        $message = 'Alert: A negative experience has been reported by an outpatient at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($ticketsop_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;

            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292853","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update ticketsop set transfer_ticket_alert = 1 WHERE id=' . $feedbackop_object->id;

    mysqli_query($con, $update_query);
}



//isr  departmenthead(isr) message when ticket is OPEN ..................................................................................................................



function isr_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedback_isr_query = 'SELECT * FROM  bf_feedback_esr  WHERE departmenthead_messagestatus = 0';

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

        // $number = $tickets_isr_object->mobile;

        $alternate_number = $tickets_isr_object->alternate_mobile;

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

        $uuid = isr_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket

        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));

        $user_list = get_user_by_question($tickets_isr_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $floor_wards = json_decode($user_row->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {

                $users_dept = get_user_by_sms_activity('ISR-SMS-DEPTHEAD', $con);
                if (!empty($users_dept)) {

                    $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292999","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

                    $conn_g->query($query1);
                }

                // Retrieve the list of users for the new condition
                $users_whatsapp = get_user_by_sms_activity('ISR-WHATSAPP-DEPTHEAD', $con);
                if (!empty($users_whatsapp)) {
                    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'staffsmsalert_for_servicerequest', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $emp_ward, $emp_bed_no,$emp_ward, $emp_name, $emp_contactnumber, $department_head_link_whatsapp]) . "', 
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
        // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $alternate_number . '","1607100000000292999","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid2 . '")';

        // $conn_g->query($query2);
    }



    $update_query = 'Update bf_feedback_esr set departmenthead_messagestatus = 1 WHERE id=' . $feedback_isr_object->id;

    mysqli_query($con, $update_query);
}



//isr  departmenthead(isr) message when ticket is REOPEN ..................................................................................................................



$feedback_isr_query = "SELECT * FROM  tickets_esr  WHERE status = 'Reopen'";

$feedback_isr_result = mysqli_query($con, $feedback_isr_query);



while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {



    $tickets_isr_query = 'SELECT tickets_esr.*, department.*, bf_feedback_esr.* FROM tickets_esr INNER JOIN department ON department.dprt_id = tickets_esr.departmentid INNER JOIN bf_feedback_esr ON bf_feedback_esr.id = tickets_esr.feedbackid WHERE feedbackid = ' . $feedback_isr_object->id . ' AND tickets_esr.reopen_ticket_alert = 0 GROUP BY department.description';

    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);

    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {


        $parameter = json_decode($tickets_isr_object->dataset);
        // print_r($parameter);


        $emp_ward = $parameter->ward;
        $emp_bed_no = $parameter->bedno;
        $emp_name = $parameter->name;
        $patientid = $parameter->patientid;
        $incident_type = $parameter->incident_type;
        $priority = $parameter->priority;
        $emp_contactnumber = $parameter->contactnumber;
        $tickets_generate = true;

        // $number = $tickets_isr_object->mobile;

        $department = $tickets_isr_object->description;

        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND tickets_esr.reopen_ticket_alert = 0 AND department.description="' . $tickets_isr_object->description . '"';

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

        $uuid = isr_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket

        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));

        $user_list = get_user_by_question($tickets_isr_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292999","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);

            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'servicerequest_reopen_message_for_staff', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $emp_ward, $emp_bed_no,$emp_ward, $emp_name, $emp_contactnumber, $department_head_link_whatsapp]) . "', 
            'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }


        $users_whatsapp = get_user_by_sms_activity('ISR-REOPEN-WHATSAPP-ALERT-ADMINS', $con);

        foreach ($users_whatsapp as $users_whatsapp_object) {
            // Check if $patient_ward matches any value in $floor_wards
            $number = $users_whatsapp_object->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292999","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);

            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'servicerequest_reopen_message_to_staff', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $emp_ward, $emp_bed_no, $emp_name, $emp_contactnumber, $department_head_link_whatsapp, $hospitalname]) . "', 
            'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }

        }
    }



    $update_query = 'Update tickets_esr set reopen_ticket_alert = 1 WHERE id=' . $feedback_isr_object->id;

    mysqli_query($con, $update_query);
}



//isr  departmenthead(isr) message when ticket is TRANSFER ..................................................................................................................



$feedback_isr_query = "SELECT * FROM  tickets_esr  WHERE status = 'Transfered'";

$feedback_isr_result = mysqli_query($con, $feedback_isr_query);



while ($feedback_isr_object = mysqli_fetch_object($feedback_isr_result)) {



    $tickets_isr_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND tickets_esr.transfer_ticket_alert = 0 GROUP BY  department.description';

    $tickets_isr_result = mysqli_query($con, $tickets_isr_query);

    $tickets_isr_rowcount = mysqli_num_rows($tickets_isr_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_isr_object = mysqli_fetch_object($tickets_isr_result)) {



        $tickets_generate = true;

        // $number = $tickets_isr_object->mobile;

        $department = $tickets_isr_object->description;

        $department_query = 'SELECT * FROM  tickets_esr  inner JOIN department ON department.dprt_id = tickets_esr.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_isr_object->id . ' AND tickets_esr.transfer_ticket_alert = 0 AND department.description="' . $tickets_isr_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'isr/track/' . $TID;

        $uuid = isr_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: Service request received from an employee at ' . $hospitalname . '.%0aFor details, please follow the link: ' . $department_head_link . '%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_isr_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000292999","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update tickets_esr set transfer_ticket_alert = 1 WHERE id=' . $feedback_isr_object->id;

    mysqli_query($con, $update_query);
}






//incident  departmenthead(incident) message when ticket is OPEN ..................................................................................................



function incident_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedback_incident_query = 'SELECT * FROM  bf_feedback_incident  WHERE departmenthead_messagestatus = 0';

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

        // $number = $tickets_incident_object->mobile;

        $alternate_number = $tickets_incident_object->alternate_mobile;

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

        $uuid = incident_departmenthead_tracking_link_UniqueId();

        $department_head_link = 'h.efeedor.com/tkt/?p=' . $uuid;    //pointing to public_html/ticket

        $department_head_link_whatsapp = 'h.efeedor.com/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message


        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));





        $user_list = get_user_by_question($tickets_incident_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $floor_wards = json_decode($user_row->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {

                $users_dept = get_user_by_sms_activity('INC-SMS-DEPTHEAD', $con);
                if (!empty($users_dept)) {

                    // $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

                    // $conn_g->query($query1);
                }

                // Retrieve the list of users for the new condition
                $users_whatsapp = get_user_by_sms_activity('INC-WHATSAPP-DEPTHEAD', $con);
                if (!empty($users_whatsapp)) {
                    $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
             VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'issue_update_staff', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $risk_matrix, $priority, $incident_type, $emp_ward, $emp_bed_no, $emp_name, $emp_contactnumber, $department_head_link_whatsapp]) . "', 
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
    }



    $update_query = 'Update bf_feedback_incident set departmenthead_messagestatus = 1 WHERE id=' . $feedback_incident_object->id;

    mysqli_query($con, $update_query);
}


//incident  departmenthead(incident) message when ticket is REOPEN ..................................................................................................



$feedback_incident_query = "SELECT * FROM  tickets_incident  WHERE status = 'Reopen'";

$feedback_incident_result = mysqli_query($con, $feedback_incident_query);



while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {



    $tickets_incident_query = 'SELECT tickets_incident.*, department.*, bf_feedback_incident.* FROM tickets_incident INNER JOIN department ON department.dprt_id = tickets_incident.departmentid INNER JOIN bf_feedback_incident ON bf_feedback_incident.id = tickets_incident.feedbackid WHERE feedbackid = ' . $feedback_incident_object->id . ' AND tickets_incident.reopen_ticket_alert = 0 GROUP BY department.description';

    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);

    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $parameter = json_decode($tickets_incident_object->dataset);
        // print_r($parameter);


        $emp_ward = $parameter->ward;
        $emp_bed_no = $parameter->bedno;
        $emp_name = $parameter->name;
        $patientid = $parameter->patientid;
        $incident_type = $parameter->incident_type;
        $priority = $parameter->priority;
        $emp_contactnumber = $parameter->contactnumber;

        $tickets_generate = true;

        // $number = $tickets_incident_object->mobile;

        $department = $tickets_incident_object->description;

        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND tickets_incident.reopen_ticket_alert = 0 AND department.description="' . $tickets_incident_object->description . '"';

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

        $uuid = incident_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket
        $department_head_link_whatsapp = '10.10.10.103/tkts/?p=' . $uuid;    //pointing to public_html/tickets for sending whatsapp message



        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_incident_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);

            $insert_notification_query = "INSERT INTO notifications_whatsapp (destination, userName, campaignName, templateParams, source, media, buttons, carouselCards, location, paramsFallbackValue, status,meta,uuid) 
            VALUES ('91$number', 'ITATONE POINT CONSULTING LLP 7345', 'incident_reopen_staffalertsms_on', '" . json_encode([$hospitalname, $Concern_Category, $Concern_Area, $incident_type, $priority, $emp_ward, $emp_bed_no, $department_head_link_whatsapp, $hospitalname]) . "', 
            'new-landing-page form', '{}', '[]', '[]', '{}', '" . json_encode(["FirstName" => "user"]) . "', 'pending','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "','" . $uuid . "')";
            // Execute the second query
            if ($conn_g->query($insert_notification_query) === TRUE) {
                echo "Data inserted into notifications table successfully.<br>";
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        }
    }



    $update_query = 'Update tickets_incident set reopen_ticket_alert = 1 WHERE id=' . $feedback_incident_object->id;

    mysqli_query($con, $update_query);
}



//incident  departmenthead(incident) message when ticket is TRANSFER ..................................................................................................



$feedback_incident_query = "SELECT * FROM  tickets_incident  WHERE status = 'Transfered'";

$feedback_incident_result = mysqli_query($con, $feedback_incident_query);



while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {



    $tickets_incident_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND tickets_incident.transfer_ticket_alert = 0 GROUP BY  department.description';

    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);

    $tickets_incident_rowcount = mysqli_num_rows($tickets_incident_result);

    $tickets_generate = false;

    $total_ticket = 0;

    $department = '';

    $message = '';

    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {



        $tickets_generate = true;

        // $number = $tickets_incident_object->mobile;

        $department = $tickets_incident_object->description;

        $department_query = 'SELECT * FROM  tickets_incident  inner JOIN department ON department.dprt_id = tickets_incident.departmentid_trasfered   WHERE  feedbackid = ' . $feedback_incident_object->id . ' AND tickets_incident.transfer_ticket_alert = 0 AND department.description="' . $tickets_incident_object->description . '"';

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

        $meta_data['link'] = $config_set['BASE_URL'] . 'incident/track/' . $TID;

        $uuid = incident_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: Incident reported by an employee at ' . $hospitalname . '. Follow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));
        $user_list = get_user_by_question($tickets_incident_object->slug, $con);

        foreach ($user_list as $user_row) {
            $number = $user_row->mobile;
            $query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000288910","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

            $conn_g->query($query);
        }
    }



    $update_query = 'Update tickets_incident set transfer_ticket_alert = 1 WHERE id=' . $feedback_incident_object->id;

    mysqli_query($con, $update_query);
}



//grievance  departmenthead(grievance) message when ticket is OPEN ..................................................................................................



function grievance_departmenthead_tracking_link_UniqueId()
{

    $prefix = ''; // You can add a prefix if desired

    $length = 10; // Desired length of the unique ID



    $id = uniqid($prefix, true);

    $id = str_replace('.', '', $id); // Remove the decimal point

    $id = substr($id, -$length); // Get the last 8 characters



    return $id;
}





$feedback_grievance_query = 'SELECT * FROM  bf_feedback_grievance  WHERE departmenthead_messagestatus = 0';

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

        // $number = $tickets_grievance_object->mobile;

        $alternate_number = $tickets_grievance_object->alternate_mobile;

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

        $uuid = grievance_departmenthead_tracking_link_UniqueId();

        $department_head_link = '10.10.10.103/tkt/?p=' . $uuid;    //pointing to public_html/ticket



        $message = 'Alert: A grievance has been reported by an employee at ' . $hospitalname . '.%0aFollow the link for details: ' . $department_head_link . '.%0a-EFEEDOR';

        $message = str_replace('&', 'and', str_replace(' ', '%20', $message));

        $user_list = get_user_by_question($tickets_grievance_object->slug, $con);

        foreach ($user_list as $user_row) {
            $floor_wards = json_decode($user_row->floor_ward_esr, true);
            // Check if $patient_ward matches any value in $floor_wards
            if (is_null($floor_wards) || empty($floor_wards) || in_array($emp_ward, $floor_wards)) {
                $number = $user_row->mobile;

                $query1 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $number . '","1607100000000291671","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid . '")';

                $conn_g->query($query1);



                // $query2 = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id` ,`HID`,`meta`,`uuid`) VALUES ("department_message","' . $message . '",0,"' . $alternate_number . '","1607100000000291671","' . $HID . '","' . mysqli_real_escape_string($con, json_encode($meta_data)) . '","' . $uuid2 . '")';

                // $conn_g->query($query2);
            }
        }
    }



    $update_query = 'Update bf_feedback_grievance set departmenthead_messagestatus = 1 WHERE id=' . $feedback_grievance_object->id;

    mysqli_query($con, $update_query);
}





$conn_g->close();

$con->close();

echo 'department head message end';
