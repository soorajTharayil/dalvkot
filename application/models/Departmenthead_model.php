<?php defined('BASEPATH') or exit('No direct script access allowed');
class Departmenthead_model extends CI_Model
{


    public function patient_and_feedback($table_patient, $table_feedback, $sorttime)

    {

        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));

        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));



        $this->db->select($table_feedback . '.*');

        $this->db->from($table_feedback);





        $this->db->join($table_patient, $table_patient . '.id = ' . $table_feedback . '.pid', 'inner');

        if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {

            $this->db->where($table_feedback . '.ward', $_SESSION['ward']);
        }



        $this->db->where($table_feedback . '.datet <=', $fdate);

        $this->db->where($table_feedback . '.datet >=', $tdate);

        $this->db->order_by('datetime', $sorttime);

        $query = $this->db->get();

        return $patientandfeedback  = $query->result();
    }



    public function get_tickets($table_feedback, $table_tickets)
    {
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));

        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

        $this->db->select($table_tickets . ".*");

        $this->db->from($table_feedback);

        $this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');

        if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {

            $this->db->where($table_feedback . '.ward', $_SESSION['ward']);
        }


        $this->db->where($table_feedback . '.datet <=', $fdate);

        $this->db->where($table_feedback . '.datet >=', $tdate);

        $query = $this->db->get();

        return $feedbackandticket = $query->result();
    }



    public function departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type)
    {
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));

        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        $email = $this->session->userdata['email'];
        $feedback_data = $this->patient_and_feedback($table_patients, $table_feedback, $sorttime);
        $this->db->select($table_tickets . '.*,' . $table_feedback . '.dataset as dataset');
        $this->db->from($table_tickets);
        $this->db->join($table_feedback,  $table_feedback . '.id = ' . $table_tickets . '.feedbackid', 'inner');
        $this->db->join($department, $department . '.dprt_id = ' . $table_tickets . '.departmentid', 'inner');
        $this->db->join($setup, $setup . '.shortkey = ' . $department . '.slug');
        if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {

            $this->db->where($table_feedback . '.ward', $_SESSION['ward']);
        }

        $this->db->where($table_feedback . '.datet <=', $fdate);

        $this->db->where($table_feedback . '.datet >=', $tdate);
        // $this->db->where($setup . '.parent', 1);
        $this->db->where($department . '.email', $email);
        $this->db->where($department . '.type', $type);
        $query = $this->db->get();
        $tickets_all = $query->result();
        $opentickets = 0;
        $addressedtickets = 0;
        $closedticket = 0;
        foreach ($tickets_all as $r) {
            if ($r->status == 'Closed') {
                $closedticket++;
            } elseif ($r->status == 'Addressed') {
                $addressedtickets++;
            } else {
                $opentickets++;
            }
        }
        $c1['alltickets'] = count($tickets_all);
        $c1['closedticket'] = $closedticket;
        $c1['addressedtickets'] = $addressedtickets;
        $c1['opentickets'] = $opentickets;
        return $c1;
    }
}