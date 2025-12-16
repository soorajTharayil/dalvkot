<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trend_analytic extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Trend_analytic_model');
        $this->load->model('efeedor_model');
        header('Content-Type: application/json');
    }


// public function __construct()
//     {
//         parent::__construct();
//         $this->load->library('session');
//         // $dates = get_from_to_date();
//         $this->load->model(
//             array(
//                 'dashboard_model',
//                 'efeedor_model',
//                 'ticketsadf_model', //1
//                 'tickets_model', //2
//                 'ticketsint_model', //3
//                 'ticketsop_model', // 4
//                 'ticketsesr_model', // 5 
//                 'ticketsgrievance_model',  //  6
//                 'ticketsincidents_model', // 7 
//                 'ticketspdf_model', // 7 
//                 'ipd_model',
//                 'opf_model',
//                 'pc_model',
//                 'isr_model',
//                 'post_model',
//                 'incident_model',
//                 'grievance_model',
//                 'admissionfeedback_model',
//                 'departmenthead_model',
//                 'setting_model'
//             )
//         );
//     }
    public function feedback_status_count() {
        $param = $this->uri->segment(3);
        $fdate = $_SESSION['from_date'];
        $tdate = $_SESSION['to_date'];
        $allFeedback = $this->efeedor_model->get_feedback('bf_patients','bf_feedback',$fdate, $tdate);
        $setup = $this->efeedor_model->setup_result('setup');
        // Call model to pull data based on the passed parameter
        $data = $this->Trend_analytic_model->get_chart_data($param,$allFeedback,$setup);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
    
    public function parameter_relative_performance() {
        $param = $this->uri->segment(3); 
        $fdate = $_SESSION['from_date'];
        $tdate = $_SESSION['to_date'];
        $allFeedback = $this->efeedor_model->get_feedback('bf_patients','bf_feedback',$fdate, $tdate);
        $setup = $this->efeedor_model->setup_result('setup');
        // Call model to pull data based on the passed parameter
        $data = $this->Trend_analytic_model->get_relative_performance($param,$allFeedback,$setup);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['value'],
                'label'=>$data['label']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
    
    
     public function get_response_count() {
        $param = $this->uri->segment(3); 
        $fdate = $_SESSION['from_date'];
        $tdate = $_SESSION['to_date'];
        $allFeedback = $this->efeedor_model->get_feedback('bf_patients','bf_feedback',$fdate, $tdate);
        $setup = $this->efeedor_model->setup_result('setup');
        // Call model to pull data based on the passed parameter
        $data = $this->Trend_analytic_model->get_response_count($param,$allFeedback,$setup);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['value'],
                'label'=>$data['label']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
    
     public function ticket_percentage() {
        $param = $this->uri->segment(3); 
        $fdate = $_SESSION['from_date'];
        $tdate = $_SESSION['to_date'];
        $allTickets = $this->efeedor_model->get_tickets('bf_feedback','tickets',$fdate, $tdate);
        $setup = $this->efeedor_model->setup_result('setup');
        $department = $this->efeedor_model->get_department('inpatient');
        // Call model to pull data based on the passed parameter
        $data = $this->Trend_analytic_model->ticket_percentage($param,$allTickets,$setup,$department);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['value'],
                'label'=>$data['label']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
    
    
    
    
    public function ticket_count() {
         
        $param = $this->uri->segment(3); 
        $fdate = $_SESSION['from_date'];
        $tdate = $_SESSION['to_date'];
        $allTickets = $this->efeedor_model->get_tickets('bf_feedback','tickets',$fdate, $tdate);
        $setup = $this->efeedor_model->setup_result('setup');
        $department = $this->efeedor_model->get_department('inpatient');
        // Call model to pull data based on the passed parameter
        $data = $this->Trend_analytic_model->ticket_count($param,$allTickets,$setup,$department);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['value'],
                'label'=>$data['label']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
}
