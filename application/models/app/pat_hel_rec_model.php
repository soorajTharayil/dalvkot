<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pat_hel_rec_model extends BF_Model {   
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
					'guid' => $guid,
					'pro_name' => $this->input->post('pro_name'),
					'model_no' => $this->input->post('model_no'),
					'description' => $this->input->post('description'),
					'quantity' => $this->input->post('quantity'),
					'price' => $this->input->post('price'),
					'subguid' => $this->input->post('subguid'),
					'cguid' => $this->input->post('cguid'),
					'bguid' => $this->input->post('bguid'),
					
									
			);
			$product=$this->db->insert('pat_hel_rec',$data);
			$this->upload_image($guid);
			return true;
			
		
			 
	 }
	 
	  public function update($guid){
			$data = array();
			$data = array(									
				
					'pro_name' => $this->input->post('pro_name'),
					'model_no' => $this->input->post('model_no'),
					'description' => $this->input->post('description'),
					'quantity' => $this->input->post('quantity'),
					'price' => $this->input->post('price'),
					'subguid' => $this->input->post('subguid'),
					'cguid' => $this->input->post('cguid'),
					'bguid' => $this->input->post('bguid'),
			);
			$this->db->where('guid',$guid);
			$this->db->update('pat_hel_rec', $data);
			$this->upload_image($guid);
			
	}
	
	public function upload_image($guid){
		$config['upload_path'] = './files/gallery_image/'; 
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
		$config['maintain_ratio'] = TRUE;
		  
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('proimage')) {
			$error = array('error' => $this->upload->display_errors());
		}else{
		   $data = array('upload_data' => $this->upload->data());
		   $datas = array(
				'proimage' => $data['upload_data']['file_name'],
			);
			$this->db->where('guid',$guid);
			$this->db->update('pat_hel_rec', $datas);
		}
	  return true;
	}
	
	
	
}		
	
	
?>