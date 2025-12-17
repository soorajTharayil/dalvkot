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

        // $fdate = date('Y-m-d'); // today
        // $tdate = date('Y-m-01'); // first day of current month
        // $_SESSION['from_date'] = $fdate;
        // $_SESSION['to_date'] = $tdate;

        $dates = get_from_to_date();
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

        if (ismodule_active('QUALITY') === false && $this->uri->segment(2) != 'track')
            redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('QUALITY') === true) {

            $data['title'] = 'IP MODULE CONFIGURATION';
            $data['content'] = $this->load->view('qualitymodules/developer', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function delete_kpi($id)
    {
        $table = $this->input->get('table');

        if (empty($table)) {
            $this->session->set_flashdata('error', 'No table specified for deletion.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $tables = [
            'bf_feedback_1PSQ3a',
            'bf_feedback_2PSQ3a',
            'bf_feedback_3PSQ3a',
            'bf_feedback_4PSQ3a',
            'bf_feedback_5PSQ3a',
            'bf_feedback_6PSQ3a',
            'bf_feedback_7PSQ3a',
            'bf_feedback_8PSQ3a',
            'bf_feedback_9PSQ3a',
            'bf_feedback_10PSQ3a',
            'bf_feedback_11PSQ3a',
            'bf_feedback_12PSQ3a',
            'bf_feedback_13PSQ3b',
            'bf_feedback_14PSQ3b',
            'bf_feedback_15PSQ3b',
            'bf_feedback_16PSQ3b',
            'bf_feedback_17PSQ3b',
            'bf_feedback_18PSQ3b',
            'bf_feedback_19PSQ3c',
            'bf_feedback_20PSQ3c',
            'bf_feedback_21PSQ3c',
            'bf_feedback_21aPSQ3c',
            'bf_feedback_22PSQ3c',
            'bf_feedback_23aPSQ4c',
            'bf_feedback_23bPSQ4c',
            'bf_feedback_23cPSQ4c',
            'bf_feedback_23dPSQ4c',
            'bf_feedback_24PSQ4c',
            'bf_feedback_25PSQ4c',
            'bf_feedback_26PSQ4c',
            'bf_feedback_27PSQ4d',
            'bf_feedback_28PSQ4d',
            'bf_feedback_29PSQ4d',
            'bf_feedback_30PSQ3d',
            'bf_feedback_31PSQ3d',
            'bf_feedback_32PSQ3d',
            'bf_feedback_PSQ3a',
            'bf_feedback_33PSQ3a',
            'bf_feedback_34PSQ3a',
            'bf_feedback_35PSQ3a',
            'bf_feedback_36PSQ3a',
            'bf_feedback_37PSQ3a',
            'bf_feedback_38PSQ3a',
            'bf_feedback_39PSQ3a',
            'bf_feedback_40PSQ3a',
            'bf_feedback_41PSQ3a',
            'bf_feedback_42PSQ3a',
            'bf_feedback_43PSQ3a',
            'bf_feedback_44PSQ3a',
            'bf_feedback_45PSQ3a',
            'bf_feedback_46PSQ3a',
            'bf_feedback_47PSQ3a',
            'bf_feedback_48PSQ3a',
            'bf_feedback_49PSQ3a',
            'bf_feedback_50PSQ3a',


        ];

        if (!in_array($table, $tables)) {
            $this->session->set_flashdata('error', 'Invalid table specified for deletion.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // Prepare action log text
        $fullname = $this->session->userdata('fullname');
        $designation = $this->session->userdata('designation');
        $action_text = 'KPI Deleted by ' . $fullname . ' (' . $designation . ')';

        // ✅ Soft delete instead of actual delete
        $this->db->where('id', $id);
        $updated = $this->db->update($table, [
            'status' => 'Deleted',
            'action' => $action_text
        ]);

        if ($updated) {
            $this->session->set_flashdata('message', 'KPI record marked as deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to mark the record as deleted.');
        }

        redirect($_SERVER['HTTP_REFERER']); // back to same KPI page
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Existing dataset
            $existing = $this->quality_model->get_feedback_33PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_33PSQ3a($id, $data);
            redirect('quality/patient_feedback_33PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Existing dataset
            $existing = $this->quality_model->get_feedback_34PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_34PSQ3a($id, $data);
            redirect('quality/patient_feedback_34PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_35PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_35PSQ3a($id, $data);
            redirect('quality/patient_feedback_35PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_36PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_36PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_36PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_37PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_37PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_37PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_38PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_38PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_38PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_39PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_39PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_39PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_40PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_40PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_40PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_41PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_41PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_41PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_42PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_42PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_42PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_43PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_43PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_43PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_44PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_44PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_44PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_45PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_45PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_45PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_46PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_46PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_46PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_47PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_47PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_47PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_48PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_48PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_48PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_49PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_49PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_49PSQ3a?id=' . $id);
        } else {
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
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_50PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_50PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_50PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_50PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_50PSQ3a', $data);
        }
    }





    public function edit_feedback_PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Fetch existing dataset
            $existing = $this->quality_model->get_feedback_PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Handle new uploaded files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'   => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'      => 50000,
                    'encrypt_name'  => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge POST data into dataset excluding files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Prepare data for update
            $data = [
                'no_of_readmissions_icu' => $this->input->post('initial_assessment_hr'),
                'no_of_admissions'       => $this->input->post('total_admission'),
                'readmission_rate'       => $this->input->post('calculatedResult'),
                'bench_mark_time'        => $this->input->post('benchmark'),
                'data_analysis'          => $this->input->post('dataAnalysis'),
                'corrective_action'      => $this->input->post('correctiveAction'),
                'preventive_action'      => $this->input->post('preventiveAction'),
                'datetime'               => $formattedDatetime,
                'datet'                  => $formattedDatet,
                'dataset'                => json_encode($dataset)
            ];

            // Update in database
            $this->quality_model->update_feedback_PSQ3a($id, $data);

            // Redirect
            redirect('quality/patient_feedback_PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_PSQ3a', $data);
        }
    }



    public function edit_feedback_1PSQ3a_byid($id)
    {
        // Check if form is submitted
        if ($this->input->post()) {

            // 1️⃣ Handle time formatting
            $hr = intval($this->input->post('initial_assessment_hr')) ?: 0;
            $min = intval($this->input->post('initial_assessment_min')) ?: 0;
            $sec = intval($this->input->post('initial_assessment_sec')) ?: 0;
            $timeString = sprintf('%02d:%02d:%02d', $hr, $min, $sec);

            // 2️⃣ Format datetime
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // 3️⃣ Fetch existing dataset and files

            $existing = $this->quality_model->get_feedback_1PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // 4️⃣ Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // 5️⃣ Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'  => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'     => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // 6️⃣ Update other form fields into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // 7️⃣ Prepare final data for DB update
            $data = [
                'time_taken_initial_assessment' => $timeString,
                'number_of_admission'           => $this->input->post('total_admission'),
                'average_time_taken_initial_assessment' => $this->input->post('calculatedResult'),
                'bench_mark_time'               => $this->input->post('benchmark'),
                'data_analysis'                 => $this->input->post('dataAnalysis'),
                'corrective_action'             => $this->input->post('correctiveAction'),
                'preventive_action'             => $this->input->post('preventiveAction'),
                'datetime'                      => $formattedDatetime,
                'datet'                          => $formattedDatet,
                'dataset'                        => json_encode($dataset)
            ];

            // 8️⃣ Update database
            $this->quality_model->update_feedback_1PSQ3a($id, $data);

            // 9️⃣ Redirect after update
            redirect('quality/patient_feedback_1PSQ3a?id=' . $id);
        } else {
            // Load the view with the form and existing record
            $data['param'] = $this->quality_model->get_feedback_1PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_1PSQ3a', $data);
        }
    }

    public function edit_feedback_2PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            // 1️⃣ Format datetime
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // 2️⃣ Get existing record
            $existing = $this->quality_model->get_feedback_2PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // 3️⃣ Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // 4️⃣ Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path'  => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size'     => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name'     => $_FILES['uploaded_files']['name'][$i],
                        'type'     => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error'    => $_FILES['uploaded_files']['error'][$i],
                        'size'     => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url'  => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // 5️⃣ Update other POST fields into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // 6️⃣ Prepare data for DB update
            $data = [
                'reporting_errors' => $this->input->post('initial_assessment_hr'),
                'number_of_test_performed' => $this->input->post('total_admission'),
                'average_no_of_reporting_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            // 7️⃣ Update DB
            $this->quality_model->update_feedback_2PSQ3a($id, $data);

            // 8️⃣ Redirect
            redirect('quality/patient_feedback_2PSQ3a?id=' . $id);
        } else {
            // Load form with existing data
            $data['param'] = $this->quality_model->get_feedback_2PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_2PSQ3a', $data);
        }
    }


    // ==================== 3PSQ3a ====================
    public function edit_feedback_3PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            // Format datetime
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // Get existing dataset and files
            $existing = $this->quality_model->get_feedback_3PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files if requested
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            // Update dataset with other POST fields
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // Prepare data for DB update
            $data = [
                'no_staff_adher_safety' => $this->input->post('initial_assessment_hr'),
                'number_of_staff_audited' => $this->input->post('total_admission'),
                'percentage_safety_precatutions' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_3PSQ3a($id, $data);
            redirect('quality/patient_feedback_3PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_3PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_3PSQ3a', $data);
        }
    }

    // ==================== 4PSQ3a ====================
    public function edit_feedback_4PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_4PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $data = [
                'no_medication_errors' => $this->input->post('initial_assessment_hr'),
                'no_opportunity_errors' => $this->input->post('total_admission'),
                'percentage_medication_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_4PSQ3a($id, $data);
            redirect('quality/patient_feedback_4PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_4PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_4PSQ3a', $data);
        }
    }

    // ==================== 5PSQ3a ====================
    public function edit_feedback_5PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_5PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $data = [
                'no_medication_chart_errors' => $this->input->post('initial_assessment_hr'),
                'no_chart_reviewed' => $this->input->post('total_admission'),
                'percentage_medication_chart_errors' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_5PSQ3a($id, $data);
            redirect('quality/patient_feedback_5PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_5PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_5PSQ3a', $data);
        }
    }


    // ==================== 6PSQ3a ====================
    public function edit_feedback_6PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_6PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_adverse_drug_reaction' => $this->input->post('initial_assessment_hr'),
                'no_inpatients' => $this->input->post('total_admission'),
                'percentage_of_adverse_drug_reaction' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_6PSQ3a($id, $data);
            redirect('quality/patient_feedback_6PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_6PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_6PSQ3a', $data);
        }
    }

    // ==================== 7PSQ3a ====================
    public function edit_feedback_7PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_7PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_unplanned_return_ot' => $this->input->post('initial_assessment_hr'),
                'no_patients_in_ot' => $this->input->post('total_admission'),
                'percentage_of_unplanned_return_ot' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_7PSQ3a($id, $data);
            redirect('quality/patient_feedback_7PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_7PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_7PSQ3a', $data);
        }
    }

    // ==================== 8PSQ3a ====================
    public function edit_feedback_8PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_8PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'surgery_procedure_followed' => $this->input->post('initial_assessment_hr'),
                'no_surgery_performed' => $this->input->post('total_admission'),
                'percentage_of_surgery_adherence' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_8PSQ3a($id, $data);
            redirect('quality/patient_feedback_8PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_8PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_8PSQ3a', $data);
        }
    }

    // ==================== 9PSQ3a ====================
    public function edit_feedback_9PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_9PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_transfusion_reactions' => $this->input->post('initial_assessment_hr'),
                'no_units_transfused' => $this->input->post('total_admission'),
                'percentage_of_transfusion_reactions' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_9PSQ3a($id, $data);
            redirect('quality/patient_feedback_9PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_9PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_9PSQ3a', $data);
        }
    }

    // ==================== 10PSQ3a ====================
    public function edit_feedback_10PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_10PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'actual_deaths_icu' => $this->input->post('initial_assessment_hr'),
                'predicted_deaths_icu' => $this->input->post('total_admission'),
                'percentage_of_mortality_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_10PSQ3a($id, $data);
            redirect('quality/patient_feedback_10PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_10PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_10PSQ3a', $data);
        }
    }


    // ==================== 11PSQ3a ====================
    public function edit_feedback_11PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_11PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'return_to_emergency' => $this->input->post('initial_assessment_hr'),
                'no_of_patients_emergency' => $this->input->post('total_admission'),
                'percentage_of_return' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_11PSQ3a($id, $data);
            redirect('quality/patient_feedback_11PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_11PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_11PSQ3a', $data);
        }
    }

    // ==================== 12PSQ3a ====================
    public function edit_feedback_12PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_12PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_pressure_ulcer' => $this->input->post('initial_assessment_hr'),
                'no_of_patient_days' => $this->input->post('total_admission'),
                'incidence_of_pressure_ulcer' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_12PSQ3a($id, $data);
            redirect('quality/patient_feedback_12PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_12PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_12PSQ3a', $data);
        }
    }

    // ==================== 13PSQ3a ====================
    public function edit_feedback_13PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_13PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_urinary_tract_infection' => $this->input->post('initial_assessment_hr'),
                'no_of_urinary_catheter_days' => $this->input->post('total_admission'),
                'urinary_tract_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_13PSQ3a($id, $data);
            redirect('quality/patient_feedback_13PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_13PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_13PSQ3a', $data);
        }
    }


    // ==================== 14PSQ3a ====================
    public function edit_feedback_14PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_14PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_pneumonia' => $this->input->post('initial_assessment_hr'),
                'no_ventilator_days' => $this->input->post('total_admission'),
                'ventilator_pneumonia_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_14PSQ3a($id, $data);
            redirect('quality/patient_feedback_14PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_14PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_14PSQ3a', $data);
        }
    }

    // ==================== 15PSQ3a ====================
    public function edit_feedback_15PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_15PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_blood_stream_infection' => $this->input->post('initial_assessment_hr'),
                'no_central_line_days' => $this->input->post('total_admission'),
                'blood_stream_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_15PSQ3a($id, $data);
            redirect('quality/patient_feedback_15PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_15PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_15PSQ3a', $data);
        }
    }

    // ==================== 16PSQ3a ====================
    public function edit_feedback_16PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_16PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_surgical_infection' => $this->input->post('initial_assessment_hr'),
                'no_of_surgery_perform' => $this->input->post('total_admission'),
                'surgical_infection_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_16PSQ3a($id, $data);
            redirect('quality/patient_feedback_16PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_16PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_16PSQ3a', $data);
        }
    }

    // ==================== 17PSQ3a ====================
    public function edit_feedback_17PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_17PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_hygiene_action' => $this->input->post('initial_assessment_hr'),
                'no_of_hygiene_oppurtunities' => $this->input->post('total_admission'),
                'hygiene_compliance_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_17PSQ3a($id, $data);
            redirect('quality/patient_feedback_17PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_17PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_17PSQ3a', $data);
        }
    }

    // ==================== 18PSQ3a ====================
    public function edit_feedback_18PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_18PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_receive_prophylactic' => $this->input->post('initial_assessment_hr'),
                'no_of_underwent_surgery' => $this->input->post('total_admission'),
                'prophylactic_percentage' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_18PSQ3a($id, $data);
            redirect('quality/patient_feedback_18PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_18PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_18PSQ3a', $data);
        }
    }

    // ==================== 19PSQ3a ====================
    public function edit_feedback_19PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_19PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }
            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_reschedule' => $this->input->post('initial_assessment_hr'),
                'no_of_surgery_planned' => $this->input->post('total_admission'),
                'percentage_of_reschedule' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_19PSQ3a($id, $data);
            redirect('quality/patient_feedback_19PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_19PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_19PSQ3a', $data);
        }
    }


    // ==================== 20PSQ3a ====================
    public function edit_feedback_20PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_20PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_time_taken' => $this->input->post('initial_assessment_hr'),
                'no_of_blood_crossmatched' => $this->input->post('total_admission'),
                'average_turn_around_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_20PSQ3a($id, $data);
            redirect('quality/patient_feedback_20PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_20PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_20PSQ3a', $data);
        }
    }

    // ==================== 21PSQ3a ====================
    public function edit_feedback_21PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_21PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_nursing_staff' => $this->input->post('initial_assessment_hr'),
                'no_of_beds' => $this->input->post('total_admission'),
                'nurse_patients_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_21PSQ3a($id, $data);
            redirect('quality/patient_feedback_21PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_21PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_21PSQ3a', $data);
        }
    }

    // ==================== 21aPSQ3a ====================
    public function edit_feedback_21aPSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_21aPSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_nursing_staff' => $this->input->post('initial_assessment_hr'),
                'no_of_beds' => $this->input->post('total_admission'),
                'nurse_patients_ratio' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_21aPSQ3a($id, $data);
            redirect('quality/patient_feedback_21aPSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_21aPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_21aPSQ3a', $data);
        }
    }

    // ==================== 22PSQ3a ====================
    public function edit_feedback_22PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_22PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_consultation_time' => $this->input->post('initial_assessment_hr'),
                'no_of_outpatients' => $this->input->post('total_admission'),
                'avg_consultation_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_22PSQ3a($id, $data);
            redirect('quality/patient_feedback_22PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_22PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_22PSQ3a', $data);
        }
    }

    // ==================== 23aPSQ3a ====================
    public function edit_feedback_23aPSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_23aPSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'lab_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_23aPSQ3a($id, $data);
            redirect('quality/patient_feedback_23aPSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_23aPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23aPSQ3a', $data);
        }
    }




    // ==================== 23bPSQ3a ====================
    public function edit_feedback_23bPSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_23bPSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'xray_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_23bPSQ3a($id, $data);
            redirect('quality/patient_feedback_23bPSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_23bPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23bPSQ3a', $data);
        }
    }

    // ==================== 23cPSQ3a ====================
    public function edit_feedback_23cPSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_23cPSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'usg_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_23cPSQ3a($id, $data);
            redirect('quality/patient_feedback_23cPSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_23cPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23cPSQ3a', $data);
        }
    }




    // ==================== 23dPSQ3a ====================
    public function edit_feedback_23dPSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_23dPSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            // Merge remaining POST data
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'sum_of_reporting_time' => $this->input->post('formattedTime'),
                'no_of_patients_in_diagnostics' => $this->input->post('total_admission'),
                'ctscan_wait_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_23dPSQ3a($id, $data);
            redirect('quality/patient_feedback_23dPSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_23dPSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_23dPSQ3a', $data);
        }
    }

    // ==================== 24PSQ3a ====================
    public function edit_feedback_24PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_24PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            // Format discharge times
            $times = [];
            for ($i = 1; $i <= 3; $i++) {
                $hr = intval($this->input->post("initial_assessment_hr$i")) ?: 0;
                $min = intval($this->input->post("initial_assessment_min$i")) ?: 0;
                $sec = intval($this->input->post("initial_assessment_sec$i")) ?: 0;
                $times[$i] = sprintf('%02d:%02d:%02d', $hr, $min, $sec);
            }

            $data = [
                'sum_of_discharge_time' => $times[1],
                'no_of_patients_discharged' => $this->input->post('total_admission'),
                'avg_discharge_time' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'excess_time_taken' => $this->input->post('excessTimeText'),

                'sum_of_discharge_time_ins' => $times[2],
                'no_of_patients_discharged_ins' => $this->input->post('total_admission2'),
                'avg_discharge_time_ins' => $this->input->post('calculatedResult2'),
                'bench_mark_time_ins' => $this->input->post('benchmark2'),
                'excess_time_taken_ins' => $this->input->post('excessTimeText2'),

                'sum_of_discharge_time_cop' => $times[3],
                'no_of_patients_discharged_cop' => $this->input->post('total_admission3'),
                'avg_discharge_time_cop' => $this->input->post('calculatedResult3'),
                'bench_mark_time_cop' => $this->input->post('benchmark3'),
                'excess_time_taken_cop' => $this->input->post('excessTimeText3'),

                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_24PSQ3a($id, $data);
            redirect('quality/patient_feedback_24PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_24PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_24PSQ3a', $data);
        }
    }

    // ==================== 25PSQ3a ====================
    public function edit_feedback_25PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_25PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_incomplete_medical_records' => $this->input->post('initial_assessment_hr'),
                'no_of_discharge' => $this->input->post('total_admission'),
                'percentage_of_medical_records' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_25PSQ3a($id, $data);
            redirect('quality/patient_feedback_25PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_25PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_25PSQ3a', $data);
        }
    }

    // ==================== 26PSQ3a ====================
    public function edit_feedback_26PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_26PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove selected files
            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            // Upload new files
            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);

            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'emergency_drugs_stock' => $this->input->post('initial_assessment_hr'),
                'no_listed_emergency_drugs' => $this->input->post('total_admission'),
                'percentage_stock_out_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_26PSQ3a($id, $data);
            redirect('quality/patient_feedback_26PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_26PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_26PSQ3a', $data);
        }
    }

    // ==================== 27PSQ3a ====================
    public function edit_feedback_27PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_27PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_variations' => $this->input->post('initial_assessment_hr'),
                'no_of_variations_opportunities' => $this->input->post('total_admission'),
                'percentage_of_variations' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_27PSQ3a($id, $data);
            redirect('quality/patient_feedback_27PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_27PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_27PSQ3a', $data);
        }
    }

    // ==================== 28PSQ3a ====================
    public function edit_feedback_28PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_28PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_patients_fall' => $this->input->post('initial_assessment_hr'),
                'no_patient_days' => $this->input->post('total_admission'),
                'patient_fall_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_28PSQ3a($id, $data);
            redirect('quality/patient_feedback_28PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_28PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_28PSQ3a', $data);
        }
    }

    // ==================== 29PSQ3a ====================
    public function edit_feedback_29PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_29PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_near_misses' => $this->input->post('initial_assessment_hr'),
                'no_of_incident_reported' => $this->input->post('total_admission'),
                'percentage_of_near_misses' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_29PSQ3a($id, $data);
            redirect('quality/patient_feedback_29PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_29PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_29PSQ3a', $data);
        }
    }


    // ==================== 30PSQ3a ====================
    public function edit_feedback_30PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_30PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_parenteral_exposures' => $this->input->post('initial_assessment_hr'),
                'no_patient_days' => $this->input->post('total_admission'),
                'needle_stick_injuries' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_30PSQ3a($id, $data);
            redirect('quality/patient_feedback_30PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_30PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_30PSQ3a', $data);
        }
    }

    // ==================== 31PSQ3a ====================
    public function edit_feedback_31PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_31PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_handovers_done' => $this->input->post('initial_assessment_hr'),
                'no_of_handover_opportunities' => $this->input->post('total_admission'),
                'percentage_of_handovers' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_31PSQ3a($id, $data);
            redirect('quality/patient_feedback_31PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_31PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_31PSQ3a', $data);
        }
    }

    // ==================== 32PSQ3a ====================
    public function edit_feedback_32PSQ3a_byid($id)
    {
        if ($this->input->post()) {
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $existing = $this->quality_model->get_feedback_32PSQ3a_byid($id);
            $dataset = json_decode($existing->dataset ?? '{}', true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            $removeIndexes = json_decode($this->input->post('remove_files_json') ?? '[]', true);
            if (!empty($removeIndexes)) {
                foreach ($removeIndexes as $index) {
                    if (isset($existingFiles[$index])) {
                        $oldFilePath = str_replace(base_url(), '', $existingFiles[$index]['url']);
                        $absolutePath = FCPATH . $oldFilePath;
                        if (file_exists($absolutePath)) @unlink($absolutePath);
                        unset($existingFiles[$index]);
                    }
                }
                $existingFiles = array_values($existingFiles);
            }

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $filesCount = count($_FILES['uploaded_files']['name']);
                $config = [
                    'upload_path' => './api/file_uploads/',
                    'allowed_types' => 'jpg|jpeg|png|pdf|csv|doc|docx|xls|xlsx',
                    'max_size' => 50000,
                    'encrypt_name' => FALSE
                ];
                $this->load->library('upload');
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file'] = [
                        'name' => $_FILES['uploaded_files']['name'][$i],
                        'type' => $_FILES['uploaded_files']['type'][$i],
                        'tmp_name' => $_FILES['uploaded_files']['tmp_name'][$i],
                        'error' => $_FILES['uploaded_files']['error'][$i],
                        'size' => $_FILES['uploaded_files']['size'][$i]
                    ];
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $existingFiles[] = [
                            'url' => base_url('api/file_uploads/' . $uploadData['file_name']),
                            'name' => $uploadData['file_name']
                        ];
                    }
                }
            }

            $dataset['files_name'] = array_values($existingFiles);
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) $dataset[$key] = $value;
            }

            $data = [
                'no_of_prescriptions_in_capitals' => $this->input->post('initial_assessment_hr'),
                'no_of_prescriptions' => $this->input->post('total_admission'),
                'compliance_rate' => $this->input->post('calculatedResult'),
                'bench_mark_time' => $this->input->post('benchmark'),
                'data_analysis' => $this->input->post('dataAnalysis'),
                'corrective_action' => $this->input->post('correctiveAction'),
                'preventive_action' => $this->input->post('preventiveAction'),
                'datetime' => $formattedDatetime,
                'datet' => $formattedDatet,
                'dataset' => json_encode($dataset)
            ];

            $this->quality_model->update_feedback_32PSQ3a($id, $data);
            redirect('quality/patient_feedback_32PSQ3a?id=' . $id);
        } else {
            $data['param'] = $this->quality_model->get_feedback_32PSQ3a_byid($id);
            $this->load->view('qualitymodules/dephead/edit_feedback_32PSQ3a', $data);
        }
    }




    // SUPER ADMIN AND ADMIN LOGIN
    public function quality_welcome_page()
    {


        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {
            $dateInfo = get_from_to_date();

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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU - ' . $titleSuffix;
            $data['title'] = 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of Beta-blocker prescription with a diagnosis of CHF with reduced EF - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of Beta-blocker prescription with a diagnosis of CHF with reduced EF';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes is achieved - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes is achieved';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of Hospitalized patients with hypoglycemia who achieved targeted blood glucose level - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of Hospitalized patients with hypoglycemia who achieved targeted blood glucose level';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Spontaneous Perineal Tear Rate - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Spontaneous Perineal Tear Rate';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Postoperative Endophthalmitis Rate - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Postoperative Endophthalmitis Rate';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of patients undergoing colonoscopy who are sedated - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of patients undergoing colonoscopy who are sedated';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Bile Duct injury rate requiring operative intervention during Laparoscopic cholecystectomy - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Bile Duct injury rate requiring operative intervention during Laparoscopic cholecystectomy';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of POCT results which led to a clinical intervention - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of POCT results which led to a clinical intervention';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Functional gain following rehabilitation - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Functional gain following rehabilitation';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of sepsis patients who receive care as per the Hour-1 sepsis bundle - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of sepsis patients who receive care as per the Hour-1 sepsis bundle';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of COPD patients receiving COPD Action plan at the time of discharge - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of COPD patients receiving COPD Action plan at the time of discharge';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of stroke patients in whom the Door-to-Needle Time (DTN) of 60 minutes is achieved - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of stroke patients in whom the Door-to-Needle Time (DTN) of 60 minutes is achieved';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of bronchiolitis patients treated inappropriately - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of bronchiolitis patients treated inappropriately';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of oncology patients who had treatment initiated following Multidisciplinary meeting - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of oncology patients who had treatment initiated following Multidisciplinary meeting';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of adverse reaction to radiopharmaceutical - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of adverse reaction to radiopharmaceutical';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of Intravenous Contrast Media Extravasation - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of Intravenous Contrast Media Extravasation';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Time taken for triage - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Time taken for triage';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = 'PSQ3a- Percentage of patients undergoing dialysis who are able to achieve target hemoglobin levels - ' . $titleSuffix;
            $data['title'] = 'PSQ3a- Percentage of patients undergoing dialysis who are able to achieve target hemoglobin levels';
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
        if (ismodule_active('QUALITY') === true) {

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

            // $data['title'] = '1.PSQ3a- Time taken for initial assessment of indoor patients - ' . $titleSuffix;
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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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

            $data['title'] = '11.PSQ3a- Return to the emergency within 72 hours with similar complaints';
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
        if (ismodule_active('QUALITY') === true) {

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

            $data['title'] = '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission';
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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';

            //Load MRD audit data
            $this->load->model('audit_model');
            $table_feedback = 'bf_feedback_mrd_audit';
            $table_patients = 'bf_patients';
            $data['feedbacktaken'] = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, 'desc');
            //END

            $data['content'] = $this->load->view('qualitymodules/patient_feedback_1PSQ3a', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function patient_feedback_2PSQ3a()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';
            #------------------------------#

            $this->load->model('ticketsincidents_model');
            $data['departments'] = $this->ticketsincidents_model->alltickets();
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
        if (ismodule_active('QUALITY') === true) {

            $data['title'] = 'QUALITY KPI FORM ANALYSIS';

            
            $this->load->model('audit_model');
            $table_feedback = 'bf_feedback_ppe_audit';
            $table_feedback = 'bf_feedback_lab_safety_audit';
            $table_patients = 'bf_patients';
            $data['feedbacktaken'] = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, 'desc');
            //END
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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {

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
        if (ismodule_active('QUALITY') === true) {


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
        if (ismodule_active('QUALITY') === true) {

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

    public function overall_1psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_1PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of time taken for initial assessment';
            $header[4] = 'Total number of admissions';
            $header[5] = 'Avg. time taken for initial assessment';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_total'] = $data['initial_assessment_total'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 1.PSQ3a- Time taken for initial assessment of indoor patients - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_2psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_2PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of reporting errors';
            $header[4] = 'Number of tests performed';
            $header[5] = 'No. of reporting errors per 1000 investigations';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 2.PSQ3a- Number of reporting errors per 1000 investigations - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_3psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_3PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of staff adhering to safety precautions';
            $header[4] = 'Number of staff audited';
            $header[5] = 'Percentage of adherence to safety precautions';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 3.PSQ3a- Percentage of adherence to safety precautions by diagnostics staffs - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_4psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_4PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of medication errors';
            $header[4] = 'Number of opportunities of medication errors';
            $header[5] = 'Percentage of medication error';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 4.PSQ3a- Medication errors rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_5psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_5PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of medication charts with error prone abbreviation';
            $header[4] = 'Number of medication charts reviewed';
            $header[5] = 'Percentage of medication chart with error-prone abbreviations';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 5.PSQ3a- Percentage of medication charts with error-prone abbreviations - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_6psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_6PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients developing adverse drug reactions';
            $header[4] = 'Number of in-patients';
            $header[5] = 'Percentage of in-patients developing adverse drug reaction';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s) - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_7psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_7PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of unplanned return to OT';
            $header[4] = 'Number of patients who underwent surgeries in the OT';
            $header[5] = 'Percentage of unplanned return to OT';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 7.PSQ3a- Percentage of unplanned return to OT - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_8psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_8PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of surgeries where the procedure was followed';
            $header[4] = 'Number of surgeries performed';
            $header[5] = 'Percentage of Surgeries following adverse event prevention procedures';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_9psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_9PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of transfusion reactions';
            $header[4] = 'Number of units transfused (in Units)';
            $header[5] = 'Percentage of transfusion reactions';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 9.PSQ3a- Percentage of transfusion reactions - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_10psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_10PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Actual deaths in ICU';
            $header[4] = 'Predicted deaths in ICU';
            $header[5] = 'Percentage of standardised mortality ratio for ICU';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 10.PSQ3a- Standardised mortality ratio for ICU - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_11psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_11PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of returns to emergency within 72 hrs with similar complaints';
            $header[4] = 'Number of patients who have come to the emergency';
            $header[5] = 'Percentage of returns to emergency within 72 hrs with similar complaints';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 11.PSQ3a- Return to the emergency within 72 hours with similar complaints - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_12psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_12PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients who develop new / worsening of pressure ulcer';
            $header[4] = 'Total no. of patient days';
            $header[5] = 'Incidence of hospital associated pressure ulcers after admission';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 12.PSQ3a- Incidence of hospital associated pressure ulcers after admission - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_13psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_13PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of urinary catheter associated UTIs';
            $header[4] = 'Number of urinary catheter days';
            $header[5] = 'Catheter associated Urinary tract infection rate';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 13.PSQ3b- Catheter associated urinary tract infection rate - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_14psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_14PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of ventilator associated pneumonia';
            $header[4] = 'Number of ventilator days';
            $header[5] = 'Ventilator associated pneumonia rate';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 14.PSQ3b- Ventilator associated pneumonia rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_15psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_15PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of central line - associated blood stream infections';
            $header[4] = 'No. of central line days';
            $header[5] = 'Central line - associated blood stream infection rate';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 15.PSQ3b- Central line - associated blood stream infection rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_16psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_16PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of surgical site infections';
            $header[4] = 'Number of surgeries performed';
            $header[5] = 'Surgical site infection rate';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 16.PSQ3b- Surgical site infection rate - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_17psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_17PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of hand hygiene actions performed';
            $header[4] = 'Number of hand hygiene opportunities';
            $header[5] = 'Hand hygiene compliance rate';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 17.PSQ3b- Hand hygiene compliance rate - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_18psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_18PSQ3b';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients who receive appropriate prophylactic antibiotic';
            $header[4] = 'Number of patients who underwent surgeries in the OT';
            $header[5] = 'Percentage of cases who received appropriate prophylactic antibiotics';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_19psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_19PSQ3c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of cases rescheduled';
            $header[4] = 'Number of surgeries planned';
            $header[5] = 'Percentage of re-scheduling of surgeries';

            $j = 6;


            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                echo '<pre>';
                print_r($data);
                echo '</pre>';
                exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 19.PSQ3c- Percentage of re- scheduling of surgeries - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_20psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_20PSQ3c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of cases rescheduled';
            $header[4] = 'Number of surgeries planned';
            $header[5] = 'Percentage of re-scheduling of surgeries';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 20.PSQ3c- Turn around time for issue of blood and blood components - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_21psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_21PSQ3c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of nursing staff';
            $header[4] = 'Number of occupied beds';
            $header[5] = 'Nurse-patient ratio for ICU';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 21.PSQ3c- Nurse-patient ratio for ICUs - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_21apsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_21aPSQ3c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of nursing staff';
            $header[4] = 'Number of occupied beds';
            $header[5] = 'Nurse-patient ratio for Ward';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 21a.PSQ3c- Nurse-patient ratio for Wards - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_22psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_22PSQ3c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of total time for consultation';
            $header[4] = 'Total number of out-patients';
            $header[5] = 'Avg. waiting time for out-patient consultation';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 22.PSQ3c - Waiting time for out- patient consultation - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_23apsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_23aPSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of total patient reporting time';
            $header[4] = 'Number of patients reported in laboratory';
            $header[5] = 'Avg. waiting time for laboratory';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 23a.PSQ4c- Waiting time for laboratory diagnostics - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_23bpsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_23bPSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of total patient reporting time';
            $header[4] = 'Number of patients reported in X-Ray';
            $header[5] = 'Avg. waiting time for X-Ray';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 23b.PSQ4c- Waiting time for X-ray diagnostics - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_23cpsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_23cPSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of total patient reporting time';
            $header[4] = 'Number of patients reported in USG';
            $header[5] = 'Avg. waiting time for USG';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 23c.PSQ4c- Waiting time for USG diagnostics - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_23dpsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_23dPSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of total patient reporting time';
            $header[4] = 'Number of patients reported in CT scan';
            $header[5] = 'Avg. waiting time for CT scan';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 23d.PSQ4c- Waiting time for CT scan diagnostics - ' . $tdate . ' to ' . $fdate . '.csv';
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



    public function overall_24gpsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_24PSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of time taken for discharge';
            $header[4] = 'Number of patients discharged';
            $header[5] = 'Avg. time taken for discharge';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 24.PSQ4c- Time taken for discharge(General Patients) - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_24ipsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_24PSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of time taken for discharge';
            $header[4] = 'Number of patients discharged';
            $header[5] = 'Avg. time taken for discharge';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 24.PSQ4c- Time taken for discharge(Insurance Patients) - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_24cpsq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_24PSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of time taken for discharge';
            $header[4] = 'Number of patients discharged';
            $header[5] = 'Avg. time taken for discharge';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 24.PSQ4c- Time taken for discharge(Corporate Patients) - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_25psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_25PSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of medical records having incomplete/ improper consent';
            $header[4] = 'Number of discharges and deaths';
            $header[5] = 'Percentage of medical records having incomplete/ improper consent';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 25.PSQ4c- Percentage of medical records having incomplete/ improper consent - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_26psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_26PSQ4c';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of stock outs of emergency drugs';
            $header[4] = 'Number of drugs listed as emergency drugs';
            $header[5] = 'Percentage of stock out rate for emergency medications';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 26.PSQ4c- Stock out rate of emergency medications - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_27psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_27PSQ4d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of variations observed in a mock drill';
            $header[4] = 'Number of opportunities of variations';
            $header[5] = 'Percentage of number of variations observed in mock';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 27.PSQ4d- Number of variations observed in mock drills - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_28psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_28PSQ4d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patient falls';
            $header[4] = 'Total number of patient days';
            $header[5] = 'Patient fall rate';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 28.PSQ4d- Patient fall rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_29psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_29PSQ4d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of near misses reported';
            $header[4] = 'Number of incidents reported';
            $header[5] = 'Percentage of near misses';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 29.PSQ4d- Percentage of near misses - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_30psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_30PSQ3d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of parenteral exposures';
            $header[4] = 'Number of in-patient days';
            $header[5] = 'Incidence of needle stick injuries';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 30.PSQ3d- Incidence of needle stick injuries - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_31psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_31PSQ3d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of handovers done appropriately';
            $header[4] = 'Number of handover opportunities';
            $header[5] = 'Percentage of appropriate handovers during shift change';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 31.PSQ3d- Appropriate handovers during shift change - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_32psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_32PSQ3d';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of prescriptions in capital letters';
            $header[4] = 'Number of prescriptions';
            $header[5] = 'Percentage of compliance rate to prescription in capitals';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- 32.PSQ3d- Compliance rate to medication prescription in capitals - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of readmission to ICU within 48 hours';
            $header[4] = 'Number of admissions';
            $header[5] = 'Percentage of readmission rate';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a - Readmission to ICU within 48 hours after being discharged - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_33psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_33PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients discharged with diagnosis of CHF with reduced EF';
            $header[4] = 'Number of patients discharged with diagnosis of CHF';
            $header[5] = 'Percentage of Beta-blocker prescription with diagnosis of CHF with reduced EF';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a - Percentage of Beta-blocker prescription with a diagnosis of CHF with reduced EF - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_34psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_34PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of AMI patients during primary angioplasty for whom door to balloon time of 90 minutes is achieved';
            $header[4] = 'Number of AMI patients undergoing primary angioplasty';
            $header[5] = 'Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes is achieved - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_35psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_35PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients with hypoglycemic events where the target glucose level was achieved';
            $header[4] = 'Number of patients with hypoglycemic events';
            $header[5] = 'Percentage of hospitalized patients with hypoglycemia who achieved blood glucose level';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of Hospitalized patients with hypoglycemia who achieved targeted blood glucose level - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_36psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_36PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of cases where a spontaneous perineal tear occurs';
            $header[4] = 'Number of vaginal deliveries';
            $header[5] = 'Percentage of cases where a spontaneous perineal tear occurs';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Spontaneous Perineal Tear Rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_37psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_37PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of cases of postoperative endophthalmitis';
            $header[4] = 'Number of ophthalmic surgeries';
            $header[5] = 'Percentage of cases where postoperative endophthalmitis occurs';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Postoperative Endophthalmitis Rate - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_38psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_38PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of patients sedated for the colonoscopy procedure';
            $header[4] = 'Number of patients undergoing colonoscopy';
            $header[5] = 'Percentage of patients undergoing colonoscopy who are sedated';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of patients undergoing colonoscopy who are sedated - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_39psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_39PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of cases where bile duct injuries occurred';
            $header[4] = 'Laparoscopic cholecystectomies performed';
            $header[5] = 'Bile Duct Injury Rate';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a - Bile Duct injury rate requiring operative intervention during Laparoscopic cholecystectomy - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_40psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_40PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Number of POCT tests which resulted in clinical intervention';
            $header[4] = 'Number of POCT tests where clinical intervention was necessary';
            $header[5] = 'Percentage of POCT results that led to clinical intervention';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of POCT results which led to a clinical intervention - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_41psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_41PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of functional gain patients in neurorehabilitation';
            $header[4] = 'Number of patients undergoing neurorehabilitation';
            $header[5] = 'Percentage of neurorehabilitation patient with functional gain';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Functional gain following rehabilitation - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_42psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_42PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No.of sepsis patients receiving Hour-1 bundle care';
            $header[4] = 'Total number of sepsis cases';
            $header[5] = 'Percentage of sepsis patients receiving Hour-1 bundle care';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of sepsis patients who receive care as per the Hour-1 sepsis bundle - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_43psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_43PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of COPD patients provided with COPD action plan';
            $header[4] = 'No. of COPD patients discharged';
            $header[5] = 'Percentage of COPD patients receiving COPD action plan at the time of discharge';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of COPD patients receiving COPD Action plan at the time of discharge - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_44psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_44PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of stroke patients with DTN time within 60 minutes';
            $header[4] = 'No. of stroke patients receiving thrombolytic therapy';
            $header[5] = 'Percentage of stroke patients with DTN time within 60 minutes';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of stroke patients in whom the Door-to-Needle Time (DTN) of 60 minutes is achieved  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_45psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_45PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of patients treated inappropriately';
            $header[4] = 'Total no. of patients with bronchiolitis';
            $header[5] = 'Percentage of bronchiolitis patients treated inappropriately';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of bronchiolitis patients treated inappropriately  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_46psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_46PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of oncology patients treated post tumour board';
            $header[4] = 'No. of oncology cases treated';
            $header[5] = 'Percentage of oncology patients treated post tumour board';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of oncology patients who had treatment initiated following Multidisciplinary meeting  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_47psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_47PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of patients who developed adverse reaction';
            $header[4] = 'No. of patients receiving the radiopharmaceutical';
            $header[5] = 'Percentage of adverse reaction to radiopharmaceutical';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of adverse reaction to radiopharmaceutical  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_48psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_48PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of contrast extravasation';
            $header[4] = 'No. of patients receiving contrast';
            $header[5] = 'Percentage of Intravenous contrast media extravasation';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Percentage of Intravenous Contrast Media Extravasation  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_49psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_49PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'Sum of time taken for triage';
            $header[4] = 'Total no. of patients coming to the emergency';
            $header[5] = 'Avg. waiting time for triage';

            $j = 6;

            $header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a- Time taken for triage  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_50psq3a_report()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


            $table_feedback = 'bf_feedback_50PSQ3a';
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


            $header[0] = 'Recorded by';
            $header[1] = 'Month - Year';
            $header[2] = 'Employee details';
            $header[3] = 'No. of dialysis patients with target hemoglobin';
            $header[4] = 'Total no. of patients undergoing dialysis';
            $header[5] = 'Percentage of dialysis patients with target hemoglobin levels';

            $j = 6;

            //$header[$j++] = 'Benchmark time';
            $header[$j++] = 'Data analysis';
            $header[$j++] = 'Corrective action';
            $header[$j++] = 'Preventive action';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['date'] = date('M-Y', strtotime($row->datetime));
                $dataexport[$i]['patient_id'] = $data['name'] . "<" . $data['patientid'] . ">\n" .
                    $data['contactnumber'] . "\n" .
                    $data['email'];

                $dataexport[$i]['initial_assessment_hr'] = $data['initial_assessment_hr'];
                $dataexport[$i]['total_admission'] = $data['total_admission'];
                $dataexport[$i]['calculatedResult'] = $data['calculatedResult'];
                //$dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];
                $dataexport[$i]['correctiveAction'] = $data['correctiveAction'];
                $dataexport[$i]['preventiveAction'] = $data['preventiveAction'];

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- PSQ3a-  Percentage of patients undergoing dialysis who are able to achieve target hemoglobin levels  - ' . $tdate . ' to ' . $fdate . '.csv';
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

    //consoldited report 
    public function export_all_kpi()
    {
        $this->load->library('spreadsheet');

        // Define KPI tables and headers
        $kpiList = [
            [
                'table' => 'bf_feedback_1PSQ3a',
                'sheet' => '1.PSQ3a- Initial Assessment',
                'header' => [
                    'Recorded by',
                    'Month - Year',
                    'Employee details',
                    'Sum of time taken for initial assessment',
                    'Total number of admissions',
                    'Avg. time taken for initial assessment',
                    'Benchmark time',
                    'Data analysis',
                    'Corrective action',
                    'Preventive action'
                ]
            ],
            [
                'table' => 'bf_feedback_2PSQ3a',
                'sheet' => '2.PSQ3a- Number of reporting errors',
                'header' => [
                    'Recorded by',
                    'Month - Year',
                    'Employee details',
                    'No. of reporting errors',
                    'No. of tests performed',
                    'No. of reporting errors per 1000 investigations',
                    'Data analysis',
                    'Corrective action',
                    'Preventive action'
                ]
            ],
        ];

        $firstSheet = true;
        foreach ($kpiList as $kpi) {
            $feedbackData = $this->quality_model->patient_and_feedback('bf_patients', $kpi['table'], 'desc');

            // Create valid sheet name (max 31 chars)
            $sheetName = substr($kpi['sheet'], 0, 31);

            if ($firstSheet) {
                $sheet = $this->spreadsheet->getActiveSheet();
                $sheet->setTitle($sheetName);
                $firstSheet = false;
            } else {
                $sheet = $this->spreadsheet->addSheetWithTitle($sheetName);
            }

            $sheet->fromArray([$kpi['header']], null, 'A1');

            $rowIndex = 2;
            foreach ($feedbackData as $row) {
                $data = json_decode($row->dataset, true);

                if ($kpi['table'] === 'bf_feedback_1PSQ3a') {
                    $rowValues = [
                        $data['name'],
                        date('M-Y', strtotime($row->datetime)),
                        $data['name'] . "<" . $data['patientid'] . ">\n" . $data['contactnumber'] . "\n" . $data['email'],
                        $data['initial_assessment_total'],
                        $data['total_admission'],
                        $data['calculatedResult'],
                        $data['benchmark'],
                        $data['dataAnalysis'],
                        $data['correctiveAction'],
                        $data['preventiveAction']
                    ];
                } elseif ($kpi['table'] === 'bf_feedback_2PSQ3a') {
                    $rowValues = [
                        $data['name'],
                        date('M-Y', strtotime($row->datetime)),
                        $data['name'] . "<" . $data['patientid'] . ">\n" . $data['contactnumber'] . "\n" . $data['email'],
                        $data['initial_assessment_hr'],
                        $data['total_admission'],
                        $data['calculatedResult'],
                        $data['dataAnalysis'],
                        $data['correctiveAction'],
                        $data['preventiveAction']
                    ];
                }

                $sheet->fromArray([$rowValues], null, 'A' . $rowIndex);
                $sheet->getStyle('C' . $rowIndex)->getAlignment()->setWrapText(true);
                $rowIndex++;
            }
        }

        $this->spreadsheet->download('NABH_KPI_Report.xlsx');
    }






    public function overall_department_excel()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('QUALITY') === true) {


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
        if (ismodule_active('QUALITY') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/ip_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);
            // redirect('report/ip_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
}
