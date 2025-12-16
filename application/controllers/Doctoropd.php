<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doctoropd extends CI_Controller
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
                'ticketsopddoctor_model',
                'doctorsopdfeedback_model',
                'setting_model',
                'Trend_analytic_model',
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
        $this->module = 'outpatient_modules';
        $this->session->set_userdata([
            'active_menu' => array('opddoctor_dashboard', 'opddoctor_ticket', 'opddoctor_reports', 'opddoctor_patients', 'opddoctor_settings', 'opddoctor_dep', 'opddoctor_analysis'),
        ]);
        // if (ismodule_active('DOCTOR-OPD') === false  && $this->uri->segment(2) != 'track')
        //     redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR MODULE CONFIGURATION';
            $data['content'] = $this->load->view('doctoropdmodules/developer', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function trend_analytic()
    {
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }

        if (ismodule_active('DOCTOR-OPD') === true) {
            // Get the 'type' from the URI segment
            $type = $this->uri->segment(3);

            // Fetch the title_category based on the 'type'
            $query = $this->db->select('title, shortname, id, shortkey')
                ->from('setup_doctor_opd')
                ->where('type', $type)
                ->get();

            $result = $query->result();

            // Check if a result exists
            if (!empty($result)) {
                $title_category = strtoupper($result[0]->title);

                // Pass the category title to the dashboard title
                $data['title'] = "OPD DOCTOR CATEGORY ANALYSIS DASHBOARD - $title_category";
            } else {
                // If no result found, fallback to default title
                $data['title'] = 'OPD DOCTOR CATEGORY ANALYSIS DASHBOARD';
            }

            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/trend_analytic', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function dep_tat_edit()
    {

        if (ismodule_active('DOCTOR-OPD') === true) {

            if ($_POST) {
                $close_time = $this->input->post('tat');
                $close_time_l1 = $close_time['close_time_l1'];
                $close_time_l2 = $close_time['close_time_l2'];
                $dept_level_escalation = $close_time['dept_level_escalation'];

                foreach ($close_time_l1 as $key => $row) {
                    $data = array('close_time' => $close_time_l1[$key], 'close_time_l2' => $close_time_l2[$key], 'dept_level_escalation' => $dept_level_escalation[$key]);
                    $this->db->where('dprt_id', $key);
                    $this->db->update('department', $data);
                }
            }


            $data['title'] = 'OPD DOCTOR-Manage Turn Around Time';

            #------------------------------#

            $data['content'] = $this->load->view('doctoropdmodules/dep_tat_edit', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    // SUPER ADMIN AND ADMIN LOGIN
    public function feedback_dashboard()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'OPD DOCTOR- FEEDBACKS DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/feedback_dashboard', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function ticket_dashboard()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'OPD DOCTOR- TICKETS DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/ticket_dashboard', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    //START ANALYTICS
    public function nps_page()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'OPD DOCTOR- NPS ANALYSIS';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/nps_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    //2
    public function nps_promoter_list()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- NPS PROMOTERS LIST';
            $data['content'] = $this->load->view('doctoropdmodules/nps_promoter_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function nps_detractors_list()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- NPS DETRACTORS LIST';

            $data['content'] = $this->load->view('doctoropdmodules/nps_detractors_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function nps_passive_list()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'OPD DOCTOR- NPS PASSIVES LIST';

            $data['content'] = $this->load->view('doctoropdmodules/nps_passive_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function psat_satisfied_list()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- SATISFIED FEEDBACKS LIST';
            $data['content'] = $this->load->view('doctoropdmodules/psat_satisfied_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function psat_unsatisfied_list()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- UNSATISFIED FEEDBACKS LIST';
            $data['content'] = $this->load->view('doctoropdmodules/psat_unsatisfied_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function psat_page()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- DSAT ANALYSIS';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/psat_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    //END ANALYTICS
    // END SUPER ADMIN AND ADMIN LOGIN


    // DEPARTMENT HEAD LOGIN
    public function department_tickets()
    {

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) {

            $data['title'] = 'OPD DOCTOR- TICKETS DASHBOARD';
            $data['content'] = $this->load->view('doctoropdmodules/department_tickets', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            //used for department head login

        } else {
            redirect('dashboard/noaccess');
        }
    }
    // END DEPARTMENT HEAD LOGIN

    public function admin_track()
    {


        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }

        if ($this->session->userdata('isLogIn') == false)
            redirect('login');


        $data['title'] = 'OPD DOCTOR- TICKET DETAILS';
        $data['departments'] = $this->ticketsopddoctor_model->read_by_id($this->uri->segment(3));
        $data['content'] = $this->load->view('doctoropdmodules/ticket_track', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }



    //START TICKETS 
    public function alltickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- ALL TICKETS';
            $dates = get_from_to_date();
            $data['departments'] = $this->ticketsopddoctor_model->alltickets();

            if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('doctoropdmodules/alltickets', $data, true);
            } else {
                $data['content'] = $this->load->view('doctoropdmodules/dephead/alltickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    //addressed ticket
    public function addressedtickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- ADDRESSED TICKETS';
            $dates = get_from_to_date();
            $data['departments'] = $this->ticketsopddoctor_model->addressedtickets();

            if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('doctoropdmodules/addressedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('doctoropdmodules/dephead/addressedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    // ticket tracking
    public function track()
    {
        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }


        $data['title'] = 'OPD DOCTOR- TICKET DETAILS';
        $data['departments'] = $this->ticketsopddoctor_model->read_by_id($this->uri->segment(3));

        if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {
            $data['content'] = $this->load->view('doctoropdmodules/ticket_track', $data, true);
        } else {
            $data['content'] = $this->load->view('doctoropdmodules/dephead/ticket_track', $data, true);
        }
        $this->load->view('layout/main_wrapper', $data);
    }

    // open tickets
    public function opentickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- OPEN TICKETS';
            $dates = get_from_to_date();
            $data['departments'] = $this->ticketsopddoctor_model->read();

            if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('doctoropdmodules/opentickets', $data, true);
            } else {
                $data['content'] = $this->load->view('doctoropdmodules/dephead/opentickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    // closed tickets
    public function closedtickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- CLOSED TICKETS';
            $dates = get_from_to_date();
            $data['departments'] = $this->ticketsopddoctor_model->read_close();

            if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('doctoropdmodules/closedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('doctoropdmodules/dephead/closedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    //END TICKETS 

    //  REPORTS

    public function capa_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- CAPA REPORT';
            $dates = get_from_to_date();
            $data['departments'] = $this->ticketsopddoctor_model->read_close();

            $data['content'] = $this->load->view('doctoropdmodules/capa_report', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/op_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function feedbacks_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- ALL FEEDBACKS REPORT';
            $data['content']  = $this->load->view('doctoropdmodules/feedbacks_report', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/feedbacks_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function feedbacks_report_login_apk()
    {
        $userName = $this->session->userdata['fullname'];




        $data['title'] = 'OP feedbacks collected by ' . $userName . '';
        $data['content']  = $this->load->view('doctoropdmodules/op_feedbacks_report_login_apk', $data, true);
        $this->load->view('layout/main_wrapper', $data);
        // redirect('report/feedbacks_report');


    }



    public function comments()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR COMMENTS LIST';
            $data['content'] = $this->load->view('doctoropdmodules/recent_comments', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/op_recent_comments');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function patient_feedback()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTORS FEEDBACK';
            #------------------------------#
            if (isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) {

                $data['content'] = $this->load->view('doctoropdmodules/patient_feedback', $data, true);
            } else {
                $data['content'] = $this->load->view('doctoropdmodules/dephead/patient_feedback', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/op_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function notifications()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $data['title'] = 'OPD DOCTOR- FEEDBACK NOTIFICATIONS';
            $data['content'] = $this->load->view('doctoropdmodules/notifications_list', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    //END REPORTS

    // OP DASHBOARD DOWNLOADS

    public function downloadcomments()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {


            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $feedbacktaken = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->doctorsopdfeedback_model->setup_result($setup);
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
            $header[1] = 'Doctor Name';
            $header[2] = 'Asisstant Surgeon';
            $header[3] = 'Scrub Nurse';
            $header[4] = 'Mobile Number';
            $j = 5;
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

            $fileName = 'EF- OPD DOCTOR COMMENTS - ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function overall_excel_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {

            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $sorttime = 'asc';
            $setup = 'setup_doctor_opd';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets_doctor_opd';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'doctoropd';
            $op_feedbacks_count = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $op_tickets_count = $this->ticketsopddoctor_model->alltickets();
            $op_open_tickets = $this->ticketsopddoctor_model->read();
            $op_closed_tickets = $this->ticketsopddoctor_model->read_close();
            $op_addressed_tickets = $this->ticketsopddoctor_model->addressedtickets();

            $op_feedbacks_count = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);


            $op_nps = $this->doctorsopdfeedback_model->nps_analytics($table_feedback, $asc, $setup);
            $op_psat = $this->doctorsopdfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
            $ticket_resolution_rate = $this->doctorsopdfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
            $dataexport = array();
            $i = 0;

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $dataexport[$i]['row1'] = 'OPD DOCTOR FEEDBACK OVERALL REPORT';
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
            $dataexport[$i]['row2'] =  $fdate;
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TOTAL FEEDBACKS SUBMITTED';
            $dataexport[$i]['row2'] = count($op_feedbacks_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'SATISFACTION INDEX';
            $dataexport[$i]['row2'] = $op_psat['psat_score'] . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'SATISFIED FEEDBACKS';
            $dataexport[$i]['row2'] =  $op_psat['satisfied_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'UNSATISFIED FEEDBACKS';
            $dataexport[$i]['row2'] = $op_psat['unsatisfied_count'];
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
            $dataexport[$i]['row2'] =  $op_nps['nps_score'] . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF PROMOTERS';
            $dataexport[$i]['row2'] = $op_nps['promoters_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF PASSIVES';
            $dataexport[$i]['row2'] = $op_nps['passives_count'];
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'NO. OF DETRACTORS';
            $dataexport[$i]['row2'] = $op_nps['detractors_count'];
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
            $dataexport[$i]['row2'] = count($op_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TICKET RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'OPEN TICKETS';
            $dataexport[$i]['row2'] = count($op_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;
            if (ticket_addressal('op_addressal') === true) {
                $dataexport[$i]['row1'] = 'ADDRESSED TICKETS';
                $dataexport[$i]['row2'] = count($op_addressed_tickets);
                $dataexport[$i]['row3'] = '';
                $dataexport[$i]['row4'] = '';
                $i++;
            }
            $dataexport[$i]['row1'] = 'CLOSED TICKETS';
            $dataexport[$i]['row2'] = count($op_closed_tickets);
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
            if (ticket_addressal('op_addressal') === true) {

                $dataexport[$i]['row5'] = 'ADDRESSED';
            }
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = 'RESOLUTION TIME';
            $dataexport[$i]['row9'] = '';
            $i++;

            $ticket = $this->doctorsopdfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
            foreach ($ticket as $ps) {
                $time = secondsToTimeforreport($ps['res_time']);
                $dataexport[$i]['row1'] = $ps['department'];
                $dataexport[$i]['row2'] = $ps['percentage'] . '%';
                $dataexport[$i]['row3'] = $ps['count'];
                $dataexport[$i]['row4'] = $ps['open_tickets'];
                if (ticket_addressal('op_addressal') === true) {

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

            $dataexport[$i]['row1'] = 'WHICH IS STRENGTHS OF THE HOSPITALS?';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'REASON';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = '';
            $i++;


            $choice_of_hospitals = $this->doctorsopdfeedback_model->reason_to_choose_hospital($table_feedback, $sorttime);

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
            $fileName = 'EF - OVERALL OPD DOCTOR FEEDBACKS REPORT  - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {


            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $feedbacktaken = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->doctorsopdfeedback_model->setup_result($setup);
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
            $header[1] = 'Doctor Name';
            $header[2] = 'Employee ID';
            $header[3] = 'Speciality';
            $header[4] = 'Mobile No';

            $j = 5;
            foreach ($arraydata as $k => $r) {
                $header[$j] = $r;
                $j++;
            }
            $header[$j++] = 'Average Rating';
            $header[$j++] = 'NPS Score';
            $header[$j++] = 'Comments';
            foreach ($setarray as $r) {
                $header[$j] = $r . ' comment';
                $j++;
            }
            $dataexport = array();
            $i = 0;
            foreach ($feedbacktaken as $row) {
                $data = json_decode($row->dataset, true);

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // exit;


                $dataexport[$i]['date'] = date('d-m-Y', strtotime($row->datetime));
                $dataexport[$i]['name'] = $data['name'];
                $dataexport[$i]['patientid'] = $data['patientid'];
                $dataexport[$i]['ward'] = $data['ward'];
                $dataexport[$i]['contactnumber'] = $data['contactnumber'];

                

                foreach ($arraydata as $k => $r) {
                    $dataexport[$i][$k] = $data[$k];
                }
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
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- OPD DOCTOR WISE FEEDBACK REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {


            $table_feedback = 'bf_feedback_doctors_opd';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $ip_nps = $this->doctorsopdfeedback_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['promoters_feedbacks'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Speciality';
            $header[3] = 'Mobile Number';
            $header[4] = 'Email id';
            $header[5] = 'NPS score';
            $header[6] = 'Average rating';
            $header[7] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
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
            $fileName = 'DOCTOR PROMOTERS LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {


            $table_feedback = 'bf_feedback_doctors_opd';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $ip_nps = $this->doctorsopdfeedback_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['passives_feedback'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Speciality';
            $header[3] = 'Mobile Number';
            $header[4] = 'Email id';
            $header[5] = 'NPS score';
            $header[6] = 'Average rating';
            $header[7] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
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
            $fileName = 'DOCTOR PASSIVES LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {


            $table_feedback = 'bf_feedback_doctors_opd';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $ip_nps = $this->doctorsopdfeedback_model->nps_analytics($table_feedback, $desc, $setup);
            $feedback = $ip_nps['detractors_feedback'];



            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Speciality';
            $header[3] = 'Mobile Number';
            $header[4] = 'Email id';
            $header[5] = 'NPS score';
            $header[6] = 'Average rating';
            $header[7] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
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
            $fileName = 'DOCTOR DETRACTORS LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {

            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $table_tickets = 'tickets_doctor_opd';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $ip_psat = $this->doctorsopdfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);
            $feedback = $ip_psat['satisfied_feedback'];

            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Speciality';
            $header[3] = 'Mobile Number';
            $header[4] = 'Email id';
            $header[5] = 'Average rating';
            $header[6] = 'General comment';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
                $dataexport[$i]['mobile'] = $row->contactnumber;
                $dataexport[$i]['email'] = $row->email;
                $dataexport[$i]['overallScore'] = $row->overallScore;
                $dataexport[$i]['suggestionText'] = $row->suggestionText;

                $i++;
            }


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'DOCTOR SATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {

            $dataexport = array();
            $i = 0;
            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $sorttime = 'asc';
            $setup = 'setup_doctor_opd';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets_doctor_opd';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'doctoropd';
            $ticket_resolution_rate = $this->doctorsopdfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);
            $op_feedbacks_count = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $op_tickets_count = $this->ticketsopddoctor_model->alltickets();
            $op_open_tickets = $this->ticketsopddoctor_model->read();
            $op_closed_tickets = $this->ticketsopddoctor_model->read_close();
            $op_addressed_tickets = $this->ticketsopddoctor_model->addressedtickets();

            $sresult = $this->doctorsopdfeedback_model->setup_result($setup);
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
            $dataexport[$i]['row2'] = count($op_feedbacks_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'TOTAL TICKETS';
            $dataexport[$i]['row2'] = count($op_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'TICKET RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'OPEN TICKETS';
            $dataexport[$i]['row2'] = count($op_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;
            if (ticket_addressal('op_addressal') === true) {

                $dataexport[$i]['row1'] = 'ADDRESSED TICKETS';
                $dataexport[$i]['row2'] = count($op_addressed_tickets);
                $dataexport[$i]['row3'] = '';
                $dataexport[$i]['row4'] = '';
                $i++;
            }
            $dataexport[$i]['row1'] = 'CLOSED TICKETS';
            $dataexport[$i]['row2'] = count($op_closed_tickets);
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
            if (ticket_addressal('op_addressal') === true) {

                $dataexport[$i]['row5'] = 'ADDRESSED';
            }
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = 'RESOLUTION TIME';
            $dataexport[$i]['row9'] = '';
            $i++;

            $ticket = $this->doctorsopdfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);
            foreach ($ticket as $ps) {
                $time = secondsToTimeforreport($ps['res_time']);
                $dataexport[$i]['row1'] = $ps['department'];
                $dataexport[$i]['row2'] = $ps['percentage'] . '%';
                $dataexport[$i]['row3'] = $ps['count'];
                $dataexport[$i]['row4'] = $ps['open_tickets'];
                $dataexport[$i]['row5'] = $ps['addressed_tickets'];
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

            foreach ($op_feedbacks_count as $row) {
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



            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            ob_end_clean();
            $fileName = 'EF- OPD DOCTOR DEPARTMENT WISE TICKET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {

            $table_feedback = 'bf_feedback_doctors_opd';
            $table_patients = 'bf_opatients';
            $table_tickets = 'tickets_doctor_opd';
            $desc = 'desc';
            $setup = 'setup_doctor_opd';

            $ip_psat = $this->doctorsopdfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);
            $feedback = $ip_psat['unsatisfied_feedback'];

            $sresult = $this->doctorsopdfeedback_model->setup_result($setup);

            foreach ($sresult as $r) {
                $questionarray[$r->shortkey] = $r->shortkey;
                $titles[$r->shortkey] = $r->title;
            }

            $rresult = $this->doctorsopdfeedback_model->setup_sub_result($setup);
            foreach ($rresult as $r) {
                // $setarray[$r->type] = $r->title;
                $setarray[$r->shortkey] = $r->shortkey;
                $titles[$r->shortkey] = $r->title;
                $shortname[$r->shortkey] = $r->shortname;
            }


            $header[0] = 'Patient Name';
            $header[1] = 'Patient ID';
            $header[2] = 'Speciality';
            $header[3] = 'Mobile Number';
            $header[4] = 'Email id';
            $header[5] = 'Average rating';
            $header[6] = 'NPS score';
            $header[7] = 'Departments';
            $header[8] = 'Concern';

            $dataexport = array();
            $i = 0;
            foreach ($feedback as $row) {


                $dataexport[$i]['name'] = $row->name;
                $dataexport[$i]['patient_id'] = $row->patientid;
                $dataexport[$i]['ward'] = $row->ward;
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
            $fileName = 'DOCTOR UNSATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('DOCTOR-OPD') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/doctoropd_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);
            // redirect('report/ip_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function download_capa_report()
    {
        if (ismodule_active('DOCTOR-OPD') === true) {


            $users = $this->db->select('user.*')
                ->get('user')
                ->result();

            $department_users = array();
            foreach ($users as $user) {
                $parameter = json_decode($user->department);


                foreach ($parameter as $key => $rows) {
                    foreach ($rows as $k => $row) {

                        $slugs = explode(',', $row);

                        foreach ($slugs as $r) {
                            $department_users[$key][$k][$r][] = $user->firstname;
                        }
                    }
                }
            }
            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];

            $this->db->select("*");

            $this->db->from('setup_doctor_opd');

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

            $departments = $this->ticketsopddoctor_model->read_close();



            $dataexport[$i]['row1'] = 'SL No.';

            $dataexport[$i]['row2'] = 'TICKET ID';

            $dataexport[$i]['row3'] = 'CREATED ON';

            $dataexport[$i]['row4'] = 'DOCTOR DETAILS';

            $dataexport[$i]['row5'] = 'CONCERN';

            $dataexport[$i]['row6'] = 'DEPARTMENT';

            $dataexport[$i]['row7'] = 'COMMENT';

            $dataexport[$i]['row8'] = 'ASSIGNEE';

            $dataexport[$i]['row9'] = 'ADDRESSAL COMMENT';

            $dataexport[$i]['row10'] = 'RCA';

            $dataexport[$i]['row11'] = 'CAPA';

            $dataexport[$i]['row12'] = 'RESOLVED ON';

            $dataexport[$i]['row13'] = 'TURN AROUND TIME';

            // $dataexport[$i]['row12'] = 'TAT STATUS';

            $i++;


            if (!empty($departments)) {

                $sl = 1;

                foreach ($departments as $department) {
                    // changes here sooraj
                    if ($department->status == 'Closed') {
                        $rep = '';

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

                            if ($r->ticket_status == 'Addressed' && $r->reply != NULL) {
                                $rep = $r->reply;
                            }
                        }

                        $createdOn = strtotime($department->created_on);

                        $lastModified = strtotime($department->last_modified);

                        $timeDifferenceInSeconds = $lastModified - $createdOn;

                        $value = $this->doctorsopdfeedback_model->convertSecondsToTime($timeDifferenceInSeconds);

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

                        $dataexport[$i]['row2'] = 'DFT- ' . $department->id;

                        $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                        $dataexport[$i]['row4'] = $department->feed->name . '(' . $department->feed->ward . ')';
                        if ($issue) {

                            $dataexport[$i]['row5'] = $issue;
                        } else {
                            $dataexport[$i]['row5'] = 'Ticket was transferred';
                        }

                        $dataexport[$i]['row6'] = $department->department->description;
                        if ($department->feed->suggestionText) {
                            $dataexport[$i]['row7'] = $department->feed->suggestionText;
                        } else {
                            $dataexport[$i]['row7'] =  'NA';
                        }
                        if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) {
                            $dataexport[$i]['row8'] = implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]);
                        } else {
                            $dataexport[$i]['row8'] = 'NA';
                        }
                        // changes here sooraj

                        $dataexport[$i]['row9'] = $rep;

                        $dataexport[$i]['row10'] = implode(", ", $root);

                        $dataexport[$i]['row11'] = implode(", ", $corrective);

                        $dataexport[$i]['row12'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                        $dataexport[$i]['row13'] = $timetaken;


                        $i++;

                        $sl++;
                    }
                }
            }


            ob_end_clean();

            $fileName = 'EF- OPD DOCTOR CAPA REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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

    public function download_alltickets()
    {
        if (ismodule_active('DOCTOR-OPD') === true) {


            $LOAD = pagetoload($this->module);
            if ($LOAD == 'outpatient_modules') {

                $users = $this->db->select('user.*')
                    ->get('user')
                    ->result();

                $department_users = array();
                foreach ($users as $user) {
                    $parameter = json_decode($user->department);


                    foreach ($parameter as $key => $rows) {
                        foreach ($rows as $k => $row) {

                            $slugs = explode(',', $row);

                            foreach ($slugs as $r) {
                                $department_users[$key][$k][$r][] = $user->firstname;
                            }
                        }
                    }
                }


                $fdate = $_SESSION['from_date'];
                $tdate = $_SESSION['to_date'];
                $this->db->select("*");
                $this->db->from('setup_doctor_opd');
                $query = $this->db->get();
                $reasons = $query->result();
                foreach ($reasons as $row) {
                    $keys[$row->shortkey] = $row->shortkey;
                    $res[$row->shortkey] = $row->shortname;
                    $titles[$row->shortkey] = $row->title;
                }
                $dataexport = array();
                $i = 0;
                $departments = $this->ticketsopddoctor_model->alltickets();
                $dataexport[$i]['row1'] = 'SL No.';
                $dataexport[$i]['row2'] = 'TICKET ID';
                $dataexport[$i]['row3'] = 'CREATED ON';
                $dataexport[$i]['row4'] = 'DOCTOR NAME';
                $dataexport[$i]['row5'] = 'EMPLOYEE ID';
                $dataexport[$i]['row6'] = 'SPEACIALITY';
                // $dataexport[$i]['row8'] = 'WARD';
                $dataexport[$i]['row7'] = 'CONCERN';
                $dataexport[$i]['row8'] = 'DEPARTMENT';
                $dataexport[$i]['row9'] = 'COMMENT';
                $dataexport[$i]['row10'] = 'ASSIGNEE';
                $dataexport[$i]['row11'] = 'STATUS';
                $dataexport[$i]['row12'] = 'TRANSFERRED TO';
                $dataexport[$i]['row13'] = 'LAST MODIFIED';
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
                                $dataexport[$i]['row2'] = 'DFT- ' . $department->id;
                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                                $dataexport[$i]['row4'] = $department->feed->name;
                                $dataexport[$i]['row5'] = $department->feed->patientid;
                                $dataexport[$i]['row6'] = $department->feed->ward;
                                // $dataexport[$i]['row8'] = $department->feed->bedno;
                                if ($issue) {

                                    $dataexport[$i]['row7'] = $issue;
                                } else {
                                    $dataexport[$i]['row7'] = 'Ticket was transferred';
                                }
                                // $dataexport[$i]['row8'] = $issue;
                                $dataexport[$i]['row8'] = $department->department->description;
                                if ($department->feed->suggestionText) {
                                    $dataexport[$i]['row9'] = $department->feed->suggestionText;
                                } else {
                                    $dataexport[$i]['row9'] =  'NA';
                                }
                                if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) {
                                    $dataexport[$i]['row10'] = implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]);
                                } else {
                                    $dataexport[$i]['row10'] = 'NA';
                                }
                                $dataexport[$i]['row11'] =  $department->status;
                                if ($transfer_dep_desc) {

                                    $dataexport[$i]['row12'] =  $transfer_dep_desc;
                                } else {
                                    $dataexport[$i]['row12'] =  'NA';
                                }
                                $dataexport[$i]['row13'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                            }
                        }
                        $i++;
                        $sl++;
                    }
                }



                ob_end_clean();

                $fileName = 'EF- OPD DOCTOR ALL TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        } else {

            redirect('dashboard/noaccess');
        }
    }


    public function download_opentickets()
    {
        if (ismodule_active('DOCTOR-OPD') === true) {


            $LOAD = pagetoload($this->module);
            if ($LOAD == 'outpatient_modules') {
                $users = $this->db->select('user.*')
                    ->get('user')
                    ->result();

                $department_users = array();
                foreach ($users as $user) {
                    $parameter = json_decode($user->department);


                    foreach ($parameter as $key => $rows) {
                        foreach ($rows as $k => $row) {

                            $slugs = explode(',', $row);

                            foreach ($slugs as $r) {
                                $department_users[$key][$k][$r][] = $user->firstname;
                            }
                        }
                    }
                }


                $departments = $this->ticketsopddoctor_model->alltickets();
                if (!empty($departments)) {

                    $fdate = $_SESSION['from_date'];
                    $tdate = $_SESSION['to_date'];
                    $this->db->select("*");
                    $this->db->from('setup_doctor_opd');
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
                    $dataexport[$i]['row4'] = 'DOCTOR NAME';
                    $dataexport[$i]['row5'] = 'EMPLOYEE ID';
                    $dataexport[$i]['row6'] = 'SPEACIALITY';
                    // $dataexport[$i]['row8'] = 'WARD';
                    $dataexport[$i]['row7'] = 'CONCERN';
                    $dataexport[$i]['row8'] = 'DEPARTMENT';
                    $dataexport[$i]['row9'] = 'COMMENT';
                    $dataexport[$i]['row10'] = 'ASSIGNEE';
                    $dataexport[$i]['row11'] = 'STATUS';
                    $dataexport[$i]['row12'] = 'TRANSFERRED TO';
                    $dataexport[$i]['row13'] = 'LAST MODIFIED';
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
                                    $dataexport[$i]['row2'] = 'DFT- ' . $department->id;
                                    $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                                    $dataexport[$i]['row4'] = $department->feed->name;
                                    $dataexport[$i]['row5'] = $department->feed->patientid;
                                
                                    $dataexport[$i]['row6'] = $department->feed->ward;
                                    // $dataexport[$i]['row8'] = $department->feed->bedno;
                                    if ($issue) {

                                        $dataexport[$i]['row7'] = $issue;
                                    } else {
                                        $dataexport[$i]['row7'] = 'Ticket was transferred';
                                    }
                                    // $dataexport[$i]['row8'] = $issue;
                                    $dataexport[$i]['row8'] = $department->department->description;
                                    if ($department->feed->suggestionText) {
                                        $dataexport[$i]['row9'] = $department->feed->suggestionText;
                                    } else {
                                        $dataexport[$i]['row9'] =  'NA';
                                    }
                                    if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) {
                                        $dataexport[$i]['row10'] = implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]);
                                    } else {
                                        $dataexport[$i]['row10'] = 'NA';
                                    }
                                    $dataexport[$i]['row11'] =  $department->status;
                                    if ($transfer_dep_desc) {

                                        $dataexport[$i]['row12'] =  $transfer_dep_desc;
                                    } else {
                                        $dataexport[$i]['row12'] =  'NA';
                                    }
                                    $dataexport[$i]['row13'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                                }
                            }
                            $i++;
                            $sl++;
                        }
                    }
                }



                ob_end_clean();

                $fileName = 'EF- OPD DOCTOR OPEN TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function ticket_resolution_rate()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'DOCTOR- TICKET RESOLUTION RATE';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function average_resolution_time()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('DOCTOR-OPD') === true) {


            $data['title'] = 'DOCTOR- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('doctoropdmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
