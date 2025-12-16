<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permotional_model extends BF_Model {   
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
			$this->db->where('proguid',$guid);
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
					'offer_type'=>$this->input->post('type'),			
					'cguid'=>$this->input->post('cguid'),			
					'subguid'=>$this->input->post('subguid'),			
					'proguid'=>$this->input->post('proguid'),			
					'from_date'=>date('Y-m-d',strtotime($this->input->post('from_date'))),			
					'to_date'=>date('Y-m-d',strtotime($this->input->post('to_date'))),			
									
			);
			$product=$this->db->insert('business_permotional',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(					
					'guid' => guid(),
					'offer_type'=>$this->input->post('type'),			
					'cguid'=>$this->input->post('cguid'),			
					'subguid'=>$this->input->post('subguid'),			
					'proguid'=>$this->input->post('proguid'),			
					'from_date'=>date('Y-m-d',strtotime($this->input->post('from_date'))),			
					'to_date'=>date('Y-m-d',strtotime($this->input->post('to_date'))),			
									
			);
			$this->db->where('guid',$guid);
			$this->db->update('business_permotional', $data);
	}
	
	
}		
	
	
?>