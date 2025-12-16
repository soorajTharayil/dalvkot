<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questionip extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'questionip_model'
		));

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	}

	public function index()
	{

		$data['title'] = 'IP DISCHARGE FEEDBACK QUESTIONS';
		$data['patients'] = $this->questionip_model->read();
		$data['content'] = $this->load->view('ipmodules/question/ipquestionlist', $data, true);

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

	public function create()
	{

		$error = false;
		$data['title'] = 'Patient Admission Form';
		$id = $this->input->post('id');
		#-------------------------------#
		$this->form_validation->set_rules('name', display('first_name'), 'required|max_length[250]');


		#-------------------------------#
		if ($this->input->post('id') == null) { //create a patient
			// $this->db->where('patient_id', $this->input->post('patient_id'));
			// $query = $this->db->get('setup');
			// if ($query->result()) {
			// 	$this->session->set_flashdata('exception', 'Duplicate Patient ID');
			// 	//redirect('patient/create');
			// 	$error = true;
			// }

			// $this->db->where('mobile', $this->input->post('mobile'));	
			// $query = $this->db->get('setup');
			// if ($query->result()) {
			// 	$this->session->set_flashdata('exception', 'Duplicate Mobile Number');
			// 	//redirect('patient/create');
			// 	$error = true;
			// }

			// $this->db->where('patient_id', $this->input->post('patient_id'));
			// $this->db->where('mobile', $this->input->post('mobile'));
			// $query = $this->db->get('setup');
			// if ($query->result()) {
			// 	$this->session->set_flashdata('exception', 'Duplicate Patient ID and Mobile Number');
			// 	//redirect('patient/create');
			// 	$error = true;
			// }


			/*if($this->input->post('hospital_id')){
				$this->db->where('hospital_id',$this->input->post('hospital_id'));
				$query = $this->db->get('setup');
				if($query->result()){
					$this->session->set_flashdata('exception', 'Duplicate Hospital ID');
					
					$error = true;
				}

				'created_by'   		   => $this->session->userdata('user_id'),
				'updated_by'    => $this->session->userdata('user_id'),


			}*/

			$data['question'] = (object)$postData = [
				'id'   		   => $this->input->post('id'),
				'title'    => $this->input->post('title'),
				'question' 	   => $this->input->post('question'),
				'shortname	' 	   => $this->input->post('shortname'),
				'type' 	   => $this->input->post('type'),
				'questionk' 	   => $this->input->post('questionk'),
				'titlek' 	   => $this->input->post('titlek'),
				'questionm'   	   => $this->input->post('questionm'),
				'titlem'       => $this->input->post('titlem'),
			];
		} 
		// else { 
		// 	// update question case
		// 	$data['question'] = (object)$postData = [
		// 		'id'   		   => $this->input->post('id'),
		// 		'title'    => $this->input->post('title'),
		// 		'question' 	   => $this->input->post('question'),
		// 		'shortname	' 	   => $this->input->post('shortname'),
		// 		'type' 	   => $this->input->post('type'),
		// 		'questionk' 	   => $this->input->post('questionk'),
		// 		'titlek' 	   => $this->input->post('titlek'),
		// 		'questionm'   	   => $this->input->post('questionm'),
		// 		'titlem'       => $this->input->post('titlem'),
		// 	];
		// }
		#-------------------------------#
		if ($this->form_validation->run() === true && $error == false) {

			#if empty $id then insert data
			if (empty($postData['id'])) {

				if ($this->questionip_model->create($postData)) {
					$ipquestion_id = $this->db->insert_id();
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}

				redirect('Questionip/');
			} else {
				if ($error == false) {
					if ($this->questionip_model->update($postData)) {
						#set success message
						$this->session->set_flashdata('message', display('update_successfully'));
					} else {
						#set exception message
						$this->session->set_flashdata('exception', display('please_try_again'));
					}
					redirect('Questionip/');
				}
			}
		} else {
			$data['content'] = $this->load->view('ipmodules/ipquestion_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function movetoinpatient()
	{
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$data = array('discharged_date' => 0);
		$query = $this->db->update('setup', $data);
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
					$query = $this->db->get('setup');
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

	public function profile($ipquestion_id = null)
	{
		$data['title'] =  display('patient_information');
		#-------------------------------#
		$data['profile'] = $this->questionip_model->read_by_id($ipquestion_id);
		$data['documents'] = $this->document_model->read_by_patient($ipquestion_id);
		$data['content'] = $this->load->view('patient_profile', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function edit($ipquestion_id = null)
	{
		$data['title'] = 'Edit Patient Form';
		#-------------------------------#
		$data['patient'] = $this->questionip_model->read_by_id($ipquestion_id);
		// if ($data['patient']->discharged_date != 0) {
		// 	$data['patient']->discharged_date =  date('Y-m-d H:i:s', strtotime($data['patient']->discharged_date));
		// }
		$data['content'] = $this->load->view('patient/edit_patient', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function patient_discharge($ipquestion_id = null)
	{
		// if ($ipquestion_id == true) {
		$data_d = date('Y-m-d H:i');
		// }
		$data['patient'] = (object)$postData = [
			'id'   		   => $ipquestion_id,
			'discharged_date' => $data_d,
			'datedischarged' => date('Y-m-d H:i', strtotime($data_d)),
			'updated_by'    => $this->session->userdata('user_id'),
		];

		if ($this->questionip_model->update($postData)) {
			#set success message
			$this->session->set_flashdata('message', display('update_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('patient/');
	}





	public function delete($ipquestion_id = null)
	{
		if ($this->questionip_model->delete($ipquestion_id)) {
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
		if ($mode == 1) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 2) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		elseif ($mode == 3) :
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 4) :
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


	public function document()
	{
		$data['title'] = display('document_list');
		$data['documents'] = $this->document_model->read();
		$data['content'] = $this->load->view('document', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}



	public function document_form()
	{
		$data['title'] = display('add_document');
		/*----------VALIDATION RULES----------*/
		$this->form_validation->set_rules('patient_id', display('patient_id'), 'required|max_length[30]');
		$this->form_validation->set_rules('doctor_name', display('doctor_id'), 'max_length[11]');
		$this->form_validation->set_rules('description', display('description'), 'trim');
		$this->form_validation->set_rules('hidden_attach_file', display('attach_file'), 'required|max_length[255]');
		/*-------------STORE DATA------------*/
		$urole = $this->session->userdata('user_role');
		$data['document'] = (object)$postData = array(
			'patient_id'  => $this->input->post('patient_id'),
			'doctor_id'   => $this->input->post('doctor_id'),
			'description' => $this->input->post('description'),
			'hidden_attach_file' => $this->input->post('hidden_attach_file'),
			'date'        => date('Y-m-d'),
			'upload_by'   => (($urole == 10) ? 0 : $this->session->userdata('user_id'))
		);

		/*-----------CREATE A NEW RECORD-----------*/
		if ($this->form_validation->run() === true) {

			if ($this->document_model->create($postData)) {
				#set success message
				$this->session->set_flashdata('message', display('save_successfully'));
			} else {
				#set exception message
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect('patient/document_form');
		} else {
			$data['doctor_list'] = $this->doctor_model->doctor_list();
			$data['content'] = $this->load->view('document_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}


	public function do_upload()
	{
		ini_set('memory_limit', '200M');
		ini_set('upload_max_filesize', '200M');
		ini_set('post_max_size', '200M');
		ini_set('max_input_time', 3600);
		ini_set('max_execution_time', 3600);

		if (($_SERVER['REQUEST_METHOD']) == "POST") {
			$filename = $_FILES['attach_file']['name'];
			$filename = strstr($filename, '.', true);
			$email    = $this->session->userdata('email');
			$filename = strstr($email, '@', true) . "_" . $filename;
			$filename = strtolower($filename);
			/*-----------------------------*/

			$config['upload_path']   = FCPATH . './assets/attachments/';
			// $config['allowed_types'] = 'csv|pdf|ai|xls|ppt|pptx|gz|gzip|tar|zip|rar|mp3|wav|bmp|gif|jpg|jpeg|jpe|png|txt|text|log|rtx|rtf|xsl|mpeg|mpg|mov|avi|doc|docx|dot|dotx|xlsx|xl|word|mp4|mpa|flv|webm|7zip|wma|svg';
			$config['allowed_types'] = '*';
			$config['max_size']      = 0;
			$config['max_width']     = 0;
			$config['max_height']    = 0;
			$config['file_ext_tolower'] = true;
			$config['file_name']     =  $filename;
			$config['overwrite']     = false;

			$this->load->library('upload', $config);

			$name = 'attach_file';
			if (!$this->upload->do_upload($name)) {
				$data['exception'] = $this->upload->display_errors();
				$data['status'] = false;
				echo json_encode($data);
			} else {
				$upload =  $this->upload->data();
				$data['message'] = display('upload_successfully');
				$data['filepath'] = './assets/attachments/' . $upload['file_name'];
				$data['status'] = true;
				echo json_encode($data);
			}
		}
	}


	public function document_delete($id = null)
	{
		if ($this->document_model->delete($id)) {

			$file = $this->input->get('file');
			if (file_exists($file)) {
				@unlink($file);
			}
			$this->session->set_flashdata('message', display('save_successfully'));
		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
