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
$table_feedback = 'bf_feedback_pdf';
$table_patients = 'bf_patients';
$sorttime = 'asc';
$setup = 'setup_pdf';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_pdf';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_pdf_message';
$setup = 'setup_pdf';
$type = 'pdf';
$department = 'department';
$reopen = 'Reopen';
/* END TABLES FROM DATABASE */
// print_r($type);
// print_r($table_feedback);
// print_r($table_tickets);
// exit;

/* post_model.php FOR GLOBAL UPDATES */
// $pdf_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
$ticket = $this->post_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
// print_r($ticket);



// For count of total feedbacks and for charts only.
$pdf_feedbacks_count = $this->post_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// To see the total tickets count
$pdf_tickets_count = $this->post_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// tooltips
$pdf_open_tickets = $this->post_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$pdf_reopen_tickets = $this->post_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$pdf_closed_tickets = $this->post_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$pdf_addressed_tickets = $this->post_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$pdf_tickets_tool = "Open Tickets: " . count($pdf_open_tickets) . ', ' . "Closed Tickets: " . count($pdf_closed_tickets) . ', ' . "Addressed Tickets: " . count($pdf_addressed_tickets) . ',' . "Reopen Tickets: " . count($pdf_reopen_tickets);

// $pdf_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$alltickets = $this->ticketspdf_model->alltickets();
$opentickets = $this->ticketspdf_model->read();
$closedtickets = $this->ticketspdf_model->read_close();
$addressed = $this->ticketspdf_model->addressedtickets();


$pdf_department['alltickets'] = count($alltickets);
$pdf_department['opentickets'] = count($opentickets);
$pdf_department['closedtickets'] = count($closedtickets);
$pdf_department['addressedtickets'] = count($addressed);

$sresult = $this->post_model->setup_result('setup');




$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
	// print_r(count($ticket));
	if (count($pdf_tickets_count) > 5) {
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
$pdf_nps = $this->post_model->nps_analytics($table_feedback, $asc, $setup);
$pdf_nps_tool = 'Promoters: ' . ($pdf_nps['promoters_count']) . ', ' . "Detractors: " . ($pdf_nps['detractors_count']) . ', ' . "Passives: " . ($pdf_nps['passives_count']);
$pdf_psat = $this->post_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$pdf_psat_tool = 'Satisfied Patients: ' . ($pdf_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($pdf_psat['unsatisfied_count']) . '. ';
//  . "Neutral: " . ($pdf_psat['neutral_count']);
$ticket_resolution_rate_ip = $this->post_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
$close_rate_ip = $this->post_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_ip = secondsToTime($close_rate_ip);

$pdf_satisfied_count = $this->post_model->get_satisfied_count($table_feedback, $table_tickets);
$pdf_unsatisfied_count = $this->post_model->get_unsatisfied_count($table_feedback, $table_tickets);

// Key Highlights
$key_highlights = $this->post_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup);


$selectionarray = $this->post_model->reason_to_choose_hospital($table_feedback, $sorttime);

$pdf_link_feedback_dashboard = base_url('post/feedback_dashboard');
$pdf_link_tickets_dashboard = base_url('post/department_tickets');




// individual patient feedback link
$pdf_link_patient_feedback = base_url('post/patient_feedback?id=');

// All feedbacks
$pdf_link_feedback_report = base_url('post/feedbacks_report');

// psat analysis
$pdf_link_satisfied_list =  base_url('post/psat_satisfied_list');
$pdf_link_unsatisfied_list =  base_url('post/psat_unsatisfied_list');
$pdf_link_psat_page = base_url('post/psat_page');

// nps analysis
$pdf_link_nps_page = base_url('post/nps_page');
$pdf_link_promoter_list = base_url('post/nps_promoter_list');
$pdf_link_detractor_list = base_url('post/nps_detractors_list');
$pdf_link_passives_list = base_url('post/nps_passive_list');

// tickets
$pdf_link_ticket_dashboard = base_url('post/ticket_dashboard');
$pdf_link_opentickets = base_url('post/opentickets');
$pdf_link_addressedtickets = base_url('post/addressedtickets');
$pdf_link_closedtickets = base_url('post/closedtickets');
$pdf_link_alltickets = base_url('post/alltickets');


$pdf_link_capa = base_url('post/capa_report');
$pdf_link_staffappriciation = base_url('post/staff_appreciation');
$pdf_link_comments = base_url('post/comments');
$pdf_link_notifications_list = base_url('post/notifications_list');


// downloads
$pdf_download_overall_pdf = base_url('post/overall_pdf_report?fdate=');
$pdf_download_overall_excel = base_url('post/overall_excel_report?fdate=');
$pdf_download_patient_excel = base_url('post/overall_patient_report?fdate=');
$pdf_download_department_excel = base_url('post/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->