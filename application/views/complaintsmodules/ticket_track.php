<?php


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

?>

<div class="content">
    <div class="row">

        <div class="col-lg-12">
            <?php

            // print_r($departments);
            $this->db->where('id', $departments[0]->feedbackid);
            $query = $this->db->get('bf_feedback_int');
            $result = $query->result();
            $feedback = $result[0];
            $param = json_decode($feedback->dataset, true);
            $this->db->order_by('id');
            // print_r($param);
            $this->db->where('title', $departments[0]->department->description);
            $query = $this->db->get('setup_int');

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


            <?php $department = $departments[0]; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip"
                            title="PATIENT COMPLAINT TICKET- <COMPLAINT ID> ">
                            <i class="fa fa-question-circle"
                                aria-hidden="true"></i></a>&nbsp;PCT-<?php echo $department->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">

                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td><strong><?php echo lang_loader('pcf', 'pcf_patient_details'); ?></strong></td>
                            <td>
                                <b> <?php echo $param['name']; ?></b>
                                (<?php echo $param['patientid']; ?>)
                                <br>
                                <?php if ($param['bedno'] != '-') { ?>
                                    <?php echo 'From '; ?>
                                    <?php echo $param['bedno']; ?>
                                <?php } ?>
                                <?php if ($param['ward'] != '') { ?>
                                    <?php echo 'in '; ?>
                                    <?php echo ($param['ward']); ?>

                                <?php } ?>
                                <br>
                                <?php if ($param['contactnumber'] != '') { ?>
                                    <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
                                <?php } ?>
                            </td>
                        <tr>
                            <td> <strong><?php echo lang_loader('pcf', 'pcf_complaint_details'); ?></strong> </td>
                            <td>
                                <strong> <?php echo $department->department->description; ?></strong>
                                <br>
                                <?php
                                // print_r($reasons);
                                if ($param['reason']) { ?>
                                    <?php echo 'Concern : '; ?>

                                    <?php foreach ($param['reason'] as $key => $value) { ?>
                                        <?php if ($value === true) {
                                            // print_r($key);
                                
                                            $this->db->where('shortkey', $key);
                                            //$this->db->where('parent', 0);
                                            $query = $this->db->get('setup_int');
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
                                        <?php echo 'Comment : '; ?>
                                        <?php echo '"' . $comm . '"'; ?>.
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if (!empty($department_users[$department->department->type][$department->department->setkey][$department->department->slug])) { ?>

                            <tr>
                                <td><strong><?php echo lang_loader('pcf', 'pcf_assigned_to'); ?></strong></td>
                                <td><?php echo implode(',', $department_users[$department->department->type][$department->department->setkey][$department->department->slug]); ?>
                                </td>

                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo lang_loader('pcf', 'pcf_created_on'); ?></strong></td>
                            <td><?php echo date('g:i A, d-m-y', strtotime($department->created_on)); ?></td>
                        </tr>

                        <?php if (int_tat('department_link') === true) { ?>
                            <?php if ($department->status != 'Closed' && $department->status != 'Reopen') { ?>
                                <tr>

                                    <td><strong><?php echo lang_loader('pcf', 'pcf_tat_status'); ?></strong></td>
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
                            <td><strong><?php echo lang_loader('pcf', 'pcf_complaint_status'); ?></strong> </td>
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
                                <?php } ?>
                                <?php if ($this->session->userdata['isLogIn'] == true) { ?>
                                    <?php //if (($this->session->userdata['user_role'] == 4 && $this->session->userdata['email'] == $department->department->email) || $this->session->userdata['user_role'] <= 3) { 
                                        ?>
                                    <select class="form-control" onchange="ticket_options(this.value)"
                                        style="max-width: 300px;" required>
                                        <option value="<?php echo $department->status; ?>" selected>
                                            <?php echo $department->status; ?></option>
                                        <?php if ($department->status != 'Closed') {
                                            $open = true; ?>



                                            <?php if ($department->addressed != 1) { ?>
                                                <?php if (ismodule_active('PCF') === true && isfeature_active('ADDRESSED-COMPLAINTS') === true) { ?>
                                                    <option value="address"><?php echo lang_loader('pcf', 'pcf_address'); ?></option>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if (ismodule_active('PCF') === true && isfeature_active('CLOSING-COMPLAINTS') === true) { ?>
                                                <option value="capa"><?php echo lang_loader('pcf', 'pcf_close'); ?></option>
                                            <?php } ?>
                                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-TRANSFER-COMPLAINTS') === true) { ?>
                                                <option value="movetick"><?php echo lang_loader('pcf', 'pcf_transfer'); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                        <!-- check login if not 4 -->
                                        <!-- check if ticket is closed -->
                                        <?php if ($this->session->userdata['user_role'] != 4) {

                                            $closed = true; ?>
                                            <?php if ($department->status == 'Closed') { ?>
                                                <?php if (ismodule_active('PCF') === true && isfeature_active('PC-REOPEN-COMPLAINTS') === true) { ?>
                                                    <option value="reopen"><?php echo lang_loader('pcf', 'pcf_reopen'); ?></option>
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
                                <td><strong><?php echo lang_loader('pcf', 'pcf_last_updated_on'); ?></strong> </td>
                                <td><?php echo date('g:i A, d-m-y', strtotime($department->last_modified)); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (int_tat('department_link') === true) { ?>
                            <?php if ($department->status == 'Closed') { ?>
                                <tr>
                                    <td><strong><?php echo lang_loader('pcf', 'pcf_turn_around_time'); ?></strong> </td>
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


        <?php if ($this->session->userdata['user_role'] != 4 && ($department->status == 'Closed')) {

            if ($closed == true) { ?>


                <?php if (($department->status != 'Open')) { ?>
                    <div class="col-sm-12" id="reopen" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><?php echo lang_loader('pcf', 'pcf_reopen_this_complaint'); ?></h3>
                            </div>
                            <div class="col-sm-12" style="overflow:auto;">
                                <!-- <div class="col-md-12 col-sm-12"> -->
                                <br />
                                <?php echo form_open('ticketsint/create', 'class="form-inner"') ?>
                                <?php echo form_hidden('id', $department->id) ?>
                                <div class="form-group row">
                                    <!-- <label for="name" class="col-xs-3 col-form-label">Addressed</label> -->
                                    <!-- <div class="col-xs-9"> -->
                                    <input type="hidden" name="status" value="Reopen">
                                    <!-- </div> -->
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <textarea class="form-control" rows="5" minlength="25" id="comment" name="reply"
                                            placeholder="Reason to reopen complaint" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="status" value="Reopen">
                                    </div>
                                </div>


                                <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button
                                                class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
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
                                <h3><?php echo lang_loader('pcf', 'pcf_address_this_complaint'); ?></h3>
                            </div>
                            <div class="col-sm-12" style="overflow:auto;">
                                <!-- <div class="col-md-12 col-sm-12"> -->
                                <br />
                                <?php echo form_open('ticketsint/create', 'class="form-inner"') ?>
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
                                        <textarea class="form-control" minlength="25" rows="5" id="comment" name="reply"
                                            placeholder="Please enter your initial response message" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="status" value="Addressed">
                                    </div>
                                </div>


                                <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button
                                                class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
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
                                <h3>Enter RCA, CAPA, and Resolution Comment to Close the Ticket</h3>
                            </div>
                            <?php echo form_open_multipart('ticketsint/create', 'class="form-inner"') ?>
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
                                                    onclick="hidebox()">Open</label>
                                            <label class="radio-inline"><input type="radio" name="status" value="Closed"
                                                    onclick="showbox()"
                                                    checked="true"><?php echo lang_loader('pcf', 'pcf_close'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <br>


                                <!-- <h3>Writing CAPA to close this ticket:<i class="text-danger">*</i></h3> -->
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <textarea class="form-control" minlength="25" rows="5" id="rootcause" name="rootcause"
                                            placeholder="Enter an RCA(Root Cause Analysis)" required></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row" id="correctiveid">
                                        <textarea class="form-control" rows="5" minlength="25" id="corrective" name="corrective"
                                            placeholder="Enter CAPA(Corrective Action and Preventive Action)" required></textarea>
                                    </div>
                                </div>
                                <?php if (close_comment('pc_close_comment') === true) { ?>
                                    <div class="col-sm-12">
                                        <div class="form-group row" id="correctiveid">
                                            <textarea class="form-control" rows="5" id="comment" name="comment"
                                                placeholder="Enter Comment" required></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <textarea class="form-control" rows="5" minlength="25" id="note" name="resolution_note"
                                            placeholder="Enter your resolution comment (visible to the patient who raised the issue)"
                                            required></textarea>
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
                                        <button class="ui positive button"
                                            id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-sm-12" id="move" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><?php echo lang_loader('pcf', 'pcf_transfering_complaint_department'); ?></h3>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <br />
                                <?php echo form_open('ticketsint/create', 'class="form-inner"') ?>
                                <?php echo form_hidden('id', $department->id) ?>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('pcf', 'pcf_department'); ?></label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="sel1" name="deparment" required aria-required="true">
                                            <?php echo '<option value="">--Change Department--</option>';
                                            $this->db->order_by('slug', 'asc');
                                            $this->db->where('type', 'interim');
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
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('pcf', 'pcf_comment'); ?></label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" minlength="25" id="comment" name="reply"
                                            placeholder="Enter the reason for complaint transfer" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen"
                                            value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id"
                                            value="<?php echo $department->departmentid; ?>">
                                    </div>
                                </div> <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button
                                                class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                        </div>
                                    </div>
                                </div> <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <script>
                    // $(document).ready(function() {
                    // Hide all elements by default
                    setTimeout(function () {
                        $('#capa').hide();
                        $('#address').hide();
                        $('#move').hide();
                        $('#reopen').hide();
                    }, 1000);

                    //  });

                    function ticket_options(val) {
                        // alert(val);
                        // $('#capa').hide();
                        // $('#address').hide();
                        // $('#move').hide();
                        // $('#reopen').hide();

                        if (val == 'capa') {
                            $('#capa').show();
                            $('#address').hide();
                            $('#move').hide();
                            $('#reopen').hide();
                        } else if (val == 'address') {
                            $('#address').show();
                            $('#capa').hide();
                            $('#move').hide();
                            $('#reopen').hide();
                        } else if (val == 'movetick') {
                            $('#move').show();
                            $('#capa').hide();
                            $('#address').hide();
                            $('#reopen').hide();
                        } else if (val == 'reopen') {
                            $('#move').hide();
                            $('#capa').hide();
                            $('#address').hide();
                            $('#reopen').show();
                        } else if (val == 'Open' || val == 'Close' || val == 'Addressed' || val == 'Reopen') {
                            $('#move').hide();
                            $('#capa').hide();
                            $('#address').hide();
                            $('#reopen').hide();
                        }
                        $('input:checkbox').attr('checked', false);
                    }
                </script>

            <?php } ?>
        <?php } ?>



        <hr>
        <?php if ($this->session->userdata('isLogIn') == true) { ?>
            <?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Addressed' || $department->status == 'Transfered') { ?>

                <?php include 'ticket_convo.php'; ?>

            <?php } ?>
        <?php } ?>

    </div>



</div>