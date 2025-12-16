<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'report_model',
			'efeedor_model',
			'doctor_model',
			'representative_model',
			'tickets_model',
			'ticketsop_model',
			'ticketsint_model',
			'ipd_model',
			'opf_model',
			'pc_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'admissionfeedback_model',
			'ticketsesr_model', // 5 
			'ticketsgrievance_model',  //  6
			'ticketsincidents_model', 
			'ticketsadf_model', //1



		));
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	}
	// IP
	//1
	public function ip_feedback_notifications()
	{
		$data['title'] = 'IP- FEEDBACK NOTIFICATIONS';

		$data['content'] = $this->load->view('ipmodules/ip_feedback_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//2
	public function ip_promoter_list()
	{
		$data['title'] = 'IP- PROMOTER LIST';

		$data['content'] = $this->load->view('ipmodules/ip_promoter_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//3
	public function ip_detractors_list()
	{
		$data['title'] = 'IP- DETRACTORS LIST';

		$data['content'] = $this->load->view('ipmodules/ip_detractors_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//4
	public function ip_passive_list()
	{
		$data['title'] = 'IP- PASSIVES LIST';

		$data['content'] = $this->load->view('ipmodules/ip_passive_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//5
	public function ip_satisfied_list()
	{
		$data['title'] = 'IP- SATISFIED PATIENTS';

		$data['content'] = $this->load->view('ipmodules/ip_satisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//6
	public function ip_unsatisfied_list()
	{
		$data['title'] = 'IP- UNSATISFIED PATIENTS';

		$data['content'] = $this->load->view('ipmodules/ip_unsatisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//end IP


	//OP
	//1
	public function op_feedback_notifications()
	{
		$data['title'] = 'OP- FEEDBACK NOTIFICATIONS';
		$data['content'] = $this->load->view('opmodules/op_feedback_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//2
	public function op_promotors_list()
	{
		$data['title'] = 'OP- PROMOTERS LIST';
		$data['content'] = $this->load->view('opmodules/op_promotors_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//3
	public function op_detractors_list()
	{
		$data['title'] = ' OP- DETRACTORS LIST';

		$data['content'] = $this->load->view('opmodules/op_detractors_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//4
	public function op_passives_list()
	{
		$data['title'] = 'OP- PASSIVES LIST';

		$data['content'] = $this->load->view('opmodules/op_passives_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//5
	public function op_satisfied_list()
	{
		$data['title'] = 'OP- SATISFIED PATIENTS';

		$data['content'] = $this->load->view('opmodules/op_satisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//6
	public function op_unsatisfied_list()
	{
		$data['title'] = 'OP- UNSATISFIED PATIENTS';

		$data['content'] = $this->load->view('opmodules/op_unsatisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//end OP


	//PATIENT COMPLAINTS 
	public function patient_complaint_notifications()
	{
		$data['title'] = 'PC- NOTIFICATIONS';

		$data['content'] = $this->load->view('complaintsmodules/patient_complaint_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//end PATIENT COMPLAINTS 

	//PSR
	public function psr_request_notifications()
	{
		$data['title'] = 'PSR- NOTIFICATIONS';

		$data['content'] = $this->load->view('psrmodules/psr_request_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//end PSR

	//ESR
	public function esr_request_notifications()
	{
		$data['title'] = 'ESR- NOTIFICATIONS';

		$data['content'] = $this->load->view('esrmodules/esr_request_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//end ESR



	//EMPEX
	//1
	public function empex_feedback_notifications()
	{
		$data['title'] = 'EMPEX- FEEDBACK NOTIFICATIONS';

		$data['content'] = $this->load->view('empexmodules/empex_feedback_notifications', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//2
	public function empex_promoter_list()
	{
		$data['title'] = 'EMPEX- PROMOTER LIST';

		$data['content'] = $this->load->view('empexmodules/empex_promoter_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//3
	public function empex_detractors_list()
	{
		$data['title'] = 'EMPEX- DETRACTORS LIST';

		$data['content'] = $this->load->view('empexmodules/empex_detractors_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//4
	public function empex_passive_list()
	{
		$data['title'] = 'EMPEX- PASSIVES LIST ';

		$data['content'] = $this->load->view('empexmodules/empex_passive_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//5
	public function empex_satisfied_list()
	{
		$data['title'] = 'EMPEX- SATISFIED EMPLOYEES';

		$data['content'] = $this->load->view('empexmodules/empex_satisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	//6
	public function empex_unsatisfied_list()
	{
		$data['title'] = 'EMPEX- UNSATISFIED EMPLOYEES';

		$data['content'] = $this->load->view('empexmodules/empex_unsatisfied_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//END EMPEX
}
/* 
//unused code
	public function feedbackmissed()
	{
		$data['title'] = 'Feedback Alert';

		$data['content'] = $this->load->view('reports/feedbackmissed', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function alert()
	{
		$data['title'] = 'Handover Alert';

		$data['content'] = $this->load->view('reports/alert', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function pnegativereport()
	{
		$data['title'] = ' Partially Satisfied Patients';

		$data['content'] = $this->load->view('pnegativereport', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function pnegativereporto()
	{
		$data['title'] = ' Partially Satisfied Patients';

		$data['content'] = $this->load->view('pnegativereporto', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
*/