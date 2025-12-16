<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Admissionfeedback extends CI_Controller

{

    private $module;



    public function __construct()

    {

        parent::__construct();

        $this->load->library('session');

        if ($this->session->userdata('isLogIn') === false && $this->uri->segment(2) != 'track')
        redirect('login');

        if ($this->session->userdata('isLogIn') === false)

            redirect('login');



        $this->load->model(

            array(

                'dashboard_model',

                'efeedor_model',

                'ticketsadf_model',

                 'admissionfeedback_model',

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

        $this->module = 'ADF';



        $this->session->set_userdata([

            'active_menu' => array('adf_dashboard', 'adf_ticket', 'adf_reports', 'adf_patients', 'adf_settings', 'adf_analysis'),

        ]);

        // if (ismodule_active('ADF') === false  && $this->uri->segment(2) != 'track')
        
        //     redirect('dashboard/noaccess');

    }



    // RESERVED FOR DEVELOPER OR COMPANY ACCESS

    public function index()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

       

        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADF MODULE CONFIGURATION';

                $data['content'] = $this->load->view('adfmodules/developer', $data, true);

                $this->load->view('layout/main_wrapper', $data);

           

        } else {

            redirect('dashboard/noaccess');

        }

    }



    // SUPER ADMIN AND ADMIN LOGIN

    public function feedback_dashboard()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

            



                $data['title'] = 'ADMISSION- FEEDBACKS DASHBOARD';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/feedback_dashboard', $data, true);

                $this->load->view('layout/main_wrapper', $data);

            

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function ticket_dashboard()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        if (ismodule_active('ADF') === true ) {

           



                $data['title'] = 'ADMISSION- TICKETS DASHBOARD';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/ticket_dashboard', $data, true);

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



        if (ismodule_active('ADF') === true ) {



           



                $data['title'] = 'ADMISSION- NPS ANALYSIS';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/nps_page', $data, true);

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

        if (ismodule_active('ADF') === true ) {

          

                $data['title'] = 'ADMISSION- NPS PROMOTERS LIST';

                $data['content'] = $this->load->view('adfmodules/nps_promoter_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);

           

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function nps_detractors_list()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {



           

                $data['title'] = 'ADMISSION- NPS DETRACTORS LIST';



                $data['content'] = $this->load->view('adfmodules/nps_detractors_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);


        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function nps_passive_list()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {



           

                $data['title'] = 'ADMISSION- NPS PASSIVES LIST';



                $data['content'] = $this->load->view('adfmodules/nps_passive_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);

          

        } else {

            redirect('dashboard/noaccess');

        }

    }





    public function psat_satisfied_list()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

         

                $data['title'] = 'ADMISSION- SATISFIED PATIENTS LIST';

                $data['content'] = $this->load->view('adfmodules/psat_satisfied_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);

          

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function psat_unsatisfied_list()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADMISSION- UNSATISFIED PATIENTS LIST';

                $data['content'] = $this->load->view('adfmodules/psat_unsatisfied_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);

          

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function psat_page()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

          

                $data['title'] = 'ADMISSION- PSAT ANALYSIS';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/psat_page', $data, true);

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

        if (ismodule_active('ADF') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) {

           

                $data['title'] = 'ADMISSION- TICKETS DASHBOARD';

                $data['content'] = $this->load->view('adfmodules/department_tickets', $data, true);

                $this->load->view('layout/main_wrapper', $data);

                //used for department head login

            

        } else {

            redirect('dashboard/noaccess');

        }

    }

    // END DEPARTMENT HEAD LOGIN



    //START TICKETS 

    public function alltickets()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        if (ismodule_active('ADF') === true ) {

          

                $data['title'] = 'ADMISSION- ALL TICKETS';

                $data['departments'] = $this->ticketsadf_model->alltickets();

                if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) {

                    $data['content'] = $this->load->view('adfmodules/alltickets', $data, true);

                }else {

                    $data['content'] = $this->load->view('adfmodules/dephead/alltickets', $data, true);



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



        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADMISSION- ADDRESSED TICKETS';

                $data['departments'] = $this->ticketsadf_model->addressedtickets();

                if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) {

                    $data['content'] = $this->load->view('adfmodules/addressedtickets', $data, true);

                }else {

                    $data['content'] = $this->load->view('adfmodules/dephead/addressedtickets', $data, true);



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

       

            $data['title'] = 'ADMISSION- TICKET DETAILS';

            $data['departments'] = $this->ticketsadf_model->read_by_id($this->uri->segment(3));

            if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('adfmodules/ticket_track', $data, true);

            }else {

                $data['content'] = $this->load->view('adfmodules/dephead/ticket_track', $data, true);



            }

            $this->load->view('layout/main_wrapper', $data);

        

    }





    public function admin_track()

    {





        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {

            $this->session->set_userdata('referred_from', current_url());

        } else {

            $this->session->set_userdata('referred_from', NULL);

        }



        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



       

            $data['title'] = 'ADMISSION- TICKET DETAILS';

            $data['departments'] = $this->ticketsadf_model->read_by_id($this->uri->segment(3));

            $data['content'] = $this->load->view('ticketsadf/ticket_track', $data, true);

            $this->load->view('layout/main_wrapper', $data);

        

    }







    public function editcapa()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        if (ismodule_active('ADF') === true ) {

           

               

                    $data['title'] = 'EDIT CAPA';

                    $data['departments'] = $this->ticketsadf_model->read_by_id($this->uri->segment(3));

                    $data['content'] = $this->load->view('ticketsadf/ticket_track', $data, true);

                    $this->load->view('layout/main_wrapper', $data);

                

            

        }

    }





    // open tickets_adf

    public function opentickets()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        if (ismodule_active('ADF') === true ) {

         

                $data['title'] = 'ADMISSION- OPEN TICKETS';

                $data['departments'] = $this->ticketsadf_model->read();

                if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) {

                    $data['content'] = $this->load->view('adfmodules/opentickets', $data, true);

                }else {

                    $data['content'] = $this->load->view('adfmodules/dephead/opentickets', $data, true);



                }

                $this->load->view('layout/main_wrapper', $data);

                $this->session->set_userdata('referred_from', NULL);

           

        } else {

            redirect('dashboard/noaccess');

        }

    }



    // closed tickets_adf

    public function closedtickets()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADMISSION- CLOSED TICKETS';

                $data['departments'] = $this->ticketsadf_model->read_close();

                if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) {

                    $data['content'] = $this->load->view('adfmodules/closedtickets', $data, true);

                }else {

                    $data['content'] = $this->load->view('adfmodules/dephead/closedtickets', $data, true);



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

        if (ismodule_active('ADF') === true ) {


                $data['title'] = 'ADMISSION- CAPA REPORT';

                $data['departments'] = $this->ticketsadf_model->read_close();

                $data['content'] = $this->load->view('adfmodules/capa_report', $data, true);

                $this->load->view('layout/main_wrapper', $data);

                // redirect('report/ip_capa_report');

            

        } else {

            redirect('dashboard/noaccess');

        }

    }





    public function feedbacks_report()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADMISSION- ALL FEEDBACKS REPORT';

                $data['content']  = $this->load->view('adfmodules/feedbacks_report', $data, true);

                $this->load->view('layout/main_wrapper', $data);

                // redirect('report/feedbacks_report');

            
        } else {

            redirect('dashboard/noaccess');

        }

    }







    public function comments()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

          

                $data['title'] = 'ADMISSION- PATIENT COMMENTS LIST';

                $data['content'] = $this->load->view('adfmodules/recent_comments', $data, true);

                $this->load->view('layout/main_wrapper', $data);

                // redirect('report/ip_recent_comments');

           

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function staff_appreciation()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

        

                $data['title'] = 'ADMISSION- STAFF RECOGNITION REPORT';

                $data['content'] = $this->load->view('adfmodules/staff_appreciation', $data, true);

                $this->load->view('layout/main_wrapper', $data);

                // redirect('report/ip_staffreport');

           

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function patient_feedback()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

           

                    $data['title'] = 'ADMISSION- PATIENT' . "'" . 'S FEEDBACK';

                    #------------------------------#

                    $data['content']  = $this->load->view('adfmodules/patient_feedback', $data, true);

                    $this->load->view('layout/main_wrapper', $data);

                    // redirect('report/ip_patient_feedback');

               

        } else {

            redirect('dashboard/noaccess');

        }

    }



    public function notifications()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

           

                $data['title'] = 'ADMISSION- FEEDBACK NOTIFICATIONS';

                $data['content'] = $this->load->view('adfmodules/notifications_list', $data, true);

                $this->load->view('layout/main_wrapper', $data);

           

        } else {

            redirect('dashboard/noaccess');

        }

    }

    //END REPORTS





    public function downloadcomments()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

         


                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $desc = 'desc';

                $setup = 'setup_adf';



                $feedbacktaken = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);

                $sresult = $this->admissionfeedback_model->setup_result($setup);

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



                $fileName = 'EF- ADF PATIENT COMMENTS - ' . $tdate . ' to ' . $fdate . '.csv';

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



    // ADF DASHBOARD DOWNLOADS



    public function overall_excel_report()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

         

                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $sorttime = 'asc';

                $setup = 'setup_adf';

                $asc = 'asc';

                $desc = 'desc';

                $table_tickets = 'tickets_adf';

                $open = 'Open';

                $closed = 'Closed';

                $addressed = 'Addressed';

                $type = 'adf';

                $ticket_resolution_rate = $this->admissionfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

                $ip_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

                $ip_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);



                $ip_tickets_count = $this->ticketsadf_model->alltickets();

                $ip_open_tickets = $this->ticketsadf_model->read();

                $ip_closed_tickets = $this->ticketsadf_model->read_close();

                $ip_addressed_tickets = $this->ticketsadf_model->addressedtickets();



                

                $ip_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $asc, $setup);

                $ip_psat = $this->admissionfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);



                $dataexport = array();

                $i = 0;



                $fdate = $_SESSION['from_date'];

                $tdate = $_SESSION['to_date'];



                $dataexport[$i]['row1'] = 'ADF FEEDBACK OVERALL REPORT';

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



                $dataexport[$i]['row1'] = 'ADDRESSED TICKETS';

                $dataexport[$i]['row2'] = count($ip_addressed_tickets);

                $dataexport[$i]['row3'] = '';

                $dataexport[$i]['row4'] = '';

                $i++;



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

                $dataexport[$i]['row5'] = 'ADDRESSED';

                $dataexport[$i]['row6'] = 'CLOSED';

                $dataexport[$i]['row7'] = 'RESOLUTION RATE';

                $dataexport[$i]['row8'] = 'RESOLUTION TIME';

                $dataexport[$i]['row9'] = '';

                $i++;



                $ticket = $this->admissionfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);

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





                $choice_of_hospitals = $this->admissionfeedback_model->reason_to_choose_hospital($table_feedback, $sorttime);



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

                $fileName = 'EF - OVERALL ADF FEEDBACKS REPORT  - ' . $tdate . ' to ' . $fdate . '.csv';

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

        if (ismodule_active('ADF') === true ) {

          


                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $desc = 'desc';

                $setup = 'setup_adf';



                $feedbacktaken = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);

                $sresult = $this->admissionfeedback_model->setup_result($setup);

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

                $fileName = 'EF- ADF PATIENT WISE FEEDBACK REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

          



                $table_feedback = 'bf_feedback_adf';

                $desc = 'desc';

                $setup = 'setup_adf';



                $ip_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $desc, $setup);

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

                $fileName = 'ADF PROMOTERS LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

         


                $table_feedback = 'bf_feedback_adf';

                $desc = 'desc';

                $setup = 'setup_adf';



                $ip_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $desc, $setup);

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

                $fileName = 'ADF PASSIVES LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

          



                $table_feedback = 'bf_feedback_adf';

                $desc = 'desc';

                $setup = 'setup_adf';



                $ip_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $desc, $setup);

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

                $fileName = 'ADF DETRACTORS LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

           

                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $desc = 'desc';

                $setup = 'setup_adf';



                $all_feedback = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);

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

                $fileName = 'ADF STAFF LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

          



                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $table_tickets = 'tickets_adf';

                $desc = 'desc';

                $setup = 'setup_adf';



                $ip_psat = $this->admissionfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);

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

                $fileName = 'ADF SATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

            if (ismodule_active('ADF') === true ) {

         

                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $table_tickets = 'tickets_adf';

                $desc = 'desc';

                $setup = 'setup_adf';



                $ip_psat = $this->admissionfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);

                $feedback = $ip_psat['unsatisfied_feedback'];



                $sresult = $this->admissionfeedback_model->setup_result($setup);



                foreach ($sresult as $r) {

                    $questionarray[$r->shortkey] = $r->shortkey;

                    $titles[$r->shortkey] = $r->title;

                }



                $rresult = $this->admissionfeedback_model->setup_sub_result($setup);

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

                $fileName = 'ADF UNSATISFIED LIST - ' . $tdate . ' to ' . $fdate . '.csv';

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

        if (ismodule_active('ADF') === true ) {

        


                $dataexport = array();

                $i = 0;

                $table_feedback = 'bf_feedback_adf';

                $table_patients = 'bf_patients';

                $sorttime = 'asc';

                $setup = 'setup_adf';

                $asc = 'asc';

                $desc = 'desc';

                $table_tickets = 'tickets_adf';

                $open = 'Open';

                $closed = 'Closed';

                $addressed = 'Addressed';

                $type = 'adf';



                $ip_tickets_count = $this->ticketsadf_model->alltickets();

                $ip_open_tickets = $this->ticketsadf_model->read();

                $ip_closed_tickets = $this->ticketsadf_model->read_close();

                $ip_addressed_tickets = $this->ticketsadf_model->addressedtickets();

                $ip_feedbacks_count = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);



                $ticket_resolution_rate = $this->admissionfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);



                $sresult = $this->admissionfeedback_model->setup_result($setup);

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



                $ticket = $this->admissionfeedback_model->tickets_recived_by_department($type, $table_feedback, $table_tickets);

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

                $fileName = 'EF- ADF DEPARTMENT WISE TICKET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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

        if (ismodule_active('ADF') === true ) {

         

                $fdate = $_SESSION['from_date'];

                $tdate = $_SESSION['to_date'];

                redirect('pdfreport/adf_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);

                // redirect('report/ip_capa_report');

          

        } else {

            redirect('dashboard/noaccess');

        }

    }



















    // fromhere

    public function download_capa_report()

    {

        if (ismodule_active('ADF') === true ) {








                    $fdate = $_SESSION['from_date'];



                    $tdate = $_SESSION['to_date'];



                    $this->db->select("*");



                    $this->db->from('setup_adf');



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



                    $departments = $this->ticketsadf_model->read_close();







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

                            if ($department->status == 'Closed') {

                                foreach ($department->feed->reason as $key => $value) {

                                    if ($titles[$key] == $department->department->description) {

                                        if (in_array($key, $keys)) {

                                            $issue = $res[$key];

                                        }

                                    }

                                }



                                foreach ($department->replymessage as $r) {

                                    if ($r->rootcause != NULL) {

                                        $root = $r->rootcause;

                                    }

                                }



                                foreach ($department->replymessage as $r) {

                                    if ($r->corrective != NULL) {

                                        $corrective = $r->corrective;

                                    }

                                }



                                $createdOn = strtotime($department->created_on);



                                $lastModified = strtotime($department->last_modified);



                                $timeDifferenceInSeconds = $lastModified - $createdOn;



                                $value = $this->admissionfeedback_model->convertSecondsToTime($timeDifferenceInSeconds);



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



                                $dataexport[$i]['row2'] = 'ADFT- ' . $department->id;



                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));



                                $dataexport[$i]['row4'] = $department->feed->name . '(' . $department->feed->patientid . ')';



                                $dataexport[$i]['row5'] = $issue;



                                $dataexport[$i]['row6'] = $department->department->description;

                                if ($assignee) {

                                    $dataexport[$i]['row7'] = $assignee;

                                } else {

                                    $dataexport[$i]['row7'] = 'NA';

                                }

                                $dataexport[$i]['row8'] = $root;



                                $dataexport[$i]['row9'] = $corrective;



                                $dataexport[$i]['row10'] = date('g:i a, d-m-y', strtotime($department->last_modified));



                                $dataexport[$i]['row11'] = $timetaken;





                                $i++;



                                $sl++;

                            }

                        }

                    }







                    ob_end_clean();



                    $fileName = 'EF- ADF CAPA REPORT - ' . $tdate . ' to ' . $fdate . '.csv';



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

        if (ismodule_active('ADF') === true ) {










                $fdate = $_SESSION['from_date'];

                $tdate = $_SESSION['to_date'];

                $this->db->select("*");

                $this->db->from('setup_adf');

                $query = $this->db->get();

                $reasons = $query->result();

                foreach ($reasons as $row) {

                    $keys[$row->shortkey] = $row->shortkey;

                    $res[$row->shortkey] = $row->shortname;

                    $titles[$row->shortkey] = $row->title;

                }

                $dataexport = array();

                $i = 0;

                $departments = $this->ticketsadf_model->alltickets();

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

                                $dataexport[$i]['row2'] = 'ADFT- ' . $department->id;

                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                                $dataexport[$i]['row4'] = $department->feed->name;

                                $dataexport[$i]['row5'] = $department->feed->patientid;

                                $dataexport[$i]['row6'] = $department->feed->contactnumber;

                                $dataexport[$i]['row7'] = $department->feed->ward;

                                $dataexport[$i]['row8'] = $department->feed->bedno;

                                $dataexport[$i]['row9'] = $issue;

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



                $fileName = 'EF- ADF ALL TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';



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

        if (ismodule_active('ADF') === true ) {





          



                $departments = $this->ticketsadf_model->alltickets();

                if (!empty($departments)) {



                    $fdate = $_SESSION['from_date'];

                    $tdate = $_SESSION['to_date'];

                    $this->db->select("*");

                    $this->db->from('setup_adf');

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

                                    $dataexport[$i]['row2'] = 'ADFT- ' . $department->id;

                                    $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                                    $dataexport[$i]['row4'] = $department->feed->name;

                                    $dataexport[$i]['row5'] = $department->feed->patientid;

                                    $dataexport[$i]['row6'] = $department->feed->contactnumber;

                                    $dataexport[$i]['row7'] = $department->feed->ward;

                                    $dataexport[$i]['row8'] = $department->feed->bedno;

                                    $dataexport[$i]['row9'] = $issue;

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

                }







                ob_end_clean();



                $fileName = 'EF- ADF OPEN TICKETS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';



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

        if (ismodule_active('ADF') === true ) {

         


                $data['title'] = 'ADMISSION- TICKET RESOLUTION RATE';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/ticket_analisys_page', $data, true);

                $this->load->view('layout/main_wrapper', $data);

          

        } else {

            redirect('dashboard/noaccess');

        }

    }





    public function average_resolution_time()

    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ADF') === true ) {

          



                $data['title'] = 'ADMISSION- AVERAGE RESOLUTION TIME';

                #------------------------------#

                $data['content'] = $this->load->view('adfmodules/ticket_analisys_page', $data, true);

                $this->load->view('layout/main_wrapper', $data);

          

        } else {

            redirect('dashboard/noaccess');

        }

    }

}

