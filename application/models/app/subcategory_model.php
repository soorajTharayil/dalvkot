<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subcategory_model extends BF_Model {   
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
		
		public function dropdown($table,$guid){
			$query = $this->db->get($table);
			$result = $query->result();
			$html = '';
			foreach($result as $row){
				if($row->guid == $guid){
					$html .= '<option value="'.$row->guid.'" selected="selected">'.$row->title.'</option>';
				}else{
					$html .= '<option value="'.$row->guid.'">'.$row->title.'</option>';
				}
			}
			return $html;
		}
		
		public function dropdownb($table,$guid){
			$query = $this->db->get($table);
			$result = $query->result();
			$html = '';
			foreach($result as $row){
				if($row->guid == $guid){
					$html .= '<option value="'.$row->guid.'" selected="selected">'.$row->bus_name.'</option>';
				}else{
					$html .= '<option value="'.$row->guid.'">'.$row->bus_name.'</option>';
				}
			}
			return $html;
		}
		
		public function get_cat($table,$guid){ 
			$this->db->where('guid',$guid);
			$query = $this->db->get($table);
			$result = $query->result();
			$html = $result[0]->title;
			return $html;
		}
	
	
	
	
   
	
	
	public function create(){	
		
			$data = array();
			$guid = guid();
			$data = array(					
					'guid' => guid(),
					'title'=>$this->input->post('title'),			
					'cguid'=>$this->input->post('cguid'),			
									
			);
			$this->db->insert('subcategory',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
				'title'=>$this->input->post('title'),	
			);
			$this->db->where('guid',$guid);
			$this->db->update('category', $data);
	}
	
	
}		
	
	
?>