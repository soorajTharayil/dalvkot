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
$table_feedback = 'bf_feedback_asset_creation';
$table_patients = 'bf_patients';
$sorttime = 'asc';
$setup = 'setup_int';

$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_asset';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'asset_ticket_message';
$reopen = 'Reopen';
$type = 'interim';
/* END TABLES FROM DATABASE */

/* asset_model.php FOR GLOBAL UPDATES */

// For count of total feedbacks and for charts only.
$asset_feedbacks_count = $this->asset_model->patient_and_feedback($table_feedback, $sorttime);

// // To see the total tickets count
$asset_tickets_count = $this->asset_model->feedback_and_ticket($table_feedback, $table_tickets, $sorttime);
// // tooltips
$asset_open_tickets = $this->asset_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $open);
$asset_reopen_tickets = $this->asset_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $reopen);

$asset_closed_tickets = $this->asset_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $closed);
$asset_addressed_tickets = $this->asset_model->tickets_feeds($table_feedback, $table_tickets, $sorttime, $addressed);
$asset_tickets_tool = "Open Tickets: " . count($asset_open_tickets) . ', ' . "Closed Tickets: " . count($asset_closed_tickets) . ', ' . "Addressed Tickets: " . count($asset_addressed_tickets) . ',' . "Reopen Tickets: " . count($asset_reopen_tickets);
$ticket_resolution_rate = $this->asset_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$close_rate = $this->asset_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);

$ticket = $this->asset_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);
// print_r($hi);
$ticket_analisys = $this->asset_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);

//$all_ticket_type = $this->ticketsasset_model->count_all_ticket_types();
// print_r($all_ticket_type);
// exit;
$alltickets = $this->ticketsasset_model->alltickets();
$asset_assign_tickets = $this->ticketsasset_model->asset_assign_tickets();
//$asset_broken_tickets = $this->ticketsasset_model->asset_broken_tickets();
$asset_repair_tickets = $this->ticketsasset_model->asset_repair_tickets();
$asset_reassign_tickets = $this->ticketsasset_model->asset_reassign_tickets();
$asset_lost_tickets = $this->ticketsasset_model->asset_lost_tickets();
$asset_dispose_tickets = $this->ticketsasset_model->asset_dispose_tickets();
$asset_transfer_tickets = $this->ticketsasset_model->asset_transfer_tickets();
$asset_unallocate_tickets = $this->ticketsasset_model->asset_unallocate_tickets();
$asset_sold_tickets = $this->ticketsasset_model->asset_sold_tickets();
$asset_use_tickets = $this->ticketsasset_model->asset_use_tickets();

$asset_preventive_tickets = $this->ticketsasset_model->asset_preventive_tickets();




// Count all tickets and asset-related tickets
$p = count($alltickets);
//$q = count($asset_broken_tickets);
$r = count($asset_repair_tickets);
$s = count($asset_lost_tickets);
$t = count($asset_dispose_tickets);
$un = count($asset_unallocate_tickets);
$sold = count($asset_sold_tickets);
$asset_use = count($asset_use_tickets);



$d = count($asset_reassign_tickets);
$e = count($asset_transfer_tickets);

$asset_assign_tickets = $asset_use - $un;

// Prepare the int_department array with relevant counts
$asset_department['alltickets'] = $p;
$asset_department['asset_use'] = $asset_use;
$asset_department['asset_assign_tickets'] = $asset_assign_tickets;
//$asset_department['asset_broken_tickets'] = $q;
$asset_department['asset_repair_tickets'] = $r;
$asset_department['asset_reassign_tickets'] = $d;
$asset_department['asset_lost_tickets'] = $s;
$asset_department['asset_dispose_tickets'] = $t;
$asset_department['asset_unallocate_tickets'] = $un;
$asset_department['asset_sold_tickets'] = $sold;



$asset_tickets_tool = "Assets in Use: " . count($asset_use_tickets) . ', ' . "Assets in Repair: " . count($asset_repair_tickets) . ', ' . "Lost Assets: " . count($asset_lost_tickets) . ', ' . "Disposed Assets: " . count($asset_dispose_tickets) . ', ' . "Sold Assets: " . count($asset_sold_tickets);









$maxPercentage = PHP_INT_MIN;
$minPercentage = PHP_INT_MAX;

$maxDepartment = [];
$minDepartment = [];

foreach ($ticket as $item) {
    // print_r(count($ticket));
    if (count($asset_tickets_count) > 5) {
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


// $asset_link_feedback_dashboard = base_url($this->uri->segment(1).'/feedback_dashboard');
// $asset_link_tickets_dashboard = base_url($this->uri->segment(1).'/department_tickets');




// individual patient feedback link
$asset_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');

// All feedbacks
$asset_link_feedback_report = base_url($this->uri->segment(1) . '/feedbacks_report');

// psat analysis
$asset_link_satisfied_list =  base_url($this->uri->segment(1) . '/psat_satisfied_list');
$asset_link_unsatisfied_list =  base_url($this->uri->segment(1) . '/psat_unsatisfied_list');
$asset_link_psat_page = base_url($this->uri->segment(1) . '/psat_page');

// nps analysis
$asset_link_nps_page = base_url($this->uri->segment(1) . '/nps_page');
$asset_link_promoter_list = base_url($this->uri->segment(1) . '/nps_promoter_list');
$asset_link_detractor_list = base_url($this->uri->segment(1) . '/nps_detractors_list');
$asset_link_passives_list = base_url($this->uri->segment(1) . '/nps_passive_list');

// tickets
$asset_link_ticket_dashboard = base_url($this->uri->segment(1) . '/ticket_dashboard');
$asset_link_opentickets = base_url($this->uri->segment(1) . '/opentickets');
$asset_assign_tickets = base_url($this->uri->segment(1) . '/asset_assign_tickets');
$asset_broken_tickets = base_url($this->uri->segment(1) . '/asset_broken_tickets');
$asset_repair_tickets = base_url($this->uri->segment(1) . '/asset_repair_tickets');
$asset_reassign_tickets = base_url($this->uri->segment(1) . '/asset_reassign_tickets');
$asset_lost_tickets = base_url($this->uri->segment(1) . '/asset_lost_tickets');
$asset_dispose_tickets = base_url($this->uri->segment(1) . '/asset_dispose_tickets');
$asset_link_addressedtickets = base_url($this->uri->segment(1) . '/addressedtickets');
$asset_link_closedtickets = base_url($this->uri->segment(1) . '/closedtickets');
$asset_link_alltickets = base_url($this->uri->segment(1) . '/alltickets');
$asset_use_tickets = base_url($this->uri->segment(1) . '/asset_use_tickets');
$asset_unallocate_tickets = base_url($this->uri->segment(1) . '/asset_unallocate_tickets');
$asset_sold_tickets = base_url($this->uri->segment(1) . '/asset_sold_tickets');


$ip_link_ticket_resolution_rate = base_url($this->uri->segment(1) . '/ticket_resolution_rate');
$ip_link_average_resolution_time= base_url($this->uri->segment(1) . '/average_resolution_time');


$asset_link_capa = base_url($this->uri->segment(1) . '/capa_report');
$asset_link_staffappriciation = base_url($this->uri->segment(1) . '/staff_appreciation');
$asset_link_comments = base_url($this->uri->segment(1) . '/complaints');
$asset_link_notifications_list = base_url($this->uri->segment(1) . '/notifications_list');


// downloads
$asset_download_overall_pdf = base_url($this->uri->segment(1) . '/overall_pdf_report');
$asset_download_comments_excel = base_url($this->uri->segment(1) . '/downloadcomments');
$asset_download_patient_excel = base_url($this->uri->segment(1) . '/overall_patient_report');
$asset_download_department_excel = base_url($this->uri->segment(1) . '/overall_department_excel');

$a = count($asset_open_tickets);
$b = count($asset_reopen_tickets);
$openticket_count = $a + $b;

?>


<?php
// This file is used as header for IP MODULE this is included to avoid redundant code and to adopt global changes
// Author: Dhananjay Kini 
// Created on 05-08-2023

?>
<!-- "We live to see another day"  -->