<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analytics_op extends CI_Controller
{
   
    private $table_feedback;
    private $table_patients;
    private $sorttime;
    private $setup;
    private $asc;
    private $desc;
    private $table_tickets;
    private $open;
    private $closed;
    private $type;

    private $addressed;




    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(
            array(
                'dashboard_model',
                'efeedor_model',
                'ticketsint_model',
                'tickets_model',
                'ticketsop_model',
                'opf_model',
                'setting_model'
            )
        );

        $this->table_feedback = 'bf_outfeedback';
        $this->table_patients = 'bf_opatients';
        $this->sorttime = 'asc';
        $this->setup = 'setupop';
        $this->asc = 'asc';
        $this->desc = 'desc';
        $this->table_tickets = 'ticketsop';
        $this->open = 'Open';
        $this->closed = 'Closed';
        $this->addressed = 'Addressed';
        $this->type = 'outpatient';
    }






    public function patient_feedback_analysis()
    {
        //echo $_SESSION['ward'];

        $question_list_parent = $this->opf_model->setup_result($this->setup);
        $feedback_data = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);

        $set = array();
        $resonse = array();
        foreach ($question_list_parent as $row) {
            $set['label_field'] = $row->shortname;
            $set['type'] = $row->type;
            $set['data_field'] = $this->get_total_feedback_rating_percentage($row->shortkey, $feedback_data);
            $set['data_field_count'] = $this->get_total_feedback_rating_count($row->shortkey, $feedback_data);
            $set['question'] = $row->question;

            $set['rated_1'] = $this->get_total_feedback_rated_count($row->shortkey, $feedback_data, 1);
            $set['rated_2'] = $this->get_total_feedback_rated_count($row->shortkey, $feedback_data, 2);
            $set['rated_3'] = $this->get_total_feedback_rated_count($row->shortkey, $feedback_data, 3);
            $set['rated_4'] = $this->get_total_feedback_rated_count($row->shortkey, $feedback_data, 4);
            $set['rated_5'] = $this->get_total_feedback_rated_count($row->shortkey, $feedback_data, 5);
            $set['total_feedback'] = $set['rated_1'] + $set['rated_2'] + $set['rated_3'] + $set['rated_4'] + $set['rated_5'];
            $set['all_detail'] = $set;
            $resonse[] = $set;
        }

        echo json_encode($resonse);
        exit;
    }


    public function patient_satisfaction_analysis()
    {
        //$dates = get_from_to_date();
        //print_r($dates); exit;
        $all_tickets = $this->opf_model->get_tickets($this->table_feedback, $this->table_tickets, $this->sorttime);
        //print_r($all_tickets);
        $feedback_data = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime,$fdate,$tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {

                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
            // if ($days > 0) {
            //     if ($days < 183 && $days > 10) {
            //         $desdate = getStartAndEndDate(date("W", strtotime($row->datetime)), $y);
            //         $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . date("F", strtotime($row->datetime));
            //     }
            // }
            if (!isset($report[$mon])) {
                $report[$mon]['rating_bar_negative'] = 0;
                $report[$mon]['rating_bar_positive'] = 0;
                $report[$mon]['rating_bar_all'] = 0;
            }

            // echo '<br />';
            // echo $row->id;
            // echo '<br />';
            $ticket_data = array();
            foreach ($all_tickets as $t) {
                //echo $t->feedbackid;

                if ($t->feedbackid == $row->id) {
                    $ticket_data[] = $t;
                }
            }

            if (count($ticket_data) > 0) {
                $report[$mon]['rating_bar_negative'] = $report[$mon]['rating_bar_negative'] + 1;
            } else {
                $report[$mon]['rating_bar_positive'] = $report[$mon]['rating_bar_positive'] + 1;
            }

            $report[$mon]['rating_bar_all'] = $report[$mon]['rating_bar_all'] + 1;
        }
        $response = array();
        foreach ($report as $key => $row) {
            $set = array();
            $set['label_field'] = $key;
            $set['data_field'] = round(($report[$key]['rating_bar_positive'] / $report[$key]['rating_bar_all']) * 100);
            $set['all_detail'] = $report[$key];
            $response[] = $set;
        }


        echo json_encode($response);
        exit;
    }


    public function resposnsechart()
    {

        //$dates = get_from_to_date();
        $feedback_data = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime,$fdate,$tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
            // if ($days > 0) {
            //     if ($days < 183 && $days > 10) {
            //         $desdate = getStartAndEndDate(date("W", strtotime($row->datetime)), $y);
            //         $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . date("F", strtotime($row->datetime));
            //     }
            // }
            $param = json_decode($row->dataset);
            if (!isset($report[$mon])) {
                $report[$mon]['count'] = 0;
            }
            $avg = count($row);
            if ($avg > 0) {
                $report[$mon]['count'] = $report[$mon]['count'] + 1;
            } else {
                $report[$mon]['count'] = 0;
            }
            $report[$mon]['overall'] = count($feedback_data);
        }
        $response = array();
        foreach ($report as $key => $row) {
            $set = array();
            $set['label_field'] = $key;
            $set['data_field'] = round((($report[$key]['count']) / count($feedback_data)) * 100);
            $set['all_detail'] = $report[$key];
            $response[] = $set;
        }
        echo json_encode($response);
        exit;
    }



    public function net_permoter_analysis()
    {        //$dates = get_from_to_date();
        $feedback_data = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
     
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime,$fdate,$tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
            // if ($days > 0) {
            //     if ($days < 183 && $days > 10) {
            //         $desdate = getStartAndEndDate(date("W", strtotime($row->datetime)), $y);
            //         $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . date("F", strtotime($row->datetime));
            //     }
            // }
            $param = json_decode($row->dataset);
            if (!isset($report[$mon])) {
                $report[$mon]['permoter'] = 0;
                $report[$mon]['passive'] = 0;
                $report[$mon]['demoter'] = 0;
                $report[$mon]['overall'] = 0;
            }
            $avg = $param->recommend1Score;
            if ($avg > 4) {
                $report[$mon]['permoter'] = $report[$mon]['permoter'] + 1;
            } else if ($avg == 4 || $avg == 3.5) {
                $report[$mon]['passive'] = $report[$mon]['passive'] + 1;
            } else {
                $report[$mon]['demoter'] = $report[$mon]['demoter'] + 1;
            }
            $report[$mon]['overall'] = $report[$mon]['overall'] + 1;
        }
        $response = array();
        foreach ($report as $key => $row) {
            $set = array();
            $set['label_field'] = $key;
            $set['data_field'] = round((($report[$key]['permoter'] - $report[$key]['demoter']) / $report[$key]['overall']) * 100);
            $set['all_detail'] = $report[$key];
            $response[] = $set;
        }


        echo json_encode($response);
        exit;
    }


    public function why_patient_choose()
    {
        //$dates = get_from_to_date();
        $feedback_data = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
        $overallarray = array('location' => 'Location', 'specificservice' => 'Specific services offered', 'referred' => 'Referred by doctors', 'friend' => 'Friend/Family recommendation', 'previous' => 'Previous experience', 'docAvailability' => 'Insurance facilities', 'companyRecommend' => 'Company Recommendation', 'otherReason' => 'Print or Online Media');
        $locationKeySet = array();
        foreach ($overallarray as $key => $value) {
            $locationKeySet[] = $key;
        }
        $report = array();
        $response = array();
        foreach ($overallarray as $key => $row) {
            $set = array();
            $data = $this->get_toal_user_count_inpercentage($key, $feedback_data, $locationKeySet);
            $percentage = $data['percentage'];
            $count = $data['count'];
            $set['label_field'] = $row . '- ' . $percentage . '%';
            $set['data_field'] = $percentage;
            $set['data_field_count'] = $count;
            $set['other'] = $data;
            $response[] = $set;
        }
        echo json_encode($response);
        exit;
    }

    public function tickets_recived_by_department()
    {
        //$dates = get_from_to_date();
        $department = $this->opf_model->get_department($this->type, false);
        $get_tickes = $this->opf_model->get_tickets($this->table_feedback, $this->table_tickets);
        //  print_r($get_tickes); 
        $report = array();
        $response = array();
        foreach ($department as $key => $row) {
            $set = array();
            $data = $this->get_toal_ticket_by_department($row->dprt_id, $get_tickes);
            $percentage = $data['percentage'];
            $total_count = $data['total_count'];
            $open_tickets = $data['open_tickets'];
            $closed_tickets = $data['closed_tickets'];
            $addressed_tickets = $data['addressed_tickets'];
            $tr_rate = $data['tr_rate'];
            $set['label_field'] = $row->description . ' (' . $percentage . '%)';
            $set['data_field'] = $percentage;
            $set['data_field_count'] = $total_count;
            $set['closed_tickets'] = $closed_tickets;
            $set['open_tickets'] = $open_tickets;
            if (ticket_addressal('ip_addressal') === true) {

                $set['addressed_tickets'] = $addressed_tickets;
            }
            $set['tr_rate'] = $tr_rate;
            $response[] = $set;
        }
        echo json_encode($response);
        exit;
    }

    private function get_toal_ticket_by_department($key, $tickes)
    {
        $total = 0;
        $total_percentage = 0;
        $open_tickets = 0;
        $closed_tickets = 0;
        $addressed_tickets = 0;
        foreach ($tickes as $row) {
            if ($row->departmentid == $key) {
                $total++;
            }
        }
        foreach ($tickes as $row) {
            if ($row->departmentid == $key && $row->status == 'Open') {
                $open_tickets++;
            } elseif ($row->departmentid == $key && $row->status == 'Addressed') {
                $addressed_tickets++;
            } elseif ($row->departmentid == $key && $row->status == 'Closed') {
                $closed_tickets++;
            }
        }
        if ($total > 0 && count($tickes) > 0) {
            $total_percentage = round(($total / count($tickes)) * 100);
        }
        if ($closed_tickets > 0 && count($tickes) > 0) {
            $tr_rate = round(($closed_tickets / count($tickes)) * 100);
        } else {
            $tr_rate = 0;
        }



        $data = array();
        $data['percentage'] = $total_percentage;
        $data['total_count'] = $total;
        $data['open_tickets'] = $open_tickets;
        $data['closed_tickets'] = $closed_tickets;
        $data['addressed_tickets'] = $addressed_tickets;
        $data['tr_rate'] = $tr_rate;
        return $data;
    }


    private function get_toal_user_count_inpercentage($key, $feedback_data, $locationKeySet)
    {

        $total = 0;
        $total_percentage = 0;
        $total_selection = 0;
        foreach ($feedback_data as $row) {
            $dataset = json_decode($row->dataset, true);
            if (isset($dataset[$key]) && $dataset[$key] === true) {
                $total++;
            }

            foreach ($locationKeySet as $locationKey) {
                if (isset($dataset[$locationKey]) &&  $dataset[$locationKey] === true) {
                    $total_selection++;
                }
            }
        }
        if ($total > 0 && count($feedback_data) > 0) {
            $total_percentage = round(($total / $total_selection * 100));
        }

        $data = array();
        $data['percentage'] = $total_percentage;
        $data['count'] = $total;
        $data['total_selection'] = $total_selection;
        return $data;
    }

    private function get_total_feedback_rating_percentage($key, $feedback)
    {
        $total = 0;
        $total_incidence = 0;

        foreach ($feedback as $row) {

            $dataset = json_decode($row->dataset, true);

            if (isset($dataset[$key]) && $dataset[$key] > 0) {
                $total_incidence++;
                $total = $total + $dataset[$key];
            }
        }
        if ($total_incidence > 0) {
            $percentage = round(($total / ($total_incidence * 5)) * 100);
        } else {
            $percentage = 0;
        }

        return $percentage;
    }


    private function get_total_feedback_rated_count($key, $feedback_data, $value_to_check)
    {
        $total_incidence = 0; // Initialize the total_incidence outside the loop
        foreach ($feedback_data as $row) {
            $dataset = json_decode($row->dataset, true);
            if (isset($dataset[$key]) && $dataset[$key] == $value_to_check) {
                $total_incidence++;
            }
        }
        return $total_incidence; // Return the total_incidence after the loop is done counting occurrences.
    }

    private function get_total_feedback_rating_count($key, $feedback)
    {

        foreach ($feedback as $row) {
            $total = 0;
            $total_incidence = 0;
            $dataset = json_decode($row->dataset, true);

            if (isset($dataset[$key]) && $dataset[$key] > 0) {
                $total_incidence++;
                $total = $total + $dataset[$key];
            }
            if ($total_incidence > 0) {
                $percentage = round(($total / ($total_incidence * 5)) * 100);
            } else {
                $percentage = 0;
            }

            return $percentage;
        }
    }

    public function trend_analysis()
    {
        $days = $_SESSION['days'];
        $set = array();
        $net_pscore = array();
        $y = date('Y');
        $dataexport = array();
        $i = 1;

        // Get setup results and patient feedback data
        $sresult = $this->opf_model->setup_result($this->setup);
        $ip_feedbacks_count = $this->opf_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
 
        // Initialize arrays for calculations
        $feedback_count = $rated_3n4n5 = $rated_1n2 = $para = array();
        $npsfeedback_count =  $promoters = $passives = $detractors = $nps_para = array();

        $departmentfromdd = $this->uri->segment(3);
        // Extract question array from setup results
        $questioarray = array();
        foreach ($sresult as $question) {
            $questioarray[$question->type][$question->shortkey] = $question->shortname;
        }

        // Flatten the question array for easy access
        $shortnames_array = array();
        if ($questioarray[$departmentfromdd]) {
            foreach ($questioarray[$departmentfromdd] as $question  => $shortnames_value) {
                $shortnames_array[$question] = $shortnames_value;
            }
        } else {
            foreach ($questioarray as $setr) {
                foreach ($setr as $slug_val_in_setup => $shortnames_value) {
                    $shortnames_array[$slug_val_in_setup] = $shortnames_value;
                }
            }
        }
        // Populate $dataexport with feedback data
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($ip_feedbacks_count as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime,$fdate,$tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
            // if ($days > 0) {
            //     if ($days < 183 && $days > 10) {
            //         $desdate = getStartAndEndDate(date("W", strtotime($row->datetime)), $y);
            //         $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . date("F", strtotime($row->datetime));
            //     }
            // }
            $feedback_table_dataset = json_decode($row->dataset, true);
            foreach ($shortnames_array as $slug_val_in_setup => $rating_receiv) {
                $dataexport[$mon][$slug_val_in_setup][$i] = $feedback_table_dataset[$slug_val_in_setup];
                $net_pscore[$mon][$slug_val_in_setup][]  = ($feedback_table_dataset['recommend1Score'] * 2);
            }
            $i++;
        }
   

        foreach ($net_pscore as $mon => $monData_nps) {
            foreach ($monData_nps as $slug_val_in_setup_nps => $npsvalues) {
                foreach ($npsvalues as $index => $nps_received) {
                    if ($nps_received) {
                        // print_r($nps_received);
                        $npsfeedback_count[$mon][$slug_val_in_setup_nps] = $npsfeedback_count[$mon][$slug_val_in_setup_nps] + 1;
                        if ($nps_received > 8) {
                            $promoters[$mon][$slug_val_in_setup_nps] = $promoters[$mon][$slug_val_in_setup_nps] + 1;
                        } elseif ($nps_received < 7) {
                            $detractors[$mon][$slug_val_in_setup_nps] = $detractors[$mon][$slug_val_in_setup_nps] + 1;
                        } else {
                            $passives[$mon][$slug_val_in_setup_nps] = $passives[$mon][$slug_val_in_setup_nps] + 1;
                        }
                        $nps_para[$mon][$slug_val_in_setup_nps] = $nps_para[$mon][$slug_val_in_setup_nps] + $nps_received;
                    }
                }
            }
        }

        // Calculate various statistics using $slug_val_in_setup as the key
        foreach ($dataexport as $mon => $monData) {
            foreach ($monData as $slug_val_in_setup => $values) {
                foreach ($values as $index => $rating_received) {

                    if ($rating_received * 1 > 0) {
                        $feedback_count[$mon][$slug_val_in_setup] = $feedback_count[$mon][$slug_val_in_setup] + 1;
                        if ($rating_received > 2) {
                            $rated_3n4n5[$mon][$slug_val_in_setup] = $rated_3n4n5[$mon][$slug_val_in_setup] + 1;
                        } else {
                            $rated_1n2[$mon][$slug_val_in_setup] = $rated_1n2[$mon][$slug_val_in_setup] + 1;
                        }
                        $para[$mon][$slug_val_in_setup] = $para[$mon][$slug_val_in_setup] + $rating_received;
                    }
                }
            }
        }



        // Consolidate the data into a single associative array
        $consolidated_data = array('department_nps' => array(), 'dep_performance' => array());

        foreach ($net_pscore as $mon => $monData_nps) {
            foreach ($monData_nps as $slug_val_in_setup_nps => $values) {
                $consolidated_data['department_nps'][] = array(
                    'timing' => $mon,
                    'nps_data' => array(
                        'Total Responses' => $npsfeedback_count[$mon][$slug_val_in_setup_nps] ? $npsfeedback_count[$mon][$slug_val_in_setup_nps] : 0,
                        'Received NPS' => $nps_para[$mon][$slug_val_in_setup_nps] ? $nps_para[$mon][$slug_val_in_setup_nps] : 0,
                        'Max NPS' => ($npsfeedback_count[$mon][$slug_val_in_setup_nps] * 10 != 0) ? ($npsfeedback_count[$mon][$slug_val_in_setup_nps] * 10) : 0,
                        'NPS Score' => round((($promoters[$mon][$slug_val_in_setup_nps] - $detractors[$mon][$slug_val_in_setup_nps]) / $npsfeedback_count[$mon][$slug_val_in_setup_nps]) * 100) ? round((($promoters[$mon][$slug_val_in_setup_nps] - $detractors[$mon][$slug_val_in_setup_nps]) / $npsfeedback_count[$mon][$slug_val_in_setup_nps]) * 100) . '%' : 0,
                        'Promoters Count' => $promoters[$mon][$slug_val_in_setup_nps] ? $promoters[$mon][$slug_val_in_setup_nps] : 0,
                        'Detractors Count' => $detractors[$mon][$slug_val_in_setup_nps] ? $detractors[$mon][$slug_val_in_setup_nps] : 0,
                        'Passives Count' => $passives[$mon][$slug_val_in_setup_nps] ? $passives[$mon][$slug_val_in_setup_nps] : 0,
                    ),
                );
            }
        }

        foreach ($dataexport as $mon => $monData) {
            foreach ($monData as $slug_val_in_setup => $values) {
                $consolidated_data['dep_performance'][] = array(
                    'timing' => $mon,
                    'slug' => $shortnames_array[$slug_val_in_setup],
                    'performance_data' => array(
                        'Total Responses' => $feedback_count[$mon][$slug_val_in_setup] ? $feedback_count[$mon][$slug_val_in_setup] : 0,
                        'Received Ratings' => $para[$mon][$slug_val_in_setup] ? $para[$mon][$slug_val_in_setup] : 0,
                        'Max Ratings' => ($feedback_count[$mon][$slug_val_in_setup] * 5 != 0) ? ($feedback_count[$mon][$slug_val_in_setup] * 5) : 0,
                        'Relative Performance' => ($feedback_count[$mon][$slug_val_in_setup] * 5 != 0) ? round(($para[$mon][$slug_val_in_setup] / ($feedback_count[$mon][$slug_val_in_setup] * 5)) * 100) . '%' : 0,
                        'Satisfied Count' => $rated_3n4n5[$mon][$slug_val_in_setup] ? $rated_3n4n5[$mon][$slug_val_in_setup] : 0,
                        'Unsatisfied Count' => $rated_1n2[$mon][$slug_val_in_setup] ? $rated_1n2[$mon][$slug_val_in_setup] : 0,
                    ),
                );
            }
        }


        // Output the consolidated array as JSON
        echo json_encode($consolidated_data);
        exit;
    }


}
