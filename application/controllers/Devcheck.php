<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Devcheck extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();

        $this->load->library('session');

        $dates = get_from_to_date();

        $this->load->model(array(

            'dashboard_model',
            'efeedor_model',
            'ipd_model',
            'opf_model',
            'pc_model',
            'isr_model',
            'incident_model',
            'grievance_model',
            'admissionfeedback_model',
            'ticketsadf_model', //1
            'tickets_model', //2
            'ticketsint_model',
            'ticketsop_model',
            'ticketsesr_model', // 5 
            'ticketsgrievance_model',  //  6
            'ticketsincidents_model', 
            'setting_model'

        ));

        if ($this->session->userdata('isLogIn') === false)

            redirect('login');

    

        

    }



    function index()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        // if ($this->session->userdata('user_role') <= 2) {

        $data['title'] = 'Hello, ' . $this->session->userdata['fullname'] . ' !';

        
        // $this->load->view('zdeveloper/dev_mainwrapper');
        $data['content']  = $this->load->view('zdeveloper/check');

    }

    // }







    public function exportdatabase()

    {

        // Load the database and utilities library

        $this->load->database();

        $this->load->dbutil();



        // Backup your entire database or specific tables

        $backup = $this->dbutil->backup();



        // Load the download helper and send the file to your desktop

        $this->load->helper('download');

        force_download('Databasebackup.gz', $backup);

    }





    function devhome()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        $data['title'] = 'Hello, ' . $this->session->userdata['fullname'] . ' !';

        #------------------------------#



        $data['content']  = $this->load->view('zdeveloper/dev_index', $data, true); // for page content

        $this->load->view('zdeveloper/dev_mainwrapper', $data); // layout (side nav and top nav)



    }

    function ipquestions()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        $data['title'] = 'IP Question';

        #------------------------------#

        $data['content']  = $this->load->view('ipmodules/ipquestions', $data, true); // for page content

        $this->load->view('layout/main_wrapper', $data); // layout (side nav and top nav)



    }

    function opquestions()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        $data['title'] = 'OP Question';

        #------------------------------#

        $data['content']  = $this->load->view('opmodules/opquestions', $data, true); // for page content

        $this->load->view('layout/main_wrapper', $data); // layout (side nav and top nav)



    }

    function pcquestions()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        $data['title'] = 'PC Question';

        #------------------------------#

        $data['content']  = $this->load->view('complaintsmodules/pcquestions', $data, true); // for page content

        $this->load->view('layout/main_wrapper', $data); // layout (side nav and top nav)



    }







    function setupip()

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

        echo 'Done';

        //echo json_encode($set);

        exit;

    }

    function setupdoctor()

    {

        $this->db->where('type', 'doctor');

        $this->db->delete('department');



        // $this->db->where('parent', 1);

        $this->db->order_by('id');

        $query = $this->db->get('setup_doctor');

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

                'type' => 'doctor',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }


    function setupdoctoropd()
    {

        $this->db->where('type', 'doctoropd');

        $this->db->delete('department');



        // $this->db->where('parent', 1);

        $this->db->order_by('id');

        $query = $this->db->get('setup_doctor_opd');

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

                'type' => 'doctoropd',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }

    function setuppdf()

    {
        
        $this->db->where('type', 'pdf');

        $this->db->delete('department');



        // $this->db->where('parent', 1);

        $this->db->order_by('id');

        $query = $this->db->get('setup_pdf');

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

                'type' => 'pdf',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }



    function setupop()

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

        echo 'Done';

        //echo json_encode($set);

        exit;

    }



    function setupinterim()
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

        echo 'Done';

        //echo json_encode($set);

        exit;

    }

    function setupsocial()
    {
        
        $this->db->where('type', 'social');

        $this->db->delete('department');

        $this->db->order_by('id');

        $query = $this->db->get('setup_social');

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

                'type' => 'social',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }


    function setupadf()
    {
        exit;
        $this->db->where('type', 'adf');

        $this->db->delete('department');

        $this->db->order_by('id');

        $query = $this->db->get('setup_adf');

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

                'type' => 'adf',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }
    function setupincident()
    {
        
        $this->db->where('type', 'incident');

        $this->db->delete('department');

        $this->db->order_by('id');

        $query = $this->db->get('setup_incident');

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

                'type' => 'incident',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }
    function setupgrievance()
    {
        
        $this->db->where('type', 'grievance');

        $this->db->delete('department');

        $this->db->order_by('id');

        $query = $this->db->get('setup_grievance');

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

                'type' => 'grievance',

            );

            $this->db->insert('department', $ipd);

        }

        echo 'Done';

        //echo json_encode($set);

        exit;

    }

    function setupesr()
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

        echo 'Done';

        // echo json_encode($set);

        exit;

    }



    // function truncatedeparment()

    // {

    // 	$this->db->truncate('department');

    // 	echo 'Done';

    // 	exit;

    // }





    // function resetuser()

    // {



    // 	$this->db->where('user_role', '4');

    // 	$this->db->delete('user');

    // 	echo 'Done';

    // 	exit;

    // }



}

