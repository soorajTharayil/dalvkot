<div class="content">
<div class="row">





    <?php



    echo '<h4>PATIENT TABLES </h4>';



    if ($this->db->table_exists('bf_patients')) {

        echo 'IP Patient table exists';

        echo '<br>';

    } else {

        echo 'IP Patient to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('bf_opatients')) {

        echo 'OP Patient table exists';

        echo '<br>';

    } else {

        echo 'OP Patient to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('patients_from_admission')) {

        echo 'Patient from admission table exists';

        echo '<br>';

    } else {

        echo 'Patient from admission to be added';

        echo '<br>';

    }



    echo '----------------------------------------------------------------';



    echo '<br>';

    echo '<h4>QUESTIONS TABLES </h4>';

    if ($this->db->table_exists('setup_adf')) {

        echo 'Admission Questions table exists';

        echo '<br>';

    } else {

        echo 'Admission Questions to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('setup')) {

        echo 'IP Questions table exists';

        echo '<br>';

    } else {

        echo 'IP Questions to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('setupop')) {

        echo 'OP Questions table exists';

        echo '<br>';

    } else {

        echo 'OP Questions to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('setup_int')) {

        echo 'INT Questions table exists';

        echo '<br>';

    } else {

        echo 'INT Questions to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('setup_incident')) {

        echo 'Incident Questions table exists';

        echo '<br>';

    } else {

        echo 'Incident Questions to be added';

        echo '<br>';

    }



    echo '----------------------------------------------------------------';



    echo '<br>';



    echo '<h4>FEEDBACK TABLES </h4>';

    if ($this->db->table_exists('bf_feedback_adf')) {

        echo 'Admission feedback table exists';

        echo '<br>';

    } else {

        echo 'Admission feedback to be added';

        echo '<br>';

    }


    if ($this->db->table_exists('bf_feedback')) {

        echo 'IP feedback table exists';

        echo '<br>';

    } else {

        echo 'IP feedback to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('bf_outfeedback')) {

        echo 'OP feedback table exists';

        echo '<br>';

    } else {

        echo 'OP feedback to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('bf_feedback_int')) {

        echo 'INT feedback table exists';

        echo '<br>';

    } else {

        echo 'INT feedback to be added';

        echo '<br>';

    }

    echo '----------------------------------------------------------------';

    echo '<br>';





    echo '<h4>TICKET TABLES </h4>';


    if ($this->db->table_exists('tickets_adf')) {

        echo 'ADF Tickets table exists';

        echo '<br>';

    } else {

        echo 'ADF Tickets to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('tickets')) {

        echo 'IP Tickets table exists';

        echo '<br>';

    } else {

        echo 'IP Tickets to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('ticketsop')) {

        echo 'OP Tickets table exists';

        echo '<br>';

    } else {

        echo 'OP Tickets to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('tickets_int')) {

        echo 'INT Tickets table exists';

        echo '<br>';

    } else {

        echo 'INT Tickets to be added';

        echo '<br>';

    }


    if ($this->db->table_exists('tickets_incident')) {

        echo 'incident Tickets table exists';

        echo '<br>';

    } else {

        echo 'incident Tickets to be added';

        echo '<br>';

    }

    echo '----------------------------------------------------------------';



    echo '<br>';





    echo '<h4>CAPA TABLES </h4>';




    if ($this->db->table_exists('ticket_message_adf')) {

        echo 'ADF CAPA table exists';

        echo '<br>';

    } else {

        echo 'ADF CAPA to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('ticket_message')) {

        echo 'IP CAPA table exists';

        echo '<br>';

    } else {

        echo 'IP CAPA to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('ticketop_message')) {

        echo 'OP CAPA table exists';

        echo '<br>';

    } else {

        echo 'OP CAPA to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('ticket_int_message')) {

        echo 'INT CAPA table exists';

        echo '<br>';

    } else {

        echo 'INT CAPA to be added';

        echo '<br>';

    }
    


    if ($this->db->table_exists('ticket_incident_message')) {

        echo 'incident CAPA table exists';

        echo '<br>';

    } else {

        echo 'incident CAPA to be added';

        echo '<br>';

    }

    echo '----------------------------------------------------------------';

    echo '<br>';



    echo '<h4>DEPARTMENNT </h4>';



    $adf = 'adf';
    $interm = 'interim';

    $inpatient = 'inpatient';

    $outpatient = 'outpatient';

    $esr = 'esr';

    $incident = 'incident';



    if ($this->db->table_exists('department')) {

        echo 'Department table exists';

        echo '<br>';

        $this->db->select('*');

        $this->db->where('type', $adf);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has adf';

        } else {

            echo 'ADD adf to Department table';

        }

        echo '<br>';


        $this->db->select('*');

        $this->db->where('type', $inpatient);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has IP';

        } else {

            echo 'ADD IP to Department table';

        }

        echo '<br>';



        $this->db->select('*');

        $this->db->where('type', $outpatient);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has OP';

        } else {

            echo 'ADD OP to Department table';

        }

        echo '<br>';



        $this->db->select('*');

        $this->db->where('type', $interm);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has INT';

        } else {

            echo 'ADD INT to Department table';

        }

        echo '<br>';


        $this->db->select('*');

        $this->db->where('type', $incident);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has Incident';

        } else {

            echo 'ADD Incident to Department table';

        }

        echo '<br>';

        $this->db->select('*');

        $this->db->where('type', $esr);

        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {

            echo 'Department table has ESR';

        } else {

            echo 'ADD ESR to Department table';

        }

        echo '<br>';

    } else {

        echo 'Department to be added';

        echo '<br>';

    }













    echo '----------------------------------------------------------------';

    echo '<br>';



    echo '<h4>ESCALATION </h4>';

    if ($this->db->table_exists('escalation')) {

        echo 'Escalation table exists';

        echo '<br>';

    } else {

        echo 'Escalation to be added';

        echo '<br>';

    }

    echo '----------------------------------------------------------------';

    echo '<br>';



    echo '<h4>ESR  </h4>';

    if ($this->db->table_exists('bf_employees_esr')) {

        echo 'Employee ESR table exists';

        echo '<br>';

    } else {

        echo 'Employee ESR to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('healthcare_employees')) {

        echo 'Healthcare Employee table exists';

        echo '<br>';

    } else {

        echo 'Healthcare Employee to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('setup_esr')) {

        echo 'ESR Questions table exists';

        echo '<br>';

    } else {

        echo 'ESR Questions to be added';

        echo '<br>';

    }

    if ($this->db->table_exists('tickets_esr')) {

        echo 'ESR Tickets table exists';

        echo '<br>';

    } else {

        echo 'ESR Tickets to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('ticket_esr_message')) {

        echo 'ESR CAPA table exists';

        echo '<br>';

    } else {

        echo 'ESR CAPA to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('bf_roles')) {

        echo 'Employee Roles table exists';

        echo '<br>';

    } else {

        echo 'Employee Roles to be added';

        echo '<br>';

    }



    if ($this->db->table_exists('bf_ward_esr')) {

        echo 'ESR Wards table exists';

        echo '<br>';

    } else {

        echo 'ESR Wards to be added';

        echo '<br>';

    }



    ?>

</div>
</div>