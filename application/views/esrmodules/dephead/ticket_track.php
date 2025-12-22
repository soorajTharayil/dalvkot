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
            $query = $this->db->get('bf_feedback_esr');
            $result = $query->result();
            $feedback = $result[0];
            $param = json_decode($feedback->dataset, true);
            $this->db->order_by('id');
            // print_r($param);
            $this->db->where('title', $departments[0]->department->description);
            $query = $this->db->get('setup_esr');

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


            // echo '<pre>';
            // print_r($param);
            // echo '</pre>';
            // exit;
            
            ?>


            <?php $department = $departments[0]; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip"
                            title="INTERNAL SERVICE REQUEST- <REQUEST ID>  ">
                            <i class="fa fa-question-circle"
                                aria-hidden="true"></i></a>&nbsp;ISR-<?php echo $department->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">

                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td> <strong><?php echo lang_loader('isr', 'isr_service_request_details'); ?></strong> </td>
                            <td><?php echo lang_loader('isr', 'isr_category') . ':'; ?>
                                <?php echo $department->department->description; ?>
                                <br>
                                <?php
                                // print_r($reasons);
                                if ($param['reason']) { ?>
                                    <?php echo 'Service request : '; ?>

                                    <?php foreach ($param['reason'] as $key => $value) { ?>
                                        <?php if ($value === true) {
                                            $this->db->where('shortkey', $key);
                                            $query = $this->db->get('setup_esr');
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
                                    <span style="overflow: clip; word-break: break-all;">

                                        <br>
                                        <?php echo 'Description : '; ?>
                                        <?php echo '"' . $comm . '"'; ?>.
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        if (!empty($param['images'])) {
                            // Convert to array if single image (backward compatible)
                            $images = is_array($param['images']) ? $param['images'] : [$param['images']];
                            $validImages = array_filter($images);

                            if (!empty($validImages)) { ?>
                                <tr>
                                    <td><strong><?php echo lang_loader('isr', 'isr_attached_image'); ?></strong></td>
                                    <td>
                                        <?php foreach ($validImages as $index => $encodedImage) {
                                            // Generate unique filename based on current timestamp and index
                                            $filename = 'attachment_' . time() . '_' . ($index + 1) . '.jpg';
                                            ?>
                                            <div style="margin-bottom: 8px; display: block;">
                                                <a href="javascript:void(0);"
                                                    onclick="previewImage('<?php echo $encodedImage; ?>', '<?php echo $filename; ?>')"
                                                    style="color: #337ab7; text-decoration: none; display: inline-block;">
                                                    <i class="fa fa-file-image-o" style="margin-right: 5px;"></i>
                                                    <?php echo $filename; ?>
                                                </a>
                                                <span style="color: #777; margin-left: 5px;">
                                                    (<?php echo round(strlen($encodedImage) / 1024, 1); ?> KB)
                                                </span>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
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

                        <?php
                        if (isset($param['files']) && is_array($param['files']) && count($param['files']) > 0) { ?>
                        <tr>
                            <td>Attached Files</td>
                            <td>
                                <ul>
                                    <?php foreach ($param['files'] as $file) {
                                        $fileUrl = htmlspecialchars($file['url']);  // Ensure safe output
                                        $fileName = htmlspecialchars($file['name']); ?>
                                    <li><a href="<?= $fileUrl ?>" download="<?= $fileName ?>"><?= $fileName ?></a></li>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <?php if ($param['priority'] != '' || $param['priority']) { ?>
                            <td>
                                <strong><?php echo lang_loader('isr', 'isr_priority'); ?></strong>
                            </td>
                            <td>
                                <?php if ($param['priority'] == 'Medium') {
                                    //warning
                                    $color = '#f0ad4e';
                                }
                                if ($param['priority'] == 'High') {
                                    //danger
                                    $color = '#d9534f';
                                }
                                if ($param['priority'] == 'Low') {
                                    //info
                                    $color = '#5bc0de';
                                }

                                ?>
                                <span style="color: <?php echo $color; ?>;">
                                    <strong> <?php echo $param['priority']; ?></strong>
                                </span>
                            </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_requests_reported_in'); ?></strong></td>
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



                        <?php $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
                        ?>
                        <?php if ($param['tag_patient_type'] && $param['tag_patientid'] && $param['tag_name'] && $param['tag_consultant']) { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_patient_details'); ?></strong></td>
                            <td>
                                <?php echo lang_loader('isr', 'isr_patient_type'); ?>
                                <?php echo $param['tag_patient_type']; ?> <br>
                                <?php echo lang_loader('isr', 'isr_patient_id'); ?>
                                <?php echo $param['tag_patientid']; ?> <br>
                                <?php echo lang_loader('isr', 'isr_patient_name'); ?> <?php echo $param['tag_name']; ?>
                                <br>
                                <?php echo lang_loader('isr', 'isr_primary_consultant'); ?>
                                <?php echo $param['tag_consultant']; ?> <br>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_request_reported_by'); ?></strong></td>
                            <td>
                                <?php echo $param['name']; ?>
                                (<a
                                    href="<?php echo $ip_link_patient_feedback . $department->id; ?>"><?php echo $param['patientid']; ?></a>)

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
                            <?php if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) { ?>

                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_incident_assigned_to'); ?></strong></td>
                            <td><?php echo implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]); ?>
                            </td>

                        </tr>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_reported_on'); ?></strong></td>
                            <td><?php echo date('g:i A, d-m-y', strtotime($department->created_on)); ?></td>
                        </tr>
                        <?php if (!empty($param['assetcode']) || !empty($param['assetname']) || !empty($param['depart']) || !empty($param['assignee']) || !empty($param['locationsite']) || !empty($param['bedsite'])): ?>
                        <tr>
                            <td><strong>Asset Details</strong></td>
                            <td>
                                <?php echo 'Asset Code: ' . htmlspecialchars($param['assetcode']); ?><br>
                                <?php echo 'Asset Name: ' . htmlspecialchars($param['assetname']); ?><br>
                                <?php echo 'Allocated Department: ' . htmlspecialchars($param['depart']); ?><br>
                                <?php echo 'Allocated User: ' . htmlspecialchars($param['assignee']); ?><br>
                                <?php echo 'Floor/ Area: ' . htmlspecialchars($param['locationsite']); ?><br>
                                <?php echo 'Site: ' . htmlspecialchars($param['bedsite']); ?><br>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if (isr_tat('department_link') === true) { ?>
                        <?php if ($department->status != 'Closed' && $department->status != 'Reopen') { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_tat_status'); ?></strong></td>
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
                            <td><strong><?php echo lang_loader('isr', 'isr_request_status'); ?></strong> </td>
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
                                <?php echo 'Pending'; ?>
                                <?php } ?>
                                <?php } ?>
                                <?php if ($this->session->userdata['isLogIn'] == true) { ?>
                                <?php //if (($this->session->userdata['user_role'] == 4 && $this->session->userdata['email'] == $department->department->email) || $this->session->userdata['user_role'] <= 3) { 
                                    ?>
                                <select class="form-control" onchange="ticket_options(this.value)"
                                    style="max-width: 300px;" required>
                                    <option value="<?php echo $department->status; ?>" selected>
                                        <?php echo $department->status; ?></option>
                                    <?php if ($department->status != 'Assigned' && $department->status != 'Rejected') { ?>
                                    <?php if (ismodule_active('ISR') === true && isfeature_active('ISR-ASSIGNED-REQUEST') === true) { ?>
                                    <option value="assignuser">Assign</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if ($department->status != 'Rejected' && $department->status != 'Assigned') { ?>
                                    <?php if (ismodule_active('ISR') === true && isfeature_active('ISR-REJECTED-REQUEST') === true) { ?>

                                    <option value="reject">Reject</option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if ($department->status != 'Closed') {
                                        $open = true; ?>

                                    <?php if (ismodule_active('ISR') === true && isfeature_active('ADDRESSED-REQUESTS') === true) { ?>



                                    <option value="address"><?php echo lang_loader('isr', 'isr_address'); ?></option>

                                    <?php } ?>

                                    <?php if (ismodule_active('ISR') === true && isfeature_active('CLOSING-REQUESTS') === true) { ?>
                                    <?php if ($department->status != 'Rejected') { ?>
                                    <option value="capa"><?php echo lang_loader('isr', 'isr_close'); ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                    <!-- <?php if (ismodule_active('ISR') === true && isfeature_active('ISR-TRANSFER-REQUESTS') === true) { ?>
                                            <option value="movetick"><?php echo lang_loader('isr', 'isr_transfer'); ?></option>
                                        <?php } ?> -->


                                    <?php } ?>
                                    <!-- check login if not 4 -->
                                    <!-- check if ticket is closed -->
                                    <?php if (isfeature_active('ISR-REQUESTS-DASHBOARD') === true) {

                                        $closed = true; ?>
                                    <?php if ($department->status == 'Closed' || $department->status == 'Rejected') { ?>

                                    <?php if (ismodule_active('ISR') === true && isfeature_active('ISR-REOPEN-REQUESTS') === true) { ?>
                                    <option value="reopen"><?php echo lang_loader('isr', 'isr_reopen'); ?></option>


                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <span> <i class="fa fa-hand-o-left" aria-hidden="true"
                                        style="font-size: 20px; padding-left: 50px;"></i></span>
                                <span style="padding-left: 10px;">Take action here</span>

                                <?php } ?>
                                <?php //} 
                                ?>
                            </td>
                        </tr>
                        <?php if ($department->last_modified > $department->created_on) { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_last_updated_on'); ?></strong> </td>
                            <td><?php echo date('g:i A, d-m-y', strtotime($department->last_modified)); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (isr_tat('department_link') === true) { ?>
                        <?php if ($department->status == 'Closed') { ?>
                        <tr>
                            <td><strong><?php echo lang_loader('isr', 'isr_turn_around_time'); ?></strong> </td>
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


        <?php if (isfeature_active('ISR-REQUESTS-DASHBOARD') === true && ($department->status == 'Closed')) {

            if ($closed == true) { ?>


        <?php if (($department->status != 'Open')) { ?>
        <div class="col-sm-12" id="reopen" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><?php echo lang_loader('isr', 'isr_reopen_this_request'); ?></h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsesr/create', 'class="form-inner"') ?>
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
                                    class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
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
                    <h3><?php echo lang_loader('isr', 'isr_address_this_request'); ?> </h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsesr/create', 'class="form-inner"') ?>
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
                                    class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
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
                    <h3>Enter the reason for rejecting this request </h3>
                </div>
                <div class="col-sm-12" style="overflow:auto;">
                    <!-- <div class="col-md-12 col-sm-12"> -->
                    <br />
                    <?php echo form_open('ticketsesr/create', 'class="form-inner"') ?>
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
                                    class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="col-sm-12" id="capa" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Enter resolution comment to close the request</h3>

                </div>
                <?php echo form_open_multipart('ticketsesr/create', 'class="form-inner"') ?>
                <?php echo form_hidden('id', $department->id) ?>
                <div class="col-sm-12" style="overflow:auto;">
                    <script>
                        function showbox() {
                            //$('#preventiveid').show();
                            $('#correctiveid').show();
                            //$("#preventive").attr("required", "true");
                            $("#corrective").attr("required", "true");
                        }

                        function hidebox() {
                            //$('#preventiveid').hide();
                            $('#correctiveid').hide();
                            //$("#preventive").removeAttr("required");
                            $("#corrective").removeAttr("required");
                        }
                    </script>
                    <div class="form-group row" style="display:none;">
                        <label class="col-sm-3"><?php echo display('status') ?></label>
                        <div class="col-xs-9">
                            <div class="form-check">
                                <label class="radio-inline"><input type="radio" name="status" value="Open"
                                        onclick="hidebox()"><?php echo lang_loader('isr', 'isr_open'); ?></label>
                                <label class="radio-inline"><input type="radio" name="status" value="Closed"
                                        onclick="showbox()"
                                        checked="true"><?php echo lang_loader('isr', 'isr_close'); ?></label>
                            </div>
                        </div>
                    </div>
                    <br>


                    <!-- <h3>Writing CAPA to close this ticket:<i class="text-danger">*</i></h3> -->
                    <!-- <div class="col-sm-12">
                                    <div class="form-group row">
                                        <textarea class="form-control" rows="5" minlength="15" id="rootcause" name="rootcause" placeholder="Enter the Root Cause Analysis( RCA)" required></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row" id="correctiveid">
                                        <textarea class="form-control" rows="5" minlength="15" id="corrective" name="corrective" placeholder="Enter CAPA(Corrective Action and Preventive Action)" required></textarea>
                                        <input type="hidden" name="preventive">
                                    </div>
                                </div> -->

                    <!-- <div class="col-sm-12">
                                    <div class="form-group row" id="correctiveid">
                                        <textarea class="form-control" rows="5" id="preventive" name="preventive" placeholder="Enter the Preventive Action and Measures" required></textarea>
                                    </div>
                                </div> -->
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <textarea class="form-control" rows="5" minlength="15" id="note" name="resolution_note"
                                placeholder="Enter your resolution comment (visible to the user who raised the issue)"
                                required></textarea>
                            <input type="hidden" name="rootcause">
                            <input type="hidden" name="corrective">
                            <input type="hidden" name="preventive">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="picture" class="col-xs-3 col-form-label">Upload supporting file</label><br>
                        <div class="col-sm-12">
                            <input type="file" name="picture" id="picture">
                            <input type="hidden" name="old_picture">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="ui buttons">
                            <!-- <button type="reset" class="ui button">
                                        <?php // echo 'Reset' ; 
                                                    ?></button>
                                    <div class="or"></div> -->
                            <button class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
        <div class="col-sm-12" id="move" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><?php echo lang_loader('isr', 'isr_transfering_request_to_category'); ?></h3>
                </div>
                <div class="col-md-12 col-sm-12">
                    <br />
                    <?php echo form_open('ticketsesr/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>
                    <div class="form-group row">
                        <label for="name"
                            class="col-xs-3 col-form-label"><?php echo lang_loader('isr', 'isr_category'); ?></label>
                        <div class="col-xs-9">
                            <select class="form-control" id="sel1" name="deparment" required aria-required="true">
                                <?php echo '<option value="">--Change Department--</option>';
                                $this->db->order_by('slug', 'asc');
                                $this->db->where('type', 'esr');
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
                            class="col-xs-3 col-form-label"><?php echo lang_loader('isr', 'isr_comment'); ?></label>
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
                                    class="ui positive button"><?php echo lang_loader('isr', 'isr_submit'); ?></button>
                            </div>
                        </div>
                    </div> <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12" id="assign" style="overflow:auto;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Assign request to respective users</h3>

                </div>
                <div class="col-lg-12 col-md-12">
                    <br />
                    <?php echo form_open('ticketsesr/create', 'class="form-inner"') ?>
                    <?php echo form_hidden('id', $department->id) ?>

                    <div class="form-group row">
                        <label for="name" class="col-xs-3 col-form-label">Select users from the list</label>
                        <div class="col-xs-9">
                            <input type="text" id="userSearch" class="form-control" placeholder="Search for names..">
                            <div class="checkbox-container" id="userList">
                                <?php foreach ($users as $user): ?>
                                <div class="checkbox">
                                    <input type="checkbox"
                                        id="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                        name="users[]"
                                        value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>"
                                        checked>
                                    <label
                                        for="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
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

        <?php } ?>


        <?php } ?>
        <?php } ?>



        <hr>
        <?php // include 'feed.php';
        ?>
        <?php if ($this->session->userdata('isLogIn') == true) { ?>
        <?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Addressed' || $department->status == 'Transfered' || $department->status == 'Rejected' || $department->status == 'Assigned') { ?>
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