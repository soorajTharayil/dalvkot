<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Track extends CI_Controller
{
	//IF LINK HAS TO BE SENT TO PATIENT
	// Update the main wrapper with function name for any new functions.

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'tickets_model',
			'ticketsincidents_model',
			'ticketsadf_model',
			'ticketsop_model',
			'ticketsint_model',
			'ticketsesr_model',
			'ipd_model',
			'opf_model',
			'pc_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'admissionfeedback_model',
			'dashboard_model',
			'setting_model'
		));
		$dates = get_from_to_date();
	}

	// tracking link for the person who raised the issue
	public function pc()
	{
		$data['departments'] = $this->ticketsint_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('complaintsmodules/tracking_link_patient', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	public function inc()
	{
		$data['departments'] = $this->ticketsincidents_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('incidentmodules/tracking_link_employee', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function isr()
	{
		$data['departments'] = $this->ticketsesr_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('esrmodules/tracking_link_employee', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
	// end tracking link for the person who raised the issue


	// tracking link for admin and super admin where multiple tickets can be tracked -- feedback modules
	public function ipdf()
	{
		$data['departments'] = $this->tickets_model->list_tickets($this->uri->segment(3));
		if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
			$data['content'] = $this->load->view('ipmodules/tickets_list', $data, true);
		}else {
			$data['content'] = $this->load->view('ipmodules/dephead/tickets_list', $data, true);

		}
		$this->load->view('layout/main_wrapper', $data);
	}

	public function opf()
	{
		$data['departments'] = $this->ticketsop_model->list_tickets($this->uri->segment(3));
		if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
			$data['content'] = $this->load->view('opmodules/tickets_list', $data, true);
		}else {
			$data['content'] = $this->load->view('opmodules/dephead/tickets_list', $data, true);

		}
		$this->load->view('layout/main_wrapper', $data);
	}

	public function adf()
	{
		$data['departments'] = $this->ticketsadf_model->list_tickets($this->uri->segment(3));
		if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
			$data['content'] = $this->load->view('adfmodules/tickets_list', $data, true);
		}else {
			$data['content'] = $this->load->view('adfmodules/dephead/tickets_list', $data, true);

		}
		$this->load->view('layout/main_wrapper', $data);
	}
	// end tracking link for admin and super admin where multiple tickets can be tracked -- feedback modules

}
