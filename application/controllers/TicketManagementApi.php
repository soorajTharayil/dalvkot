<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TicketManagementApi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $dates = get_from_to_date();
        $this->load->model(array(
            'dashboard_model',
            'efeedor_model',			'users_model',
            'ticketsadf_model', //1
            'tickets_model', //2
            'ticketsint_model', //3
            'ticketsop_model', // 4
            'ticketsesr_model', // 5 
            'ticketspdf_model', // 5 
            'ticketsgrievance_model',  //  6
            'ticketsincidents_model', // 7 
            'ipd_model',
            'opf_model',
            'opt/ipd_opt_model',
            'pc_model',
            'post_model',
            'isr_model',
            'incident_model',
            'grievance_model',
            'admissionfeedback_model',
            'departmenthead_model',
            'setting_model'
        ));
        // if ($this->session->userdata('isLogIn') === false)
        //     redirect('login');

        // if ($this->session->userdata('user_role') !== 0)
        //     redirect('dashboard/noaccess');
    }
	
	private function loginUser($userId){
		
        $check_user =  $this->dashboard_model->check_user_api($userId);

        $u = json_decode($check_user->row()->departmentpermission);
        $floor_ward = json_decode($check_user->row()->floor_ward);
        $floor_ward_esr = json_decode($check_user->row()->floor_ward_esr);
        $department = json_decode($check_user->row()->department, true);
        $question_array = array();
        foreach ($department as $key => $deprow) {
            foreach ($deprow as $set) {
                $set_array = explode(',', $set);
                foreach ($set_array as $r) {
                    $question_array[$key][] = $r;
                }
            }
        }



        if ($check_user->num_rows() === 1) {
            //retrive setting data and store to session

            //store data in session
            $this->session->set_userdata([
                'isLogIn' => true,
                'user_id' => (($postData['user_role'] == 10) ? $check_user->row()->id : $check_user->row()->user_id),
                'patient_id' => (($postData['user_role'] == 10) ? $check_user->row()->patient_id : null),
                'email' => $check_user->row()->email,
                'fullname' => $check_user->row()->firstname,
                'user_role' => $check_user->row()->user_role,
                'user_role_name' => $check_user->row()->lastname,

                'picture' => $check_user->row()->picture,
                // 'access1' => $access1,
                // 'access2' => $access2,
                // 'access3' => $access3,
                // 'access4' => $access4,
                // 'access5' => $access5,
                // 'access6' => $access6,
                // 'access7' => $access7,
                // 'access8' => $access8,
                // 'access9' => $access9,
                'departmenthead' => $u,
                'floor_ward' => $floor_ward,
                'floor_ward_esr' => $floor_ward_esr,
                'department_access' => $department,
                'question_array' => $question_array,
                'title' => (!empty($setting->title) ? $setting->title : null),
                'address' => (!empty($setting->description) ? $setting->description : null),
                'logo' => (!empty($setting->logo) ? $setting->logo : null),
                'favicon' => (!empty($setting->favicon) ? $setting->favicon : null),
                'footer_text' => (!empty($setting->footer_text) ? $setting->footer_text : null),
            ]);
        }
        header('content-type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        $dates = get_from_to_date();
		return true;
	}
	public function ticketDashboard()
    {
        $userId = $this->uri->segment(3);
        $module = $this->uri->segment(4);
		$this->loginUser($userId);
		if($module == 'IP'){
			$alltickets = $this->tickets_model->alltickets();
			$opentickets_read = $this->tickets_model->read();
			$opentickets_address = $this->tickets_model->addressedtickets();
			$opentickets = array_merge($opentickets_read, $opentickets_address);
			$closedtickets = $this->tickets_model->read_close();
			$response = [
				"totalTicket" => count($alltickets),
				"openTicket" => count($opentickets),
				"closedTicket" => count($closedtickets),
			];
			echo json_encode($response);
		}
		if($module == 'OP'){
			$alltickets = $this->ticketsop_model->alltickets();
			$opentickets_read = $this->ticketsop_model->read();
			$opentickets_address = $this->ticketsop_model->addressedtickets();
			$opentickets = array_merge($opentickets_read, $opentickets_address);
			$closedtickets = $this->ticketsop_model->read_close();
			$response = [
				"totalTicket" => count($alltickets),
				"openTicket" => count($opentickets),
				"closedTicket" => count($closedtickets),
			];
			echo json_encode($response);
		}
		if($module == 'PCF'){
			$alltickets = $this->ticketsint_model->alltickets();
			$opentickets_read = $this->ticketsint_model->read();
			$opentickets_address = $this->ticketsint_model->addressedtickets();
			$opentickets = array_merge($opentickets_read, $opentickets_address);
			$closedtickets = $this->ticketsint_model->read_close();
			$response = [
				"totalTicket" => count($alltickets),
				"openTicket" => count($opentickets),
				"closedTicket" => count($closedtickets),
			];
			echo json_encode($response);
		}
		if($module == 'ISR'){
			$alltickets = $this->ticketsesr_model->alltickets();
			$opentickets_read = $this->ticketsesr_model->read();
			$opentickets_address = $this->ticketsesr_model->addressedtickets();
			$opentickets = array_merge($opentickets_read, $opentickets_address);
			$closedtickets = $this->ticketsesr_model->read_close();
			$response = [
				"totalTicket" => count($alltickets),
				"openTicket" => count($opentickets),
				"closedTicket" => count($closedtickets),
			];
			echo json_encode($response);
		}
		if($module == 'INCIDENT'){
			$alltickets = $this->ticketsincidents_model->alltickets();
			$opentickets_read = $this->ticketsincidents_model->read();
			$opentickets_address = $this->ticketsincidents_model->addressedtickets();
			$opentickets = array_merge($opentickets_read, $opentickets_address);
			$closedtickets = $this->ticketsincidents_model->read_close();
			$response = [
				"totalTicket" => count($alltickets),
				"openTicket" => count($opentickets),
				"closedTicket" => count($closedtickets),
			];
			echo json_encode($response);
		}
		exit;
	}
	
	public function allTicketDashboard()
    {
        $userId = $this->uri->segment(3);
        $module = $this->uri->segment(4);
		$this->loginUser($userId);
		if($module == 'IP'){
			$alltickets = $this->tickets_model->alltickets();
			$opentickets_read = $this->tickets_model->read();
			$opentickets_address = $this->tickets_model->addressedtickets();
			$opentickets = array_merge($opentickets_address,$opentickets_read);
			$closedtickets = $this->tickets_model->read_close();
			$response = [
				"all" => $alltickets,
				"open" => $opentickets,
				"closed" => $closedtickets
			];
			echo json_encode($response);
		}
		if($module == 'OP'){
			$alltickets = $this->ticketsop_model->alltickets();
			
			$opentickets_read = $this->ticketsop_model->read();
			$opentickets_address = $this->ticketsop_model->addressedtickets();
			$opentickets = array_merge($opentickets_address,$opentickets_read);
			$closedtickets = $this->ticketsop_model->read_close();
			$response = [
				"all" => $alltickets,
				"open" => $opentickets,
				"closed" => $closedtickets,
			];
			echo json_encode($response);
		}
		if($module == 'PCF'){
			$alltickets = $this->ticketsint_model->alltickets();
			$opentickets_read = $this->ticketsint_model->read();
			$opentickets_address = $this->ticketsint_model->addressedtickets();
			$opentickets = array_merge($opentickets_address,$opentickets_read);
			$closedtickets = $this->ticketsint_model->read_close();
			$response = [
				"all" => $alltickets,
				"open" => $opentickets,
				"closed" => $closedtickets,
			];
			echo json_encode($response);
		}
		if($module == 'ISR'){
			$alltickets = $this->ticketsesr_model->alltickets();
			$opentickets_read = $this->ticketsesr_model->read();
			$opentickets_address = $this->ticketsesr_model->addressedtickets();
			$opentickets = array_merge($opentickets_address,$opentickets_read);
			$closedtickets = $this->ticketsesr_model->read_close();
			$response = [
				"all" => $alltickets,
				"open" => $opentickets,
				"closed" => $closedtickets,
			];
			echo json_encode($response);
		}
		if($module == 'INCIDENT'){
			$alltickets = $this->ticketsincidents_model->alltickets();
			$opentickets_read = $this->ticketsincidents_model->read();
			$opentickets_address = $this->ticketsincidents_model->addressedtickets();
			$opentickets = array_merge($opentickets_address,$opentickets_read);
			$closedtickets = $this->ticketsincidents_model->read_close();
			$response = [
				"all" => $alltickets,
				"open" => $opentickets,
				"closed" => $closedtickets,
			];
			echo json_encode($response);
		}
		exit;
	}
}