<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
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
			'ticketsadf_model', //1
			'ticketsesr_model', // 5 
			'ticketsgrievance_model',  //  6
			'ticketsincidents_model', 

		));
		if ($this->session->userdata('isLogIn') == false) {
			redirect('login');
		}
	}

	//INPATIENT DISCHARGE FEEDBACK
	public function ip_patient_feedback()
	{
		$data['title'] = 'IP- FEEDBACK DETAILS';
		$data['content'] = $this->load->view('ipmodules/patient_feedback', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function ip_feedbacks_report()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		$data['title'] = 'IP- FEEDBACK REPORT';
		#------------------------------#
		$data['content']  = $this->load->view('ipmodules/feedbacks_report', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function ip_capa_report()
	{
		$data['title'] = 'IP- CAPA REPORT';
		$data['departments'] = $this->tickets_model->read_close();

		$data['content'] = $this->load->view('ipmodules/capa_report', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function ip_recent_comments()
	{
		$data['title'] = 'IP- FEEDBACK COMMENTS';
		$data['content'] = $this->load->view('ipmodules/recent_comments', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function ip_staffreport()
	{
		$data['title'] = 'IP- STAFF RECOMMENDATION REPORT';
		$data['content'] = $this->load->view('ipmodules/staff_appreciation', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//INPATIENT DISCHARGE FEEDBACK END


	//OUTPATIENT FEEDBACK 
	public function op_patient_feedback()
	{
		$data['title'] = 'OP- FEEDBACK DETAILS';
		$data['content'] = $this->load->view('opmodules/op_patient_feedback', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function op_allfeedbacks_list()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		$data['title'] = 'OP- FEEDBACK REPORT';
		#------------------------------#
		$data['content']  = $this->load->view('opmodules/op_allfeedbacks_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function op_capa_list()
	{
		$data['title'] = 'OP- CAPA REPORT';
		$data['departments'] = $this->ticketsop_model->read_close();

		$data['content'] = $this->load->view('opmodules/op_capa_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function op_recent_comments()
	{
		$data['title'] = 'OP- FEEDBACK COMMENTS';
		$data['content'] = $this->load->view('opmodules/op_recent_comments', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//OUTPATIENT FEEDBACK  END


	//PATIENT COMPLAINTS 
	public function patient_complaint_details()
	{
		$data['title'] = 'PC- COMPLAINT DETAILS';
		$data['content'] = $this->load->view('complaintsmodules/patient_complaint_details', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function patient_complaint_action()
	{
		$data['title'] = 'PC- COMPLAINTS ACTION REPORT';
		$data['departments'] = $this->ticketsint_model->read_close();

		$data['content'] = $this->load->view('complaintsmodules/patient_complaint_action', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function patient_recent_complaints()
	{
		$data['title'] = 'PC- RECENT COMPLAINTS';
		$data['content'] = $this->load->view('complaintsmodules/patient_recent_complaints', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//PATIENT COMPLAINTS END


	//PATIENT SERVICE REQUEST START
	public function psr_request_details()
	{
		$data['title'] = 'PSR- REQUEST DETAILS';
		$data['content'] = $this->load->view('psrmodules/psr_request_details', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function psr_resolution_report()
	{
		$data['title'] = 'PSR- RESOLUTION REPORT';
		$data['content'] = $this->load->view('psrmodules/psr_resolution_report', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function psr_recent_requests()
	{
		$data['title'] = 'PSR- RECENT REQUESTS';
		$data['content'] = $this->load->view('psrmodules/psr_recent_requests', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//PATIENT SERVICE REQUEST END


	//EMPLOYEE SERVICE REQUEST START 
	public function esr_request_details()
	{
		$data['title'] = 'ESR- REQUEST DETAILS';
		$data['content'] = $this->load->view('esrmodules/esr_request_details', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function esr_resolution_report()
	{
		$data['title'] = 'ESR- RESOLUTION REPORT';
		$data['content'] = $this->load->view('esrmodules/esr_resolution_report', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function esr_recent_requests()
	{
		$data['title'] = 'ESR- RECENT REQUESTS';
		$data['content'] = $this->load->view('esrmodules/esr_recent_requests', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//EMPLOYEE SERVICE REQUEST END


	//EMPLOYEE EXPERIENCE START
	public function empex_employee_feedback()
	{
		$data['title'] = 'EMPEX- FEEDBACK DETAILS';
		$data['content'] = $this->load->view('empexmodules/empex_employee_feedback', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function empex_capa_list()
	{
		$data['title'] = 'EMPEX- CAPA REPORT';
		$data['content'] = $this->load->view('empexmodules/empex_capa_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function empex_recent_comments()
	{
		$data['title'] = 'EMPEX- FEEDBACK COMMENTS';
		$data['content'] = $this->load->view('empexmodules/empex_recent_comments', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	//EMPLOYEE EXPERIENCE END
}

	//UNUSED CODE
	/*
	public function assign_by_all()
	{
		$data['title'] = display('appointment_assign_by_all');
		#-------------------------------#
		$data['date'] = (object)$getData = array(
			'start_date' => date('Y-m-d', strtotime(($this->input->post('start_date', true) != null) ? $this->input->post('start_date', true) : date('Y-m-d'))),
			'end_date' => date('Y-m-d', strtotime(($this->input->post('end_date', true) != null) ? $this->input->post('end_date', true) : date('Y-m-d'))),
		);
		#-------------------------------#
		$data['appointments'] = $this->report_model->assign_by_all($getData);
		$data['content'] = $this->load->view('report_assign_by_all', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function assign_by_all_doctor()
	{
		$data['title'] = display('appointment_assign_by_doctor');
		#-------------------------------#
		$data['user'] = (object)$getData = [
			'start_date' => $this->input->get('start_date', true),
			'end_date'	 => $this->input->get('end_date', true),
			'user_id'	 => $this->input->get('user_id', true)
		];
		#-------------------------------#
		$data['user_list'] = $this->doctor_model->doctor_list();
		$data['appointments'] = $this->report_model->assign_by_user($getData);
		$data['content'] = $this->load->view('report_assign_by_all_doctor', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function assign_by_all_representative()
	{
		$data['title'] = display('appointment_assign_by_representative');
		#-------------------------------#
		$data['user'] = (object)$getData = [
			'start_date' => $this->input->get('start_date', true),
			'end_date'	 => $this->input->get('end_date', true),
			'user_id'	 => $this->input->get('user_id', true)
		];
		#-------------------------------#
		$data['user_list'] = $this->representative_model->representative_list();
		$data['appointments'] = $this->report_model->assign_by_user($getData);
		$data['content'] = $this->load->view('report_assign_by_all_representative', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function assign_to_all_doctor()
	{
		$data['title'] = display('appointment_assign_to_all_doctor');
		#-------------------------------#
		$data['user'] = (object)$getData = [
			'start_date' => $this->input->get('start_date', true),
			'end_date'	 => $this->input->get('end_date', true),
			'user_id'	 => $this->input->get('user_id', true)
		];
		#-------------------------------#
		$data['user_list'] = $this->doctor_model->doctor_list();
		$data['appointments'] = $this->report_model->assign_to_user($getData);
		$data['content'] = $this->load->view('report_assign_to_all_doctor', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}




	public function smsfeedbackreport()
	{
		$data['title'] = 'Feedback Report';


		$data['content'] = $this->load->view('smsfeedback', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}





	public function staffreportop()
	{
		$data['title'] = 'Staff Recommendation Report';


		$data['content'] = $this->load->view('staffreportop', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

*/
