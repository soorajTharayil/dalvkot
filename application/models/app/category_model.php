<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends BF_Model {   
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
			$this->db->where('id',$guid);
			$query = $this->db->get($table);        
			$result = $query->result();
			$data = $result[0];
			return $data;
		}
	
	
	
	
   
	
	
	public function create(){	
		
			$data = array();
			$guid = guid();
			if($this->input->post('status') == 0){
				$status = 0;
			}else{
				$status = 1;
			}
			$data = array(					
					'guid' => guid(),
					'title'=>$this->input->post('title'),			
					'status'=>$status,			
									
			);
			$category=$this->db->insert('category',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			if($this->input->post('status') == 0){
				$status = 0;
			}else{
				$status = 1;
			}
			$data = array(									
				'title'=>$this->input->post('title'),	
				'status'=>$status,	
			);
			$this->db->where('id',$guid);
			$this->db->update('category', $data);
	}
	
	
}		
	
	
?>