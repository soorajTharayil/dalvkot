<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(
			array(
				'questions_model'
			)
		);

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	}




	public function index()
	{
		$data['title'] = 'IP QUESTIONS';
		$data['patients'] = $this->questions_model->readipquestions();
		$data['content'] = $this->load->view('ipmodules/ipquestions', $data, true);

		$this->load->view('layout/main_wrapper', $data);
	}

	public function interim()
	{
		$data['title'] = 'Interim Patients List';
		$data['patients'] = $this->questions_model->read_interim();
		$data['content'] = $this->load->view('patient/interim', $data, true);

		$this->load->view('layout/main_wrapper', $data);
	}

	public function op()
	{
		$data['title'] = 'Discharged Patients';
		$data['patients'] = $this->questions_model->readdischarged();
		$data['content'] = $this->load->view('patient/patient_dis', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function email_check($email, $id)
	{
		$emailExists = $this->db->select('email')
			->where('email', $email)
			->where_not_in('id', $id)
			->get('patient')
			->num_rows();

		if ($emailExists > 0) {
			$this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
			return false;
		} else {
			return true;
		}
	}
	public function add()
	{
		$this->load->library('form_validation');
	
		$id = $this->input->post('id');

		// Prepare postData
		$postData = [
			'id' => $id,
			'title' => $this->input->post('title'),
			'question' => $this->input->post('question'),
			'shortname	' 	   => $this->input->post('shortname'),
			'type' => $this->input->post('type'),
			'questionk' => $this->input->post('questionk'),
			'titlek' => $this->input->post('titlek'),
			'questionm' => $this->input->post('questionm'),
			'titlem' => $this->input->post('titlem'),
			
			// Add other fields as necessary
		];
		
		if (empty($id)) {
			if ($this->questions_model->create($postData)) {
				$this->session->set_flashdata('message', 'Save successfully');
			} else {
				$this->session->set_flashdata('exception', 'Please try again');
			}
			redirect('question/add');
		} else {
			// Update existing question
			if ($this->questions_model->update($postData)) {
				$this->session->set_flashdata('message', 'Update successfully');
			} else {
				$this->session->set_flashdata('exception', 'Please try again');
			}
			redirect('question');
		}
	}

	// public function add()
	// {
	// 	$error = false;
	// 	$data['title'] = 'Add IP Question';
	// 	$id = $this->input->post('id');
	// 	#-------------------------------#
	// 	// $this->form_validation->set_rules('name', display('first_name'),'required|max_length[250]');


	// 	#-------------------------------#
	// 	if ($this->input->post('id') == null) { //create a patient
	// 		$this->db->where('id', $this->input->post('id'));
	// 		$query = $this->db->get('setup');
	// 		if ($query->result()) {
	// 			// $this->session->set_flashdata('exception', 'Duplicate Patient ID');
	// 			//redirect('patient/create');
	// 			$error = true;
	// 		}
	// 		/*if($this->input->post('hospital_id')){
	// 			$this->db->where('hospital_id',$this->input->post('hospital_id'));
	// 			$query = $this->db->get('bf_patients');
	// 			if($query->result()){
	// 				$this->session->set_flashdata('exception', 'Duplicate Hospital ID');

	// 				$error = true;
	// 			}
	// 		}*/
	// 		if ($this->input->post('slug')) {
	// 			$slug = $this->input->post('slug');
	// 		} else {
	// 			$slug = null;
	// 		}
	// 		$data['question'] = (object)$postData = [
	// 			'id'   		   => $this->input->post('id'),
	// 			'title'    => $this->input->post('title'),
	// 			'question' 	   => $this->input->post('question'),
	// 			'shortname	' 	   => $this->input->post('shortname'),
	// 			'type' 	   => $this->input->post('type'),
	// 			'questionk' 	   => $this->input->post('questionk'),
	// 			'titlek' 	   => $this->input->post('titlek'),
	// 			'questionm'   	   => $this->input->post('questionm'),
	// 			'titlem'       => $this->input->post('titlem'),
	// 			'slug'       => $slug,
	// 		];
	// 	} else { // update patient
	// 		if (($this->input->post('id')) == true) {


	// 			$data['question'] = (object)$postData = [
	// 				'id'   		   => $this->input->post('id'),
	// 				'title'    => $this->input->post('title'),
	// 				'question' 	   => $this->input->post('question'),
	// 				'shortname	' 	   => $this->input->post('shortname'),
	// 				'type' 	   => $this->input->post('type'),
	// 				'questionk' 	   => $this->input->post('questionk'),
	// 				'titlek' 	   => $this->input->post('titlek'),
	// 				'questionm'   	   => $this->input->post('questionm'),
	// 				'titlem'       => $this->input->post('titlem'),

	// 			];
	// 		}
	// 		#-------------------------------#
	// 		if ($this->form_validation->run() === true && $error == false) {

	// 			#if empty $id then insert data
	// 			if (empty($postData['id'])) {

	// 				if ($this->questions_model->create($postData)) {
	// 					$patient_id = $this->db->insert_id();
	// 					#set success message
	// 					$this->session->set_flashdata('message', display('save_successfully'));
	// 				} else {
	// 					#set exception message
	// 					$this->session->set_flashdata('exception', display('please_try_again'));
	// 				}

	// 				redirect('questions/add');
	// 			} else {
	// 				if ($error == false) {
	// 					if ($this->questions_model->update($postData)) {
	// 						#set success message
	// 						$this->session->set_flashdata('message', display('update_successfully'));
	// 					} else {
	// 						#set exception message
	// 						$this->session->set_flashdata('exception', display('please_try_again'));
	// 					}
	// 					redirect('questions');
	// 				}
	// 			}
	// 		} else {
	// 			$data['content'] = $this->load->view('questions/ip', $data, true);
	// 			$this->load->view('layout/main_wrapper', $data);
	// 		}
	// 	}
	// }


	public function movetoinpatient()
	{
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$data = array('discharged_date' => 0);
		$query = $this->db->update('bf_patients', $data);
		$result = $query->result();
	}

	public function get_bed_no()
	{
		$ip = $this->input->get('id');
		$bip = $this->input->get('bid');
		$this->db->where('title', $ip);
		$query = $this->db->get('bf_ward');
		$result = $query->result();
		$beds = explode(',', $result[0]->bed_no);
		$html = '<option value="" selected>Select Bed NO</option>';
		//	print_r($beds);
		foreach ($beds as $b) {


			if ($b != '') {
				if ($b == $bip) {

					$html .= '<option value="' . $b . '" selected>' . $b . '</option>';
				} else {
					$this->db->where('ward', $ip);
					$this->db->where('bed_no', $b);
					$this->db->where('discharged_date', 0);
					$query = $this->db->get('bf_patients');
					$result = $query->result();
					if (count($result) == 0) {
						$html .= '<option value="' . $b . '">' . $b . '</option>';
					} else {
						$html .= '<option value="' . $b . '"  style="color:red">' . $b . '</option>';
					}
				}
			}
		}
		echo $html;
		exit;
	}



	public function edit($patient_id = null)
	{
		$data['title'] = 'Edit Question';
		#-------------------------------#
		$data['question'] = $this->questions_model->read_by_id($patient_id);

		$data['content'] = $this->load->view('ipmodules/questionform', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($patient_id = null)
	{
		if ($this->questions_model->delete($patient_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
			redirect('patient?del=2');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Cannot remove the patient since Handovers were done for the patient ');
		}
		redirect('patient?del=1');
	}



	/*
	   |----------------------------------------------
	   |        id genaretor
	   |----------------------------------------------
	   */
	public function randStrGen($mode = null, $len = null)
	{
		$result = "";
		if ($mode == 1):
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 2):
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		elseif ($mode == 3):
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 4):
			$chars = "0123456789";
		endif;

		$charArray = str_split($chars);
		for ($i = 0; $i < $len; $i++) {
			$randItem = array_rand($charArray);
			$result .= "" . $charArray[$randItem];
		}
		return $result;
	}
	/*
	   |----------------------------------------------
	   |         Ends of id genaretor
	   |----------------------------------------------
	   */


}
