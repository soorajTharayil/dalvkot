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
$table_feedback = 'bf_feedback_incident';
$table_patients = 'bf_employees_incident';
$sorttime = 'asc';
$setup = 'setup_incident';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_incident';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_incident_message';
$reopen = 'Reopen';
$type = 'incident';
/* END TABLES FROM DATABASE */

/* incident_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$int_feedbacks_count = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$int_tickets_count = $this->incident_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$int_open_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$int_reopen_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$int_closed_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$int_addressed_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$int_tickets_tool = "Open Tickets: " . count($int_open_tickets) . ', ' . "Closed Tickets: " . count($int_closed_tickets) . ', ' . "Addressed Tickets: " . count($int_addressed_tickets) . ',' . "Reopen Tickets: " . count($int_reopen_tickets);
$ticket_resolution_rate = $this->incident_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate = $this->incident_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);

$ticket = $this->incident_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
$ticket_analisys = $this->incident_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);

$alltickets = $this->ticketsincidents_model->alltickets();
$opentickets = $this->ticketsincidents_model->read();
$closedtickets = $this->ticketsincidents_model->read_close();
$addressed = $this->ticketsincidents_model->describetickets();
$reject = $this->ticketsincidents_model->rejecttickets();

$inc_department['alltickets'] = count($alltickets);
$inc_department['opentickets'] = count($opentickets);
$inc_department['closedticket'] = count($closedtickets);
$inc_department['addressedtickets'] = count($addressed);
$inc_department['rejecttickets'] = count($reject);
$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
    // print_r(count($ticket));
    if (count($int_tickets_count) > 5) {
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


// // IP ANALYTICS
// $int_nps = $this->incident_model->nps_analytics($table_feedback, $asc, $setup);
// $int_nps_tool = 'Promoters: ' . ($int_nps['promoters_count']) . ', ' . "Detractors: " . ($int_nps['detractors_count']) . ', ' . "Passives: " . ($int_nps['passives_count']);
// $int_psat = $this->incident_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
// $int_psat_tool = 'Satisfied Patients: ' . ($int_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($int_psat['unsatisfied_count']) . '. ';
// //  . "Neutral: " . ($int_psat['neutral_count']);


// $int_satisfied_count = $this->incident_model->get_satisfied_count($table_feedback, $table_tickets);
// $int_unsatisfied_count = $this->incident_model->get_unsatisfied_count($table_feedback, $table_tickets);

// // Key Highlights
// $key_highlights = $this->incident_model->key_highlights($table_feedback, $asc, $setup);


$sresult = $this->efeedor_model->setup_result('setup_int');


// $int_link_feedback_dashboard = base_url($this->uri->segment(1).'/feedback_dashboard');
// $int_link_tickets_dashboard = base_url($this->uri->segment(1).'/department_tickets');




// individual patient feedback link
$int_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');

// All feedbacks
$int_link_feedback_report = base_url($this->uri->segment(1) . '/feedbacks_report');

// psat analysis
$int_link_satisfied_list =  base_url($this->uri->segment(1) . '/psat_satisfied_list');
$int_link_unsatisfied_list =  base_url($this->uri->segment(1) . '/psat_unsatisfied_list');
$int_link_psat_page = base_url($this->uri->segment(1) . '/psat_page');

// nps analysis
$int_link_nps_page = base_url($this->uri->segment(1) . '/nps_page');
$int_link_promoter_list = base_url($this->uri->segment(1) . '/nps_promoter_list');
$int_link_detractor_list = base_url($this->uri->segment(1) . '/nps_detractors_list');
$int_link_passives_list = base_url($this->uri->segment(1) . '/nps_passive_list');

// tickets
$int_link_ticket_dashboard = base_url($this->uri->segment(1) . '/ticket_dashboard');
$int_link_opentickets = base_url($this->uri->segment(1) . '/opentickets');
$int_link_addressedtickets = base_url($this->uri->segment(1) . '/describetickets');
$int_link_closedtickets = base_url($this->uri->segment(1) . '/closedtickets');
$int_link_alltickets = base_url($this->uri->segment(1) . '/alltickets');
$ip_link_ticket_resolution_rate = base_url($this->uri->segment(1) . '/ticket_resolution_rate');
$ip_link_average_resolution_time = base_url($this->uri->segment(1) . '/average_resolution_time');
$int_link_rejecttickets = base_url($this->uri->segment(1) . '/rejecttickets');

$int_link_capa = base_url($this->uri->segment(1) . '/capa_report');
$int_link_staffappriciation = base_url($this->uri->segment(1) . '/staff_appreciation');
$int_link_comments = base_url($this->uri->segment(1) . '/complaints');
$int_link_notifications_list = base_url($this->uri->segment(1) . '/notifications_list');


// downloads
$int_download_overall_pdf = base_url($this->uri->segment(1) . '/overall_pdf_report');
$int_download_comments_excel = base_url($this->uri->segment(1) . '/downloadcomments');
$int_download_patient_excel = base_url($this->uri->segment(1) . '/overall_patient_report');
$int_download_department_excel = base_url($this->uri->segment(1) . '/overall_department_excel');

$a = count($int_open_tickets);
$b = count($int_reopen_tickets);
$openticket_count = $a + $b;

?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->