<?php
$currentTime = time();

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
$logo_imgrraydata = array();
foreach ($questioarray as $setr) {
    foreach ($setr as $k => $v) {
        $logo_imgrraydata[$k] = $v;
    }
}



$hosplogo = $this->db->select("logo,title")
    ->get('setting')
    ->row();

$logo_img['logo'] = $hosplogo->logo;
$logo_img['title'] = $hosplogo->title;

foreach ($param['reason'] as $key => $value) {

    if ($value === true) {
        $this->db->where('shortkey', $key);
        $query = $this->db->get('setup_int');
        $cresult = $query->result();
    }
    if (count($cresult) != 0) {
        $issues =  $cresult[0]->shortname;
    }
}
foreach ($param['comment'] as $com => $explain) {
    if ($com) {
        $comment = $explain;
    }
}




?>

<?php $department = $departments[0];
//  print_r($department->replymessage[0]->corrective);
?>

<div class="content">

    <div class="ticket-card" style="overflow: hidden;">
        <div class="panel panel-bd" style="width:100%; text-align:center">
            <img src="<?php echo (!empty($logo_img) ? base_url('uploads/' . $logo_img['logo']) : null) ?>" style=" height: 60px; width: 180px; margin-top:5px;   margin-bottom: 0px;">
            <br>
            <p style="font-family: Arial, sans-serif;font-size:20px; margin-bottom: 5px; margin-top: 2px;font-weight: bold;"><?php echo $logo_img['title']; ?></p>
            <div class="panel-body">
                <?php if ($this->session->userdata['isLogIn'] == false) { ?>
                    <?php if ($department->status == 'Closed') { ?>
                        <span class="navheader" style="color: #198754;"><?php echo lang_loader('pcf', 'pcf_closed'); ?></span>
                        <span class="navheader" style="color:  #198754;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                        <!-- <?php if ($department->status == 'Closed' && $department->patient_verified_status == 1) { ?>
                            <span
                                style="font-size: 25px; color: green; cursor: pointer;"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Concern has been verified by the patient">
                                ✔️
                            </span>
                        <?php } ?> -->
                    <?php } ?>
                    <?php if ($department->status == 'Addressed') { ?>
                        <span class="navheader"><?php echo lang_loader('pcf', 'pcf_inprogress'); ?></span>
                        <span class="navheader" style="color:  #f0ad4e;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php } ?>
                    <?php if ($department->status == 'Open') { ?>
                        <span class="navheader" style="color: #d9534f;"><?php echo lang_loader('pcf', 'pcf_assigned'); ?></span>
                        <span class="navheader" style="color: #d9534f;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;</span>
                    <?php }  ?>
                    <?php if ($department->status == 'Reopen') { ?>
                        <span class="navheader" style="color: #d9534f;">Reopen</span>
                        <span class="navheader" style="color: #d9534f;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;</span>
                    <?php }  ?>
                    <style>
                        .navheader {
                            text-align: center;
                            font-size: 16px;
                            display: inline-block;
                            text-align: center;
                            /* float: right; */
                            font-weight: bold;
                            margin-bottom: 5px;
                            margin-top: 0px;
                        }
                    </style>
                <?php } ?>
                <?php if ($department->status == 'Closed') { ?>

                    <p class="message-note">
                        <?php if ($department->status == 'Closed' && $department->patient_verified_status == 0) { ?>
                            <?php echo lang_loader('pcf', 'pcf_request_resolved_department'); ?>.
                        <?php } ?>
                    </p>
                    <p class="message-note">
                        <?php if ($department->status == 'Closed' && $department->patient_verified_status == 1) { ?>
                            Concern resolution verified by the staff.
                        <?php } ?>
                    </p>
                    <br>
                    <?php if ($department->status == 'Closed' && $department->patient_verified_status == 0) { ?>
                        <p><strong>Has your concern been resolved?</strong></p>

                        <div id="emoji-options">
                            <?php echo form_open('ticketsint/create', 'class="form-inner" id="emojiForm"') ?>
                            <?php echo form_hidden('id', $this->uri->segment(3)) ?>
                            <label style="margin-right: 20px; cursor: pointer;">
                                <input type="radio" name="concernResolved" value="yes" hidden>
                                <span class="emoji" data-value="yes" onclick="submitEmojiForm()">😊</span>
                                <input type="hidden" name="status_patient_verified" value="Verified">
                                <input type="hidden" name="status" value="Closed">
                            </label>


                            <label style="cursor: pointer;">
                                <input type="radio" name="concernResolved" value="no" hidden>
                                <span class="emoji" data-value="no">😞</span>
                            </label>
                            <?php echo form_close() ?>
                        </div>
                    <?php } ?>
                    <div id="thank-you-message" style="display: none;">
                        <p>Thank you for your feedback!</p>
                    </div>

                    <div id="reopen-question" style="display: none; text-align: center;">
                        <p>Do you want to reopen the ticket?</p>
                        <div style="display: inline-flex; gap: 10px;">
                            <button type="button" class="reopen-option btn-yes" data-value="yes" style="cursor: pointer; padding: 5px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 14px;">
                                Yes
                            </button>
                            <button type="button" class="reopen-option btn-no" data-value="no" style="cursor: pointer; padding: 5px 15px; background-color: #f44336; color: white; border: none; border-radius: 5px; font-size: 14px;">
                                No
                            </button>
                        </div>
                    </div>


                    <div id="additional-thank-you" style="display: none;">
                        <p>Thank you for your feedback!</p>
                    </div>

                    <div id="reopen-reason" style="display: none;">
                        <?php echo form_open('ticketsint/create', 'class="form-inner"') ?>
                        <?php echo form_hidden('id', $this->uri->segment(3)) ?>
                        <input type="hidden" name="status" value="Reopen">
                        <input type="hidden" name="patient_reopen_name" value="<?php echo $param['name']; ?>">
                        <p>Please let us know the reason for reopening the ticket:</p>
                        <textarea rows="4" cols="50" placeholder="Enter your reason here..." required id="comment" name="reply"></textarea>
                        <input type="hidden" name="status_patient" value="Patient">
                        <input type="hidden" name="status" value="Reopen">
                        <div class="form-group row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="ui buttons"> <button class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button> </div>
                            </div>
                        </div> <?php echo form_close() ?>
                    </div>


                    <br>
                <?php } ?>
                <br>
                <?php if ($department->status == 'Addressed') { ?>
                    <p class="message-note">
                        <?php if ($department->department->pname) { ?>
                            <!-- if department head is mapped -->
                            <?php echo lang_loader('pcf', 'pcf_request_resolved_department'); ?>
                            <!-- Your issue is assigned to <b> <?php //echo $department->department->pname; 
                                                                ?></b>and has your addressed issue. -->
                        <?php } else {  ?>
                            <?php echo lang_loader('pcf', 'pcf_request_resolved_department'); ?>
                            <!-- Your issue is addressed and the team is working on it. -->
                        <?php }  ?>
                    </p>
                <?php } ?>
                <?php if ($department->status == 'Open') { ?>
                    <p class="message-note">
                        <?php if ($department->department->pname) { ?>
                            <!-- if department head is mapped -->
                            <?php echo lang_loader('pcf', 'pcf_you_request_assigned'); ?>
                        <?php } else {  ?>
                            <?php echo lang_loader('pcf', 'pcf_you_request_assigned'); ?>
                            <!-- We are sorry that you are facing this issue. Your issue will be soon assigned to one of our executive. -->
                        <?php }  ?>
                    </p>
                <?php }  ?>
                <style>
                    .message-note {
                        font-size: 14px;
                        /* font-weight: bold; */
                        text-align: center;
                        margin-bottom: 0px;
                        margin-top: 0px;
                    }
                </style>
                <br>
                <?php
                $closeTime = $department->department->close_time;
                $createdOn1 = strtotime($department->created_on);
                $underrange = $createdOn1 + ($start_time * $closeTime);
                $uprange = $createdOn1 + (1 * $closeTime);
                $lastModified1 = strtotime($department->last_modified) - 2;
                $lastModified2 = strtotime($department->last_modified);
                $countexc = 0;
                $time_rem = $createdOn1  + $closeTime;
                $timeDifferenceInSeconds =  $time_rem - $currentTime;
                $value = $this->pc_model->convertSecondsToTime($timeDifferenceInSeconds);

                if (($uprange < $currentTime)) {
                    $show = true;
                } ?>
                <div style="display:none;">
                    <?php if ($department->status == 'Open' && $show === true) { ?>
                        <!-- Escalation button show here. -->
                        <?php echo lang_loader('pcf', 'pcf_escalate_this_issue'); ?>

                    <?php } ?>
                </div>
                <?php if ($department->status == 'Closed' || $department->status == 'Reopen') { ?>
                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                        <!-- <table class="table table-border no-footer no-header"> -->
                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('pcf', 'pcf_complaint_summary'); ?></b></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_complaint_id'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo 'PCT-' . $department->id;  ?>

                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_status'); ?></td>
                                <td style="text-align: left;">
                                    <?php if ($department->status == 'Closed') { ?>
                                        <span style="color: #198754;"><?php echo lang_loader('pcf', 'pcf_closed'); ?></span>
                                        <span style="color:  #198754;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                        <!-- <?php if ($department->status == 'Closed' && $department->patient_verified_status == 1) { ?>
                                            <span
                                                style="font-size: 25px; color: green; cursor: pointer;"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Concern has been verified by the patient">
                                                ✔️
                                            </span>
                                        <?php } ?> -->
                                    <?php } ?>
                                    <?php if ($department->status == 'Addressed') { ?>
                                        <span><?php echo lang_loader('pcf', 'pcf_inprogreess'); ?></span>
                                        <span style="color:  #f0ad4e;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                    <?php } ?>
                                    <?php if ($department->status == 'Open') { ?>
                                        <span style="color: #d9534f;"><?php echo lang_loader('pcf', 'pcf_assigned'); ?></span>
                                        <span style="color: #d9534f;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;</span>
                                    <?php }  ?>
                                    <?php if ($department->status == 'Reopen') { ?>
                                        <span style="color: #d9534f;">Reopen</span>
                                        <span style="color: #d9534f;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;</span>
                                    <?php }  ?>

                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_department'); ?></td>
                                <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_concern'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
                            </tr>
                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($department->status == 'Closed') { ?>

                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">Resolution Comment </td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $department->replymessage[0]->resolution_note  . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_closed_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a', strtotime($department->last_modified)); ?>
                                    <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                </td>
                            </tr>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_time_taken'); ?></td>
                                <td style="text-align: left;">
                                    <?php
                                    $createdOn = strtotime($department->created_on);
                                    $lastModified = strtotime($department->last_modified);
                                    $timeDifferenceInSeconds = $lastModified - $createdOn;
                                    $value = $this->pc_model->convertSecondsToTime($timeDifferenceInSeconds);
                                    if ($value['days'] != 0) {
                                        echo $value['days'] . ' days, ';
                                    }
                                    if ($value['hours'] != 0) {
                                        echo  $value['hours'] . ' hrs, ';
                                    }
                                    if ($value['minutes'] != 0) {
                                        echo  $value['minutes'] . ' mins.';
                                    }
                                    ?>
                                </td>
                            </tr>

                        </table>

                        <?php if (int_tat('department_rating') === true) { ?>
                            <form action="save_rating.php" method="post">
                                <label for="rating"><?php echo lang_loader('pcf', 'pcf_rate_this'); ?>:</label>
                                <div class="stars">
                                    <input type="radio" name="rating" id="5" value="5">
                                    <label for="5" class="fa fa-star"></label>

                                    <input type="radio" name="rating" id="4" value="4">
                                    <label for="4" class="fa fa-star"></label>

                                    <input type="radio" name="rating" id="3" value="3">
                                    <label for="3" class="fa fa-star"></label>

                                    <input type="radio" name="rating" id="2" value="2">
                                    <label for="2" class="fa fa-star"></label>

                                    <input type="radio" name="rating" id="1" value="1">
                                    <label for="1" class="fa fa-star"></label>
                                </div>
                                <br>
                                <button type="button" value="Submit" class="btn btn-success"><?php echo lang_loader('pcf', 'pcf_submit'); ?> </button>
                            </form>

                        <?php } ?>
                    </div>
                    <style>
                        .stars {
                            display: flex;
                            flex-direction: row-reverse;
                            justify-content: center;
                        }

                        .stars input[type="radio"] {
                            display: none;
                        }

                        .stars label {
                            font-size: 24px;
                            cursor: pointer;
                            color: grey;
                            margin: 0 3px;
                        }

                        .stars input[type="radio"]:checked~label {
                            color: gold;
                        }
                    </style>
                <?php } else { ?>
                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">

                        <p style="margin-left: 10px;margin-right: 10px; text-align: left;display:none;">
                            <?php
                            $expectedtime = strtotime($department->created_on);
                            $maxtime = $department->department->close_time;
                            $time_in_sec = $expectedtime + $maxtime;
                            $tat_time = strtotime($time_in_sec);
                            ?>
                            <i class="fa fa-exclamation-triangle"></i>
                            <?php echo date('g:i a', $time_in_sec); ?>
                            <?php echo date('d-m-y', $time_in_sec); ?>
                        </p>

                        <!-- <table class="table table-no-border no-footer"> -->
                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('pcf', 'pcf_complaint_details'); ?></b></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_complaint_id'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo 'PCT-' . $department->id;  ?>

                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_status'); ?></td>
                                <td style="text-align: left;">
                                    <?php if ($department->status == 'Closed' || $department->status == 'Reopen') { ?>
                                        <span style="color: #198754;"><?php echo lang_loader('pcf', 'pcf_closed'); ?></span>
                                        <span style="color:  #198754;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                    <?php } ?>
                                    <?php if ($department->status == 'Addressed') { ?>
                                        <span><?php echo lang_loader('pcf', 'pcf_inprogreess'); ?></span>
                                        <span style="color:  #f0ad4e;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                    <?php } ?>
                                    <?php if ($department->status == 'Open') { ?>
                                        <span style="color: #d9534f;"><?php echo lang_loader('pcf', 'pcf_assigned'); ?></span>
                                        <span style="color: #d9534f;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;</span>
                                    <?php }  ?>

                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_site'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo '' . $param['bedno'] . '';  ?>
                                    <br>
                                    <?php echo '' . $param['ward'] . '';  ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_department'); ?></td>
                                <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_concern'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
                            </tr>

                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <?php if ($department->last_modified > $department->created_on) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_updated_on'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo date('g:i a', strtotime($department->last_modified)); ?>
                                        <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                        <?php if (int_tat('department_information') === true) { ?>
                            <?php if ($department->department->pname) { ?>

                                <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                                    <tr>
                                        <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('pcf', 'pcf_department_info'); ?></b></td>
                                    </tr>
                                    <tr style="margin-left: 10px;margin-right: 10px;">
                                        <td style="text-align: left;width:30px;">H.O.D</td>
                                        <td style="text-align: left;"><?php echo $department->department->pname; ?></td>
                                    </tr>

                                    <tr style="margin-left: 10px;margin-right: 10px;">
                                        <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_phone'); ?></td>
                                        <td style="text-align: left;">
                                            <i class="fa fa-phone"></i>
                                            <?php echo $department->department->mobile; ?>
                                        </td>
                                    </tr>
                                </table>
                            <?php } ?>
                        <?php
                        }
                        if ($department->status == 'Addressed') { ?>
                            <table class="table table-no-border no-footer no-header" style="display: none;">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b>Did you know?</b></td>
                                </tr>
                                <tr colspan="2" style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">
                                        <p>
                                            <?php
                                            $expectedtime = strtotime($department->created_on);
                                            $maxtime = $department->department->close_time;
                                            $time_in_sec = $expectedtime + $maxtime;
                                            $tat_time = strtotime($time_in_sec);
                                            ?>
                                            <?php echo date('g:i a', $time_in_sec); ?>
                                            <?php echo date('d-m-y', $time_in_sec); ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        <?php    }  ?>


                        <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                            <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('pcf', 'pcf_patient_info'); ?></b></td>
                                </tr>


                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_name'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo $param['name']; ?>
                                    </td>
                                </tr>

                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_id'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo $param['patientid']; ?>
                                    </td>
                                </tr>
                                <?php if (patientlink('patient_phone') === true) { ?>
                                    <tr style="margin-left: 10px;margin-right: 10px;">
                                        <td style="text-align: left;width:30px;"><?php echo lang_loader('pcf', 'pcf_contact'); ?></td>
                                        <td style="text-align: left;">
                                            <?php if ($param['contactnumber'] != '') { ?>
                                                <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>


                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <style>
            .ticket-card {
                max-width: 600px;
                margin: 4% auto 0;
                /* padding: 20px; */
            }

            .ticket-card.lg {
                max-width: 800px;
            }

            .view-header {
                margin: 10px 0;
            }

            .view-header .header-icon {
                font-size: 60px;
                color: #37a000;
                width: 68px;
                float: left;
                margin-top: -8px;
                line-height: 0;
            }

            .view-header .header-title {
                margin-left: 68px;
            }

            .view-header .header-title h3 {
                margin-bottom: 2px;
            }

            .emoji,
            .reopen-option {
                font-size: 2rem;
                transition: transform 0.2s;
            }

            .emoji:hover,
            .reopen-option:hover {
                transform: scale(1.2);
                cursor: pointer;
            }

            textarea {
                width: 100%;
                max-width: 500px;
                margin-top: 10px;
            }
        </style>
        <script>
            // Handle concern resolved (like or dislike emoji)
            document.querySelectorAll('.emoji').forEach((emoji) => {
                emoji.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');

                    // Hide initial question
                    document.getElementById('emoji-options').style.display = 'none';

                    if (value === 'yes') {
                        // Show thank-you message for resolved
                        document.getElementById('thank-you-message').style.display = 'block';
                    } else if (value === 'no') {
                        // Show question to reopen the ticket
                        document.getElementById('reopen-question').style.display = 'block';
                    }
                });
            });

            // Handle reopen question
            document.querySelectorAll('.reopen-option').forEach((option) => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');

                    // Hide reopen question
                    document.getElementById('reopen-question').style.display = 'none';

                    if (value === 'yes') {
                        // Show reason text box for reopening
                        document.getElementById('reopen-reason').style.display = 'block';
                        document.getElementById('concern_id').style.display = 'block';
                    } else if (value === 'no') {
                        // Show additional thank-you message
                        document.getElementById('additional-thank-you').style.display = 'block';
                    }
                });
            });
        </script>

        <script>
            // Function to submit the form when the emoji is clicked
            function submitEmojiForm() {
                document.getElementById('emojiForm').submit();
            }
        </script>