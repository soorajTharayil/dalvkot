<?
include('../api/db.php');
include('/home/efeedor/globalconfig.php');
function generateUniqueId()
{
    $prefix = ''; // You can add a prefix if desired
    $length = 10; // Desired length of the unique ID

    $id = uniqid($prefix, true);
    $id = str_replace('.', '', $id); // Remove the decimal point
    $id = substr($id, -$length); // Get the last 8 characters

    return $id;
}



// for interim
$query = 'SELECT * FROM bf_patients WHERE whatsapp_message = 0';
$flore = mysqli_query($con, $query);
while ($r = mysqli_fetch_object($flore)) {
    $message = '';
    $number = $r->mobile;
    $name = $r->name;
    $uuid = generateUniqueId();
    $slink = 'h.efeedor.com/pat/?p=' . $uuid;
    /* FOR Patient Message */
    // $message = 'Hi, %0aThank you for choosing ' . $hospitalname . ' for your healthcare needs. If you have any concern or request during your stay, please click on the link below and register. ' . $slink;
    // $message .= '%0a' . $COMPANYNAME;

$message = 'Dear ' .$name. ',
Thank you for choosing ' .$hospitalname. '. If you have any concern or request during your stay, please click on the link below and register. 
'.$slink. '
-ITATONE';
    
    $TEMPID = '1607100000000271239';

    $meta_data['config_set_url'] = $config_set['BASE_URL'];
    $meta_data['config_set_domain'] = $config_set['DOMAIN'];
    $meta_data['patient_detail'] = $r;

    $query = "INSERT INTO `whatsapp_notification`(`uuid`,`type`, `message`, `status`, `mobile_email`, `template_id`, `HID`,`meta`) VALUES ('$uuid','message', '$message', 0, '$number', '$TEMPID', '$HID','" . mysqli_real_escape_string($con, json_encode($meta_data)) . "')";
    $conn_g->query($query);

    $query = 'UPDATE bf_patients SET whatsapp_message = 1 WHERE id=' . $r->id;
    mysqli_query($con, $query);
}

$conn_g->close();
$con->close();
