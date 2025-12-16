<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View extends CI_Controller
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

    function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        // if ($this->session->userdata('user_role') <= 2) {
        $data['title'] = 'Hello, ' . $this->session->userdata['fullname'] . ' !';
        $data['content']  = $this->load->view('zdeveloper/check');
        // $this->load->view('zdeveloper/dev_mainwrapper');
    }
    // }


    public function consolidated_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $data['title'] = 'Consolidated Report';

        #------------------------------#
        $data['content'] = $this->load->view('consolidated_report', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function user_activity()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $data['title'] = 'USER ACTIVITY DASHBOARD';

        #------------------------------#
        $data['content'] = $this->load->view('user_activity', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }
    public function stats()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $data['title'] = 'Alerts Statistics';

        #------------------------------#
        $data['content'] = $this->load->view('stats', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function user_activity_api()
    {
        $userId = $this->uri->segment(3);
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
        $feedbacktaken_count_ip = $this->ipd_model->get_feedback_count();		

        // OP feedback
        $feedbacktaken_count_op = $this->opf_model->get_feedback_count();

        // PC feedback
        $feedbacktaken_count_pcf = $this->pc_model->get_feedback_count();

        // ISR tickets
        $esralltickets = $this->ticketsesr_model->alltickets_individual_user();
        $totalTicketsCount = count($esralltickets);
        $totalTicketsCountOpen = count($this->ticketsesr_model->read_individual_user());
        $totalTicketsCountAssigned = count($this->ticketsesr_model->assignedtickets_individual_user());
        $totalTicketsCountClosed = count($this->ticketsesr_model->read_close_individual_user());

        // Incident tickets
        $incidentalltickets = $this->ticketsincidents_model->alltickets_individual_user();
        $totalTicketsCount_incident = count($incidentalltickets);
        $totalTicketsCountOpen_inciden = count($this->ticketsincidents_model->read_individual_user());
        $totalTicketsCountAssigned_inciden = count($this->ticketsincidents_model->assignedtickets_individual_user());
        $totalTicketsCountClosed_inciden = count($this->ticketsincidents_model->read_close_individual_user());

        // Grievance tickets
        $grievencealltickets = $this->ticketsgrievance_model->alltickets_individual_user();
        $totalTicketsCount_grievence = count($grievencealltickets);
        $totalTicketsCountOpen_grievence = count($this->ticketsgrievance_model->read_individual_user());
        $totalTicketsCountAddressed_grievence = count($this->ticketsgrievance_model->addressedtickets_individual_user());
        $totalTicketsCountClosed_grievence = count($this->ticketsgrievance_model->read_close_individual_user());

        // Prepare response
        $response = [
            'ip_feedback_count' => $feedbacktaken_count_ip,
            'op_feedback_count' => $feedbacktaken_count_op,
            'pc_feedback_count' => $feedbacktaken_count_pcf,
            'isr_tickets' => [
                'total' => $totalTicketsCount,
                'open' => $totalTicketsCountOpen,
                'assigned' => $totalTicketsCountAssigned,
                'closed' => $totalTicketsCountClosed
            ],
            'incident_tickets' => [
                'total' => $totalTicketsCount_incident,
                'open' => $totalTicketsCountOpen_inciden,
                'assigned' => $totalTicketsCountAssigned_inciden,
                'closed' => $totalTicketsCountClosed_inciden
            ],
            'grievance_tickets' => [
                'total' => $totalTicketsCount_grievence,
                'open' => $totalTicketsCountOpen_grievence,
                'addressed' => $totalTicketsCountAddressed_grievence,
                'closed' => $totalTicketsCountClosed_grievence
            ]
        ];

        echo json_encode($response);
        exit;
    }

    public function user_activity_isr()
    {
        $userId = $this->uri->segment(4);
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
        //echo  $userId = $this->uri->segment(3);
        $type =  $this->uri->segment(3);
        $tickets = [];		$allUsers = $this->users_model->read();				foreach($allUsers as $row){			$UserDataSet[$row->user_id] = $row->firstname;		}
        if ($type == 'all') {
            $tickets = $this->ticketsesr_model->alltickets_individual_user();
        } elseif ($type == 'open') {
            $tickets = $this->ticketsesr_model->read_individual_user();
        } elseif ($type == 'assigne') {
            $tickets = $this->ticketsesr_model->assignedtickets_individual_user();
        } elseif ($type == 'close') {
            $tickets = $this->ticketsesr_model->read_close_individual_user();
        }
				foreach($tickets as $key => $row){						$tickets[$key]->assign_to_name = $UserDataSet[$row->assign_to];		}
        echo json_encode($tickets);
        exit();
    }

    public function user_activity_incident()
    {
        $userId = $this->uri->segment(4);		
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
        //echo  $userId = $this->uri->segment(3);
        $type =  $this->uri->segment(3);		$allUsers = $this->users_model->read();				foreach($allUsers as $row){			$UserDataSet[$row->user_id] = $row->firstname;		}
        $tickets = [];
        if ($type == 'all') {
            $tickets = $this->ticketsincidents_model->alltickets_individual_user();
        } elseif ($type == 'open') {
            $tickets = $this->ticketsincidents_model->read_individual_user();
        } elseif ($type == 'assigne') {
            $tickets = $this->ticketsincidents_model->assignedtickets_individual_user();
        } elseif ($type == 'close') {
            $tickets = $this->ticketsincidents_model->read_close_individual_user();
        }
		foreach($tickets as $key => $row){						$tickets[$key]->assign_to_name = $UserDataSet[$row->assign_to];		}
        echo json_encode($tickets);
        exit();
    }

    public function user_activity_ipd()
    {
        $userId = $this->uri->segment(4);
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
        //echo  $userId = $this->uri->segment(3);
        $type =  $this->uri->segment(3);
        $tickets = [];
        if ($type == 'all') {
            $tickets = $this->ipd_model->get_feedback_rows();
        }
        foreach ($tickets as $key => $row) {
            $tickets[$key]->dataset = json_decode($row->dataset);
        }
        echo json_encode($tickets);
        exit();
    }

    public function user_activity_pcf()
    {
        $userId = $this->uri->segment(4);
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
        //echo  $userId = $this->uri->segment(3);
        $type =  $this->uri->segment(3);
        $tickets = [];
        if ($type == 'all') {
            $tickets = $this->pc_model->get_feedback_rows();
        }
        foreach ($tickets as $key => $row) {
            $tickets[$key]->dataset = json_decode($row->dataset);
        }
        echo json_encode($tickets);
        exit();
    }


    public function user_activity_opf()
    {
        $userId = $this->uri->segment(4);
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
        //echo  $userId = $this->uri->segment(3);
        $type =  $this->uri->segment(3);
        $tickets = [];
        if ($type == 'all') {
            $tickets = $this->opf_model->get_feedback_rows();
        }
        foreach ($tickets as $key => $row) {
            $tickets[$key]->dataset = json_decode($row->dataset);
        }

        echo json_encode($tickets);
        exit();
    }		public function user_activity_permission()    {        $userId = $this->uri->segment(3);        $check_user =  $this->dashboard_model->check_user_api($userId);		$floor_ward = json_decode($check_user->row()->floor_ward);		$user  = json_decode($check_user->row()->departmentpermission);				$department = json_decode($check_user->row()->department,true);		$userRole = $user->userrole;		foreach($department as $key => $row){			foreach($row as $k => $r){				$department[$key][$k] = explode(',',$department[$key][$k]);			}		}		        $this->db->where('U.user_id', $userId);        $this->db->select('U.*,F.feature_name,M.module_name,S.section_name,S.url');        $this->db->from('user_permissions as U');        $this->db->join('features as F','F.feature_id = U.feature_id');        $this->db->join('modules as M','M.module_id = U.module');        $this->db->join('sections as S','S.section_id = U.section');		$this->db->order_by('M.module_id','asc');        $query = $this->db->get();        $permission = $query->result();        if(count($permission) == 0){            $this->db->where('R.role_id', $userRole);            $this->db->select('R.*,F.feature_name,M.module_name,S.section_name,S.url');            $this->db->from('role_permissions as R');            $this->db->join('features as F','F.feature_id = R.feature_id');            $this->db->join('modules as M','M.module_id = R.module');            $this->db->join('sections as S','S.section_id = R.section');			$this->db->order_by('M.module_id','asc');            $query = $this->db->get();            $permission = $query->result();        }                $module_access = array();        $feature_access = array();        $section_access = array();        $section_url = array();        foreach($permission as $row){            if($row->status == 1){                $module_access[$row->module_name] = true;                 $feature_access[$row->feature_name] = true;                 $section_access[$row->section_name] = true; 								$section_url[$row->section_name] = $row->url;            }else{                if($module_access[$row->module_name] != true){                    $module_access[$row->module_name] = false;                                     }                if($feature_access[$row->feature_name] != true){                    $feature_access[$row->feature_name] = false;                 }                if($section_access[$row->section_name] != true){                    $section_access[$row->section_name] = false;                 }            }        }		header('content-type: application/json; charset=utf-8');        header("Access-Control-Allow-Origin: *");        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');        header('Access-Control-Max-Age: 1000');        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');		echo json_encode(['modules'=>$module_access,'feature' =>$feature_access,'section'=>$section_access,'department'=>$department,'floor_ward'=>$floor_ward,'userRole'=>$userRole]);		exit;	}
}
