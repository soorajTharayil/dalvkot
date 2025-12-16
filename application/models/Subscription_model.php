<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model {
 
	private $table = "subscription";

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->get()
			->row();
	} 
	
  	public function update($data = [])
	{
		return $this->db->where('subscription_id',$data['subscription_id'])
			->update($this->table,$data); 
	} 
}
