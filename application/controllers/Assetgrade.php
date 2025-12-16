<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assetgrade extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'assetgrade_model',
			'dashboard_model',
			'efeedor_model',
		));
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		if ($this->session->userdata['user_role'] > 2) {

			redirect('dashboard/noaccess');
		}
	}

	public function index()
	{
		$data['title'] = 'LIST OF ASSET GRADES';
		#-------------------------------#
		$data['departments'] = $this->assetgrade_model->read();
		$data['content'] = $this->load->view('asset_grade/asset_grade', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'ADD ASSET GRADES';
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name'), 'required|max_length[100]');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid', true),
			'title' 		  => $this->input->post('name', true),
			'bed_no' => $this->input->post('description', true),
			'bed_nom' => $this->input->post('description_m', true),


		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['guid'])) {
				if ($this->assetgrade_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('assetgrade');
			} else {
				if ($this->assetgrade_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('assetgrade/edit/' . $postData['guid']);
			}
		} else {
			$data['content'] = $this->load->view('asset_grade/asset_grade_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = 'EDIT ASSET GRADE';
		#-------------------------------#
		$data['department'] = $this->assetgrade_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('asset_grade/asset_grade_form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->assetgrade_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('assetgrade');
	}
}
