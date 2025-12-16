<?php

$initial_assesment_info_tooltip = "MRD file audit";
$report_error_info_tooltip = "PPE audit";
$safety_precautions_info_tooltip = "Outpatient consultation waiting time";
$medication_errors_info_tooltip = "Laboratory waiting time";
$medication_charts_info_tooltip = "X-Ray waiting time";
$adverse_drug_info_tooltip= "USG waiting time";
$unplanned_return_info_tooltip= "CT scan waiting time";
$wrong_surgery_info_tooltip = "Surgical safety audit";
$transfusion_reactions_info_tooltip= "Medicine dispensing audit";
$mortality_ratio_info_tooltip= "Medication administration audit";
$theemergency_info_tooltip= "Handover audit";
$ulcers_info_tooltip= "Prescriptions audit";
$urinary_info_tooltip= "Hand hygiene audit";
$pneumonia_info_tooltip= "TAT for issue of blood and blood components";
$blood_infection_info_tooltip= "Nurse-Patient ratio for ICU";
$site_infection_info_tooltip= "Return to ICU within 48 hours after being discharged from ICU";
$hand_hygiene_info_tooltip= "Return to ICU within 48 hours after being discharged from ICU- Data Verification";
$prophylactic_info_tooltip= "Return to emergency department within 72 hours with similar presenting complaints";
$re_scheduling_info_tooltip= "Return to emergency department within 72 hours with similar presenting complaints- Data Verification";
$mock_drill_info_tooltip= "Mock drills audit";
$facility_inspection_info_tooltip= "Facilty safety inspection audit";
$ward_info_tooltip= "Nurse-Patient ratio for Ward";

$vap_info_tooltip= "VAP Prevention checklist";
$catheter_info_tooltip= "Catheter Insertion checklist";
$ssi_info_tooltip= "SSI Bundle care policy";
$urinary_info_tooltip= "Urinary Catheter maintenance checklist";
$central_info_tooltip= "Central Line Insertion checklist";
$maintenance_info_tooltip= "Central Line maintenance checklist";
$room_clean_info_tooltip= "Patient room cleaning checklist";
$area_clean_info_tooltip= "Other area cleaning checklist";
$toilet_info_tooltip= "Toilet cleaning checklist";
$canteen_info_tooltip= "Canteen audit checklist";







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



/* START TABLES FROM DATABASE */
$table_feedback = 'bf_feedback_1PSQ3a';
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

/* audit_model.php FOR GLOBAL UPDATES */
// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
$ticket = $this->audit_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
//  print_r($ticket);



// For count of total feedbacks and for charts only.
$ip_feedbacks_count = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// To see the total tickets count
$ip_tickets_count = $this->audit_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// tooltips
$ip_open_tickets = $this->audit_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$ip_reopen_tickets = $this->audit_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$ip_closed_tickets = $this->audit_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$ip_addressed_tickets = $this->audit_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$ip_tickets_tool = "Open Tickets: " . count($ip_open_tickets) . ', ' . "Closed Tickets: " . count($ip_closed_tickets) . ', ' . "Addressed Tickets: " . count($ip_addressed_tickets) . ',' . "Reopen Tickets: " . count($ip_reopen_tickets);

// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$alltickets = $this->tickets_model->alltickets();
$opentickets = $this->tickets_model->read();
$closedtickets = $this->tickets_model->read_close();
$addressed = $this->tickets_model->addressedtickets();


$ip_department['alltickets'] = count($alltickets);
$ip_department['opentickets'] = count($opentickets);
$ip_department['closedtickets'] = count($closedtickets);
$ip_department['addressedtickets'] = count($addressed);

$sresult = $this->audit_model->setup_result('setup');




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
$ip_nps = $this->audit_model->nps_analytics($table_feedback, $asc, $setup);
$ip_nps_tool = 'Promoters: ' . ($ip_nps['promoters_count']) . ', ' . "Detractors: " . ($ip_nps['detractors_count']) . ', ' . "Passives: " . ($ip_nps['passives_count']);
$ip_psat = $this->audit_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$ip_psat_tool = 'Satisfied Patients: ' . ($ip_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($ip_psat['unsatisfied_count']) . '. ';
//  . "Neutral: " . ($ip_psat['neutral_count']);
$ticket_resolution_rate_ip = $this->audit_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
$close_rate_ip = $this->audit_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_ip = secondsToTime($close_rate_ip);

$ip_satisfied_count = $this->audit_model->get_satisfied_count($table_feedback, $table_tickets);
$ip_unsatisfied_count = $this->audit_model->get_unsatisfied_count($table_feedback, $table_tickets);

// Key Highlights
$key_highlights = $this->audit_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup);


$selectionarray = $this->audit_model->reason_to_choose_hospital($table_feedback, $sorttime);

$ip_link_feedback_dashboard = base_url('audit/feedback_dashboard');
$ip_link_tickets_dashboard = base_url('audit/department_tickets');




// individual patient feedback link
$ip_link_patient_feedback = base_url('audit/patient_feedback?id=');


// All feedbacks
$feedbacks_report_mrd_audit = base_url('audit/feedbacks_report_mrd_audit');
$feedbacks_report_ppe_audit = base_url('audit/feedbacks_report_ppe_audit');
$feedbacks_report_consultation_time = base_url('audit/feedbacks_report_consultation_time');
$feedbacks_report_lab_time = base_url('audit/feedbacks_report_lab_time');
$feedbacks_report_xray_time = base_url('audit/feedbacks_report_xray_time');
$feedbacks_report_usg_time = base_url('audit/feedbacks_report_usg_time');
$feedbacks_report_ctscan_time = base_url('audit/feedbacks_report_ctscan_time');
$feedbacks_report_surgical_safety = base_url('audit/feedbacks_report_surgical_safety');
$feedbacks_report_medicine_dispense = base_url('audit/feedbacks_report_medicine_dispense');
$feedbacks_report_medication_administration = base_url('audit/feedbacks_report_medication_administration');
$feedbacks_report_handover = base_url('audit/feedbacks_report_handover');
$feedbacks_report_prescriptions = base_url('audit/feedbacks_report_prescriptions');
$feedbacks_report_hand_hygiene = base_url('audit/feedbacks_report_hand_hygiene');
$feedbacks_report_tat_blood = base_url('audit/feedbacks_report_tat_blood');
$feedbacks_report_nurse_patients_ratio = base_url('audit/feedbacks_report_nurse_patients_ratio');
$feedbacks_report_return_to_i = base_url('audit/feedbacks_report_return_to_i');
$feedbacks_report_return_to_icu = base_url('audit/feedbacks_report_return_to_icu');
$feedbacks_report_return_to_ed = base_url('audit/feedbacks_report_return_to_ed');
$feedbacks_report_return_to_emr = base_url('audit/feedbacks_report_return_to_emr');
$feedbacks_report_mock_drill = base_url('audit/feedbacks_report_mock_drill');
$feedbacks_report_code_originals = base_url('audit/feedbacks_report_code_originals');
$feedbacks_report_safety_inspection = base_url('audit/feedbacks_report_safety_inspection');
$feedbacks_report_nurse_patients_ratio_ward = base_url('audit/feedbacks_report_nurse_patients_ratio_ward');


$feedbacks_report_vap = base_url('audit/feedbacks_report_vap');
$feedbacks_report_catheter_insert = base_url('audit/feedbacks_report_catheter_insert');
$feedbacks_report_ssi_bundle = base_url('audit/feedbacks_report_ssi_bundle');
$feedbacks_report_urinary = base_url('audit/feedbacks_report_urinary');
$feedbacks_report_central_line_insert = base_url('audit/feedbacks_report_central_line_insert');
$feedbacks_report_central_maintenance = base_url('audit/feedbacks_report_central_maintenance');
$feedbacks_report_room_cleaning = base_url('audit/feedbacks_report_room_cleaning');
$feedbacks_report_other_cleaning = base_url('audit/feedbacks_report_other_cleaning');
$feedbacks_report_toilet_cleaning = base_url('audit/feedbacks_report_toilet_cleaning');
$feedbacks_report_canteen = base_url('audit/feedbacks_report_canteen');




$mrd_audit_feedback = base_url('audit/mrd_audit_feedback?id=');
$ppe_audit_feedback = base_url('audit/ppe_audit_feedback?id=');
$op_consultation_feedback = base_url('audit/op_consultation_feedback?id=');
$lab_wait_time_feedback = base_url('audit/lab_wait_time_feedback?id=');
$xray_wait_time_feedback = base_url('audit/xray_wait_time_feedback?id=');
$usg_wait_time_feedback = base_url('audit/usg_wait_time_feedback?id=');
$ctscan_wait_time_feedback = base_url('audit/ctscan_wait_time_feedback?id=');
$surgical_safety_feedback = base_url('audit/surgical_safety_feedback?id=');
$medicine_dispensing_feedback = base_url('audit/medicine_dispensing_feedback?id=');
$medication_administration_feedback = base_url('audit/medication_administration_feedback?id=');
$handover_feedback = base_url('audit/handover_feedback?id=');
$prescriptions_feedback = base_url('audit/prescriptions_feedback?id=');
$hygiene_feedback = base_url('audit/hygiene_feedback?id=');
$tat_blood_feedback = base_url('audit/tat_blood_feedback?id=');
$nurse_patient_feedback = base_url('audit/nurse_patient_feedback?id=');
$return_to_icu_feedback = base_url('audit/return_to_icu_feedback?id=');
$return_to_icu_dv_feedback = base_url('audit/return_to_icu_dv_feedback?id=');
$return_to_emr_feedback = base_url('audit/return_to_emr_feedback?id=');
$return_to_emr_dv_feedback = base_url('audit/return_to_emr_dv_feedback?id=');
$mock_drill_feedback = base_url('audit/mock_drill_feedback?id=');
$safety_inspection_feedback = base_url('audit/safety_inspection_feedback?id=');
$nurse_patient_ward_feedback = base_url('audit/nurse_patient_ward_feedback?id=');


$vap_prevention_feedback = base_url('audit/vap_prevention_feedback?id=');
$catheter_insert_feedback = base_url('audit/catheter_insert_feedback?id=');
$ssi_bundle_feedback = base_url('audit/ssi_bundle_feedback?id=');
$urinary_catheter_feedback = base_url('audit/urinary_catheter_feedback?id=');
$central_line_insert_feedback = base_url('audit/central_line_insert_feedback?id=');
$central_maintenance_feedback = base_url('audit/central_maintenance_feedback?id=');
$room_cleaning_feedback = base_url('audit/room_cleaning_feedback?id=');
$other_cleaning_feedback = base_url('audit/other_cleaning_feedback?id=');
$toilet_cleaning_feedback = base_url('audit/toilet_cleaning_feedback?id=');
$canteen_audit_feedback = base_url('audit/canteen_audit_feedback?id=');




// psat analysis
$ip_link_satisfied_list =  base_url('audit/psat_satisfied_list');
$ip_link_unsatisfied_list =  base_url('audit/psat_unsatisfied_list');
$ip_link_psat_page = base_url('audit/psat_page');

// nps analysis
$ip_link_nps_page = base_url('audit/nps_page');
$ip_link_promoter_list = base_url('audit/nps_promoter_list');
$ip_link_detractor_list = base_url('audit/nps_detractors_list');
$ip_link_passives_list = base_url('audit/nps_passive_list');

// tickets
$ip_link_ticket_dashboard = base_url('audit/ticket_dashboard');
$ip_link_opentickets = base_url('audit/opentickets');
$ip_link_addressedtickets = base_url('audit/addressedtickets');
$ip_link_closedtickets = base_url('audit/closedtickets');
$ip_link_alltickets = base_url('audit/alltickets');


$ip_link_capa = base_url('audit/capa_report');
$ip_link_staffappriciation = base_url('audit/staff_appreciation');
$ip_link_comments = base_url('audit/comments');
$ip_link_notifications_list = base_url('audit/notifications_list');


// downloads
$ip_download_overall_pdf = base_url('audit/overall_pdf_report?fdate=');
$ip_download_overall_excel = base_url('audit/overall_excel_report?fdate=');
$ip_download_patient_excel = base_url('audit/overall_patient_report?fdate=');
$ip_download_department_excel = base_url('audit/overall_department_excel?fdate=');


?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->