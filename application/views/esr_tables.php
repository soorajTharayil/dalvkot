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
$table_feedback = 'bf_feedback_esr';
$table_patients = 'bf_employees_esr';
$sorttime = 'asc';
$setup = 'setup_esr';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_esr';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_esr_message';
$reopen = 'Reopen';
$type = 'esr';
$transferd = 'Tranfered';

/* END TABLES FROM DATABASE */

/* isr_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$esr_feedbacks_count = $this->isr_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$esr_tickets_count = $this->isr_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$esr_open_tickets = $this->isr_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$esr_reopen_tickets = $this->isr_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);
$esr_transfered_tickets = $this->isr_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $transferd);


$esr_allopenticket_count = count($esr_open_tickets) + count($esr_reopen_tickets) + count($esr_transferd_tickets);


$esr_closed_tickets = $this->isr_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$esr_addressed_tickets = $this->isr_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$esr_tickets_tool = "Open Requests: " . count($esr_open_tickets) . ', ' . "Closed Requests: " . count($esr_closed_tickets) . ', ' . "Addressed Requests: " . count($esr_addressed_tickets) . ',' . "Reopen : " . count($esr_reopen_tickets);
$ticket_resolution_rate_esr = $this->isr_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate_esr = $this->isr_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_esr = secondsToTime($close_rate_esr);

$ticket = $this->isr_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
// $esr_department =	$this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$esralltickets = $this->ticketsesr_model->alltickets();

$esropentickets = $this->ticketsesr_model->read();
$esrclosedtickets = $this->ticketsesr_model->read_close();
$esraddressed = $this->ticketsesr_model->addressedtickets();


$esr_department['alltickets'] = count($esralltickets);

$esr_department['opentickets'] = count($esropentickets);
$esr_department['closedtickets'] = count($esrclosedtickets);
$esr_department['addressedtickets'] = count($esraddressed);


$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
	// print_r(count($ticket));
	if (count($esr_tickets_count) > 5) {
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





$esr_link_tickets_dashboard = base_url('isr/department_tickets');




// individual patient feedback link
$esr_link_patient_feedback = base_url('isr/patient_complaint?patientid=');

// All feedbacks
$esr_link_feedback_report = base_url('isr/feedbacks_report');

// psat analysis
$esr_link_satisfied_list =  base_url('isr/psat_satisfied_list');
$esr_link_unsatisfied_list =  base_url('isr/psat_unsatisfied_list');
$esr_link_psat_page = base_url('isr/psat_page');

// nps analysis
$esr_link_nps_page = base_url('isr/nps_page');
$esr_link_promoter_list = base_url('isr/nps_promoter_list');
$esr_link_detractor_list = base_url('isr/nps_detractors_list');
$esr_link_passives_list = base_url('isr/nps_passive_list');

// tickets
$esr_link_ticket_dashboard = base_url('isr/ticket_dashboard');
$esr_link_opentickets = base_url('isr/opentickets');
$esr_link_addressedtickets = base_url('isr/addressedtickets');
$esr_link_closedtickets = base_url('isr/closedtickets');
$esr_link_alltickets = base_url('isr/alltickets');


$esr_link_capa = base_url('isr/capa_report');
$esr_link_staffappriciation = base_url('isr/staff_appreciation');
$esr_link_comments = base_url('isr/comments');
$esr_link_notifications_list = base_url('isr/notifications_list');


// downloads
$esr_download_overall_pdf = base_url('isr/overall_pdf_report?fdate=');
$esr_download_overall_excel = base_url('isr/overall_excel_report?fdate=');
$esr_download_patient_excel = base_url('isr/overall_patient_report?fdate=');
$esr_download_department_excel = base_url('isr/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->