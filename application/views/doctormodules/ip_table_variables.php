<?php

/* START DATE AND CALENDER */
$dates = get_from_to_date();
$pagetitle = $dates['pagetitle'];
$fdate = $dates['fdate'];
$tdate = $dates['tdate'];
$pagetitle = $dates['pagetitle'];
$fdate = date('Y-m-d', strtotime($fdate));
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
$days = $dates['days'];
/* END DATE AND CALENDER */


/* START TABLES FROM DATABASE */
$table_feedback = 'bf_feedback_doctors';
$table_patients = 'bf_opatients';
$sorttime = 'asc';
$setup = 'setup_doctor';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_doctor';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_doctor_message';
$type = 'doctor';
$department = 'department';
$reopen = 'Reopen';
/* END TABLES FROM DATABASE */

/* doctorsfeedback_model.php FOR GLOBAL UPDATES */
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);


$ticket = $this->doctorsfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);



// For count of total feedbacks and for charts only.
$ip_feedbacks_count = $this->doctorsfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// To see the total tickets count
$ip_tickets_count = $this->doctorsfeedback_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// tooltips
$ip_open_tickets = $this->doctorsfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$ip_reopen_tickets = $this->doctorsfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$ip_closed_tickets = $this->doctorsfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$ip_addressed_tickets = $this->doctorsfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$ip_tickets_tool = "Open Tickets: " . count($ip_open_tickets) . ', ' . "Closed Tickets: " . count($ip_closed_tickets) . ', ' . "Addressed Tickets: " . count($ip_addressed_tickets) . ',' . "Reopen Tickets: " . count($ip_reopen_tickets);

// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
$ticket_analisys = $this->doctorsfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
$alltickets = $this->ticketsdoctor_model->alltickets();
$opentickets = $this->ticketsdoctor_model->read();
$closedtickets = $this->ticketsdoctor_model->read_close();
$addressed = $this->ticketsdoctor_model->addressedtickets();


$op_department['alltickets'] = count($alltickets);
$op_department['opentickets'] = count($opentickets);
$op_department['closedticket'] = count($closedtickets);
$op_department['addressedtickets'] = count($addressed);

$sresult = $this->doctorsfeedback_model->setup_result($setup);



$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
    // print_r(count($ticket));
    if (count($ip_tickets_count) > 5) {
        if ($item['percentage'] > 0) {
            if ($item['percentage'] > $maxPercentage) {
                $maxPercentage = $item['percentage'];
                $maxDepartment = $item['department'];
            }

            if ($item['percentage'] < $minPercentage) {
                $minPercentage = $item['percentage'];
                $minDepartment = $item['department'];
            }
        }
    } else {
        $maxPercentage = NULL;
        $maxDepartment =  NULL;
        $minPercentage =  NULL;
        $minDepartment =  NULL;
    }
}

// IP ANALYTICS
$ip_nps = $this->doctorsfeedback_model->nps_analytics($table_feedback, $asc, $setup);
$ip_nps_tool = 'Promoters: ' . ($ip_nps['promoters_count']) . ', ' . "Detractors: " . ($ip_nps['detractors_count']) . ', ' . "Passives: " . ($ip_nps['passives_count']);
$ip_psat = $this->doctorsfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$ip_psat_tool = 'Satisfied Feedbacks: ' . ($ip_psat['satisfied_count']) . ', ' . "Unsatisfied Feedbacks: " . ($ip_psat['unsatisfied_count']) . '. ';
//  . "Neutral: " . ($ip_psat['neutral_count']);
$ticket_resolution_rate = $this->doctorsfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
$close_rate = $this->doctorsfeedback_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);

$ip_satisfied_count = $this->doctorsfeedback_model->get_satisfied_count($table_feedback, $table_tickets);
$ip_unsatisfied_count = $this->doctorsfeedback_model->get_unsatisfied_count($table_feedback, $table_tickets);

// Key Highlights
$key_highlights = $this->doctorsfeedback_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup);


$selectionarray = $this->doctorsfeedback_model->reason_to_choose_hospital($table_feedback, $sorttime);
// $close_rate = $this->doctorsfeedback_model->ticket_rate($table_tickets, $table_ticket_action, $closed);
// $close_time = $this->doctorsfeedback_model->convertSecondsToTime($close_rate);
// $ticket_close_rate = $close_time['days'] .  $close_time['hours'] . $close_time['minutes'];

$ip_link_feedback_dashboard = base_url($this->uri->segment(1) . '/feedback_dashboard');

$ip_link_tickets_dashboard = base_url($this->uri->segment(1) . '/department_tickets');




// individual patient feedback link
$ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_feedback?id=');

// All feedbacks
$ip_link_feedback_report = base_url($this->uri->segment(1) . '/feedbacks_report');

// psat analysis
$ip_link_satisfied_list =  base_url($this->uri->segment(1) . '/psat_satisfied_list');
$ip_link_unsatisfied_list =  base_url($this->uri->segment(1) . '/psat_unsatisfied_list');
$ip_link_psat_page = base_url($this->uri->segment(1) . '/psat_page');


// nps analysis
$ip_link_nps_page = base_url($this->uri->segment(1) . '/nps_page');
$ip_link_promoter_list = base_url($this->uri->segment(1) . '/nps_promoter_list');
$ip_link_detractor_list = base_url($this->uri->segment(1) . '/nps_detractors_list');
$ip_link_passives_list = base_url($this->uri->segment(1) . '/nps_passive_list');

// tickets
$ip_link_ticket_dashboard = base_url($this->uri->segment(1) . '/ticket_dashboard');
$ip_link_opentickets = base_url($this->uri->segment(1) . '/opentickets');
$ip_link_addressedtickets = base_url($this->uri->segment(1) . '/addressedtickets');
$ip_link_closedtickets = base_url($this->uri->segment(1) . '/closedtickets');
$ip_link_alltickets = base_url($this->uri->segment(1) . '/alltickets');
$ip_link_ticket_resolution_rate = base_url($this->uri->segment(1) . '/ticket_resolution_rate');
$ip_link_average_resolution_time= base_url($this->uri->segment(1) . '/average_resolution_time');

$ip_link_capa = base_url($this->uri->segment(1) . '/capa_report');
$ip_link_staffappriciation = base_url($this->uri->segment(1) . '/staff_appreciation');
$ip_link_comments = base_url($this->uri->segment(1) . '/comments');
$ip_link_notifications_list = base_url($this->uri->segment(1) . '/notifications_list');


// downloads
$ip_download_overall_pdf = base_url($this->uri->segment(1) . '/overall_pdf_report');
$ip_download_overall_excel = base_url($this->uri->segment(1) . '/overall_excel_report');
$ip_download_patient_excel = base_url($this->uri->segment(1) . '/overall_patient_excel');
$ip_download_department_excel = base_url($this->uri->segment(1) . '/overall_department_excel');



$a = count($ip_open_tickets);
$b = count($ip_reopen_tickets);
$openticket_count = $a + $b;
?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->