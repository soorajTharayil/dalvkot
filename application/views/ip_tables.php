<?php

/* START DATE AND CALENDER */
// $dates = get_from_to_date();
// $pagetitle = $dates['pagetitle'];
// $fdate = $dates['fdate'];
// $tdate = $dates['tdate'];
// $pagetitle = $dates['pagetitle'];
// $fdate = date('Y-m-d', strtotime($fdate));
// $fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
// $days = $dates['days'];
/* END DATE AND CALENDER */
$fdate = $_SESSION['from_date'];
$tdate = $_SESSION['to_date'];


/* START TABLES FROM DATABASE */
$table_feedback = 'bf_feedback';
$table_patients = 'bf_patients';
$sorttime = 'asc';
$setup = 'setup';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_message';
$setup = 'setup';
$type = 'inpatient';
$department = 'department';
$reopen = 'Reopen';
/* END TABLES FROM DATABASE */

/* ipd_model.php FOR GLOBAL UPDATES */
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$department = $this->ipd_opt_model->get_department($type);
$get_tickes = $this->ipd_opt_model->get_tickets($table_feedback, $table_tickets);

$ticket = $this->ipd_opt_model->tickets_recived_by_department($type, $table_feedback, $table_tickets,$department,$get_tickes);

//  print_r($ticket);



// For count of total feedbacks and for charts only.

$ip_feedbacks_count = $this->ipd_opt_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
$totalFeedbackList = $ip_feedbacks_count;
$allTickets = $this->ipd_opt_model->get_tickets($table_feedback, $table_tickets);
// To see the total tickets count
//TODO Optimization 1
$ip_tickets_count = $this->ipd_opt_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// tooltips
$ip_open_tickets = $this->ipd_opt_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$ip_reopen_tickets = $this->ipd_opt_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$ip_closed_tickets = $this->ipd_opt_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$ip_addressed_tickets = $this->ipd_opt_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
//TODO Optimization 1

$ip_tickets_tool = "Open Tickets: " . count($ip_open_tickets) . ', ' . "Closed Tickets: " . count($ip_closed_tickets) . ', ' . "Addressed Tickets: " . count($ip_addressed_tickets) . ',' . "Reopen Tickets: " . count($ip_reopen_tickets);

// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
// echo time();
// echo '<br />';
$alltickets = $this->tickets_model->alltickets();
$opentickets = $this->tickets_model->read();
$closedtickets = $this->tickets_model->read_close();
$addressed = $this->tickets_model->addressedtickets();


$ip_department['alltickets'] = count($alltickets);
$ip_department['opentickets'] = count($opentickets);
$ip_department['closedtickets'] = count($closedtickets);
$ip_department['addressedtickets'] = count($addressed);

$sresult = $this->ipd_model->setup_result('setup');




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
$ip_nps = $this->ipd_opt_model->nps_analytics($table_feedback, $asc, $totalFeedbackList);
$ip_nps_tool = 'Promoters: ' . ($ip_nps['promoters_count']) . ', ' . "Detractors: " . ($ip_nps['detractors_count']) . ', ' . "Passives: " . ($ip_nps['passives_count']);
$ip_psat = $this->ipd_opt_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime,$allTickets,$totalFeedbackList);
$ip_psat_tool = 'Satisfied Patients: ' . ($ip_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($ip_psat['unsatisfied_count']) . '. ';
// //  . "Neutral: " . ($ip_psat['neutral_count']);
$ticket_resolution_rate_ip = $this->ipd_opt_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback,$allTickets);
$close_rate_ip = $this->ipd_opt_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action,$allTickets);
$ticket_close_rate_ip = secondsToTime($close_rate_ip);

 $ip_satisfied_count = $this->ipd_opt_model->get_satisfied_count($table_feedback, $table_tickets,$totalFeedbackList);
 $ip_unsatisfied_count = $this->ipd_opt_model->get_unsatisfied_count($table_feedback, $table_tickets,$totalFeedbackList);

// // Key Highlights
 $key_highlights = $this->ipd_opt_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup,$totalFeedbackList);


 $selectionarray = $this->ipd_opt_model->reason_to_choose_hospital($table_feedback, $sorttime,$totalFeedbackList);

$ip_link_feedback_dashboard = base_url('ipd/feedback_dashboard');
$ip_link_tickets_dashboard = base_url('ipd/department_tickets');
// echo time();
// exit;



// individual patient feedback link
$ip_link_patient_feedback = base_url('ipd/patient_feedback?id=');

// All feedbacks
$ip_link_feedback_report = base_url('ipd/feedbacks_report');

// psat analysis
$ip_link_satisfied_list =  base_url('ipd/psat_satisfied_list');
$ip_link_unsatisfied_list =  base_url('ipd/psat_unsatisfied_list');
$ip_link_psat_page = base_url('ipd/psat_page');

// nps analysis
$ip_link_nps_page = base_url('ipd/nps_page');
$ip_link_promoter_list = base_url('ipd/nps_promoter_list');
$ip_link_detractor_list = base_url('ipd/nps_detractors_list');
$ip_link_passives_list = base_url('ipd/nps_passive_list');

// tickets
$ip_link_ticket_dashboard = base_url('ipd/ticket_dashboard');
$ip_link_opentickets = base_url('ipd/opentickets');
$ip_link_addressedtickets = base_url('ipd/addressedtickets');
$ip_link_closedtickets = base_url('ipd/closedtickets');
$ip_link_alltickets = base_url('ipd/alltickets');


$ip_link_capa = base_url('ipd/capa_report');
$ip_link_staffappriciation = base_url('ipd/staff_appreciation');
$ip_link_comments = base_url('ipd/comments');
$ip_link_notifications_list = base_url('ipd/notifications_list');


// downloads
$ip_download_overall_pdf = base_url('ipd/overall_pdf_report?fdate=');
$ip_download_overall_excel = base_url('ipd/overall_excel_report?fdate=');
$ip_download_patient_excel = base_url('ipd/overall_patient_report?fdate=');
$ip_download_department_excel = base_url('ipd/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->