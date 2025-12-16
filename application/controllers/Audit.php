<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit extends CI_Controller
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
                'ipd_model',
                'audit_model',
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
            $data['content'] = $this->load->view('auditmodules/developer', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function audit_welcome_page()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT MANAGER DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('audit_welcome_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report_mrd_audit()
    {
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }

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

            $data['title'] = 'MRD AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_mrd_audit', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report_ppe_audit()
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

            $data['title'] = 'PPE AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_ppe_audit', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_consultation_time()
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

            $data['title'] = 'OP CONSULTATION WAITING TIME REPORT- ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_consultation_time', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_lab_time()
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

            $data['title'] = 'LABORATORY WAITING TIME REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_lab_time', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_xray_time()
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

            $data['title'] = 'X-RAY WAITING TIME REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_xray_time', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_usg_time()
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

            $data['title'] = 'USG WAITING TIME REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_usg_time', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_ctscan_time()
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

            $data['title'] = 'CT SCAN WAITING TIME REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_ctscan_time', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_surgical_safety()
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

            $data['title'] = 'SURGICAL SAFETY AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_surgical_safety', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_medicine_dispense()
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

            $data['title'] = 'MEDICINE DISPENSING AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_medicine_dispense', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_medication_administration()
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

            $data['title'] = 'MEDICATION ADMINISTRATION AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_medication_administration', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_handover()
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

            $data['title'] = 'HANDOVER AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_handover', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_prescriptions()
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

            $data['title'] = 'PRESCRIPTIONS AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_prescriptions', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_hand_hygiene()
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

            $data['title'] = 'HAND HYGIENE AUDIT REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_hand_hygiene', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_tat_blood()
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

            $data['title'] = 'TAT FOR BLOOD ISSUE REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_tat_blood', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_nurse_patients_ratio()
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

            $data['title'] = 'NURSE-PATIENT RATIO REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_nurse_patients_ratio', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_nurse_patients_ratio_ward()
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

            $data['title'] = 'NURSE-PATIENT RATIO REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_nurse_patients_ratio_ward', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_return_to_i()
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

            $data['title'] = 'ICU RETURN REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_return_to_i', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_return_to_icu()
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

            $data['title'] = 'ICU RETURN REPORT- DATA VERIFICATION - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_return_to_icu', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_return_to_ed()
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

            $data['title'] = 'EMERGENCY RETURN REPORT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_return_to_ed', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_return_to_emr()
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

            $data['title'] = 'EMERGENCY RETURN REPORT- DATA VERIFICATION - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_return_to_emr', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_mock_drill()
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

            $data['title'] = 'MOCK DRILLS AUDIT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_mock_drill', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_code_originals()
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

            $data['title'] = 'CODE - ORIGINALS AUDIT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_code_originals', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_safety_inspection()
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

            $data['title'] = 'FACILITY SAFETY INSPECTION CHECKLIST & AUDIT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_safety_inspection', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }



    public function feedbacks_report_vap()
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

            $data['title'] = 'VAP PREVENTION CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_vap', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_catheter_insert()
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

            $data['title'] = 'CATHETER INSERTION CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_catheter_insert', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_ssi_bundle()
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

            $data['title'] = 'SSI BUNDLE CARE POLICY - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_ssi_bundle', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_urinary()
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

            $data['title'] = 'URINARY CATHETER MAINTENANCE CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_urinary', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_central_line_insert()
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

            $data['title'] = 'CENTRAL LINE INSERTION CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_central_line_insert', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_central_maintenance()
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

            $data['title'] = 'CENTRAL LINE MAINTENANCE CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_central_maintenance', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_room_cleaning()
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

            $data['title'] = 'PATIENT ROOM CLEANING AUDIT - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_room_cleaning', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_other_cleaning()
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

            $data['title'] = 'OTHER AREA CLEANING CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_other_cleaning', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_toilet_cleaning()
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

            $data['title'] = 'TOILET CLEANING CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_toilet_cleaning', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_canteen()
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

            $data['title'] = 'CANTEEN AUDIT CHECKLIST - ' . $titleSuffix;
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_canteen', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function mrd_audit_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/mrd_audit_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/mrd_audit_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function ppe_audit_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/ppe_audit_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/ppe_audit_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function op_consultation_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/op_consultation_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/op_consultation_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function lab_wait_time_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/lab_wait_time_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/lab_wait_time_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function xray_wait_time_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/xray_wait_time_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/xray_wait_time_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function usg_wait_time_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/usg_wait_time_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/usg_wait_time_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function ctscan_wait_time_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/ctscan_wait_time_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/ctscan_wait_time_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function surgical_safety_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/surgical_safety_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/surgical_safety_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function medicine_dispensing_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/medicine_dispensing_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/medicine_dispensing_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function medication_administration_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/medication_administration_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/medication_administration_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function handover_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/handover_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/handover_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function prescriptions_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/prescriptions_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/prescriptions_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function hygiene_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/hygiene_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/hygiene_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function tat_blood_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/tat_blood_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/tat_blood_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function nurse_patient_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/nurse_patient_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/nurse_patient_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function nurse_patient_ward_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/nurse_patient_ward_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/nurse_patient_ward_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function return_to_icu_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/return_to_icu_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/return_to_icu_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function return_to_icu_dv_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/return_to_icu_dv_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/return_to_icu_dv_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function return_to_emr_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/return_to_emr_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/return_to_emr_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function return_to_emr_dv_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/return_to_emr_dv_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/return_to_emr_dv_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function code_pink_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/code_pink_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/code_pink_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function code_red_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/code_red_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/code_red_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function code_blue_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/code_blue_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/code_blue_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function safety_inspection_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/safety_inspection_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/safety_inspection_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }




    public function vap_prevention_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/vap_prevention_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/vap_prevention_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function catheter_insert_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/catheter_insert_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/catheter_insert_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function ssi_bundle_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/ssi_bundle_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/ssi_bundle_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function urinary_catheter_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/urinary_catheter_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/urinary_catheter_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function central_line_insert_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/central_line_insert_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/central_line_insert_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function central_maintenance_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/central_maintenance_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/central_maintenance_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function room_cleaning_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/room_cleaning_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/room_cleaning_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function other_cleaning_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/other_cleaning_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/other_cleaning_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function toilet_cleaning_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/toilet_cleaning_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/toilet_cleaning_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function canteen_audit_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/canteen_audit_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/canteen_audit_feedback', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/ip_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }



    public function edit_mrd_audit()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_mrd_audit', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_mrd_audit', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_mrd_audit_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            $data = array(


                'patient_got_admitted' => $this->input->post('initial_assessment_hr1'),
                'doctor_completed_assessment' => $this->input->post('initial_assessment_hr2'),
                'initial_assessment' => $this->input->post('calculatedResult'),
                'consent_verified' => $this->input->post('consent_verified'),
                'consent_comment' => $this->input->post('consent_comment'),
                'discharge_summary' => $this->input->post('discharge_summary'),
                'error_prone' => $this->input->post('error_prone'),
                'error_prone_comment' => $this->input->post('error_prone_comment'),
                'doctor_adviced_discharge' => $this->input->post('initial_assessment_hr3'),
                'bill_paid_time' => $this->input->post('initial_assessment_hr4'),
                'time_taken_for_discharge' => $this->input->post('calculatedDoctorAdviceToBillPaid'),
                'comments' => $this->input->post('dataAnalysis'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_mrd_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/mrd_audit_feedback?id=' . $id);
        } else {
            // Load the view with the form

        }
    }

    public function edit_ppe_audit_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'staffname' => $this->input->post('staffname'),
                'department' => $this->input->post('department'),
                'gloves' => $this->input->post('gloves'),
                'mask' => $this->input->post('mask'),
                'cap' => $this->input->post('cap'),
                'apron' => $this->input->post('apron'),
                'leadApron' => $this->input->post('leadApron'),

                'xrayBarrior' => $this->input->post('error_prone'),
                'tld' => $this->input->post('error_prone_comment'),
                'comment' => $this->input->post('comment_l'),
                'general_comment' => $this->input->post('general_comment'),
                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_ppe_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/ppe_audit_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_consultation_time_audit_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'department' => $this->input->post('department'),
                'register_time' => $this->input->post('initial_assessment_hr1'),
                'room_enter_time' => $this->input->post('initial_assessment_hr2'),
                'consultation_wait_time' => $this->input->post('calculatedResultTime'),
                'general_comment' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_consultation_time_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/op_consultation_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_lab_wait_time_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'testname' => $this->input->post('testname'),
                'billing_time' => $this->input->post('initial_assessment_hr1'),
                'sample_received_time' => $this->input->post('initial_assessment_hr2'),
                'lab_wait_time' => $this->input->post('calculatedResultTime'),
                'general_comment' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_lab_wait_time_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/lab_wait_time_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_xray_wait_time_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'billing_time' => $this->input->post('initial_assessment_hr1'),
                'procedure_entry_time' => $this->input->post('initial_assessment_hr2'),
                'xray_wait_time' => $this->input->post('calculatedResultTime'),
                'procedure_end_time' => $this->input->post('initial_assessment_hr3'),
                'general_comment' => $this->input->post('dataAnalysis'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_xray_wait_time_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/xray_wait_time_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_usg_wait_time_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'billing_time' => $this->input->post('initial_assessment_hr1'),
                'procedure_entry_time' => $this->input->post('initial_assessment_hr2'),
                'usg_wait_time' => $this->input->post('calculatedResultTime'),
                'report_getting_time' => $this->input->post('initial_assessment_hr3'),
                'general_comment' => $this->input->post('dataAnalysis'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_usg_wait_time_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/usg_wait_time_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_ctscan_time_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'billing_time' => $this->input->post('initial_assessment_hr1'),
                'procedure_entry_time' => $this->input->post('initial_assessment_hr2'),
                'ctscan_wait_time' => $this->input->post('calculatedResultTime'),
                'procedure_end_time' => $this->input->post('initial_assessment_hr3'),
                'general_comment' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_ctscan_time_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/ctscan_wait_time_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }
    public function edit_feedback_surgical_safety_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'surgeryname' => $this->input->post('surgeryname'),
                'date_of_surgery' => $this->input->post('initial_assessment_hr1'),
                'antibiotic' => $this->input->post('gloves'),
                'checklist' => $this->input->post('mask'),
                'bundle_care' => $this->input->post('cap'),
                'time_out' => $this->input->post('apron'),
                'unplanned_return' => $this->input->post('xrayBarrior'),
                'comments' => $this->input->post('dataAnalysis'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_surgical_safety_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/surgical_safety_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }
    public function edit_feedback_medicine_dispense_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'medicinename' => $this->input->post('medicinename'),
                'correct_medicine' => $this->input->post('gloves'),
                'correct_quantity' => $this->input->post('mask'),
                'medicine_expiry' => $this->input->post('cap'),

                'comments' => $this->input->post('dataAnalysis'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_medicine_dispense_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/medicine_dispensing_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_medication_administration_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'triple_check' => $this->input->post('gloves'),
                'medicine_labelled' => $this->input->post('mask'),
                'file_verified' => $this->input->post('cap'),
                'six_rights' => $this->input->post('apron'),
                'administration_documented' => $this->input->post('lead_apron'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_medication_administration_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/medication_administration_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_handover_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'ward' => $this->input->post('ward'),
                'designation' => $this->input->post('department'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'relevant_details' => $this->input->post('relevant_details'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_handover_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/handover_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_prescriptions_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'ward' => $this->input->post('ward'),
                'department' => $this->input->post('department'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),

                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'doctors_name' => $this->input->post('auditedBy'),


                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_prescriptions_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/prescriptions_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_hand_hygiene_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'employeename' => $this->input->post('testname'),
                'designation' => $this->input->post('designation'),
                'department' => $this->input->post('department'),
                'indication' => $this->input->post('indication'),
                'action' => $this->input->post('action'),
                'compliance' => $this->input->post('compliance'),



                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_hand_hygiene_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/hygiene_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_tat_blood_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'transfusion' => $this->input->post('department'),
                'transfusion_request_time' => $this->input->post('initial_assessment_hr1'),
                'blood_received_time' => $this->input->post('initial_assessment_hr2'),
                'tat_blood' => $this->input->post('calculatedResultTime'),
                'transfusion_started_time' => $this->input->post('initial_assessment_hr3'),
                'benchmark' => '04:00:00',



                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_tat_blood_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/tat_blood_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_nurse_patients_ratio_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'site' => $this->input->post('site'),
                'ward' => $this->input->post('ward'),
                'icu' => $this->input->post('icu'),
                'patient_status' => $this->input->post('department'),
                'beds' => $this->input->post('beds'),
                'nurses' => $this->input->post('nurses'),




                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_nurse_patients_ratio_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/nurse_patient_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_nurse_patients_ratio_ward_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'site' => $this->input->post('site'),
                'ward' => $this->input->post('ward'),
                'icu' => $this->input->post('icu'),
                'patient_status' => $this->input->post('department'),
                'beds' => $this->input->post('beds'),
                'nurses' => $this->input->post('nurses'),




                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_nurse_patients_ratio_ward_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/nurse_patient_ward_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_return_to_i_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'initial_admission' => $this->input->post('initial_assessment_hr1'),
                'complaintAdmission' => $this->input->post('complaintAdmit'),
                'treatmentAdmission' => $this->input->post('treatment_name'),
                'initial_discharge' => $this->input->post('initial_assessment_hr2'),
                're_admission' => $this->input->post('initial_assessment_hr3'),
                'time_duration' => $this->input->post('calculatedResultTime'),
                'complaintReadmission' => $this->input->post('complaint'),




                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_return_to_i_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/return_to_icu_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_return_to_icu_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'initial_admission' => $this->input->post('initial_assessment_hr1'),
                're_admitted_tf' => $this->input->post('gloves'),
                're_admitted_tf_comment' => $this->input->post('gloves_comment'),
                're_admitted_fe' => $this->input->post('mask'),
                're_admitted_fe_comment' => $this->input->post('mask_comment'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_return_to_icu_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/return_to_icu_dv_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_return_to_ed_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(



                'initial_consultation' => $this->input->post('initial_assessment_hr1'),
                'complaintConsultation' => $this->input->post('complaintAdmit'),
                'treatmentConsultation' => $this->input->post('treatment_name'),
                'revisit_time' => $this->input->post('initial_assessment_hr2'),
                'time_duration' => $this->input->post('calculatedResultTime'),
                'complaintReconsultation' => $this->input->post('complaint'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_return_to_ed_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/return_to_emr_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_return_to_emr_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(



                'patientid' => $this->input->post('patientid'),
                'initial_consultaion' => $this->input->post('initial_assessment_hr1'),
                'same_op_tf' => $this->input->post('gloves'),
                'same_op_tf_comment' => $this->input->post('gloves_comment'),
                'same_op_fe' => $this->input->post('mask'),
                'same_op_fe_comment' => $this->input->post('mask_comment'),
                'same_op_st' => $this->input->post('same_op'),
                'same_op_st_comment' => $this->input->post('same_op_comment'),
                're_consultation' => $this->input->post('condition'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_return_to_emr_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/return_to_emr_dv_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_mock_drill_pink_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(



                'location' => $this->input->post('location'),
                'name' => $this->input->post('name'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_mock_drill_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/code_pink_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_mock_drill_red_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(



                'location' => $this->input->post('location'),
                'name' => $this->input->post('name'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_mock_drill_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/code_red_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_feedback_mock_drill_blue_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(



                'location' => $this->input->post('location'),
                'name' => $this->input->post('name'),


                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_mock_drill_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/code_blue_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }





    public function edit_vap_prevention_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'relevant_details' => $this->input->post('relevant_details'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );



            // Update the data in the database
            $this->audit_model->update_bf_feedback_vap_prevention_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/vap_prevention_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_catheter_insert_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(

                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),
                'urine_sample' => $this->input->post('urine_sample'),
                'bystander' => $this->input->post('bystander'),


                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_catheter_insert_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/catheter_insert_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_ssi_bundle_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),
                'urine_sample' => $this->input->post('urine_sample'),
                'bystander' => $this->input->post('bystander'),
                'instruments' => $this->input->post('instruments'),
                'sterile' => $this->input->post('sterile'),
                'antibiotics' => $this->input->post('antibiotics'),
                'surgical_site' => $this->input->post('surgical_site'),
                'wound' => $this->input->post('wound'),
                'documented' => $this->input->post('documented'),


                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_ssi_bundle_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/ssi_bundle_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_urinary_catheter_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),
                'urine_sample' => $this->input->post('urine_sample'),
                'bystander' => $this->input->post('bystander'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_urinary_catheter_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/urinary_catheter_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_central_line_insert_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),
                'urine_sample' => $this->input->post('urine_sample'),
                'bystander' => $this->input->post('bystander'),
                'instruments' => $this->input->post('instruments'),


                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_central_line_insert_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/central_line_insert_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_central_maintenance_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'patientid' => $this->input->post('patientid'),
                'patientname' => $this->input->post('patientname'),
                'age' => $this->input->post('age'),
                'staffname' => $this->input->post('staffname'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),
                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                
                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_central_maintenance_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/central_maintenance_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_room_cleaning_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'area' => $this->input->post('area'),
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),
                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),
                'urine_sample' => $this->input->post('urine_sample'),
                'bystander' => $this->input->post('bystander'),
                

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_room_cleaning_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/room_cleaning_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_other_cleaning_insert_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'area' => $this->input->post('area'),
             
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                'facility_communicated' => $this->input->post('facility_communicated'),
                'health_education' => $this->input->post('health_education'),
                'risk_assessment' => $this->input->post('risk_assessment'),
                'urethral' => $this->input->post('urethral'),

                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_other_area_cleaning_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/other_cleaning_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }

    public function edit_toilet_cleaning_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'area' => $this->input->post('area'),
               
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                
                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_toilet_cleaning_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/toilet_cleaning_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }


    public function edit_canteen_audit_byid($id)
    {

        // Check if form is submitted
        if ($this->input->post()) {
            // Capture the value from the form input
            $dataCollected = $this->input->post('dataCollected');

            // Format the datetime and datet values
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));
            $data = array(


                'area' => $this->input->post('area'),
               
                'identification_details' => $this->input->post('identification_details'),
                'vital_signs' => $this->input->post('vital_signs'),
                'surgery' => $this->input->post('surgery'),

                'complaints_communicated' => $this->input->post('complaints_communicated'),
                'intake' => $this->input->post('intake'),
                'output' => $this->input->post('output'),
                'allergies' => $this->input->post('allergies'),
                'medication' => $this->input->post('medication'),
                'diagnostic' => $this->input->post('diagnostic'),
                'lab_results' => $this->input->post('lab_results'),
                'pending_investigation' => $this->input->post('pending_investigation'),
                'medicine_order' => $this->input->post('medicine_order'),
                
                'comments' => $this->input->post('dataAnalysis'),

                'datetime' => $formattedDatetime, // Correctly formatted datetime
                'datet' => $formattedDatet,       // Correctly formatted date
                'dataset'             => json_encode($_POST)
            );

            // Update the data in the database
            $this->audit_model->update_bf_feedback_canteen_audit($id, $data);

            // Redirect to a success page or wherever you need to go after the update
            redirect('audit/canteen_audit_feedback?id=' . $id);
        } else {
            // Load the view with the form


        }
    }



    public function edit_ppe_audit()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_ppe_audit', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_ppe_audit', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }
    public function edit_op_consultation()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_op_consultation', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_op_consultation', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_lab_time()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_lab_time', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_lab_time', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_xray_time()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_xray_time', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_xray_time', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }



    public function edit_usg_time()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_usg_time', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_usg_time', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_ctscan_time()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_ctscan_time', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_ctscan_time', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_surgical_safety()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_surgical_safety', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_surgical_safety', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_medicine_dispensing()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_medicine_dispensing', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_medicine_dispensing', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_medication_administration()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_medication_administration', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_medication_administration', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_handover_audit()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_handover_audit', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_handover_audit', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_prescriptions()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_prescriptions', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_prescriptions', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_hand_hygiene()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_hand_hygiene', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_hand_hygiene', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_tat_blood()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_tat_blood', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_tat_blood', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_nurse_patient_ratio()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_nurse_patient_ratio', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_nurse_patient_ratio', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_nurse_patient_ratio_ward()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_nurse_patient_ratio_ward', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_nurse_patient_ratio_ward', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_return_to_icu()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_return_to_icu', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_return_to_icu', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_return_to_icu_dv()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_return_to_icu_dv', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_return_to_icu_dv', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_return_to_emr()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_return_to_emr', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_return_to_emr', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_return_to_emr_dv()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_return_to_emr_dv', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_return_to_emr_dv', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_code_pink()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_code_pink', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_code_pink', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_code_red()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_code_red', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_code_red', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_code_blue()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_code_blue', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_code_blue', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_safety_inspection()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_safety_inspection', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_safety_inspection', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }


    public function edit_vap_prevention()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_vap_prevention', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_vap_prevention', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_catheter_insert()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_catheter_insert', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_catheter_insert', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_ssi_bundle()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_ssi_bundle', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_ssi_bundle', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_urinary_catheter()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_urinary_catheter', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_urinary_catheter', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_central_line_insert()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_central_line_insert', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_central_line_insert', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_central_maintenance()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_central_maintenance', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_central_maintenance', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_room_cleaning()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_room_cleaning', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_room_cleaning', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_other_cleaning()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_other_cleaning', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_other_cleaning', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_toilet_cleaning()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_toilet_cleaning', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_toilet_cleaning', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function edit_canteen_audit()
    {

        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $LOAD = pagetoload($this->module);
        if ($LOAD == 'inpatient_modules') {
            $data['title'] = 'EDIT AUDIT FORM';
            $data['departments'] = $this->tickets_model->read_by_id($this->uri->segment(3));
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/edit_canteen_audit', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_canteen_audit', $data, true);
            }
            //    $data['content'] = $this->load->view('qualitymodules/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }





    public function downloadcomments()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->ipd_model->setup_result($setup);
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

            $ip_feedbacks_count = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
            $ticket_resolution_rate = $this->ipd_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
            $ip_tickets_count = $this->tickets_model->alltickets();
            $ip_open_tickets = $this->tickets_model->read();
            $ip_closed_tickets = $this->tickets_model->read_close();
            $ip_addressed_tickets = $this->tickets_model->addressedtickets();

            $ip_nps = $this->ipd_model->nps_analytics($table_feedback, $asc, $setup);
            $ip_psat = $this->ipd_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);

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

            $ticket = $this->ipd_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
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


            $choice_of_hospitals = $this->ipd_model->reason_to_choose_hospital($table_feedback, $sorttime);

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

            $feedbacktaken = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->ipd_model->setup_result($setup);
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

    public function download_promoter_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $desc = 'desc';
            $setup = 'setup';

            $ip_nps = $this->ipd_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['promoters_feedbacks'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Email id';
            $header[6] = 'NPS score';
            $header[7] = 'Average rating';
            $header[8] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['bedno'] = $row->bedno;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['nps_score'] = ($row->recommend1Score) * 2;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['suggestionText'] = $row->suggestionText;

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD PROMOTERS LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function download_passive_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $desc = 'desc';
            $setup = 'setup';

            $ip_nps = $this->ipd_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['passives_feedback'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Email id';
            $header[6] = 'NPS score';
            $header[7] = 'Average rating';
            $header[8] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['bedno'] = $row->bedno;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['nps_score'] = ($row->recommend1Score) * 2;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['suggestionText'] = $row->suggestionText;

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD PASSIVES LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function download_detractor_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $desc = 'desc';
            $setup = 'setup';

            $ip_nps = $this->ipd_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['detractors_feedback'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Email id';
            $header[6] = 'NPS score';
            $header[7] = 'Average rating';
            $header[8] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['bedno'] = $row->bedno;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['nps_score'] = ($row->recommend1Score) * 2;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['suggestionText'] = $row->suggestionText;

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD DETRACTORS LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function download_staff_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $all_feedback = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);
            $feedback = $all_feedback;


            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Staff name';


            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {
                $param = json_decode($row->dataset);
                if ($param->staffname) {
                    $dataexport[$i]['name'] = $param->name;
                    $dataexport[$i]['patient_id'] = $param->patientid;
                    $dataexport[$i]['ward'] = $param->ward;
                    $dataexport[$i]['bedno'] = $param->bedno;
                    $dataexport[$i]['mobile'] = $param->contactnumber;
                    $dataexport[$i]['staffname'] = $param->staffname;


                    $i++;
                }
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD STAFF LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function download_satisfied_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $table_tickets = 'tickets';
            $desc = 'desc';
            $setup = 'setup';

            $ip_psat = $this->ipd_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);
            $feedback = $ip_psat['satisfied_feedback'];

            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Email id';
            $header[6] = 'Average rating';
            $header[7] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['bedno'] = $row->bedno;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['suggestionText'] = $row->suggestionText;

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD SATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function download_unsatisfied_list()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $table_feedback = 'bf_feedback';
            $table_patients = 'bf_patients';
            $table_tickets = 'tickets';
            $desc = 'desc';
            $setup = 'setup';

            $ip_psat = $this->ipd_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);
            $feedback = $ip_psat['unsatisfied_feedback'];

            $sresult = $this->ipd_model->setup_result($setup);

            foreach ($sresult as $r) {
                $questionarray[$r->shortkey] = $r->shortkey;
                $titles[$r->shortkey] = $r->title;
            }

            $rresult = $this->ipd_model->setup_sub_result($setup);
            foreach ($rresult as $r) {
                // $setarray[$r->type] = $r->title;
                $setarray[$r->shortkey] = $r->shortkey;
                $titles[$r->shortkey] = $r->title;
                $shortname[$r->shortkey] = $r->shortname;
            }


            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Floor/Ward';
            $header[3] = 'Room/Bed';
            $header[4] = 'Mobile Number';
            $header[5] = 'Email id';
            $header[6] = 'Average rating';
            $header[7] = 'NPS score';
            $header[8] = 'Departments';
            $header[9] = 'Concern';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['bedno'] = $row->bedno;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['nps_score'] = ($row->recommend1Score) * 2;
                foreach ($questionarray as $key) {
                    if (isset($row->$key) && $row->$key <= 3) {
                        $result->$key = $row->$key;
                        if ($result->$key) {
                            $dataexport[$i]['department'] = $titles[$key] . ' ';
                        }
                    }
                }

                foreach ($setarray as $key2) {
                    if (isset($row->reason->$key2) && $row->reason->$key2) {
                        $rzn->$key2 = $row->reason->$key2;
                        if ($rzn->$key2) {
                            $dataexport[$i]['concern'] = $shortname[$key2] . ' ';
                        }
                    }
                }

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'IPD UNSATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
            $ip_feedbacks_count = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $ticket_resolution_rate = $this->ipd_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

            $sresult = $this->ipd_model->setup_result($setup);
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

            $ticket = $this->ipd_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
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

    public function download_capa_report()
    {
        if (ismodule_active('IP') === true) {






            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];

            $this->db->select("*");

            $this->db->from('setup');

            //$this->db->where('parent', 0);

            $query = $this->db->get();

            $reasons = $query->result();

            foreach ($reasons as $row) {

                $keys[$row->shortkey] = $row->shortkey;

                $res[$row->shortkey] = $row->shortname;

                $titles[$row->shortkey] = $row->title;
            }



            $dataexport = array();

            $i = 0;

            $departments = $this->tickets_model->read_close();



            $dataexport[$i]['row1'] = 'SL No.';

            $dataexport[$i]['row2'] = 'TICKET ID';

            $dataexport[$i]['row3'] = 'CREATED ON';

            $dataexport[$i]['row4'] = 'PATIENT DETAILS';

            $dataexport[$i]['row5'] = 'CONCERN';

            $dataexport[$i]['row6'] = 'DEPARTMENT';

            $dataexport[$i]['row7'] = 'ASSIGNEE';

            $dataexport[$i]['row8'] = 'RCA';

            $dataexport[$i]['row9'] = 'CAPA';

            $dataexport[$i]['row10'] = 'RESOLVED ON';

            $dataexport[$i]['row11'] = 'TURN AROUND TIME';

            // $dataexport[$i]['row12'] = 'TAT STATUS';

            $i++;



            if (!empty($departments)) {

                $sl = 1;

                foreach ($departments as $department) {
                    // changes here sooraj
                    if ($department->status == 'Closed') {
                        if ($department->departmentid_trasfered != 0) {
                            $issue = NULL;
                        } else {
                            foreach ($department->feed->reason as $key => $value) {
                                if ($key) {
                                    if ($titles[$key] == $department->department->description) {
                                        if (in_array($key, $keys)) {
                                            $issue = $res[$key];
                                        }
                                    }
                                }
                            }
                        }

                        $root = [];
                        $corrective = [];
                        foreach ($department->replymessage as $r) {
                            if ($r->rootcause != NULL) {
                                $root[] = $r->rootcause;
                            }

                            if ($r->corrective != NULL) {
                                $corrective[] = $r->corrective;
                            }
                        }

                        $createdOn = strtotime($department->created_on);

                        $lastModified = strtotime($department->last_modified);

                        $timeDifferenceInSeconds = $lastModified - $createdOn;

                        $value = $this->ipd_model->convertSecondsToTime($timeDifferenceInSeconds);

                        $timetaken = '';

                        if ($value['days'] != 0) {

                            $timetaken .= $value['days'] . ' days, ';
                        }

                        if ($value['hours'] != 0) {

                            $timetaken .= $value['hours'] . ' hrs, ';
                        }

                        if ($value['minutes'] != 0) {

                            $timetaken .= $value['minutes'] . ' mins.';
                        }

                        if ($timeDifferenceInSeconds <= 60) {

                            $timetaken .= 'less than a minute';
                        }
                        $assignee = $department->department->pname;
                        $dataexport[$i]['row1'] = $sl;

                        $dataexport[$i]['row2'] = 'IPDT- ' . $department->id;

                        $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                        $dataexport[$i]['row4'] = $department->feed->name . '(' . $department->feed->patientid . ')';
                        if ($issue) {

                            $dataexport[$i]['row5'] = $issue;
                        } else {
                            $dataexport[$i]['row5'] = 'Ticket was transferred';
                        }

                        $dataexport[$i]['row6'] = $department->department->description;
                        if ($assignee) {
                            $dataexport[$i]['row7'] = $assignee;
                        } else {
                            $dataexport[$i]['row7'] = 'NA';
                        }
                        // changes here sooraj

                        $dataexport[$i]['row8'] = implode(", ", $root);

                        $dataexport[$i]['row9'] = implode(", ", $corrective);

                        $dataexport[$i]['row10'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                        $dataexport[$i]['row11'] = $timetaken;


                        $i++;

                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- IPD CAPA REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        }
    }

    public function download_alltickets()
    {
        if (ismodule_active('IP') === true) {




            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            $this->db->select("*");
            $this->db->from('setup');
            $query = $this->db->get();
            $reasons = $query->result();
            foreach ($reasons as $row) {
                $keys[$row->shortkey] = $row->shortkey;
                $res[$row->shortkey] = $row->shortname;
                $titles[$row->shortkey] = $row->title;
            }
            $dataexport = array();
            $i = 0;
            $departments = $this->tickets_model->alltickets();
            $dataexport[$i]['row1'] = 'SL No.';
            $dataexport[$i]['row2'] = 'TICKET ID';
            $dataexport[$i]['row3'] = 'CREATED ON';
            $dataexport[$i]['row4'] = 'PATIENT NAME';
            $dataexport[$i]['row5'] = 'PATIENT ID';
            $dataexport[$i]['row6'] = 'PHONE NUMBER';
            $dataexport[$i]['row7'] = 'FLOOR/WARD';
            $dataexport[$i]['row8'] = 'BED NUMBER';
            $dataexport[$i]['row9'] = 'CONCERN';
            $dataexport[$i]['row10'] = 'DEPARTMENT';
            $dataexport[$i]['row11'] = 'ASSIGNEE';
            $dataexport[$i]['row12'] = 'STATUS';
            $dataexport[$i]['row13'] = 'TRANSFERRED TO';
            $dataexport[$i]['row14'] = 'LAST MODIFIED';
            $i++;
            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    foreach ($department->feed->reason as $key => $value) {
                        if ($titles[$key] == $department->department->description) {
                            if (in_array($key, $keys)) {
                                $issue = $res[$key];
                            }
                        }


                        if ($department->departmentid_trasfered !== NULL && $department->departmentid_trasfered !== '') {
                            $this->db->select("*");
                            $this->db->from('department');
                            $this->db->where('dprt_id', $department->departmentid_trasfered);
                            $query = $this->db->get();
                            $moved_to_arr = $query->result();
                        }
                        $transfer_dep_desc = $moved_to_arr[0]->description;
                        if (!empty($department)) {
                            $dataexport[$i]['row1'] = $sl;
                            $dataexport[$i]['row2'] = 'IPDT- ' . $department->id;
                            $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                            $dataexport[$i]['row4'] = $department->feed->name;
                            $dataexport[$i]['row5'] = $department->feed->patientid;
                            $dataexport[$i]['row6'] = $department->feed->contactnumber;
                            $dataexport[$i]['row7'] = $department->feed->ward;
                            $dataexport[$i]['row8'] = $department->feed->bedno;
                            if ($issue) {

                                $dataexport[$i]['row9'] = $issue;
                            } else {
                                $dataexport[$i]['row9'] = 'Ticket was transferred';
                            }

                            $dataexport[$i]['row10'] = $department->department->description;
                            if ($department->department->pname != '' && $department->department->pname != NULL) {
                                $dataexport[$i]['row11'] = $department->department->pname;
                            } else {
                                $dataexport[$i]['row11'] = 'NA';
                            }
                            $dataexport[$i]['row12'] =  $department->status;
                            if ($transfer_dep_desc) {

                                $dataexport[$i]['row13'] =  $transfer_dep_desc;
                            } else {
                                $dataexport[$i]['row13'] =  'NA';
                            }
                            $dataexport[$i]['row14'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                        }
                    }
                    $i++;
                    $sl++;
                }
            }



            ob_end_clean();

            $fileName = 'EF- IPD ALL TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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


    public function download_opentickets()
    {
        if (ismodule_active('IP') === true) {




            $departments = $this->tickets_model->alltickets();
            if (!empty($departments)) {

                $fdate = $_SESSION['from_date'];
                $tdate = $_SESSION['to_date'];
                $this->db->select("*");
                $this->db->from('setup');
                $query = $this->db->get();
                $reasons = $query->result();
                foreach ($reasons as $row) {
                    $keys[$row->shortkey] = $row->shortkey;
                    $res[$row->shortkey] = $row->shortname;
                    $titles[$row->shortkey] = $row->title;
                }
                $dataexport = array();
                $i = 0;

                $dataexport[$i]['row1'] = 'SL No.';
                $dataexport[$i]['row2'] = 'TICKET ID';
                $dataexport[$i]['row3'] = 'CREATED ON';
                $dataexport[$i]['row4'] = 'PATIENT NAME';
                $dataexport[$i]['row5'] = 'PATIENT ID';
                $dataexport[$i]['row6'] = 'PHONE NUMBER';
                $dataexport[$i]['row7'] = 'FLOOR/WARD';
                $dataexport[$i]['row8'] = 'BED NUMBER';
                $dataexport[$i]['row9'] = 'CONCERN';
                $dataexport[$i]['row10'] = 'DEPARTMENT';
                $dataexport[$i]['row11'] = 'ASSIGNEE';
                $dataexport[$i]['row12'] = 'STATUS';
                $dataexport[$i]['row13'] = 'TRANSFERRED TO';
                $dataexport[$i]['row14'] = 'LAST MODIFIED';
                $i++;
            }
            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {
                    if ($department->status != 'Closed') {
                        foreach ($department->feed->reason as $key => $value) {
                            if ($titles[$key] == $department->department->description) {
                                if (in_array($key, $keys)) {
                                    $issue = $res[$key];
                                }
                            }
                        }


                        if ($department->departmentid_trasfered !== NULL && $department->departmentid_trasfered !== '') {
                            $this->db->select("*");
                            $this->db->from('department');
                            $this->db->where('dprt_id', $department->departmentid_trasfered);
                            $query = $this->db->get();
                            $moved_to_arr = $query->result();
                        }
                        $transfer_dep_desc = $moved_to_arr[0]->description;
                        if (!empty($department)) {

                            $dataexport[$i]['row1'] = $sl;
                            $dataexport[$i]['row2'] = 'IPDT- ' . $department->id;
                            $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                            $dataexport[$i]['row4'] = $department->feed->name;
                            $dataexport[$i]['row5'] = $department->feed->patientid;
                            $dataexport[$i]['row6'] = $department->feed->contactnumber;
                            $dataexport[$i]['row7'] = $department->feed->ward;
                            $dataexport[$i]['row8'] = $department->feed->bedno;

                            if ($issue) {

                                $dataexport[$i]['row9'] = $issue;
                            } else {
                                $dataexport[$i]['row9'] = 'Ticket was transferred';
                            }
                            $dataexport[$i]['row10'] = $department->department->description;
                            if ($department->department->pname != '' && $department->department->pname != NULL) {
                                $dataexport[$i]['row11'] = $department->department->pname;
                            } else {
                                $dataexport[$i]['row11'] = 'NA';
                            }
                            $dataexport[$i]['row12'] =  $department->status;
                            if ($transfer_dep_desc) {

                                $dataexport[$i]['row13'] =  $transfer_dep_desc;
                            } else {
                                $dataexport[$i]['row13'] =  'NA';
                            }
                            $dataexport[$i]['row14'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                        }

                        $i++;
                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- IPD OPEN TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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


    public function ticket_resolution_rate()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {

            $data['title'] = 'IP- TICKET RESOLUTION RATE';
            #------------------------------#
            $data['content'] = $this->load->view('auditmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function average_resolution_time()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('IP') === true) {


            $data['title'] = 'IP- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('auditmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
