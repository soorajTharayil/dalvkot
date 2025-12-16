<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doctors_model extends BF_Model {
	public function find_all_event() {
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;
	}
	public function all_doctors() {  
		$this->db->select('*');
		$this->db->from('doctors');
		//$this->db->where('location',$this->uri->segment(2));
		//$this->db->join('analytics', 'analytics.cguid = doctors.guid');
		//$this->db->join('prices', 'prices.cguid = doctors.guid');
		//$this->db->join('add_consumer_details', 'add_consumer_details.cguid = doctors.guid');
		//$this->db->group_by('prices.cguid');
		
$query = $this->db->get();

        $result = $query->result();
        return $result;
    }
	
	public function get_doctors($table,$guid) {
		$this->db->where('guid',$guid);
        $query = $this->db->get($table); 
        $result = $query->result();
        return $result[0];
    }
		
	
	public function update(){
		if($this->input->post('name')){
			$data = array();
			$guid = guid();
			$data = array(
				'guid' => $guid,
				'name' => $this->input->post('name'),
				'mobile' => $this->input->post('mobile') ,
				'email' => $this->input->post('email') ,
				'specialization' => $this->input->post('specialization') ,           
				'location' => $this->input->post('location'),
				'associated_hospitals' => $this->input->post('associated_hospitals') ,
				'other_information' => $this->input->post('other_information') ,
				'hospital_pic' => $this->input->post('hospital_pic') ,
				
					 
			);
			$this->db->insert('doctors', $data);
			//$this->create_doctor_analytics($guid);
			//$this->create_prices($guid);
			//$this->create_add_consumer_details($guid);
			$this->upload_image($guid);
			return true;
		}
	}
	/*public function create_doctor_analytics($guid){
		$this->db->where('cguid',$guid);
		$this->db->delete('analytics');
		$analytics = $this->input->post('analytic');
		foreach($analytics as $row){
			$data = array();
			$data = array(
				'guid' => guid(),
				'cguid' => $guid,
				'analytic' => $row,
			 );
			$this->db->insert('analytics', $data);
		}
		return true;
	}
	public function create_prices($guid){
		$this->db->where('cguid',$guid);
		$this->db->delete('prices');
		$prices = $this->input->post('price');
		foreach($prices as $row){
			$data = array();
			$data = array(
				'guid' => guid(),
				'price' => $row,
				'cguid' => $guid,
			 );
			$this->db->insert('prices', $data);
		}
		return true;
	}
	
	public function create_add_consumer_details($guid){
	
		
		$data = array();
        $data = array(
            'guid' => guid(),
			'cguid' => $guid,
            'location' => $this->input->post('location'),
            'gender' => $this->input->post('gender') ,
            'education_level' => $this->input->post('education_level') ,
            'relationship_status' => $this->input->post('relationship_status') ,           
            'language' => $this->input->post('language') ,           
            'buying_motivation' => $this->input->post('buying_motivation'),             
            'age' => $this->input->post('age') ,           
            'interesets' => $this->input->post('interesets') ,           
            'job_title' => $this->input->post('job_title') ,           
            'interested_in' => $this->input->post('interested_in')  ,          
            'income_level' => $this->input->post('income_level')  ,          
            'buying_concern' => $this->input->post('buying_concern') ,           
                    
        );
        $this->db->insert('add_consumer_details', $data);
		return true;
	
	}*/
	  
	public function update1($guid){
		if($this->input->post('name')){
			$data = array();
			
			$data = array(
				'guid' => $guid,
				'name' => $this->input->post('name'),
				'mobile' => $this->input->post('mobile') ,
				'email' => $this->input->post('email') ,
				'specialization' => $this->input->post('specialization') ,           
				'location' => $this->input->post('location'),
				'associated_hospitals' => $this->input->post('associated_hospitals') ,
				'other_information' => $this->input->post('other_information') ,
				'hospital_pic' => $this->input->post('hospital_pic') ,
					 
			);
			$this->db->where('guid',$guid);
			$this->db->update('doctors', $data);
			/*$this->create_doctor_analytics($guid);
			$this->create_prices($guid);
			$this->update_add_consumer_details($guid);*/
			$this->upload_image($guid);
			return true;
		}
	}
	
	/*public function update_add_consumer_details($guid){
	
		
		$data = array();
        $data = array(
           
            'location' => $this->input->post('location'),
            'gender' => $this->input->post('gender') ,
            'education_level' => $this->input->post('education_level') ,
            'relationship_status' => $this->input->post('relationship_status') ,           
            'language' => $this->input->post('language') ,           
            'buying_motivation' => $this->input->post('buying_motivation'),            
            'age' => $this->input->post('age') ,           
            'interesets' => $this->input->post('interesets') ,           
            'job_title' => $this->input->post('job_title') ,           
            'interested_in' => $this->input->post('interested_in')  ,          
            'income_level' => $this->input->post('income_level')  ,          
            'buying_concern' => $this->input->post('buying_concern') ,           
                    
        );
		$this->db->where('cguid',$guid);
        $this->db->update('add_consumer_details', $data);
		return true;
	
	}*/
	
	
	public function upload_image($guid){
		$config['upload_path'] = './files/doctor/';
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
		$config['maintain_ratio'] = TRUE;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('hospital_pic')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());
			$datas = array();
			$datas = array(
				'hospital_pic' => $data['upload_data']['file_name'],
			);
			$this->db->where('id',$guid);
			$this->db->insert('doctors', $datas);
		}  
		return true;
	}
	
	
}
?>