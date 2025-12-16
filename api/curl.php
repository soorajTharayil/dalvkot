<?php

date_default_timezone_set('Asia/Kolkata');

include('db.php');



//pin generation for employee creation
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $baseurl.'api/pin_generation_employee.php');
// $result = curl_exec($curl);

//automatic patient discharge 7 Days
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'api/automatic_patient_discharge.php');
$result = curl_exec($curl);

//all patient related sms
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_messages/patient_message.php');
$result = curl_exec($curl);

//all employee related sms
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_messages/employee_message.php');
$result = curl_exec($curl);

//all department head related sms
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_messages/department_head_message.php');
$result = curl_exec($curl);


//all admin related sms
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_messages/admins_message.php');
$result = curl_exec($curl);

//all department head related emails
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_PHPMailer/department_head_email.php');
$result = curl_exec($curl);


//all admin related emails
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_PHPMailer/admins_email.php');
$result = curl_exec($curl);

//all admin related emails
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'new_PHPMailer/patient_email.php');
$result = curl_exec($curl);

//all admin related emails
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'escalation_set/int_escalation.php');
$result = curl_exec($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'escalation_set/ip_escalation.php');
$result = curl_exec($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'escalation_set/op_escalation.php');
$result = curl_exec($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'escalation_set/isr_escalation.php');
$result = curl_exec($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $baseurl.'escalation_set/inc_escalation.php');
$result = curl_exec($curl);

?>