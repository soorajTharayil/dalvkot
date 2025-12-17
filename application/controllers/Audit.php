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

        if (ismodule_active('AUDIT') === false && $this->uri->segment(2) != 'track')
            redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {
            $dateInfo = get_from_to_date();

            $data['title'] = 'QUALITY AUDIT MANAGER DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('audit_welcome_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function delete_audit($id)
    {
        $table = $this->input->get('table');

        if (empty($table)) {
            $this->session->set_flashdata('error', 'No table specified for deletion.');
            redirect($_SERVER['HTTP_REFERER']); // back to same page
            return;
        }

        $audit_array = [
            'bf_feedback_mrd_audit',
            'bf_feedback_ppe_audit',
            'bf_feedback_lab_safety_audit',
            'bf_feedback_consultation_time',
            'bf_feedback_lab_wait_time',
            'bf_feedback_xray_wait_time',
            'bf_feedback_usg_wait_time',
            'bf_feedback_ctscan_time',
            'bf_feedback_surgical_safety',
            'bf_feedback_medicine_dispense',
            'bf_feedback_medication_administration',
            'bf_feedback_handover',
            'bf_feedback_prescriptions',
            'bf_feedback_hand_hygiene',
            'bf_feedback_tat_blood',
            'bf_feedback_nurse_patients_ratio',
            'bf_feedback_return_to_i',
            'bf_feedback_return_to_icu',
            'bf_feedback_return_to_ed',
            'bf_feedback_return_to_emr',
            'bf_feedback_mock_drill',
            'bf_feedback_code_originals',
            'bf_feedback_safety_inspection',
            'bf_feedback_nurse_patients_ratio_ward',
            'bf_feedback_vap_prevention',
            'bf_feedback_catheter_insert',
            'bf_feedback_ssi_bundle',
            'bf_feedback_urinary_catheter',
            'bf_feedback_central_line_insert',
            'bf_feedback_central_maintenance',
            'bf_feedback_room_cleaning',
            'bf_feedback_other_area_cleaning',
            'bf_feedback_toilet_cleaning',
            'bf_feedback_canteen_audit',

        ];

        if (!in_array($table, $audit_array)) {
            $this->session->set_flashdata('error', 'Invalid table specified for deletion.');
            redirect($_SERVER['HTTP_REFERER']); // back to same page
            return;
        }

        // Prepare action log text
        $fullname = $this->session->userdata('fullname');
        $designation = $this->session->userdata('designation');
        $action_text = 'Audit Deleted by ' . $fullname . ' (' . $designation . ')';

        // ✅ Soft delete instead of actual delete
        $this->db->where('id', $id);
        $updated = $this->db->update($table, [
            'status' => 'Deleted',
            'action' => $action_text
        ]);

        if ($updated) {
            $this->session->set_flashdata('message', 'Audit record marked as deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to mark the record as deleted.');
        }

        redirect($_SERVER['HTTP_REFERER']); // back to same audit page
    }


    public function audit_master()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {
            $dateInfo = get_from_to_date();

            $data['title'] = 'AUDIT MASTER';
            #------------------------------#
            $data['content'] = $this->load->view('audit_master', $data, true);
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

        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'MRD AUDIT REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'RADIOLOGY SAFETY AUDIT REPORT';
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_ppe_audit', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_lab_safety_audit()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'LABORATORY SAFETY AUDIT REPORT';
            $data['content']  = $this->load->view('auditmodules/feedbacks_report_lab_safety_audit', $data, true);
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'OP CONSULTATION WAITING TIME REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'LABORATORY WAITING TIME REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'X-RAY WAITING TIME REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'USG WAITING TIME REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CT SCAN WAITING TIME REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'OPERATING ROOM SAFETY AUDIT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'MEDICATION MANAGEMENT PROCESS AUDIT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'MEDICATION ADMINISTRATION AUDIT REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'HANDOVER AUDIT REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'PRESCRIPTIONS AUDIT REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'HAND HYGIENE AUDIT REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'TAT FOR BLOOD ISSUE REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'NURSE-PATIENT RATIO REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'NURSE-PATIENT RATIO REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'ICU RETURN REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'ICU RETURN REPORT- DATA VERIFICATION';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'EMERGENCY RETURN REPORT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'EMERGENCY RETURN REPORT- DATA VERIFICATION';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'MOCK DRILLS AUDIT';
            $data['segment1'] = $this->uri->segment(1);
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CODE - ORIGINALS AUDIT';
            $data['segment1'] = $this->uri->segment(1);
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'FACILITY SAFETY INSPECTION CHECKLIST & AUDIT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'VAP PREVENTION CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CATHETER INSERTION CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'SSI BUNDLE CARE POLICY';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'URINARY CATHETER MAINTENANCE CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CENTRAL LINE INSERTION CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CENTRAL LINE MAINTENANCE CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'PATIENT ROOM CLEANING AUDIT';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'OTHER AREA CLEANING CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'TOILET CLEANING CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {
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

            $data['title'] = 'CANTEEN AUDIT CHECKLIST';
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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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

    public function lab_safety_audit_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {

            $data['title'] = 'QUALITY AUDIT FORM';
            #------------------------------#
            if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('auditmodules/lab_safety_audit_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/lab_safety_audit_feedback', $data, true);
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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {

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
        if ($this->input->post()) {

            // Fetch existing record
            $existing = $this->audit_model->get_bf_feedback_mrd_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle file removal
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

            // Handle new file uploads
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



            // Format datetime fields
            // $dataCollected = $this->input->post('dataCollected');
            // $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            // $formattedDatet = date('Y-m-d', strtotime($dataCollected));


            // Add back files into dataset
            $dataset['files_name'] = array_values($existingFiles);
            $dataset['initial_assessment_hr1']        = $this->input->post('initial_assessment_hr1');
            $dataset['initial_assessment_hr2'] = $this->input->post('initial_assessment_hr2');
            $dataset['calculatedResult']          = $this->input->post('calculatedResult');
            $dataset['consent_verified']            = $this->input->post('consent_verified');
            $dataset['consent_comment']             = $this->input->post('consent_comment');
            $dataset['discharge_summary']           = $this->input->post('discharge_summary');
            $dataset['error_prone']                 = $this->input->post('error_prone');
            $dataset['error_prone_comment']         = $this->input->post('error_prone_comment');
            $dataset['initial_assessment_hr3']    = $this->input->post('initial_assessment_hr3');
            $dataset['initial_assessment_hr4']              = $this->input->post('initial_assessment_hr4');
            $dataset['calculatedDoctorAdviceToBillPaid']    = $this->input->post('calculatedDoctorAdviceToBillPaid');
            $dataset['dataAnalysis']                    = $this->input->post('dataAnalysis');


            // Build data array for DB
            $data = [
                'patient_got_admitted'        => $this->input->post('initial_assessment_hr1'),
                'doctor_completed_assessment' => $this->input->post('initial_assessment_hr2'),
                'initial_assessment'          => $this->input->post('calculatedResult'),
                'consent_verified'            => $this->input->post('consent_verified'),
                'consent_comment'             => $this->input->post('consent_comment'),
                'discharge_summary'           => $this->input->post('discharge_summary'),
                'error_prone'                 => $this->input->post('error_prone'),
                'error_prone_comment'         => $this->input->post('error_prone_comment'),
                'doctor_adviced_discharge'    => $this->input->post('initial_assessment_hr3'),
                'bill_paid_time'              => $this->input->post('initial_assessment_hr4'),
                'time_taken_for_discharge'    => $this->input->post('calculatedDoctorAdviceToBillPaid'),
                'comments'                    => $this->input->post('dataAnalysis'),
                'dataset'                     => json_encode($dataset)
            ];

            // Update in database
            $this->audit_model->update_bf_feedback_mrd_audit($id, $data);

            // Redirect after update
            redirect('audit/mrd_audit_feedback?id=' . $id);
        } else {
            // Load edit view with existing record
            $data['record'] = $this->audit_model->get_bf_feedback_mrd_audit_byid($id);
            $this->load->view('audit/edit_mrd_audit_feedback', $data);
        }
    }


    public function edit_ppe_audit_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_ppe_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            // Save other form data into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // Update database
            $this->audit_model->update_bf_feedback_ppe_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/ppe_audit_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_ppe_audit_byid($id);
            $this->load->view('audit/edit_ppe_audit_feedback', $data);
        }
    }






    public function edit_lab_safety_audit_byid($id)
    {
        if ($this->input->post()) {
            // Fetch existing record
            $existing = $this->audit_model->get_bf_feedback_lab_safety_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // --- Handle removal of uploaded files ---
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

            // --- Handle new file uploads ---
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

            // Save updated file list
            $dataset['files_name'] = array_values($existingFiles);

            // --- Format datetime fields ---
            $dataCollected = $this->input->post('dataCollected');
            $formattedDatetime = date('Y-m-d H:i:s', strtotime($dataCollected));
            $formattedDatet = date('Y-m-d', strtotime($dataCollected));

            // --- Store all other form fields in dataset ---
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // --- Update DB ---
            $this->audit_model->update_bf_feedback_lab_safety_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            // --- Redirect ---
            redirect('audit/lab_safety_audit_feedback?id=' . $id);
        } else {
            // Load edit view with existing record
            $data['record'] = $this->audit_model->get_bf_feedback_lab_safety_audit_byid($id);
            $this->load->view('audit/edit_lab_safety_audit_feedback', $data);
        }
    }



    public function edit_consultation_time_audit_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_consultation_time_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle file removal
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

            // Handle new file uploads
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

            // Save other form fields into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_consultation_time_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/op_consultation_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_consultation_time_audit_byid($id);
            $this->load->view('audit/edit_consultation_time_audit_feedback', $data);
        }
    }



    public function edit_lab_wait_time_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_lab_wait_time_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle removed files
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

            // Handle new uploads
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

            // Save all POST fields into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_lab_wait_time_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/lab_wait_time_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_lab_wait_time_audit_byid($id);
            $this->load->view('audit/edit_lab_wait_time_feedback', $data);
        }
    }

    public function edit_feedback_xray_wait_time_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_xray_wait_time_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_xray_wait_time_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/xray_wait_time_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_xray_wait_time_audit_byid($id);
            $this->load->view('audit/edit_xray_wait_time_feedback', $data);
        }
    }

    public function edit_feedback_usg_wait_time_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_usg_wait_time_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_usg_wait_time_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/usg_wait_time_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_usg_wait_time_audit_byid($id);
            $this->load->view('audit/edit_usg_wait_time_feedback', $data);
        }
    }

    public function edit_feedback_ctscan_time_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_ctscan_time_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_ctscan_time_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/ctscan_wait_time_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_ctscan_time_audit_byid($id);
            $this->load->view('audit/edit_ctscan_wait_time_feedback', $data);
        }
    }

    public function edit_feedback_surgical_safety_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_surgical_safety_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            // Handle new uploads
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

            // Save all POST fields except file inputs
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_surgical_safety_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/surgical_safety_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_surgical_safety_audit_byid($id);
            $this->load->view('audit/edit_surgical_safety_feedback', $data);
        }
    }

    public function edit_feedback_medicine_dispense_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_medicine_dispense_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_medicine_dispense_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/medicine_dispensing_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_medicine_dispense_audit_byid($id);
            $this->load->view('audit/edit_medicine_dispense_feedback', $data);
        }
    }

    public function edit_feedback_medication_administration_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_medication_administration_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_medication_administration_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/medication_administration_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_medication_administration_audit_byid($id);
            $this->load->view('audit/edit_medication_administration_feedback', $data);
        }
    }

    public function edit_feedback_handover_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_handover_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_handover_audit($id, [
                'dataset' => json_encode($dataset)
            ]);

            redirect('audit/handover_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_handover_audit_byid($id);
            $this->load->view('audit/edit_handover_feedback', $data);
        }
    }


    // Prescriptions Feedback
    public function edit_feedback_prescriptions_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_prescriptions_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files
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

            // Save all POST fields except files
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_prescriptions_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/prescriptions_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_prescriptions_audit_byid($id);
            $this->load->view('audit/edit_prescriptions_feedback', $data);
        }
    }

    // Hand Hygiene Feedback
    public function edit_feedback_hand_hygiene_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_hand_hygiene_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_hand_hygiene_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/hygiene_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_hand_hygiene_audit_byid($id);
            $this->load->view('audit/edit_hand_hygiene_feedback', $data);
        }
    }

    // TAT Blood Feedback
    public function edit_feedback_tat_blood_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_tat_blood_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_tat_blood_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/tat_blood_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_tat_blood_audit_byid($id);
            $this->load->view('audit/edit_tat_blood_feedback', $data);
        }
    }

    // Nurse Patients Ratio Feedback
    public function edit_feedback_nurse_patients_ratio_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_nurse_patients_ratio_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_nurse_patients_ratio_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/nurse_patient_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_nurse_patients_ratio_audit_byid($id);
            $this->load->view('audit/edit_nurse_patients_ratio_feedback', $data);
        }
    }

    // Nurse Patients Ratio Ward Feedback
    public function edit_feedback_nurse_patients_ratio_ward_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_nurse_patients_ratio_ward_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_nurse_patients_ratio_ward_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/nurse_patient_ward_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_nurse_patients_ratio_ward_audit_byid($id);
            $this->load->view('audit/edit_nurse_patients_ratio_ward_feedback', $data);
        }
    }


    // Return to ICU Feedback
    public function edit_feedback_return_to_i_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_return_to_i_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Remove files
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
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_return_to_i_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/return_to_icu_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_return_to_i_audit_byid($id);
            $this->load->view('audit/edit_return_to_icu_feedback', $data);
        }
    }

    // Return to ICU DV Feedback
    public function edit_feedback_return_to_icu_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_return_to_icu_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_return_to_icu_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/return_to_icu_dv_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_return_to_icu_audit_byid($id);
            $this->load->view('audit/edit_return_to_icu_dv_feedback', $data);
        }
    }

    // Return to ED Feedback
    public function edit_feedback_return_to_ed_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_return_to_ed_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_return_to_ed_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/return_to_emr_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_return_to_ed_audit_byid($id);
            $this->load->view('audit/edit_return_to_ed_feedback', $data);
        }
    }

    // Return to EMR DV Feedback
    public function edit_feedback_return_to_emr_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_return_to_emr_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_return_to_emr_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/return_to_emr_dv_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_return_to_emr_audit_byid($id);
            $this->load->view('audit/edit_return_to_emr_feedback', $data);
        }
    }

    // Mock Drill Pink Feedback
    public function edit_feedback_mock_drill_pink_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_mock_drill_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/code_pink_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $this->load->view('audit/edit_mock_drill_feedback', $data);
        }
    }


    // Mock Drill Red Feedback
    public function edit_feedback_mock_drill_red_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_mock_drill_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/code_red_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $this->load->view('audit/edit_mock_drill_feedback_red', $data);
        }
    }

    // Mock Drill Blue Feedback
    public function edit_feedback_mock_drill_blue_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_mock_drill_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/code_blue_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_mock_drill_audit_byid($id);
            $this->load->view('audit/edit_mock_drill_feedback_blue', $data);
        }
    }

    // VAP Prevention Feedback
    public function edit_vap_prevention_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_vap_prevention_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_vap_prevention_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/vap_prevention_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_vap_prevention_audit_byid($id);
            $this->load->view('audit/edit_vap_prevention_feedback', $data);
        }
    }

    // Catheter Insert Feedback
    public function edit_catheter_insert_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_catheter_insert_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_catheter_insert_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/catheter_insert_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_catheter_insert_audit_byid($id);
            $this->load->view('audit/edit_catheter_insert_feedback', $data);
        }
    }

    // SSI Bundle Feedback
    public function edit_ssi_bundle_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_ssi_bundle_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_ssi_bundle_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/ssi_bundle_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_ssi_bundle_audit_byid($id);
            $this->load->view('audit/edit_ssi_bundle_feedback', $data);
        }
    }


    // Urinary Catheter Feedback
    public function edit_urinary_catheter_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_urinary_catheter_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle removed files
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

            // Handle uploaded files
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

            // Merge all POST data except file info
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_urinary_catheter_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/urinary_catheter_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_urinary_catheter_audit_byid($id);
            $this->load->view('audit/edit_urinary_catheter_feedback', $data);
        }
    }

    // Central Line Insert Feedback
    public function edit_central_line_insert_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_central_line_insert_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_central_line_insert_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/central_line_insert_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_central_line_insert_audit_byid($id);
            $this->load->view('audit/edit_central_line_insert_feedback', $data);
        }
    }

    // Central Maintenance Feedback
    public function edit_central_maintenance_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_central_maintenance_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_central_maintenance_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/central_maintenance_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_central_maintenance_audit_byid($id);
            $this->load->view('audit/edit_central_maintenance_feedback', $data);
        }
    }


    // Room Cleaning Feedback
    public function edit_room_cleaning_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_room_cleaning_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle removed files
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

            // Handle new uploads
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

            // Merge all POST data except file info
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            $this->audit_model->update_bf_feedback_room_cleaning_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/room_cleaning_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_room_cleaning_audit_byid($id);
            $this->load->view('audit/edit_room_cleaning_feedback', $data);
        }
    }

    // Other Area Cleaning Feedback
    public function edit_other_cleaning_insert_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_other_area_cleaning_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_other_area_cleaning_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/other_cleaning_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_other_area_cleaning_audit_byid($id);
            $this->load->view('audit/edit_other_cleaning_feedback', $data);
        }
    }

    // Toilet Cleaning Feedback
    public function edit_toilet_cleaning_byid($id)
    {
        if ($this->input->post()) {
            $existing = $this->audit_model->get_bf_feedback_toilet_cleaning_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
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

            $this->audit_model->update_bf_feedback_toilet_cleaning_audit($id, ['dataset' => json_encode($dataset)]);
            redirect('audit/toilet_cleaning_feedback?id=' . $id);
        } else {
            $data['record'] = $this->audit_model->get_bf_feedback_toilet_cleaning_audit_byid($id);
            $this->load->view('audit/edit_toilet_cleaning_feedback', $data);
        }
    }
    public function edit_canteen_audit_byid($id)
    {
        if ($this->input->post()) {
            // Get existing record and dataset
            $existing = $this->audit_model->get_bf_feedback_canteen_audit_byid($id);
            $dataset = json_decode($existing->dataset, true) ?: [];
            $existingFiles = $dataset['files_name'] ?? [];

            // Handle removed files
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

            // Handle new file uploads
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

            // Merge all POST data (except file-specific fields) into dataset
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['uploaded_files', 'remove_files_json'])) {
                    $dataset[$key] = $value;
                }
            }

            // Update record in DB
            $this->audit_model->update_bf_feedback_canteen_audit($id, ['dataset' => json_encode($dataset)]);

            // Redirect to feedback page
            redirect('audit/canteen_audit_feedback?id=' . $id);
        } else {
            // Load edit form view with current record
            $data['record'] = $this->audit_model->get_bf_feedback_canteen_audit_byid($id);
            $this->load->view('audit/edit_canteen_feedback', $data);
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


    public function edit_lab_safety_audit()
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
                $data['content'] = $this->load->view('auditmodules/edit_lab_safety_audit', $data, true);
            } else {
                $data['content'] = $this->load->view('auditmodules/dephead/edit_lab_safety_audit', $data, true);
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
        if (ismodule_active('AUDIT') === true) {


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

    // Raw data for each audit


    public function overall_mrd_audit()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {

            $table_feedback = 'bf_feedback_mrd_audit';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';


            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);

            //if KPI is connected to this audit
            if (isset($_GET['kpi']) && $_GET['kpi'] == 1) {

                $from = isset($_GET['from']) ? $_GET['from'] : null;
                $to   = isset($_GET['to']) ? $_GET['to'] : null;

                if ($from && $to) {
                    $filtered = [];

                    foreach ($feedbacktaken as $row) {

                        $audit_date = date('Y-m-d', strtotime($row->datetime));

                        if ($audit_date >= $from && $audit_date <= $to) {
                            $filtered[] = $row;
                        }
                    }

                    // Replace only for KPI-triggered download
                    $feedbacktaken = $filtered;
                }
            }
            //END


            $sresult = $this->audit_model->setup_result($setup);
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

            // CSV headers (unchanged)
            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';

            $header[$j++] = 'Admitted time';
            $header[$j++] = 'Initial assessment time';
            $header[$j++] = 'Time taken for initial assessment';
            $header[$j++] = 'Consent verified';
            $header[$j++] = 'Discharge summary';
            $header[$j++] = 'Error prone abbreviation';
            $header[$j++] = 'Discharge advice time';
            $header[$j++] = 'Billing time';
            $header[$j++] = 'Time taken for discharge';

            $header[$j++] = 'Additional comments';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));

                $dataexport[$i]['initial_assessment_hr1'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr1']));
                $dataexport[$i]['initial_assessment_hr2'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr2']));
                $dataexport[$i]['calculatedResultTime'] = $data['calculatedResultTime'];

                $dataexport[$i]['consent_verified'] = ucfirst($data['consent_verified']) . "\r\nRemarks: " . $data['consent_verified_text'];
                $dataexport[$i]['discharge_summary'] = ucfirst($data['discharge_summary']) . "\r\nRemarks: " . $data['discharge_summary_text'];
                $dataexport[$i]['error_prone'] = ucfirst($data['error_prone']) . "\r\nRemarks: " . $data['error_prone_text'];

                $dataexport[$i]['initial_assessment_hr3'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr3']));
                $dataexport[$i]['initial_assessment_hr4'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr4']));
                $dataexport[$i]['calculatedDoctorAdviceToBillPaid'] = date('H:i:s', strtotime($data['calculatedDoctorAdviceToBillPaid']));

                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];

                $i++;
            }



            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();

            // Filename
            if (isset($_GET['kpi']) && $_GET['kpi'] == 1) {
                $fileName = 'EF- MRD AUDIT -' . $_GET['from'] . '-to-' . $_GET['to'] . '.csv';
            } else if (isset($_GET['filtertype']) && $_GET['filtertype'] === 'admission') {
                $fileName = 'EF- MRD AUDIT - Filtered by Admission Date - ' . $tdate . ' to ' . $fdate . '.csv';
            } else {
                $fileName = 'EF- MRD AUDIT - ' . $tdate . ' to ' . $fdate . '.csv';
            }



            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($dataexport[0])) {
                $fp = fopen('php://output', 'w');
                fputcsv($fp, $header, ',');
                foreach ($dataexport as $values) {
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

    public function overall_surgical_audit()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_surgical_safety';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            $header[$j++] = 'Surgery name';
            $header[$j++] = 'Surgery date';


            $header[$j++] = 'Has the patient\'s identity been confirmed by verifying the ID band?';
            $header[$j++] = 'Has the surgical site been marked?';
            $header[$j++] = 'Has the informed consent been completed and documented?';
            $header[$j++] = 'Has the availability of artificial dentures, eyes, or other appliances been checked?';
            $header[$j++] = 'Have HIV, HBsAg, and HCV tests been completed?';
            $header[$j++] = 'Has the time of last oral intake (fluid/food) been mentioned?';
            $header[$j++] = 'Has the patients weight been documented?';
            $header[$j++] = 'Has the time of urine voiding been documented?';
            $header[$j++] = 'Has the anaesthesia safety check been completed?';
            $header[$j++] = 'Has the patients drug allergy history been verified?';
            $header[$j++] = 'Has antibiotic prophylaxis been verified as given prior to surgery?';
            $header[$j++] = 'Was the antibiotic given within the last 60 minutes before surgery?';
            $header[$j++] = 'Has it been checked whether thromboprophylaxis has been ordered?';
            $header[$j++] = 'Have the surgeon, anaesthesia professionals, and nurse verbally confirmed incision time, patient identity, surgical site and procedure?';
            $header[$j++] = 'Have anticipated clinical events been reviewed by surgeon, anaesthesia & nursing team?';
            $header[$j++] = 'Have anticipated equipment issues or concerns been reviewed?';
            $header[$j++] = 'Has it been confirmed whether prosthesis/equipment required is available?';
            $header[$j++] = 'Has display of essential imaging been checked?';
            $header[$j++] = 'Has the name of the procedure been recorded?';
            $header[$j++] = 'Have counts of instruments/sponges/needles been checked?';
            $header[$j++] = 'Has the closure time been documented?';
            $header[$j++] = 'Has the specimen labeling been completed with the correct patient name?';
            $header[$j++] = 'Are there any equipment problems that need to be addressed or reported?';
            $header[$j++] = 'Have the surgeon, anaesthesia professionals, and nurse reviewed the key concerns for the patients recovery and ongoing management?';



            $header[$j++] = 'Additional comments';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));

                $dataexport[$i]['surgeryname'] = $data['surgeryname'];
                $dataexport[$i]['initial_assessment_hr1'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr1']));


                $dataexport[$i]['antibiotic'] = ucfirst($data['antibiotic']) . "\r\nRemarks: " . $data['antibiotic_text'];
                $dataexport[$i]['checklist'] = ucfirst($data['checklist']) . "\r\nRemarks: " . $data['checklist_text'];
                $dataexport[$i]['bundle_care'] = ucfirst($data['bundle_care']) . "\r\nRemarks: " . $data['bundle_care_text'];
                $dataexport[$i]['time_out'] = ucfirst($data['time_out']) . "\r\nRemarks: " . $data['time_out_text'];
                $dataexport[$i]['unplanned_return'] = ucfirst($data['unplanned_return']) . "\r\nRemarks: " . $data['unplanned_return_text'];
                $dataexport[$i]['last_oral'] = ucfirst($data['last_oral']) . "\r\nRemarks: " . $data['last_oral_text'];
                $dataexport[$i]['patients_weight'] = ucfirst($data['patients_weight']) . "\r\nRemarks: " . $data['patients_weight_text'];
                $dataexport[$i]['urine_void'] = ucfirst($data['urine_void']) . "\r\nRemarks: " . $data['urine_void_text'];
                $dataexport[$i]['anaesthesia'] = ucfirst($data['anaesthesia']) . "\r\nRemarks: " . $data['anaesthesia_text'];
                $dataexport[$i]['drug_allergy'] = ucfirst($data['drug_allergy']) . "\r\nRemarks: " . $data['drug_allergy_text'];
                $dataexport[$i]['prophylaxis'] = ucfirst($data['prophylaxis']) . "\r\nRemarks: " . $data['prophylaxis_text'];
                $dataexport[$i]['antibiotic_given'] = ucfirst($data['antibiotic_given']) . "\r\nRemarks: " . $data['antibiotic_given_text'];
                $dataexport[$i]['thromboprophylaxis'] = ucfirst($data['thromboprophylaxis']) . "\r\nRemarks: " . $data['thromboprophylaxis_text'];
                $dataexport[$i]['anaesthesia_professionals'] = ucfirst($data['anaesthesia_professionals']) . "\r\nRemarks: " . $data['anaesthesia_professionals_text'];
                $dataexport[$i]['clinical_events'] = ucfirst($data['clinical_events']) . "\r\nRemarks: " . $data['clinical_events_text'];
                $dataexport[$i]['anticipated_equipment'] = ucfirst($data['anticipated_equipment']) . "\r\nRemarks: " . $data['anticipated_equipment_text'];
                $dataexport[$i]['prosthesis'] = ucfirst($data['prosthesis']) . "\r\nRemarks: " . $data['prosthesis_text'];
                $dataexport[$i]['imaging'] = ucfirst($data['imaging']) . "\r\nRemarks: " . $data['imaging_text'];
                $dataexport[$i]['procedure_name'] = ucfirst($data['procedure_name']) . "\r\nRemarks: " . $data['procedure_name_text'];
                $dataexport[$i]['instruments_counts'] = ucfirst($data['instruments_counts']) . "\r\nRemarks: " . $data['instruments_counts_text'];
                $dataexport[$i]['closure_time'] = ucfirst($data['closure_time']) . "\r\nRemarks: " . $data['closure_time_text'];
                $dataexport[$i]['specimen_labeling'] = ucfirst($data['specimen_labeling']) . "\r\nRemarks: " . $data['specimen_labeling_text'];
                $dataexport[$i]['equipment_report'] = ucfirst($data['equipment_report']) . "\r\nRemarks: " . $data['equipment_report_text'];
                $dataexport[$i]['patients_recovery'] = ucfirst($data['patients_recovery']) . "\r\nRemarks: " . $data['patients_recovery_text'];



                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];


                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- OPERATING ROOM SAFETY AUDIT - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_medicine_audit()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_medicine_dispense';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            $header[$j++] = 'Surgery name';
            $header[$j++] = 'Surgery date';
            $header[$j++] = 'Consultant Name';
            $header[$j++] = 'Diagnosis';
            $header[$j++] = 'Medicine Name';
            


            $header[$j++] = 'Has the correct drug been selected for the patient\'s condition?';
            $header[$j++] = 'Has the appropriate dose been prescribed?';
            $header[$j++] = 'Has the correct unit of measurement for the drug dose been used?';
            $header[$j++] = 'Has the correct frequency of administration been specified?';
            $header[$j++] = 'Has the correct route of administration been mentioned?';
            $header[$j++] = 'Has the correct drug concentration been prescribed?';
            $header[$j++] = 'Has the correct rate of administration been indicated?';
            
            $header[$j++] = 'Has the prescription been checked for therapeutic duplication?';
            
            $header[$j++] = 'Is the handwriting legible and easily understandable?';
            
            $header[$j++] = 'Have only approved medical abbreviations been used in the prescription?';
            
            $header[$j++] = 'Have drug names been written using capital letters to avoid confusion?';
            
            $header[$j++] = 'Has the drug been prescribed using its generic name?';
            
            $header[$j++] = 'Has the drug dose been modified considering potential drug-drug interactions?';
            
            $header[$j++] = 'Has the timing, dose, or choice of drug been adjusted considering food-drug interactions?';
            
            $header[$j++] = 'Has the correct drug been dispensed as per the prescription?';
            $header[$j++] = 'Has the correct dose of the medication been dispensed?';
            $header[$j++] = 'Has the correct formulation (e.g., tablet, syrup, injection) been dispensed?';
            $header[$j++] = 'Has the pharmacist ensured that expired or near-expiry drugs are not dispensed?';
            $header[$j++] = 'Has the medication been properly labeled with accurate patient and drug information?';
            $header[$j++] = 'Was the medication dispensed within the defined acceptable timeframe?';
            $header[$j++] = 'Has any generic or therapeutic substitution been done only after consulting the prescribing doctor?';
            
            $header[$j++] = 'Has the medication been administered to the correct patient?';
            $header[$j++] = 'Has any prescribed dose been unintentionally omitted?';
            $header[$j++] = 'Has the correct dose of the medication been administered?';
            $header[$j++] = 'Has the correct drug been administered as per the prescription?';
            $header[$j++] = 'Has the correct dosage form (e.g., tablet, injection, syrup) been used?';
            $header[$j++] = 'Has the correct route of administration (e.g., oral, IV, IM) been followed?';
            $header[$j++] = 'Has the medication been administered at the correct rate?';
            $header[$j++] = 'Has the medication been administered for the correct duration?';
            $header[$j++] = 'Has the medication been given at the correct time as prescribed?';
            $header[$j++] = 'Has the drug administration been properly documented?';
            $header[$j++] = 'Has the documentation by nursing staff been complete and accurate?';
            $header[$j++] = 'Has there been any documentation without actual drug administration?';



            $header[$j++] = 'Additional comments';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));

                $dataexport[$i]['surgeryname'] = $data['surgeryname'];
                $dataexport[$i]['initial_assessment_hr1'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr1']));
                $dataexport[$i]['consultant_name'] = $data['consultant_name'];
                $dataexport[$i]['diagnosis'] = $data['diagnosis'];
                $dataexport[$i]['medicinename'] = $data['medicinename'];



                $dataexport[$i]['correct_medicine'] = ucfirst($data['correct_medicine']) . "\r\nRemarks: " . $data['correct_medicine_text'];
                $dataexport[$i]['correct_quantity'] = ucfirst($data['correct_quantity']) . "\r\nRemarks: " . $data['correct_quantity_text'];
                $dataexport[$i]['medicine_expiry'] = ucfirst($data['medicine_expiry']) . "\r\nRemarks: " . $data['medicine_expiry_text'];
                $dataexport[$i]['apron'] = ucfirst($data['apron']) . "\r\nRemarks: " . $data['apron_text'];
                $dataexport[$i]['lead_apron'] = ucfirst($data['lead_apron']) . "\r\nRemarks: " . $data['lead_apron_text'];
                $dataexport[$i]['use_xray_barrior'] = ucfirst($data['use_xray_barrior']) . "\r\nRemarks: " . $data['use_xray_barrior_text'];
                $dataexport[$i]['administration_rate'] = ucfirst($data['administration_rate']) . "\r\nRemarks: " . $data['administration_rate_text'];

                $dataexport[$i]['therapeutic_duplication'] = ucfirst($data['therapeutic_duplication']) . "\r\nRemarks: " . $data['therapeutic_duplication_text'];
                // 3. Illegible Handwriting
                $dataexport[$i]['handwriting_legible'] =
                    ucfirst($data['handwriting_legible']) . "\r\nRemarks: " . $data['handwriting_legible_text'];
                
                // 4. Non-approved Abbreviations
                $dataexport[$i]['medical_abbreviations'] =
                    ucfirst($data['medical_abbreviations']) . "\r\nRemarks: " . $data['medical_abbreviations_text'];
                
                // 5. Non-usage of Capital Letters for Drug Names
                $dataexport[$i]['capital_letters'] =
                    ucfirst($data['capital_letters']) . "\r\nRemarks: " . $data['capital_letters_text'];
                
                $dataexport[$i]['generic_name'] =
                    ucfirst($data['generic_name']) . "\r\nRemarks: " . $data['generic_name_text'];
                
                $dataexport[$i]['drug_interaction'] =
                    ucfirst($data['drug_interaction']) . "\r\nRemarks: " . $data['drug_interaction_text'];
                    // 4. Food-Drug Interaction
                    $dataexport[$i]['food_drug'] =
                        ucfirst($data['food_drug']) . "\r\nRemarks: " . $data['food_drug_text'];
                    
                    // 5. Drug Dispensed
                    $dataexport[$i]['drug_dispensed'] =
                        ucfirst($data['drug_dispensed']) . "\r\nRemarks: " . $data['drug_dispensed_text'];
                    
                    // 6. Dose Dispensed
                    $dataexport[$i]['dose_dispensed'] =
                        ucfirst($data['dose_dispensed']) . "\r\nRemarks: " . $data['dose_dispensed_text'];
                    
                    // 7. Formulation Dispensed
                    $dataexport[$i]['formulation_dispensed'] =
                        ucfirst($data['formulation_dispensed']) . "\r\nRemarks: " . $data['formulation_dispensed_text'];
                    
                    // 8. Expired Drugs
                    $dataexport[$i]['expired_drungs'] =
                        ucfirst($data['expired_drungs']) . "\r\nRemarks: " . $data['expired_drungs_text'];
                    
                    // 9. Accurate Patient
                    $dataexport[$i]['accurate_patient'] =
                        ucfirst($data['accurate_patient']) . "\r\nRemarks: " . $data['accurate_patient_text'];
                    
                    // 10. Medication Dispense
                    $dataexport[$i]['medication_dispese'] =
                        ucfirst($data['medication_dispese']) . "\r\nRemarks: " . $data['medication_dispese_text'];
                    
                    // 11. Generic Substitution
                    $dataexport[$i]['generic_substitution'] =
                        ucfirst($data['generic_substitution']) . "\r\nRemarks: " . $data['generic_substitution_text'];
                        // a. Correct Patient
                    $dataexport[$i]['correct_patient'] =
                        ucfirst($data['correct_patient']) . "\r\nRemarks: " . $data['correct_patient_text'];
                    
                    // b. Dose Omitted
                    $dataexport[$i]['dose_omitted'] =
                        ucfirst($data['dose_omitted']) . "\r\nRemarks: " . $data['dose_omitted_text'];
                    
                    // c. Medication Dose
                    $dataexport[$i]['medication_dose'] =
                        ucfirst($data['medication_dose']) . "\r\nRemarks: " . $data['medication_dose_text'];
                    
                    // d. Drug Administered
                    $dataexport[$i]['drug_administered'] =
                        ucfirst($data['drug_administered']) . "\r\nRemarks: " . $data['drug_administered_text'];
                    
                    // e. Correct Dosage
                    $dataexport[$i]['correct_dosage'] =
                        ucfirst($data['correct_dosage']) . "\r\nRemarks: " . $data['correct_dosage_text'];
                    
                    // f. Correct Route
                    $dataexport[$i]['correct_route'] =
                        ucfirst($data['correct_route']) . "\r\nRemarks: " . $data['correct_route_text'];
                    
                    // g. Correct Rate
                    $dataexport[$i]['correct_rate'] =
                        ucfirst($data['correct_rate']) . "\r\nRemarks: " . $data['correct_rate_text'];
                    
                    // h. Correct Duration
                    $dataexport[$i]['correct_duration'] =
                        ucfirst($data['correct_duration']) . "\r\nRemarks: " . $data['correct_duration_text'];
                    
                    // i. Correct Time
                    $dataexport[$i]['correct_time'] =
                        ucfirst($data['correct_time']) . "\r\nRemarks: " . $data['correct_time_text'];
                    
                    // j. Drug Administration
                    $dataexport[$i]['drug_administration'] =
                        ucfirst($data['drug_administration']) . "\r\nRemarks: " . $data['drug_administration_text'];
                    
                    // k. Nursing Staff
                    $dataexport[$i]['nursing_staff'] =
                        ucfirst($data['nursing_staff']) . "\r\nRemarks: " . $data['nursing_staff_text'];
                        // l. Documentation Drug
                    $dataexport[$i]['documentation_drug'] =
                        ucfirst($data['documentation_drug']) . "\r\nRemarks: " . $data['documentation_drug_text'];




                

                



                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];


                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- MEDICATION MANAGEMENT PROCESS AUDIT - ' . $tdate . ' to ' . $fdate . '.csv';
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


    public function overall_administration_audit()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_medication_administration';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            
                        
                       
            $header[$j++] = 'Have you checked your own medications and verified the medication order including drug name, dose, route, time, and frequency?';
            $header[$j++] = 'Did you confirm that the prescribed medicine is written in the order?';
            $header[$j++] = 'Is the medication tray stocked with all required articles?';
            $header[$j++] = 'Did you perform handwashing or use hand rub before administering the medication to the patient?';
            $header[$j++] = 'Did you greet and identify the patient using two identification methods?';
            $header[$j++] = 'Have you explained the procedure to the patient and verified their allergic status?';
            $header[$j++] = 'Did you check and ensure that all medications are present at the patient’s side along with the patient’s file?';
            $header[$j++] = 'Have you verified the medicine for its name, expiry date, color, and texture?';
            $header[$j++] = 'Did you explain the drug indication, expected action, reaction, and side effects to the patient or relatives?';
            $header[$j++] = 'Is all medicine available for use at the bedside on time?';
            $header[$j++] = 'For high-alert drugs, did you ensure verification by one staff nurse before administration?';
            $header[$j++] = 'Have you labeled the prepared medicine with the drug name and dilution?';
            $header[$j++] = 'Are you administering the medication as per approved techniques?';
            $header[$j++] = 'Did you provide privacy for the patient if needed?';
            $header[$j++] = 'For multi-dose vials, did you note the date and time of opening on the medicine?';
            $header[$j++] = 'Did you check the patency and status of the cannula, including the date and time of cannulation near the site?';
            $header[$j++] = 'After IV administration, did you flush the line with normal saline?';
            $header[$j++] = 'Are IV medications being run on time, and have they been discontinued or discarded appropriately?';
            $header[$j++] = 'After administering the medication, did you reassess the patient for any reactions and ensure their comfort?';
            $header[$j++] = 'For oral medications, have you ensured that the patient has taken the medications and that no medicine is left unattended?';
            $header[$j++] = 'Have you discarded waste and replaced used articles?';
            $header[$j++] = 'Did you perform handwashing or use hand rub after the procedure?';
            $header[$j++] = 'Have you recorded the procedure in the documents immediately after completing it?';
            $header[$j++] = 'Additional comments';


            $header[$j++] = 'Additional comments';

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                    // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));

                $dataexport[$i]['gloves'] = ucfirst($data['gloves']) . "\r\nRemarks: " . $data['gloves_text'];
                
                $dataexport[$i]['mask'] = ucfirst($data['mask']) . "\r\nRemarks: " . $data['mask_text'];
                
                $dataexport[$i]['cap'] = ucfirst($data['cap']) . "\r\nRemarks: " . $data['cap_text'];
                
                $dataexport[$i]['apron'] = ucfirst($data['apron']) . "\r\nRemarks: " . $data['apron_text'];
                
                $dataexport[$i]['lead_apron'] = ucfirst($data['lead_apron']) . "\r\nRemarks: " . $data['lead_apron_text'];

                $dataexport[$i]['use_xray_barrior'] = ucfirst($data['use_xray_barrior']) . "\r\nRemarks: " . $data['use_xray_barrior_text'];
                
                $dataexport[$i]['patient_file'] = ucfirst($data['patient_file']) . "\r\nRemarks: " . $data['patient_file_text'];
                
                $dataexport[$i]['verified'] = ucfirst($data['verified']) . "\r\nRemarks: " . $data['verified_text'];
                
                $dataexport[$i]['indication'] = ucfirst($data['indication']) . "\r\nRemarks: " . $data['indication_text'];
                
                $dataexport[$i]['medicine'] = ucfirst($data['medicine']) . "\r\nRemarks: " . $data['medicine_text'];
                
                $dataexport[$i]['alert'] = ucfirst($data['alert']) . "\r\nRemarks: " . $data['alert_text'];
                
                $dataexport[$i]['dilution'] = ucfirst($data['dilution']) . "\r\nRemarks: " . $data['dilution_text'];
                
                $dataexport[$i]['administering'] = ucfirst($data['administering']) . "\r\nRemarks: " . $data['administering_text'];
                $dataexport[$i]['privacy'] = ucfirst($data['privacy']) . "\r\nRemarks: " . $data['privacy_text'];
                
                $dataexport[$i]['vials'] = ucfirst($data['vials']) . "\r\nRemarks: " . $data['vials_text'];
                
                $dataexport[$i]['cannula'] = ucfirst($data['cannula']) . "\r\nRemarks: " . $data['cannula_text'];
                
                $dataexport[$i]['flush'] = ucfirst($data['flush']) . "\r\nRemarks: " . $data['flush_text'];
                
                $dataexport[$i]['medications'] = ucfirst($data['medications']) . "\r\nRemarks: " . $data['medications_text'];
                
                $dataexport[$i]['reassess'] = ucfirst($data['reassess']) . "\r\nRemarks: " . $data['reassess_text'];
                
                $dataexport[$i]['oral'] = ucfirst($data['oral']) . "\r\nRemarks: " . $data['oral_text'];
                
                $dataexport[$i]['discarded'] = ucfirst($data['discarded']) . "\r\nRemarks: " . $data['discarded_text'];
                
                
                $dataexport[$i]['handwashing'] = ucfirst($data['handwashing']) . "\r\nRemarks: " . $data['handwashing_text'];
                
                $dataexport[$i]['procedures'] = ucfirst($data['procedures']) . "\r\nRemarks: " . $data['procedures_text'];
                


                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];


                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'MEDICATION ADMINISTRATION AUDIT - ' . $tdate . ' to ' . $fdate . '.csv';
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


  public function overall_prescription_audit()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_prescriptions';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            
            $header[$j++] = 'Ward';
            $header[$j++] = 'Name of the Consultant';
            $header[$j++] = 'Is the prescription written in capital letters?';
            $header[$j++] = 'Is the route of administration mentioned?';
            $header[$j++] = 'Is the dose mentioned?';
            $header[$j++] = 'Is the frequency mentioned?';
            $header[$j++] = 'Is the patient identification present?';
            $header[$j++] = 'Does the prescription use any non-standard abbreviations?';
            $header[$j++] = 'Is the date mentioned?';
            $header[$j++] = 'Is the name & sign of Doctor present?';
            $header[$j++] = 'Additional comments';


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                    // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));
                
                $dataexport[$i]['ward'] = $data['ward'];
                $dataexport[$i]['staffname'] = $data['staffname'];

                $dataexport[$i]['identification_details'] = ucfirst($data['identification_details']) . "\r\nRemarks: " . $data['identification_details_text'];
                
                $dataexport[$i]['vital_signs'] = ucfirst($data['vital_signs']) . "\r\nRemarks: " . $data['vital_signs_text'];
                
                $dataexport[$i]['surgery'] = ucfirst($data['surgery']) . "\r\nRemarks: " . $data['surgery_text'];
                
                $dataexport[$i]['complaints_communicated'] = ucfirst($data['complaints_communicated']) . "\r\nRemarks: " . $data['complaints_communicated_text'];
                
                $dataexport[$i]['intake'] = ucfirst($data['intake']) . "\r\nRemarks: " . $data['intake_text'];
                
                $dataexport[$i]['output'] = ucfirst($data['output']) . "\r\nRemarks: " . $data['output_text'];
                
                $dataexport[$i]['data_mentioned'] = ucfirst($data['data_mentioned']) . "\r\nRemarks: " . $data['data_mentioned_text'];
                
                $dataexport[$i]['sign_doctor'] = ucfirst($data['sign_doctor']) . "\r\nRemarks: " . $data['sign_doctor_text'];


                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];


                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'PRESCRIPTIONS AUDIT  - ' . $tdate . ' to ' . $fdate . '.csv';
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



  public function overall_tat_blood()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_tat_blood';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient MID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            $header[$j++] = 'Select Transfusion Type';
            $header[$j++] = 'Time at which transfusion request was given';
            $header[$j++] = 'Time at which blood/blood product was received';
            $header[$j++] = 'Turn around time';
            $header[$j++] = 'Benchmark';
            $header[$j++] = 'Time at which transfusion started';
            $header[$j++] = 'Additional comments';


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                    // exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];

                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));
                    
                $dataexport[$i]['dep'] = $data['dep'];
                $dataexport[$i]['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
                $dataexport[$i]['initial_assessment_hr2'] = $data['initial_assessment_hr2'];
                $dataexport[$i]['turn_around_time'] = $data['calculatedResultTime'];
                $dataexport[$i]['benchmark'] = $data['benchmark'];
                $dataexport[$i]['initial_assessment_hr3'] = $data['initial_assessment_hr3'];

                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];


                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'TAT FOR BLOOD ISSUE - ' . $tdate . ' to ' . $fdate . '.csv';
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



  public function overall_nurse_patient()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_nurse_patients_ratio';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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
            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Site';
            $header[4] = 'Selected ICU';
            $header[5] = 'Patient Status';
            $header[6] = 'Number of Occupied Beds';
            $header[7] = 'Number of Nurses';
            $header[8] = 'Additional Comments';
           
              $j = 9;

            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    //  echo '<pre>';
                    //  print_r($data);
                    //  echo '</pre>';
                    //  exit;
                       
                       
            $dataexport[$i]['audit_type'] = $data['audit_type'];
            $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
            $dataexport[$i]['audit_by'] = $data['audit_by'];
            
            $dataexport[$i]['site'] = $data['site'];
            $dataexport[$i]['icu'] = $data['icu'];
            $dataexport[$i]['department'] = $data['department'];
            $dataexport[$i]['beds'] = $data['beds'];
            $dataexport[$i]['nurses'] = $data['nurses'];
            $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis'];   // textarea (comments)
            

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'NURSE-PATIENT RATIO - ' . $tdate . ' to ' . $fdate . '.csv';
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


  public function overall_icu_return()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_return_to_i';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient MID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            $header[$j++] = 'Date & Time of Initial Admission';
            $header[$j++] = 'Complaint at the Time of Admission';
            $header[$j++] = 'Treatment Given at the Time of Admission';
            $header[$j++] = 'Date & Time of Initial Discharge';
            $header[$j++] = 'Date & Time of Re-admission';
            $header[$j++] = 'Time Duration Between Discharge and Re-admission';
            $header[$j++] = 'Complaint at the Time of Re-admission';
            $header[$j++] = 'Additional Comments';
            
                        
            
          

           


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                   //  echo '<pre>';
                   //  print_r($data);
                    // echo '</pre>';
                  //   exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];
                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));
                $dataexport[$i]['initial_assessment_hr1'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr1']));
                $dataexport[$i]['complaintAdmit'] = $data['complaintAdmit'];
                $dataexport[$i]['treatment_name'] = $data['treatment_name'];
                $dataexport[$i]['initial_assessment_hr2'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr2']));
                $dataexport[$i]['initial_assessment_hr3'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr3']));
                $dataexport[$i]['complaint'] = $data['complaint'];

               
            

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'ICU RETURN - ' . $tdate . ' to ' . $fdate . '.csv';
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


  public function overall_icu_verification()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_return_to_icu';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            $header[$j++] = 'Date of Initial Admission';
            $header[$j++] = 'Re-admission Within 24 Hours After Discharge';
            $header[$j++] = 'Re-admission Within 48 Hours After Discharge';
            $header[$j++] = 'Additional Comments';


            
            
           


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                   //  echo '<pre>';
                    // print_r($data);
                   //  echo '</pre>';
                 //   exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];
                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));
               
                $dataexport[$i]['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
                $dataexport[$i]['gloves'] = $data['gloves'];
                $dataexport[$i]['mask'] = $data['mask'];
                 $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis']; 

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'ICU RETURN REPORT  DATA VERIFICATION - ' . $tdate . ' to ' . $fdate . '.csv';
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


 public function overall_emergency_return()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_return_to_ed';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            $header[$j++] = 'Date & Time of Initial Consultation';
            $header[$j++] = 'Complaint at the Time of Consultation';
            $header[$j++] = 'Treatment Given at the Time of Consultation';
            $header[$j++] = 'Revisit Date & Time';
             $header[$j++] = 'Calculate result';
            $header[$j++] = 'Complaint at the Time of Re-consultation';
            $header[$j++] = 'Additional Comments';



            
            
           


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    // echo '<pre>';
                     //print_r($data);
                    // echo '</pre>';
                  //  exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];
                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                
                $dataexport[$i]['location'] = $data['location'];
                $dataexport[$i]['department'] = $data['department'];
                $dataexport[$i]['attended_doctor'] = $data['attended_doctor'];
                $dataexport[$i]['initial_assessment_hr6'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr6']));
                $dataexport[$i]['discharge_date_time'] = date('Y-m-d H:i', strtotime($data['discharge_date_time']));
              
                $dataexport[$i]['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
                $dataexport[$i]['complaintAdmit'] = $data['complaintAdmit'];
                $dataexport[$i]['treatment_name'] = $data['treatment_name'];
                $dataexport[$i]['initial_assessment_hr2'] = $data['initial_assessment_hr2'];
                 $dataexport[$i]['calculatedResultTime'] = $data['calculatedResultTime'];
                $dataexport[$i]['complaint'] = $data['complaint'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis']; 

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EMERGENCY RETURN REPORT- ' . $tdate . ' to ' . $fdate . '.csv';
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





 public function overall_emergency_verification()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('AUDIT') === true) {


            $table_feedback = 'bf_feedback_return_to_emr';
            $table_patients = 'bf_patients';
            $desc = 'desc';
            $setup = 'setup';

            $feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->audit_model->setup_result($setup);
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


            $header[0] = 'Audit Name';
            $header[1] = 'Date & Time of Audit';
            $header[2] = 'Audit by';
            $header[3] = 'Patient UHIID';
            $header[4] = 'Patient Name';
            $header[5] = 'Patient Age';
            $header[6] = 'Patient Gender';

            $j = 7;

            $header[$j++] = 'Area';
            $header[$j++] = 'Department';
            $header[$j++] = 'Attended Doctor';
            $header[$j++] = 'Admission / Visit Date & Time';
            $header[$j++] = 'Discharge Date & Time';
            
            $header[$j++] = 'Date & Time of Initial Consultation';
            $header[$j++] = 'Same OP Number Recorded Within 24 Hours';
            $header[$j++] = 'Same OP Number Recorded Within 48 Hours';
            $header[$j++] = 'Same OP Number Recorded Within 72 Hours';
            $header[$j++] = 'Patient Condition at Re-consultation';
            $header[$j++] = 'Additional Comments';

            
           


            $dataexport = [];
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                    // echo '<pre>';
                     //print_r($data);
                    // echo '</pre>';
                  //  exit;

                $dataexport[$i]['audit_type'] = $data['audit_type'];
                $dataexport[$i]['date'] = date('Y-m-d H:i', strtotime($row->datetime));
                $dataexport[$i]['audit_by'] = $data['audit_by'];
                $dataexport[$i]['mid_no'] = $data['mid_no'];
                $dataexport[$i]['patient_name'] = $data['patient_name'];
                $dataexport[$i]['patient_age'] = $data['patient_age'];
                $dataexport[$i]['patient_gender'] = $data['patient_gender'];
                
                $dataexport[$i]['initial_assessment_hr1'] = date('Y-m-d H:i', strtotime($data['initial_assessment_hr1']));
                $dataexport[$i]['gloves'] = $data['gloves'];
                $dataexport[$i]['gloves_comment'] = $data['gloves_comment'];
                $dataexport[$i]['mask'] = $data['mask'];
                $dataexport[$i]['mask_comment'] = $data['mask_comment'];
                $dataexport[$i]['condition'] = $data['condition'];
                $dataexport[$i]['dataAnalysis'] = $data['dataAnalysis']; 

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EMERGENCY RETURN REPORT- DATA VERIFICATION - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {


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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {






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
        if (ismodule_active('AUDIT') === true) {




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
        if (ismodule_active('AUDIT') === true) {




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
        if (ismodule_active('AUDIT') === true) {

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
        if (ismodule_active('AUDIT') === true) {


            $data['title'] = 'IP- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('auditmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
