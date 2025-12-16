<?php 
$baseurl = 'https://efeedor.com/';
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl.'PHPMailer/escalate_mail.php');
echo $result = curl_exec($curl);


?>