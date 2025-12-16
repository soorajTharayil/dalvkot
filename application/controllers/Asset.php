<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Asset extends CI_Controller
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

                'ticketsasset_model',
                'asset_model',

                'pc_model',

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

        $this->module = 'complaint_modules';



        $this->session->set_userdata([

            'active_menu' => array('int_dashboard', 'int_ticket', 'int_reports', 'int_patients', 'int_settings'),

        ]);
    }

    // if (ismodule_active('ASSET') === false  && $this->uri->segment(2) != 'track'){

    //     redirect('dashboard/noaccess');
    // }



    // RESERVED FOR DEVELOPER OR COMPANY ACCESS

    function index()
    {


        print_r($this->session->userdata('permissions'));
        // if (ismodule_active('ASSET') === true ) {



        //         $data['title'] = 'PC MODULE CONFIGURATION';

        //         $data['content'] = $this->load->view('assetmodules/developer', $data, true);

        //         $this->load->view('layout/main_wrapper', $data);

        // } else {

        //     redirect('dashboard/noaccess');
        // }
    }



    // SUPER ADMIN AND ADMIN LOGIN

    public function ticket_dashboard()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');


        if (ismodule_active('ASSET') === true) {





            $data['title'] = 'ASSET MANAGER DASHBOARD';

            #------------------------------#

            $data['content'] = $this->load->view('assetmodules/ticket_dashboard', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }


    // public function ticket_dashboard_pie() {
    //     // Check if the user is logged in
    //     if ($this->session->userdata('isLogIn') == false) {
    //         redirect('login');
    //     }

    //     // Prepare the data
    //     $data = [
    //         'labels' => [
    //             'Emergency Response Equipment',
    //             'Facility and Infrastructure',
    //             'Furniture and Fixtures',
    //             'Human Resources',
    //             'IT and Information Systems',
    //             'Medical Equipment',
    //             'Pharmaceuticals and Medications',
    //             'Research Equipment',
    //             'Safety and Security',
    //             'Supplies and Consumables',
    //             'Utilities',
    //             'Vehicles'
    //         ],
    //         'values' => [12, 15, 8, 20, 17, 10, 9, 5, 12, 7, 18, 6] // Add your values here
    //     ];

    //     // Set the content type to JSON
    //     header('Content-Type: application/json');

    //     // Return the JSON-encoded data
    //     echo json_encode($data);
    // }

    public function ticket_dashboard_pie()
    {
        // Check if the user is logged in
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

        // Load the database if not already loaded
        //$this->load->database();

        // Fetch departments
        $departments = $this->db->select('id, title')
            ->from('bf_departmentasset')
            ->get()
            ->result_array();

        if ($_SESSION['ward'] !== 'ALL') {
            $this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
        }

        // Fetch feedback data
        $feedbacks = $this->db->select('dataset')
            ->from('bf_feedback_asset_creation')
            ->where('datetime >=', $tdate)
            ->where('datetime <=', $fdate)
            ->get()
            ->result_array();

        // Initialize the labels and values
        $labels = [];
        $values = [];

        // Iterate over departments and count matching assets
        foreach ($departments as $department) {
            $count = 0;
            $title = $department['title'];

            foreach ($feedbacks as $feedback) {
                $dataset = json_decode($feedback['dataset'], true);

                if (isset($dataset['ward']) && $dataset['ward'] === $title) {
                    $count++;
                }
            }

            // Only add departments with assets to the chart
            if ($count > 0) {
                $labels[] = $title;
                $values[] = $count;
            }
        }

        // Prepare the data for the pie chart
        $data = [
            'labels' => $labels,
            'values' => $values
        ];

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Return the JSON-encoded data
        echo json_encode($data);
    }

    public function asset_department_chart()
    {
        // Check if the user is logged in
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

        // Load the database if not already loaded
        //$this->load->database();

        // Fetch departments
        $departments = $this->db->select('id, title')
            ->from('bf_asset_location')
            ->get()
            ->result_array();

        if ($_SESSION['ward'] !== 'ALL') {
            $this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
        }

        // Fetch feedback data
        $feedbacks = $this->db->select('dataset')
            ->from('bf_feedback_asset_creation')
            ->where('datetime >=', $tdate)
            ->where('datetime <=', $fdate)
            ->get()
            ->result_array();

        // Initialize the labels and values
        $labels = [];
        $values = [];

        // Iterate over departments and count matching assets
        foreach ($departments as $department) {
            $count = 0;
            $title = $department['title'];

            foreach ($feedbacks as $feedback) {
                $dataset = json_decode($feedback['dataset'], true);

                if (isset($dataset['depart']) && $dataset['depart'] === $title) {
                    $count++;
                }
            }

            // Only add departments with assets to the chart
            if ($count > 0) {
                $labels[] = $title;
                $values[] = $count;
            }
        }

        // Prepare the data for the pie chart
        $data = [
            'labels' => $labels,
            'values' => $values
        ];

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Return the JSON-encoded data
        echo json_encode($data);
    }

    public function asset_floor_chart()
    {
        // Check if the user is logged in
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

        // Load the database if not already loaded
        //$this->load->database();

        // Fetch departments
        $departments = $this->db->select('id, title')
            ->from('bf_ward_esr')
            ->where('title !=', 'ALL')
            ->get()
            ->result_array();

        if ($_SESSION['ward'] !== 'ALL') {
            $this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
        }

        // Fetch feedback data
        $feedbacks = $this->db->select('dataset')
            ->from('bf_feedback_asset_creation')
            ->where('datetime >=', $tdate)
            ->where('datetime <=', $fdate)
            ->get()
            ->result_array();

        // Initialize the labels and values
        $labels = [];
        $values = [];

        // Iterate over departments and count matching assets
        foreach ($departments as $department) {
            $count = 0;
            $title = $department['title'];

            foreach ($feedbacks as $feedback) {
                $dataset = json_decode($feedback['dataset'], true);

                if (isset($dataset['locationsite']) && $dataset['locationsite'] === $title) {
                    $count++;
                }
            }

            // Only add departments with assets to the chart
            if ($count > 0) {
                $labels[] = $title;
                $values[] = $count;
            }
        }

        // Prepare the data for the pie chart
        $data = [
            'labels' => $labels,
            'values' => $values
        ];

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Return the JSON-encoded data
        echo json_encode($data);
    }

    public function asset_grade_chart()
    {
        if ($this->session->userdata('isLogIn') == false) {
            redirect('login');
        }

        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

        $grades = $this->db->select('title, bed_no, bed_nom')
            ->from('bf_asset_grade')
            ->where('title !=', 'ALL')
            ->get()
            ->result_array();

        // Sort in PHP by last letter
        usort($grades, function ($a, $b) {
            return strcmp(substr($a['title'], -1), substr($b['title'], -1));
        });

        if ($_SESSION['ward'] !== 'ALL') {
            $this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
        }

        $assets = $this->db->select('dataset')
            ->from('bf_feedback_asset_creation')
            ->where('datetime >=', $tdate)
            ->where('datetime <=', $fdate)
            ->get()
            ->result_array();

        $labels = [];
        $values = [];

        foreach ($grades as $grade) {
            $count = 0;
            $minPrice = (float)$grade['bed_no'];
            $maxPrice = (float)$grade['bed_nom'];

            foreach ($assets as $asset) {
                $data = json_decode($asset['dataset'], true);

                if (isset($data['unitprice'])) {
                    $unitPrice = (float)$data['unitprice'];

                    if ($unitPrice >= $minPrice && $unitPrice <= $maxPrice) {
                        $count++;
                    }
                }
            }

            $labels[] = $grade['title'];
            $values[] = $count;
        }

        $chartData = [
            'labels' => $labels,
            'values' => $values
        ];

        header('Content-Type: application/json');
        echo json_encode($chartData);
    }









    public function deny_transfer($ticket_id)
    {
        // Get ticket details
        $this->db->where('id', $ticket_id);
        $ticket = $this->db->get('tickets_asset')->row();

        $current_user_id = $this->session->userdata('user_id');

        // Check if current user is super admin (roles 2 or 3)
        if (in_array($this->session->userdata('user_role'), [2, 3])) {
            $data = array(
                'transfer_approval_status' => 'denied',
                'transfer_to' => null
            );
            $message = 'Transfer denied by Super Admin';
        } else {
            // Regular user denial
            $transfer_to_users = $ticket->transfer_to ? explode(',', $ticket->transfer_to) : [];
            if (!in_array($current_user_id, $transfer_to_users)) {
                redirect('asset/track/' . $ticket_id);
                return;
            }
            $data = array(
                'transfer_approval_status' => 'denied'
            );
            $message = 'Transfer denied by Receiving User';
        }

        // Update the ticket
        $this->db->where('id', $ticket_id);
        $this->db->update('tickets_asset', $data);

        // Log denial message
        $this->db->insert('asset_ticket_message', array(
            'reply' => 'Denied',
            'message' => $message,
            'action' => 'Transfer Denied',
            'created_by' => $current_user_id,
            'ticketid' => $ticket_id
        ));

        // Trigger email/API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
        curl_exec($curl);

        redirect('asset/track/' . $ticket_id);
    }


    public function approve_transfer($ticket_id)
    {
        // Get ticket details
        $this->db->where('id', $ticket_id);
        $ticket = $this->db->get('tickets_asset')->row();

        $current_user_id = $this->session->userdata('user_id');
        $is_super_admin = in_array($this->session->userdata('user_role'), [2, 3]);

        if ($ticket) {
            if ($is_super_admin && $ticket->transfer_approval_status == 'pending') {
                // Super admin approval - first step
                $data = array(
                    'status' => 'Approved by Admin',
                    'transfer_approval_status' => 'approved_by_admin',
                    'depart' => $ticket->depart_transfer
                );
                $message = 'Transfer approved by Super Admin - awaiting user confirmation';
                $action = 'Approved by Admin';
                $ticket_status = 'Approved by Admin';
            } elseif (!$is_super_admin && $ticket->transfer_approval_status == 'approved_by_admin') {
                // User acceptance - final step
                // Check if current user is in transfer_to list
                $transfer_to_users = explode(',', $ticket->transfer_to);
                if (!in_array($current_user_id, $transfer_to_users)) {
                    redirect('asset/track/' . $ticket_id);
                    return;
                }

                $data = array(
                    'status' => 'Asset Transfer',
                    'transfer_approval_status' => 'approved',
                    'depart' => $ticket->depart_transfer
                );
                $message = 'Transfer accepted by receiving user';
                $action = 'Asset Transferred';
                $ticket_status = 'Asset Transfer';

                // Update feedback asset record
                $this->db->where('id', $ticket_id);
                $this->db->update('bf_feedback_asset_creation', array(
                    'assignstatus' => 'Asset Transfer',
                    'depart' => $ticket->depart_transfer
                ));
            } else {
                // Invalid approval attempt
                redirect('asset/track/' . $ticket_id);
                return;
            }

            // Update ticket
            $this->db->where('id', $ticket_id);
            $this->db->update('tickets_asset', $data);

            // Log message
            $this->db->insert('asset_ticket_message', array(
                'reply' => $is_super_admin ? 'Approved by Admin' : 'Approved by User',
                'message' => $message,
                'action' => $action,
                'ticket_status' => $ticket_status,
                'created_by' => $current_user_id,
                'ticketid' => $ticket_id,
                'depart' => $ticket->depart_transfer
            ));
        }

        // Trigger email/API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
        curl_exec($curl);

        redirect('asset/track/' . $ticket_id);
    }

    // END SUPER ADMIN AND ADMIN LOGIN




    // DEPARTMENT HEAD LOGIN

    public function department_tickets()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        if (ismodule_active('ASSET') === true   && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) {





            $data['title'] = 'ASSET MANAGEMENT DASHBOARD';

            #------------------------------#

            $data['content'] = $this->load->view('assetmodules/department_tickets', $data, true);

            $this->load->view('layout/main_wrapper', $data);

            //used for department head login


        } else {

            redirect('dashboard/noaccess');
        }
    }

    // END DEPARTMENT HEAD LOGIN



    //START COMPLAINTSS 

    public function alltickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET MASTER';
            $dates = get_from_to_date();


            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->alltickets();

            // print_r($data['departments']);
            // exit;

            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/alltickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/alltickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_qrcode()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET QR CODE LIST';

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_qrcode();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_qrcode', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_qrcode', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_financial_metrices()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET FINANCIALS OVERVIEW';

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_financial_metrices();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_financial_metrices', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_financial_metrices', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_distribution_analysis()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET DISTRIBUTION ANALYSIS';

            #-------------------------------#
            // $data['departments'] = $this->ticketsasset_model->asset_distribution_analysis();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_distribution_analysis', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_distribution_analysis', $data, true);
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



        if (ismodule_active('ASSET') === true) {



            $data['title'] = 'PC- ADDRESSED COMPLAINTS';

            $data['departments'] = $this->ticketsasset_model->addressedtickets();

            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/addressedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/addressedtickets', $data, true);
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



        $data['title'] = 'ASSET DETAILS';

        // Fetch department data
        $data['departments'] = $this->ticketsasset_model->read_by_id($this->uri->segment(3));

        // Reverse the reply messages and calculate the 'Asset Repair' count
        $replyMessages = array_reverse($data['departments']->replymessage);
        $assetRepairCount = 0;
        foreach ($replyMessages as $r) {
            if ($r->ticket_status === 'Asset Repair') {
                $assetRepairCount++;
            }
        }

        // Add the count to data array to pass to the view
        $data['assetRepairCount'] = $assetRepairCount;

        if (isfeature_active('ASSET-DASHBOARD') === true) {
            $data['content'] = $this->load->view('assetmodules/ticket_track', $data, true);
        } else {
            $data['content'] = $this->load->view('assetmodules/dephead/ticket_track', $data, true);
        }
        $this->load->view('layout/main_wrapper', $data);
    }



    // open tickets

    public function asset_assign_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ALLOCATED ASSETS LIST';
            $dates = get_from_to_date();

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_assign_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_assign_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_assign_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_transfer_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'TRANSFERRED ASSETS LIST';
            $dates = get_from_to_date();

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_transfer_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_transfer_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_transfer_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_preventive_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'PREVENTIVE MAINTENANCE OVERVIEW';
            $dates = get_from_to_date();

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_preventive_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_preventive_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_preventive_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_calibration_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET CALIBRATION OVERVIEW';
            $dates = get_from_to_date();

            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_calibration_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_calibration_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_calibration_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_use_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'USED ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_use_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_use_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_use_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_warranty_reports()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET WARRANTY  OVERVIEW';


            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_warranty_reports();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_warranty_reports', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_warranty_reports', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }


    public function asset_contract_reports()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'ASSET AMC/ CMC  OVERVIEW';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_contract_reports();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_contract_reports', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_contract_reports', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }





    public function asset_unallocate_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'UNALLOCATED ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_unallocate_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_unallocate_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_unallocate_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }


    // open tickets

    public function asset_broken_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'BROKEN ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_broken_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_broken_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_broken_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }
    // open tickets

    public function asset_repair_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'MALFUNCTIONED ASSET LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_repair_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_repair_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_repair_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function asset_sold_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'SOLD ASSET LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_sold_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_sold_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_sold_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }
    // open tickets

    public function asset_reassign_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'REASSIGNED ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_reassign_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_reassign_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_reassign_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }
    // open tickets

    public function asset_lost_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'LOST ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_lost_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_lost_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_lost_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }
    // open tickets

    public function asset_dispose_tickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'DISPOSED ASSETS LIST';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->asset_dispose_tickets();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/asset_dispose_tickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/asset_dispose_tickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);
            $this->session->set_userdata('referred_from', NULL);
            // redirect('tickets/');

        } else {

            redirect('dashboard/noaccess');
        }
    }
    // open tickets

    public function opentickets()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');

        if (ismodule_active('ASSET') === true) {
            $data['title'] = 'PC- OPEN COMPLAINTS';
            #-------------------------------#
            $data['departments'] = $this->ticketsasset_model->read();
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/opentickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/opentickets', $data, true);
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

        if (ismodule_active('ASSET') === true) {







            $data['title'] = 'PC- CLOSED COMPLAINTS';

            $data['departments'] = $this->ticketsasset_model->read_close();

            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/closedtickets', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/closedtickets', $data, true);
            }
            $this->load->view('layout/main_wrapper', $data);

            // redirect('tickets/ticket_close');


        } else {

            redirect('dashboard/noaccess');
        }
    }

    //END COMPLAINTSS 



    //  REPORTS



    public function capa_report()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ASSET') === true) {


            $data['title'] = 'PC- CAPA REPORT';

            $data['departments'] = $this->ticketsasset_model->read_close();

            $data['content'] = $this->load->view('assetmodules/capa_report', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        } else {

            redirect('dashboard/noaccess');
        }
    }







    public function complaints()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ASSET') === true) {





            $data['title'] = 'PC- PATIENT' . "'" . 'S COMMENTS';

            $data['content'] = $this->load->view('assetmodules/recent_comments', $data, true);

            $this->load->view('layout/main_wrapper', $data);

            // redirect('report/int_recent_comments');


        } else {

            redirect('dashboard/noaccess');
        }
    }





    public function patient_complaint()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ASSET') === true) {



            $data['title'] = 'ASSET DETAILS';

            #------------------------------#
            if (isfeature_active('ASSET-DASHBOARD') === true) {
                $data['content'] = $this->load->view('assetmodules/patient_complaint', $data, true);
            } else {
                $data['content'] = $this->load->view('assetmodules/dephead/patient_complaint', $data, true);
            }



            $this->load->view('layout/main_wrapper', $data);

            // redirect('report/int_patient_feedback');


        } else {

            redirect('dashboard/noaccess');
        }
    }

    public function edit_asset()
    {
        if (!isset($this->session->userdata['isLogIn']) || ($this->session->userdata('isLogIn') === false)) {
            $this->session->set_userdata('referred_from', current_url());
        } else {
            $this->session->set_userdata('referred_from', NULL);
        }

        $data['title'] = 'EDIT ASSET DETAILS';
        $data['departments'] = $this->ticketsasset_model->read_by_id($this->uri->segment(3));

        if (isfeature_active('ASSET-DASHBOARD') === true) {
            $data['content'] = $this->load->view('assetmodules/edit_asset', $data, true);
        } else {
            $data['content'] = $this->load->view('assetmodules/dephead/edit_asset', $data, true);
        }

        $this->load->view('layout/main_wrapper', $data);
    }

    public function edit_asset_byid($id)
    {
        // Check if the form is submitted
        if ($this->input->post()) {

            $contractType = $this->input->post('contract');

            // $encodedImage = $this->input->post('image');

            // if (!empty($_FILES['new_asset_image']['tmp_name']) && is_uploaded_file($_FILES['new_asset_image']['tmp_name'])) {
            //     $tempFile = $_FILES['new_asset_image']['tmp_name'];
            //     $mimeType = mime_content_type($tempFile);

            //     // Only process if it's an image
            //     if (strpos($mimeType, 'image/') === 0) {
            //         $imageData = file_get_contents($tempFile);
            //         $encodedImage = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
            //     }
            // }


            // Capture and sanitize the values from the form input
            $data = array(
                'patientid' => $this->input->post('patientid'),
                'assetname' => $this->input->post('assetname'),
                'ward' => $this->input->post('ward'),
                'brand' => $this->input->post('brand'),
                'model' => $this->input->post('model'),
                'serial' => $this->input->post('serial'),

                'locationsite' => $this->input->post('locationsite'),
                'bedno' => $this->input->post('bedno'),
                'depart' => $this->input->post('depart'),
                'assignee' => $this->input->post('assigned'),

                'purchaseDate' => $this->input->post('purchaseDate'),
                'installDate' => $this->input->post('installDate'),

                'invoice' => $this->input->post('invoice'),
                'grn_no' => $this->input->post('grn_no'),

                'preventive_maintenance_date' => $this->input->post('preventive_maintenance_date'),
                'upcoming_preventive_maintenance_date' => $this->input->post('upcoming_preventive_maintenance_date'),
                'reminder_alert_1' => $this->input->post('reminder_alert_1'),
                'reminder_alert_2' => $this->input->post('reminder_alert_2'),

                'asset_calibration_date' => $this->input->post('asset_calibration_date'),
                'upcoming_calibration_date' => $this->input->post('upcoming_calibration_date'),
                'calibration_reminder_alert_1' => $this->input->post('calibration_reminder_alert_1'),
                'calibration_reminder_alert_2' => $this->input->post('calibration_reminder_alert_2'),

                'warrenty' => $this->input->post('warrenty'),
                'warrenty_end' => $this->input->post('warrenty_end'),

                'assetquantity' => $this->input->post('assetquantity'),
                'unitprice' => $this->input->post('unitprice'),
                'totalprice' => $this->input->post('totalprice'),
                'depreciation' => $this->input->post('depreciation'),
                'assetCurrentValue' => $this->input->post('assetCurrentValue'),

                'contract' => $contractType,

                'supplierinfo' => $this->input->post('supplierinfo'),
                'servicename' => $this->input->post('servicename'),
                'servicecon' => $this->input->post('servicecon'),
                'servicemail' => $this->input->post('servicemail'),


                'comment' => $this->input->post('dataAnalysis'),
                'dataset' => json_encode($_POST)
            );

            if ($contractType === 'AMC') {
                $data['contract_start_date'] = $this->input->post('amcStartDate');
                $data['contract_end_date'] = $this->input->post('amcEndDate');
                $data['contract_service_charges'] = $this->input->post('amcServiceCharges');
            } elseif ($contractType === 'CMC') {
                $data['contract_start_date'] = $this->input->post('cmcStartDate');
                $data['contract_end_date'] = $this->input->post('cmcEndDate');
                $data['contract_service_charges'] = $this->input->post('cmcServiceCharges');
            }

            // Update the data in the database
            $this->asset_model->update_bf_feedback_asset_creation($id, $data);

            // Redirect back to the edit_asset page after the update
            redirect('asset/edit_asset/' . $id);
        } else {
            // If the form was not submitted, redirect to the edit_asset page
            redirect('asset/edit_asset/' . $id);
        }
    }




    public function delete_asset($id)
    {

        $this->db->trans_start();

        // Delete the asset with the given ID
        $this->db->where('id', $id);
        $this->db->delete('bf_feedback_asset_creation');

        $this->db->where('id', $id);
        $this->db->delete('tickets_asset');

        $this->db->trans_complete();


        // After deleting, redirect to the 'alltickets' page
        redirect(base_url($this->uri->segment(1) . "/alltickets"));
    }





    public function dep_tat()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');



        $data['title'] = 'Manage Turn Around Time';

        #------------------------------#

        $data['content'] = $this->load->view('assetmodules/dep_tat', $data, true);

        $this->load->view('layout/main_wrapper', $data);

        // redirect('report/int_patient_feedback');



    }

    public function dep_tat_edit()
    {

        if (ismodule_active('ASSET') === true) {

            if ($_POST) {
                $close_time = $this->input->post('tat');
                $close_time_l1 = $close_time['close_time_l1'];
                $close_time_l2 = $close_time['close_time_l2'];

                foreach ($close_time_l1 as $key => $row) {
                    $data = array('close_time' => $close_time_l1[$key], 'close_time_l2' => $close_time_l2[$key]);
                    $this->db->where('dprt_id', $key);
                    $this->db->update('department', $data);
                }
            }


            $data['title'] = 'Manage Turn Around Time';

            #------------------------------#

            $data['content'] = $this->load->view('assetmodules/dep_tat_edit', $data, true);

            $this->load->view('layout/main_wrapper', $data);
        }
    }

    public function notifications()
    {

        if ($this->session->userdata('isLogIn') == false)

            redirect('login');

        if (ismodule_active('ASSET') === true) {



            $data['title'] = 'PC- COMPLAINT NOTIFICATIONS';

            $data['content'] = $this->load->view('assetmodules/recent_comments', $data, true);

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

        if (ismodule_active('ASSET') === true) {



            $table_feedback = 'bf_feedback_int';

            $table_patients = 'bf_patients';

            $desc = 'desc';

            $setup = 'setup_int';



            $feedbacktaken = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $desc);

            $sresult = $this->pc_model->setup_result($setup);

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

            $header[1] = 'Patient Name';

            $header[2] = 'Patient ID';

            $header[3] = 'Floor/Ward';

            $header[4] = 'Room/Bed';

            $header[5] = 'Mobile Number';

            $header[6] = 'Department';

            $header[7] = 'Concern';

            $header[8] = 'Comment';

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

                    $dataexport[$i]['Department'] = $setarray[$key];
                }

                foreach ($data['reason'] as $key => $value) {

                    if ($value) {

                        $dataexport[$i]['ticket'] = $question[$key];
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



            $fileName = 'EF- PC COMPLAINTS - ' . $tdate . ' to ' . $fdate . '.csv';

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

        if (ismodule_active('ASSET') === true) {


            $dataexport = array();

            $i = 0;

            $table_feedback = 'bf_feedback_int';

            $table_patients = 'bf_patients';

            $sorttime = 'asc';

            $setup = 'setup_int';

            $asc = 'asc';

            $desc = 'desc';

            $table_tickets = 'tickets_int';

            $open = 'Open';

            $closed = 'Closed';

            $addressed = 'Addressed';

            $type = 'interim';



            $int_feedbacks_count = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

            $ticket_resolution_rate = $this->pc_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);


            $int_tickets_count = $this->ticketsasset_model->alltickets();
            $int_open_tickets = $this->ticketsasset_model->read();
            $int_closed_tickets = $this->ticketsasset_model->read_close();
            $int_addressed_tickets = $this->ticketsasset_model->addressedtickets();

            $header = 'PC DEPARTMENT WISE COMPLAINTS REPORT';

            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];



            $dataexport[$i]['row1'] = 'COMPLAINTS REPORT';

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



            // $dataexport[$i]['row1'] = 'TOTAL FEEDBACKS SUBMITTED';

            // $dataexport[$i]['row2'] = count($int_feedbacks_count);

            //    $dataexport[$i]['row3'] = '';

            //  $dataexport[$i]['row4'] = '';

            //  $i++;



            $dataexport[$i]['row1'] = '';

            $dataexport[$i]['row2'] = '';

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;





            $dataexport[$i]['row1'] = 'TOTAL COMPLAINTS';

            $dataexport[$i]['row2'] = count($int_tickets_count);

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;



            $dataexport[$i]['row1'] = 'COMPLAINT RESOLUTION RATE';

            $dataexport[$i]['row2'] = $ticket_resolution_rate . '%';

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;



            $dataexport[$i]['row1'] = 'OPEN COMPLAINTS';

            $dataexport[$i]['row2'] = count($int_open_tickets);

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;


            if (ticket_addressal('pc_addressal') === true) {

                $dataexport[$i]['row1'] = 'ADDRESSED COMPLAINTS';

                $dataexport[$i]['row2'] = count($int_addressed_tickets);

                $dataexport[$i]['row3'] = '';

                $dataexport[$i]['row4'] = '';

                $i++;
            }


            $dataexport[$i]['row1'] = 'CLOSED COMPLAINTS';

            $dataexport[$i]['row2'] = count($int_closed_tickets);

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;



            $dataexport[$i]['row1'] = '';

            $dataexport[$i]['row2'] = '';

            $dataexport[$i]['row3'] = '';

            $dataexport[$i]['row4'] = '';

            $i++;





            $dataexport[$i]['row1'] = 'COMPLAINTS RECEIVED BY DEPARTMENT';

            $dataexport[$i]['row2'] = 'PERCENTAGE';

            $dataexport[$i]['row3'] = 'COUNT';

            $dataexport[$i]['row4'] = 'OPEN';
            if (ticket_addressal('pc_addressal') === true) {

                $dataexport[$i]['row5'] = 'ADDRESSED';
            }
            $dataexport[$i]['row6'] = 'CLOSED';

            $dataexport[$i]['row7'] = 'RESOLUTION RATE';

            $dataexport[$i]['row8'] = 'RESOLUTION TIME';
            $dataexport[$i]['row9'] = '';

            $i++;



            $ticket = $this->pc_model->tickets_recived_by_department_interim($type, $table_feedback, $table_tickets);



            foreach ($ticket as $ps) {
                // print_r($ticket);
                $time = secondsToTimeforreport($ps['res_time']);
                $dataexport[$i]['row1'] = $ps['department'];

                $dataexport[$i]['row2'] = $ps['percentage'] . '%';

                $dataexport[$i]['row3'] = $ps['total_count'];

                $dataexport[$i]['row4'] = $ps['open_tickets'];
                if (ticket_addressal('pc_addressal') === true) {

                    $dataexport[$i]['row5'] = $ps['addressed_tickets'];
                }
                $dataexport[$i]['row6'] = $ps['closed_tickets'];

                $dataexport[$i]['row7'] = $ps['tr_rate'] . '%';

                $dataexport[$i]['row8'] = $time;

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

            $fileName = 'EF- PC DEPARTMENT WISE COMPLAINTS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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

        if (ismodule_active('ASSET') === true) {


            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];

            redirect('pdfreport/pc_pdf_report?fdate=' . $tdate . '&tdate=' . $fdate);

            // redirect('report/ip_capa_report');


        } else {

            redirect('dashboard/noaccess');
        }
    }





    public function download_capa_report()
    {
        if (ismodule_active('ASSET') === true) {


            $fdate = $_SESSION['from_date'];

            $tdate = $_SESSION['to_date'];

            $this->db->select("*");

            $this->db->from('setup_int');

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

            $departments = $this->ticketsasset_model->read_close();



            $dataexport[$i]['row1'] = 'SL No.';

            $dataexport[$i]['row2'] = 'COMPLAINT ID';

            $dataexport[$i]['row3'] = 'CREATED ON';

            $dataexport[$i]['row4'] = 'PATIENT DETAILS';

            $dataexport[$i]['row5'] = 'CONCERN';

            $dataexport[$i]['row6'] = 'DEPARTMENT';

            $dataexport[$i]['row7'] = 'DEPARTMENT TAT';

            $dataexport[$i]['row8'] = 'ASSIGNEE';

            $dataexport[$i]['row9'] = 'RCA';

            $dataexport[$i]['row10'] = 'CAPA';

            $dataexport[$i]['row11'] = 'RESOLVED ON';

            $dataexport[$i]['row12'] = 'TIME TAKEN';

            $dataexport[$i]['row13'] = 'TAT STATUS';

            $i++;



            if (!empty($departments)) {

                $sl = 1;

                foreach ($departments as $department) {

                    if ($department->status == 'Closed') {

                        $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');

                        $query = $this->db->get('ticket_int_message');

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



                        $value2 = $this->pc_model->convertSecondsToTime($department->department->close_time);

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

                        $value = $this->pc_model->convertSecondsToTime($timeDifferenceInSeconds);

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

                        $dataexport[$i]['row2'] = 'PCT- ' . $department->id;

                        $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));

                        $dataexport[$i]['row4'] = $department->feed->name . '(' . $department->feed->patientid . ')';

                        $dataexport[$i]['row5'] = $issue;

                        $dataexport[$i]['row6'] = $department->department->description;

                        $dataexport[$i]['row7'] = $dep_tat;

                        $dataexport[$i]['row8'] = $department->department->pname;

                        $dataexport[$i]['row9'] = $root;

                        $dataexport[$i]['row10'] = $corrective;

                        $dataexport[$i]['row11'] = date('g:i a, d-m-y', strtotime($department->last_modified));

                        $dataexport[$i]['row12'] = $timetaken;

                        $dataexport[$i]['row13'] = $close;

                        $i++;

                        $sl++;
                    }
                }
            }



            ob_end_clean();

            $fileName = 'EF- PC CAPA REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $this->db->where_not_in('assignstatus', ['Asset Lost', 'Asset Dispose', 'Asset Sold']);
            $query = $this->db->get();
            $departments = $query->result();


            $this->db->select('title, bed_no, method');
            $this->db->from('bf_departmentasset');
            $wardRows = $this->db->get()->result();

            $wardMap = [];
            foreach ($wardRows as $row) {
                $wardKey = trim($row->title);
                $wardMap[$wardKey] = [
                    'rate' => floatval($row->bed_no),
                    'method' => strtoupper(trim($row->method)),
                ];
            }

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'PRIMARY ASSET NAME',
                'ASSET GROUP',
                'ASSET BRAND',
                'ASSET MODEL',
                'ASSET SERIAL NO',
                'BASE ASSET LOCATION',
                'BASE ASSET SITE',
                'CURRENT ASSET LOCATION',
                'CURRENT ASSET SITE',
                'ASSET DEPARTMENT',
                'ASSET USER',
                'PURCHASE DATE',
                'PURCHASE ORDER NO',
                'INVOICE NO',
                'GRN NO',
                'INSTALLATION DATE',
                'WARRANTY START DATE',
                'WARRANTY END DATE',
                'ASSET QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'DEPRECIATION RATE(%)',
                'CURRENT ASSET VALUE',
                'VALUATION DATE',
                'ASSET VALUE- FY 24-25',
                'ASSET VALUE- FY 23-24',
                'CONTRACT TYPE',
                'CONTRACT START DATE',
                'CONTRACT END DATE',
                'CONTRACT SERVICE CHARGES',
                'SUPPLIER INFO',
                'ADDITIONAL NOTES',

            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    // echo '<pre>';
                    // print_r($departments);
                    // echo '</pre>';
                    // exit;


                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;



                    $dataexport[$i]['row4'] = $department->ward;

                    $dataexport[$i]['row5'] = $department->brand;
                    $dataexport[$i]['row6'] = $department->model;
                    $dataexport[$i]['row7'] = $department->serial;

                    $dataexport[$i]['row8'] = $department->locationsite;
                    $dataexport[$i]['row9'] = $department->bedno;

                    $dataexport[$i]['row10'] = $department->locationsite;
                    $dataexport[$i]['row11'] = $department->bedno;



                    $dataexport[$i]['row12'] = $department->depart;
                    $dataexport[$i]['row13'] = $department->assignee;



                    $dataexport[$i]['row14'] = date('d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row15'] = $department->porder;

                    $dataexport[$i]['row16'] = $department->invoice;
                    $dataexport[$i]['row17'] = $department->grn_no;

                    $dataexport[$i]['row18'] = date('d-m-y', strtotime($department->installDate));

                    $dataexport[$i]['row19'] = date('d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row20'] = date('d-m-y', strtotime($department->warrenty_end));


                    $dataexport[$i]['row21'] = $department->assetquantity;
                    $dataexport[$i]['row22'] = $department->unitprice;
                    $dataexport[$i]['row23'] = $department->totalprice;

                    $dataexport[$i]['row24'] = $department->depreciation;



                    $fyDecoded = json_decode($department->fyValues, true);

                    $dataexport[$i]['row25'] = $fyDecoded['FY 25-26'] ?? 'N/A';

                    $dataexport[$i]['row26'] = date('d-m-y');

                    $dataexport[$i]['row27'] = $fyDecoded['FY 24-25'] ?? 'N/A';
                    $dataexport[$i]['row28'] = $fyDecoded['FY 23-24'] ?? 'N/A';






                    $dataexport[$i]['row29'] = !empty($department->contract) ? $department->contract : 'N/A';

                    $dataexport[$i]['row30'] = !empty($department->contract_start_date) ? date('d-m-y', strtotime($department->contract_start_date)) : 'N/A';

                    $dataexport[$i]['row31'] = !empty($department->contract_end_date) ? date('d-m-y', strtotime($department->contract_end_date)) : 'N/A';

                    $dataexport[$i]['row32'] = !empty($department->contract_service_charges) ? $department->contract_service_charges : 'N/A';


                    $dataexport[$i]['row33'] =
                        (!empty($department->supplierinfo) ? "Supplier Name: " . $department->supplierinfo : 'N/A') . ", " .
                        (!empty($department->servicename) ? "Service Person Name: " . $department->servicename : 'N/A') . ", " .
                        (!empty($department->servicecon) ? "Service Person Contact: " . $department->servicecon : 'N/A') . ", " .
                        (!empty($department->servicemail) ? "Service Person Email: " . $department->servicemail : 'N/A');



                    $dataexport[$i]['row34'] = $department->comment;


                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_assign_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL ALLOCATED ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_broken_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL BROKEN ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_sold_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL SOLD ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_repair_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL LOST ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_lost_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL LOST ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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

    public function download_asset_dispose_tickets()
    {
        if (ismodule_active('ASSET') === true) {

            $fdate = $_SESSION['from_date'];
            $tdate = $_SESSION['to_date'];

            // Fetch data from bf_feedback_asset_creation
            $this->db->select("*");
            $this->db->from('bf_feedback_asset_creation');
            $query = $this->db->get();
            $departments = $query->result();

            // Define CSV headers
            $header = [
                'SL NO.',
                'ASSET CODE',
                'ASSET NAME',
                'ASSET AREA',
                'ASSET SITE',
                'ASSET GROUP',
                'PURCHASE DATE',
                'EXPIRE DATE',
                'QUANTITY',
                'UNIT PRICE',
                'TOTAL PRICE',
                'COMMENTS',
                'SUPPLIER INFO',
                'STATUS'
            ];

            // Initialize data for CSV export
            $dataexport = [];
            $i = 0;

            if (!empty($departments)) {
                $sl = 1;
                foreach ($departments as $department) {

                    $dataexport[$i]['row1'] = $sl;
                    $dataexport[$i]['row2'] = 'ASSET- ' . $department->patientid;
                    $dataexport[$i]['row3'] = $department->assetname;
                    $dataexport[$i]['row4'] = $department->locationsite;
                    $dataexport[$i]['row5'] = $department->bedno;
                    $dataexport[$i]['row6'] = $department->ward;
                    $dataexport[$i]['row7'] = date('g:i a, d-m-y', strtotime($department->purchaseDate));
                    $dataexport[$i]['row8'] = date('g:i a, d-m-y', strtotime($department->warrenty));
                    $dataexport[$i]['row9'] = $department->assetquantity;
                    $dataexport[$i]['row10'] = $department->unitprice;
                    $dataexport[$i]['row11'] = $department->totalprice;
                    $dataexport[$i]['row12'] = $department->comment;

                    $dataexport[$i]['row13'] = $department->supplierinfo;
                    $dataexport[$i]['row14'] = $department->assignstatus;

                    $i++;
                    $sl++;
                }
            }

            // Output CSV
            ob_end_clean();

            $fileName = 'EF- ALL DISPOSED ASSET REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (!empty($dataexport)) {
                $fp = fopen('php://output', 'w');

                // Add header to CSV
                fputcsv($fp, $header, ',');

                // Add rows to CSV
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





    public function download_opentickets()
    {
        if (ismodule_active('ASSET') === true) {



            $departments = $this->ticketsasset_model->alltickets();
            if (!empty($departments)) {

                $fdate = $_SESSION['from_date'];
                $tdate = $_SESSION['to_date'];
                $this->db->select("*");
                $this->db->from('setup_int');
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
                $dataexport[$i]['row2'] = 'COMPLAINT ID';
                $dataexport[$i]['row3'] = 'CREATED ON';
                $dataexport[$i]['row4'] = 'PATIENT NAME';
                $dataexport[$i]['row5'] = 'PATIENT ID';
                $dataexport[$i]['row6'] = 'PHONE NUMBER';
                $dataexport[$i]['row7'] = 'FLOOR/WARD';
                $dataexport[$i]['row8'] = 'BED NUMBER';
                $dataexport[$i]['row9'] = 'CONCERN';
                $dataexport[$i]['row10'] = 'DEPARTMENT';
                $dataexport[$i]['row11'] = 'COMMENTS';
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
                                $dataexport[$i]['row2'] = 'PC- ' . $department->id;
                                $dataexport[$i]['row3'] = date('g:i a, d-m-y', strtotime($department->created_on));
                                $dataexport[$i]['row4'] = $department->feed->name;
                                $dataexport[$i]['row5'] = $department->feed->patientid;
                                $dataexport[$i]['row6'] = $department->feed->contactnumber;
                                $dataexport[$i]['row7'] = $department->feed->ward;
                                $dataexport[$i]['row8'] = $department->feed->bedno;
                                $dataexport[$i]['row9'] = $issue;
                                $dataexport[$i]['row10'] = $department->department->description;

                                foreach ($department->feed->comment as $key => $value) {

                                    if ($value) {

                                        $dataexport[$i]['row11'] = $value;
                                    }
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

            $fileName = 'EF- PC OPEN COMPLAINTS REPORT - ' . $tdate . ' to ' . $fdate . '.csv';

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
        if (ismodule_active('ASSET') === true) {

            $data['title'] = 'PC- COMPLAINT RESOLUTION RATE';
            #------------------------------#
            $data['content'] = $this->load->view('assetmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }


    public function average_resolution_time()
    {
        if ($this->session->userdata('isLogIn') == false)
            redirect('login');
        if (ismodule_active('ASSET') === true) {

            $data['title'] = 'PC- AVERAGE RESOLUTION TIME';
            #------------------------------#
            $data['content'] = $this->load->view('assetmodules/ticket_analisys_page', $data, true);
            $this->load->view('layout/main_wrapper', $data);
        } else {
            redirect('dashboard/noaccess');
        }
    }
}
