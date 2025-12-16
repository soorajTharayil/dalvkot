<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class nurses_model extends BF_Model {
	public function find_all_event() {
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;
	}
	public function all_nurses() {  
		$this->db->select('*');  
		$this->db->from('nurse');
		$this->db->order_by('status','desc');
		//$this->db->where('location',$this->uri->segment(2));
		//$this->db->join('analytics', 'analytics.cguid = nurses.guid');
		//$this->db->join('prices', 'prices.cguid = nurses.guid');
		//$this->db->join('add_consumer_details', 'add_consumer_details.cguid = nurses.guid');
		//$this->db->group_by('prices.cguid');
		
$query = $this->db->get();

        $result = $query->result();
        return $result;
    }
	
	public function get_nurses($table,$guid) {
		$this->db->where('guid',$guid);
        $query = $this->db->get($table); 
        $result = $query->result();
        return $result[0];
    }
		
	
	public function create(){
		if($this->input->post('name')){
			$data = array();
			// print_r($_POST); exit;
			$guid = $this->input->post('empid');
			$data = array(
				'guid' => $guid,
				'name' => $this->input->post('name'),
				'password' => $this->input->post('pass') ,
				'status' => 1 ,
				
					 
			);
			$this->db->insert('nurse', $data);
			$this->upload_image($guid);
			return true;
		}
	}
	
		  public function update($guid){
	
			
			if($this->input->post('name')){
		
				$data = array();
				$data = array(								
				'name' => $this->input->post('name'),
				
				'password' => $this->input->post('pass') ,
				'status' => $this->input->post('status') ,
					);
			$this->db->where('guid',$guid);
			$this->db->update('nurse', $data);
		
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
			$this->db->update('nurse', $data);
			$this->upload_image($guid);
			return true;  
		}
	}
	
	
	  
	public function upload_image($guid){
		$config['upload_path'] = './files/nurses/';  
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
			$this->db->update('nurse', $datas);
		}  
		return true;
	}
	
	
}
?>