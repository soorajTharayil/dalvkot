<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class nursing_model extends BF_Model {
	public function find_all_event() {
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;
	}
	public function all_nursing_data() {  
		$this->db->select('*');  
		$this->db->from('nursing_data');
		//$this->db->where('location',$this->uri->segment(2));
		//$this->db->join('analytics', 'analytics.cguid = nursing_datas.guid');
		//$this->db->join('prices', 'prices.cguid = nursing_datas.guid');
		//$this->db->join('add_consumer_details', 'add_consumer_details.cguid = nursing_datas.guid');
		//$this->db->group_by('prices.cguid');
		
$query = $this->db->get();

        $result = $query->result();
        return $result;
    }
	
	public function get_nursing_datas($table,$guid) {
		$this->db->where('guid',$guid);
        $query = $this->db->get($table); 
        $result = $query->result();
        return $result[0];
    }
		
	
	public function nursing_daily_assessment(){
		if($this->input->post('name')){
			$data = array();
			// print_r($_POST); exit;
			$guid = guid();
			$data = array(
				'guid' => $guid,
				'name' => $this->input->post('name'),
				'contact_no' => $this->input->post('contact_no') ,
				'alternate_no' => $this->input->post('alternate_no') ,
				'email' => $this->input->post('email') ,
				'current_add' => $this->input->post('current_add') ,           
				'permanent_add' => $this->input->post('permanent_add'),
				'password' => $this->input->post('password') ,
				'files' => $this->input->post('files') ,
				
					 
			);
			$this->db->insert('nursing_daily_assessment', $data);
			$this->upload_image($guid);
			return true;
		}
	}
	public function nursing_data(){
		if($this->input->post('val_dentures')){
			$data = array();
			// print_r($_POST); exit;
			$guid = guid();  
			$data = array(
				'guid' => $guid,
				'val_dentures' => $this->input->post('val_dentures'),
				'hearing_aid' => $this->input->post('hearing_aid') ,
				'eye_glasses' => $this->input->post('eye_glasses') ,
				'dresses' => $this->input->post('dresses') ,
				'other_valuable' => $this->input->post('other_valuable') ,           
				'orientation_done_for' => $this->input->post('orientation_done_for') ,           
				'neurological_assessment' => $this->input->post('neurological_assessment'),
				'alert' => $this->input->post('alert') ,
				'vision' => $this->input->post('vision') ,
				'hearing' => $this->input->post('hearing') ,
				'speech' => $this->input->post('speech') ,
				'spasm' => $this->input->post('spasm') ,
				'repiratory' => $this->input->post('repiratory') ,
				'chest_pain' => $this->input->post('chest_pain') ,
				'pulse_rate' => $this->input->post('pulse_rate') ,
				'rhythm' => $this->input->post('rhythm') ,
				'urinary' => $this->input->post('urinary') ,
				'gastro_intestinal_treat' => $this->input->post('gastro_intestinal_treat') ,
				'gynae' => $this->input->post('gynae') ,
					 
			);
			$this->db->insert('nursing_data', $data);
			//$this->upload_image($guid);
			return true;
		}
	}	public function nursing_data1(){    
		if($this->input->post('walking')){
			$data = array();
			// print_r($_POST); exit;
			$guid = guid();
			$data = array(
				'guid' => $guid,
				'walking' => $this->input->post('walking'),
				'eating' => $this->input->post('eating') ,
				'bathing' => $this->input->post('bathing') ,
				'dressing' => $this->input->post('dressing') ,   
				'toilet_needs' => $this->input->post('toilet_needs') ,           
				'br_ulcer_location' => $this->input->post('br_ulcer_location'),
				'br_ulcer_stage' => $this->input->post('br_ulcer_stage') ,
				'br_ulcer_pus' => $this->input->post('br_ulcer_pus') ,
				'skin_wound' => $this->input->post('skin_wound') ,
					 
			);
			$this->db->insert('nursing_data1', $data);
			//$this->upload_image($guid);
			return true;
		}
	}
	
		  public function update($guid){
	
			
			if($this->input->post('name')){
		
				$data = array();
				$data = array(								
				'name' => $this->input->post('name'),
				'contact_no' => $this->input->post('contact_no') ,
				'alternate_no' => $this->input->post('alternate_no') ,
				'email' => $this->input->post('email') ,
				'current_add' => $this->input->post('current_add') ,           
				'permanent_add' => $this->input->post('permanent_add'),
				'password' => $this->input->post('password') ,
				'files' => $this->input->post('files') ,
					);
			$this->db->where('guid',$guid);
			$this->db->update('nursing_data', $data);
		
			$this->upload_image($guid,'files');
			
		
		return true;
		
	 }
	 
	
	 
	}




	
	public function update1($guid){  
		if($this->input->post('name')){
			$data = array();
		//echo $guid; 
			//exit;  
			$data = array(
				//'guid' => $guid,
				'name' => $this->input->post('name'),
				'contact_no' => $this->input->post('contact_no') ,
				'alternate_no' => $this->input->post('alternate_no') ,
				'email' => $this->input->post('email') ,
				'current_add' => $this->input->post('current_add') ,           
				'permanent_add' => $this->input->post('permanent_add'),
				'password' => $this->input->post('password') ,
				'files' => $this->input->post('files') ,
					 
			);
			$this->db->where('guid',$guid);
			$this->db->update('nursing_data', $data);
			$this->upload_image($guid);
			return true;  
		}
	}
	
	
	  
	public function upload_image($guid){
		$config['upload_path'] = './files/nursing_datas/';  
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
		$config['maintain_ratio'] = TRUE;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('files')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());
			$datas = array();
			$datas = array(
				'files' => $data['upload_data']['file_name'],
			);
			$this->db->where('guid',$guid);   
			$this->db->update('nursing_data', $datas);
		}  
		return true;
	}
	
	
	  
	public function update_img(){
					$config['upload_path'] = './files/nurses/';  
					$config['allowed_types'] = 'pdf|jpg|png|jpeg';
					$config['maintain_ratio'] = TRUE;
					$this->load->library('upload', $config);
					
					if (!$this->upload->do_upload('profile_img')) {
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
					} else {
						$data = array('upload_data' => $this->upload->data());
						$datas = array();
						$datas = array(
							'files' => $data['upload_data']['file_name'],
						);
						$this->db->where('id',$this->session->userdata['user_id']);   
						$this->db->update('users', $datas);
					}  
		return true;
	}
	
	
}
?>