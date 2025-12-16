<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_acc_model extends BF_Model {   
		public function find_all_event() {   
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;
		}
		

		public function all($table) {
			$query = $this->db->get($table);
			$result = $query->result();
			return $result;
		}
	
		
		public function edit($table,$guid){
			$this->db->where('guid',$guid);
			$query = $this->db->get($table);        
			$result = $query->result();
			$data = $result[0];
			return $data;
		}
	
	
	
	
   
	
	
	public function create(){	
		
			$data = array();
			$guid = guid();
			$data = array(					
					'guid' => guid(),
					'title'=>$this->input->post('title'),			
									
			);
			$business_acc=$this->db->insert('business_acc',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
				'title'=>$this->input->post('title'),	
			);
			$this->db->where('guid',$guid);
			$this->db->update('business_acc', $data);
	}
	
	
}		
	
	
?>