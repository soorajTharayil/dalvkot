<?php



$instance_lang1 = 'English';

$instance_lang2 = 'Kannada';

$instance_lang3 = 'Malayalam';



$lang1 = 'english';

$lang2 = 'lang2';

$lang3 = 'lang3';







$benchmark_for_nps_red = 30;

$benchmark_for_nps_yellow = 70;

$benchmark_for_nps_green = 70;



$benchmark_for_psat_red = 30;

$benchmark_for_psat_yellow = 50;

$benchmark_for_psat_green = 80;



$closed = $status = 'closed';

$sorttime = 'asc';

$asc = 'asc';

$num_of_modules = 0;

$num_of_modules_tickets = 0;



if (ismodule_active('ADF') === true) {

    $num_of_modules++;

    $adf_module = true;



    //ADF

    $adf_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback('bf_patients', 'bf_feedback_adf', $sorttime, 'setup_adf');

    $adf_nps = $this->admissionfeedback_model->nps_analytics('bf_feedback_adf', $asc, 'setup_adf');

    $adf_psat = $this->admissionfeedback_model->psat_analytics('bf_patients', 'bf_feedback_adf', 'tickets_adf', $sorttime);

    $hospital_selection['adf'] = $this->ipd_model->reason_to_choose_hospital('bf_feedback_adf', $sorttime);



    $ticket_resolution_rate_adf = $this->admissionfeedback_model->ticket_resolution_rate('tickets_adf', $closed, 'bf_feedback_adf');

    $close_rate_adf = $this->admissionfeedback_model->ticket_rate('tickets_adf', $status, 'bf_feedback_adf', 'ticket_message_adf');

    $avg_ticket_time_adf = secondsToTimeforreport($close_rate_adf);



    $adfalltickets = $this->ticketsadf_model->alltickets();

    $adfopentickets = $this->ticketsadf_model->read();

    $adfclosedtickets = $this->ticketsadf_model->read_close();

    $adfaddressed = $this->ticketsadf_model->addressedtickets();



    $tickets['adf_alltickets'] = count($adfalltickets);

    $tickets['adf_opentickets'] = count($adfopentickets);

    $tickets['adf_closedtickets'] = count($adfclosedtickets);

    $tickets['adf_addressedtickets'] = count($adfaddressed);

    $tickets['adf_resolution_rate'] = $ticket_resolution_rate_adf;

    $tickets['adf_resolution_time'] = $avg_ticket_time_adf;



    $feed['adf_feedback'] = count($adf_feedbacks_count);

    $feed['adf_tickets'] = count($adfalltickets);
ismodule_active('IP')
    $feed['adf_nps_score'] = $adf_nps['nps_score'];

    $feed['adf_promoters_count'] = $adf_nps['promoters_count'];

    $feed['adf_detractors_count'] = $adf_nps['detractors_count'];

    $feed['adf_passives_count'] = $adf_nps['passives_count'];

    $feed['adf_satisfied_count'] = $adf_psat['satisfied_count'];

    $feed['adf_unsatisfied_count'] = $adf_psat['unsatisfied_count'];

    $feed['adf_psat_score'] = $adf_psat['psat_score'];



    if ($feed['ip_psat_score'] < $benchmark_for_nps_red) {

        $ip_psat_color = 'color: #d9534f; display: inline-block;'; // Red

    }

    // If the score is between 20 (inclusive) and 60 (exclusive)

    elseif ($feed['ip_psat_score'] < $benchmark_for_nps_yellow) {

        $ip_psat_color = 'color:  #f0ad4e; display: inline-block;'; // Yellow

    }

    // If the score is between 60 (inclusive) and 80 (exclusive)

    elseif ($feed['ip_psat_score'] > $benchmark_for_nps_yellow) {

        $ip_psat_color = 'color:  #198754; display: inline-block;'; // Green

    }





    if ($feed['adf_psat_score']  <= $benchmark_for_psat_red) {

        $adf_psat_color = 'color: #d9534f; display: inline-block;';

    } elseif ($feed['adf_psat_score'] >= $benchmark_for_psat_yellow) {

        $adf_psat_color = 'color:  #f0ad4e; display: inline-block;';

    } else {

        $adf_psat_color = 'color:  #198754; display: inline-block;';

    }



    foreach ($adf_feedbacks_count as $afeeds) {

        $adffeeds[] = json_decode($afeeds->dataset, true);

        if ($afeeds->source == 'Link') {

            $adf_web++;

        }

        if ($afeeds->source == 'APP') {

            $adf_app++;

        }

        if ($afeeds->source == 'QR') {

            $adf_qr++;

        }

    }



    foreach ($adffeeds as $feeds1 => $adffeedback) {

        if ($adffeedback['langsub'] == $lang1) {

            $lang['adf_1']++;

        } elseif ($adffeedback['langsub'] == $lang2) {

            $lang['adf_2']++;

        } else {

            $lang['adf_3']++;

        }

    }

}



if (ismodule_active('ip_page') === true) {

    $num_of_modules++;

    $ip_module = true;

    //IPDF

    $ip_feedbacks_count = $this->ipd_model->patient_and_feedback('bf_patients', 'bf_feedback', $sorttime, 'setup');



    $ip_nps = $this->ipd_model->nps_analytics('bf_feedback', $asc, 'setup');

    $ip_psat = $this->ipd_model->psat_analytics('bf_patients', 'bf_feedback', 'tickets', $sorttime);



    $hospital_selection['ip'] = $this->ipd_model->reason_to_choose_hospital('bf_feedback', $sorttime);

    asort($hospital_selection['ip']);





    $ip_max_hospital_selection = null;

    $ip_min_hospital_selection = null;



    $ip_hosp_Sel = array_filter($hospital_selection['ip'], function ($item) {

        return $item->percentage != 0;

    });



    foreach ($ip_hosp_Sel as $item) {

        if ($ip_max_hospital_selection === null || $item->percentage < $ip_max_hospital_selection) {

            $ip_max_hospital_selection['percent'] = $item->percentage;

            $ip_max_hospital_selection['title'] = $item->title;

            $ip_max_hospital_selection['count'] = $item->count;

        }

        if ($ip_min_hospital_selection === null || $item->percentage > $ip_min_hospital_selection) {

            $ip_min_hospital_selection['percent'] = $item->percentage;

            $ip_min_hospital_selection['title'] = $item->title;

            $ip_min_hospital_selection['count'] = $item->count;

        }

    }

    // $ip_list_hs_sel = $ip_hosp_Sel;

    // rsort($ip_list_hs_sel);

    // print_r($ip_hosp_Sel);





    $ticket_resolution_rate_ip = $this->ipd_model->ticket_resolution_rate('tickets', $closed, 'bf_feedback');

    $close_rate_ip = $this->ipd_model->ticket_rate('tickets', $status, 'bf_feedback', 'ticket_message');

    $avg_ticket_time_ip = secondsToTimeforreport($close_rate_ip);



    $ipalltickets = $this->tickets_model->alltickets();

    $ipopentickets = $this->tickets_model->read();

    $ipclosedtickets = $this->tickets_model->read_close();

    $ipaddressed = $this->tickets_model->addressedtickets();



    $tickets['ip_alltickets'] = count($ipalltickets);

    $tickets['ip_opentickets'] = count($ipopentickets);

    $tickets['ip_closedtickets'] = count($ipclosedtickets);

    $tickets['ip_addressedtickets'] = count($ipaddressed);

    $tickets['ip_resolution_rate'] = $ticket_resolution_rate_ip;

    $tickets['ip_resolution_time'] = $avg_ticket_time_ip;



    $feed['ip_feedback'] = count($ip_feedbacks_count);

    $feed['ip_tickets'] = count($ipalltickets);

    $feed['ip_nps_score'] = $ip_nps['nps_score'];

    $feed['ip_promoters_count'] = $ip_nps['promoters_count'];

    $feed['ip_detractors_count'] = $ip_nps['detractors_count'];

    $feed['ip_passives_count'] = $ip_nps['passives_count'];

    $feed['ip_satisfied_count'] = $ip_psat['satisfied_count'];

    $feed['ip_unsatisfied_count'] = $ip_psat['unsatisfied_count'];

    $feed['ip_psat_score'] = $ip_psat['psat_score'];



    if ($feed['ip_nps_score'] <= $benchmark_for_nps_red) {

        $ip_nps_color = 'color: #d9534f; display: inline-block;'; // Red

        $ip_low_nps = true;

    }

    // If the score is between 20 (inclusive) and 60 (exclusive)

    elseif ($feed['ip_nps_score'] <= $benchmark_for_nps_yellow) {

        $ip_nps_color = 'color:  #f0ad4e; display: inline-block;'; // Yellow

        $ip_medium_nps = true;

    }

    // If the score is between 60 (inclusive) and 80 (exclusive)

    elseif ($feed['ip_nps_score'] >= $benchmark_for_nps_green) {

        $ip_nps_color = 'color:  #198754; display: inline-block;'; // Green

    }



    if ($feed['ip_psat_score'] <= $benchmark_for_psat_red) {

        $ip_psat_color = 'color: #d9534f; display: inline-block;'; // Red

        $ip_low_psat = true;

    } elseif ($feed['ip_psat_score'] <= $benchmark_for_psat_yellow) {

        $ip_psat_color = 'color:  #f0ad4e; display: inline-block;'; // Yellow

        $ip_medium_psat = true;

    } elseif ($feed['ip_psat_score'] >= $benchmark_for_psat_green) {

        $ip_psat_color = 'color:  #198754; display: inline-block;'; // Green

    }

}



foreach ($ip_feedbacks_count as $feeds_ip) {

    $ipfeeds[] = json_decode($feeds_ip->dataset, true);

    if ($feeds_ip->source == 'Link') {

        $ip_web++;

    }

    if ($feeds_ip->source == 'APP') {

        $ip_app++;

    }

    if ($feeds_ip->source == 'QR') {

        $ip_qr++;

    }

}





foreach ($ipfeeds as $feeds2 => $ipfeedback) {

    if ($ipfeedback['langsub'] == $lang1) {

        $lang['ip_1']++;

    }

    if ($ipfeedback['langsub'] == $lang2) {

        $lang['ip_2']++;

    }

    if ($ipfeedback['langsub'] == $lang3) {

        $lang['ip_3']++;

    }

}





if (ismodule_active('OP') === true) {

    //OPF

    $num_of_modules++;



    $op_feedbacks_count = $this->opf_model->patient_and_feedback('bf_opatients', 'bf_outfeedback', $sorttime, 'setupop');

    $op_nps = $this->opf_model->nps_analytics('bf_outfeedback', $asc, 'setupop');

    $op_psat = $this->opf_model->psat_analytics('bf_opatients', 'bf_outfeedback', 'ticketsop', $sorttime);

    $hospital_selection['op'] = $this->ipd_model->reason_to_choose_hospital('bf_outfeedback', $sorttime);



    $ticket_resolution_rate_op = $this->opf_model->ticket_resolution_rate('ticketsop', $closed, 'bf_outfeedback');

    $close_rate_op = $this->opf_model->ticket_rate('ticketsop', $status, 'bf_outfeedback', 'ticketop_message');

    $avg_ticket_time_op = secondsToTimeforreport($close_rate_op);



    $opalltickets = $this->ticketsop_model->alltickets();

    $opopentickets = $this->ticketsop_model->read();

    $opclosedtickets = $this->ticketsop_model->read_close();

    $opaddressed = $this->ticketsop_model->addressedtickets();



    $tickets['op_alltickets'] = count($opalltickets);

    $tickets['op_opentickets'] = count($opopentickets);

    $tickets['op_closedtickets'] = count($opclosedtickets);

    $tickets['op_addressedtickets'] = count($opaddressed);

    $tickets['op_resolution_rate'] = $ticket_resolution_rate_op;

    $tickets['op_resolution_time'] = $avg_ticket_time_op;



    $feed['op_feedback'] = count($op_feedbacks_count);

    $feed['op_tickets'] = count($opalltickets);

    $feed['op_nps_score'] = $op_nps['nps_score'];

    $feed['op_promoters_count'] = $op_nps['promoters_count'];

    $feed['op_detractors_count'] = $op_nps['detractors_count'];

    $feed['op_passives_count'] = $op_nps['passives_count'];

    $feed['op_satisfied_count'] = $op_psat['satisfied_count'];

    $feed['op_unsatisfied_count'] = $op_psat['unsatisfied_count'];

    $feed['op_psat_score'] = $op_psat['psat_score'];





    if ($feed['op_nps_score']  <= $benchmark_for_nps_red) {

        $op_nps_color = 'color: #d9534f; display: inline-block;';

        $op_low_nps = true;

    } elseif ($feed['op_nps_score'] >= $benchmark_for_nps_yellow) {

        $op_nps_color = 'color:  #f0ad4e; display: inline-block;';

        $op_medium_nps = true;

    } else {

        $op_nps_color = 'color:  #198754; display: inline-block;';

        $op_high_nps = true;

    }



    if ($feed['op_psat_score']  <= $benchmark_for_psat_red) {

        $op_psat_color = 'color: #d9534f; display: inline-block;';

    } elseif ($feed['op_nps_score'] >= $benchmark_for_psat_yellow) {

        $op_psat_color = 'color:  #f0ad4e; display: inline-block;';

    } else {

        $op_psat_color = 'color:  #198754; display: inline-block;';

    }



    // $op_web = 0;

    // $op_app = 0;

    // $op_qr = 0;

    // $lang['op_1'] = 0;

    // $lang['op_2'] = 0;

    // $lang['op_3'] = 0;



    foreach ($op_feedbacks_count as $ofeeds) {

        $opfeeds[] = json_decode($ofeeds->dataset, true);

        if ($ofeeds->source == 'Link') {

            $op_web++;

        }

        if ($ofeeds->source == 'APP') {

            $op_app++;

        }

        if ($ofeeds->source == 'QR') {

            $op_qr++;

        }

    }



    foreach ($opfeeds as $feeds3 => $opfeedback) {



        if ($opfeedback['langsub'] == $lang1) {

            $lang['op_1']++;

        }

        if ($opfeedback['langsub'] == $lang2) {

            $lang['op_2']++;

        }

        if ($opfeedback['langsub'] == $lang3) {

            $lang['op_3']++;

        }

    }

}



if (ismodule_active('PCF') === true) {

    //PCF

    $ticket_resolution_rate_pc = $this->pc_model->ticket_resolution_rate('tickets_int', $closed, 'bf_feedback_int');

    $close_rate_pc = $this->pc_model->ticket_rate('tickets_int', $status, 'bf_feedback_int', 'ticket_int_message');

    $avg_ticket_time_pc = secondsToTimeforreport($close_rate_pc);

    $pcalltickets = $this->ticketsint_model->alltickets();

    $pcopentickets = $this->ticketsint_model->read();

    $pcclosedtickets = $this->ticketsint_model->read_close();

    $pcaddressed = $this->ticketsint_model->addressedtickets();

    $tickets['pc_alltickets'] = count($pcalltickets);

    $tickets['pc_opentickets'] = count($pcopentickets);

    $tickets['pc_closedtickets'] = count($pcclosedtickets);

    $tickets['pc_addressedtickets'] = count($pcaddressed);

    $tickets['pc_resolution_rate'] = $ticket_resolution_rate_pc;

    $tickets['pc_resolution_time'] = $avg_ticket_time_pc;

}



if (ismodule_active('ISR') === true) {

    //ISR

    $ticket_resolution_rate_isr = $this->isr_model->ticket_resolution_rate('tickets_esr', $closed, 'bf_feedback_esr');

    $close_rate_isr = $this->isr_model->ticket_rate('tickets_esr', $status, 'bf_feedback_esr', 'ticket_esr_message');

    $avg_ticket_time_isr = secondsToTimeforreport($close_rate_isr);

    $isralltickets = $this->ticketsesr_model->alltickets();

    $isropentickets = $this->ticketsesr_model->read();

    $isrclosedtickets = $this->ticketsesr_model->read_close();

    $israddressed = $this->ticketsesr_model->addressedtickets();

    $tickets['isr_alltickets'] = count($isralltickets);

    $tickets['isr_opentickets'] = count($isropentickets);

    $tickets['isr_closedtickets'] = count($isrclosedtickets);

    $tickets['isr_addressedtickets'] = count($israddressed);

    $tickets['isr_resolution_rate'] = $ticket_resolution_rate_isr;

    $tickets['isr_resolution_time'] = $avg_ticket_time_isr;

}



if (ismodule_active('INCIDENT') === true) {

    //INC

    $ticket_resolution_rate_inc = $this->incident_model->ticket_resolution_rate('tickets_incident', $closed, 'bf_feedback_incident');

    $close_rate_inc = $this->incident_model->ticket_rate('tickets_incident', $status, 'bf_feedback_incident', 'ticket_incident_message');

    $avg_ticket_time_inc = secondsToTimeforreport($close_rate_inc);

    $incalltickets = $this->ticketsincidents_model->alltickets();

    $incopentickets = $this->ticketsincidents_model->read();

    $incclosedtickets = $this->ticketsincidents_model->read_close();

    $incaddressed = $this->ticketsincidents_model->addressedtickets();

    $tickets['inc_alltickets'] = count($incalltickets);

    $tickets['inc_opentickets'] = count($incopentickets);

    $tickets['inc_closedtickets'] = count($incclosedtickets);

    $tickets['inc_addressedtickets'] = count($incaddressed);

    $tickets['inc_resolution_rate'] = $ticket_resolution_rate_inc;

    $tickets['inc_resolution_time'] = $avg_ticket_time_inc;

}



if (ismodule_active('GRIEVANCE') === true) {

    //SG

    $ticket_resolution_rate_sg = $this->grievance_model->ticket_resolution_rate('tickets_grievance', $closed, 'bf_feedback_grievance');

    $close_rate_sg = $this->grievance_model->ticket_rate('tickets_grievance', $status, 'bf_feedback_grievance', 'ticket_grievance_message');

    $avg_ticket_time_sg = secondsToTimeforreport($close_rate_sg);

    $sgalltickets = $this->ticketsgrievance_model->alltickets();

    $sgopentickets = $this->ticketsgrievance_model->read();

    $scclosedtickets = $this->ticketsgrievance_model->read_close();

    $sgaddressed = $this->ticketsgrievance_model->addressedtickets();

    $tickets['sg_alltickets'] = count($sgalltickets);

    $tickets['sg_opentickets'] = count($sgopentickets);

    $tickets['sg_closedtickets'] = count($scclosedtickets);

    $tickets['sg_addressedtickets'] = count($sgaddressed);

    $tickets['sg_resolution_rate'] = $ticket_resolution_rate_sg;

    $tickets['sg_resolution_time'] = $avg_ticket_time_sg;

}



// other logics for overviewpage



$totalfeeds = $feed['ip_feedback'] + $feed['op_feedback'] + $feed['adf_feedback'];

$totalticks = $tickets['adf_alltickets'] + $tickets['ip_alltickets']  + $tickets['op_alltickets']  + $tickets['pc_alltickets'] + $tickets['inc_alltickets'] + $tickets['isr_alltickets'] + $tickets['sg_alltickets'];



$feedbacks_from_app = $ip_app + $op_app + $adf_app;

$feedbacks_from_qr = $ip_qr + $op_qr + $adf_qr;

$feedbacks_from_link = $ip_web + $op_web + $adf_web;



$satisfied_patients_count =  $feed['ip_satisfied_count'] + $feed['op_satisfied_count'] + $feed['adf_satisfied_count'];

// $neutral_patients_count =  $feed['ip_neutral_count'] + $feed['op_neutral_count'] = $feed['adf_neutral_count'];

$neutral_patients_count =  0;

$unsatisfied_patients_count =  $feed['ip_unsatisfied_count'] + $feed['op_unsatisfied_count'] + $feed['adf_unsatisfied_count'];



$overall_psat =  (($feed['ip_psat_score'] + $feed['op_psat_score'] + $feed['adf_psat_score']) / $num_of_modules);

$overall_psat_score = round($overall_psat, 2);







$promoters_count =  $feed['ip_promoters_count'] + $feed['op_promoters_count'] + $feed['adf_promoters_count'];

$detractors_count =  $feed['ip_detractors_count'] + $feed['op_detractors_count'] + $feed['adf_detractors_count'];

$passive_count =  $feed['ip_passives_count'] + $feed['op_passives_count'] + $feed['adf_passives_count'];



$overall_nps =  (($feed['ip_nps_score'] + $feed['op_nps_score'] + $feed['adf_nps_score']) / $num_of_modules);

$overall_nps_score = round($overall_nps, 2);

// echo '<pre>';

// print_r($hospital_selection);

// exit;





// Function to consolidate data

function consolidateData($adf, $ip, $op)

{

    $consolidated = [];



    foreach (array_merge($adf, $ip, $op) as $item) {

        $key = $item->title;

        if (!isset($consolidated[$key])) {

            $consolidated[$key] = (object)["percentage" => 0, "count" => 0];

        }



        $consolidated[$key]->percentage += $item->percentage;

        $consolidated[$key]->count += $item->count;

    }



    // Sort the array by percentage in ascending order

    uasort($consolidated, function ($a, $b) {

        return $a->percentage <=> $b->percentage;

    });



    return $consolidated;

}





// Consolidate the data

$consolidated_data = consolidateData($hospital_selection['adf'], $hospital_selection['ip'], $hospital_selection['op']);





// $lastElement = end($consolidated_data);

// print_r($lastElement);



// exit;

// Output the consolidated data

// print_r($hospital_selection['ip']);

// exit;

