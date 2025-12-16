<?php

$table_feedback = 'bf_feedback_adf';
$table_patients = 'bf_patients';
$department = 'department';
$type = 'adf';
$sorttime = 'asc';
$setup = 'setup_adf';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_adf';
$open = 'Open';
$closed = 'Closed';
$status = 'Closed';
$addressed = 'Addressed';
$reopen = 'Reopen';
$table_ticket_action = 'ticket_message_adf';

/* END TABLES FROM DATABASE */

/* admissionfeedback_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$adf_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);



$ticket_resolution_rate_adf = $this->admissionfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
$close_rate_adf = $this->admissionfeedback_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_adf = secondsToTime($close_rate_adf);



// To see the total tickets count
$adf_tickets_count = $this->admissionfeedback_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);

// To see the total tickets count
$adf_tickets_count = $this->admissionfeedback_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);

$adf_open_tickets = $this->admissionfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$adf_reopen_tickets = $this->admissionfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$adf_closed_tickets = $this->admissionfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$adf_addressed_tickets = $this->admissionfeedback_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$adf_tickets_tool = "Open Tickets: " . count($adf_open_tickets) . ', ' . "Closed Tickets: " . count($adf_closed_tickets) . ', ' . "Addressed Tickets: " . count($adf_addressed_tickets) . ',' . "Reopen Tickets: " . count($adf_reopen_tickets);

$adf_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $asc, $setup);

$adf_nps_tool = 'Promoters: ' . ($adf_nps['promoters_count']) . ', ' . "Detractors: " . ($adf_nps['detractors_count']) . ', ' . "Passives: " . ($adf_nps['passives_count']);
$adf_psat = $this->admissionfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$adf_psat_tool = 'Satisfied Patients: ' . ($adf_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($adf_psat['unsatisfied_count']) . '. ';
//  . "Neutral: " . ($adf_psat['neutral_count']);
// $adf_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$adfalltickets = $this->ticketsadf_model->alltickets();
$adfopentickets = $this->ticketsadf_model->read();
$adfclosedtickets = $this->ticketsadf_model->read_close();
$adfaddressed = $this->ticketsadf_model->addressedtickets();


$adf_department['alltickets'] = count($adfalltickets);
$adf_department['opentickets'] = count($adfopentickets);
$adf_department['closedtickets'] = count($adfclosedtickets);
$adf_department['addressedtickets'] = count($adfaddressed);



$ticket = $this->admissionfeedback_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
//$int_department =    $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);



$adf_link_feedback_dashboard = base_url('admissionfeedback/feedback_dashboard');
$adf_link_tickets_dashboard = base_url('admissionfeedback/department_tickets');




// individual patient feedback link
$adf_link_patient_feedback = base_url('admissionfeedback/patient_feedback?id=');

// All feedbacks
$adf_link_feedback_report = base_url('admissionfeedback/feedbacks_report');

// psat analysis
$adf_link_satisfied_list =  base_url('admissionfeedback/psat_satisfied_list');
$adf_link_unsatisfied_list =  base_url('admissionfeedback/psat_unsatisfied_list');
$adf_link_psat_page = base_url('admissionfeedback/psat_page');

// nps analysis
$adf_link_nps_page = base_url('admissionfeedback/nps_page');
$adf_link_promoter_list = base_url('admissionfeedback/nps_promoter_list');
$adf_link_detractor_list = base_url('admissionfeedback/nps_detractors_list');
$adf_link_passives_list = base_url('admissionfeedback/nps_passive_list');

// tickets
$adf_link_ticket_dashboard = base_url('admissionfeedback/ticket_dashboard');
$adf_link_opentickets = base_url('admissionfeedback/opentickets');
$adf_link_addressedtickets = base_url('admissionfeedback/addressedtickets');
$adf_link_closedtickets = base_url('admissionfeedback/closedtickets');
$adf_link_alltickets = base_url('admissionfeedback/alltickets');


$adf_link_capa = base_url('admissionfeedback/capa_report');
$adf_link_staffappriciation = base_url('admissionfeedback/staff_appreciation');
$adf_link_comments = base_url('admissionfeedback/comments');
$adf_link_notifications_list = base_url('admissionfeedback/notifications_list');


// downloads
$adf_download_overall_pdf = base_url('admissionfeedback/overall_pdf_report?fdate=');
$adf_download_overall_excel = base_url('admissionfeedback/overall_excel_report?fdate=');
$adf_download_patient_excel = base_url('admissionfeedback/overall_patient_report?fdate=');
$adf_download_department_excel = base_url('admissionfeedback/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->