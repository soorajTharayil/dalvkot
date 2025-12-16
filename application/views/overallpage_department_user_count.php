<?php

$alltickets = $this->ticketsesr_model->alltickets();
$opentickets = $this->ticketsesr_model->read();
$closedtickets = $this->ticketsesr_model->read_close();
$addressed = $this->ticketsesr_model->addressedtickets();


$alltickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
$opentickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
$closetickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
$addressedtickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
$dept_user = array();
foreach ($alltickets as $ticket) {
    if ($ticket->assign_user == 1 && $ticket->assign_to == $user_id) {
        $alltickets_assign_user_count++; // Increment the count if assign_user is equal to 1
        $dept_user[] = $ticket;
    }
}

foreach ($opentickets as $ticket) {
    if ($ticket->assign_user == 1 && $ticket->assign_to == $user_id) {
        $opentickets_assign_user_count++; // Increment the count if assign_user is equal to 1
    }
}

foreach ($closedtickets as $ticket) {
    if ($ticket->assign_user == 1 && $ticket->assign_to == $user_id) {
        $closetickets_assign_user_count++; // Increment the count if assign_user is equal to 1
    }
}

foreach ($addressed as $ticket) {
    if ($ticket->assign_user == 1 && $ticket->assign_to == $user_id) {
        $addressedtickets_assign_user_count++; // Increment the count if assign_user is equal to 1
    }
}


$isr_department_head_user_count['alltickets'] =  $alltickets_assign_user_count;
$isr_department_head_user_count['opentickets'] = $opentickets_assign_user_count;
$isr_department_head_user_count['closedticket'] = $closetickets_assign_user_count;
$isr_department_head_user_count['addressedtickets'] = $addressedtickets_assign_user_count;
