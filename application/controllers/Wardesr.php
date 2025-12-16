<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wardesr extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'ticketsint_model',
			'tickets_model',
			'ticketsesr_model',
			'ticketsop_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'departmenthead_model',
			'setting_model',
			'wardesr_model',
		));
		$this->session->set_userdata([
			'active_menu' => array('esr_dashboard', 'esr_ticket', 'esr_reports', 'esr_patients', 'esr_settings'),
		]);
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		
	}

	public function index()
	{
		$data['title'] = 'MANAGE ISR FLOOR/WARDS';
		#-------------------------------#
		$data['departments'] = $this->wardesr_model->read();
		$data['content'] = $this->load->view('wardesr', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'ADDING ISR FLOOR/WARD';
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name'), 'required|max_length[100]');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid', true),
			'title' 		  => $this->input->post('name', true),
			'smallname' 		  => $this->input->post('smallname', true),
			'bed_no' => $this->input->post('description', true)

		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['guid'])) {
				if ($this->wardesr_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('wardesr');
			} else {
				if ($this->wardesr_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('wardesr');
			}
		} else {
			$data['content'] = $this->load->view('wardesr_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING ISR FLOOR/WARD';
		#-------------------------------#
		$data['department'] = $this->wardesr_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('wardesr_form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->wardesr_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('wardesr');
	}
}
