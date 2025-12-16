<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patient extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'patient_model'
		));

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	}

	public function index()
	{
		$data['title'] = 'ADMITTED PATIENT LIST';
		$data['patients'] = $this->patient_model->read();
		$data['content'] = $this->load->view('patient/patient', $data, true);

		$this->load->view('layout/main_wrapper', $data);
	}



	public function discharged()
	{
		$data['title'] = 'DISCHARGED PATIENT LIST';
		$data['patients'] = $this->patient_model->readdischarged();
		$data['content'] = $this->load->view('patient/patient_discharge_list', $data, true);
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
		$data['title'] = 'PATIENT ADMISSION ';
		$id = $this->input->post('id');
		#-------------------------------#
		$this->form_validation->set_rules('name', display('first_name'), 'required|max_length[250]');


		#-------------------------------#
		if ($this->input->post('id') == null) { //create a patient
			$this->db->where('patient_id', $this->input->post('patient_id'));
			$query = $this->db->get('patients_from_admission');
			if ($query->result()) {
				$this->session->set_flashdata('exception', 'Duplicate Patient ID');
				//redirect('patient/create');
				$error = true;
			}

			$this->db->where('mobile', $this->input->post('mobile'));	
			$query = $this->db->get('patients_from_admission');
			if ($query->result()) {
				$this->session->set_flashdata('exception', 'Duplicate Mobile Number');
				//redirect('patient/create');
				$error = true;
			}

			$this->db->where('patient_id', $this->input->post('patient_id'));
			$this->db->where('mobile', $this->input->post('mobile'));
			$query = $this->db->get('patients_from_admission');
			if ($query->result()) {
				$this->session->set_flashdata('exception', 'Duplicate Patient ID and Mobile Number');
				//redirect('patient/create');
				$error = true;
			}


			/*if($this->input->post('hospital_id')){
				$this->db->where('hospital_id',$this->input->post('hospital_id'));
				$query = $this->db->get('bf_patients');
				if($query->result()){
					$this->session->set_flashdata('exception', 'Duplicate Hospital ID');
					
					$error = true;
				}

				'created_by'   		   => $this->session->userdata('user_id'),
				'updated_by'    => $this->session->userdata('user_id'),


			}*/
			if ($this->input->post('admited_date')) {
				$data_d = $this->input->post('admited_date');
			} else {
				$data_d = date('Y-m-d H:i');
			}

			$data['patient'] = (object)$postData = [
				'id'   		   => $this->input->post('id'),
				'name'    => $this->input->post('name'),
				'hospital_id' 	   => $this->input->post('hospital_id'),
				'email' 	   => $this->input->post('email'),
				'mobile' 	   => $this->input->post('mobile'),
				'patient_id' 	   => $this->input->post('patient_id'),
				'gender' 	   => $this->input->post('gender'),
				'age'   	   => $this->input->post('age'),
				'admitedfor'       => $this->input->post('admitedfor'),
				'ward'  => $this->input->post('ward'),
				'consultant' => $this->input->post('consultant'),
				'bed_no' 		   => $this->input->post('bed_no'),
				'admited_date' => date('Y-m-d H:i', strtotime($data_d)),
				'created_by'   		   => $this->session->userdata('user_id'),
				'discharged_date' => 0

			];
		} else { // update patient
			if ($this->input->post('discharged_date') == true) {
				$data_d = date('Y-m-d H:i', strtotime($this->input->post('discharged_date')));
			} else {
				$data_d = 0;
			}
			$data['patient'] = (object)$postData = [
				'id'   		   => $this->input->post('id'),
				'name'    => $this->input->post('name'),
				'hospital_id' 	   => $this->input->post('hospital_id'),
				'patient_id' 	   => $this->input->post('patient_id'),
				'email' 	   => $this->input->post('email'),
				'mobile' 	   => $this->input->post('mobile'),
				'gender' 	   => $this->input->post('gender'),
				'age'   	   => $this->input->post('age'),
				'admitedfor'       => $this->input->post('admitedfor'),
				'ward'  => $this->input->post('ward'),
				'consultant' => $this->input->post('consultant'),
				'bed_no' 		   => $this->input->post('bed_no'),
				'admited_date' => date('Y-m-d H:i', strtotime($this->input->post('admited_date'))),
				'discharged_date' => 0,
				'datedischarged' => 0,
				'updated_by'   		   => $this->session->userdata('user_id'),

			];
		}
		#-------------------------------#
		if ($this->form_validation->run() === true && $error == false) {

			#if empty $id then insert data
			if (empty($postData['id'])) {

				if ($this->patient_model->create($postData)) {
					$patient_id = $this->db->insert_id();
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				redirect('patient');
			} else {
				if ($error == false) {
					if ($this->patient_model->update($postData)) {
						#set success message
						$this->session->set_flashdata('message', display('update_successfully'));
					} else {
						#set exception message
						$this->session->set_flashdata('exception', display('please_try_again'));
					}

				

					redirect('patient/');
				}
			}
		} else {
			$data['content'] = $this->load->view('patient/patient_form_create', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function movetoinpatient()
	{
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$data = array('discharged_date' => 0);
		$query = $this->db->update('patients_from_admission', $data);
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
					$query = $this->db->get('patients_from_admission');
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

	public function profile($patient_id = null)
	{
		$data['title'] =  display('patient_information');
		#-------------------------------#
		$data['profile'] = $this->patient_model->read_by_id($patient_id);
		$data['documents'] = $this->document_model->read_by_patient($patient_id);
		$data['content'] = $this->load->view('patient_profile', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function summary($patient_id = null)
	{
		$data['title'] =  'Patient Addmission Summary';
		#-------------------------------#

		$data['content'] = $this->load->view('patient/welcome', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function edit($patient_id = null)
	{
		$data['title'] = 'Edit Patient Form';
		#-------------------------------#
		$data['patient'] = $this->patient_model->read_by_id($patient_id);
		// if ($data['patient']->discharged_date != 0) {
		// 	$data['patient']->discharged_date =  date('Y-m-d H:i:s', strtotime($data['patient']->discharged_date));
		// }
		$data['content'] = $this->load->view('patient/edit_patient', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	// public function patient_discharge($patient_id = null)
	// {
	// 	// if ($patient_id == true) {
	// 	$data_d = date('Y-m-d H:i');
	// 	// }
	// 	$data['patient'] = (object)$postData = [
	// 		'id'   		   => $patient_id,
	// 		'discharged_date' => $data_d,
	// 		'datedischarged' => date('Y-m-d H:i', strtotime($data_d)),
	// 		'updated_by'    => $this->session->userdata('user_id'),
	// 	];

	// 	if ($this->patient_model->update($postData)) {
	// 		#set success message
	// 		$this->session->set_flashdata('message', display('update_successfully'));
	// 	} else {
	// 		#set exception message
	// 		$this->session->set_flashdata('exception', display('please_try_again'));
	// 	}
	// 	redirect('patient/');
	// }




	public function patient_discharge($patient_id = null)
	{
		// if ($patient_id == true) {
	// 	$data_d = date('Y-m-d H:i');
	// 	// }

		if ($this->patient_model->set_discharge($patient_id)) {
			#set success message
			$this->session->set_flashdata('message', display('Patient Discharged'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Cannot remove the patient');
		}
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
		curl_exec($curl);
		redirect('patient');
	}


	
	public function patient_damar($patient_id = null)
	{
		// if ($patient_id == true) {
	// 	$data_d = date('Y-m-d H:i');
	// 	// }

		if ($this->patient_model->dama($patient_id)) {
			#set success message
			$this->session->set_flashdata('message', display('Discharge patient without sending message.'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Cannot remove the patient');
		}
		
		// $curl = curl_init();
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
		// curl_exec($curl);
		redirect('patient');
	}


	public function delete($patient_id = null)
	{
		if ($this->patient_model->delete($patient_id)) {
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
