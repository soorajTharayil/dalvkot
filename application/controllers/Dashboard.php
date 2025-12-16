<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        // $dates = get_from_to_date();
        $this->load->model(
            array(
                'dashboard_model',
                'efeedor_model',
                'ticketsadf_model', //1
                'tickets_model', //2
                'ticketsint_model', //3
                'ticketsop_model', // 4
                'ticketsesr_model', // 5 
                'ticketsgrievance_model',  //  6
                'ticketsincidents_model', // 7 
                'ticketspdf_model', // 7 
                'opt/ipd_opt_model',
                'ipd_model',
                'opf_model',
                'pc_model',
                'isr_model',
                'post_model',
                'incident_model',
                'grievance_model',
                'admissionfeedback_model',
                'departmenthead_model',
                'asset_model',
                'ticketsasset_model',
                'setting_model'
            )
        );
    }

    public function index()
    {


        $userid = $this->input->get('userid', true);
        $redirectType = $this->input->get('redirectType', true);
       


        // Redirect for APK login
        if (!empty($userid)) {
            // Verify if the userid exists in the database
            $user_check = $this->dashboard_model->check_user_api($userid);

            if ($user_check->num_rows() === 1) {

                $setting = $this->setting_model->read();
                $logo = !empty($setting->logo) ? $setting->logo : null;

                // Set session and redirect to dashboard
                $this->session->set_userdata([
                    'isLogIn' => true,
                    'user_id' => $userid,
                    'fullname' => $user_check->row()->firstname,
                    'email' => $user_check->row()->email,
                    'user_role' => $user_check->row()->user_role,
                    'user_role_name' => $user_check->row()->lastname,
                    'picture' => $user_check->row()->picture,
                    'logo' => $logo,
                    'redirectType' => $redirectType
                ]);

                if ($this->session->userdata('isLogIn') && $this->session->userdata('redirectType') === "userActivity") {
                    redirect('/view/user_activity');
                    exit;
                }

                $this->redirectTo(1); // Default welcome page
            }
        }

        // Web redirect to dashboard home page
        if ($this->session->userdata('isLogIn'))

            $this->redirectTo(1);

        // $this->form_validation->set_rules('email', display('email'), 'required|max_length[50]|valid_email');
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5');
        $this->form_validation->set_rules('user_role', display('user_role'), 'required');


        #-------------------------------#
        $setting = $this->setting_model->read();
        $data['title'] = (!empty($setting->title) ? $setting->title : null);
        $data['logo'] = (!empty($setting->logo) ? $setting->logo : null);
        $data['favicon'] = (!empty($setting->favicon) ? $setting->favicon : null);
        $data['footer_text'] = (!empty($setting->footer_text) ? $setting->footer_text : null);

        $data['user'] = (object) $postData = [
            'email' => $this->input->post('email', true),
            'password' => md5($this->input->post('password', true)),
            'user_role' => $this->input->post('user_role', true),


        ];

        #-------------------------------#
        if ($this->form_validation->run() === true) {
            //check user data
            $check_user = $this->dashboard_model->check_user($postData);

            $u = json_decode($check_user->row()->departmentpermission);
            $floor_ward = json_decode($check_user->row()->floor_ward);
            $floor_ward_esr = json_decode($check_user->row()->floor_ward_esr);

            // Combine all comma-separated values from all keys into one array
            $all_items = [];

            foreach ($floor_ward_esr as $value) {
                $items = array_map('trim', explode(',', $value));
                $all_items = array_merge($all_items, $items);
            }

            // Optional: remove duplicates if needed
            $all_items = array_unique($all_items);


            $floor_ward_esr = $all_items;
            $department = json_decode($check_user->row()->department, true);
            $departmentSet = array();
            $question_array = array();
            foreach ($department as $key => $deprow) {
                foreach ($deprow as $k => $set_array) {
                    //$set_array = explode(',', $set);
                    foreach ($set_array as $r) {

                        $question_array[$k][] = $r;
                        $departmentSet[$key][$k][] = $r;
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
                    'floor_asset' => json_decode($check_user->row()->floor_asset),

                    'department_access' => $department,
                    'question_array' => $question_array,
                    'title' => (!empty($setting->title) ? $setting->title : null),
                    'address' => (!empty($setting->description) ? $setting->description : null),
                    'logo' => (!empty($setting->logo) ? $setting->logo : null),
                    'favicon' => (!empty($setting->favicon) ? $setting->favicon : null),
                    'footer_text' => (!empty($setting->footer_text) ? $setting->footer_text : null),
                ]);



                $this->redirectTo($check_user->row()->user_access);
            } else {
                #set exception message
                $this->session->set_flashdata('exception', 'Incorrect Email / Mobile Number / Password!');
                //redirect to login form
                redirect('login');
            }
        } else {
            $this->load->view('layout/login_wrapper', $data);
        }
    }


    public function redirectTo($user_access = null)
    {
        // print_r($this->session->userdata);
        // exit;

        if ($this->session->userdata('isLogIn') === false)
            redirect('login');
        // echo '<pre>';
        // print_r($this->session->userdata); exit;
        $userRole = $this->session->userdata['user_role'];
        $userId = $this->session->userdata['user_id'];
        $this->db->where('U.user_id', $userId);
        $this->db->select('U.*,F.feature_name,M.module_name,S.section_name,S.url');
        $this->db->from('user_permissions as U');
        $this->db->join('features as F', 'F.feature_id = U.feature_id');
        $this->db->join('modules as M', 'M.module_id = U.module');
        $this->db->join('sections as S', 'S.section_id = U.section');
        $this->db->order_by('M.module_id', 'asc');
        $query = $this->db->get();
        $permission = $query->result();

        if (count($permission) == 0) {
            $this->db->where('R.role_id', $userRole);
            $this->db->select('R.*,F.feature_name,M.module_name,S.section_name,S.url');
            $this->db->from('role_permissions as R');
            $this->db->join('features as F', 'F.feature_id = R.feature_id');
            $this->db->join('modules as M', 'M.module_id = R.module');
            $this->db->join('sections as S', 'S.section_id = R.section');
            $this->db->order_by('M.module_id', 'asc');
            $query = $this->db->get();
            $permission = $query->result();
        }



        $module_access = array();
        $feature_access = array();
        $section_access = array();
        $section_url = array();
        foreach ($permission as $row) {
            if ($row->status == 1) {
                $module_access[$row->module_name] = true;
                $feature_access[$row->feature_name] = true;
                $section_access[$row->section_name] = true;

                $section_url[$row->section_name] = $row->url;
            } else {
                if ($module_access[$row->module_name] != true) {
                    $module_access[$row->module_name] = false;
                }
                if ($feature_access[$row->feature_name] != true) {
                    $feature_access[$row->feature_name] = false;
                }
                if ($section_access[$row->section_name] != true) {
                    $section_access[$row->section_name] = false;
                }
            }
        }

        $this->session->set_userdata(['modules' => $module_access, 'feature' => $feature_access, 'section' => $section_access]);
        //echo '<pre>';

        if (isset($this->session->userdata['referred_from'])) {
            $referred_from = $this->session->userdata('referred_from');
            $this->session->set_userdata('referred_from', NULL);
            redirect($referred_from, 'refresh');
        }
        foreach ($section_access as $key => $row) {
            if ($row === true) {

                //echo $section_url[$key]; exit;
                redirect($section_url[$key]);
                exit;
            }
        }
        //exit;
        redirect('dashboard/welcome');

        
    }

    public function maintenance()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $this->load->view('maintenance');
    }






    public function ebook()
    {
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        } else {
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/ebook?fdate=' . $tdate . '&tdate=' . $fdate);
        }
        // redirect('report/ip_capa_report');

    }

    public function noaccess()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $this->load->view('noaccess', $data);
    }

    public function departmenthead()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $data['title'] = 'DEPARTMENT HEAD MAPPING';

        #------------------------------#
        $data['content'] = $this->load->view('departmenthead', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function welcome()
    {
        if (isset($this->session->userdata['user_role'])) {

            $this->session->set_userdata([
                'active_menu' => array(null)
            ]);

            $data['title'] = null;
            //  'OVERVIEW  ' . '<small class="align-items:center;"><a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This page provides a quick overview of all the key patient experience metrics derived from each module. Please visit individual  dashboard to view detailed analytics and reports."><i class="fa fa-info-circle" aria-hidden="true"></i></a></small>';

            #------------------------------#
            $data['content'] = $this->load->view('welcome', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('logout');
        }
    }

    public function profile()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        $data['title'] = 'PROFILE';
        #------------------------------#
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->dashboard_model->profile($user_id);
        $data['content'] = $this->load->view('profile', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function company_profile()
    {
        $data['title'] = 'Company Profile';
        #------------------------------#
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->dashboard_model->profile($user_id);
        $data['content'] = $this->load->view('company_profile', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function email_check($email, $user_id)
    {
        $emailExists = $this->db->select('email')
            ->where('email', $email)
            ->where_not_in('user_id', $user_id)
            ->get('user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }


    public function form()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        $data['title'] = 'MANAGE YOUR PROFILE';
        $user_id = $this->session->userdata('user_id');
        #-------------------------------#
        $this->form_validation->set_rules('firstname', display('first_name'), 'required|max_length[50]');
        //$this->form_validation->set_rules('lastname', display('last_name'),'required|max_length[50]');

        //$this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");
        $this->form_validation->set_rules('email', display('email'), "required|max_length[50]|valid_email");

        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5');

        $this->form_validation->set_rules('phone', display('phone'), 'max_length[20]');
        $this->form_validation->set_rules('mobile', display('mobile'), 'required|max_length[20]');
        $this->form_validation->set_rules('blood_group', display('blood_group'), 'max_length[10]');
        $this->form_validation->set_rules('sex', display('sex'), 'required|max_length[10]');
        $this->form_validation->set_rules('date_of_birth', display('date_of_birth'), 'max_length[10]');
        //$this->form_validation->set_rules('address',display('address'),'required|max_length[255]');
        $this->form_validation->set_rules('status', display('status'), 'required');
        #-------------------------------#
        //picture upload
        $picture = $this->fileupload->do_upload(
            'assets/images/doctor/',
            'picture'
        );
        // if picture is uploaded then resize the picture
        if ($picture !== false && $picture != null) {
            $this->fileupload->do_resize(
                $picture,
                293,
                350
            );
        }
        //if picture is not uploaded
        if ($picture === false) {
            $this->session->set_flashdata('exception', display('invalid_picture'));
        }
        #-------------------------------#
        $data['doctor'] = (object) $postData = [
            'user_id' => $this->input->post('user_id', true),
            'firstname' => $this->input->post('firstname', true),
            'lastname' => '',
            'designation' => $this->input->post('designation', true),
            'department_id' => $this->input->post('department_id', true),
            'address' => $this->input->post('address', true),
            'phone' => $this->input->post('phone', true),
            'mobile' => $this->input->post('mobile', true),
            'email' => $this->input->post('email', true),
            'password' => md5($this->input->post('password', true)),
            'short_biography' => $this->input->post('short_biography', true),
            'picture' => (!empty($picture) ? $picture : $this->input->post('old_picture')),
            'specialist' => $this->input->post('specialist', true),
            'date_of_birth' => date('Y-m-d', strtotime($this->input->post('date_of_birth', true))),
            'sex' => $this->input->post('sex', true),
            'blood_group' => $this->input->post('blood_group', true),
            'altmobile' => $this->input->post('altmobile', true),
            'degree' => $this->input->post('degree', true),
            'created_by' => $this->session->userdata('user_id'),
            'create_date' => date('Y-m-d'),
            'status' => $this->input->post('status', true),
        ];
        #-------------------------------#

        if ($this->form_validation->run() === true) {

            if ($this->dashboard_model->update($postData)) {
                #set success message
                $this->session->set_flashdata('message', display('update_successfully'));
            } else {
                #set exception message
                $this->session->set_flashdata('exception', display('please_try_again'));
            }

            //update profile picture
            if ($postData['user_id'] == $this->session->userdata('user_id')) {
                $this->session->set_userdata([
                    'picture' => $postData['picture'],
                    'fullname' => $postData['firstname'] . ' ' . $postData['lastname']
                ]);
            }

            redirect('dashboard/form/');
        } else {

            $user_id = $this->session->userdata('user_id');
            $data['doctor'] = $this->dashboard_model->profile($user_id);
            $data['content'] = $this->load->view('profile_form', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }




    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function swithc()
    {
        $_SESSION['ward'] = 'ALL';
        $fdate = date('Y-m-d', time());
        $tdate = date('Y-m-d', strtotime('-90 days'));
        $_SESSION['from_date'] = $fdate;
        $_SESSION['to_date'] = $tdate;

        if ($this->input->get('type') == 1) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1,
            ]);
            $this->redirectTo(1);
        } elseif ($this->input->get('type') == 2) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1,

            ]);
            $this->redirectTo(2);
        } elseif ($this->input->get('type') == 3) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1,
            ]);
            $this->redirectTo(3);
        } elseif ($this->input->get('type') == 4) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(4);
        } elseif ($this->input->get('type') == 5) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(5);
        } elseif ($this->input->get('type') == 6) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(6);
        } elseif ($this->input->get('type') == 7) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(7);
        } elseif ($this->input->get('type') == 8) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(8);
        } elseif ($this->input->get('type') == 9) {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1
            ]);
            $this->redirectTo(10);
        } else {
            $this->session->set_userdata([
                'isLogIn' => true,
                'useraccess' => 1,

            ]);
            $this->redirectTo(9);
        }

        exit;
    }
     public function loginapi()
    {
        $this->output->set_content_type('application/json');

        try {
            // Get raw JSON input
            $rawInput = $this->input->raw_input_stream;
            $inputData = json_decode($rawInput, true); // true = associative array

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->output->set_output(json_encode([
                    'status' => false,
                    'message' => 'Invalid JSON format'
                ]));
            }

            $userid = isset($inputData['userid']) ? trim($inputData['userid']) : null;

            if (!empty($userid)) {
                $check_user = $this->dashboard_model->check_user_api($userid);
            } else {
                // Manual validation
                $errors = [];
                if (empty($inputData['email']) || !filter_var($inputData['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Valid Email is required';
                }

                if (empty($inputData['password'])) {
                    $errors['password'] = 'Password is required';
                }

                if (!empty($errors)) {
                    return $this->output->set_output(json_encode([
                        'status' => false,
                        'message' => 'Validation failed',
                        'errors' => $errors
                    ]));
                }

                $postData = [
                    'email' => $inputData['email'],
                    'password' => md5($inputData['password']),
                    'user_role' => isset($inputData['user_role']) ? $inputData['user_role'] : null
                ];

                $check_user = $this->dashboard_model->check_user($postData);
            }

            if ($check_user && $check_user->num_rows() === 1) {
                $user = $check_user->row();

                $setting = $this->setting_model->read();
                $department = json_decode($user->department, true);
                $departmentpermission = json_decode($user->departmentpermission);
                $floor_ward = json_decode($user->floor_ward);
                $floor_ward_esr = json_decode($user->floor_ward_esr);
                $floor_asset = json_decode($user->floor_asset);

                // Build question array
                $question_array = [];
                foreach ($department as $key => $deprow) {
                    foreach ($deprow as $set) {
                        $set_array = explode(',', $set);
                        foreach ($set_array as $r) {
                            $question_array[$key][] = $r;
                        }
                    }
                }

                // Prepare session data
                $session_data = [
                    'isLogIn' => true,
                    'user_id' => (!empty($postData['user_role']) && $postData['user_role'] == 10) ? $user->id : $user->user_id,
                    'patient_id' => (!empty($postData['user_role']) && $postData['user_role'] == 10) ? $user->patient_id : null,
                    'email' => $user->email,
                    'fullname' => $user->firstname,
                    'user_role' => $user->user_role,
                    'user_role_name' => $user->lastname,
                    'picture' => $user->picture,
                    'departmenthead' => $departmentpermission,
                    'floor_ward' => $floor_ward,
                    'floor_ward_esr' => $floor_ward_esr,
                    'floor_asset' => $floor_asset,
                    'department_access' => $department,
                    'question_array' => $question_array,
                    'title' => $setting->title ?? null,
                    'address' => $setting->description ?? null,
                    'logo' => $setting->logo ?? null,
                    'favicon' => $setting->favicon ?? null,
                    'footer_text' => $setting->footer_text ?? null,
                ];

                // Optional: store in session
                $this->session->set_userdata($session_data);

                return $this->output->set_output(json_encode([
                    'status' => true,
                    'message' => 'Login successful',
                    'data' => $session_data,
                ]));
            } else {
                return $this->output->set_output(json_encode([
                    'status' => false,
                    'message' => 'Invalid credentials or user not found',
                ]));
            }

        } catch (Exception $e) {
            return $this->output->set_output(json_encode([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ]));
        }
    }
}
