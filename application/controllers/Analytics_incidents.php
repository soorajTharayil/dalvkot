<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analytics_incidents extends CI_Controller
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
                'ticketsincidents_model',
                'incident_model',
                'setting_model'
            )
        );

        $this->table_feedback = 'bf_feedback_incident';
        $this->table_patients = 'bf_employees_incident';
        $this->sorttime = 'asc';
        $this->setup = 'setup_incident';
        $this->asc = 'asc';
        $this->desc = 'desc';
        $this->table_tickets = 'tickets_incident';
        $this->open = 'Open';
        $this->closed = 'Closed';
        $this->addressed = 'Addressed';
        $this->type = 'incident';
    }


    public function tickets_recived_by_department()
    {
        // $dates = get_from_to_date();

        $department = $this->incident_model->get_departmentint($this->type);

        $all_tickes = $this->incident_model->get_tickets($this->table_feedback, $this->table_tickets);
        $report = array();
        $response = array();
        $department_set = array();
        foreach ($department as $departmentRow) {
            if (isset($department_set[$departmentRow->setkey])) {
                $department_set[$departmentRow->setkey]['department_id_set'][] = $departmentRow->dprt_id;
            } else {
                $department_set[$departmentRow->setkey] = array();
                $department_set[$departmentRow->setkey]['department_id_set'] = array();
                $department_set[$departmentRow->setkey]['department_id_set'][] = $departmentRow->dprt_id;
                $department_set[$departmentRow->setkey]['department_name'] = $departmentRow->description;
            }
            asort($department_set);
        }


        foreach ($department_set as $key => $department_set_row) {
            $set = array();
            // echo '<pre>';
            // print_r($department_set_row); exit;
            $data =  $this->get_toal_ticket_by_department($all_tickes, $department_set_row);
            $percentage  = $data['percentage'];
            $total_count  = $data['total_count'];
            $open_tickets = $data['open_tickets'];
            $closed_tickets = $data['closed_tickets'];
            $addressed_tickets = $data['addressed_tickets'];
            $tr_rate = $data['tr_rate'];
            // $total_tickets = $data['total_tickets'];
            $set['label_field'] = $department_set_row['department_name'] . '(' . $percentage . '%)';
            $set['data_field'] = $percentage;
            $set['data_field_count'] = $total_count;
            $set['closed_tickets'] = $closed_tickets;
            $set['open_tickets'] = $open_tickets;
            if (ticket_addressal('incidents_addressal') === true) {

                $set['addressed_tickets'] = $addressed_tickets;
            }
            $set['tr_rate'] = $tr_rate;
            $response[] = $set;
        }
        // Sort the response array by 'data_field' in descending order
        usort($response, function ($a, $b) {
            return $b['data_field'] - $a['data_field'];
        });
        echo json_encode($response);
        exit;
    }


    private function get_toal_ticket_by_department($tickes, $department_set_row)
    {

        $total = 0;
        $total_percentage = 0;
        $open_tickets = 0;
        $closed_tickets = 0;
        $addressed_tickets = 0;

        foreach ($tickes as $row) {
            if (in_array($row->departmentid, $department_set_row['department_id_set'])) {
                $total++;
            }
        }
        foreach ($tickes as $row) {
            if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Open') {
                $open_tickets++;
            }
            if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Closed') {
                $closed_tickets++;
            }
            if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Addressed') {
                $addressed_tickets++;
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
        // $data['total_tickets'] = count($tickes);
        return $data;
    }

    public function why_patient_choose()
    {
        //$dates = get_from_to_date();
        $feedback_data = $this->incident_model->patient_and_feedback($this->table_patients, $this->table_feedback, $this->sorttime, $this->setup);
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
}
