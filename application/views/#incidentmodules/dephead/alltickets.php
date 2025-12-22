<!-- admin -->
<div class="content">

    <?php
    // individual patient feedback link
    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
    $this->db->select("*");
    $this->db->from('setup_incident');
    //$this->db->where('parent', 0);
    $query = $this->db->get();
    $reasons  = $query->result();
    foreach ($reasons as $row) {
        $keys[$row->shortkey] = $row->shortkey;
        $res[$row->shortkey] = $row->shortname;
        $titles[$row->shortkey] = $row->title;
    }

    if (count($departments)) {

    ?>

        <div class="row">

            <!--  table area -->
            <div class="col-lg-12">
                <div class="panel panel-default ">
                    <div class="panel-heading" style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('inc', 'inc_download_all_incident_report'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
                                <i class="fa fa-file-text"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
                            <form>
                                <p>
                                    <!-- <span style="font-size:15px; font-weight:bold;"><?php echo lang_loader('inc', 'inc_sort_incident_by'); ?></span> -->
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected><?php echo lang_loader('inc', 'inc_select_category'); ?></option>
                                        <?php
                                        $this->db->group_by('description');
                                        $this->db->where('type', 'incident');
                                        $query = $this->db->get('department');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec') == $row->description) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->description); ?>" selected><?php echo $row->description; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->description); ?>"><?php echo $row->description; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                    <?php if (isset($_GET['depsec'])) { ?>
                                        <span style="font-size:15px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <select name="dep" class="form-control" onchange="gotonextdepartment(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                            <option value="1" selected><?php echo lang_loader('inc', 'inc_select_incident'); ?></option>
                                            <?php
                                            $this->db->where('type', 'incident');
                                            $this->db->where('description', $this->input->get('depsec'));
                                            $query = $this->db->get('department');
                                            $result = $query->result();
                                            foreach ($result as $row) {
                                            ?>
                                                <?php if ($this->input->get('type') == $row->dprt_id) { ?>
                                                    <option value="<?php echo $row->dprt_id; ?>" selected><?php echo $row->name; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row->dprt_id; ?>"><?php echo $row->name; ?></option>
                                                <?php } ?>

                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_severity(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Select Severity</option>
                                        <?php
                                        $this->db->order_by('title');

                                        $query = $this->db->get('incident_type');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec_severity') == $row->title) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_priority(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Select Priority</option>
                                        <?php
                                        $this->db->order_by('title');
                                        $query = $this->db->get('priority');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec_priority') == $row->title) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                </p>
                            </form>
                            <br />
                        <?php } ?>

                        <table class="incticketsall table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo lang_loader('inc', 'inc_slno'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incidents_id'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident'); ?></th>
                                    <th style="white-space: nowrap;">Incident<br>Severity</th>
                                    <th style="white-space: nowrap;">Incident<br>Priority</th>


                                    <th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_reported_on'); ?></th>
                                    <!-- <th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_modified_on'); ?></th> -->
                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                        <th style="text-align: center;"><?php echo lang_loader('inc', 'inc_status'); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($departments)) {        ?>
                                    <?php $sl = 1; ?>
                                    <?php foreach ($departments as $department) {
                                        if ($department->status == 'Addressed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
                                            $query = $this->db->get('ticket_incident_message');
                                            $ticket = $query->result();
                                            $addressed_comm = $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . '  addressed the ticket with , ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Transfered') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
                                            $query = $this->db->get('ticket_incident_message');
                                            $ticket = $query->result();
                                            $trans_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Reopen') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
                                            $query = $this->db->get('ticket_incident_message');
                                            $ticket = $query->result();
                                            $reopen_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Closed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
                                            $query = $this->db->get('ticket_incident_message');
                                            $ticket = $query->result();

                                            $rowmessage = $ticket[0]->message . ' Closed the ticket,  Root Cause: ' . $ticket[0]->rootcause . '. CAPA: ' . $ticket[0]->corrective . '  ';
                                        } else {
                                            $rowmessage = 'THIS TICKET IS OPEN';
                                        }
                                        if (strlen($rowmessage) > 60) {
                                            $rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
                                        }

                                    ?>
                                        <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">
                                            <td><?php echo $sl; ?></td>
                                            <td><a href="<?php echo $ip_link_patient_feedback . $department->id; ?>"><?php echo lang_loader('inc', 'inc_inc'); ?><?php echo $department->id; ?></a></td>

                                            <td style="overflow: clip; word-break: break-all;">


                                                <?php if (!empty($department->feed->patientid)) : ?>
                                                    <?php echo $department->feed->name; ?>
                                                    &nbsp;(
                                                    <?php echo $department->feed->patientid; ?>
                                                    </a>)
                                                <?php else : ?>

                                                    <?php echo $department->feed->name; ?>

                                                <?php endif; ?>

                                                <!-- <br>
                                                <?php echo $department->feed->role; ?> -->
                                                <br>
                                                <?php echo $department->feed->ward; ?>
                                                <?php if ($department->feed->bedno) { ?>
                                                    <?php echo 'in ' . $department->feed->bedno; ?>
                                                <?php } ?>
                                                <br>
                                                <?php
                                                echo "<i class='fa fa-phone'></i> ";
                                                echo $department->feed->contactnumber; ?>
                                                <?php if ($department->feed->email) { ?>
                                                    <br>
                                                    <?php echo "<i class='fa fa-envelope'></i> "; ?>
                                                    <?php echo $department->feed->email; ?>
                                                <?php } ?>
                                            </td>

                                            <td style="overflow: clip; word-break: break-all;">

                                                <?php
                                                if ($department->departmentid_trasfered != 0) {
                                                    $show = false;
                                                    if ($department->status == 'Addressed') {
                                                        echo 'Ticket was transferred';
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Transfered') {
                                                        echo $trans_comm;
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Reopen') {
                                                        echo $reopen_comm;
                                                        $show = true;
                                                    }

                                                    if ($show == false && $department->status == 'Closed') {
                                                        echo 'Ticket was transferred';
                                                    }
                                                } else {

                                                    foreach ($department->feed->reason as $key => $value) {


                                                        if ($key) {
                                                            if ($titles[$key] == $department->department->description) {
                                                                if (in_array($key, $keys)) {
                                                                    echo $res[$key];
                                                                    echo '<br>';
                                                                    echo '<strong>' . $department->department->description . '</strong>';
                                                                    $show = $res[$key];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                // print_r($show);
                                                ?>
                                            </td>
                                            <td style="overflow: clip; word-break: break-all; white-space: nowrap;">
                                                <span><?php echo $department->feed->incident_type; ?></span>
                                                <?php if (!empty($department->feed->patientid)) { ?>
                                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-SEVERITY-INCIDENTS') === true) { ?>
                                                        <a href="<?php echo $ip_link_patient_feedback . $department->feed->patientid; ?>" title="Edit" style="margin-left: 5px;">
                                                            <i style="font-size: 20px; color: green; vertical-align: middle; position: relative; top: 1px;" class="fa fa-edit" data-toggle="tooltip" data-placement="bottom"></i>
                                                        </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>


                                            <td style="overflow: clip; word-break: break-all; white-space: nowrap;">
                                                <span><?php echo $department->feed->priority; ?></span>
                                                <?php if (!empty($department->feed->patientid)) { ?>
                                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-PRIORITY-INCIDENTS') === true) { ?>
                                                        <a href="<?php echo $ip_link_patient_feedback . $department->feed->patientid; ?>" title="Edit" style="margin-left: 5px;">
                                                            <i style="font-size: 20px; color: green; vertical-align: middle; position: relative; top: 1px;" class="fa fa-edit" data-toggle="tooltip" data-placement="bottom"></i>
                                                        </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>

                                            <td style="overflow: clip; word-break: break-all;">
                                                <?php echo date('g:i A', strtotime($department->created_on)); ?>
                                                <br>
                                                <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                            </td>

                                            <!-- <td style="overflow: clip; word-break: break-all;">
                                                <?php echo date('g:i A', strtotime($department->last_modified)); ?>
                                                <br>
                                                <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                            </td> -->
                                            <?php
                                            // Set default values for $tool and $color
                                            $tool = '';
                                            $color = 'btn-info'; // Default to a Bootstrap class if status doesn't match
                                            $tooldelete = 'Click to delete the incident.';
                                            // Determine the tooltip and color based on the department status
                                            if ($department->status == 'Addressed') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-warning';
                                            } elseif ($department->status == 'Open') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-danger';
                                                $status_icon = 'fa fa-envelope-open-o';
                                            } elseif ($department->status == 'Rejected') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-yellow'; // Changed color to btn-yellow for Rejected
                                                $status_icon = 'fa fa-reply';
                                            } elseif ($department->status == 'Closed') {
                                                $tool = 'Ticket is closed';
                                                $color = 'btn-success';
                                                $status_icon = 'fa fa-check-circle';
                                            } elseif ($department->status == 'Reopen') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-primary';
                                            } elseif ($department->status == 'Transfered') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-info';
                                            } elseif ($department->status == 'Assigned') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-orange'; // Added this condition for Assigned
                                                $status_icon = 'fa fa-hand-paper-o';
                                            } elseif ($department->status == 'Re-assigned') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-bluee'; // Added this condition for Assigned
                                                $status_icon = '';
                                            } elseif ($department->status == 'Described') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-reddd'; // Added this condition for Assigned
                                                $status_icon = '';
                                            } else {
                                                $tool = 'Unknown status';
                                                $color = 'btn-info';
                                            }
                                            ?>

                                            <?php if (ismodule_active('INCIDENT') === true && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                                <td style="vertical-align: middle; padding: 5px;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; width: 100%;">
                                                        <!-- 1st Button (Status) -->
                                                        <?php if ($department->status != 'Verified') { ?>
                                                            <a style="font-size: 17px; width: 120px;" href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $tool; ?>" class="btn btn-sm btn-block <?php echo $color; ?>">
                                                                <?php echo $department->status; ?> <i style="font-size:15px;margin-left:5px;" class="<?php echo $status_icon; ?>"></i>
                                                            </a>
                                                        <?php } else { ?>
                                                            <!-- Keep an empty placeholder for alignment -->
                                                            <div style="width: 120px;"></div>
                                                        <?php } ?>

                                                        <!-- 2nd Button (Verified Icon) -->
                                                        <?php if (isfeature_active('IN-VERIFY-INCIDENTS') === true && $department->status == 'Closed' && $department->verified_status == 1) { ?>
                                                            <i style="font-size: 25px; color: green;" class="fa fa-check-circle-o" data-toggle="tooltip" data-placement="bottom" title="Incident is verified"></i>
                                                        <?php } else { ?>
                                                            <!-- Placeholder for alignment -->
                                                            <div style="width: 25px;"></div>
                                                        <?php } ?>

                                                        <!-- 3rd Button (Delete Icon) -->
                                                        <?php if (isfeature_active('IN-DELETE-INCIDENTS') === true) { ?>
                                                            <?php echo form_open('ticketsincident/create', ['class' => 'form-inner', 'id' => 'deleteForm']) ?>
                                                            <input type="hidden" name="status" value="Delete" id="status">
                                                            <input type="hidden" name="id" value="<?php echo $department->id; ?>"> <!-- Assuming you have a ticket ID -->
                                                            <a style="font-size: 14px; width: 50px;" href="#" onclick="submitDeleteForm(event);" data-placement="bottom" data-toggle="tooltip" title="<?php echo $tooldelete; ?>" class="btn btn-sm btn-block btn-danger">
                                                                <i style="font-size: 15px;" class="fa fa-trash"></i>
                                                            </a>
                                                            <?php echo form_close(); ?>
                                                        <?php } ?>
                                                    </div>
                                                </td>


                                            <?php } ?>
                                        </tr>
                                        <?php $sl++; ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table> <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    <?php } else {   ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('inc', 'inc_no_record_found'); ?>

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
<style>
    .btn-orange {
        background-color: #f09a22;
        color: white;
        font-size: 14px;
    }

    .btn-bluee {
        background-color: #2a73e8;
        color: white;
        font-size: 14px;
    }

    .btn-reddd {
        background-color: #3f1670;
        color: white;
        font-size: 14px;
    }

    .btn-yellow {
        background-color: #FFDE4D;
        color: white;
        font-size: 14px;
    }
</style>
<script>
    function gotonextdepartment(type) {
        var subsecid = $('#subsecid').val();
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?type=") ?>" + type + "&depsec=" + subsecid;
        window.location.href = url;
    }

    function gotonextdepartment2(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec=") ?>" + type;
        window.location.href = url;
    }


    function gotonextdepartment_severity(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec_severity=") ?>" + type;
        window.location.href = url;
    }

    function gotonextdepartment_priority(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec_priority=") ?>" + type;
        window.location.href = url;
    }
</script>
<script>
    function submitDeleteForm(event) {
        event.preventDefault(); // Prevent default anchor behavior

        // Show confirmation alert
        const confirmDelete = confirm("This incident will be permanently deleted from the application. Are you sure you want to proceed?");

        if (confirmDelete) {
            document.getElementById('deleteForm').submit(); // Submit the form if confirmed
        }
    }
</script>