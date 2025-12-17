<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analytics_audit_quality extends CI_Controller
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
                'audit_model',
                'setting_model'
            )
        );

        $this->table_feedback = 'bf_feedback';
        $this->table_patients = 'bf_patients';
        $this->sorttime = 'asc';
        $this->setup = 'setup';
        $this->asc = 'asc';
        $this->desc = 'desc';
        $this->table_tickets = 'tickets';
        $this->open = 'Open';
        $this->closed = 'Closed';
        $this->addressed = 'Addressed';
        $this->type = 'inpatient';
    }





    public function patient_feedback_analysis()
    {
        //echo $_SESSION['ward'];

        $question_list_parent = $this->ipd_model->setup_result($this->setup);
        $feedback_data = $this->ipd_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);

        $set = array();
        $resonse = array();
        foreach ($question_list_parent as $row) {
            $set['label_field'] = $row->shortname;
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






    public function resposnsechart_mrd_audit()
    {

        $table_feedback = 'bf_feedback_mrd_audit';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_ppe_audit()
    {

        $table_feedback = 'bf_feedback_ppe_audit';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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


    public function resposnsechart_lab_safety_audit()
    {

        $table_feedback = 'bf_feedback_lab_safety_audit';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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


    public function resposnsechart_consultation_time()
    {

        $table_feedback = 'bf_feedback_consultation_time';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_lab_time()
    {

        $table_feedback = 'bf_feedback_lab_wait_time';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_xray_time()
    {

        $table_feedback = 'bf_feedback_xray_wait_time';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_usg_time()
    {

        $table_feedback = 'bf_feedback_usg_wait_time';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_ctscan_time()
    {

        $table_feedback = 'bf_feedback_ctscan_time';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_surgical_safety()
    {

        $table_feedback = 'bf_feedback_surgical_safety';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_medicine_dispense()
    {

        $table_feedback = 'bf_feedback_medicine_dispense';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_medication_administration()
    {

        $table_feedback = 'bf_feedback_medication_administration';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_handover()
    {

        $table_feedback = 'bf_feedback_handover';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_prescriptions()
    {

        $table_feedback = 'bf_feedback_prescriptions';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_hand_hygiene()
    {

        $table_feedback = 'bf_feedback_hand_hygiene';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_tat_blood()
    {

        $table_feedback = 'bf_feedback_tat_blood';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_nurse_patients_ratio()
    {

        $table_feedback = 'bf_feedback_nurse_patients_ratio';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_nurse_patients_ratio_ward()
    {

        $table_feedback = 'bf_feedback_nurse_patients_ratio_ward';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_return_to_i()
    {

        $table_feedback = 'bf_feedback_return_to_i';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_return_to_icu()
    {

        $table_feedback = 'bf_feedback_return_to_icu';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_return_to_ed()
    {

        $table_feedback = 'bf_feedback_return_to_ed';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_return_to_emr()
    {

        $table_feedback = 'bf_feedback_return_to_emr';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_safety_inspection()
    {

        $table_feedback = 'bf_feedback_safety_inspection';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_mock_drill()
    {

        $table_feedback = 'bf_feedback_mock_drill';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_code_originals()
    {

        $table_feedback = 'bf_feedback_code_originals';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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


    public function resposnsechart_vap_prevention()
    {

        $table_feedback = 'bf_feedback_vap_prevention';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_catheter_insert()
    {

        $table_feedback = 'bf_feedback_catheter_insert';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_ssi_bundle()
    {

        $table_feedback = 'bf_feedback_ssi_bundle';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_urinary_catheter()
    {

        $table_feedback = 'bf_feedback_urinary_catheter';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_central_line_insert()
    {

        $table_feedback = 'bf_feedback_central_line_insert';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_central_maintenance()
    {

        $table_feedback = 'bf_feedback_central_maintenance';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_room_cleaning()
    {

        $table_feedback = 'bf_feedback_room_cleaning';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_other_cleaning()
    {

        $table_feedback = 'bf_feedback_other_area_cleaning';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_toilet_cleaning()
    {

        $table_feedback = 'bf_feedback_toilet_cleaning';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_canteen()
    {

        $table_feedback = 'bf_feedback_canteen_audit';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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





    public function resposnsechart_1ps()
    {

        $table_feedback = 'bf_feedback_1PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_2ps()
    {

        $table_feedback = 'bf_feedback_2PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_3ps()
    {

        $table_feedback = 'bf_feedback_3PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_4ps()
    {

        $table_feedback = 'bf_feedback_4PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_5ps()
    {

        $table_feedback = 'bf_feedback_5PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_6ps()
    {

        $table_feedback = 'bf_feedback_6PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_7ps()
    {

        $table_feedback = 'bf_feedback_7PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_8ps()
    {

        $table_feedback = 'bf_feedback_8PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_9ps()
    {

        $table_feedback = 'bf_feedback_9PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_10ps()
    {

        $table_feedback = 'bf_feedback_10PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_11ps()
    {

        $table_feedback = 'bf_feedback_11PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_12ps()
    {

        $table_feedback = 'bf_feedback_12PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_13ps()
    {

        $table_feedback = 'bf_feedback_13PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_14ps()
    {

        $table_feedback = 'bf_feedback_14PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_15ps()
    {

        $table_feedback = 'bf_feedback_15PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_16ps()
    {

        $table_feedback = 'bf_feedback_16PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_17ps()
    {

        $table_feedback = 'bf_feedback_17PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_18ps()
    {

        $table_feedback = 'bf_feedback_18PSQ3b';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_19ps()
    {

        $table_feedback = 'bf_feedback_19PSQ3c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_20ps()
    {

        $table_feedback = 'bf_feedback_20PSQ3c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_21ps()
    {

        $table_feedback = 'bf_feedback_21PSQ3c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_21aps()
    {

        $table_feedback = 'bf_feedback_21aPSQ3c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_22ps()
    {

        $table_feedback = 'bf_feedback_22PSQ3c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_23aps()
    {

        $table_feedback = 'bf_feedback_23aPSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_23bps()
    {

        $table_feedback = '	bf_feedback_23bPSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_23cps()
    {

        $table_feedback = 'bf_feedback_23cPSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_23dps()
    {

        $table_feedback = '	bf_feedback_23dPSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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




    public function resposnsechart_24ps()
    {

        $table_feedback = 'bf_feedback_24PSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
    public function resposnsechart_25ps()
    {

        $table_feedback = 'bf_feedback_25PSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_26ps()
    {

        $table_feedback = 'bf_feedback_26PSQ4c';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_27ps()
    {

        $table_feedback = 'bf_feedback_27PSQ4d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_28ps()
    {

        $table_feedback = 'bf_feedback_28PSQ4d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_29ps()
    {

        $table_feedback = 'bf_feedback_29PSQ4d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_30ps()
    {

        $table_feedback = 'bf_feedback_30PSQ4d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_31ps()
    {

        $table_feedback = 'bf_feedback_31PSQ3d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_32ps()
    {

        $table_feedback = 'bf_feedback_32PSQ3d';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_33ps()
    {

        $table_feedback = 'bf_feedback_PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_34ps()
    {

        $table_feedback = 'bf_feedback_33PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_35ps()
    {

        $table_feedback = 'bf_feedback_34PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_36ps()
    {

        $table_feedback = 'bf_feedback_35PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_37ps()
    {

        $table_feedback = 'bf_feedback_36PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_38ps()
    {

        $table_feedback = 'bf_feedback_37PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_39ps()
    {

        $table_feedback = 'bf_feedback_38PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_40ps()
    {

        $table_feedback = 'bf_feedback_39PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_41ps()
    {

        $table_feedback = 'bf_feedback_40PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_42ps()
    {

        $table_feedback = 'bf_feedback_41PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_43ps()
    {

        $table_feedback = 'bf_feedback_42PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_44ps()
    {

        $table_feedback = 'bf_feedback_43PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_45ps()
    {

        $table_feedback = 'bf_feedback_44PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_46ps()
    {

        $table_feedback = 'bf_feedback_45PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_47ps()
    {

        $table_feedback = 'bf_feedback_46PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_48ps()
    {

        $table_feedback = 'bf_feedback_47PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_49ps()
    {

        $table_feedback = 'bf_feedback_48PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_50ps()
    {

        $table_feedback = 'bf_feedback_49PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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

    public function resposnsechart_51ps()
    {

        $table_feedback = 'bf_feedback_50PSQ3a';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $desc = 'desc';
        //$dates = get_from_to_date();
        $feedback_data = $this->audit_model->kpi_feedback($table_patients, $table_feedback, $sorttime, $setup);
        $days = $_SESSION['days'];
        $set = array();
        $report = array();
        $y = date('Y');
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        foreach ($feedback_data as $row) {
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
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
}
