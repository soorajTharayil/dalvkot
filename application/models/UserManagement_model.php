<?php defined('BASEPATH') or exit('No direct script access allowed');



class UserManagement_model extends CI_Model

{



	private $table = 'user';
	private $table2 = 'roles';



	public function create($data = [])

	{



		$this->db->insert($this->table, $data);
		// Get the insert ID of the newly inserted record
		$user_id = $this->db->insert_id();  // Retrieve the insert ID

		// Ensure that $user_id is set before proceeding
		if (!$user_id) {
			return false;  // Handle the case where insertion failed
		}

		// Get user permissions based on the new user_id and role_id
		$userPermission = $this->user_permission($user_id, $data['user_role']);
        $this->updateUserManagement($userPermission,$user_id);
		// Insert data into the user_permissions table
// 		foreach ($userPermission as $module => $sections) {
// 			foreach ($sections as $section => $permissions) {
// 				foreach ($permissions as $permission) {
// 					$permissionData = [
// 						'user_id' => $user_id,  // Use the insert ID as the user_id
// 						'feature_id' => $permission['feature_id'],
// 						'status' => $permission['status'] ? 1 : 0, // Convert boolean to 1 or 0
// 						'section' => $permission['section_id'],
// 						'module' => $permission['module_id'],
// 					];
// 					// Insert each permission into the user_permissions table
// 					$this->db->insert('user_permissions', $permissionData);
// 				}
// 			}
// 		}

		$this->sinkdeparment($_POST, 'NOEMAIL');

		return true;
	}

	public function get_all_descriptions()
	{
		$this->db->select('type, setkey, description');
		$query = $this->db->get('department');
		$result = $query->result();

		$descriptions = [];
		foreach ($result as $row) {
			$descriptions[$row->type][$row->setkey] = $row->description;
		}

		return $descriptions;
	}
	public function read()

	{

		return $this->db->select("*")

			->from($this->table)

			->order_by('user_role', 'asc')

			->get()

			->result();
	}


	public function is_mobile_exists($mobile)
	{
		$this->db->where('mobile', $mobile);
		$query = $this->db->get('user'); // Replace 'user' with your actual table name

		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function is_email_exists($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('user'); // Replace 'user' with your actual table name

		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function read_by_id($dprt_id = null)

	{

		return $this->db->select("*")

			->from($this->table)

			->where('user_id', $dprt_id)

			->get()

			->row();
	}

	public function role_edit($dprt_id = null)

	{

		return $this->db->select("*")

			->from($this->table2)

			->where('role_id', $dprt_id)

			->get()

			->row();
	}




	public function departmentList()

	{

		return $this->db->select("*")

			->from('department')



			->get()

			->result();
	}



	public function update($data = [])
	{
	    
		// Check if the record exists
		if ($this->read_by_id($_POST['ids'])) {
			$ds = $this->read_by_id($_POST['ids']);
			$old_email = $ds->email;

			// Update the existing record
			$this->db->where('user_id', $_POST['ids'])
				->update($this->table, $data);

			$user_id = $_POST['ids']; // Use the provided ID for updating permissions
		} else {
			// Insert new record
			$this->db->insert($this->table, $data);

			// Get the insert ID of the newly inserted record
			$user_id = $this->db->insert_id();

			// Ensure that $user_id is set before proceeding
			if (!$user_id) {
				return false; // Handle the case where insertion failed
			}
		}

		// Delete old permissions for the user
		//$this->db->where('user_id', $user_id)->delete('user_permissions');

		// Get user permissions based on the user_id and role_id
		//$userPermission = $this->user_permission($user_id, $data['user_role']);
        //$this->updateUserManagement($userPermission,$user_id);
		// Insert updated data into the user_permissions table

		// Handle other logic for sink department or any additional processing
		$this->sinkdeparment($_POST, $old_email ?? null);

		return true;
	}
    
    private function updateUserManagement($userPermission,$user_id){
        foreach ($userPermission as $module => $sections) {
            foreach ($sections as $section => $permissions) {
                foreach ($permissions as $permission) {
                    // Check if the permission already exists
                    $this->db->where([
                        'user_id' => $user_id,
                        'feature_id' => $permission['feature_id'],
                        'section' => $permission['section_id'],
                        'module' => $permission['module_id']
                    ]);
                    $query = $this->db->get('user_permissions');
        
                    if ($query->num_rows() == 0) { // Insert only if it does not exist
                        $permissionData = [
                            'user_id' => $user_id,
                            'feature_id' => $permission['feature_id'],
                            'status' => $permission['status'] ? 1 : 0,
                            'section' => $permission['section_id'],
                            'module' => $permission['module_id'],
                        ];
                        $this->db->insert('user_permissions', $permissionData);
                    }
                }
            }
        }
    }



	public function sinkdeparment($d, $old_email)

	{



		$data = array(

			'mobile' => '',

			'alternate_mobile' => '',

			'email' => '',

			'alternate_email' => '',

			'pname' => '',

		);

		$this->db->where('email', $old_email);

		$this->db->update('department', $data);

		$ipdepartment = $d['depip'];

		foreach ($ipdepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'inpatient');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}



		$opdepartment = $d['depop'];

		foreach ($opdepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'outpatient');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}



		$indepartment = $d['depin'];

		foreach ($indepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'interim');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}



		$psrdepartment = $d['deppsr'];

		foreach ($psrdepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'service');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}



		$esrdepartment = $d['depesr'];

		foreach ($esrdepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'esr');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}



		// --

		$gridepartment = $d['depgrievance'];

		foreach ($gridepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'grievance');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}

		// --



		$adfdepartment = $d['depadf'];

		foreach ($adfdepartment as $keyadf => $adfrow) {

			$this->db->where('dprt_id', $keyadf);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'adf');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}





		$empexdepartment = $d['depempex'];

		foreach ($empexdepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'employees');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}





		$incidepartment = $d['depinci'];

		foreach ($incidepartment as $keyip => $iprow) {

			$this->db->where('dprt_id', $keyip);

			$query = $this->db->get('department');

			$result = $query->result();

			$data = array(

				'mobile' => $d['mobile'],

				'alternate_mobile' => $d['alternate_mobile'],

				'alternate_email' => $d['alternate_email'],

				'email' => $d['email'],

				'pname' => $d['name'],

			);

			$this->db->where('type', 'incident');

			$this->db->where('description', $result[0]->description);

			$this->db->update('department', $data);
		}

		return true;
	}



	public function delete($dprt_id = null)

	{



		$user = $this->db->where('user_id', $dprt_id)->get($this->table)->result();

		$old_email = $user[0]->email;



		$data = array(

			'mobile' => '',

			'alternate_email' => '',

			'alternate_mobile' => '',

			'email' => '',

			'pname' => ''

		);

		$this->db->where('email', $old_email);

		$this->db->update('department', $data);

		$this->db->where('user_id', $dprt_id)->delete($this->table);



		if ($this->db->affected_rows()) {

			return true;
		} else {

			return false;
		}
	}

	public function update_email_status($dprt_id)
	{
		$user = $this->db->where('user_id', $dprt_id)->get($this->table)->result();

		if (empty($user)) {
			return false; // No user found
		}

		$admin = $user[0]->user_role;
		$data = array();

		switch ($admin) {
			case 2:
				$data['admin_email'] = '0';
				break;
			case 3:
				$data['admin_email'] = '0';
				break;
			case 4:
				$data['departmenthead_email'] = '0';
				break;
			case 8:
				$data['patient_coordinator_email'] = '0';
				break;
			default:
				return false; // Invalid user role
		}

		$this->db->where('user_id', $dprt_id);
		return $this->db->update('user', $data);
	}

	public function update_sms_status($dprt_id)
	{
		$user = $this->db->where('user_id', $dprt_id)->get($this->table)->result();

		if (empty($user)) {
			return false; // No user found
		}

		$admin = $user[0]->user_role;
		$data = array();

		switch ($admin) {
			case 2:
				$data['message_alert'] = '0';
				break;
			case 3:
				$data['message_alert'] = '0';
				break;
			case 4:
				$data['message_alert'] = '0';
				break;
			case 8:
				$data['message_alert'] = '0';
				break;
			default:
				return false; // Invalid user role
		}

		$this->db->where('user_id', $dprt_id);
		return $this->db->update('user', $data);
	}


	public function update_whatsapp_status($dprt_id)
	{
		$user = $this->db->where('user_id', $dprt_id)->get($this->table)->result();

		if (empty($user)) {
			return false; // No user found
		}

		$admin = $user[0]->user_role;
		$data = array();

		switch ($admin) {
			case 2:
				$data['whatsapp_alert'] = '0';
				break;
			case 3:
				$data['whatsapp_alert'] = '0';
				break;
			case 4:
				$data['whatsapp_alert'] = '0';
				break;
			case 8:
				$data['whatsapp_alert'] = '0';
				break;
			default:
				return false; // Invalid user role
		}

		$this->db->where('user_id', $dprt_id);
		return $this->db->update('user', $data);
	}

	public function role_delete($dprt_id = null)

	{

		$this->db->where('role_id', $dprt_id)->delete($this->table2);



		if ($this->db->affected_rows()) {

			return true;
		} else {

			return false;
		}
	}



	public function department_list($dep)

	{

		$result = $this->db->select("*")

			->from('department')

			->where('type', $dep)

			->group_by('description')

			->get()

			->result();



		return $result;
	}





	public function role_list()

	{

		$result = $this->db

			->select("*")

			->from('roles')

			->order_by('role_id', 'asc') // or 'desc' for descending order

			->get()

			->result();



		return $result;
	}



	public function role_permission($role)

	{

		// $this->db->where('R.role_id', $userRole);

		// $this->db->select('R.*,F.feature_name,M.module_name,S.section_name');

		// $this->db->from('role_permissions as R');

		// $this->db->join('features as F','F.feature_id = R.feature_id');

		// $this->db->join('modules as M','M.module_id = R.module');

		// $this->db->join('sections as S','S.section_id = R.section');

		// $query = $this->db->get();



		$this->db->from('role_permissions as R');

		$this->db->where('R.role_id', $role);

		$query = $this->db->get();

		$role_permission = $query->result();

		$active_role_permission = [];

		foreach ($role_permission as $role) {

			$active_role_permission[$role->feature_id] = $role->status;
		}

		//echo '<pre>';
		$this->db->from('features as F');
		$this->db->select('F.*, M.description, S.section_name, S.section_type,M.module_id');
		$this->db->join('sections as S', 'S.section_id = F.section_id');
		$this->db->join('modules as M', 'M.module_id = S.module_id');
		$this->db->where('M.display', 1); // Add this line to filter by display column
		$this->db->where('F.display', 1); // Add this line to filter by display column
		$this->db->where('S.display', 1); // Add this line to filter by display column
		$this->db->order_by('M.showid');  // Add this line to order by module_id
		$query = $this->db->get();

		$permissionList = $query->result();



		$groupedPermissions = [];



		foreach ($permissionList as $permission) {

			$module = $permission->description;

			$section = $permission->section_name;



			if (!isset($groupedPermissions[$module][$section])) {

				$groupedPermissions[$module][$section] = [];
			}



			$groupedPermissions[$module][$section][] = [

				'feature_name' => $permission->feature_name,
				'feature_description' => $permission->feature_description,
				'feature_tooltip' => $permission->feature_tooltip,

				'feature_id' => $permission->feature_id,
				'section_id' => $permission->section_id,
				'module_id' => $permission->module_id,
				'section_type' => $permission->section_type,

				'status' => ($active_role_permission[$permission->feature_id] == 1) ? true : false,

			];
		}

		// print_r($groupedPermissions);

		// echo $role; exit;

		return $groupedPermissions;
	}



	public function user_permission($user_id, $role_id)

	{

		$this->db->from('user_permissions as UP');

		$this->db->where('UP.user_id', $user_id);

		$query = $this->db->get();

		$user_permission = $query->result();
		if (count($user_permission) == 0) {
			$this->db->from('role_permissions as R');

			$this->db->where('R.role_id', $role_id);

			$query = $this->db->get();

			$user_permission = $query->result();
		}

		$active_role_permission = [];

		foreach ($user_permission as $role) {

			$active_user_permission[$role->feature_id] = $role->status;
		}

		//echo '<pre>';

		$this->db->from('features as F');
		$this->db->select('F.*, M.description, S.section_name, S.section_type,M.module_id');
		$this->db->join('sections as S', 'S.section_id = F.section_id');
		$this->db->join('modules as M', 'M.module_id = S.module_id');
		$this->db->where('M.display', 1); // Add this line to filter by display column
		$this->db->where('F.display', 1); // Add this line to filter by display column
		$this->db->where('S.display', 1); // Add this line to filter by display column
		$this->db->order_by('M.showid');  // Add this line to order by module_id
		$query = $this->db->get();
		$permissionList = $query->result();



		$groupedPermissions = [];



		foreach ($permissionList as $permission) {

			$module = $permission->description;

			$section = $permission->section_name;



			if (!isset($groupedPermissions[$module][$section])) {

				$groupedPermissions[$module][$section] = [];
			}



			$groupedPermissions[$module][$section][] = [

				'feature_name' => $permission->feature_name,
				'feature_description' => $permission->feature_description,
				'feature_tooltip' => $permission->feature_tooltip,

				'feature_id' => $permission->feature_id,
				'section_id' => $permission->section_id,
				'module_id' => $permission->module_id,
				'section_type' => $permission->section_type,

				'status' => ($active_user_permission[$permission->feature_id] == 1) ? true : false,

			];
		}



		return $groupedPermissions;
	}



	public function save_role_permission($NewPermission, $role)

	{

		$this->db->from('features as F');

		$this->db->join('sections as S', 'S.section_id = F.section_id');

		$this->db->select('F.*,S.module_id');



		$query = $this->db->get();

		$permissionList = $query->result();

		foreach ($permissionList  as $permission) {

			$status = 0;

			if (isset($NewPermission[$permission->feature_id])) {

				$status = 1;
			}

			$this->db->where('role_id', $role);

			$this->db->where('feature_id', $permission->feature_id);

			$query = $this->db->get('role_permissions');

			$result = $query->result();

			if (count($result) > 0) {

				$set = array('status' => $status);

				$this->db->where('role_id', $role);

				$this->db->where('feature_id', $permission->feature_id);

				$this->db->update('role_permissions', $set);
			} else {

				$set = array(

					'status' => $status,

					'role_id' => $role,

					'feature_id' => $permission->feature_id,

					'section' => $permission->section_id,

					'module' => $permission->module_id,



				);

				$this->db->insert('role_permissions', $set);
			}
		}

		return true;
	}



	public function save_user_permission($NewPermission, $floor_ward, $floor_ward_esr, $floor_asset, $department, $user_id)

	{


		if ($NewPermission !== null) {

			$this->db->from('features as F');
			$this->db->join('sections as S', 'S.section_id = F.section_id');
			$this->db->select('F.*,S.module_id');
			$query = $this->db->get();
			$permissionList = $query->result();

			foreach ($permissionList  as $permission) {

				$status = 0;

				if (isset($NewPermission[$permission->feature_id])) {

					$status = 1;
				}

				$this->db->where('user_id', $user_id);

				$this->db->where('feature_id', $permission->feature_id);

				$query = $this->db->get('user_permissions');

				$result = $query->result();

				if (count($result) > 0) {

					$set = array('status' => $status);

					$this->db->where('user_id', $user_id);

					$this->db->where('feature_id', $permission->feature_id);

					$this->db->update('user_permissions', $set);
				} else {

					$set = array(

						'status' => $status,

						'user_id' => $user_id,

						'feature_id' => $permission->feature_id,

						'section' => $permission->section_id,

						'module' => $permission->module_id,



					);
					$this->db->insert('user_permissions', $set);
				}
			}
		}

		$data = array();
		if ($floor_ward !== null) {
			$data['floor_ward'] = json_encode($floor_ward);
			$this->db->where('user_id', $user_id)->update('user', $data);
		}
		if ($floor_ward_esr !== null) {
			$data['floor_ward_esr'] = json_encode($floor_ward_esr);
			$this->db->where('user_id', $user_id)->update('user', $data);
		}
		if ($floor_asset !== null) {
			$data['floor_asset'] = json_encode($floor_asset);
			$this->db->where('user_id', $user_id)->update('user', $data);
		}
		if ($department !== null) {
			$data['department'] = json_encode($department);
			$this->db->where('user_id', $user_id)->update('user', $data);
		}
		return true;
	}



	public function role_create($data = [])

	{

		return $this->db->insert('roles', $data);
	}


	public function role_update($data = [])
	{
		return $this->db->where('role_id', $data['role_id'])
			->update($this->table2, $data);
	}
}
