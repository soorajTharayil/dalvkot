<?php
include 'calculate_remaining_days.php';
$department = $this->db->order_by('subscription_id', 'DESC')->get('subscription')->result();
$department = $department[0];
$remainingDays = calculateRemainingDays($department->delivered_end, $department->delivered_on);

$currentDate = new DateTime();
$expirationDate = new DateTime($department->delivered_end);
$interval = $currentDate->diff($expirationDate);

if ($currentDate > $expirationDate && $interval->days != 0) {
    $message = "Critical Alert: Your software license has expired ".$interval->days." days ago. Please renew your license immediately to avoid disruptions to your workflow.";
} elseif ($remainingDays === "Today") {
    $message = "Attention: Your software license will expire today at 11:59 PM. Renew now to ensure uninterrupted service.";
} elseif ($remainingDays === "Tomorrow") {
    $message = "Attention: Your software license will expire tomorrow. Renew now to ensure uninterrupted service.";
} elseif ($remainingDays <= 10) {
    $message = "Attention: Your software license will expire in ".$remainingDays." . Renew now to ensure uninterrupted service";
} elseif ($remainingDays <= 30) {
    $message = "Attention: Your software license will expire in ".$remainingDays." . Renew now to ensure uninterrupted service";
} 

echo $message;

?>
