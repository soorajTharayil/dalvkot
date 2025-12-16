<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $dates = get_from_to_date();
        $this->load->model(array(
            'dashboard_model',
            'efeedor_model',
            'ticketsadf_model', //1
            'tickets_model', //2
            'ticketsint_model', //3
            'ticketsop_model', // 4
            'ticketsesr_model', // 5 
            'ticketsgrievance_model',  //  6
            'ticketsincidents_model', // 7 
            'ipd_model',
            'opf_model',
            'pc_model',
            'isr_model',
            'incident_model',
            'grievance_model',
            'admissionfeedback_model',
            'departmenthead_model',
            'setting_model'
        ));
    }

    function index()
    {
        $report['feedbacks'] = $this->feedback_report_api();
        $report['tickets'] = $this->ticket_report_api();
        $jsonString = json_encode($report);
        $reportObject = json_decode($jsonString, false);
        echo json_encode($reportObject);
    }

    private function feedback_report_api()
    {
        $feedbacks[] = $this->getIP();
        $feedbacks[] = $this->getOP();
        $feedbacks[] = $this->getADF();
        return $feedbacks;
    }

    private function ticket_report_api()
    {
        $closed = $status = 'closed';
        //ADF
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

        //IPDF
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

        //OPF
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

        return $tickets;
    }


    private function getADF()
    {
        $table_feedback = 'bf_feedback_adf';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup_adf';
        $asc = 'asc';
        $table_tickets = 'tickets_adf';
        $adf_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback('bf_patients', 'bf_feedback_adf', $sorttime, 'setup_adf');
        $adfalltickets = $this->ticketsadf_model->alltickets();
        $adf_nps = $this->admissionfeedback_model->nps_analytics('bf_feedback_adf', $asc, 'setup_adf');
        $adf_psat = $this->admissionfeedback_model->psat_analytics('bf_patients', 'bf_feedback_adf', 'tickets_adf', $sorttime);

        $adf['adf_feedback'] = count($adf_feedbacks_count);
        $adf['adf_tickets'] = count($adfalltickets);
        $adf['adf_nps_score'] = $adf_nps['nps_score'];
        $adf['adf_promoters_count'] = $adf_nps['promoters_count'];
        $adf['adf_detractors_count'] = $adf_nps['detractors_count'];
        $adf['adf_passives_count'] = $adf_nps['passives_count'];

        $adf['adf_satisfied_count'] = $adf_psat['satisfied_count'];
        $adf['adf_unsatisfied_count'] = $adf_psat['unsatisfied_count'];
        // print_r($ip);
        return $adf;
    }


    private function getIP()
    {
        $table_feedback = 'bf_feedback';
        $table_patients = 'bf_patients';
        $sorttime = 'asc';
        $setup = 'setup';
        $asc = 'asc';
        $table_tickets = 'tickets';
        $ip_feedbacks_count = $this->ipd_model->patient_and_feedback('bf_patients', 'bf_feedback', $sorttime, 'setup');
        $ipalltickets = $this->tickets_model->alltickets();
        $ip_nps = $this->ipd_model->nps_analytics('bf_feedback', $asc, 'setup');
        $ip_psat = $this->ipd_model->psat_analytics('bf_patients', 'bf_feedback', 'tickets', $sorttime);

        $ip['ip_feedback'] = count($ip_feedbacks_count);
        $ip['ip_tickets'] = count($ipalltickets);
        $ip['ip_nps_score'] = $ip_nps['nps_score'];
        $ip['ip_promoters_count'] = $ip_nps['promoters_count'];
        $ip['ip_detractors_count'] = $ip_nps['detractors_count'];
        $ip['ip_passives_count'] = $ip_nps['passives_count'];

        $ip['ip_satisfied_count'] = $ip_psat['satisfied_count'];
        $ip['ip_unsatisfied_count'] = $ip_psat['unsatisfied_count'];
        // print_r($ip);
        return $ip;
    }




    public function getOP()
    {
        $table_feedback = 'bf_outfeedback';
        $table_patients = 'bf_opatients';
        $sorttime = 'asc';
        $setup = 'setupop';
        $asc = 'asc';
        $table_tickets = 'ticketsop';
        $op_feedbacks_count = $this->opf_model->patient_and_feedback('bf_opatients', 'bf_outfeedback', $sorttime, 'setupop');
        $opalltickets = $this->tickets_model->alltickets();
        $op_nps = $this->opf_model->nps_analytics('bf_outfeedback', $asc, 'setupop');
        $op_psat = $this->opf_model->psat_analytics('bf_opatients', 'bf_outfeedback', 'ticketsop', $sorttime);

        $op['op_feedback'] = count($op_feedbacks_count);
        $op['op_tickets'] = count($opalltickets);
        $op['op_nps_score'] = $op_nps['nps_score'];
        $op['op_promoters_count'] = $op_nps['promoters_count'];
        $op['op_detractors_count'] = $op_nps['detractors_count'];
        $op['op_passives_count'] = $op_nps['passives_count'];
        $op['op_satisfied_count'] = $op_psat['satisfied_count'];
        $op['op_unsatisfied_count'] = $op_psat['unsatisfied_count'];
        // print_r($ip);
        return $op;
    }
}
