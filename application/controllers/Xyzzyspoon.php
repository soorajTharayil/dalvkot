<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Xyzzyspoon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $dates = get_from_to_date();
        $this->load->model(array(
            'dashboard_model',
            'efeedor_model',
            'ticketsint_model',
            'tickets_model',
            'ticketsop_model',
            'setting_model'
        ));

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        // if ($this->session->userdata('isLogIn') == true)
        // redirect('logout');

        if ($this->session->userdata['user_role'] != 0)
            redirect('logout');
    }

    function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if ($this->session->userdata('user_role') <= 2) {
            $data['title'] = 'Hello, ' . $this->session->userdata['fullname'] . ' !';
            $data['content']  = $this->load->view('zdeveloper/kill', $data);
        }
    }


    function panzerIP()
    {
        $this->setupip();

        $this->db->truncate('bf_feedback');
        $this->db->truncate('bf_patient');
        $this->db->truncate('tickets');
        $this->db->truncate('ticket_message');
        echo 'Feedback Table cleared';
        echo '<br>';
        echo 'Patient Table cleared';
        echo '<br>';
        echo 'Tickets Table cleared';
        echo '<br>';
        echo 'CAPA Table cleared';
        echo '<br>';
    }

    function panzerOP()
    {
        $this->setupop();
        $this->db->truncate('bf_outfeedback');
        $this->db->truncate('bf_opatient');
        $this->db->truncate('ticketsop');
        $this->db->truncate('ticketop_message');
        echo 'Feedback Table cleared';
        echo '<br>';
        echo 'Patient Table cleared';
        echo '<br>';
        echo 'Tickets Table cleared';
        echo '<br>';
        echo 'CAPA Table cleared';
        echo '<br>';
    }

    function panzerPC()
    {
        $this->setuppc();
        $this->db->truncate('bf_feedback_int');
        $this->db->truncate('bf_patient');
        $this->db->truncate('tickets_int');
        $this->db->truncate('ticket_int_message');
        echo 'Feedback Table cleared';
        echo '<br>';
        echo 'Patient Table cleared';
        echo '<br>';
        echo 'Tickets Table cleared';
        echo '<br>';
        echo 'CAPA Table cleared';
        echo '<br>';
    }

    function panzerESR()
    {
        $this->setupesr();
        $this->db->truncate('bf_feedback_esr');
        $this->db->truncate('bf_employees_esr');
        $this->db->truncate('healthcare_employees');
        $this->db->truncate('tickets_esr');
        $this->db->truncate('ticket_esr_message');
        echo 'Feedback Table cleared';
        echo '<br>';
        echo 'Employee Table cleared';
        echo '<br>';
        echo 'Tickets Table cleared';
        echo '<br>';
        echo 'CAPA Table cleared';
        echo '<br>';
        echo 'Employees added from hospital Table cleared';
        echo '<br>';
    }


    function userclr()
    {
        $this->db->truncate('user');
        $this->adduser();
    }


    private function adduser()
    {
        echo '<br>';

        echo 'User table set to default with developer and superadmin accounts';
        echo '<br>';
        $keys = [
            'user_id', 'firstname', 'lastname', 'email', 'password', 'user_role', 'designation', 'department_id',
            'address', 'phone', 'mobile', 'short_biography', 'picture', 'specialist', 'date_of_birth', 'sex',
            'blood_group', 'degree', 'created_by', 'create_date', 'update_date', 'status', 'altmobile', 'departmentpermission'
        ];
        $values = [
            [
                1, 'Developer', NULL, 'developer@efeedor.com', 'c6989f06490c4012ede31df60ef3bb25', 0, NULL, NULL, 'Bangalore', NULL, '9900040236', NULL, 'assets/images/doctor/2023-04-11/d.jpg', NULL, '1998-10-30', 'Male', NULL, NULL, 1, '2023-04-19', NULL, 1, NULL, '{"ids":"0","name":"Developer","email":"developer@efeedor.com","mobile":"9900040236","password":"admin123","userrole":"Efeedor","ippermission":"1","oppermission":"1","inpermission":"1","esrpermission":"1","user_role":"0"}'
            ],
            [
                2, 'Super admin', '', 'demo@efeedor.com', '0192023a7bbd73250516f069df18b500', 2, NULL, NULL, 'Bangalore', NULL, '9562812784', NULL, 'assets/images/doctor/2023-08-10/e.png', NULL, '1970-01-01', 'Male', NULL, NULL, 2, '2023-08-16', NULL, 1, NULL, '{"ids":"2","name":"Super admin","email":"demo@efeedor.com","mobile":"9562812784","password":"admin123","userrole":"SuperAdmin","user_role":"2","message_ticket_ip":"1","inweeklyreport_ip":"1","weeklyipticketreport_ip":"1","weeklynpsscore_ip":"1","weeklyiphospitalselection_ip":"1","weeklyinsighthighlow_ip":"1","weeklyratinganalysis_ip":"1","inmonthlyreport_ip":"1","montlyipticketreport_ip":"1","monthlynpsscore_ip":"1","montylyiphospitalselection_ip":"1","monthlyinsighthighlow_ip":"1","monthlyratinganalysis_ip":"1","message_ticket_op":"1","inweeklyreport_op":"1","weeklyipticketreport_op":"1","weeklynpsscore_op":"1","weeklyiphospitalselection_op":"1","weeklyinsighthighlow_op":"1","weeklyratinganalysis_op":"1","inmonthlyreport_op":"1","montlyipticketreport_op":"1","monthlynpsscore_op":"1","montylyiphospitalselection_op":"1","monthlyinsighthighlow_op":"1","monthlyratinganalysis_op":"1","message_ticket_int":"1","ippermission":"1","oppermission":"1","inpermission":"1"}'
            ]
        ];

        $data = array_map(function ($value) use ($keys) {
            return array_combine($keys, $value);
        }, $values);

        foreach ($data as $record) {
            $this->db->insert('user', $record);
        }
    }


    function bigbang()
    {
        $this->panzerIP();
        $this->panzerOP();
        $this->panzerPC();
        $this->panzerESR();
        $this->userclr();
        $this->panzerdep();
        echo '<br>';
        echo 'BIG BANG';
        exit;
    }


    private function panzerdep()
    {
        $this->setupip();
        $this->setupop();
        $this->setuppc();
        $this->setupesr();
    }

    private  function setupip()
    {
        $this->db->where('type', 'inpatient');
        $this->db->delete('department');

        // $this->db->where('parent', 1);
        $this->db->order_by('id');
        $query = $this->db->get('setup');
        $result = $query->result();

        $set = array();
        $i = 0;
        foreach ($result as $r) {
            $ipd = array(
                'name' => $r->shortname,
                'description' => $r->title,
                'status' => 1,
                'slug' => $r->shortkey,
                'setkey' => $r->type,
                'type' => 'inpatient',
            );
            $this->db->insert('department', $ipd);
        }
        echo 'Department table IP reset';
        echo '<br>';
    }


    private  function setupop()
    {
        $this->db->where('type', 'outpatient');
        $this->db->delete('department');

        $this->db->order_by('id');
        $query = $this->db->get('setupop');
        $result = $query->result();
        $set = array();
        $i = 0;
        foreach ($result as $r) {
            $ipd = array(
                'name' => $r->shortname,
                'description' => $r->title,
                'status' => 1,
                'setkey' => $r->type,
                'slug' => $r->shortkey,
                'type' => 'outpatient',
            );
            $this->db->insert('department', $ipd);
        }
        echo 'Department table OP reset';
        echo '<br>';
    }

    private  function setuppc()
    {
        $this->db->where('type', 'interim');
        $this->db->delete('department');

        $this->db->order_by('id');
        $query = $this->db->get('setup_int');
        $result = $query->result();
        $set = array();
        $i = 0;
        foreach ($result as $r) {
            $ipd = array(
                'name' => $r->shortname,
                'description' => $r->title,
                'status' => 1,
                'setkey' => $r->type,
                'slug' => $r->shortkey,
                'type' => 'interim',
            );
            $this->db->insert('department', $ipd);
        }
        echo 'Department table Interim reset';
        echo '<br>';
    }

    private  function setupesr()
    {
        $this->db->where('type', 'esr');
        $this->db->delete('department');

        $this->db->order_by('id');
        $query = $this->db->get('setup_esr');
        $result = $query->result();
        $set = array();
        $i = 0;
        foreach ($result as $r) {
            $ipd = array(
                'name' => $r->shortname,
                'description' => $r->title,
                'status' => 1,
                'setkey' => $r->type,
                'slug' => $r->shortkey,
                'type' => 'esr',
            );
            $this->db->insert('department', $ipd);
        }
        echo 'Department table ESR reset';
        echo '<br>';
    }
}
