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
$table_feedback = 'bf_outfeedback';
$table_patients = 'bf_opatients';
$sorttime = 'asc';
$setup = 'setupop';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'ticketsop';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticketop_message';
$type = 'outpatient';
$department = 'department';
$reopen = 'Reopen';
/* END TABLES FROM DATABASE */

/* opf_model.php FOR GLOBAL UPDATES */
// $op_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);


$ticket = $this->opf_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);



// For count of total feedbacks and for charts only.
$op_feedbacks_count = $this->opf_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// To see the total tickets count
$op_tickets_count = $this->opf_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// tooltips
$op_open_tickets = $this->opf_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$op_reopen_tickets = $this->opf_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$op_closed_tickets = $this->opf_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$op_addressed_tickets = $this->opf_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$op_tickets_tool = "Open Tickets: " . count($op_open_tickets) . ', ' . "Closed Tickets: " . count($op_closed_tickets) . ', ' . "Addressed Tickets: " . count($op_addressed_tickets) . ',' . "Reopen Tickets: " . count($op_reopen_tickets);

// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

$alltickets = $this->ticketsop_model->alltickets();
$opentickets = $this->ticketsop_model->read();
$closedtickets = $this->ticketsop_model->read_close();
$addressed = $this->ticketsop_model->addressedtickets();


$op_department['alltickets'] = count($alltickets);
$op_department['opentickets'] = count($opentickets);
$op_department['closedtickets'] = count($closedtickets);
$op_department['addressedtickets'] = count($addressed);

$sresult = $this->opf_model->setup_result('setup');
$ticket_resolution_rate_op = $this->opf_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate_op = $this->opf_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate_op = secondsToTime($close_rate_op);

$op_nps = $this->opf_model->nps_analytics($table_feedback, $asc, $setup);
$op_nps_tool = 'Promoters: ' . ($op_nps['promoters_count']) . ', ' . "Detractors: " . ($op_nps['detractors_count']) . ', ' . "Passives: " . ($op_nps['passives_count']);
$op_psat = $this->opf_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$op_psat_tool = 'Satisfied Patients: ' . ($op_psat['satisfied_count']) . ', ' . "Unsatisfied Patients: " . ($op_psat['unsatisfied_count']) . '. ';


$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
    // print_r(count($ticket));
    if (count($op_tickets_count) > 5) {
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

$op_link_feedback_dashboard = base_url('opf/feedback_dashboard');
$op_link_tickets_dashboard = base_url('opf/department_tickets');




// individual patient feedback link
$op_link_patient_feedback = base_url('opf/patient_feedback?id=');

// All feedbacks
$op_link_feedback_report = base_url('opf/feedbacks_report');

// psat analysis
$op_link_satisfied_list =  base_url('opf/psat_satisfied_list');
$op_link_unsatisfied_list =  base_url('opf/psat_unsatisfied_list');
$op_link_psat_page = base_url('opf/psat_page');

// nps analysis
$op_link_nps_page = base_url('opf/nps_page');
$op_link_promoter_list = base_url('opf/nps_promoter_list');
$op_link_detractor_list = base_url('opf/nps_detractors_list');
$op_link_passives_list = base_url('opf/nps_passive_list');

// tickets
$op_link_ticket_dashboard = base_url('opf/ticket_dashboard');
$op_link_opentickets = base_url('opf/opentickets');
$op_link_addressedtickets = base_url('opf/addressedtickets');
$op_link_closedtickets = base_url('opf/closedtickets');
$op_link_alltickets = base_url('opf/alltickets');


$op_link_capa = base_url('opf/capa_report');
$op_link_staffappriciation = base_url('opf/staff_appreciation');
$op_link_comments = base_url('opf/comments');
$op_link_notifications_list = base_url('opf/notifications_list');


// downloads
$op_download_overall_pdf = base_url('opf/overall_pdf_report?fdate=');
$op_download_overall_excel = base_url('opf/overall_excel_report?fdate=');
$op_download_patient_excel = base_url('opf/overall_patient_report?fdate=');
$op_download_department_excel = base_url('opf/overall_department_excel?fdate=');


// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->