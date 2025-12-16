

<?php
function calculateRemainingDays($endDate, $onDate)
{
    // Convert dates to DateTime objects
    $currentDate = new DateTime();
    $expirationDate = new DateTime($endDate);
    $deliveryDate = new DateTime($onDate);

    // Check if delivery is not yet made
  
    // Calculate remaining days
    $interval = $currentDate->diff($expirationDate);

    // Check if expired
    if ($currentDate > $expirationDate && $interval->days != 0) {
        return "Expired " . $interval->days . " days ago";
    }

    // Check if today
    if ($expirationDate->format('Y-m-d') == $currentDate->format('Y-m-d')) {
        return "Today";
    }

    // Check if tomorrow
    $tomorrow = new DateTime('tomorrow');
    if ($expirationDate->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
        return "Tomorrow";
    }

    // Return remaining days
    return "" . $interval->days . " Days";
}




?>
