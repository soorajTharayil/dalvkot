<?php
// Fetch all users from the database

$users = $this->db->select('user.*')
    ->where('user_id !=', 1)
    ->get('user')
    ->result();

// Initialize $checked_users with user names from the fetched users
$checked_users = array();
foreach ($users as $user) {
    $checked_users[] = $user->user_id;
}
?>
<div class="content">
    <div class="row">

        <div class="col-lg-12">
            <?php

            // print_r($departments);
            $this->db->where('id', $departments[0]->feedbackid);
            $query = $this->db->get('bf_feedback_incident');
            $result = $query->result();
            $feedback = $result[0];
            $param = json_decode($feedback->dataset, true);
            $this->db->order_by('id');
            // print_r($param);
            $this->db->where('title', $departments[0]->department->description);
            $query = $this->db->get('setup_incident');

            $sresult = $query->result();
            $setarray = array();
            $questioarray = array();
            // print_r($sresult);
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

            ?>


            <?php $department = $departments[0];

            // echo '<pre>';
            // print_r($department->assign_for_process_monitor);
            // print_r($department->assign_to);
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

            // Step 3: Map IDs → names
            $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
                return $userMap[$id] ?? $id;
            }, $assign_for_process_monitor_ids);

            $assign_to_names = array_map(function ($id) use ($userMap) {
                return $userMap[$id] ?? $id;
            }, $assign_to_ids);

            // Step 4: Join into comma-separated strings
            $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
            $names = implode(', ', $assign_to_names);

            // Debug output
            


            ?>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="INCIDENTS- <INCIDENTS ID> ">
                            <i class="fa fa-question-circle"
                                aria-hidden="true"></i></a>&nbsp;INC-<?php echo $department->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">

                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td> <strong><?php echo lang_loader('inc', 'inc_incident_report'); ?></strong> </td>
                            <td>



                                <strong> <?php echo lang_loader('inc', 'inc_category'); ?></strong>
                                <?php echo $department->department->description; ?>
                                <br>
                                <?php
                                // print_r($reasons);
                                if ($param['reason']) { ?>
                                    <strong> <?php echo 'Incident : '; ?></strong>

                                    <?php foreach ($param['reason'] as $key => $value) { ?>
                                        <?php if ($value === true) {
                                            $this->db->where('shortkey', $key);
                                            $query = $this->db->get('setup_incident');
                                            $cresult = $query->result();
                                            ?>
                                            <?php if (count($cresult) != 0) { ?>
                                                <?php echo $cresult[0]->shortname; ?>

                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else {
                                    echo $departments[0]->department->name;
                                } ?>

                                <?php foreach ($param['comment'] as $key => $value) { ?>
                                    <?php if ($key) { ?>
                                        <?php $comm = $value; ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($comm) { ?>
                                    <span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
                                        <strong> <?php echo 'Description : '; ?></strong>
                                        <?php echo '"' . $comm . '"'; ?>.
                                    </span>
                                <?php } ?>

                                <?php if ($param['what_went_wrong']) { ?>
                                    <span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
                                        <strong> <?php echo 'What went wrong : '; ?></strong>
                                        <?php echo '"' . $param['what_went_wrong'] . '"'; ?>.
                                    </span>
                                <?php } ?>

                                <?php if ($param['action_taken']) { ?>
                                    <span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
                                        <strong> <?php echo 'Immediate action taken : '; ?></strong>
                                        <?php echo '"' . $param['action_taken'] . '"'; ?>.
                                    </span>
                                <?php } ?>

                            </td>
                        </tr>
                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></strong></td>
                            <td>
                                <?php $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
                                ?>

                                <?php echo $param['name']; ?>
                                (<a
                                    href="<?php echo $ip_link_patient_feedback . $param['patientid']; ?>"><?php echo $param['patientid']; ?></a>)

                                <!-- <br>
                                <?php echo $param['role']; ?> -->
                                <br>
                                <?php if ($param['contactnumber'] != '') { ?>
                                    <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
                                <?php } ?>
                                <br>
                                <?php if ($param['email'] != '') { ?>
                                    <i class="fa fa-envelope-o"></i> <?php echo $param['email']; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if ($department->incident_occured_in) { ?>
                            <tr>
                                <td><strong>Incident occured on</strong></td>
                                <td><?php echo $department->incident_occured_in; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Incident reported on</strong></td>
                            <td><?php echo date('d M, Y - g:i A', strtotime($department->created_on)); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Incident reported in</strong></td>
                            <td><?php if ($param['ward'] != '') { ?>
                                    <?php echo 'Floor/Ward: '; ?>
                                    <?php echo ($param['ward']); ?>
                                <?php } ?>
                                <br>
                                <?php if ($param['bedno']) { ?>
                                    <?php echo 'Site: '; ?>
                                    <?php echo $param['bedno']; ?>
                                <?php } ?>

                            </td>
                        </tr>


                        <tr>
                            <td>
                                <strong>Assigned risk</strong>
                            </td>
                            <td>
                                <?php if (!empty($param['risk_matrix']['level']) && !empty($param['risk_matrix']['impact']) && !empty($param['risk_matrix']['likelihood'])): ?>
                                    <?php
                                    // Helper function
                                    if (!function_exists('getRiskColor')) {
                                        function getRiskColor($value)
                                        {
                                            switch ($value) {
                                                case 'High':
                                                    return '#d9534f'; // red
                                                case 'Medium':
                                                    return '#f0ad4e'; // orange
                                                case 'Low':
                                                    return '#107427ff'; // blue
                                                default:
                                                    return '#6c757d'; // gray
                                            }
                                        }
                                    }

                                    $level = $param['risk_matrix']['level'];
                                    $impact = $param['risk_matrix']['impact'];
                                    $likelihood = $param['risk_matrix']['likelihood'];
                                    ?>
                                    <strong>
                                        <span
                                            style="color: <?php echo getRiskColor($level); ?>;"><?php echo htmlspecialchars($level); ?></span>
                                    </strong>
                                    (
                                    <span style=""><?php echo htmlspecialchars($impact); ?></span>
                                    Impact ×
                                    <span style=""><?php echo htmlspecialchars($likelihood); ?></span>
                                    Likelihood
                                    )

                                <?php else: ?>
                                    <span style="color:#6c757d;font-style:italic;">Unassigned</span>
                                <?php endif; ?>
                            </td>

                        </tr>



                        <tr>
                            <td>
                                <strong>Assigned priority</strong>
                            </td>
                            <td>
                                <?php
                                $priority = !empty($param['priority']) ? $param['priority'] : 'Unassigned';

                                switch ($priority) {
                                    case 'P1-Critical':
                                        $color = '#d9534f';
                                        break; // red
                                    case 'P2-High':
                                        $color = '#f0ad4e';
                                        break; // orange
                                    case 'P3-Medium':
                                        $color = '#d7da17ff';
                                        break; // yellow
                                    case 'P4-Low':
                                        $color = '#5bc0de';
                                        break; // blue
                                    case 'Unassigned':
                                        $color = '#6c757d';
                                        break; // gray
                                    default:
                                        $color = '#000000';
                                }
                                ?>
                                <span
                                    style="color: <?php echo $color; ?>; <?php echo ($priority == 'Unassigned' ? 'font-style:italic;' : ''); ?>">
                                    <strong><?php echo htmlspecialchars($priority); ?></strong>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Assigned severity</strong>
                            </td>
                            <td>
                                <?php
                                $incident_type = !empty($param['incident_type']) ? $param['incident_type'] : 'Unassigned';

                                switch ($incident_type) {
                                    case 'Sentinel':
                                        $sevColor = '#d9534f';
                                        break; // red
                                    case 'Adverse':
                                        $sevColor = '#f0ad4e';
                                        break; // orange
                                    case 'No-harm':
                                        $sevColor = '#5bc0de';
                                        break; // blue
                                    case 'Near miss':
                                        $sevColor = '#19ca6e';
                                        break; // green
                                    case 'Unassigned':
                                        $sevColor = '#6c757d';
                                        break; // gray
                                    default:
                                        $sevColor = '#000000';
                                }
                                ?>
                                <span
                                    style="color: <?php echo $sevColor; ?>; <?php echo ($incident_type == 'Unassigned' ? 'font-style:italic;' : ''); ?>">
                                    <strong><?php echo htmlspecialchars($incident_type); ?></strong>
                                </span>
                            </td>
                        </tr>

                        <?php if ($param['tag_patientid'] || $param['tag_name']) { ?>
                            <tr>
                                <td><strong><?php echo lang_loader('inc', 'inc_patient_details'); ?></strong></td>
                                <td>
                                    <?php echo lang_loader('inc', 'inc_patient_id'); ?>
                                    <?php echo $param['tag_patientid']; ?> <br>
                                    <?php echo lang_loader('inc', 'inc_patient_name'); ?>     <?php echo $param['tag_name']; ?>
                                    <br>

                                </td>
                            </tr>
                        <?php } ?>


                        <?php if ($names) { ?>
                            <tr>
                                <td><strong>Assigned team leader</strong></td>
                                <td>
                                    <?php echo $names; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($actionText_process_monitor) { ?>
                            <tr>
                                <td><strong>Assigned process monitor</strong></td>
                                <td>
                                    <?php echo $actionText_process_monitor; ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php
                        if (!empty($param['images']) && is_array($param['images'])) { ?>
                            <tr>
                                <td><strong><?php echo lang_loader('inc', 'inc_attached_image'); ?></strong></td>
                                <td>
                                    <?php
                                    $i = 1;
                                    foreach ($param['images'] as $encodedImage) { ?>
                                        <a href="<?php echo $encodedImage; ?>" download="image_<?php echo $i; ?>.jpg"
                                            target="_blank">
                                            Download Image <?php echo $i; ?>
                                        </a><br>
                                        <?php
                                        $i++;
                                    } ?>
                                </td>
                            </tr>
                        <?php } ?>


                        <script>
                            function previewImage(imageData, filename) {
                                var win = window.open('', '_blank');
                                win.document.title = filename; // Set window title to filename
                                win.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${filename}</title>
            <style>
                body { margin: 0; padding: 0; background: #f5f5f5; }
                .image-container { 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    height: 100vh; 
                    padding: 20px;
                    box-sizing: border-box;
                }
                img { 
                    max-width: 100%; 
                    max-height: 100%; 
                    object-fit: contain; 
                    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                }
                .filename {
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    background: rgba(0,0,0,0.7);
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-family: Arial, sans-serif;
                }
            </style>
        </head>
        <body>
            <div class="filename">${filename}</div>
            <div class="image-container">
                <img src="${imageData}" alt="${filename}">
            </div>
        </body>
        </html>
    `);
                                win.document.close();
                            }
                        </script>

                        <tr>
                            <td><strong>Attached documents</strong></td>
                            <td>
                                <?php
                                if (!empty($param['files_name']) && is_array($param['files_name'])) {
                                    foreach ($param['files_name'] as $file) {
                                        if (!empty($file['name']) && !empty($file['url'])) {
                                            echo '<span class="no-print"><a href="' . htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8') . '" download="' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '">';
                                            echo htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
                                            echo '</a></span>';

                                            echo '<span class="only-print" style="display:none;">' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '</span><br>';
                                        }
                                    }
                                } else {
                                    echo 'No files available';
                                }
                                ?>
                            </td>

                        </tr>






                        <?php if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) { ?>

                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_incident_assigned_to'); ?></strong></td>
                            <td><?php echo implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]); ?>
                            </td>

                        </tr>
                        <?php } ?>



                        <?php if (isr_tat('department_link') === true) { ?>
                        <?php if ($department->status != 'Closed' && $department->status != 'Reopen') { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_tat_status'); ?></strong></td>
                            <td>
                                <?
                                $currentTime = time();
                                $start_time = 0;
                                $end_time = 1;
                                $closeTime = $department->department->close_time;
                                $createdOn1 = strtotime($department->created_on);
                                $underrange = $createdOn1 + ($closeTime);
                                $uprange = $createdOn1 + ($end_time * $closeTime);
                                $lastModified1 = strtotime($department->last_modified) - 5;
                                $lastModified2 = strtotime($department->last_modified);
                                $countexc = 0;
                                $time_rem = $createdOn1 + $closeTime;
                                // $timeDifferenceInSeconds = $currentTime - $time_rem;
                                $timeDifferenceInSeconds = $time_rem - $currentTime;
                                $value = $this->updated_model->convertSecondsToTime($timeDifferenceInSeconds);

                                if ($value['isNegative'] == false) {
                                    echo '<b><span style="color:green;">Within TAT<span></b>';
                                    echo '<br>';
                                    echo 'TAT exceeding in ';
                                    if ($value['days'] != 0)
                                        echo $value['days'] . ' days, ';
                                    if ($value['hours'] != 0)
                                        echo $value['hours'] . ' hrs, ';
                                    if ($value['minutes'] != 0)
                                        echo $value['minutes'] . ' mins,';
                                    if ($value['seconds'] <= 60)
                                        echo $value['seconds'] . ' seconds';
                                } else {
                                    echo '<b><span style="color:red;">Exceeded TAT<span></b>';
                                    echo '<br>';
                                    echo 'TAT exceeded ';
                                    if ($value['days'] != 0)
                                        echo $value['days'] . ' days, ';
                                    if ($value['hours'] != 0)
                                        echo $value['hours'] . ' hrs, ';
                                    if ($value['minutes'] != 0)
                                        echo $value['minutes'] . ' mins,';
                                    if ($value['seconds'] <= 60)
                                        echo $value['seconds'] . ' seconds';
                                    echo ' ago. ';
                                } ?>

                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_incident_status'); ?></strong> </td>
                            <td> <?php if ($this->session->userdata['isLogIn'] == false) { ?>
                                <?php if ($department->status == 'Closed') { ?>
                                <span style="color:  #198754;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Closed'; ?>
                                <?php } ?>
                                <?php if ($department->status == 'Addressed' || $department->status == 'Reopen' || $department->status == 'Transfered') { ?>
                                <span style="color:  #f0ad4e;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Inprogress'; ?>
                                <?php } ?>
                                <?php if ($department->status == 'Open') { ?>
                                <span style="color: #d9534f;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Pending'; ?>
                                <?php } ?>
                                <?php if ($department->status == 'Assigned') { ?>
                                <span style="color: #f09a22;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Assigned'; ?>
                                <?php } ?>
                                <?php if ($department->status == 'Re-assigned') { ?>
                                <span style="color: #f09a22;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Re-assigned'; ?>
                                <?php } ?>
                                <?php if ($department->status == 'Described') { ?>
                                <span style="color: #f09a22;font-weight: bold; display: inline-block;"><i
                                        class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php echo 'Described'; ?>
                                <?php } ?>
                                <?php } ?>
                                <?php if ($this->session->userdata['isLogIn'] == true) { ?>
                                <?php //if (($this->session->userdata['user_role'] == 4 && $this->session->userdata['email'] == $department->department->email) || $this->session->userdata['user_role'] <= 3) { 
                                    ?>
                                <select class="form-control" onchange="ticket_options(this.value)"
                                    style="max-width: 300px;" required>
                                    <option value="<?php echo $department->status; ?>" selected>
                                        <?php echo $department->status; ?>
                                    </option>
                                    <?php if ($department->status != 'Assigned' && $department->status != 'Rejected' && $department->status != 'Described' && $department->status != 'Closed' && $department->status != 'Re-assigned') { ?>
                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-ASSIGNED-INCIDENTS') === true) { ?>
                                    <option value="assignuser">Accept & Assign</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if ($department->status != 'Closed' && $department->status != 'Open') { ?>
                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-REASSIGNED-INCIDENTS') === true) { ?>
                                    <option value="reassign">Re-assign</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if ($department->status != 'Rejected' && $department->status != 'Assigned' && $department->status != 'Described' && $department->status != 'Closed') { ?>
                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-REJECTED-INCIDENTS') === true) { ?>

                                    <option value="reject">Reject</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('DESCRIBING-INCIDENTS') === true) { ?>
                                    <?php if ($department->status != 'Closed' && $department->status != 'Open') { ?>
                                    <option value="describe">Explain with RCA & CAPA</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if ($department->status != 'Closed') {
                                        $open = true; ?>



                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('CLOSING-INCIDENTS') === true) { ?>
                                    <?php if ($department->status != 'Rejected') { ?>
                                    <option value="capa">Verify & Close</option>
                                    <?php } ?>
                                    <?php } ?>



                                    <?php } ?>
                                    <!-- check login if not 4 -->
                                    <!-- check if ticket is closed -->
                                    <?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) {

                                        $closed = true; ?>
                                    <?php if ($department->status == 'Closed' || $department->status == 'Rejected') { ?>

                                    <?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-REOPEN-INCIDENTS') === true) { ?>
                                    <option value="reopen"><?php echo lang_loader('inc', 'inc_reopen'); ?></option>

                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                    <!-- <?php if ($department->status == 'Closed') { ?>

                                        <?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-VERIFY-INCIDENTS') === true) { ?>
                                            <option value="verify">Verify</option>

                                        <?php } ?>
                                    <?php } ?> -->

                                </select>
                                <span> <i class="fa fa-hand-o-left" aria-hidden="true"
                                        style="font-size: 20px; padding-left: 50px;"></i></span>
                                <span style="padding-left: 10px;">Take Action here</span>

                                <?php } ?>
                                <?php //} 
                                ?>
                            </td>
                        </tr>
                        <?php if ($department->last_modified > $department->created_on) { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_last_updated_on'); ?></strong> </td>
                            <td><?php echo date('g:i A, d-m-y', strtotime($department->last_modified)); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (isr_tat('department_link') === true) { ?>
                        <?php if ($department->status == 'Closed') { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('inc', 'inc_turn_around_time'); ?></strong> </td>
                            <td><?php
                            $createdOn = strtotime($department->created_on);
                            $lastModified = strtotime($department->last_modified);
                            $timeDifferenceInSeconds = $lastModified - $createdOn;
                            $value = $this->updated_model->convertSecondsToTime($timeDifferenceInSeconds);

                            if ($value['days'] != 0) {
                                echo $value['days'] . ' days, ';
                            }
                            if ($value['hours'] != 0) {
                                echo $value['hours'] . ' hrs, ';
                            }
                            if ($value['minutes'] != 0) {
                                echo $value['minutes'] . ' mins.';
                            }
                            ?></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

        <?php
        $assignedUsers = explode(',', $department->assign_for_process_monitor); // convert to array
        $currentUserId = $this->session->userdata('user_id');

        if (in_array($currentUserId, $assignedUsers)) { ?>
        <?php if ($department->status != 'Closed') { ?>

        <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
        <?php echo form_hidden('id', $department->id) ?>
        <div class="form-group row">
            <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
            <!-- <div class="col-xs-9"> -->
            <!-- </div> -->
        </div>
        <div class="col-sm-12">
            <div class="form-group row">
                <textarea class="form-control" rows="5" minlength="15" id="comment" name="process_monitor_note"
                    placeholder="Add notes" required></textarea>
                <input type="hidden" name="reply_by" value="Admin">
                <input type="hidden" name="status" value="Monitor">
            </div>
        </div>

        <br>
        <!--Radio-->
        <div class="form-group row">
            <div class="col-sm-6">
                <div class="ui buttons">
                    <button class="ui positive button">
                        <?php echo lang_loader('inc', 'inc_submit'); ?>
                    </button>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
        <?php } ?>
        <?php } ?>


        <?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true && ($department->status == 'Closed')) {

            if ($closed == true) { ?>


        <?php if (($department->status != 'Open')) { ?>
        <div class="col-sm-12" id="reopen" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><?php echo lang_loader('inc', 'inc_reopen_this_incident'); ?></h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>
                    <div class="form-group row">
                        <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                        <!-- <div class="col-xs-9"> -->
                        <input type="hidden" name="status" value="Reopen">
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <textarea class="form-control" rows="5" minlength="15" id="comment" name="reply"
                                placeholder="Reason to reopen incident" required></textarea>
                            <input type="hidden" name="reply_by" value="Admin">
                            <input type="hidden" name="status" value="Reopen">
                        </div>
                    </div>


                    <!--Radio-->
                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="ui buttons"> <button
                                    class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <!-- Verify code  -->
        <div class="col-sm-12" id="verify" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Verify Incident</h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>
                    <div class="form-group row">
                        <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                        <!-- <div class="col-xs-9"> -->
                        <input type="hidden" name="status" value="Verified">
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <textarea class="form-control" rows="5" minlength="15" id="comment" name="reply"
                                placeholder="Reason for verifying incident" required></textarea>
                            <input type="hidden" name="reply_by" value="Admin">
                            <input type="hidden" name="status" value="Verified">
                        </div>
                    </div>


                    <!--Radio-->
                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="ui buttons"> <button
                                    class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <?php } ?>
        <?php } ?>


        <?php } else { ?>
        <?php if ($open == true) { ?>
        <?php if (($department->status != 'Closed')) { ?>
        <div class="col-sm-12" id="address" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><?php echo lang_loader('inc', 'inc_address_this_incident'); ?> </h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>
                    <div class="form-group row">
                        <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                        <!-- <div class="col-xs-9"> -->
                        <input type="hidden" name="addressed" <?php if ($department->addressed == 1) {
                            echo 'checked disabled';
                        } ?>>
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <textarea class="form-control" rows="5" minlength="15" id="comment" name="reply"
                                placeholder="Please enter your initial response message" required></textarea>
                            <input type="hidden" name="reply_by" value="Admin">
                            <input type="hidden" name="status" value="Addressed">
                        </div>
                    </div>


                    <!--Radio-->
                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="ui buttons"> <button
                                    class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="col-sm-12" id="reject" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Enter the reason for rejecting this incident </h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>
                    <div class="form-group row">
                        <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                        <!-- <div class="col-xs-9"> -->
                        <input type="hidden" name="addressed" <?php if ($department->addressed == 1) {
                            echo 'checked disabled';
                        } ?>>
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <textarea class="form-control" rows="5" minlength="15" id="comment" name="reply"
                                placeholder="Please enter your input here" required></textarea>
                            <input type="hidden" name="rejected_by" value="Admin">
                            <input type="hidden" name="status" value="Rejected">
                        </div>
                    </div>


                    <!--Radio-->
                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="ui buttons"> <button
                                    class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="col-sm-12" id="capa" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading rca-heading">
                    <h3 class="panel-title" style="margin:0;">
                        Enter Root Cause Analysis (RCA) to Close the Incident
                    </h3>


                </div>


                <?php echo form_open('ticketsincident/create', array('class' => 'form-inner', 'enctype' => 'multipart/form-data')); ?>
                <?php echo form_hidden('id', $department->id) ?>

                <div class="col-sm-12" style="overflow:auto;">

                    <script>
                        function showbox() {
                            $('#correctiveid').show();
                            $("#corrective").attr("required", "true");
                        }

                        function hidebox() {
                            $('#correctiveid').hide();
                            $("#corrective").removeAttr("required");
                        }

                        // RCA method toggle
                        (function ($) {
                            $(function () {
                                function toggleRCA() {
                                    var m = $('#rca_method').val();
                                    // Hide all & remove required
                                    $('#rca_DEFAULT, #rca_5WHY, #rca_5W2H').hide()
                                        .find('textarea, input').prop('required', false);

                                    if (m === 'DEFAULT') {
                                        $('#rca_DEFAULT').show()
                                            .find('textarea').prop('required', true);
                                    } else if (m === '5WHY') {
                                        $('#rca_5WHY').show()
                                            .find('textarea').prop('required', true);
                                    } else if (m === '5W2H') {
                                        $('#rca_5W2H').show()
                                            .find('textarea').prop('required', true);
                                    }
                                }
                                $('#rca_method').on('change', toggleRCA);
                                toggleRCA(); // initial
                            });
                        })(jQuery);
                    </script>
                    <br>
                    <div class="rca-controls" style="margin-left: 20px;">
                        <label for="rca_method" class="control-label"
                            style="font-size: 16px; margin-left: -21px;">Choose
                            RCA Tool :
                        </label>
                        <select name="rca_method" id="rca_method" class="form-control input-sm">
                            <option value="DEFAULT" name="DEFAULT" selected>DEFAULT</option>
                            <option value="5WHY" name="5WHY">5WHY</option>
                            <option value="5W2H" name="5W2H">5W2H</option>
                        </select>
                    </div>
                    <!-- DEFAULT: single RCA textarea -->
                    <div id="rca_DEFAULT">
                        <div class="col-sm-12" style="margin-bottom:21px;">
                            <br>
                            <textarea class="form-control" style="margin-left: -16px;" rows="5" minlength="15"
                                id="rootcause" name="rootcause"
                                placeholder="Enter the Root Cause Analysis (RCA) for incident closure:"
                                required></textarea>
                        </div>
                    </div>

                    <!-- 5WHY: five textareas -->
                    <div id="rca_5WHY" style="display:none;">
                        <br>
                        <div class="form-group row" style="margin-bottom:8px;">
                            <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 1:</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" name="fivewhy_1"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:8px;">
                            <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 2:</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" name="fivewhy_2"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:8px;">
                            <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 3:</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" name="fivewhy_3"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:8px;">
                            <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 4:</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" name="fivewhy_4"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 5:</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" name="fivewhy_5"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- 5W2H: seven textareas -->
                    <div id="rca_5W2H" style="display:none;">
                        <div class="form-group row">
                            <br>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">What happened?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_1"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">Why did it happen?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_2"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">Where did it happen?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_3"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">When did it happen?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_4"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">Who was involved?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_5"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:8px;">
                                <label style="font-weight:600;">How did it happen?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_6"
                                    placeholder="Your input here"></textarea>
                            </div>

                            <div class="col-sm-12">
                                <label style="font-weight:600;">How much/How many (impact/cost)?</label>
                                <textarea class="form-control" rows="3" name="fivewhy2h_7"
                                    placeholder="Your input here"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="ui buttons">
                                <button class="ui positive button">Submit RCA</button>
                                <input type="hidden" name="status" value="ClosedSave">

                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <?php echo form_hidden('id', $department->id) ?>
            <!-- Existing CAPA & attachments (left as-is) -->


            <!-- Existing CAPA & attachments (left as-is) -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Enter Corrective , Preventive action to close the incident</h3>
                </div>


                <div class="col-sm-12">
                    <div class="form-group " id="correctiveid">
                        <br>
                        <textarea class="form-control" rows="5" minlength="15" id="corrective" name="corrective"
                            placeholder="Enter the Corrective Action for incident closure:" required></textarea>

                        <input type="hidden" name="status" value="Closed">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group " id="correctiveid">

                        <textarea class="form-control" rows="5" minlength="15" id="preventive" name="preventive"
                            placeholder="Enter the Preventive Action for incident closure:" required></textarea>

                        <input type="hidden" name="status" value="Closed">
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Enter Verification comment to close the incident</h3>
                </div>

                <div class="col-sm-12" style="margin-top: 20px;">
                    <div class="form-group " id="correctiveid">
                        <textarea class="form-control" rows="5" id="verification_comment" name="verification_comment"
                            placeholder="Enter the verification and closure remark here" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="picture" class="col-xs-3 col-form-label">Upload supporting file (Max limit
                        10MB)</label><br>
                    <div class="col-sm-12" style="margin-bottom: 20px;">
                        <input type="file" name="picture" id="picture">
                        <input type="hidden" name="old_picture">
                    </div>
                    <br>
                </div>
            </div>






            <div class="form-group row">
                <div class="col-sm-6">
                    <div class="ui buttons">
                        <button class="ui positive button">Submit & Close</button>
                    </div>
                </div>
            </div>

        </div>

        <?php echo form_close() ?>
    </div>
</div>

<div class="col-sm-12" id="move" style="overflow:auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3><?php echo lang_loader('inc', 'inc_transfering_incident_to_category'); ?></h3>
        </div>
        <div class="col-md-12 col-sm-12">
            <br />
            <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
            <?php echo form_hidden('id', $department->id) ?>
            <div class="form-group row">
                <label for="name"
                    class="col-xs-3 col-form-label"><?php echo lang_loader('inc', 'inc_category'); ?></label>
                <div class="col-xs-9">
                    <select class="form-control" id="sel1" name="deparment" required aria-required="true">
                        <?php echo '<option value="">--Change Department--</option>';
                        $this->db->order_by('slug', 'asc');
                        $this->db->where('type', 'incident');
                        $query = $this->db->get('department');
                        $data = $query->result();
                        $result_department = array();
                        foreach ($data as $element) {
                            if (!isset($result_department[$element->description])) {
                                $result_department[$element->description] = $element;
                            }
                        }
                        foreach ($result_department as $r) {
                            if ($department->department->description != $r->description) {
                                echo '<option value="' . $r->dprt_id . '">' . $r->description . '</option>';
                            }
                        } ?> </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="name"
                    class="col-xs-3 col-form-label"><?php echo lang_loader('inc', 'inc_comment'); ?></label>
                <div class="col-xs-9">
                    <textarea class="form-control" rows="5" minlength="15" id="comment" name="reply"
                        placeholder="Enter the reason for incident transfer" required></textarea>
                    <input type="hidden" name="reply_by" value="Admin">
                    <input type="hidden" name="reply_departmen"
                        value="<?php echo $department->department->description; ?>">
                </div>
            </div> <!--Radio-->
            <div class="form-group row">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="ui buttons"> <button
                            class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                    </div>
                </div>
            </div> <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="col-sm-12" id="assign" style="overflow:auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Assign incident to responsible stakeholders</h3>

        </div>
        <div class="col-lg-12 col-md-12">
            <br />
            <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
            <?php echo form_hidden('id', $department->id) ?>
            <?php echo form_hidden('feedbackid', $department->feedbackid) ?>

            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">
                    Select Staff / Users responsible to input RCA/ CAPA
                    <a href="javascript:void()" data-toggle="tooltip"
                        title="Users responsible for documenting the root cause, corrective action, and preventive action for the incident."><i
                            class="fa fa-info-circle" aria-hidden="true"></i></i></a>
                </label>
                <div class="col-xs-9">
                    <input type="text" id="userSearch" class="form-control" placeholder="Search for names..">
                    <div class="checkbox-container" id="userList">
                        <?php foreach ($users as $user): ?>
                        <div class="checkbox">
                            <input type="checkbox"
                                id="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                name="users[]"
                                value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                            <label for="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">Select Process monitors to monitor
                    incident
                    <a href="javascript:void()" data-toggle="tooltip"
                        title="Users assigned to monitor the incident and add notes or comments as required."><i
                            class="fa fa-info-circle" aria-hidden="true"></i></i></a>
                </label>
                <div class="col-xs-9">
                    <input type="text" id="userSearch" class="form-control" placeholder="Search for names..">
                    <div class="checkbox-container" id="userList">
                        <?php foreach ($users as $user): ?>
                        <div class="checkbox">
                            <input type="checkbox"
                                id="user_for_process_monitor<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                name="users_for_process_monitor[]"
                                value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                            <label
                                for="user_for_process_monitor<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">Additional Notes</label>
                <div class="col-xs-9">
                    <textarea class="form-control" rows="5" id="comment" name="reply"
                        placeholder="Your inputs here"></textarea>
                    <input type="hidden" name="status" value="Assigned">

                </div>
            </div> <!--Radio-->
            <div class="form-group row">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="ui buttons"> <button
                            class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
                    </div>
                </div>
            </div> <?php echo form_close() ?>
        </div>
    </div>
</div>

<div class="col-sm-12" id="reassign" style="overflow:auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Re-assign incident to respective users</h3>

        </div>
        <div class="col-lg-12 col-md-12">
            <br />
            <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
            <?php echo form_hidden('id', $department->id) ?>
            <?php echo form_hidden('feedbackid', $department->feedbackid) ?>



            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">Select Team Leader to input RCA/ CAPA</label>
                <div class="col-xs-9">
                    <input type="text" id="userSearch_reassign" class="form-control" placeholder="Search for names..">
                    <div class="checkbox-container" id="userList_reassign">
                        <?php foreach ($users as $user): ?>
                        <div class="checkbox">
                            <input type="checkbox"
                                id="user_reassign_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                name="users_reassign[]"
                                value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                            <label
                                for="user_reassign_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">Select Process monitors to monitor
                    incident</label>
                <div class="col-xs-9">
                    <input type="text" id="userSearch_reassign" class="form-control" placeholder="Search for names..">
                    <div class="checkbox-container" id="userList">
                        <?php foreach ($users as $user): ?>
                        <div class="checkbox">
                            <input type="checkbox"
                                id="user_reassign_for_process_monitor<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                name="users_reassign_for_process_monitor[]"
                                value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                            <label
                                for="user_reassign_for_process_monitor<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label">Additional Notes</label>
                <div class="col-xs-9">
                    <textarea class="form-control" rows="5" id="comment" name="reply"
                        placeholder="Your inputs here"></textarea>
                    <input type="hidden" name="status" value="Re-assigned">

                </div>
            </div> <!--Radio-->
            <div class="form-group row">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="ui buttons"> <button
                            class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
                    </div>
                </div>
            </div> <?php echo form_close() ?>
        </div>
    </div>
</div>

<div class="col-sm-12" id="describe" style="overflow:auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Explain the Incident in detail with RCA and CAPA: </h3>
        </div>
        <div class="col-sm-12" style="overflow:auto;">
            <!-- <div class="col-md-12 col-sm-12"> -->

            <?php echo form_open('ticketsincident/create', array('class' => 'form-inner', 'enctype' => 'multipart/form-data')); ?>
            <?php echo form_hidden('id', $department->id) ?>
            <?php echo form_hidden('feedbackid', $department->feedbackid) ?>

            <div class="form-group row">
                <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                <!-- <div class="col-xs-9"> -->
                <input type="hidden" name="describe" <?php if ($department->addressed == 1) {
                    echo 'checked disabled';
                } ?>>
                <!-- </div> -->
            </div>
            <!-- <p style="font-weight: bold;font-size:15px;">Incident description submitted in the form:</p>

                <div class="col-sm-12">
                    <div class="form-group row">
                        <p style="font-size: 14px;">
                            <?php
                            echo isset($comm) && !empty($comm) ? $comm : 'No description was received';

                            ?>
                        </p>
                    </div>
                </div> -->
            <div class="col-sm-12" style="overflow:auto;">

                <script>
                    function showbox() {
                        $('#correctiveid').show();
                        $("#corrective").attr("required", "true");
                    }

                    function hidebox() {
                        $('#correctiveid').hide();
                        $("#corrective").removeAttr("required");
                    }

                    // RCA method toggle
                    (function ($) {
                        $(function () {
                            function toggleRCA() {
                                var m = $('#rca_method_describe').val();
                                // Hide all & remove required
                                $('#rca_DEFAULT_describe, #rca_5WHY_describe, #rca_5W2H_describe').hide()
                                    .find('textarea, input').prop('required', false);

                                if (m === 'DEFAULT') {
                                    $('#rca_DEFAULT_describe').show()
                                        .find('textarea').prop('required', true);
                                } else if (m === '5WHY') {
                                    $('#rca_5WHY_describe').show()
                                        .find('textarea').prop('required', true);
                                } else if (m === '5W2H') {
                                    $('#rca_5W2H_describe').show()
                                        .find('textarea').prop('required', true);
                                }
                            }
                            $('#rca_method_describe').on('change', toggleRCA);
                            toggleRCA(); // initial
                        });
                    })(jQuery);
                </script>
                <br>
                <div class="rca-controls" style="margin-left: -10px;">
                    <label for="rca_method_describe" class="control-label" style="font-size: 16px;">Choose RCA Tool
                        :
                    </label>
                    <select name="rca_method_describe" id="rca_method_describe" class="form-control input-sm">
                        <option value="DEFAULT" name="DEFAULT" selected>DEFAULT</option>
                        <option value="5WHY" name="5WHY">5WHY</option>
                        <option value="5W2H" name="5W2H">5W2H</option>
                    </select>
                </div>
                <!-- DEFAULT: single RCA textarea -->
                <div id="rca_DEFAULT_describe">
                    <div class="col-sm-12" style="margin-bottom:30px;margin-left:-25px;">
                        <br>
                        <textarea class="form-control" rows="5" minlength="15" id="rootcause_describe"
                            name="rootcause_describe"
                            placeholder="Enter the Root Cause Analysis (RCA) for incident closure:" required></textarea>
                    </div>
                </div>

                <!-- 5WHY: five textareas -->
                <div id="rca_5WHY_describe" style="display:none;">
                    <br>
                    <div class="form-group row" style="margin-bottom:8px;">
                        <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 1:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" name="fivewhy_1_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:8px;">
                        <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 2:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" name="fivewhy_2_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:8px;">
                        <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 3:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" name="fivewhy_3_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:8px;">
                        <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 4:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" name="fivewhy_4_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label" style="font-weight:600;">WHY 5:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" name="fivewhy_5_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>

                </div>

                <!-- 5W2H: seven textareas -->
                <div id="rca_5W2H_describe" style="display:none;">
                    <div class="form-group row">
                        <br>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">What happened?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_1_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">Why did it happen?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_2_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">Where did it happen?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_3_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">When did it happen?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_4_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">Who was involved?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_5_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12" style="margin-bottom:8px;">
                            <label style="font-weight:600;">How did it happen?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_6_describe"
                                placeholder="Your input here"></textarea>
                        </div>

                        <div class="col-sm-12">
                            <label style="font-weight:600;">How much/How many (impact/cost)?</label>
                            <textarea class="form-control" rows="3" name="fivewhy2h_7_describe"
                                placeholder="Your input here"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Enter the Corrective Actions, Preventive Measures and Lesson Learned to describe the incident.
            </h3>
        </div>


        <div class="col-sm-12">
            <div class="form-group " id="correctiveid">
                <br>
                <textarea class="form-control" rows="5" minlength="15" id="corrective_describe"
                    name="corrective_describe" placeholder="Enter the Corrective Action" required></textarea>

            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group " id="correctiveid">

                <textarea class="form-control" rows="5" minlength="15" id="preventive_describe"
                    name="preventive_describe" placeholder="Enter the Preventive Action" required></textarea>

                <input type="hidden" name="status" value="Described">
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group " id="correctiveid">
                <textarea class="form-control" rows="5" id="verification_comment_describe"
                    name="verification_comment_describe" placeholder="Additional Notes / Lesson learned"
                    required></textarea>
            </div>
        </div>

        <div class="col-sm-12">
            <label for="describe_picture" class="col-xs-3 col-form-label">Upload supporting file (Max limit
                10MB)</label><br>
            <div class="col-sm-12">
                <input type="file" name="describe_picture" id="describe_picture">
            </div>
        </div>




        <div class="form-group row">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="ui buttons">
                    <button class="ui positive button"><?php echo lang_loader('inc', 'inc_submit'); ?></button>
                </div>
            </div>
        </div>
    </div>


    <?php echo form_close() ?>
</div>
<!-- </div> -->
</div>
</div>

<?php } ?>


<?php } ?>
<?php } ?>



<hr>
<?php // include 'feed.php';
?>
<?php if ($this->session->userdata('isLogIn') == true) { ?>
<?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Addressed' || $department->status == 'Transfered' || $department->status == 'Rejected' || $department->status == 'Assigned' || $department->status == 'Described' || $department->status == 'Verified' || $department->status == 'Re-assigned') { ?>
<?php include 'ticket_convo.php'; ?>

<?php } ?>
<?php } ?>

</div>



</div>


<style>
    .checkbox-container {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }

    .checkbox input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 1px solid #ccc;
        width: 20px;
        height: 20px;
        border-radius: 3px;
        display: inline-block;
        position: relative;
        margin-right: 10px;
        cursor: pointer;
        vertical-align: middle;
    }

    .checkbox input[type="checkbox"]:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .checkbox input[type="checkbox"]:checked::before {
        content: '\2714';
        /* Check mark symbol */
        font-size: 16px;
        color: #fff;
        /* White color for check mark */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .checkbox input[type="checkbox"]::before {
        content: '';
        display: block;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 3px;
        background-color: #fff;
        border: 1px solid #ccc;
    }

    .checkbox input[type="checkbox"]:checked::after {
        content: '\2714';
        /* Check mark symbol */
        font-size: 16px;
        color: #fff;
        /* White color for check mark */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .checkbox label {
        cursor: pointer;
        position: relative;
        padding-left: 5px;
        /* Space for check mark */
        vertical-align: middle;
    }

    /* only affects this header */
    .rca-heading {
        display: flex;
        align-items: center;
        /* vertical center */
        justify-content: space-between;
        gap: 12px;
        /* space between title and controls */
    }

    /* keep label+select on one line */
    .rca-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .rca-controls select {
        width: auto;
        /* don't stretch full width */
        min-width: 120px;
    }
</style>
<script>
    document.getElementById('userSearch').addEventListener('keyup', function () {
        var filter = this.value.toLowerCase();
        var checkboxes = document.getElementById('userList').getElementsByClassName('checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            var label = checkboxes[i].getElementsByTagName('label')[0];
            var text = label.textContent || label.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = '';
            } else {
                checkboxes[i].style.display = 'none';
            }
        }
    });
</script>
<script>
    document.getElementById('userSearch_reassign').addEventListener('keyup', function () {
        var filter = this.value.toLowerCase();
        var checkboxes = document.getElementById('userList_reassign').getElementsByClassName('checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            var label = checkboxes[i].getElementsByTagName('label')[0];
            var text = label.textContent || label.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = '';
            } else {
                checkboxes[i].style.display = 'none';
            }
        }
    });
</script>