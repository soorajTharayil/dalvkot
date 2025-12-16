<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_model extends BF_Model {   
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
					'proguid'=>$this->input->post('proguid'),			
					'pro_name'=>$this->input->post('pro_name'),			
					'model_no'=>$this->input->post('model_no'),			
					'item_quantity'=>$this->input->post('item_quantity'),			
					'price'=>$this->input->post('price'),			
					'proimage'=>$this->input->post('proimage'),			
					'status'=>$this->input->post('status'),			
					'dates'=>$this->input->post('dates'),			
					'description'=>$this->input->post('description'),			
					'order_no'=>$this->input->post('order_no'),			
					'customer_name'=>$this->input->post('customer_name'),			
					'mobile_no'=>$this->input->post('mobile_no'),			
									
			);
			$orders=$this->db->insert('orders',$data);
			
			return true;
			
		
			
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
					'proguid'=>$this->input->post('proguid'),			
					'pro_name'=>$this->input->post('pro_name'),			
					'model_no'=>$this->input->post('model_no'),			
					'item_quantity'=>$this->input->post('item_quantity'),			
					'price'=>$this->input->post('price'),			
					'proimage'=>$this->input->post('proimage'),			
					'status'=>$this->input->post('status'),			
					'dates'=>$this->input->post('dates'),			
					'description'=>$this->input->post('description'),			
					'order_no'=>$this->input->post('order_no'),			
					'customer_name'=>$this->input->post('customer_name'),			
					'mobile_no'=>$this->input->post('mobile_no'),	
			);
			$this->db->where('guid',$guid);
			$this->db->update('orders', $data);
	}
	
	
}		
	
	
?>