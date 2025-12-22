<?php
include('env.php');
include('/var/www/html/globalconfig.php');

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

// Enable error reporting for development; comment the line below in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

$active_group = 'default';
$active_record = true;

$link = $config_set['DOMAIN'];

$db['hostname'] = $config_set['DBHOST'];
$db['username'] = $config_set['DBUSER'];
$db['password'] = $config_set['DBPASSWORD'];
$db['database'] = $config_set['DBNAME'];
$baseurl = $config_set['BASE_URL'];

/* Create a connection to the database */
$con = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);
if ($con->connect_error) {
    die('Could not connect to the database server: ' . $con->connect_error);
}

/* Fetch data from the 'setting' table */
$setting_query = 'SELECT * FROM `setting`';
$setting_result = $con->query($setting_query);

if ($setting_result === false) {
    die('Error executing setting query: ' . $con->error);
}

while ($user_object = $setting_result->fetch_object()) {
    $hid = $user_object->description;
}

$notification_query = "SELECT * FROM `notification` WHERE HID = '$hid'";
$notification_result = $conn_g->query($notification_query);

if ($notification_result === false) {
    die('Error executing notification query: ' . $con->error);
}


$notification_object = $notification_result->fetch_object();
$user_notification_count = 0;
$patient_message = 0;
$department_message = 0;
$admins_message = 0;

$pen_user_notification_count = 0;
$pen_patient_message = 0;
$pen_department_message = 0;
$pen_admins_message = 0;
while ($notification_object = $notification_result->fetch_object()) {
    $field_count = mysqli_num_fields($notification_result);

    if ($notification_object->type == 'user' && $notification_object->status == 1) {
        $user_notification_count++;
    }
    if ($notification_object->type == 'patient_message' && $notification_object->status == 1) {
        $patient_message++;
    }
    if ($notification_object->type == 'department_message' && $notification_object->status == 1) {
        $department_message++;
    }
    if ($notification_object->type == 'admins_message' && $notification_object->status == 1) {
        $admins_message++;
    }



    if ($notification_object->type == 'user' && $notification_object->status == 0) {
        $pen_user_notification_count++;
    }
    if ($notification_object->type == 'patient_message' && $notification_object->status == 0) {
        $pen_patient_message++;
    }
    if ($notification_object->type == 'department_message' && $notification_object->status == 0) {
        $pen_department_message++;
    }
    if ($notification_object->type == 'admins_message' && $notification_object->status == 0) {
        $pen_admins_message++;
    }
}


echo "\n";
echo "\n";
echo "Notifications and alerts stats";
echo "\n";
echo "\n";
echo "Total user creation messages sent: " . $user_notification_count . "\n";
echo "Total patient messages sent: " . $patient_message . "\n";
echo "Total alerts sent for department heads: " . $department_message . "\n";
echo "Total alerts sent for admins: " . $admins_message . "\n";
$success_total = $admins_message + $user_notification_count + $department_message + $patient_message;
echo "Total alerts success: " . $success_total . "\n";




echo "\n";
echo "\n";
echo "\n";

echo "Total user creation messages pending: " . $pen_user_notification_count . "\n";
echo "Total patient messages pending: " . $pen_patient_message . "\n";
echo "Total alerts pending for department heads: " . $pen_department_message . "\n";
echo "Total alerts pending for admins: " . $pen_admins_message . "\n";
$pending_total = $pen_user_notification_count + $pen_patient_message + $pen_department_message + $pen_admins_message;
echo "Total alerts pending: " . $pending_total . "\n";


$setting_result->close();
$con->close();
