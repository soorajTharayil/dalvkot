<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grievance extends CI_Controller
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
                'ticketsgrievance_model',
                'grievance_model',
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
        $this->module = 'grievance_modules';

        $this->session->set_userdata([
            'active_menu' => array('grievance_dashboard', 'grievance_ticket', 'grievance_reports', 'grievance_patients', 'grievance_settings'),
        ]);


        // if (ismodule_active('GRIEVANCE') === false  && $this->uri->segment(2) != 'track')
        //     redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'SG-STAFF GRIEVANCE MODULE CONFIGURATION';
            $data['content'] = $this->load->view('grievancemodules/developer', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    // SUPER ADMIN AND ADMIN LOGIN
    public function ticket_dashboard()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'SG- STAFF GRIEVANCES DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('grievancemodules/ticket_dashboard', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    // END SUPER ADMIN AND ADMIN LOGIN


    // DEPARTMENT HEAD LOGIN
    public function department_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('GRIEVANCE') === true  && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) {


            $data['title'] = 'SG- STAFF GRIEVANCES DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('grievancemodules/department_tickets', $data, true);
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

        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG- ALL GRIEVANCES';
            #-------------------------------#
            $data['departments'] = $this->ticketsgrievance_model->alltickets();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/alltickets', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/alltickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function alltickets_individual_user()
    {
        $userName = $this->session->userdata['fullname'];
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG- ALL GRIEVANCES BY '. $userName .'';
            #-------------------------------#
            $data['departments'] = $this->ticketsgrievance_model->alltickets_individual_user();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/alltickets_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/alltickets_individual_user', $data, true);
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

        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG- ADDRESSED GRIEVANCES';
            $data['departments'] = $this->ticketsgrievance_model->addressedtickets();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/addressedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/addressedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            // redirect('tickets/alltickets');

        } else {
            redirect('dashboard/noaccess');
        }
    }

      //addressed ticket
      public function addressedtickets_individual_user()
      {
        $userName = $this->session->userdata['fullname'];
          if ($this->session->userdata('isLogIn') == false)
              redirect('login');
  
          if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
              $data['title'] = 'SG- ADDRESSED GRIEVANCES BY '. $userName .'';
              $data['departments'] = $this->ticketsgrievance_model->addressedtickets_individual_user();
              if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                  $data['content'] = $this->load->view('grievancemodules/addressedtickets_individual_user', $data, true);
              } else {
                  $data['content'] = $this->load->view('grievancemodules/dephead/addressedtickets_individual_user', $data, true);
              }
              $this->load->view('layout/main_wrapper', $data);
              // redirect('tickets/alltickets');
  
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

        $data['title'] = 'SG-STAFF GRIEVANCE DETAILS';
        $data['departments'] = $this->ticketsgrievance_model->read_by_id($this->uri->segment(3));
        if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
            $data['content'] = $this->load->view('grievancemodules/ticket_track', $data, true);
        } else {
            $data['content'] = $this->load->view('grievancemodules/dephead/ticket_track', $data, true);
        }
        $this->load->view('layout/main_wrapper', $data);
    }

    // open tickets
    public function opentickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG-STAFF OPEN GRIEVANCES';
            #-------------------------------#
            $data['departments'] = $this->ticketsgrievance_model->read();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/opentickets', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/opentickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function read_individual_user()
    {
        $userName = $this->session->userdata['fullname'];
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG-STAFF OPEN GRIEVANCES BY '. $userName .'';
            #-------------------------------#
            $data['departments'] = $this->ticketsgrievance_model->read_individual_user();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/read_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/read_individual_user', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    // closed tickets

    public function closedtickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();

            $data['title'] = 'SG-STAFF CLOSED GRIEVANCES';
            $data['departments'] = $this->ticketsgrievance_model->read_close();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/closedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/closedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function read_close_individual_user()
    {
        $userName = $this->session->userdata['fullname'];
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $dates = get_from_to_date();
            $data['title'] = 'SG-STAFF CLOSED GRIEVANCES BY '. $userName .'';
            $data['departments'] = $this->ticketsgrievance_model->read_close_individual_user();
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/read_close_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/read_close_individual_user', $data, true);
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
        if (ismodule_active('GRIEVANCE') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'SG-STAFF GRIEVANCE CAPA REPORT';
            $data['departments'] = $this->ticketsgrievance_model->read_close();
            $data['content'] = $this->load->view('grievancemodules/capa_report', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }



    public function complaints()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {


            $data['title'] = 'SG- STAFF GRIEVANCE' . "'" . 'S COMMENTS';
            $data['content'] = $this->load->view('grievancemodules/recent_comments', $data, true);
            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/int_recent_comments');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function employee_complaint()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'SG-STAFF GRIEVANCES';
            #------------------------------#
            if (isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) {
                $data['content'] = $this->load->view('grievancemodules/employee_complaint', $data, true);
            } else {
                $data['content'] = $this->load->view('grievancemodules/dephead/employee_complaint', $data, true);
            }

            $this->load->view('layout/main_wrapper', $data);
            // redirect('report/int_patient_feedback');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function notifications()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'SG-STAFF GRIEVANCE NOTIFICATIONS';
            $data['content'] = $this->load->view('grievancemodules/recent_comments', $data, true);
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
        if (ismodule_active('GRIEVANCE') === true) {


            $table_feedback = 'bf_feedback_grievance';
            $table_patients = 'bf_employees_grievance';
            $desc = 'desc';
            $setup = 'setup_grievance';

            $feedbacktaken = $this->grievance_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->grievance_model->setup_result($setup);
            $setarray = array();
            $question = array();
            foreach ($sresult as $r) {
                $setarray[$r->type] = $r->title;
                $setarray[$r->shortkey] = $r->shortname;
            }
            foreach ($sresult as $r) {
                $question[$r->shortkey] = $r->shortname;
                $question[$r->type] = $r->title;
            }



            $header[0] = 'Date';
            $header[1] = 'Employee Name';
            $header[2] = 'Employee ID';
            $header[3] = 'Floor/Ward';
            $header[4] = 'Location';
            $header[5] = 'Mobile Number';
            $header[6] = 'Category';
            $header[7] = 'Grievance';
            $header[8] = 'Description';
            // $j = 9;
            // foreach ($setarray as $r) {
            //     $header[$j] = $r;

            //     $j++;
            // }
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
                foreach ($data['comment'] as $key => $value) {
                    $dataexport[$i]['Department'] =  $setarray[$key];
                }
                foreach ($data['reason'] as $key => $value) {
                    if ($value) {
                        $dataexport[$i]['ticket'] =  $question[$key];
                    }
                }
                foreach ($data['comment'] as $key => $value) {
                    if ($value) {
                        $dataexport[$i]['comment'] = $value;
                    }
                }
                $i++;
            }
            $newdataset = $dataexport;
            // echo '<pre>';
            // print_r($dataexport);
            // exit;
            ob_end_clean();
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $fileName = 'EF- GRIEVANCE REPORT- ' . $tdate . ' to ' . $fdate . '.csv';
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

    public function dep_tat()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'TAT SET';
            $data['content'] = $this->load->view('grievancemodules/dep_tat', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }





    public function dep_tat_edit()
    {
        if (ismodule_active('GRIEVANCE') === true) {

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


            $data['title'] = 'SG-Manage Turn Around Time';

            #------------------------------#

            $data['content'] = $this->load->view('grievancemodules/dep_tat_edit', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function overall_department_excel()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {


            $dataexport = array();
            $i = 0;
            $table_feedback = 'bf_feedback_grievance';
            $table_patients = 'bf_employees_grievance';
            $sorttime = 'asc';
            $setup = 'setup_grievance';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets_grievance';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'grievance';

            $int_feedbacks_count = $this->grievance_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $int_tickets_count = $this->ticketsgrievance_model->alltickets();
            $int_open_tickets = $this->ticketsgrievance_model->read();
            $int_closed_tickets = $this->ticketsgrievance_model->read_close();
            $int_addressed_tickets = $this->ticketsgrievance_model->addressedtickets();

            $ticket_resolution_rate = $this->grievance_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

            $header = 'DEPARTMENT WISE GRIEVANCES REPORT';
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $dataexport[$i]['row1'] = 'GRIEVANCES REPORT';
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


            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'TOTAL GRIEVANCES';
            $dataexport[$i]['row2'] = count($int_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'GRIEVANCES RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'OPEN GRIEVANCES';
            $dataexport[$i]['row2'] = count($int_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'ADDRESSED GRIEVANCES';
            $dataexport[$i]['row2'] = count($int_addressed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'CLOSED GRIEVANCES';
            $dataexport[$i]['row2'] = count($int_closed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'GRIEVANCES RECEIVED BY CATEGORY';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = 'OPEN';
            $dataexport[$i]['row5'] = 'ADDRESSED';
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = '';
            $i++;

            $ticket = $this->grievance_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);

            foreach ($ticket as $ps) {
                $dataexport[$i]['row1'] = $ps['department'];
                $dataexport[$i]['row2'] = $ps['percentage'] . '%';
                $dataexport[$i]['row3'] = $ps['total_count'];
                $dataexport[$i]['row4'] = $ps['open_tickets'];
                $dataexport[$i]['row5'] = $ps['addressed_tickets'];
                $dataexport[$i]['row6'] = $ps['closed_tickets'];
                $dataexport[$i]['row7'] = $ps['tr_rate'] . '%';
                $dataexport[$i]['row8'] = '';
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
            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            ob_end_clean();
            $fileName = 'EF- CATEGORY WISE GRIEVANCES REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('GRIEVANCE') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/grievance_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);
            // redirect('report/ip_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }





    public function download_capa_report()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('GRIEVANCE') === true) {
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

            $this->db->from('setup_grievance');

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

            $departments = $this->ticketsgrievance_model->read_close();



            $dataexport[$i]['row1'] = 'SL No.';

            $dataexport[$i]['row2'] = 'GRIEVANCE ID';

            $dataexport[$i]['row3'] = 'REPORTED ON';

            $dataexport[$i]['row4'] = 'EMPLOYEE DETAILS';

            $dataexport[$i]['row5'] = 'GRIEVANCE';

            $dataexport[$i]['row6'] = 'CATEGORY';

            $dataexport[$i]['row7'] = 'COMMENT';

            $dataexport[$i]['row8'] = 'ASSIGNEE';

            $dataexport[$i]['row9'] = 'ADDRESSAL COMMENT';

            $dataexport[$i]['row10'] = 'RCA';

            $dataexport[$i]['row11'] = 'CAPA';

            $dataexport[$i]['row12'] = 'RESOLVED ON';

            $dataexport[$i]['row13'] = 'TIME TAKEN';



            $i++;



            if (!empty($departments)) {

                $sl = 1;

                foreach ($departments as $department) {

                    if ($department->status == 'Closed') {

                        $rep = '';
                        $root = '';
                        $corrective = '';
                        $issue = '';

                        $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');

                        $query = $this->db->get('ticket_grievance_message');

                        $ticket = $query->result();

                        $rowmessage = $ticket[0]->message . ' Closed this ticket';

                        $createdOn1 = strtotime($department->created_on);

                        $lastModified1 = strtotime($department->last_modified);

                        $closeddiff = $lastModified1 - $createdOn1;

                        if ($department->department->close_time <= $closeddiff) {

                            $close = 'Exceeded TAT';
                        } else {

                            $close = 'Within TAT';
                        }

                        if (strlen($rowmessage) > 60) {

                            $rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
                        }

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

                        foreach ($department->replymessage as $r) {

                            if ($r->ticket_status == 'Addressed' && $r->reply != NULL) {
                                $rep = $r->reply;
                            }
                        }



                        $value2 = $this->grievance_model->convertSecondsToTime($department->department->close_time);

                        $dep_tat = '';

                        if ($value2['days'] != 0) {

                            $dep_tat .= $value2['days'] . ' days, ';
                        }

                        if ($value2['hours'] != 0) {

                            $dep_tat .= $value2['hours'] . ' hrs, ';
                        }

                        if ($value2['minutes'] != 0) {

                            $dep_tat .= $value2['minutes'] . ' mins.';
                        }



                        $createdOn = strtotime($department->created_on);

                        $lastModified = strtotime($department->last_modified);

                        $timeDifferenceInSeconds = $lastModified - $createdOn;

                        $value = $this->grievance_model->convertSecondsToTime($timeDifferenceInSeconds);

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



                        $dataexport[$i]['row1'] = $sl;

                        $dataexport[$i]['row2'] = 'SG- ' . $department->id;

                        $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                        $dataexport[$i]['row4'] = $department->feed->name . '(' . $department->feed->patientid . ')';

                        $dataexport[$i]['row5'] = $issue;

                        $dataexport[$i]['row6'] = $department->department->description;

                        if ($department->feed->other) {
                            $dataexport[$i]['row7'] = $department->feed->other;
                        } else {
                            $dataexport[$i]['row7'] =  'NA';
                        }

                        if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) { 
                            $dataexport[$i]['row8'] = implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]);
                        } else {
                            $dataexport[$i]['row8'] = 'NA';
                        }

                        $dataexport[$i]['row9'] = $rep;

                        $dataexport[$i]['row10'] = $root;

                        $dataexport[$i]['row11'] = $corrective;

                        $dataexport[$i]['row12'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                        $dataexport[$i]['row13'] = $timetaken;


                        $i++;

                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- SG CAPA REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

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
            $this->db->from('setup_grievance');
            $query = $this->db->get();
            $reasons = $query->result();
            foreach ($reasons as $row) {
                $keys[$row->shortkey] = $row->shortkey;
                $res[$row->shortkey] = $row->shortname;
                $titles[$row->shortkey] = $row->title;
            }
            $dataexport = array();
            $i = 0;
            $departments = $this->ticketsgrievance_model->alltickets();
            $dataexport[$i]['row1'] = 'SL No.';
            $dataexport[$i]['row2'] = 'GRIEVANCE ID';
            $dataexport[$i]['row3'] = 'REPORTED ON';
            $dataexport[$i]['row4'] = 'REPORTED BY';
            $dataexport[$i]['row5'] = 'EMPLOYEE ID';
            $dataexport[$i]['row6'] = 'PHONE NUMBER';
            $dataexport[$i]['row7'] = 'FLOOR/WARD';
            $dataexport[$i]['row8'] = 'SITE';
            $dataexport[$i]['row9'] = 'GRIEVANCE';
            $dataexport[$i]['row10'] = 'CATEGORY';
            $dataexport[$i]['row11'] = 'COMMENT';
            $dataexport[$i]['row12'] = 'ASSIGNEE';
            $dataexport[$i]['row13'] = 'STATUS';
            $dataexport[$i]['row14'] = 'TRANSFERRED TO';
            $dataexport[$i]['row15'] = 'LAST MODIFIED';
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
                            $dataexport[$i]['row2'] = 'SG- ' . $department->id;
                            $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                            $dataexport[$i]['row4'] = $department->feed->name;
                            $dataexport[$i]['row5'] = $department->feed->patientid;
                            $dataexport[$i]['row6'] = $department->feed->contactnumber;
                            $dataexport[$i]['row7'] = $department->feed->ward;
                            $dataexport[$i]['row8'] = $department->feed->bedno;
                            $dataexport[$i]['row9'] = $issue;
                            $dataexport[$i]['row10'] = $department->department->description;
                            if ($department->feed->other) {
                                $dataexport[$i]['row11'] = $department->feed->other;
                            } else {
                                $dataexport[$i]['row11'] =  'NA';
                            }

                            if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) { 
                                $dataexport[$i]['row12'] = implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]);
                            } else {
                                $dataexport[$i]['row12'] = 'NA';
                            }
                            $dataexport[$i]['row13'] =  $department->status;
                            if ($transfer_dep_desc) {

                                $dataexport[$i]['row14'] =  $transfer_dep_desc;
                            } else {
                                $dataexport[$i]['row14'] =  'NA';
                            }
                            $dataexport[$i]['row15'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                        }
                    }
                    $i++;
                    $sl++;
                }
            }



            ob_end_clean();

            $fileName = 'EF- SG ALL GRIEVANCES REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $departments = $this->ticketsgrievance_model->alltickets();
            if (!empty($departments)) {

                $fdate = $_SESSION['from_date'];
                $tdate = $_SESSION['to_date'];
                $this->db->select("*");
                $this->db->from('setup_grievance');
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
                $dataexport[$i]['row2'] = 'GRIEVANCE ID';
                $dataexport[$i]['row3'] = 'REPORTED ON';
                $dataexport[$i]['row4'] = 'REPORTED BY';
                $dataexport[$i]['row5'] = 'EMPLOYEE ID';
                $dataexport[$i]['row6'] = 'PHONE NUMBER';
                $dataexport[$i]['row7'] = 'FLOOR/WARD';
                $dataexport[$i]['row8'] = 'SITE';
                $dataexport[$i]['row9'] = 'GRIEVANCE';
                $dataexport[$i]['row10'] = 'CATEGORY';
                $dataexport[$i]['row11'] = 'COMMENT';
                $dataexport[$i]['row12'] = 'ASSIGNEE';
                $dataexport[$i]['row13'] = 'STATUS';
                $dataexport[$i]['row14'] = 'TRANSFERRED TO';
                $dataexport[$i]['row15'] = 'LAST MODIFIED';
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
                                $dataexport[$i]['row2'] = 'SG- ' . $department->id;
                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                                $dataexport[$i]['row4'] = $department->feed->name;
                                $dataexport[$i]['row5'] = $department->feed->patientid;
                                $dataexport[$i]['row6'] = $department->feed->contactnumber;
                                $dataexport[$i]['row7'] = $department->feed->ward;
                                $dataexport[$i]['row8'] = $department->feed->bedno;
                                $dataexport[$i]['row9'] = $issue;
                                $dataexport[$i]['row10'] = $department->department->description;
                                if ($department->feed->other) {
                                    $dataexport[$i]['row11'] = $department->feed->other;
                                } else {
                                    $dataexport[$i]['row11'] =  'NA';
                                }
    
                                if ($department->department->pname != '' && $department->department->pname != NULL) {
                                    $dataexport[$i]['row12'] = $department->department->pname;
                                } else {
                                    $dataexport[$i]['row12'] = 'NA';
                                }
                                $dataexport[$i]['row13'] =  $department->status;
                                if ($transfer_dep_desc) {
    
                                    $dataexport[$i]['row14'] =  $transfer_dep_desc;
                                } else {
                                    $dataexport[$i]['row14'] =  'NA';
                                }
                                $dataexport[$i]['row15'] = date('g:i a, d-m-y', strtotime($department->last_modified));
                            }
                        }
                        $i++;
                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- SG OPEN GRIEVANCE REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        if (ismodule_active('GRIEVANCE') === true) {


            $data['title'] = 'SG- GRIEVANCE RESOLUTION RATE';
            #------------------------------#
            $data['content'] = $this->load->view('grievancemodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function average_resolution_time()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('GRIEVANCE') === true) {

            $data['title'] = 'SG- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('grievancemodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
