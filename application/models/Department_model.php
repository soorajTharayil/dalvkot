<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

	private $table = 'department';

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		//echo $this->session->userdata['access3']; 
				if($this->session->userdata['access3'] == 'interim'){
					$department = 'interim';	
				}elseif($this->session->userdata['access2'] =='op'){	
					$department = 'outpatient';	
				}else{
					$department = 'inpatient';		
				}
			//echo $department; exit;
		$data =  $this->db->select("*")->where('type',$department) 
			->from($this->table)
			//->group_by('description')			
			->order_by('description','asc')
			
			->get()
			->result();
		$result = array();
		foreach ($data as $element) {
			$result[$element->description] = $element;
		}
		
		return $result;
	} 
 
	public function read_by_id($dprt_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('dprt_id',$dprt_id)
			->get()
			->row();
	} 
 
	public function update($data = [])
	{
		    $this->db->where('dprt_id',$data['dprt_id'])
			->update($this->table,$data); 
			$d = array(
					'pname' => $this->input->post('pname',true),
					'mobile' => $this->input->post('mobile',true),
					'password'=>$this->input->post('password',true),
					'email' => $this->input->post('email',true)
			); 
			$this->db->where('description',$this->input->post('description'));
			$query = $this->db->get($this->table);
			$result = $query->result();
			foreach($result as $r){
				$this->db->where('dprt_id',$r->dprt_id)
				->update($this->table,$d);
			}
			$this->db->where('email',$this->input->post('email',true));
			$query = $this->db->get('user');
			$result = $query->result();
			if($result){
				$data = array(
					'department_id'=>$r->dprt_id,
								
				);
				$this->db->where('email',$this->input->post('email',true));
				$this->db->update('user',$data);
			}else{
				$data = array(
					'department_id'=>$r->dprt_id,
					'password'=>md5($this->input->post('password',true)),
					'firstname'=>$this->input->post('pname',true),
					'email'=>$this->input->post('email',true),
					'user_role'=>4,
								
				);
				//$this->db->where('email',$data['dprt_id']);
				$this->db->insert('user',$data);
			}
			return true;
	} 
 
	public function delete($dprt_id = null)
	{
		$this->db->where('dprt_id',$dprt_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 

	public function department_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->where('status',1)
			->get()
			->result();

		$list[''] = display('select_department');
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->dprt_id] = $value->name; 
			}
			return $list;
		} else {
			return false;
		}
	}
	
 }
