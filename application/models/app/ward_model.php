<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ward_model extends CI_Model {   
		public function find_all_event() {
			$query = $this->db->get('event');
			$result = $query->result();
			return $result;
		}
		

		public function all($table) {
			$this->db->order_by('title','asc');
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
					'title'=>strtoupper($this->input->post('title')),			
									
			);
			$ward=$this->db->insert('ward',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
				'title'=>strtoupper($this->input->post('title')),	
			);
			$this->db->where('guid',$guid);
			$this->db->update('ward', $data);
	}
	
	
}		
	
	
?>