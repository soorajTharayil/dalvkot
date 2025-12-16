<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_list_model extends BF_Model {   
		
		

		public function all($table) {
			$query = $this->db->get($table);
			$result = $query->result();
			return $result;
		}
	
		
		public function edit($table,$guid){
			$this->db->where('busguid',$guid);
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
					'bus_name'=>$this->input->post('bus_name'),			
					'licence_no'=>$this->input->post('licence_no'),			
					'phone_number'=>$this->input->post('phone_number'),			
					'available_hour'=>$this->input->post('available_hour'),			
					'address'=>$this->input->post('address'),			
					'lat'=>$this->input->post('lat'),			
					'long'=>$this->input->post('long'),			
					'email_address'=>$this->input->post('email_address'),			
					'description'=>$this->input->post('description'),			
					'document'=>$this->input->post('document'),			
					'storeimage'=>$this->input->post('storeimage'),			
									
			);
			$category=$this->db->insert('category',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
				'title'=>$this->input->post('title'),	
				'bus_name'=>$this->input->post('bus_name'),			
					'licence_no'=>$this->input->post('licence_no'),			
					'phone_number'=>$this->input->post('phone_number'),			
					'available_hour'=>$this->input->post('available_hour'),			
					'address'=>$this->input->post('address'),			
					'lat'=>$this->input->post('lat'),			
					'long'=>$this->input->post('long'),			
					'email_address'=>$this->input->post('email_address'),			
					'description'=>$this->input->post('description'),			
					'document'=>$this->input->post('document'),			
					'storeimage'=>$this->input->post('storeimage'),	
			);
			$this->db->where('guid',$guid);
			$this->db->update('category', $data);
	}
	
	
}		
	
	
?>