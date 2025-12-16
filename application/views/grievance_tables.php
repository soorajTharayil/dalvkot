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
$table_feedback = 'bf_feedback_grievance';
$table_patients = 'bf_employees_grievance';
$sorttime = 'asc';
$setup = 'setup_grievance';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_grievance';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_grievance_message';
$reopen = 'Reopen';
$type = 'grievance';
$transferd = 'Tranfered';

/* END TABLES FROM DATABASE */

/* grievance_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$grievance_feedbacks_count = $this->grievance_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// // To see the total tickets count
$grievance_tickets_count = $this->grievance_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$grievance_open_tickets = $this->grievance_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$grievance_reopen_tickets = $this->grievance_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);
$grievance_transfered_tickets = $this->grievance_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $transferd);


$grievance_allopenticket_count = count($grievance_open_tickets) + count($grievance_reopen_tickets) + count($grievance_transferd_tickets);


$grievance_closed_tickets = $this->grievance_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$grievance_addressed_tickets = $this->grievance_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$grievance_tickets_tool = "Open Grievances: " . count($grievance_open_tickets) . ', ' . "Closed Grievances: " . count($grievance_closed_tickets) . ', ' . "Addressed Grievances: " . count($grievance_addressed_tickets) . ',' . "Reopen : " . count($grievance_reopen_tickets);
$ticket_resolution_rate_grievance = $this->grievance_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate_grievance = $this->grievance_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_grievance = secondsToTime($close_rate_grievance);

$ticket = $this->grievance_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// $grievance_department =	$this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$grealltickets = $this->ticketsgrievance_model->alltickets();
$greopentickets = $this->ticketsgrievance_model->read();
$greclosedtickets = $this->ticketsgrievance_model->read_close();
$greaddressed = $this->ticketsgrievance_model->addressedtickets();


$grievance_department['alltickets'] = count($grealltickets);
$grievance_department['opentickets'] = count($greopentickets);
$grievance_department['closedtickets'] = count($greclosedtickets);
$grievance_department['addressedtickets'] = count($greaddressed);



$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
	// print_r(count($ticket));
	if (count($grievance_tickets_count) > 5) {
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





$grievance_link_tickets_dashboard = base_url('grievance/department_tickets');




// individual patient feedback link
$grievance_link_patient_feedback = base_url('grievance/patient_complaint?patientid=');

// All feedbacks
$grievance_link_feedback_report = base_url('grievance/feedbacks_report');

// psat analysis
$grievance_link_satisfied_list =  base_url('grievance/psat_satisfied_list');
$grievance_link_unsatisfied_list =  base_url('grievance/psat_unsatisfied_list');
$grievance_link_psat_page = base_url('grievance/psat_page');

// nps analysis
$grievance_link_nps_page = base_url('grievance/nps_page');
$grievance_link_promoter_list = base_url('grievance/nps_promoter_list');
$grievance_link_detractor_list = base_url('grievance/nps_detractors_list');
$grievance_link_passives_list = base_url('grievance/nps_passive_list');

// tickets
$grievance_link_ticket_dashboard = base_url('grievance/ticket_dashboard');
$grievance_link_opentickets = base_url('grievance/opentickets');
$grievance_link_addressedtickets = base_url('grievance/addressedtickets');
$grievance_link_closedtickets = base_url('grievance/closedtickets');
$grievance_link_alltickets = base_url('grievance/alltickets');


$grievance_link_capa = base_url('grievance/capa_report');
$grievance_link_staffappriciation = base_url('grievance/staff_appreciation');
$grievance_link_comments = base_url('grievance/comments');
$grievance_link_notifications_list = base_url('grievance/notifications_list');


// downloads
$grievance_download_overall_pdf = base_url('grievance/overall_pdf_report?fdate=');
$grievance_download_overall_excel = base_url('grievance/overall_excel_report?fdate=');
$grievance_download_patient_excel = base_url('grievance/overall_patient_report?fdate=');
$grievance_download_department_excel = base_url('grievance/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->