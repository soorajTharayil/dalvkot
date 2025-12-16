<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patients_model extends BF_Model {
	public function find_all_event() {
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;  
	}
	public function all_patients($type,$dis) {  
		$this->db->select('*');
		
		if($dis == '1'){
			$this->db->where('discharged_date !=','0');
		}else{
			$this->db->where('discharged_date','0');
		}
		$this->db->from('patients');
		$query = $this->db->get();
		$result = $query->result();
        return $result;
    }  
	
	public function get_patients($table,$guid) {
		$this->db->where('guid',$guid);
        $query = $this->db->get($table); 
        $result = $query->result();
        return $result[0];
    }
		
	
	public function create(){
		if($this->input->post('name')){
			$data = array();
			$guid = guid();
			$data = array(
				'guid' => $guid,
				'name' => strtoupper($this->input->post('name')),
				'patient_id' => strtoupper($this->input->post('patient_id')),
				'location' => strtoupper($this->input->post('location')) ,           
				'admitedfor' => strtoupper($this->input->post('admitedfor')) ,           
				'gender' => $this->input->post('gender'),
				'age' => $this->input->post('age') ,
				'ward' => $this->input->post('ward') ,
				'bed_no' => strtoupper($this->input->post('bed_no')) ,
				'admited_date' => $this->input->post('admited_date') ,
				'discharged_date' => '0' ,
				
					 
			);  
			$this->db->insert('patients', $data);
			//$this->create_doctor_analytics($guid);
			//$this->create_prices($guid);
			//$this->create_add_consumer_details($guid);
			$this->upload_image($guid);
			return true;
		}
	}

	public function update1($guid){
		if($this->input->post('rollback')){
			$data = array(
				  
			
				'discharged_date' => 0,
				
			);
			$this->db->where('guid',$guid);
			$this->db->update('patients', $data);
		}else if($this->input->post('name')){
			$data = array();
			
			$data = array(
				  
				'name' => strtoupper($this->input->post('name')),
				'patient_id' => strtoupper($this->input->post('patient_id')),
				'location' => strtoupper($this->input->post('location')) ,           
				       
				'gender' => $this->input->post('gender'),
				'age' => $this->input->post('age') ,
				'admitedfor' => strtoupper($this->input->post('admitedfor')) ,
				'ward' => $this->input->post('ward') ,
				'bed_no' => strtoupper($this->input->post('bed_no')) ,
				'admited_date' => $this->input->post('admited_date') ,
				'discharged_date' => $this->input->post('discharged_date') ,
				
			);
			$this->db->where('guid',$guid);
			$this->db->update('patients', $data);
			/*$this->create_doctor_analytics($guid);
			$this->create_prices($guid);
			$this->update_add_consumer_details($guid);*/
			$this->upload_image($guid);
			return true;
		}
	}
	
	public function upload_image($guid){
		$config['upload_path'] = './files/patients/';
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
		$config['maintain_ratio'] = TRUE;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('photo')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());
			$datas = array();
			$datas = array(
				'photo' => $data['upload_data']['file_name'],
			);
			$this->db->where('id',$guid);
			$this->db->update('patients', $datas);
		}
		return true;
	}
	
	
}
?>