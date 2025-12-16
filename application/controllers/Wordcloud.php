<?php
// defined('BASEPATH') or exit('No direct script access allowed');

class Wordcloud extends CI_Controller
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
                'ipd_model',
                'opf_model',
                'pc_model',
                'isr_model',
                'incident_model',
                'grievance_model',
                'admissionfeedback_model',
                'setting_model'
            )
        );


    }

    public function ip_comment()
    {
        $this->table_feedback = 'bf_feedback';
        $this->table_patients = 'bf_patients';
        $this->sorttime = 'desc';
        $feedback_data = array();
        $feedback_data = $this->ipd_model->commentwords($this->table_patients, $this->table_feedback, $this->sorttime);
        echo json_encode($feedback_data);
        exit;
    }
 
    public function op_comment()
    {
        $this->table_feedback = 'bf_outfeedback';
        $this->table_patients = 'bf_opatients';
        $this->sorttime = 'desc';
        $feedback_data = $this->ipd_model->commentwords($this->table_patients, $this->table_feedback, $this->sorttime);
        echo json_encode($feedback_data);
        exit;
    }



}
