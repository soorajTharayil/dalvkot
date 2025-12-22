<!-- admin -->
<div class="content">
    <?php
    $this->db->from('tickets_incident');
    $this->db->group_start();
    $this->db->where('priority IS NULL', NULL, FALSE);
    $this->db->or_where('priority', '');
    $this->db->or_where('priority', 'unassigned');
    $this->db->group_end();

    $count_priority = $this->db->count_all_results();

    ?>

    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('TOTAL-INCIDENTS') === true) { ?>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div class="panel panel-bd">
                <div class="panel-body" style="height: 100px;">
                    <div class="statistic-box">
                        <h2><span class="count-number"><?php echo $count_priority; ?></span> <span
                                class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
                        <div class="small">No. of incidents in risk <a
                                href="javascript:void()" data-toggle="tooltip"
                                title="<?php echo $totaltickect_tooltip; ?>"><i class="fa fa-info-circle"
                                    aria-hidden="true"></i></i></a></div>
                        <div class="icon">
                            <i class="fa fa-ticket"></i>
                        </div>
                        <!-- <a href="<?php echo $int_link_alltickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a> -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('OPEN-INCIDENTS') === true) { ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div class="panel panel-bd">
                <div class="panel-body" style="height: 100px;">
                    <div class="statistic-box">
                        <h2><span class="count-number"><?php echo $inc_department['opentickets']; ?></span> <span
                                class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
                        <div class="small">No. of incidents in priority <a
                                href="javascript:void()" data-toggle="tooltip"
                                title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle"
                                    aria-hidden="true"></i></i></a></div>
                        <div class="icon">
                            <i class="fa fa-envelope-open-o"></i>
                        </div>
                        <!-- <a href="<?php echo $int_link_opentickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a> -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('DESCRIBING-INCIDENTS') === true) { ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div class="panel panel-bd">
                <div class="panel-body" style="height: 100px;">
                    <div class="statistic-box">
                        <h2><span class="count-number"><?php echo $inc_department['addressedtickets']; ?></span> <span
                                class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
                        <div class="small">No. of incidents in severity <a
                                href="javascript:void()" data-toggle="tooltip"
                                title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle"
                                    aria-hidden="true"></i></i></a></div>
                        <div class="icon">
                            <i class="fa fa-reply"></i>
                        </div>
                        <!-- <a href="<?php echo $int_link_addressedtickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a> -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

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
                            <a class="btn btn-success" target="_blank" data-placement="bottom" data-toggle="tooltip"
                                title="Incident form"
                                href="<?php echo base_url('inn?user_id=' . $this->session->userdata['user_id']); ?>"
                                target="_blank">
                                <i class="fa fa-pencil"></i> Report incidents
                            </a>

                        </div>
                        <div class="btn-group">
                            <a class="btn btn-success" target="_blank" data-placement="bottom" data-toggle="tooltip"
                                title="<?php echo lang_loader('inc', 'inc_download_all_incident_report'); ?>"
                                href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
                                <i class="fa fa-file-text"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
                            <form>
                                <p>
                                    <span style="font-size:16px;"><strong>Filter By : </strong></span>
                                    <!-- <span style="font-size:15px; font-weight:bold;"><?php echo lang_loader('inc', 'inc_sort_incident_by'); ?></span> -->
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Incident Category</option>
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
                                    <select name="depsec_assigned_risk" class="form-control" id="subsecid" onchange="gotonextdepartment_assigned_risk(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Assigned Risk</option>
                                        <?php
                                        $this->db->order_by('title');
                                        $query = $this->db->get('assigned_risk');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec_assigned_risk') == $row->title) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>

                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_priority(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Action Priority</option>
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
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_severity(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Incident Severity</option>
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
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_incident_assigned_status(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected>Assigned Status</option>
                                        <?php

                                        $query = $this->db->get('incident_assigned_status');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec_incident_assigned_status') == $row->title) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->smallname); ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->smallname); ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                <div style="margin-left:77px;">
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_incident_status(this.value)" style="width:200px; margin-left:80px;margin-top:20px;">
                                        <option value="1" selected>Incident Status</option>
                                        <?php
                                        $this->db->order_by('title');

                                        $query = $this->db->get('incident_status');
                                        $result = $query->result();

                                        foreach ($result as $row) {
                                        ?>
                                            <?php if ($this->input->get('depsec_incident_status') == $row->title) { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                </p>
                            </form>
                            <br />
                        <?php } ?>

                        <table class="incticketsall table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:5%"><?php echo lang_loader('inc', 'inc_slno'); ?></th>
                                    <th style="width:20%;">Incident details</th>
                                    <th style="width:15%;"><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></th>
                                    <th style="width:13%;"><?php echo lang_loader('inc', 'inc_reported_on'); ?> / Occurred on</th>
                                    <th style="width:17%;">Risk / Priority / Category</th>
                                    <th style="width:15%;">Assigned details </th>
                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                        <th style="width:15%; text-align:center;"><?php echo lang_loader('inc', 'inc_status'); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($departments)) {        ?>
                                    <?php $sl = 1; ?>
                                    <?php foreach ($departments as $department) {

                                        // echo '<pre>';
                                        // print_r($department);
                                        // echo '</pre>';
                                        // exit;

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

                                            <td style="overflow-wrap: break-word; word-break: normal; white-space: normal;">
                                                <strong>Incident ID:</strong> <?php echo $department->id; ?><br>

                                                <?php
                                                if ($department->departmentid_trasfered != 0) {
                                                    $show = false;
                                                    if ($department->status == 'Addressed') {
                                                        echo '<strong>Incident:</strong> Ticket was transferred<br>';
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Transfered') {
                                                        echo '<strong>Incident:</strong> ' . $trans_comm . '<br>';
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Reopen') {
                                                        echo '<strong>Incident:</strong> ' . $reopen_comm . '<br>';
                                                        $show = true;
                                                    }
                                                    if ($show == false && $department->status == 'Closed') {
                                                        echo '<strong>Incident:</strong> Ticket was transferred<br>';
                                                    }
                                                } else {
                                                    foreach ($department->feed->reason as $key => $value) {
                                                        if ($key) {
                                                            if ($titles[$key] == $department->department->description) {
                                                                if (in_array($key, $keys)) {
                                                                    echo '<strong>Incident:</strong> ' . $res[$key] . '<br>';
                                                                    echo '<strong>Incident Category:</strong> ' . $department->department->description . '<br>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>

                                            <td style="overflow: clip; word-break: break-all;">


                                                <?php if (!empty($department->feed->patientid)) : ?>
                                                    <?php echo $department->feed->name; ?>
                                                    &nbsp;(<a href="<?php echo $ip_link_patient_feedback . $department->id; ?>">
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
                                                <strong>Reported on:</strong><br>
                                                <?php echo date('g:i A', strtotime($department->created_on)); ?><br>
                                                <?php echo date('d-m-Y', strtotime($department->created_on)); ?><br><br>

                                                <strong>Occurred on:</strong><br>
                                                <?php
                                                if (!empty($department->incident_occured_in)) {
                                                    echo date('g:i A', strtotime(str_replace([',', '-'], '', $department->incident_occured_in))) . "<br>";
                                                    echo date('d-m-Y', strtotime(str_replace([',', '-'], '', $department->incident_occured_in)));
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>




                                            <?php
                                            $priority = !empty($department->feed->priority)
                                                ? str_replace('–', '-', $department->feed->priority)
                                                : 'Unassigned';

                                            switch ($priority) {
                                                case 'P1-Critical':
                                                    $colors = '#ff4d4d';
                                                    break;
                                                case 'P2-High':
                                                    $colors = '#ff9800';
                                                    break;
                                                case 'P3-Medium':
                                                    $colors = '#fbc02d';
                                                    break;
                                                case 'P4-Low':
                                                    $colors = '#1c8e42ff';
                                                    break;
                                                case 'Unassigned':
                                                    $colors = '#6c757d';
                                                    break;
                                                default:
                                                    $colors = '#000';
                                            }
                                            ?>
                                            <?php
                                            $incident_type = !empty($department->feed->incident_type)
                                                ? str_replace('–', '-', $department->feed->incident_type)
                                                : 'Unassigned';

                                            switch ($incident_type) {
                                                case 'Sentinel':
                                                    $color = '#ff4d4d';
                                                    break;
                                                case 'Hazardous Condition':
                                                    $color = '#ff9800';
                                                    break;
                                                case 'Adverse':
                                                    $color = '#fbc02d';
                                                    break;
                                                case 'No-harm':
                                                    $color = '#1c36b4ff';
                                                    break;
                                                case 'Near miss':
                                                    $color = '#1c8e42ff';
                                                    break;
                                                case 'Unassigned':
                                                    $color = '#6c757d';
                                                    break;
                                                default:
                                                    $color = '#000';
                                            }
                                            ?>
                                            <?php
                                            $rm = !empty($department->feed->risk_matrix) ? (array) $department->feed->risk_matrix : [];
                                            $level = $rm['level'] ?? '';
                                            $impact = $rm['impact'] ?? '';
                                            $likelihood = $rm['likelihood'] ?? '';

                                            $riskColors = [
                                                'High'   => '#d9534f',
                                                'Medium' => '#f0ad4e',
                                                'Low'    => '#1c8e42ff',
                                                'default' => '#6c757d'
                                            ];

                                            $getColor = function ($value) use ($riskColors) {
                                                return $riskColors[$value] ?? $riskColors['default'];
                                            };
                                            ?>

                                            <td>
                                                <table style="width:100%; border-collapse: collapse; font-size:14px; line-height:1.6;">
                                                    <!-- Risk -->
                                                    <tr>
                                                        <td style="width:30px;  font-weight:bold;">Risk</td>
                                                        <td style="width:10px; text-align:center;">:</td>
                                                        <td style="padding-left:6px;">
                                                            <?php if (!empty($level)) : ?>
                                                                <span style="color: <?php echo $getColor($level); ?>;">
                                                                    <strong><?php echo htmlspecialchars($level); ?></strong>
                                                                </span>
                                                            <?php else: ?>
                                                                <span style="color:#6c757d; font-style:italic;"><strong>Unassigned</strong></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="width:40px; padding-left:10px;">
                                                            <?php if (
                                                                !empty($department->feed->patientid) && $department->status != 'Closed'
                                                                && ismodule_active('INCIDENT') && isfeature_active('EDIT-SEVERITY-INCIDENTS')
                                                                && $department->verified_status != 1
                                                            ): ?>
                                                                <a href="<?php echo $ip_link_patient_feedback . $department->id; ?>" title="Edit">
                                                                    <i class="fa fa-edit" style="font-size:16px; color:green;"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <!-- Priority -->
                                                    <tr>
                                                        <td style="font-weight:bold;">Priority</td>
                                                        <td style="text-align:center;">:</td>
                                                        <td style="padding-left:6px;">
                                                            <span style="color: <?php echo $colors; ?>; 
                             font-style:<?php echo ($priority == 'Unassigned') ? 'italic' : 'normal'; ?>;">
                                                                <strong><?php echo $priority; ?></strong>
                                                            </span>
                                                        </td>
                                                        <td style="padding-left:10px;">
                                                            <?php if (
                                                                !empty($department->feed->patientid) && $department->status != 'Closed'
                                                                && ismodule_active('INCIDENT') && isfeature_active('EDIT-PRIORITY-INCIDENTS')
                                                                && $department->verified_status != 1
                                                            ): ?>
                                                                <!-- <a href="<?php echo $ip_link_patient_feedback . $department->id; ?>" title="Edit">
                        <i class="fa fa-edit" style="font-size:16px; color:green;"></i>
                    </a> -->
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <!-- Severity -->
                                                    <tr>
                                                        <td style="font-weight:bold;">Category</td>
                                                        <td style="text-align:center;">:</td>
                                                        <td style="padding-left:6px;">
                                                            <span style="color:<?php echo empty($incident_type) ? '#6c757d' : $color; ?>; 
                             font-style:<?php echo ($incident_type == 'Unassigned') ? 'italic' : 'normal'; ?>;">
                                                                <strong><?php echo $incident_type ?? 'Unassigned'; ?></strong>
                                                            </span>
                                                        </td>
                                                        <td style="padding-left:10px;">
                                                            <?php if (
                                                                !empty($department->feed->patientid) && $department->status != 'Closed'
                                                                && ismodule_active('INCIDENT') && isfeature_active('EDIT-SEVERITY-INCIDENTS')
                                                                && $department->verified_status != 1
                                                            ): ?>
                                                                <!-- <a href="<?php echo $ip_link_patient_feedback . $department->id; ?>" title="Edit">
                        <i class="fa fa-edit" style="font-size:16px; color:green;"></i>
                    </a> -->
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <b><strong> Team Leader :</strong></b>
                                                <?php echo !empty($names) ? $names : 'Unassigned'; ?><br>

                                                <!-- <b><strong> Team Member :</strong></b>
                                                <?php echo !empty($actionText_team_member) ? $actionText_team_member : 'Unassigned'; ?><br> -->

                                                <!-- <b><strong> Process Monitor :</strong></b>
                                                <?php echo !empty($actionText_process_monitor) ? $actionText_process_monitor : 'Unassigned'; ?> -->
                                                <br>
                                                <?php
                                                // Show Assigned Date for all relevant statuses
                                                if (
                                                    $department->status == 'Assigned' ||
                                                    $department->status == 'Re-assigned' ||
                                                    $department->status == 'Described'
                                                ) {
                                                    $assignedDate = null;
                                                    $ticketId = $department->id ?? null;

                                                    if (!empty($ticketId)) {
                                                        // Build base query
                                                        $this->db->select('created_on')
                                                            ->from('ticket_incident_message')
                                                            ->where('ticketid', $ticketId);

                                                        // ✅ Logic based on current status
                                                        if ($department->status == 'Re-assigned') {
                                                            // Get the latest Re-assigned record
                                                            $this->db->where('ticket_status', 'Re-assigned')
                                                                ->order_by('created_on', 'DESC')
                                                                ->limit(1);
                                                        } else {
                                                            // Get the first Assigned record
                                                            $this->db->where('ticket_status', 'Assigned')
                                                                ->order_by('created_on', 'ASC')
                                                                ->limit(1);
                                                        }

                                                        $query = $this->db->get();
                                                        $result = $query->row();

                                                        if (!empty($result)) {
                                                            $assignedDate = $result->created_on;
                                                        }
                                                    }

                                                    // Display the label and date
                                                    echo '<b><strong>Assigned On :</strong></b> ';
                                                    if (!empty($assignedDate)) {
                                                        echo date('d M, Y - g:i A', strtotime($assignedDate));
                                                    } else {
                                                        echo 'Unassigned';
                                                    }
                                                    echo '<br>';
                                                }
                                                ?>


                                                <br>

                                                <?php
                                                if (
                                                    $department->status == 'Assigned' ||
                                                    $department->status == 'Re-assigned' ||
                                                    $department->status == 'Described'
                                                ) {
                                                ?>
                                                    <div>
                                                        <b><strong>TAT Due :</strong></b>
                                                        <?php
                                                        date_default_timezone_set('Asia/Kolkata'); // Set your timezone

                                                        // Determine which date field to use
                                                        if ($department->status == 'Described') {
                                                            $targetDate = $department->assign_tat_due_date ?? null;
                                                        } else {
                                                            $targetDate = $department->assign_tat_due_date ?? null;
                                                        }

                                                        if (!empty($targetDate)) {
                                                            $dueDate = strtotime($targetDate);
                                                            $now = time();

                                                            // Display formatted due date first
                                                            echo date('d M, Y - g:i A', $dueDate) . '<br>';

                                                            if ($dueDate > $now) {
                                                                // ✅ Within TAT (green)
                                                                // echo '<span style="color:green; font-weight:bold;">Within TAT</span><br>';
                                                            } else {
                                                                // ❌ TAT Overdue (red)
                                                                $diff = $now - $dueDate;
                                                                $days = floor($diff / (60 * 60 * 24));
                                                                $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));

                                                                // echo '<span style="color:red; font-weight:bold;">TAT due by ';
                                                                // if ($days > 0) echo $days . ' days ';
                                                                // if ($hours > 0) echo $hours . ' hrs';
                                                                echo '</span><br>';
                                                            }
                                                        } else {
                                                            echo 'Unassigned';
                                                        }
                                                        ?>
                                                        <br>
                                                    </div>
                                                <?php } ?>

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
                                                $tick_status = 'Open';
                                                $status_icon = 'fa fa-envelope-open-o';
                                            } elseif ($department->status == 'Rejected') {
                                                $tool = 'Click to change the status.';
                                                $tick_status = 'Rejected';
                                                $color = 'btn-yellow'; // Changed color to btn-yellow for Rejected
                                                $status_icon = 'fa fa-reply';
                                            } elseif ($department->status == 'Closed') {
                                                $tool = 'Ticket is closed';
                                                $tick_status = 'Closed';
                                                $color = 'btn-success';
                                                $status_icon = 'fa fa-check-circle';
                                            } elseif ($department->status == 'Reopen') {
                                                $tool = 'Click to close this ticket.';
                                                $tick_status = 'Reopen';
                                                $color = 'btn-primary';
                                            } elseif ($department->status == 'Transfered') {
                                                $tool = 'Click to close this ticket.';
                                                $tick_status = 'Transfered';
                                                $color = 'btn-info';
                                            } elseif ($department->status == 'Assigned') {
                                                $tool = 'Click to change the status.';
                                                $tick_status = 'Assigned';
                                                $color = 'btn-orange'; // Added this condition for Assigned
                                                $status_icon = 'fa fa-hand-paper-o';
                                            } elseif ($department->status == 'Re-assigned') {
                                                $tool = 'Click to change the status.';
                                                $tick_status = 'Assigned';
                                                $color = 'btn-orange'; // Added this condition for Assigned
                                                $status_icon = 'fa fa-hand-paper-o';
                                            } elseif ($department->status == 'Described') {
                                                $tool = 'Click to change the status.';
                                                $tick_status = 'Described';
                                                $color = 'btn-reddd'; // Added this condition for Assigned
                                                $status_icon = '';
                                            } else {
                                                $tool = 'Unknown status';
                                                $color = 'btn-info';
                                            }
                                            ?>

                                            <?php if (ismodule_active('INCIDENT') === true && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                                <td style="vertical-align: middle; padding: 5px;">
                                                    <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                                                        <!-- 1st Button (Status) -->
                                                        <?php if ($department->status != 'Verified' && $department->verified_status != 1) { ?>
                                                            <a style="font-size: 17px; width: 115px;"
                                                                href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>"
                                                                data-placement="bottom" data-toggle="tooltip"
                                                                title="<?php echo $tool; ?>"
                                                                class="btn btn-sm btn-block <?php echo $color; ?>">
                                                                <?php echo $tick_status; ?>
                                                                <i style="font-size:15px;margin-left:5px;" class="<?php echo $status_icon; ?>"></i>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a style="font-size: 17px; width: 115px;"
                                                                href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>"
                                                                data-placement="bottom" data-toggle="tooltip"
                                                                title="<?php echo $tool; ?>"
                                                                class="btn btn-sm btn-block <?php echo $color; ?>">
                                                                Verified
                                                                <i style="font-size:15px;margin-left:5px;" class="<?php echo $status_icon; ?>"></i>
                                                            </a>
                                                        <?php } ?>

                                                        <!-- 2nd Button (Verified Icon) -->
                                                        <?php if (isfeature_active('IN-VERIFY-INCIDENTS') === true && $department->status == 'Closed' && $department->verified_status == 1) { ?>
                                                            <i style="font-size: 25px; color: green;"
                                                                class="fa fa-check-circle-o"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Incident is verified"></i>
                                                        <?php } ?>

                                                        <!-- 3rd Button (Delete Icon) -->
                                                        <?php if (isfeature_active('IN-DELETE-INCIDENTS') === true) { ?>
                                                            <?php echo form_open('ticketsincident/create', ['class' => 'form-inner', 'id' => 'deleteForm_' . $department->id]) ?>
                                                            <input type="hidden" name="status" value="Delete">
                                                            <input type="hidden" name="id" value="<?php echo $department->id; ?>">
                                                            <a style="font-size: 14px; width: 50px;" href="#"
                                                                onclick="submitDeleteForm(event, '<?php echo $department->id; ?>');"
                                                                data-placement="bottom" data-toggle="tooltip"
                                                                title="<?php echo $tooldelete; ?>"
                                                                class="btn btn-sm btn-block btn-danger">
                                                                <i style="font-size: 15px;" class="fa fa-trash"></i>
                                                            </a>
                                                            <?php echo form_close(); ?>
                                                        <?php } ?>
                                                    </div>
                                                    <br>
                                                    <?php
                                                    if (
                                                        $department->status == 'Assigned' ||
                                                        $department->status == 'Re-assigned' ||
                                                        $department->status == 'Described'
                                                    ) {
                                                    ?>
                                                        <div>
                                                            <?php
                                                            date_default_timezone_set('Asia/Kolkata'); // Set timezone

                                                            $targetDate = $department->assign_tat_due_date ?? null;

                                                            if (!empty($targetDate)) {
                                                                $dueDate = strtotime($targetDate);
                                                                $now = time();
                                                                $ticketId = $department->id ?? null;
                                                                $describedDate = null;

                                                                // ✅ If status is "Described", fetch described time from DB
                                                                if ($department->status == 'Described' && !empty($ticketId)) {
                                                                    $this->db->select('created_on')
                                                                        ->from('ticket_incident_message')
                                                                        ->where('ticketid', $ticketId)
                                                                        ->where('ticket_status', 'Described')
                                                                        ->order_by('created_on', 'DESC')
                                                                        ->limit(1);
                                                                    $query = $this->db->get();
                                                                    $result = $query->row();

                                                                    if (!empty($result)) {
                                                                        $describedDate = strtotime($result->created_on);
                                                                    }
                                                                }

                                                                // ✅ If Described, compare described date vs due date
                                                                if ($department->status == 'Described' && !empty($describedDate)) {
                                                                    if ($describedDate <= $dueDate) {
                                                                        // Described within TAT ✅
                                                                        echo '<span style="color:green; font-weight:bold;">Within TAT</span><br>';
                                                                    } else {
                                                                        // Described after due date ❌
                                                                        $diff = $describedDate - $dueDate;
                                                                        $days = floor($diff / (60 * 60 * 24));
                                                                        $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));

                                                                        echo '<span style="color:red; font-weight:bold;">TAT Exceeded by ';
                                                                        if ($days > 0) echo $days . ' days ';
                                                                        if ($hours > 0) echo $hours . ' hrs';
                                                                        echo '</span><br>';
                                                                    }
                                                                } else {
                                                                    // ✅ For all other statuses, compare current time vs due date
                                                                    if ($dueDate > $now) {
                                                                        echo '<span style="color:green; font-weight:bold;">Within TAT</span><br>';
                                                                    } else {
                                                                        $diff = $now - $dueDate;
                                                                        $days = floor($diff / (60 * 60 * 24));
                                                                        $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));

                                                                        echo '<span style="color:orange; font-weight:bold;">TAT Due by ';
                                                                        if ($days > 0) echo $days . ' days ';
                                                                        if ($hours > 0) echo $hours . ' hrs';
                                                                        echo '</span><br>';
                                                                    }
                                                                }
                                                            } else {
                                                                echo 'Unassigned';
                                                            }
                                                            ?>
                                                            <br>
                                                        </div>


                                                    <?php } ?>

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

    function gotonextdepartment_assigned_risk(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec_assigned_risk=") ?>" + type;
        window.location.href = url;
    }

    function gotonextdepartment_incident_status(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec_incident_status=") ?>" + type;
        window.location.href = url;
    }

    function gotonextdepartment_incident_assigned_status(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec_incident_assigned_status=") ?>" + type;
        window.location.href = url;
    }
</script>
<script>
    function submitDeleteForm(event, id) {
        event.preventDefault();

        const confirmDelete = confirm("This incident will be permanently deleted from the application. Are you sure you want to proceed?");

        if (confirmDelete) {
            document.getElementById('deleteForm_' + id).submit();
        }
    }
</script>