<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quality extends CI_Controller
{
    private $module;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if ($this->session->userdata('isLogIn') === false && $this->uri->segment(2) != 'track')
            redirect('login');

        $this->load->model(
            array(
                'dashboard_model',
                'efeedor_model',
                'tickets_model',
                'quality_model',
                'setting_model',
                'departmenthead_model',
            )
        );

        // $dates = get_from_to_date();
        if (isset($_SESSION['from_date']) && isset($_SESSION['to_date'])) {
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
        } else {
            $fdate = date('Y-m-d', time());
            $tdate = date('Y-m-d', strtotime('-365 days'));
            $_SESSION['from_date'] = $fdate;
            $_SESSION['to_date'] = $tdate;
        }
        $this->module = 'inpatient_modules';

        $this->session->set_userdata([
            'active_menu' => array('ip_dashboard', 'ip_ticket', 'ip_reports', 'ip_patients', 'ip_settings', 'ip_dep', 'ip_analysis'),
        ]);

        if (ismodule_active('IP') === false && $this->uri->segment(2) != 'track')
            redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('IP') === true) {

            $data['title'] = 'IP MODULE CONFIGURATION';
            $data['content'] = $this->load->view('qualitymodules/developer', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function edit_feedback_PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_1PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';

            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_1PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_1PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_2PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_2PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_2PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_3PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_3PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_3PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_4PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_4PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_4PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_5PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_5PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_5PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_6PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_6PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_6PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_7PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_7PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_7PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_8PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_8PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_8PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_9PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_9PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_9PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_10PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_10PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_10PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_11PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_11PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_11PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_12PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_12PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_12PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_13PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_13PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_13PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_14PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_14PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_14PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_15PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_15PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_15PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_16PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_16PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_16PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_17PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_17PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_17PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_18PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_18PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_18PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_19PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_19PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_19PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_20PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_20PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_20PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_21PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_21PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_21PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_21aPSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_21aPSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_21aPSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_22PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_22PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_22PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_23PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_23PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_23PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_23aPSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_23aPSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_23aPSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_23bPSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_23bPSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_23bPSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_23cPSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_23cPSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_23cPSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_23dPSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_23dPSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_23dPSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_24PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_24PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_24PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_25PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_25PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_25PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_26PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_26PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_26PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_27PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_27PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_27PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_28PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_28PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_28PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_29PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_29PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_29PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_30PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_30PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_30PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_31PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_31PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_31PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_32PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_32PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_32PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_33PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_33PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_33PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_33PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_33PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_33PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_33PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_33PSQ3a', $data);
        }
    }


    public function edit_feedback_34PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_34PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_34PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_34PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_34PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_34PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_34PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_34PSQ3a', $data);
        }
    }

    public function edit_feedback_35PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_35PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_35PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_35PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_35PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_35PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_35PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_35PSQ3a', $data);
        }
    }


    public function edit_feedback_36PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_36PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_36PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_36PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_36PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_36PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_36PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_36PSQ3a', $data);
        }
    }


    public function edit_feedback_37PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_37PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_37PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_37PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_37PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_37PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_37PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_37PSQ3a', $data);
        }
    }


    public function edit_feedback_38PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_38PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_38PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_38PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_38PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_38PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_38PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_38PSQ3a', $data);
        }
    }


    public function edit_feedback_39PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_39PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_39PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_39PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_39PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_39PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_39PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_39PSQ3a', $data);
        }
    }


    public function edit_feedback_40PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_40PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_40PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_40PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_40PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_40PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_40PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_40PSQ3a', $data);
        }
    }


    public function edit_feedback_41PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_41PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_41PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_41PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_41PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_41PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_41PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_41PSQ3a', $data);
        }
    }


    public function edit_feedback_42PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_42PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_42PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_42PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_42PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_42PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_42PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_42PSQ3a', $data);
        }
    }


    public function edit_feedback_43PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_43PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_43PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_43PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_43PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_43PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_43PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_43PSQ3a', $data);
        }
    }


    public function edit_feedback_44PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_44PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_44PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_44PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_44PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_44PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_44PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_44PSQ3a', $data);
        }
    }


    public function edit_feedback_45PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_45PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_45PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_45PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_45PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_45PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_45PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_45PSQ3a', $data);
        }
    }


    public function edit_feedback_46PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_46PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_46PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_46PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_46PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_46PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_46PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_46PSQ3a', $data);
        }
    }


    public function edit_feedback_47PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_47PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_47PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_47PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_47PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_47PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_47PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_47PSQ3a', $data);
        }
    }


    public function edit_feedback_48PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_48PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_48PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_48PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_48PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_48PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_48PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_48PSQ3a', $data);
        }
    }


    public function edit_feedback_49PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_49PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_49PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_49PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_49PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_49PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_49PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_49PSQ3a', $data);
        }
    }


    public function edit_feedback_50PSQ3a()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT KPI FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('qualitymodules/edit_feedback_50PSQ3a', $data, true);
            } else {
                $data['content'] = $this->load->view('qualitymodules/dephead/edit_feedback_50PSQ3a', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_feedback_50PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_50PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_50PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_50PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_50PSQ3a', $data);
        }
    }


    

    public function edit_feedback_PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_readmissions_icu' => $this->input->post('initial_assessment_hr'),
                'no_of_admissions' => $this->input->post('total_admission'),
                'readmission_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_PSQ3a', $data);
        }
    }


    public function edit_feedback_1PSQ3a_byid($id)
    {


        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the hour, minute, and second values from the form input
            $hr = intval($this->input->post('initial_assessment_hr')) ?: 0;
            $min = intval($this->input->post('initial_assessment_min')) ?: 0;
            $sec = intval($this->input->post('initial_assessment_sec')) ?: 0;

            // Format hr, min, and sec into the desired string format "HH:MM:SS"
            $timeString = sprintf('%02d:%02d:%02d', $hr, $min, $sec);

            // Capture other form data
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'time_taken_initial_assessment' => $timeString,
                'number_of_admission' => $this->input->post('total_admission'),
                'average_time_taken_initial_assessment' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_1PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_1PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_1PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_1PSQ3a', $data);
        }
    }
    public function edit_feedback_2PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'reporting_errors' => $this->input->post('initial_assessment_hr'),
                'number_of_test_performed' => $this->input->post('total_admission'),
                'average_no_of_reporting_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_2PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_2PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_2PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_2PSQ3a', $data);
        }
    }
    public function edit_feedback_3PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_staff_adher_safety' => $this->input->post('initial_assessment_hr'),
                'number_of_staff_audited' => $this->input->post('total_admission'),
                'percentage_safety_precatutions' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_3PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_3PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_3PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_3PSQ3a', $data);
        }
    }

    public function edit_feedback_4PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_medication_errors' => $this->input->post('initial_assessment_hr'),
                'no_opportunity_errors' => $this->input->post('total_admission'),
                'percentage_medication_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_4PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_4PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_4PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_4PSQ3a', $data);
        }
    }

    public function edit_feedback_5PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_medication_chart_errors' => $this->input->post('initial_assessment_hr'),
                'no_chart_reviewed' => $this->input->post('total_admission'),
                'percentage_medication_chart_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_5PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_5PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_5PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_5PSQ3a', $data);
        }
    }

    public function edit_feedback_6PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_adverse_drug_reaction' => $this->input->post('initial_assessment_hr'),
                'no_inpatients' => $this->input->post('total_admission'),
                'percentage_of_adverse_drug_reaction' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_6PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_6PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_6PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_6PSQ3a', $data);
        }
    }
    public function edit_feedback_7PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_unplanned_return_ot' => $this->input->post('initial_assessment_hr'),
                'no_patients_in_ot' => $this->input->post('total_admission'),
                'percentage_of_unplanned_return_ot' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_7PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_7PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_7PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_7PSQ3a', $data);
        }
    }

    public function edit_feedback_8PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'surgery_procedure_followed' => $this->input->post('initial_assessment_hr'),
                'no_surgery_performed' => $this->input->post('total_admission'),
                'percentage_of_surgery_adherence' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_8PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_8PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_8PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_8PSQ3a', $data);
        }
    }

    public function edit_feedback_9PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_transfusion_reactions' => $this->input->post('initial_assessment_hr'),
                'no_units_transfused' => $this->input->post('total_admission'),
                'percentage_of_transfusion_reactions' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_9PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_9PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_9PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_9PSQ3a', $data);
        }
    }

    public function edit_feedback_10PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_10PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_10PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_10PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_10PSQ3a', $data);
        }
    }

    public function edit_feedback_11PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'return_to_emergency' => $this->input->post('initial_assessment_hr'),
                'no_of_patients_emergency' => $this->input->post('total_admission'),
                'percentage_of_return' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_11PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_11PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_11PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_11PSQ3a', $data);
        }
    }
    public function edit_feedback_12PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_pressure_ulcer' => $this->input->post('initial_assessment_hr'),
                'no_of_patient_days' => $this->input->post('total_admission'),
                'incidence_of_pressure_ulcer' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_12PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_12PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_12PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_12PSQ3a', $data);
        }
    }

    public function edit_feedback_13PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_urinary_tract_infection' => $this->input->post('initial_assessment_hr'),
                'no_of_urinary_catheter_days' => $this->input->post('total_admission'),
                'urinary_tract_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_13PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_13PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_13PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_13PSQ3a', $data);
        }
    }

    public function edit_feedback_14PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_pneumonia' => $this->input->post('initial_assessment_hr'),
                'no_ventilator_days' => $this->input->post('total_admission'),
                'ventilator_pneumonia_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_14PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_14PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_14PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_14PSQ3a', $data);
        }
    }

    public function edit_feedback_15PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_blood_stream_infection' => $this->input->post('initial_assessment_hr'),
                'no_central_line_days' => $this->input->post('total_admission'),
                'blood_stream_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_15PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_15PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_15PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_15PSQ3a', $data);
        }
    }

    public function edit_feedback_16PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_surgical_infection' => $this->input->post('initial_assessment_hr'),
                'no_of_surgery_perform' => $this->input->post('total_admission'),
                'surgical_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_16PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_16PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_16PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_16PSQ3a', $data);
        }
    }

    public function edit_feedback_17PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_hygiene_action' => $this->input->post('initial_assessment_hr'),
                'no_of_hygiene_oppurtunities' => $this->input->post('total_admission'),
                'hygiene_compliance_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_17PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_17PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_17PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_17PSQ3a', $data);
        }
    }

    public function edit_feedback_18PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_receive_prophylactic' => $this->input->post('initial_assessment_hr'),
                'no_of_underwent_surgery' => $this->input->post('total_admission'),
                'prophylactic_percentage' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_18PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_18PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_18PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_18PSQ3a', $data);
        }
    }


    public function edit_feedback_19PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_reschedule' => $this->input->post('initial_assessment_hr'),
                'no_of_surgery_planned' => $this->input->post('total_admission'),
                'percentage_of_reschedule' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_19PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_19PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_19PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_19PSQ3a', $data);
        }
    }

    public function edit_feedback_20PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_time_taken' => $this->input->post('initial_assessment_hr'),
                'no_of_blood_crossmatched' => $this->input->post('total_admission'),
                'average_turn_around_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_20PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_20PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_20PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_20PSQ3a', $data);
        }
    }

    public function edit_feedback_21PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_nursing_staff' => $this->input->post('initial_assessment_hr'),
                'no_of_beds' => $this->input->post('total_admission'),
                'nurse_patients_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_21PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_21PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_21PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_21PSQ3a', $data);
        }
    }

    public function edit_feedback_21aPSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_nursing_staff' => $this->input->post('initial_assessment_hr'),
                'no_of_beds' => $this->input->post('total_admission'),
                'nurse_patients_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_21aPSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_21aPSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_21aPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_21aPSQ3a', $data);
        }
    }

    public function edit_feedback_22PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_consultation_time' => $this->input->post('initial_assessment_hr'),
                'no_of_outpatients' => $this->input->post('total_admission'),
                'avg_consultation_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_22PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_22PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_22PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_22PSQ3a', $data);
        }
    }

    public function edit_feedback_23aPSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'lab_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_23aPSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_23aPSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_23aPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23aPSQ3a', $data);
        }
    }

    public function edit_feedback_23bPSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'xray_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_23bPSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_23bPSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_23bPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23bPSQ3a', $data);
        }
    }
    public function edit_feedback_23cPSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'usg_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_23cPSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_23cPSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_23cPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23cPSQ3a', $data);
        }
    }

    public function edit_feedback_23dPSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'ctscan_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_23dPSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_23dPSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_23dPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23dPSQ3a', $data);
        }
    }

    public function edit_feedback_24PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the hour, minute, and second values from the form input
            $hr = intval($this->input->post('initial_assessment_hr')) ?: 0;
            $min = intval($this->input->post('initial_assessment_min')) ?: 0;
            $sec = intval($this->input->post('initial_assessment_sec')) ?: 0;

            // Capture the hour, minute, and second values from the form input
            $hr2 = intval($this->input->post('initial_assessment_hr2')) ?: 0;
            $min2 = intval($this->input->post('initial_assessment_min2')) ?: 0;
            $sec2 = intval($this->input->post('initial_assessment_sec2')) ?: 0;

            // Capture the hour, minute, and second values from the form input
            $hr3 = intval($this->input->post('initial_assessment_hr3')) ?: 0;
            $min3 = intval($this->input->post('initial_assessment_min3')) ?: 0;
            $sec3 = intval($this->input->post('initial_assessment_sec3')) ?: 0;


            // Format hr, min, and sec into the desired string format "HH:MM:SS"
            $timeString = sprintf('%02d:%02d:%02d', $hr, $min, $sec);
            $timeString2 = sprintf('%02d:%02d:%02d', $hr2, $min2, $sec2);
            $timeString3 = sprintf('%02d:%02d:%02d', $hr3, $min3, $sec3);


            // Capture other form data
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(

                'sum_of_discharge_time' =>  $timeString,
                'no_of_patients_discharged' => $this->input->post('total_admission'),
                'avg_discharge_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'excess_time_taken' => $this->input->post('excessTimeText'),


                'sum_of_discharge_time_ins' =>  $timeString2,
                'no_of_patients_discharged_ins' => $this->input->post('total_admission2'),
                'avg_discharge_time_ins' => $this->input->post('calculatedResult2'),
                'bench_mark_time_ins' => $this->input->post('benchmark2'),
                'excess_time_taken_ins' => $this->input->post('excessTimeText2'),

                'sum_of_discharge_time_cop' =>  $timeString3,
                'no_of_patients_discharged_cop' => $this->input->post('total_admission3'),
                'avg_discharge_time_cop' => $this->input->post('calculatedResult3'),
                'bench_mark_time_cop' => $this->input->post('benchmark3'),
                'excess_time_taken_cop' => $this->input->post('excessTimeText3'),

                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_24PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_24PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_24PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_24PSQ3a', $data);
        }
    }


    public function edit_feedback_25PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_incomplete_medical_records' => $this->input->post('initial_assessment_hr'),
                'no_of_discharge' => $this->input->post('total_admission'),
                'percentage_of_medical_records' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_25PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_25PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_25PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_25PSQ3a', $data);
        }
    }
    public function edit_feedback_26PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'emergency_drugs_stock' => $this->input->post('initial_assessment_hr'),
                'no_listed_emergency_drugs' => $this->input->post('total_admission'),
                'percentage_stock_out_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_26PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_26PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_26PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_26PSQ3a', $data);
        }
    }


    public function edit_feedback_27PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_variations' => $this->input->post('initial_assessment_hr'),
                'no_of_variations_opportunities' => $this->input->post('total_admission'),
                'percentage_of_variations' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_27PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_27PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_27PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_27PSQ3a', $data);
        }
    }

    public function edit_feedback_28PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_patients_fall' => $this->input->post('initial_assessment_hr'),
                'no_patient_days' => $this->input->post('total_admission'),
                'patient_fall_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_28PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_28PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_28PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_28PSQ3a', $data);
        }
    }

    public function edit_feedback_29PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_near_misses' => $this->input->post('initial_assessment_hr'),
                'no_of_incident_reported' => $this->input->post('total_admission'),
                'percentage_of_near_misses' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_29PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_29PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_29PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_29PSQ3a', $data);
        }
    }

    public function edit_feedback_30PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_parenteral_exposures' => $this->input->post('initial_assessment_hr'),
                'no_patient_days' => $this->input->post('total_admission'),
                'needle_stick_injuries' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_30PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_30PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_30PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_30PSQ3a', $data);
        }
    }

    public function edit_feedback_31PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_handovers_done' => $this->input->post('initial_assessment_hr'),
                'no_of_handover_opportunities' => $this->input->post('total_admission'),
                'percentage_of_handovers' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_31PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_31PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_31PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_31PSQ3a', $data);
        }
    }

    public function edit_feedback_32PSQ3a_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'no_of_prescriptions_in_capitals' => $this->input->post('initial_assessment_hr'),
                'no_of_prescriptions' => $this->input->post('total_admission'),
                'compliance_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->quality_model->update_feedback_32PSQ3a($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('quality/patient_feedback_32PSQ3a?id=' . $id);
        } else {
            // Load the view with the form
            $data['param'] = $this->quality_model->get_feedback_32PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_32PSQ3a', $data);
        }
    }



    // SUPER ADMIN AND ADMIN LOGIN
    public function quality_welcome_page()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY INDICATOR MANAGER DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('quality_welcome_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report_PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_33PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of Beta-blocker prescription with a diagnosis of CHF with reduced EF - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_33PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_34PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes is achieved - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_34PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_35PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of Hospitalized patients with hypoglycemia who achieved targeted blood glucose level - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_35PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_36PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Spontaneous Perineal Tear Rate - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_36PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_37PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Postoperative Endophthalmitis Rate - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_37PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_38PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of patients undergoing colonoscopy who are sedated - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_38PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_39PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Bile Duct injury rate requiring operative intervention during Laparoscopic cholecystectomy - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_39PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_40PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of POCT results which led to a clinical intervention - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_40PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_41PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Functional gain following rehabilitation - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_41PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_42PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of sepsis patients who receive care as per the Hour-1 sepsis bundle - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_42PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_43PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of COPD patients receiving COPD Action plan at the time of discharge - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_43PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_44PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of stroke patients in whom the Door-to-Needle Time (DTN) of 60 minutes is achieved - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_44PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_45PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of bronchiolitis patients treated inappropriately - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_45PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_46PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of oncology patients who had treatment initiated following Multidisciplinary meeting - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_46PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_47PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of adverse reaction to radiopharmaceutical - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_47PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_48PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of Intravenous Contrast Media Extravasation - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_48PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_49PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Time taken for triage - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_49PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_50PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = 'PSQ3a- Percentage of patients undergoing dialysis who are able to achieve target hemoglobin levels - ' . $titleSuffix;
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_50PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report_1PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            //$data['title'] = '1.PSQ3a- Time taken for initial assessment of indoor patients - ' . $titleSuffix;
            $data['title'] = '1.PSQ3a- Time taken for initial assessment of indoor patients';

            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_1PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_2PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '2.PSQ3a- Number of reporting errors per 1000 investigations';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_2PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_3PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '3.PSQ3a- Percentage of adherence to safety precautions by diagnostics staffs';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_3PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_4PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '4.PSQ3a- Medication errors rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_4PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_5PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '5.PSQ3a- Percentage of medication charts with error-prone abbreviations';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_5PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_6PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s)';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_6PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_7PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '7.PSQ3a- Percentage of unplanned return to OT';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_7PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_8PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events- wrong site/wrong patient/wrong surgery have been adhered to';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_8PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_9PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '9.PSQ3a- Percentage of transfusion reactions';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_9PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_10PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '10.PSQ3a- Standardised mortality ratio for ICU';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_10PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_11PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '11.PSQ3a- Return to the emergency department within 72 hours with similar presenting complaints';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_11PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_12PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission (Bed sore per 1000 patient days)';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_12PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_13PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '13.PSQ3b- Catheter associated urinary tract infection rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_13PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_14PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '14.PSQ3b- Ventilator associated pneumonia rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_14PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_15PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '15.PSQ3b- Central line - associated blood stream infection rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_15PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_16PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '16.PSQ3b- Surgical site infection rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_16PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_17PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '17.PSQ3b- Hand hygiene compliance rate';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_17PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_18PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics within the specified timeframe';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_18PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_19PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '19.PSQ3c- Percentage of re- scheduling of surgeries';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_19PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_20PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '20.PSQ3c- Turn around time for issue of blood and blood components';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_20PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_21PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '21.PSQ3c- Nurse-patient ratio for ICUs';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_21PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_21aPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '21a.PSQ3c- Nurse-patient ratio for Wards';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_21aPSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report_22PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '22.PSQ3c - Waiting time for out- patient consultation';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_22PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_23PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '23.PSQ4c- Waiting time for diagnostics';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_23PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_23aPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '23a.PSQ4c- Waiting time for laboratory diagnostics';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_23aPSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_23bPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '23b.PSQ4c- Waiting time for X-ray diagnostics';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_23bPSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_23cPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '23c.PSQ4c- Waiting time for USG diagnostics';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_23cPSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_23dPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '23d.PSQ4c- Waiting time for CT scan diagnostics';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_23dPSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_24PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '24.PSQ4c- Time taken for discharge';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_24PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_25PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '25.PSQ4c- Percentage of medical records having incomplete and/or improper consent';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_25PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_26PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '26.PSQ4c- Stock out rate of emergency medications';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_26PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_27PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '27.PSQ4d- Number of variations observed in mock drills';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_27PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_28PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '28.PSQ4d- Patient fall rate (Falls per 1000 patient days)';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_28PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_29PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '29.PSQ4d- Percentage of near misses';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_29PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_30PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '30.PSQ3d- Incidence of needle stick injuries';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_30PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_31PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '31.PSQ3d- Appropriate handovers during shift change (To be done separately for doctors and nurses)';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_31PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function feedbacks_report_32PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $dateInfo = get_from_to_date();
            $pagetitle = $dateInfo['pagetitle'];
            $titleSuffix = "";

            if ($pagetitle === "Current Month") {
                $titleSuffix = strtoupper(date('F Y'));
            } elseif ($pagetitle === "Previous Month") {
                $titleSuffix = strtoupper(date('F Y', strtotime('-1 month')));
            } elseif ($pagetitle === "Last 365 Days") {
                $titleSuffix = "LAST 365 DAYS";
            } elseif ($pagetitle === "Last 30 Days") {
                $titleSuffix = "LAST 30 DAYS";
            } elseif ($pagetitle === "Custom") {
                $titleSuffix = date('F Y', strtotime($dateInfo['tdate'])) . " - " . date('F Y', strtotime($dateInfo['fdate']));
            } elseif ($pagetitle === "Last 24 Hours") {
                $titleSuffix = "LAST 24 HOURS";
            } elseif ($pagetitle === "Quaterly") {
                $titleSuffix = "LAST 90 DAYS";
            } else {
                $titleSuffix = $pagetitle;
            }

            $data['title'] = '32.PSQ3d- Compliance rate to medication prescription in capitals';
            $data['content']  = $this->load->view('qualitymodules/feedbacks_report_32PSQ3a', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_33PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_33PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_34PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_34PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_35PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_35PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_36PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_36PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_37PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_37PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_38PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_38PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_39PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_39PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_40PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_40PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_41PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_41PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_42PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_42PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_43PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_43PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_44PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_44PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_45PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_45PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_46PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_46PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_47PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_47PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_48PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_48PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_49PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_49PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_50PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_50PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function patient_feedback_1PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_1PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_2PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_2PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_3PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_3PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_4PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_4PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_5PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_5PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_6PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_6PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_7PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_7PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_8PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_8PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_9PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_9PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_10PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_10PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_11PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_11PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_12PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_12PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_13PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_13PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_14PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_14PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_15PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_15PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_16PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_16PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_17PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_17PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_18PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_18PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_19PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_19PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_20PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_20PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_21PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_21PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_21aPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_21aPSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function patient_feedback_22PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_22PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_23PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_23PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_23aPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_23aPSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_23bPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_23bPSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_23cPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_23cPSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_23dPSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_23dPSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_24PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_24PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_25PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_25PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_26PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_26PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_27PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_27PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_28PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_28PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_29PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_29PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function patient_feedback_30PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_30PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function patient_feedback_31PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_31PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function patient_feedback_32PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_32PSQ3a', $data, true);


            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    //END REPORTS


    public function downloadcomments()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->quality_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->quality_model->setup_result($setup);
            $setarray = array();
            $questioarray = array();
            foreach ($sresult as $r) {
                $setarray[$r->type] = $r->title;
            }
            foreach ($sresult as $r) {
                $questioarray[$r->type][$r->shortkey] = $r->shortname;
            }

            $arraydata = array();
            foreach ($questioarray as $setr) {
                foreach ($setr as $k => $v) {
                    $arraydata[$k] = $v;
                }
            }

            $header[0] = 'Date';
            $header[1] = 'Patient Name';
            $header[2] = 'Patient ID';
            $header[3] = 'Floor/Ward';
            $header[4] = 'Room/Bed';
            $header[5] = 'Mobile Number';
            $j = 6;
            $header[$j++] = 'Average Rating';
            $header[$j++] = 'NPS Score';
            $header[$j++] = 'Comments';
            foreach ($setarray as $r) {
                $header[$j] = $r;
                $j++;
            }
            $dataexport = array();
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);
                $dataexport[$i]['date'] = date('d-m-Y', strtotime($row->datetime));
                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['patient_id'] = $data['patientid'];
                $dataexport[$i]['ward'] = $data['ward'];
                $dataexport[$i]['bedno'] = $data['bedno'];
                $dataexport[$i]['mobile'] = $data['contactnumber'];
                $dataexport[$i]['overallScore'] = $data['overallScore'];
                $dataexport[$i]['recommend1Score'] = ($data['recommend1Score']) * 2;

                $dataexport[$i]['suggestionText'] = $data['suggestionText'];
                foreach ($setarray as $key => $t) {
                    if ($data['comment'][$key] != '') {
                        $dataexport[$i][$key] = $data['comment'][$key];
                    } else {
                        $dataexport[$i][$key] = '';
                    }
                }
                $i++;
            }
            $newdataset = $dataexport;
            $d = array();
            $p = array();
            $n = array();
            $para = array();
            $for5 = array();
            $for4 = array();
            $for3 = array();
            $for2 = array();
            $for1 = array();
            foreach ($dataexport as $row) {
                foreach ($row as $k => $r) {
                    if ($r * 1 > 0) {
                        $d[$k] = $d[$k] + 1;
                        if ($r > 2) {
                            $p[$k] = $p[$k] + 1;
                        } else {
                            $n[$k] = $n[$k] + 1;
                        }
                        $para[$k] = $para[$k] + $r;
                        if ($k == 'overallScore') {
                            if ($r == 5) {
                                $for5[$k] = $for5[$k] + 1;
                            }
                            if ($r == 4) {
                                $for4[$k] = $for4[$k] + 1;
                            }
                            if ($r == 3) {
                                $for3[$k] = $for3[$k] + 1;
                            }
                            if ($r == 2) {
                                $for2[$k] = $for2[$k] + 1;
                            }
                            if ($r == 1) {
                                $for1[$k] = $for1[$k] + 1;
                            }
                        }
                    }
                }
            }

            ob_end_clean();
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $fileName = 'EF- IPD PATIENT COMMENTS - ' . $tdate . ' to ' . $fdate . '.csv';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($dataexport[0])) {
                $fp = fopen('php://output', 'w');
                //print_r($header);
                fputcsv($fp, $header, ',');
                foreach ($dataexport as $values) {
                    //print_r($values); exit;
                    fputcsv($fp, $values, ',');
                }
                fclose($fp);
            }
            ob_flush();
            exit;
        } else {
            redirect('dashboard/noaccess');
        }
    }

    // IP DASHBOARD DOWNLOADS

    public function overall_excel_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $sorttime = 'asc';
            $setup = 'setup';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'inpatient';

            $ip_feedbacks_count = $this->quality_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
            $ticket_resolution_rate = $this->quality_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
            $ip_tickets_count = $this->tickets_model->alltickets();
            $ip_open_tickets = $this->tickets_model->read();
            $ip_closed_tickets = $this->tickets_model->read_close();
            $ip_addressed_tickets = $this->tickets_model->addressedtickets();

            $ip_nps = $this->quality_model->nps_analytics($table_feedback, $asc, $setup);
            $ip_psat = $this->quality_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);

            $dataexport = array();
            $i = 0;

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $dataexport[$i]['row1'] = 'IPD FEEDBACK OVERALL REPORT';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'FROM DATE';
            $dataexport[$i]['row2'] = $tdate;
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TO DATE';
            $dataexport[$i]['row2'] = $fdate;
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TOTAL FEEDBACKS SUBMITTED';
            $dataexport[$i]['row2'] = count($ip_feedbacks_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'SATISFACTION INDEX';
            $dataexport[$i]['row2'] = $ip_psat['psat_score'] . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'SATISFIED PATIENTS';
            $dataexport[$i]['row2'] =  $ip_psat['satisfied_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'UNSATISFIED PATIENTS';
            $dataexport[$i]['row2'] = $ip_psat['unsatisfied_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            //add here
            $dataexport[$i]['row1'] = 'NET PROMOTER SCORE';
            $dataexport[$i]['row2'] =  $ip_nps['nps_score'] . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF PROMOTERS';
            $dataexport[$i]['row2'] = $ip_nps['promoters_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF PASSIVES';
            $dataexport[$i]['row2'] = $ip_nps['passives_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF DETRACTORS';
            $dataexport[$i]['row2'] = $ip_nps['detractors_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'TICKETS REPORT';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TOTAL TICKETS';
            $dataexport[$i]['row2'] = count($ip_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TICKET RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;
            $dataexport[$i]['row1'] = 'OPEN TICKETS';
            $dataexport[$i]['row2'] = count($ip_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;
            if (ticket_addressal('ip_addressal') === true) {
                $dataexport[$i]['row1'] = 'ADDRESSED TICKETS';
                $dataexport[$i]['row2'] = count($ip_addressed_tickets);
                $dataexport[$i]['row3'] = '';
                $dataexport[$i]['row4'] = '';
                $i++;
            }
            $dataexport[$i]['row1'] = 'CLOSED TICKETS';
            $dataexport[$i]['row2'] = count($ip_closed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;



            $dataexport[$i]['row1'] = 'TICKETS RECEIVED BY DEPARTMENT';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = 'OPEN';
            if (ticket_addressal('ip_addressal') === true) {

                $dataexport[$i]['row5'] = 'ADDRESSED';
            }
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = 'RESOLUTION TIME';
            $dataexport[$i]['row9'] = '';
            $i++;

            $ticket = $this->quality_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
            foreach ($ticket as $ps) {
                $time = secondsToTimeforreport($ps['res_time']);
                $dataexport[$i]['row1'] = $ps['department'];
                $dataexport[$i]['row2'] = $ps['percentage'] . '%';
                $dataexport[$i]['row3'] = $ps['count'];
                $dataexport[$i]['row4'] = $ps['open_tickets'];
                if (ticket_addressal('ip_addressal') === true) {

                    $dataexport[$i]['row5'] = $ps['addressed_tickets'];
                }
                $dataexport[$i]['row6'] = $ps['closed_tickets'];
                $dataexport[$i]['row6'] = $ps['closed_tickets'];
                $dataexport[$i]['row7'] = $ps['tr_rate'] . '%';
                $dataexport[$i]['row8'] = $time;
                $dataexport[$i]['row9'] = '';
                $i++;
            }

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'WHY PATIENTS CHOSE YOUR HOSPITAL';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'REASON';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = '';
            $i++;


            $choice_of_hospitals = $this->quality_model->reason_to_choose_hospital($table_feedback, $sorttime);

            foreach ($choice_of_hospitals as $key => $object) {

                $dataexport[$i]['row1'] = $object->title;
                $dataexport[$i]['row2'] =  $object->percentage . '%';
                $dataexport[$i]['row3'] = $object->count;
                $dataexport[$i]['row4'] = '';
                $i++;
            }


            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;
            //echo '<pre>';
            //print_r($dataexport); exit; 
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF - OVERALL IPD FEEDBACKS REPORT  - ' . $tdate . ' to ' . $fdate . '.csv';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($dataexport[0])) {
                $fp = fopen('php://output', 'w');
                //print_r($header);
                //fputcsv($fp, $header,',');
                foreach ($dataexport as $values) {
                    //print_r($values); exit;
                    fputcsv($fp, $values, ',');
                }
                fclose($fp);
            }
            ob_flush();
            exit;
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function overall_patient_excel()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->quality_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->quality_model->setup_result($setup);
            $setarray = array();
            $questioarray = array();
            foreach ($sresult as $r) {
                $setarray[$r->type] = $r->title;
            }
            foreach ($sresult as $r) {
                $questioarray[$r->type][$r->shortkey] = $r->shortname;
            }

            $arraydata = array();
            foreach ($questioarray as $setr) {
                foreach ($setr as $k => $v) {
                    $arraydata[$k] = $v;
                }
            }

            $header[0] = 'Date';
            $header[1] = 'Patient Name';
            $header[2] = 'Patient ID';
            $header[3] = 'Floor/Ward ';
            $header[4] = 'Room/Bed';
            $header[5] = 'Mobile Number';
            $header[6] = 'Email id';
            $j = 7;
            foreach ($arraydata as $k => $r) {
                $header[$j] = $r;
                $j++;
            }
            $header[$j++] = 'Average Rating';
            $header[$j++] = 'NPS Score';
            $header[$j++] = 'Recommneded Staff';
            $header[$j++] = 'Comments';
            foreach ($setarray as $r) {
                $header[$j] = $r . ' comment';
                $j++;
            }
            $dataexport = array();
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);
                $dataexport[$i]['date'] = date('d-m-Y', strtotime($row->datetime));
                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['patient_id'] = $data['patientid'];
                $dataexport[$i]['ward'] = $data['ward'];
                $dataexport[$i]['bedno'] = $data['bedno'];
                $dataexport[$i]['mobile'] = $data['contactnumber'];
                $dataexport[$i]['email'] = $data['email'];
                foreach ($arraydata as $k => $r) {
                    $dataexport[$i][$k] = $data[$k];
                }
                $dataexport[$i]['overallScore'] = $data['overallScore'];
                $dataexport[$i]['recommend1Score'] = ($data['recommend1Score']) * 2;
                $dataexport[$i]['staffname'] = $data['staffname'];
                $dataexport[$i]['suggestionText'] = $data['suggestionText'];
                foreach ($setarray as $key => $t) {
                    if ($data['comment'][$key] != '') {
                        $dataexport[$i][$key] = $data['comment'][$key];
                    } else {
                        $dataexport[$i][$key] = '';
                    }
                }
                $i++;
            }
            $newdataset = $dataexport;
            $d = array();
            $p = array();
            $n = array();
            $para = array();
            $for5 = array();
            $for4 = array();
            $for3 = array();
            $for2 = array();
            $for1 = array();
            foreach ($dataexport as $row) {
                foreach ($row as $k => $r) {
                    if ($r * 1 > 0) {
                        $d[$k] = $d[$k] + 1;
                        if ($r > 2) {
                            $p[$k] = $p[$k] + 1;
                        } else {
                            $n[$k] = $n[$k] + 1;
                        }
                        $para[$k] = $para[$k] + $r;
                        if ($k == 'overallScore') {
                            if ($r == 5) {
                                $for5[$k] = $for5[$k] + 1;
                            }
                            if ($r == 4) {
                                $for4[$k] = $for4[$k] + 1;
                            }
                            if ($r == 3) {
                                $for3[$k] = $for3[$k] + 1;
                            }
                            if ($r == 2) {
                                $for2[$k] = $for2[$k] + 1;
                            }
                            if ($r == 1) {
                                $for1[$k] = $for1[$k] + 1;
                            }
                        }
                    }
                }
            }

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- IPD PATIENT WISE FEEDBACK REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($dataexport[0])) {
                $fp = fopen('php://output', 'w');
                //print_r($header);
                fputcsv($fp, $header, ',');
                foreach ($dataexport as $values) {
                    //print_r($values); exit;
                    fputcsv($fp, $values, ',');
                }
                fclose($fp);
            }
            ob_flush();
            exit;
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function overall_department_excel()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $dataexport = array();
            $i = 0;
            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $sorttime = 'asc';
            $setup = 'setup';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'inpatient';

            $ip_tickets_count = $this->tickets_model->alltickets();
            $ip_open_tickets = $this->tickets_model->read();
            $ip_closed_tickets = $this->tickets_model->read_close();
            $ip_addressed_tickets = $this->tickets_model->addressedtickets();
            $ip_feedbacks_count = $this->quality_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $ticket_resolution_rate = $this->quality_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

            $sresult = $this->quality_model->setup_result($setup);
            $setarray = array();
            $questioarray = array();

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $dataexport[$i]['row1'] = 'TICKETS REPORT';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'FROM DATE';
            $dataexport[$i]['row2'] = $tdate;
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TO DATE';
            $dataexport[$i]['row2'] = $fdate;
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TOTAL FEEDBACKS SUBMITTED';
            $dataexport[$i]['row2'] = count($ip_feedbacks_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'TOTAL TICKETS';
            $dataexport[$i]['row2'] = count($ip_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TICKET RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'OPEN TICKETS';
            $dataexport[$i]['row2'] = count($ip_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            if (ticket_addressal('ip_addressal') === true) {
                $dataexport[$i]['row1'] = 'ADDRESSED TICKETS';
                $dataexport[$i]['row2'] = count($ip_addressed_tickets);
                $dataexport[$i]['row3'] = '';
                $dataexport[$i]['row4'] = '';
                $i++;
            }

            $dataexport[$i]['row1'] = 'CLOSED TICKETS';
            $dataexport[$i]['row2'] = count($ip_closed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'TICKETS RECEIVED BY DEPARTMENT';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = 'OPEN';
            if (ticket_addressal('ip_addressal') === true) {
                $dataexport[$i]['row5'] = 'ADDRESSED';
            }
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = 'RESOLUTION TIME';
            $dataexport[$i]['row9'] = '';
            $i++;

            $ticket = $this->quality_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
            foreach ($ticket as $ps) {
                $time = secondsToTimeforreport($ps['res_time']);
                $dataexport[$i]['row1'] = $ps['department'];
                $dataexport[$i]['row2'] = $ps['percentage'] . '%';
                $dataexport[$i]['row3'] = $ps['count'];
                $dataexport[$i]['row4'] = $ps['open_tickets'];
                if (ticket_addressal('ip_addressal') === true) {
                    $dataexport[$i]['row5'] = $ps['addressed_tickets'];
                }
                $dataexport[$i]['row6'] = $ps['closed_tickets'];
                $dataexport[$i]['row7'] = $ps['tr_rate'] . '%';
                $dataexport[$i]['row8'] = $time;
                $dataexport[$i]['row9'] = '';
                $i++;
            }


            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            foreach ($sresult as $r) {
                $setarray[$r->type] = $r->title;
            }

            foreach ($sresult as $r) {
                $questioarray[$r->type][$r->shortkey] = $r->shortname;
            }

            $arraydata = array();

            foreach ($questioarray as $setr) {
                foreach ($setr as $k => $v) {
                    $arraydata[$k] = $v;
                }
            }


            $dataexport[$i]['row1'] = 'DEPARTMENT WISE FEEDBACK REPORT';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $k = 2;
            $dataexport[$i]['name'] = 'TITLE';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $r;
                $k++;
            }
            $i++;



            $d = array();
            $p = array();
            $n = array();
            $para = array();
            $for5 = array();
            $for4 = array();
            $for3 = array();
            $for2 = array();
            $for1 = array();

            foreach ($ip_feedbacks_count as $row) {
                $data = json_decode($row->dataset, true);
                $dataexportt[$i]['name'] = $data['name'];
                $dataexportt[$i]['patient_id'] = $data['patientid'];
                $dataexportt[$i]['mobile'] = $data['mobile'];
                $dataexportt[$i]['email'] = $data['email'];
                foreach ($arraydata as $k => $r) {
                    $dataexportt[$i][$k] = $data[$k];
                }
                $dataexportt[$i]['overallScore'] = $data['overallScore'];
                $i++;
            }
            $i++;

            foreach ($dataexportt as $row) {
                foreach ($row as $k => $r) {
                    if ($r * 1 > 0) {
                        $d[$k] = $d[$k] + 1;
                        if ($r > 2) {
                            $p[$k] = $p[$k] + 1;
                        } else {
                            $n[$k] = $n[$k] + 1;
                        }
                        $para[$k] = $para[$k] + $r;
                        if ($k == 'overallScore') {
                            if ($r == 5) {
                                $for5[$k] = $for5[$k] + 1;
                            }
                            if ($r == 4) {
                                $for4[$k] = $for4[$k] + 1;
                            }
                            if ($r == 3) {
                                $for3[$k] = $for3[$k] + 1;
                            }
                            if ($r == 2) {
                                $for2[$k] = $for2[$k] + 1;
                            }
                            if ($r == 1) {
                                $for1[$k] = $for1[$k] + 1;
                            }
                        }
                    }
                }
            }

            $dataexport[$i]['name'] = 'RELATIVE PERFORMANCE';
            foreach ($arraydata as $k => $r) {
                if ($d[$k] * 5 != 0) {
                    $dataexport[$i][$k] = round(($para[$k] / ($d[$k] * 5)) * 100) . '%';
                } else {
                    $dataexport[$i][$k] = '-';  // or some other value that indicates undefined or not applicable
                }
            }
            $i++;

            $dataexport[$i]['name'] = 'MAXIMUM SCORE';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $d[$k] * 5;
            }
            $i++;

            $dataexport[$i]['name'] = 'PARAMETER SCORE';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $para[$k];
            }
            $i++;

            $dataexport[$i]['name'] = 'POSITIVE RATINGS RECIEVED';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $p[$k];
            }
            $i++;

            $dataexport[$i]['name'] =  'NEGATIVE RATINGS RECIEVED';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $n[$k];
            }
            $i++;


            $dataexport[$i]['name'] = 'TOTAL RESPONSES';
            foreach ($arraydata as $k => $r) {
                $dataexport[$i][$k] = $d[$k];
            }
            $i++;


            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            // $header1='sdgf';
            ob_end_clean();
            $fileName = 'EF- IPD DEPARTMENT WISE TICKET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($dataexport[0])) {
                $fp = fopen('php://output', 'w');
                //print_r($header);
                fputcsv($fp, $header, ',');
                foreach ($dataexport as $values) {
                    //print_r($values); exit;
                    fputcsv($fp, $values, ',');
                }
                fclose($fp);
            }
            ob_flush();
            exit;
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function overall_pdf_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/ip_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);
            // redirect('report/ip_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
}
