<div class="content">
    <?php
    // individual patient feedback link
    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');
    $this->db->select("*");
    $this->db->from('setup_int');
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
                            <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('pcf', 'pcf_download_all_complaint_report'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
                                <i class="fa fa-file-text"></i>
                            </a>
                        </div>
                    </div>


                    <div class="panel-body">


                        <table class="pcticketsall table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo lang_loader('pcf', 'pcf_slno'); ?></th>
                                    <th><?php echo lang_loader('ip', 'ip_date'); ?></th>

                                    <th style="white-space: nowrap;"><?php echo lang_loader('pcf', 'pcf_complaint_id'); ?></th>
                                    <th style="white-space: nowrap;"><?php echo lang_loader('pcf', 'pcf_patient_details'); ?></th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($departments)) {        ?>
                                    <?php $sl = 1; ?>
                                    <?php foreach ($departments as $department) {
                                        // print_r($department);
                                        $data = json_decode($department->dataset, true);
                                        // print_r($data['name']);

                                        // exit;
                                        if ($department->status == 'Addressed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $addressed_comm = $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . '  addressed the ticket with , ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Transfered') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $trans_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Reopen') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $reopen_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Closed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
                                            $query = $this->db->get('ticket_int_message');
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
                                            <td style="white-space: nowrap;">
                                                <?php if ($department->datetime) { ?>
                                                    <?php echo date('g:i A', strtotime($department->datetime)); ?>
                                                    <br>
                                                    <?php echo date('d-m-y', strtotime($department->datetime)); ?>
                                                <?php } ?>
                                            </td>
                                            <td>PCT-<?php echo $department->id; ?></td>
                                            <td style="overflow: clip; word-break: break-all;"><?php echo $data['name']; ?>&nbsp;(<?php echo $data['patientid'] ?>)
                                                <br>
                                                <?php echo $data['ward']; ?>
                                                <?php if ($data['bedno']) { ?>
                                                    <?php echo 'in ' . $data['bedno']; ?>
                                                <?php } ?>
                                                <br>

                                            </td>



                                            <?php
                                            if ($department->status == 'Addressed') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'warning';
                                            } elseif ($department->status == 'Open') {
                                                $tool = 'Click to change the status.';
                                                $color = 'danger';
                                            } elseif ($department->status == 'Closed') {
                                                $tool = 'Ticket is closed';
                                                $color = 'success';
                                            } elseif ($department->status == 'Reopen') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'primary';
                                            } elseif ($department->status == 'Transfered') {
                                                $tool = 'Click to close this ticket.';
                                                $color = 'info';
                                            } else {
                                                $color = 'info';
                                            }



                                            ?>
                                            <?php if (ismodule_active('PCF') === true  && isfeature_active('OPEN-COMPLAINTS') === true) { ?>
                                                <td style="display: flex; align-items: center; gap: 10px;">
                                                    <a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>"
                                                        data-placement="bottom"
                                                        data-toggle="tooltip"
                                                        title="<?php echo $tool; ?>"
                                                        class="btn btn-sm btn-<?php echo $color; ?>">
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

                        <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf', 'pcf_no_record_found'); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
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