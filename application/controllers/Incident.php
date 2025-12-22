<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Incident extends CI_Controller
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
                'ticketsincidents_model',
                'incident_model',
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
        $this->module = 'incident_modules';

        $this->session->set_userdata([
            'active_menu' => array('inci_dashboard', 'inci_ticket', 'inci_reports', 'inci_patients', 'inci_settings'),
        ]);

        if (ismodule_active('INCIDENT') === false && $this->uri->segment(2) != 'track')
            redirect('dashboard/noaccess');
    }

    // RESERVED FOR DEVELOPER OR COMPANY ACCESS
    public function index()
    {

        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INCIDENTS MODULE CONFIGURATION';
            $data['content'] = $this->load->view('incidentmodules/developer', $data, true);
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

        if (ismodule_active('INCIDENT') === true) {
            $dates = get_from_to_date();
            $data['title'] = 'INC all incidents raised  by ' . $userName . '';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->alltickets_individual_user();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/alltickets_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/alltickets_individual_user', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function assignedtickets_individual_user()
    {
        $userName = $this->session->userdata['fullname'];
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {

            $dates = get_from_to_date();
            $data['title'] = 'INC assigned incidents raised  by ' . $userName . '';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->assignedtickets_individual_user();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/assignedtickets_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/assignedtickets_individual_user', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    public function read_close_individual_user()
    {
        $userName = $this->session->userdata['fullname'];
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {

            $dates = get_from_to_date();
            $data['title'] = 'INC closed incidents raised  by ' . $userName . '';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->read_close_individual_user();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/read_close_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/read_close_individual_user', $data, true);
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
        if (ismodule_active('INCIDENT') === true) {
            $dates = get_from_to_date();

            $data['title'] = 'INC open incidents raised  by ' . $userName . '';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->read_individual_user();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/read_individual_user', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/read_individual_user', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {
            redirect('dashboard/noaccess');
        }
    }

    // SUPER ADMIN AND ADMIN LOGIN
    public function ticket_dashboard()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');


        if (ismodule_active('INCIDENT') === true) {


            $data['title'] = 'INC- INCIDENTS DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('incidentmodules/ticket_dashboard', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function download_capa_report_pdf()
    {
        if (ismodule_active('INCIDENT') === true) {

            $logo = base_url('uploads/') . $this->session->userdata['logo'];
            $title = array();
            $title = $this->session->userdata['title'];

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
            $this->db->from('setup_incident');
            $query = $this->db->get();
            $reasons = $query->result();

            foreach ($reasons as $row) {
                $keys[$row->shortkey] = $row->shortkey;
                $res[$row->shortkey] = $row->shortname;
                $titles[$row->shortkey] = $row->title;
            }

            $dataexport = array();
            $i = 0;
            $departments = $this->ticketsincidents_model->read_close();

            // echo '<pre>';
            // print_r($departments);
            // echo '</pre>';
            // exit;



            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

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
                    $resolution_note = [];
                    $rootcause_describtion = [];
                    $corrective_description = [];

                    foreach ($department->replymessage as $r) {
                        if ($r->rootcause != NULL) {
                            $root[] = $r->rootcause;
                        }

                        if ($r->corrective != NULL) {
                            $corrective[] = $r->corrective;
                        }
                        if ($r->rootcause_describtion != NULL) {
                            $rootcause_describtion[] = $r->rootcause_describtion;
                        }
                        if ($r->corrective_description != NULL) {
                            $corrective_description[] = $r->corrective_description;
                        }

                        if ($r->resolution_note != NULL) {
                            $resolution_note[] = $r->resolution_note;
                        }

                        if ($r->ticket_status == 'Addressed' && $r->reply != NULL) {
                            $rep = $r->reply;
                        }
                    }

                    $createdOn = strtotime($department->created_on);
                    $lastModified = strtotime($department->last_modified);
                    $timeDifferenceInSeconds = $lastModified - $createdOn;

                    $value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

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




                    $userss = $this->db->select('user_id, firstname')
                        ->where('user_id !=', 1)
                        ->get('user')
                        ->result();

                    $userMap = [];
                    foreach ($userss as $u) {
                        $userMap[$u->user_id] = $u->firstname;
                    }

                    // Step 2: Convert comma-separated IDs into arrays
                    $assign_for_process_monitor_ids = !empty($department->assign_for_process_monitor)
                        ? explode(',', $department->assign_for_process_monitor)
                        : [];

                    $assign_to_ids = !empty($department->assign_to)
                        ? explode(',', $department->assign_to)
                        : [];

                    $assign_for_team_member_ids = !empty($department->assign_for_team_member)
                        ? explode(',', $department->assign_for_team_member)
                        : []; // 🆕

                    // Step 3: Map IDs → names
                    $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_for_process_monitor_ids);

                    $assign_to_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_to_ids);

                    $assign_for_team_member_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_for_team_member_ids); // 🆕

                    // Step 4: Join into comma-separated strings
                    $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
                    $names = implode(', ', $assign_to_names);
                    $actionText_team_member = implode(', ', $assign_for_team_member_names); // 🆕



                    $assignee = $department->department->pname;
                    $incidentHistory = $department->replymessage;
                    $dataexport[] = array(
                        // 'SL No.' => $sl,
                        'TICKET ID' => 'INC- ' . $department->id,

                        'TICKET DETAILS' =>
                            '<strong>Incident Category:</strong> ' . ($department->department->description) . '<br>' .
                            '<strong>Incident:</strong> ' . ($issue ? $issue : 'Ticket was transferred') . '<br>' .
                            '<strong>Incident Description:</strong> ' . ($department->feed->other ? $department->feed->other : 'NA') . '<br>' .
                            '<strong>What went wrong:</strong> ' . ($department->feed->what_went_wrong) . '<br>' .
                            '<strong>Immediate action taken:</strong> ' . ($department->feed->action_taken) . '<br>',


                        'RISK' => '<strong>' .
                            $department->feed->risk_matrix->level . '</strong> (' .
                            $department->feed->risk_matrix->impact . ' Impact × ' .
                            $department->feed->risk_matrix->likelihood . ' Likelihood)',


                        'PRIORITY' => $department->priority,
                        'PROCESS MONITOR' => $actionText_process_monitor,
                        'TEAM LEADER' => $names,
                        'TEAM MEMBER' => $actionText_team_member,
                        'RISK_LEVEL' => $department->feed->risk_matrix->level,
                        'RISK_IMPACT' => $department->feed->risk_matrix->impact,
                        'RISK_LIKELIHOOD' => $department->feed->risk_matrix->likelihood,

                        'INCIDENT TYPE' => $department->incident_type,

                        'PATIENT DETAILS' => ($department->feed->name ?? '') . (!empty($department->feed->patientid) ? ' (' . $department->feed->patientid . ')' : '') . '<br>' . (!empty($department->feed->contactnumber) ? '<i class="fa fa-phone"></i> ' . $department->feed->contactnumber . '<br>' : '') . (!empty($department->feed->email) ? '<i class="fa fa-envelope"></i> ' . $department->feed->email : ''),

                        'TAG PATIENT DETAILS' => ($department->feed->tag_name ?? '') .
                            (!empty($department->feed->tag_patientid) ? ' (' . $department->feed->tag_patientid . ')' : ''),

                        'TAG EMP DETAILS' => ($department->feed->employee_name ?? '') .
                            (!empty($department->feed->employee_id) ? ' (' . $department->feed->employee_id . ')' : ''),

                        'TAG EQP DETAILS' => ($department->feed->asset_name ?? '') .
                            (!empty($department->feed->asset_code) ? ' (' . $department->feed->asset_code . ')' : ''),



                        'FLOOR DETAILS' => '<strong>Floor/ Ward: </strong>' . ($department->feed->ward) . '<br>' .
                            '<strong>Site:</strong> ' . ($department->feed->bedno ? $department->feed->bedno : 'NA'),

                        'ASSIGNEE' => !empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])
                            ? implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug])
                            : 'NA',
                        'CREATED ON' => date('g:i a, d-m-y', strtotime($department->created_on)),
                        'OCCURED ON' => $department->incident_occured_in,
                        'CLOSED BY' => $department->incident_occured_in,
                        'RESOLVED ON' => date('g:i a, d-m-y', strtotime($department->last_modified)),
                        // 'ADDRESSAL COMMENT' => $rep,
                        'RCA/CAPA' => 'RCA: ' . (!empty($root) ? implode(", ", $root) : '') . '<br><br>' .
                            'CAPA: ' . (!empty($corrective) ? implode(", ", $corrective) : '') . '<br><br>' .
                            'Resolution Comment: ' . (!empty($resolution_note) ? implode(", ", $resolution_note) : 'NA'),
                        'DESCRIPTION' => 'RCA FOR DESCRIPTION: ' . (!empty($rootcause_describtion) ? implode(", ", $rootcause_describtion) : '') . '<br><br>' .
                            'CAPA FOR DESCRIPTION: ' . (!empty($corrective_description) ? implode(", ", $corrective_description) : '') . '<br><br>' .
                            'DESCRIPTION: ' . (!empty($corrective_description) ? implode(", ", $resolution_note) : 'NA'),

                        'TURN AROUND TIME' => $timetaken,
                        'DATA' => $department->replymessage
                    );

                    $sl++;
                }
            }

            $this->load->library('Pdf');
            // Load PDF Library and initialize
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Efeedor');
            $pdf->SetTitle('INCIDENTS REPORT - ' . $tdate . ' to ' . $fdate);
            $pdf->SetSubject('INCIDENTS REPORT - ' . $tdate . ' to ' . $fdate);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);

            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '';
            $html .= '<span style="text-align:center;"><img src="' . $logo . '" style="height:30px; width:100px;margin-bottom:-3px;"></span>';
            $html .= '<h2 style="text-align:center;">' . $title . '</h2>';
            $html .= '<h2 style="text-align:center;">INCIDENT MANAGEMENT REPORT </h2>';
            $html .= '<p><span style="text-align:left;">SHOWING DATA FROM ' . $tdate . ' TO ' . $fdate . '</span></p>';

            // Loop through the dataexport array
            foreach ($dataexport as $data) {
                // Add space between tables
                if ($data !== reset($dataexport)) {
                    $html .= '<p style="margin: 30px 0;"></p>'; // Adding space between tables
                }
                // Open table for each ticket
                $html .= '<table border="1" cellpadding="5" 
    style="margin-top:40px; width: 100%; border:1px solid #ccc; 
    border-collapse: collapse; font-family: Arial, sans-serif; font-size:12px; line-height:1.5;">';

                // Ticket ID as a header for each ticket
                $html .= '<tr style="background:#f5f5f5;">
    <td colspan="1" style="font-weight:bold; font-size:14px; color:#d9534f; padding:8px;">
        ' . $data['TICKET ID'] . '
    </td>
</tr>';


                $html .= '<tr>
    <td style="width: 30%; font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Incident Details</td>
    <td style="border:1px solid #ccc; padding:8px;">' . $data['TICKET DETAILS'] . '</td>
</tr>';

                // Emp Details
                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Incident Reported By</td>
    <td style="border: 1px solid #dadada;">' . $data['PATIENT DETAILS'] . '</td>
</tr>';

                // Emp Details
                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Incident Occured On</td>
    <td style="border: 1px solid #dadada;">' . $data['OCCURED ON'] . '</td>
</tr>';

                // Created On
                $html .= '<tr>
    <td style="font-weight: bold; border: 1px solid #dadada;">Incident Reported On</td>
    <td style="border: 1px solid #dadada;">' . $data['CREATED ON'] . '</td>
</tr>';

                // Floor and Site Details
                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Incident Reported In</td>
    <td style="border: 1px solid #dadada;">' . $data['FLOOR DETAILS'] . '</td>
</tr>';
                // Define colors for Risk
                $riskColors = [
                    'High' => '#d9534f',  // Red
                    'Medium' => '#f0ad4e',  // Orange
                    'Low' => '#16993bff',  // Blue
                    'Unassigned' => '#6c757d'   // Gray
                ];

                // Get risk values
                $level = $data['RISK_LEVEL'] ?? 'Unassigned';
                $impact = $data['RISK_IMPACT'] ?? 'Unassigned';
                $likelihood = $data['RISK_LIKELIHOOD'] ?? 'Unassigned';

                // Pick color for level only
                $riskColor = $riskColors[$level] ?? $riskColors['Unassigned'];

                // Assigned Risk row inside PDF HTML
                $html .= '<tr>
    <td style="width:30%; font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Assigned Risk</td>
    <td style="border:1px solid #ccc; padding:8px;">
        <font color="' . $riskColor . '"><b>' . htmlspecialchars($level) . '</b></font>
        (' . htmlspecialchars($impact) . ' Impact × ' . htmlspecialchars($likelihood) . ' Likelihood)
    </td>
</tr>';



                // Priority

                // Normalize and map color for Risk Priority
                $priority = str_replace('–', '-', $department->priority);
                switch ($priority) {
                    case 'P1-Critical':
                        $color = '#ff4d4d'; // Red
                        break;
                    case 'P2-High':
                        $color = '#ff9800'; // Orange
                        break;
                    case 'P3-Medium':
                        $color = '#fbc02d'; // Yellow
                        break;
                    case 'P4-Low':
                        $color = '#178b60ff'; // Blue
                        break;
                    default:
                        $color = '#000';    // Black
                }

                // Define colors for priority
                $priorityColors = [
                    'P1-Critical' => '#ff4d4d',  // Red
                    'P2-High' => '#ff9800',  // Orange
                    'P3-Medium' => '#fbc02d',  // Yellow
                    'P4-Low' => '#178b60ff',  // Blue
                    'Unassigned' => '#6c757d'   // Gray
                ];

                // Define colors for severity
                $severityColors = [
                    'Near miss' => '#178b60ff',   // Blue
                    'No-harm' => '#fbc02d',   // Yellow
                    'Adverse' => '#ff9800',   // Orange
                    'Sentinel' => '#ff4d4d',   // Red
                    'Unassigned' => '#6c757d'    // Gray
                ];

                // Get current values
                $priority = $data['PRIORITY'] ?? 'Unassigned';
                $severity = $data['INCIDENT TYPE'] ?? 'Unassigned';

                // Pick colors
                $priorityColor = $priorityColors[$priority] ?? $priorityColors['Unassigned'];
                $severityColor = $severityColors[$severity] ?? $severityColors['Unassigned'];

                // Risk Priority row inside PDF HTML
                $html .= '<tr>
    <td style="width:30%; font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Assigned Priority</td>
    <td style="border:1px solid #ccc; padding:8px;">
        <span style="color:' . $priorityColor . '; font-weight:600;">' . htmlspecialchars($priority) . '</span>
    </td>
</tr>';

                // Normalize severity (lowercase, trim, unify spaces and dashes)
                $severity = $data['INCIDENT TYPE'] ?? 'Unassigned';
                $severity = strtolower(trim($severity));
                $severity = preg_replace('/\s+/', ' ', $severity);   // collapse multiple spaces
                $severity = str_replace(['–', '—'], '-', $severity);  // normalize dashes

                // Map normalized severity keys
                $severityColors = [
                    'near miss' => '#178b60ff',   // Blue
                    'no-harm' => '#fbc02d',     // Yellow
                    'adverse' => '#ff9800',     // Orange
                    'sentinel' => '#ff4d4d',     // Red
                    'unassigned' => '#6c757d'      // Gray
                ];

                // Pick color
                $severityColor = $severityColors[$severity] ?? $severityColors['unassigned'];

                // Render row
                $html .= '<tr>
    <td style="width:30%; font-weight:bold; border:1px solid #dadada;">Assigned Severity</td>
    <td style="border:1px solid #dadada; padding:8px;">
        <span style="color:' . $severityColor . '; font-weight:600;">' . htmlspecialchars($data['INCIDENT TYPE'] ?? 'Unassigned') . '</span>
    </td>
</tr>';



                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Patient Details</td>
    <td style="border: 1px solid #dadada;">' . $data['TAG PATIENT DETAILS'] . '</td>
</tr>';
                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Employe Details</td>
    <td style="border: 1px solid #dadada;">' . $data['TAG EMP DETAILS'] . '</td>
</tr>';
                $html .= '<tr>
    <td style="width: 30%; font-weight: bold; border: 1px solid #dadada;">Equipment Details</td>
    <td style="border: 1px solid #dadada;">' . $data['TAG EQP DETAILS'] . '</td>
</tr>';



                $html .= '<tr>
    <td style="width: 30%; font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Assigned Team Leader</td>
    <td style="border:1px solid #ccc; padding:8px; tex-color: red;">' . $data['TEAM LEADER'] . '</td>
</tr>';
                $html .= '<tr>
    <td style="width: 30%; font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Assigned Process Monitor</td>
    <td style="border:1px solid #ccc; padding:8px; tex-color: red;">' . $data['PROCESS MONITOR'] . '</td>
</tr>';








                // Resolved On
                $html .= '<tr>
    <td style="font-weight: bold; border: 1px solid #dadada;">Closed On</td>
    <td style="border: 1px solid #dadada;">' . $data['RESOLVED ON'] . '</td>
</tr>';

                // Turn Around Time
                $html .= '<tr>
    <td style="font-weight: bold; border: 1px solid #dadada;">Turn Around Time</td>
    <td style="border: 1px solid #dadada;">' . $data['TURN AROUND TIME'] . '</td>
</tr>';

                // Incident History
                $html .= '<tr>
    <td style="font-weight:bold; background:#fafafa; border:1px solid #ccc; padding:8px;">Incident Timeline & History</td>
    <td style="border:1px solid #ccc; padding:10px;">';

                // Sort Incident History by created_on
                usort($data['DATA'], function ($a, $b) {
                    return strtotime($a->created_on) - strtotime($b->created_on);
                });

                foreach ($data['DATA'] as $r) {
                    $html .= '<strong style="color: blue;">' . $r->ticket_status . '</strong>';

                    $html .= '<div style="margin-bottom:15px; margin-top:15px; padding:10px; background:#f9f9f9; border:1px dashed #ddd; border-radius:5px;">';
                    $html .= '<strong>Date & Time:</strong> ' . date('d M, Y - g:i A', strtotime($r->created_on)) . '<br>';

                    if ($r->ticket_status != 'Assigned') {
                        $html .= '<strong>Action :</strong> ' . htmlspecialchars($r->action) . '<br>';
                    }

                    if (!empty($r->process_monitor_note)) {
                        $html .= '<strong>Notes :</strong> ' . htmlspecialchars($r->process_monitor_note) . '<br>';
                    }

                    if ($r->ticket_status == 'Transfered') {
                        $html .= '<strong>Action :</strong> ' . htmlspecialchars($r->action) . ' (Team Leader)<br>';
                        $html .= '<strong>Transferred by :</strong> ' . htmlspecialchars($r->message) . '<br>';
                        $html .= '<strong>Comment :</strong> ' . htmlspecialchars($r->reply) . '<br>';
                    }

                    if ($r->ticket_status == 'Assigned') {
                        $html .= '<strong>Action :</strong> ' . htmlspecialchars($r->action) . ' (Team Leader)<br>';
                        $html .= '<strong>Process Monitor :</strong> ' . htmlspecialchars($r->action_for_process_monitor) . '<br>';
                        $html .= '<strong>Assigned by :</strong> ' . htmlspecialchars($r->message) . '<br>';
                    }

                    if ($r->ticket_status == 'Re-assigned') {
                        $html .= '<strong>Process Monitor :</strong> ' . htmlspecialchars($r->action_for_process_monitor) . '<br>';
                        $html .= '<strong>Re-assigned by :</strong> ' . htmlspecialchars($r->message) . '<br>';
                    }

                    if ($r->ticket_status == 'Described') {
                        if (!empty($r->rca_tool_describe)) {
                            $html .= '<strong>Root Cause Analysis (RCA)</strong><br>';
                            $html .= '<strong>Tool Applied :</strong> ' . htmlspecialchars($r->rca_tool_describe) . '<br>';
                        }

                        if ($r->rca_tool_describe == 'DEFAULT') {
                            $html .= '<strong>Closure RCA :</strong> ' . htmlspecialchars($r->rootcause_describe) . '<br>';
                        }

                        if ($r->rca_tool_describe == '5WHY') {
                            $html .= '<ul>';
                            $html .= '<li><b><strong>WHY 1:</strong></b> ' . htmlspecialchars($r->fivewhy_1_describe) . '</li>';
                            $html .= '<li><b><strong>WHY 2:</strong></b> ' . htmlspecialchars($r->fivewhy_2_describe) . '</li>';
                            $html .= '<li><b><strong>WHY 3:</strong></b> ' . htmlspecialchars($r->fivewhy_3_describe) . '</li>';
                            $html .= '<li><b><strong>WHY 4:</strong></b> ' . htmlspecialchars($r->fivewhy_4_describe) . '</li>';
                            $html .= '<li><b><strong>WHY 5:</strong></b> ' . htmlspecialchars($r->fivewhy_5_describe) . '</li>';
                            $html .= '</ul>';
                        }

                        if ($r->rca_tool_describe == '5W2H') {
                            $html .= '<dl>';
                            if (!empty($r->fivewhy2h_1_describe))
                                $html .= '<dt><strong>What happened?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_1_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_2_describe))
                                $html .= '<dt><strong>Why did it happen?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_2_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_3_describe))
                                $html .= '<dt><strong>Where did it happen?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_3_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_4_describe))
                                $html .= '<dt><strong>When did it happen?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_4_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_5_describe))
                                $html .= '<dt><strong>Who was involved?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_5_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_6_describe))
                                $html .= '<dt><strong>How did it happen?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_6_describe) . '</dd>';
                            if (!empty($r->fivewhy2h_7_describe))
                                $html .= '<dt><strong>How much/How many (impact/cost)?</strong></dt><dd>' . htmlspecialchars($r->fivewhy2h_7_describe) . '</dd>';
                            $html .= '</dl>';
                        }

                        if (!empty($r->corrective_describe)) {
                            $html .= '<strong>Corrective Action :</strong> ' . htmlspecialchars($r->corrective_describe) . '<br>';
                        }

                        if (!empty($r->preventive_describe)) {
                            $html .= '<strong>Preventive Action :</strong> ' . htmlspecialchars($r->preventive_describe) . '<br>';
                        }

                        if (!empty($r->verification_comment_describe)) {
                            $html .= '<strong>Lesson Learned :</strong> ' . htmlspecialchars($r->verification_comment_describe) . '<br>';
                        }
                    }

                    if (!empty($r->reply) && $r->ticket_status != 'Described' && $r->ticket_status != 'Transfered') {
                        $html .= '<strong>' . lang_loader('inc', 'inc_comment') . ':</strong> ' . htmlspecialchars($r->reply) . '<br>';
                    }

                    if (!empty($r->rca_tool)) {
                        $html .= '<strong>Root Cause Analysis (RCA) for Incident Closure</strong><br>';
                        $html .= '<strong>Tool Applied :</strong> ' . htmlspecialchars($r->rca_tool) . '<br>';
                    }

                    if ($r->rca_tool == 'DEFAULT') {
                        $html .= '<strong>Closure RCA :</strong> ' . htmlspecialchars($r->rootcause) . '<br>';
                    }

                    if ($r->rca_tool == '5WHY') {
                        $html .= '<ul>';
                        $html .= '<li><b>WHY 1:</b> ' . htmlspecialchars($r->fivewhy_1) . '</li>';
                        $html .= '<li><b>WHY 2:</b> ' . htmlspecialchars($r->fivewhy_2) . '</li>';
                        $html .= '<li><b>WHY 3:</b> ' . htmlspecialchars($r->fivewhy_3) . '</li>';
                        $html .= '<li><b>WHY 4:</b> ' . htmlspecialchars($r->fivewhy_4) . '</li>';
                        $html .= '<li><b>WHY 5:</b> ' . htmlspecialchars($r->fivewhy_5) . '</li>';
                        $html .= '</ul>';
                    }

                    if ($r->rca_tool == '5W2H') {
                        $html .= '<dl>';
                        if (!empty($r->fivewhy2h_1))
                            $html .= '<dt>What happened?</dt><dd>' . htmlspecialchars($r->fivewhy2h_1) . '</dd>';
                        if (!empty($r->fivewhy2h_2))
                            $html .= '<dt>Why did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_2) . '</dd>';
                        if (!empty($r->fivewhy2h_3))
                            $html .= '<dt>Where did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_3) . '</dd>';
                        if (!empty($r->fivewhy2h_4))
                            $html .= '<dt>When did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_4) . '</dd>';
                        if (!empty($r->fivewhy2h_5))
                            $html .= '<dt>Who was involved?</dt><dd>' . htmlspecialchars($r->fivewhy2h_5) . '</dd>';
                        if (!empty($r->fivewhy2h_6))
                            $html .= '<dt>How did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_6) . '</dd>';
                        if (!empty($r->fivewhy2h_7))
                            $html .= '<dt>How much/How many (impact/cost)?</dt><dd>' . htmlspecialchars($r->fivewhy2h_7) . '</dd>';
                        $html .= '</dl>';
                    }

                    if (!empty($r->corrective)) {
                        $html .= '<strong>Closure Corrective Action :</strong> ' . htmlspecialchars($r->corrective) . '<br>';
                    }

                    if (!empty($r->preventive)) {
                        $html .= '<strong>Closure Preventive Action :</strong> ' . htmlspecialchars($r->preventive) . '<br>';
                    }

                    if (!empty($r->verification_comment)) {
                        $html .= '<strong>Closure Verification Remark :</strong> ' . htmlspecialchars($r->verification_comment) . '<br>';
                    }



                    $html .= '</div>';
                }

                $html .= '</td></tr>'; // End incident history row

                // Close table
                $html .= '</table>';
            }
        }




        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = 'EF- INCIDENT REPORT - ' . $tdate . ' to ' . $fdate . '.pdf';
        $pdf->Output($fileName, 'D');
    }

    // END SUPER ADMIN AND ADMIN LOGIN


    // DEPARTMENT HEAD LOGIN
    public function department_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('INCIDENT') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) {


            $data['title'] = 'INC- INCIDENTS DASHBOARD';
            #------------------------------#
            $data['content'] = $this->load->view('incidentmodules/department_tickets', $data, true);
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

        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- ALL INCIDENTS';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->alltickets();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/alltickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/alltickets', $data, true);
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

        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- ADDRESSED INCIDENTS';
            $data['departments'] = $this->ticketsincidents_model->addressedtickets();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/addressedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/addressedtickets', $data, true);
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

        $data['title'] = 'INC- INCIDENTS DETAILS';
        $data['departments'] = $this->ticketsincidents_model->read_by_id($this->uri->segment(3));
        if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
            $data['content'] = $this->load->view('incidentmodules/ticket_track', $data, true);
        } else {
            $data['content'] = $this->load->view('incidentmodules/dephead/ticket_track', $data, true);
        }
        $this->load->view('layout/main_wrapper', $data);
    }

    // open tickets
    public function opentickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {


            $data['title'] = 'INC- OPEN INCIDENTS';
            #-------------------------------#
            $data['departments'] = $this->ticketsincidents_model->read();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/opentickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/opentickets', $data, true);
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
        if (ismodule_active('INCIDENT') === true) {



            $data['title'] = 'INC- CLOSED INCIDENTS';
            $data['departments'] = $this->ticketsincidents_model->read_close();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/closedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/closedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            // redirect('tickets/ticket_close');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    //END TICKETS 
    public function rejecttickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- REJECTED INCIDENTS';
            $data['departments'] = $this->ticketsincidents_model->rejecttickets();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/rejecttickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/rejecttickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            // redirect('tickets/alltickets');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    //  REPORTS

    public function capa_report()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- INCIDENTS CLOSURE REPORT';
            $data['departments'] = $this->ticketsincidents_model->read_close();
            $data['content'] = $this->load->view('incidentmodules/capa_report', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }



    public function complaints()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {


            $data['title'] = 'INC- INCIDENTS EMPLOYEE' . "'" . 'S COMMENTS';
            $data['content'] = $this->load->view('incidentmodules/recent_comments', $data, true);
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
        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- INCIDENTS ';
            $data['departments'] = $this->ticketsincidents_model->read_by_id($this->uri->segment(3));
            #------------------------------#
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {

                $data['content'] = $this->load->view('incidentmodules/employee_complaint', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/employee_complaint', $data, true);
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
        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- INCIDENT NOTIFICATIONS';
            $data['content'] = $this->load->view('incidentmodules/recent_comments', $data, true);
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
        if (ismodule_active('INCIDENT') === true) {


            $table_feedback = 'bf_feedback_incident';
            $table_patients = 'bf_employees_incident';
            $desc = 'desc';
            $setup = 'setup_incident';

            $feedbacktaken = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $desc);
            $sresult = $this->incident_model->setup_result($setup);
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
            $header[6] = 'Incident Category';
            $header[7] = 'Incident';
            $header[8] = 'Incident Occured On';
            $header[9] = 'Assigned Risk';
            $header[10] = 'Assigned Priority';
            $header[11] = 'Incident Category';
            $header[12] = 'Description';
            $header[13] = 'What Went Wrong';
            $header[14] = 'Immediate Action Taken';
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
                $dataexport[$i]['name'] = $data['name'] ?? 'N/A';
                $dataexport[$i]['patient_id'] = $data['patientid'] ?? 'N/A';
                $dataexport[$i]['ward'] = $data['ward'] ?? 'N/A';
                $dataexport[$i]['bedno'] = $data['bedno'] ?? 'N/A';
                $dataexport[$i]['mobile'] = $data['contactnumber'] ?? 'N/A';

                // Department
                foreach ($data['comment'] as $key => $value) {
                    $dataexport[$i]['Department'] = $setarray[$key] ?? 'N/A';
                }

                // Ticket question
                foreach ($data['reason'] as $key => $value) {
                    if ($value) {
                        $dataexport[$i]['ticket'] = $question[$key] ?? 'N/A';
                    }
                }

                // ✅ Additional Fields
                $incidentTime = $data['incident_occured_in'] ?? '';
                if (!empty($incidentTime)) {
                    $formattedIncidentTime = date('d M, Y - g:i A', strtotime($incidentTime));
                } else {
                    $formattedIncidentTime = 'N/A';
                }
                $dataexport[$i]['incident_occured_in'] = $formattedIncidentTime;

                $dataexport[$i]['risk_level'] = $data['risk_matrix']['level'] ?? 'Unassigned';
                $dataexport[$i]['priority'] = $data['priority'] ?? 'Unassigned';
                $dataexport[$i]['incident_type'] = $data['incident_type'] ?? 'Unassigned';

                // Comment
                foreach ($data['comment'] as $key => $value) {
                    if ($value) {
                        $dataexport[$i]['comment'] = $value ?? 'N/A';
                    }
                }


                $dataexport[$i]['what_went_wrong'] = $data['what_went_wrong'] ?? 'N/A';
                $dataexport[$i]['action_taken'] = $data['action_taken'] ?? 'N/A';

                $i++;
            }

            $newdataset = $dataexport;
            // echo '<pre>';
            // print_r($dataexport);
            // exit;
            ob_end_clean();
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $fileName = 'EF- INCIDENT REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (!empty($dataexport) && is_array($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Write header row safely
                if (!empty($header) && is_array($header)) {
                    fputcsv($fp, $header, ',');
                }

                foreach ($dataexport as $values) {
                    // Convert object to array if needed
                    if (is_object($values)) {
                        $values = (array) $values;
                    }

                    // Skip if still not array or empty
                    if (is_array($values) && !empty($values)) {
                        fputcsv($fp, $values, ',');
                    }
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
        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'TAT SET';
            $data['content'] = $this->load->view('incidentmodules/dep_tat', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }




    public function dep_tat_edit()
    {
        if (ismodule_active('INCIDENT') === true) {

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



            $data['title'] = 'INC-Manage Turn Around Time';

            #------------------------------#

            $data['content'] = $this->load->view('incidentmodules/dep_tat_edit', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function overall_department_excel()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {


            $dataexport = array();
            $i = 0;
            $table_feedback = 'bf_feedback_incident';
            $table_patients = 'bf_employees_incident';
            $sorttime = 'asc';
            $setup = 'setup_incident';
            $asc = 'asc';
            $desc = 'desc';
            $table_tickets = 'tickets_incident';
            $open = 'Open';
            $closed = 'Closed';
            $addressed = 'Addressed';
            $type = 'incident';

            $int_feedbacks_count = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $int_tickets_count = $this->ticketsincidents_model->alltickets();
            $int_open_tickets = $this->ticketsincidents_model->read();
            $int_closed_tickets = $this->ticketsincidents_model->read_close();
            $int_addressed_tickets = $this->ticketsincidents_model->addressedtickets();


            $ticket_resolution_rate = $this->incident_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

            $header = 'INC INCIDENT REPORT';
            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            $dataexport[$i]['row1'] = 'INCIDENT REPORT';
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


            $dataexport[$i]['row1'] = 'TOTAL INCIDENTS';
            $dataexport[$i]['row2'] = count($int_tickets_count);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;



            $dataexport[$i]['row1'] = 'OPEN INCIDENTS';
            $dataexport[$i]['row2'] = count($int_open_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'ADDRESSED INCIDENTS';
            $dataexport[$i]['row2'] = count($int_addressed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;

            $dataexport[$i]['row1'] = 'CLOSED INCIDENTS';
            $dataexport[$i]['row2'] = count($int_closed_tickets);
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'INCIDENT RESOLUTION RATE';
            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;



            $dataexport[$i]['row1'] = '';
            $dataexport[$i]['row2'] = '';
            $dataexport[$i]['row3'] = '';
            $dataexport[$i]['row4'] = '';
            $i++;


            $dataexport[$i]['row1'] = 'INCIDENT RECEIVED BY CATEGORY';
            $dataexport[$i]['row2'] = 'PERCENTAGE';
            $dataexport[$i]['row3'] = 'COUNT';
            $dataexport[$i]['row4'] = 'OPEN';
            $dataexport[$i]['row5'] = 'ADDRESSED';
            $dataexport[$i]['row6'] = 'CLOSED';
            $dataexport[$i]['row7'] = 'RESOLUTION RATE';
            $dataexport[$i]['row8'] = '';
            $i++;

            $ticket = $this->incident_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);

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
            $fileName = 'EF- INCIDENT CATEGORY WISE REPORT - ' . $tdate . ' to ' . $fdate . '.csv';
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
        if (ismodule_active('INCIDENT') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            redirect('pdfreport/incident_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);
            // redirect('report/ip_capa_report');

        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function download_capa_report()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('INCIDENT') === true) {



            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];

            $this->db->select("*");

            $this->db->from('setup_incident');

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

            $departments = $this->ticketsincidents_model->read_close();






            $dataexport[$i]['row1'] = 'SL No.';
            $dataexport[$i]['row2'] = 'INCIDENT ID';
            $dataexport[$i]['row3'] = 'INCIDENT';
            $dataexport[$i]['row4'] = 'INCIDENT CATEGORY';
            $dataexport[$i]['row5'] = 'INCIDENT DESCRIPTION';
            $dataexport[$i]['row6'] = 'WHAT WENT WRONG';
            $dataexport[$i]['row7'] = 'IMMEDIATE ACTION TAKEN';
            $dataexport[$i]['row8'] = 'REPORTED BY';
            $dataexport[$i]['row9'] = 'INCIDENT OCCURED IN';
            $dataexport[$i]['row10'] = 'REPORTED ON';
            $dataexport[$i]['row11'] = 'REPORTED IN';


            $dataexport[$i]['row12'] = 'ASSIGNED RISK';
            $dataexport[$i]['row13'] = 'ASSIGNED PRIORITY';
            $dataexport[$i]['row14'] = 'ASSIGNED CATEGORY';

            $dataexport[$i]['row15'] = 'PATIENT DETAILS';
            $dataexport[$i]['row16'] = 'EMPLOYE DETAILS';
            $dataexport[$i]['row17'] = 'EQUIPMENT DETAILS';
            $dataexport[$i]['row18'] = 'ASSIGNED TEAM LEADER';
            $dataexport[$i]['row19'] = 'ASSIGNED TEAM MEMBER';
            $dataexport[$i]['row20'] = 'ASSIGNED PROCESS MONITOR ';


            $dataexport[$i]['row21'] = 'INCIDENT TIMELINE & HISTORY';

            $dataexport[$i]['row22'] = 'CLOSED ON';

            $dataexport[$i]['row23'] = 'TURN AROUND TIME';

            // $dataexport[$i]['row13'] = 'TAT STATUS';

            $i++;



            if (!empty($departments)) {

                $sl = 1;

                foreach ($departments as $department) {

                    // Step 1: Build user_id → firstname map
                    $userss = $this->db->select('user_id, firstname')
                        ->where('user_id !=', 1)
                        ->get('user')
                        ->result();

                    $userMap = [];
                    foreach ($userss as $u) {
                        $userMap[$u->user_id] = $u->firstname;
                    }

                    // Step 2: Convert comma-separated IDs into arrays
                    $assign_for_process_monitor_ids = !empty($department->assign_for_process_monitor)
                        ? explode(',', $department->assign_for_process_monitor)
                        : [];

                    $assign_to_ids = !empty($department->assign_to)
                        ? explode(',', $department->assign_to)
                        : [];

                    $assign_for_team_member_ids = !empty($department->assign_for_team_member)
                        ? explode(',', $department->assign_for_team_member)
                        : []; // 🆕

                    // Step 3: Map IDs → names
                    $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_for_process_monitor_ids);

                    $assign_to_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_to_ids);

                    $assign_for_team_member_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_for_team_member_ids); // 🆕

                    // Step 4: Join into comma-separated strings
                    $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
                    $names = implode(', ', $assign_to_names);
                    $actionText_team_member = implode(', ', $assign_for_team_member_names); // 🆕




                    $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');

                    $query = $this->db->get('ticket_incident_message');

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


                    $root = [];
                    $corrective = [];
                    $resolution_note = [];
                    $rootcause_describtion = [];
                    $corrective_description = [];

                    foreach ($department->replymessage as $r) {
                        if ($r->rootcause != NULL) {
                            $root[] = $r->rootcause;
                        }

                        if ($r->corrective != NULL) {
                            $corrective[] = $r->corrective;
                        }
                        if ($r->rootcause_describtion != NULL) {
                            $rootcause_describtion[] = $r->rootcause_describtion;
                        }
                        if ($r->corrective_description != NULL) {
                            $corrective_description[] = $r->corrective_description;
                        }

                        if ($r->resolution_note != NULL) {
                            $resolution_note[] = $r->resolution_note;
                        }

                        if ($r->ticket_status == 'Addressed' && $r->reply != NULL) {
                            $rep = $r->reply;
                        }
                    }



                    $value2 = $this->incident_model->convertSecondsToTime($department->department->close_time);

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

                    $value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

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

                    // Convert ISO date to PHP timestamp
                    $incidentTime = $department->feed->incident_occured_in;

                    // If it's not empty, format it
                    if (!empty($incidentTime)) {
                        $formatted = date('d M, Y - g:i A', strtotime($incidentTime));
                    } else {
                        $formatted = 'N/A';
                    }

                    $dataexport[$i]['row1'] = $sl;

                    $dataexport[$i]['row2'] = 'INC- ' . $department->id;
                    $dataexport[$i]['row3'] = $department->department->description;
                    $dataexport[$i]['row4'] = $issue;
                    $dataexport[$i]['row5'] = $department->feed->other;
                    $dataexport[$i]['row6'] = $department->feed->what_went_wrong;
                    $dataexport[$i]['row7'] = $department->feed->action_taken;
                    $dataexport[$i]['row8'] = $department->feed->name . '(' . $department->feed->patientid . ')';
                    $dataexport[$i]['row9'] = $formatted;
                    $dataexport[$i]['row10'] = date('g:i a, d-m-y', strtotime($department->created_on));
                    $dataexport[$i]['row11'] = $department->feed->ward . '(' . $department->feed->bedno . ')';
                    $dataexport[$i]['row12'] = $department->feed->risk_matrix->level ?? 'Unassigned';
                    $dataexport[$i]['row13'] = $department->feed->priority ?? 'Unassigned';
                    $dataexport[$i]['row14'] = $department->feed->incident_type ?? 'Unassigned';

                    $dataexport[$i]['row15'] = $department->feed->tag_name . '(' . $department->feed->tag_patientid . ')';
                    $dataexport[$i]['row16'] = $department->feed->employee_name . '(' . $department->feed->employee_if . ')';
                    $dataexport[$i]['row17'] = $department->feed->asset_name . '(' . $department->feed->asset_code . ')';
                    $dataexport[$i]['row18'] = $names;
                    $dataexport[$i]['row19'] = $actionText_team_member;
                    $dataexport[$i]['row20'] = $actionText_process_monitor;

                    usort($department->replymessage, function ($a, $b) {
                        return strtotime($a->created_on) - strtotime($b->created_on);
                    });

                    $reply_details = "";

                    foreach ($department->replymessage as $r) {

                        $reply_details .= "" . $r->ticket_status . "\n";
                        $reply_details .= "Date & Time : " . date('d M, Y - g:i A', strtotime($r->created_on)) . "\n";
                        $reply_details .= "Action : " . strip_tags($r->action) . "\n";

                        if ($r->process_monitor_note) {
                            $reply_details .= "Notes : " . strip_tags($r->process_monitor_note) . "\n";
                        }

                        if ($r->ticket_status == 'Assigned') {
                            $reply_details .= "Team Member : " . strip_tags($r->action_for_team_member) . "\n";
                            $reply_details .= "Process Monitor : " . strip_tags($r->action_for_process_monitor) . "\n";
                            $reply_details .= "Assigned by : " . strip_tags($r->message) . "\n";
                        }

                        if ($r->ticket_status == 'Re-assigned') {
                            $reply_details .= "Team Member : " . strip_tags($r->action_for_team_member) . "\n";
                            $reply_details .= "Process Monitor : " . strip_tags($r->action_for_process_monitor) . "\n";
                            $reply_details .= "Re-assigned by : " . strip_tags($r->message) . "\n";
                        }

                        if ($r->ticket_status == 'Transfered') {
                            $reply_details .= "Transferred by : " . strip_tags($r->message) . "\n";
                            $reply_details .= "Comment : " . strip_tags($r->reply) . "\n";
                        }

                        if ($r->ticket_status == 'Described') {
                            if ($r->rca_tool_describe) {
                                $reply_details .= "Root Cause Analysis (RCA)\n";
                                $reply_details .= "Tool Applied : " . strip_tags($r->rca_tool_describe) . "\n";
                            }

                            if ($r->rootcause_describe) {
                                $reply_details .= "RCA in brief : " . strip_tags($r->rootcause_describe) . "\n";
                            }

                            if ($r->rca_tool_describe == '5WHY') {
                                $reply_details .= "WHY 1 : " . strip_tags($r->fivewhy_1_describe) . "\n";
                                $reply_details .= "WHY 2 : " . strip_tags($r->fivewhy_2_describe) . "\n";
                                $reply_details .= "WHY 3 : " . strip_tags($r->fivewhy_3_describe) . "\n";
                                $reply_details .= "WHY 4 : " . strip_tags($r->fivewhy_4_describe) . "\n";
                                $reply_details .= "WHY 5 : " . strip_tags($r->fivewhy_5_describe) . "\n";
                            }

                            if ($r->rca_tool_describe == '5W2H') {
                                $reply_details .= "What happened? : " . strip_tags($r->fivewhy2h_1_describe) . "\n";
                                $reply_details .= "Why did it happen? : " . strip_tags($r->fivewhy2h_2_describe) . "\n";
                                $reply_details .= "Where did it happen? : " . strip_tags($r->fivewhy2h_3_describe) . "\n";
                                $reply_details .= "When did it happen? : " . strip_tags($r->fivewhy2h_4_describe) . "\n";
                                $reply_details .= "Who was involved? : " . strip_tags($r->fivewhy2h_5_describe) . "\n";
                                $reply_details .= "How did it happen? : " . strip_tags($r->fivewhy2h_6_describe) . "\n";
                                $reply_details .= "How much/How many? : " . strip_tags($r->fivewhy2h_7_describe) . "\n";
                            }

                            if ($r->corrective_describe) {
                                $reply_details .= "Corrective Action : " . strip_tags($r->corrective_describe) . "\n";
                            }
                            if ($r->preventive_describe) {
                                $reply_details .= "Preventive Action : " . strip_tags($r->preventive_describe) . "\n";
                            }
                            if ($r->verification_comment_describe) {
                                $reply_details .= "Lesson Learned : " . strip_tags($r->verification_comment_describe) . "\n";
                            }
                        }

                        if ($r->reply && $r->ticket_status != 'Described' && $r->ticket_status != 'Transfered') {
                            $reply_details .= "Comment : " . strip_tags($r->reply) . "\n";
                        }

                        if ($r->rca_tool) {
                            $reply_details .= "Root Cause Analysis (Closure)\n";
                            $reply_details .= "Tool Applied : " . strip_tags($r->rca_tool) . "\n";

                            if ($r->rca_tool == 'DEFAULT') {
                                $reply_details .= "Closure RCA : " . strip_tags($r->rootcause) . "\n";
                            }
                            if ($r->rca_tool == '5WHY') {
                                $reply_details .= "WHY 1 : " . strip_tags($r->fivewhy_1) . "\n";
                                $reply_details .= "WHY 2 : " . strip_tags($r->fivewhy_2) . "\n";
                                $reply_details .= "WHY 3 : " . strip_tags($r->fivewhy_3) . "\n";
                                $reply_details .= "WHY 4 : " . strip_tags($r->fivewhy_4) . "\n";
                                $reply_details .= "WHY 5 : " . strip_tags($r->fivewhy_5) . "\n";
                            }
                            if ($r->rca_tool == '5W2H') {
                                $reply_details .= "What happened? : " . strip_tags($r->fivewhy2h_1) . "\n";
                                $reply_details .= "Why did it happen? : " . strip_tags($r->fivewhy2h_2) . "\n";
                                $reply_details .= "Where did it happen? : " . strip_tags($r->fivewhy2h_3) . "\n";
                                $reply_details .= "When did it happen? : " . strip_tags($r->fivewhy2h_4) . "\n";
                                $reply_details .= "Who was involved? : " . strip_tags($r->fivewhy2h_5) . "\n";
                                $reply_details .= "How did it happen? : " . strip_tags($r->fivewhy2h_6) . "\n";
                                $reply_details .= "How much/How many? : " . strip_tags($r->fivewhy2h_7) . "\n";
                            }
                        }

                        if ($r->corrective) {
                            $reply_details .= "Closure Corrective Action : " . strip_tags($r->corrective) . "\n";
                        }
                        if ($r->preventive) {
                            $reply_details .= "Closure Preventive Action : " . strip_tags($r->preventive) . "\n";
                        }
                        if ($r->verification_comment) {
                            $reply_details .= "Closure Verification Remark : " . strip_tags($r->verification_comment) . "\n";
                        }



                        $reply_details .= "---------------------------------------\n";
                    }

                    $dataexport[$i]['row21'] = $reply_details;




                    $dataexport[$i]['row22'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                    $dataexport[$i]['row23'] = $timetaken;

                    // $dataexport[$i]['row13'] = $close;

                    $i++;

                    $sl++;

                }
            }



            ob_end_clean();

            $fileName = 'INCIDENT CLOSURE REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');

            header('Expires: 0');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Cache-Control: private', false);

            header('Content-Type: text/csv');

            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport) && is_array($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Write header safely
                if (!empty($header) && is_array($header)) {
                    fputcsv($fp, $header, ',');
                }

                foreach ($dataexport as $values) {
                    // PHP 8 strict type-safe check
                    if (is_object($values)) {
                        $values = (array) $values;
                    }

                    if (is_array($values)) {
                        fputcsv($fp, $values, ',');
                    }
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

        if (ismodule_active('INCIDENT') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];
            $this->db->select("*");
            $this->db->from('setup_incident');
            $query = $this->db->get();
            $reasons = $query->result();
            foreach ($reasons as $row) {
                $keys[$row->shortkey] = $row->shortkey;
                $res[$row->shortkey] = $row->shortname;
                $titles[$row->shortkey] = $row->title;
            }

            $dataexport = array();
            $i = 0;
            $departments = $this->ticketsincidents_model->alltickets();
            // echo '<pre>';
            // print_r($departments);
            // exit;

            //KPI is connected to this incident
            if (isset($_GET['kpi']) && $_GET['kpi'] == 'incident') {

                $from = isset($_GET['from']) ? $_GET['from'] : null;
                $to   = isset($_GET['to']) ? $_GET['to'] : null;

                if ($from && $to) {
                    $filtered = [];

                    foreach ($departments as $row) {

                        $audit_date = date('Y-m-d', strtotime($row->created_on));

                        if ($audit_date >= $from && $audit_date <= $to) {
                            $filtered[] = $row;
                        }
                    }

                    // Replace only for KPI-triggered download
                    $departments = $filtered;
                }
            }
            //END

            $dataexport[$i]['row1'] = 'SL No.';
            $dataexport[$i]['row2'] = 'INCIDENT ID';
            $dataexport[$i]['row3'] = 'REPORTED ON';
            $dataexport[$i]['row4'] = 'REPORTED BY';
            $dataexport[$i]['row5'] = 'EMPLOYEE ID';
            $dataexport[$i]['row6'] = 'PHONE NUMBER';
            $dataexport[$i]['row7'] = 'INCIDENT';
            $dataexport[$i]['row8'] = 'INCIDENT SHORT NAME';
            $dataexport[$i]['row9'] = 'INCIDENT DESCRIPTION';
            $dataexport[$i]['row10'] = 'INCIDENT OCCURED ON';

            $dataexport[$i]['row11'] = 'FLOOR/WARD';
            $dataexport[$i]['row12'] = 'SITE';

            $dataexport[$i]['row13'] = 'ASSIGNED RISK';
            $dataexport[$i]['row14'] = 'ASSIGNED PRIORITY';
            $dataexport[$i]['row15'] = 'ASSIGNED CATEGORY';


            $dataexport[$i]['row16'] = 'TAGGED PATIENT NAME';
            $dataexport[$i]['row17'] = 'TAGGED PATIENT ID';


            $dataexport[$i]['row18'] = 'ASSIGNEE TO';
            $dataexport[$i]['row19'] = 'TAT DUE DATE';
            $dataexport[$i]['row20'] = 'TAT DESCRIBED STATUS';
            $dataexport[$i]['row21'] = 'RCA TOOL APPLIED';
            $dataexport[$i]['row22'] = 'RCA IN BRIEF';
            $dataexport[$i]['row23'] = 'ROOT CAUSE ANALYSIS';
            $dataexport[$i]['row24'] = 'CORRECTIVE ACTION';
            $dataexport[$i]['row25'] = 'PREVENTIVE ACTION';
            $dataexport[$i]['row26'] = 'CLOSURE VERIFICATION REMARK';

            $dataexport[$i]['row27'] = 'STATUS';

            $i++;
            if (!empty($departments)) {

                $sl = 1;
                foreach ($departments as $department) {
                    $rca_details = '';
                    $corrective_describe = '';
                    $preventive_describe = '';
                    $closedverifycomment = '';
                    $display = '';
                    $tat_due_date = '';

                    date_default_timezone_set('Asia/Kolkata');

                    // --- Build user map ---
                    $userss = $this->db->select('user_id, firstname')
                        ->where('user_id !=', 1)
                        ->get('user')
                        ->result();

                    $userMap = [];
                    foreach ($userss as $u) {
                        $userMap[$u->user_id] = $u->firstname;
                    }

                    // --- Convert assigned IDs ---
                    $assign_to_ids = !empty($department->assign_to)
                        ? explode(',', $department->assign_to)
                        : [];

                    $assign_to_names = array_map(function ($id) use ($userMap) {
                        return isset($userMap[$id]) ? $userMap[$id] : $id;
                    }, $assign_to_ids);

                    $names = implode(',', $assign_to_names);

                    // --- Determine due date ---
                    $targetDate = $department->assign_tat_due_date ?? null;
                    $dueDate = '';
                    $tat_due_date = '';
                    $now = time();


                    if (!empty($targetDate) && strtolower($targetDate) != 'unassigned' && strtolower($targetDate) != 'na') {
                        $dueDate = strtotime($targetDate);
                        $tat_due_date = date('d M, Y - g:i A', $dueDate);
                    }

                    // --- Get described date (if applicable) ---
                    $describedDate = null;
                    $ticketId = $department->id ?? null;

                    if (!empty($ticketId) && $department->status == 'Described') {
                        $result = $this->db->select('created_on')
                            ->from('ticket_incident_message')
                            ->where('ticketid', $ticketId)
                            ->where('ticket_status', 'Described')
                            ->order_by('created_on', 'DESC')
                            ->limit(1)
                            ->get()
                            ->row();

                        if (!empty($result)) {
                            $describedDate = strtotime($result->created_on);
                        }
                    }

                    // --- Determine display status ---
                    if (empty($dueDate)) {
                        $display = 'Unassigned';
                    } else if ($department->status == 'Described' && !empty($describedDate)) {
                        if ($describedDate <= $dueDate) {
                            $display = 'Within TAT';
                        } else {
                            $diff = $describedDate - $dueDate;
                            $days = floor($diff / (60 * 60 * 24));
                            $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
                            $display = 'TAT Exceeded by ';
                            if ($days > 0)
                                $display .= $days . ' days ';
                            if ($hours > 0)
                                $display .= $hours . ' hrs';
                        }
                    } else {
                        if ($dueDate > $now) {
                            $display = 'Within TAT';
                        } else {
                            $diff = $now - $dueDate;
                            $days = floor($diff / (60 * 60 * 24));
                            $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
                            $display = 'TAT Due by ';
                            if ($days > 0)
                                $display .= $days . ' days ';
                            if ($hours > 0)
                                $display .= $hours . ' hrs';
                        }
                    }

                    // --- Fetch closed verification comment ---
                    if (!empty($ticketId) && $department->status == 'Closed') {
                        $result = $this->db->select('verification_comment')
                            ->from('ticket_incident_message')
                            ->where('ticketid', $ticketId)
                            ->where('ticket_status', 'Closed')
                            ->order_by('created_on', 'DESC')
                            ->limit(1)
                            ->get()
                            ->row();
                        if (!empty($result)) {
                            $closedverifycomment = $result->verification_comment;
                        }
                    }


                    // ✅ If status is "Described", fetch described time from DB
                    if ($department->status == 'Described' || $department->status == 'Closed') {

                        $this->db->select('*')
                            ->from('ticket_incident_message')
                            ->where('ticketid', $ticketId)
                            ->where('ticket_status', 'Described')
                            ->order_by('created_on', 'DESC')
                            ->limit(1);
                        $query = $this->db->get();
                        $result = $query->row();

                        if (!empty($result)) {
                            $corrective_describe = $result->corrective_describe;
                            $preventive_describe = $result->preventive_describe;
                            $rca_tool_describe = $result->rca_tool_describe;
                            $rootcause_describe = $result->rootcause_describe;

                            // Tool applied
                            // if (!empty($result->rca_tool_describe)) {
                            //     $rca_details .= "Tool Applied: " . $result->rca_tool_describe . "\n";
                            // }
                            // // RCA in brief
                            // if (!empty($result->rootcause_describe)) {
                            //     $rca_details .= "RCA in brief: " . $result->rootcause_describe . "\n";
                            // }

                            // 5 WHY format
                            if ($result->rca_tool_describe == '5WHY') {
                                for ($w = 1; $w <= 5; $w++) {
                                    $why_field = 'fivewhy_' . $w . '_describe';
                                    if (!empty($result->$why_field)) {
                                        $rca_details .= "WHY $w: " . $result->$why_field . "\n";
                                    }
                                }
                            }

                            // 5W2H format
                            if ($result->rca_tool_describe == '5W2H') {
                                $map = [
                                    'fivewhy2h_1_describe' => 'What happened?',
                                    'fivewhy2h_2_describe' => 'Why did it happen?',
                                    'fivewhy2h_3_describe' => 'Where did it happen?',
                                    'fivewhy2h_4_describe' => 'When did it happen?',
                                    'fivewhy2h_5_describe' => 'Who was involved?',
                                    'fivewhy2h_6_describe' => 'How did it happen?',
                                    'fivewhy2h_7_describe' => 'How much / How many (impact/cost)?'
                                ];

                                foreach ($map as $field => $label) {
                                    if (!empty($result->$field)) {
                                        $rca_details .= $label . ': ' . $result->$field . "\n";
                                    }
                                }
                            }

                        }



                    }

                    $rm = (array) $department->feed->risk_matrix;

                    $level = $rm['level'] ?? 'Unassigned';
                    $impact = $rm['impact'] ?? 'Unassigned';
                    $likelihood = $rm['likelihood'] ?? 'Unassigned';

                    // color mapping (not needed for export, but kept consistent)
                    $riskColors = [
                        'High' => '#d9534f',
                        'Medium' => '#f0ad4e',
                        'Low' => '#5bc0de',
                        'default' => '#6c757d'
                    ];

                    $getColor = function ($value) use ($riskColors) {
                        return $riskColors[$value] ?? $riskColors['default'];
                    };
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
                        $incidentTime = $department->feed->incident_occured_in;

                        // If it's not empty, format it
                        if (!empty($incidentTime)) {
                            $formatted = date('d M, Y - g:i A', strtotime($incidentTime));
                        } else {
                            $formatted = 'N/A';
                        }
                        $transfer_dep_desc = $moved_to_arr[0]->description;
                        if (!empty($department)) {
                            $dataexport[$i]['row1'] = $sl;
                            $dataexport[$i]['row2'] = 'INC- ' . $department->id;
                            $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                            $dataexport[$i]['row4'] = $department->feed->name;
                            $dataexport[$i]['row5'] = $department->feed->patientid;
                            $dataexport[$i]['row6'] = $department->feed->contactnumber;
                            $dataexport[$i]['row7'] = $issue;
                            $dataexport[$i]['row8'] = $department->department->description;
                            $dataexport[$i]['row9'] = $department->feed->other;
                            $dataexport[$i]['row10'] = $formatted;
                            $dataexport[$i]['row11'] = $department->feed->ward;
                            $dataexport[$i]['row12'] = $department->feed->bedno;
                            $dataexport[$i]['row13'] = $level . ' (' . $impact . ' Impact × ' . $likelihood . ' Likelihood)';
                            $dataexport[$i]['row14'] = $department->feed->priority;
                            $dataexport[$i]['row15'] = $department->feed->incident_type;
                            if ($department->feed->tag_name != '' && $department->feed->tag_name != NULL) {
                                $dataexport[$i]['row16'] = $department->feed->tag_name;
                            } else {
                                $dataexport[$i]['row16'] = 'NA';
                            }
                            if ($department->feed->tag_patientid != '' && $department->feed->tag_patientid != NULL) {
                                $dataexport[$i]['row17'] = $department->feed->tag_patientid;
                            } else {
                                $dataexport[$i]['row17'] = 'NA';
                            }
                            if ($names != '' && $names != NULL) {
                                $dataexport[$i]['row18'] = $names;
                            } else {
                                $dataexport[$i]['row18'] = 'NA';
                            }
                            if ($tat_due_date != '' && $tat_due_date != NULL) {
                                $dataexport[$i]['row19'] = $tat_due_date;
                            } else {
                                $dataexport[$i]['row19'] = 'Unassigned';
                            }
                            if ($display != '' && $display != NULL) {
                                $dataexport[$i]['row20'] = $display;
                            } else {
                                $dataexport[$i]['row20'] = 'NA';
                            }

                            if ($rca_tool_describe != '') {
                                $dataexport[$i]['row21'] = $rca_tool_describe;
                            } else {
                                $dataexport[$i]['row21'] = 'NA';
                            }
                            if ($rootcause_describe != '') {
                                $dataexport[$i]['row22'] = $rootcause_describe;
                            } else {
                                $dataexport[$i]['row22'] = 'NA';
                            }
                            if ($rca_details != '') {
                                $dataexport[$i]['row23'] = $rca_details;
                            } else {
                                $dataexport[$i]['row23'] = 'NA';
                            }
                            if ($corrective_describe != '' && $corrective_describe != NULL) {
                                $dataexport[$i]['row24'] = $corrective_describe;
                            } else {
                                $dataexport[$i]['row24'] = 'NA';
                            }
                            if ($preventive_describe != '' && $preventive_describe != NULL) {
                                $dataexport[$i]['row25'] = $preventive_describe;
                            } else {
                                $dataexport[$i]['row25'] = 'NA';
                            }
                            if ($closedverifycomment != '' && $closedverifycomment != NULL) {
                                $dataexport[$i]['row26'] = $closedverifycomment;
                            } else {
                                $dataexport[$i]['row26'] = 'NA';
                            }
                            $dataexport[$i]['row27'] = ($department->status == 'Re-assigned') ? 'Assigned' : $department->status;




                        }
                    }
                    $i++;
                    $sl++;
                }
            }



            ob_end_clean();

            $fileName = 'EF- INC ALL INCIDENTS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');

            header('Expires: 0');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Cache-Control: private', false);

            header('Content-Type: text/csv');

            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport) && is_array($dataexport)) {

                $fp = fopen('php://output', 'w');

                // Write CSV header if it exists and is an array
                if (!empty($header) && is_array($header)) {
                    fputcsv($fp, $header, ',');
                }

                foreach ($dataexport as $values) {
                    // Ensure each row is a valid array before writing
                    if (is_array($values)) {
                        fputcsv($fp, $values, ',');
                    } else {
                        // Optionally log invalid rows for debugging
                        error_log('Invalid CSV row: ' . print_r($values, true));
                    }
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
        if (ismodule_active('INCIDENT') === true) {


            $departments = $this->ticketsincidents_model->alltickets();
            if (!empty($departments)) {

                $fdate = $_SESSION['from_date'];
                $tdate = $_SESSION['to_date'];
                $this->db->select("*");
                $this->db->from('setup_incident');
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
                $dataexport[$i]['row2'] = 'INCIDENT ID';
                $dataexport[$i]['row3'] = 'REPORTED ON';
                $dataexport[$i]['row4'] = 'REPORTED BY';
                $dataexport[$i]['row5'] = 'EMPLOYEE ID';
                $dataexport[$i]['row6'] = 'PHONE NUMBER';
                $dataexport[$i]['row7'] = 'FLOOR/WARD';
                $dataexport[$i]['row8'] = 'SITE';
                $dataexport[$i]['row9'] = 'INCIDENT SEVERITY';
                $dataexport[$i]['row10'] = 'ACTION PRIORITY';
                $dataexport[$i]['row11'] = 'ASSIGNED RISK';
                $dataexport[$i]['row12'] = 'INCIDENT';
                $dataexport[$i]['row13'] = 'CATEGORY';
                $dataexport[$i]['row14'] = 'ASSIGNEE';
                $dataexport[$i]['row15'] = 'STATUS';
                $dataexport[$i]['row16'] = 'TRANSFERRED TO';
                $dataexport[$i]['row17'] = 'LAST MODIFIED';
                $dataexport[$i]['row18'] = 'TAGGED PATIENT NAME';
                $dataexport[$i]['row19'] = 'TAGGED PATIENT ID';
                $dataexport[$i]['row20'] = 'TAGGED EMPLOYE NAME';
                $dataexport[$i]['row21'] = 'TAGGED EMPLOYE ID';
                $dataexport[$i]['row22'] = 'TAGGED ASSET NAME';
                $dataexport[$i]['row23'] = 'TAGGED ASSET CODE';
                $i++;
            }
            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {
                    $rm = (array) $department->feed->risk_matrix;

                    $level = $rm['level'] ?? 'Unassigned';
                    $impact = $rm['impact'] ?? 'Unassigned';
                    $likelihood = $rm['likelihood'] ?? 'Unassigned';

                    // color mapping (not needed for export, but kept consistent)
                    $riskColors = [
                        'High' => '#d9534f',
                        'Medium' => '#f0ad4e',
                        'Low' => '#5bc0de',
                        'default' => '#6c757d'
                    ];

                    $getColor = function ($value) use ($riskColors) {
                        return $riskColors[$value] ?? $riskColors['default'];
                    };
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
                                $dataexport[$i]['row2'] = 'INC- ' . $department->id;
                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                                $dataexport[$i]['row4'] = $department->feed->name;
                                $dataexport[$i]['row5'] = $department->feed->patientid;
                                $dataexport[$i]['row6'] = $department->feed->contactnumber;
                                $dataexport[$i]['row7'] = $department->feed->ward;
                                $dataexport[$i]['row8'] = $department->feed->bedno;
                                $dataexport[$i]['row9'] = $department->feed->incident_type;
                                $dataexport[$i]['row10'] = $department->feed->priority;
                                $dataexport[$i]['row11'] = $level . ' (' . $impact . ' Impact × ' . $likelihood . ' Likelihood)';
                                $dataexport[$i]['row12'] = $issue;
                                $dataexport[$i]['row13'] = $department->department->description;
                                if ($department->department->pname != '' && $department->department->pname != NULL) {
                                    $dataexport[$i]['row14'] = $department->department->pname;
                                } else {
                                    $dataexport[$i]['row14'] = 'NA';
                                }
                                $dataexport[$i]['row15'] = $department->status;
                                if ($transfer_dep_desc) {

                                    $dataexport[$i]['row16'] = $transfer_dep_desc;
                                } else {
                                    $dataexport[$i]['row16'] = 'NA';
                                }
                                $dataexport[$i]['row17'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                                if ($department->feed->tag_name != '' && $department->feed->tag_name != NULL) {
                                    $dataexport[$i]['row18'] = $department->feed->tag_name;
                                } else {
                                    $dataexport[$i]['row18'] = 'NA';
                                }
                                if ($department->feed->tag_patientid != '' && $department->feed->tag_patientid != NULL) {
                                    $dataexport[$i]['row19'] = $department->feed->tag_patientid;
                                } else {
                                    $dataexport[$i]['row19'] = 'NA';
                                }

                                if ($department->feed->employee_name != '' && $department->feed->employee_name != NULL) {
                                    $dataexport[$i]['row20'] = $department->feed->employee_name;
                                } else {
                                    $dataexport[$i]['row20'] = 'NA';
                                }
                                if ($department->feed->employee_id != '' && $department->feed->employee_id != NULL) {
                                    $dataexport[$i]['row21'] = $department->feed->employee_id;
                                } else {
                                    $dataexport[$i]['row21'] = 'NA';
                                }
                                if ($department->feed->asset_name != '' && $department->feed->asset_name != NULL) {
                                    $dataexport[$i]['row22'] = $department->feed->asset_name;
                                } else {
                                    $dataexport[$i]['row22'] = 'NA';
                                }
                                if ($department->feed->asset_code != '' && $department->feed->asset_code != NULL) {
                                    $dataexport[$i]['row23'] = $department->feed->asset_code;
                                } else {
                                    $dataexport[$i]['row23'] = 'NA';
                                }
                            }
                        }
                        $i++;
                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- INC OPEN INCIDENTS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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


    public function describetickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- DESCRIBED INCIDENTS';
            $data['departments'] = $this->ticketsincidents_model->describetickets();
            if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {
                $data['content'] = $this->load->view('incidentmodules/describetickets', $data, true);
            } else {
                $data['content'] = $this->load->view('incidentmodules/dephead/describetickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            // redirect('tickets/alltickets');

        } else {
            redirect('dashboard/noaccess');
        }
    }
    public function ticket_resolution_rate()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {


            $data['title'] = 'INC- INCIDENT RESOLUTION RATE';
            #------------------------------#
            $data['content'] = $this->load->view('incidentmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function average_resolution_time()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('INCIDENT') === true) {

            $data['title'] = 'INC- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('incidentmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
