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
$transferd = 'Tranfered';
/* END TABLES FROM DATABASE */

/* pc_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$int_feedbacks_count = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$int_tickets_count = $this->pc_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$int_open_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$int_reopen_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);
$int_transferd_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $transferd);

$int_closed_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$int_addressed_tickets = $this->pc_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$interim_tickets_tool = "Open Complaints: " . count($int_open_tickets) . ', ' . "Closed Complaints: " . count($int_closed_tickets) . ', ' . "Addressed Complaints: " . count($int_addressed_tickets) . ',' . "Reopen : " . count($int_reopen_tickets);
$ticket_resolution_rate_int = $this->pc_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$int_allopenticket_count = count($int_open_tickets) + count($int_reopen_tickets) + count($int_transferd_tickets);

$close_rate_int = $this->pc_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_int = secondsToTime($close_rate_int);

$ticket = $this->pc_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$intlltickets = $this->ticketsint_model->alltickets();
$intopentickets = $this->ticketsint_model->read();
$intclosedtickets = $this->ticketsint_model->read_close();
$intaddressed = $this->ticketsint_model->addressedtickets();


$int_department['alltickets'] = count($intlltickets);
$int_department['opentickets'] = count($intopentickets);
$int_department['closedtickets'] = count($intclosedtickets);
$int_department['addressedtickets'] = count($intaddressed);





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





$int_link_tickets_dashboard = base_url('pc/department_tickets');




// individual patient feedback link
$int_link_patient_feedback = base_url('pc/patient_complaint?patientid=');

// All feedbacks
$int_link_feedback_report = base_url('pc/feedbacks_report');

// psat analysis
$int_link_satisfied_list =  base_url('pc/psat_satisfied_list');
$int_link_unsatisfied_list =  base_url('pc/psat_unsatisfied_list');
$int_link_psat_page = base_url('pc/psat_page');

// nps analysis
$int_link_nps_page = base_url('pc/nps_page');
$int_link_promoter_list = base_url('pc/nps_promoter_list');
$int_link_detractor_list = base_url('pc/nps_detractors_list');
$int_link_passives_list = base_url('pc/nps_passive_list');

// tickets
$int_link_ticket_dashboard = base_url('pc/ticket_dashboard');
$int_link_opentickets = base_url('pc/opentickets');
$int_link_addressedtickets = base_url('pc/addressedtickets');
$int_link_closedtickets = base_url('pc/closedtickets');
$int_link_alltickets = base_url('pc/alltickets');


$int_link_capa = base_url('pc/capa_report');
$int_link_staffappriciation = base_url('pc/staff_appreciation');
$int_link_comments = base_url('pc/comments');
$int_link_notifications_list = base_url('pc/notifications_list');


// downloads
$int_download_overall_pdf = base_url('pc/overall_pdf_report?fdate=');
$int_download_overall_excel = base_url('pc/overall_excel_report?fdate=');
$int_download_patient_excel = base_url('pc/overall_patient_report?fdate=');
$int_download_department_excel = base_url('pc/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->