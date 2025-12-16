<div class="content">
    <?php
    // individual patient feedback link
    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
    $this->db->select("*");
    $this->db->from('setup_esr');
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
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('isr', 'isr_download_all_request_report'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
                                <i class="fa fa-file-text"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                    <?php   if (isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>
                            <form>
                                <p>
                                    <!-- <span style="font-size:15px; font-weight:bold;">Sort Requests By : </span> -->
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
                                        <option value="1" selected><?php echo lang_loader('isr', 'isr_select_category'); ?></option>
                                        <?php
                                        $this->db->group_by('description');
                                        $this->db->where('type', 'esr');
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
                                            <option value="1" selected><?php echo lang_loader('isr', 'isr_select_service_request'); ?></option>
                                            <?php
                                            $this->db->where('type', 'esr');
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
                                </p>
                            </form>
                            <br />
                        <?php } ?>

                        <table class="esrticketsall table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo lang_loader('isr', 'isr_slno'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('isr', 'isr_requests_id'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('isr', 'isr_request_reported_by'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('isr', 'isr_service_request'); ?></th>
                                    <?php   if (isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>
                                        <th><?php echo lang_loader('isr', 'isr_category'); ?></th>
                                    <?php } ?>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('isr', 'isr_reported_on'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('isr', 'isr_modified_on'); ?></th>
                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('OPEN-REQUESTS') === true) { ?>
                                        <th style="text-align: center;"><?php echo display('action') ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($departments)) {        ?>
                                    <?php $sl = 1; ?>
                                    <?php foreach ($departments as $department) {
                                        if ($department->status == 'Addressed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
                                            $query = $this->db->get('ticket_esr_message');
                                            $ticket = $query->result();
                                            $addressed_comm = $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . '  addressed the ticket with , ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Transfered') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
                                            $query = $this->db->get('ticket_esr_message');
                                            $ticket = $query->result();
                                            $trans_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Reopen') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
                                            $query = $this->db->get('ticket_esr_message');
                                            $ticket = $query->result();
                                            $reopen_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Closed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
                                            $query = $this->db->get('ticket_esr_message');
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
                                            <td><a href="<?php echo $ip_link_patient_feedback . $department->id; ?>"><?php echo lang_loader('isr', 'isr_isr'); ?><?php echo $department->id; ?></a></td>
                                            <td style="overflow: clip; word-break: break-all;"><?php echo $department->feed->name; ?>&nbsp;(<?php echo $department->feed->patientid; ?>)
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
                                                                    $show = $res[$key];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                // print_r($show);
                                                ?>
                                            </td>
                                            <?php   if (isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>
                                                <td><?php echo $department->department->description; ?>
                                                    <br>
                                                    <?php echo $department->department->pname; ?>
                                                </td>
                                            <?php } ?>
                                            <td style="overflow: clip; word-break: break-all;">
                                                <?php echo date('g:i A', strtotime($department->created_on)); ?>
                                                <br>
                                                <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                            </td>

                                            <td style="overflow: clip; word-break: break-all;">
                                                <?php echo date('g:i A', strtotime($department->last_modified)); ?>
                                                <br>
                                                <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                            </td>
                                            <?php
                                            // Set default values for $tool and $color
                                            $tool = '';
                                            $color = 'btn-info'; // Default to a Bootstrap class if status doesn't match

                                            // Determine the tooltip and color based on the department status
                                            if ($department->status == 'Addressed') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-warning';
                                            } elseif ($department->status == 'Open') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-danger';
                                            } elseif ($department->status == 'Rejected') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-yellow'; // Changed color to btn-yellow for Rejected
                                            } elseif ($department->status == 'Closed') {
                                                $tool = 'Ticket is closed';
                                                $color = 'btn-success';
                                            } elseif ($department->status == 'Reopen') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-primary';
                                            } elseif ($department->status == 'Transfered') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'btn-info';
                                            } elseif ($department->status == 'Assigned') {
                                                $tool = 'Click to change the status.';
                                                $color = 'btn-orange'; // Added this condition for Assigned
                                            } else {
                                                $tool = 'Unknown status';
                                                $color = 'btn-info';
                                            }
                                            ?>

                                            <?php if (ismodule_active('ISR') === true && isfeature_active('TOTAL-REQUESTS') === true) { ?>
                                                <td style="display: flex; align-items: center; gap: 10px;">
												<a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>"
													data-placement="bottom"
													data-toggle="tooltip"
                                                    title="<?php echo $tool; ?>"  class="btn btn-sm <?php echo $color; ?>">
													<?php echo $department->status; ?>
													<i style="font-size: x-small;" class="fa fa-edit"></i>
												</a>
												<?php if ($department->status == 'Closed' && $department->patient_verified_status == 1) { ?>
													<span
														style="font-size: 20px; color: green; cursor: pointer;"
														data-toggle="tooltip"
														data-placement="bottom"
														title="Concern has been verified by the patient">
														✔️
													</span>
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

                        <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('isr', 'isr_no_record_found'); ?>
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

.btn-yellow {
    background-color: #fbbc05;
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
</script>