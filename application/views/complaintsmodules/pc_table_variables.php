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
$table_feedback = 'bf_feedback_int';
$table_patients = 'bf_patients';
$sorttime = 'asc';
$setup = 'setup_int';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_int';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_int_message';
$reopen = 'Reopen';
$type = 'interim';
/* END TABLES FROM DATABASE */

/* pc_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$int_feedbacks_count = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$int_tickets_count = $this->pc_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$int_open_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$int_reopen_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$int_closed_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$int_addressed_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$int_tickets_tool = "Open Tickets: " . count($int_open_tickets) . ', ' . "Closed Tickets: " . count($int_closed_tickets) . ', ' . "Addressed Tickets: " . count($int_addressed_tickets) . ',' . "Reopen Tickets: " . count($int_reopen_tickets);
$ticket_resolution_rate = $this->pc_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate = $this->pc_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);

$ticket = $this->pc_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
$ticket_analisys = $this->pc_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);

$alltickets = $this->ticketsint_model->alltickets();
$opentickets = $this->ticketsint_model->read();
$closedtickets = $this->ticketsint_model->read_close();
$addressed = $this->ticketsint_model->addressedtickets();


$int_department['alltickets'] = count($alltickets);
$int_department['opentickets'] = count($opentickets);
$int_department['closedticket'] = count($closedtickets);
$int_department['addressedtickets'] = count($addressed);

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




$sresult = $this->efeedor_model->setup_result('setup_int');


// $int_link_feedback_dashboard = base_url($this->uri->segment(1).'/feedback_dashboard');
// $int_link_tickets_dashboard = base_url($this->uri->segment(1).'/department_tickets');




// individual patient feedback link
$int_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');

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
$int_link_addressedtickets = base_url($this->uri->segment(1) . '/addressedtickets');
$int_link_closedtickets = base_url($this->uri->segment(1) . '/closedtickets');
$int_link_alltickets = base_url($this->uri->segment(1) . '/alltickets');
$ip_link_ticket_resolution_rate = base_url($this->uri->segment(1) . '/ticket_resolution_rate');
$ip_link_average_resolution_time= base_url($this->uri->segment(1) . '/average_resolution_time');


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