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
$transferd = 'Tranfered';

/* END TABLES FROM DATABASE */

/* incident_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$incident_feedbacks_count = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$incident_tickets_count = $this->incident_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$incident_open_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$incident_reopen_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);
$incident_transfered_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $transferd);


$incident_allopenticket_count = count($incident_open_tickets) + count($incident_reopen_tickets) + count($incident_transferd_tickets);


$incident_closed_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$incident_addressed_tickets = $this->incident_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$incident_tickets_tool = "Open Incidents: " . count($incident_open_tickets) . ', ' . "Closed Incidents: " . count($incident_closed_tickets) . ', ' . "Addressed Incidents: " . count($incident_addressed_tickets) . ',' . "Reopen : " . count($incident_reopen_tickets);
$ticket_resolution_rate_incident = $this->incident_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate_incident = $this->incident_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_incident = secondsToTime($close_rate_incident);

$ticket = $this->incident_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
// $incident_department =	$this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$incalltickets = $this->ticketsincidents_model->alltickets();
$incopentickets = $this->ticketsincidents_model->read();
$incclosedtickets = $this->ticketsincidents_model->read_close();
$incaddressed = $this->ticketsincidents_model->addressedtickets();


$incident_department['alltickets'] = count($incalltickets);
$incident_department['opentickets'] = count($incopentickets);
$incident_department['closedtickets'] = count($incclosedtickets);
$incident_department['addressedtickets'] = count($incaddressed);



$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
	// print_r(count($ticket));
	if (count($incident_tickets_count) > 5) {
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





$incident_link_tickets_dashboard = base_url('incident/department_tickets');




// individual patient feedback link
$incident_link_patient_feedback = base_url('incident/patient_complaint?patientid=');

// All feedbacks
$incident_link_feedback_report = base_url('incident/feedbacks_report');

// psat analysis
$incident_link_satisfied_list =  base_url('incident/psat_satisfied_list');
$incident_link_unsatisfied_list =  base_url('incident/psat_unsatisfied_list');
$incident_link_psat_page = base_url('incident/psat_page');

// nps analysis
$incident_link_nps_page = base_url('incident/nps_page');
$incident_link_promoter_list = base_url('incident/nps_promoter_list');
$incident_link_detractor_list = base_url('incident/nps_detractors_list');
$incident_link_passives_list = base_url('incident/nps_passive_list');

// tickets
$incident_link_ticket_dashboard = base_url('incident/ticket_dashboard');
$incident_link_opentickets = base_url('incident/opentickets');
$incident_link_addressedtickets = base_url('incident/addressedtickets');
$incident_link_closedtickets = base_url('incident/closedtickets');
$incident_link_alltickets = base_url('incident/alltickets');


$incident_link_capa = base_url('incident/capa_report');
$incident_link_staffappriciation = base_url('incident/staff_appreciation');
$incident_link_comments = base_url('incident/comments');
$incident_link_notifications_list = base_url('incident/notifications_list');


// downloads
$incident_download_overall_pdf = base_url('incident/overall_pdf_report?fdate=');
$incident_download_overall_excel = base_url('incident/overall_excel_report?fdate=');
$incident_download_patient_excel = base_url('incident/overall_patient_report?fdate=');
$incident_download_department_excel = base_url('incident/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->