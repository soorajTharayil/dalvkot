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
        $query = $this->db->get('setup_incident');
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

<?php $department = $departments[0]; ?>

<div class="content">
    <div class="ticket-card" style="overflow: hidden;">
        <div class="panel panel-bd" style="width:100%; text-align:center">
            <img src="<?php echo (!empty($logo_img) ? base_url('uploads/' . $logo_img['logo']) : null) ?>" style=" height: 60px; width: 180px; margin-top:5px;   margin-bottom: 0px;">
            <br>
            <p style="font-family: Arial, sans-serif;font-size:20px; margin-bottom: 5px; margin-top: 2px;font-weight: bold;"><?php echo $logo_img['title']; ?></p>
            <div class="panel-body">

                <?php if ($this->session->userdata['isLogIn'] == false) { ?>
                    <?php if ($department->status == 'Closed') { ?>
                        <span class="navheader" style="color: #198754;">Closed</span>
                        <span class="navheader" style="color:  #198754;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php } ?>
                    <?php if ($department->status == 'Addressed') { ?>
                        <span class="navheader"><?php echo lang_loader('inc', 'inc_inprogress'); ?></span>
                        <span class="navheader" style="color:  #f0ad4e;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php } ?>
                    <?php if ($department->status == 'Open') { ?>
                        <span class="navheader" style="color: #d9534f;"><?php echo lang_loader('inc', 'inc_assigned'); ?></span>
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
                            Your incident has been resolved by the respective department.
                        <?php } ?>
                    </p>
                    <p class="message-note">
                        <?php if ($department->status == 'Closed' && $department->patient_verified_status == 1) { ?>
                            Incident resolution verified by the staff.
                        <?php } ?>
                    </p>
                    <br>
                    <?php if ($department->status == 'Closed' && $department->patient_verified_status == 0) { ?>
                        <p><strong>Has your incident been resolved?</strong></p>

                        <div id="emoji-options">
                            <?php echo form_open('ticketsincident/create', 'class="form-inner" id="emojiForm"') ?>
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
                        <p>Do you want to reopen the incident?</p>
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
                        <?php echo form_open('ticketsincident/create', 'class="form-inner"') ?>
                        <?php echo form_hidden('id', $this->uri->segment(3)) ?>
                        <input type="hidden" name="status" value="Reopen">
                        <input type="hidden" name="patient_reopen_name" value="<?php echo $param['name']; ?>">
                        <p>Please let us know the reason for reopening the incident:</p>
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
                <?php if ($department->status == 'Addressed') { ?>
                    <p class="message-note">
                        <?php echo lang_loader('inc', 'inc_incident_actively_assigned'); ?>
                    </p>
                <?php } ?>
                <?php if ($department->status == 'Open') { ?>
                    <p class="message-note">
                        <?php echo lang_loader('inc', 'inc_incident_registered'); ?>
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

                <?php if ($department->status == 'Closed') { ?>
                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('inc', 'inc_incident_summary'); ?></b></td>
                            </tr>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_incident_summary'); ?></td>
                                <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_incidents'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
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
                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">Resolution Comment </td>
                                    <td style="text-align: left;">
                                    <?php echo '"' . $department->replymessage[0]->resolution_note  . '"'; ?>

                                    </td>
                                </tr>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;">Closed on</td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->last_modified)); ?>
                                    <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                </td>
                            </tr>
                          
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">Time Taken</td>
                                    <td style="text-align: left;">
                                        <?php
                                        $createdOn = strtotime($department->created_on);
                                        $lastModified = strtotime($department->last_modified);
                                        $timeDifferenceInSeconds = $lastModified - $createdOn;
                                        $value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);
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
                    </div>
                <?php } else { ?>

                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('inc', 'inc_incident_report'); ?></b></td>
                            </tr>
                            <span class="navheader">
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_priority'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo ' ' . $param['priority'] . '. ';  ?>
                                    </td>
                                </tr>
                            </span>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;">Site</td>
                                <td style="text-align: left;">
                                    <?php echo 'From ' . $param['bedno'] . '. ';  ?>
                                    <?php echo 'In ' . $param['ward'] . '.';  ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_incidents'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
                            </tr>

                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <?php if ($department->last_modified > $department->created_on) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_updated_on'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo date('g:i a,', strtotime($department->last_modified)); ?>
                                        <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                        <?php if (incident_tat('department_information') === true) { ?>
                            <?php if ($department->department->pname) { ?>
                                <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                                    <tr>
                                        <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('inc', 'inc_department_info'); ?></b></td>
                                    </tr>
                                    <tr style="margin-left: 10px;margin-right: 10px;">
                                        <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_incident_summary'); ?></td>
                                        <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                                    </tr>

                                    <tr style="margin-left: 10px;margin-right: 10px;">
                                        <td style="text-align: left;width:30px;"><?php echo lang_loader('inc', 'inc_contact'); ?></td>
                                        <td style="text-align: left;">
                                            <?php echo $department->department->pname; ?>
                                            <br>
                                            <i class="fa fa-phone"></i>
                                            <?php echo $department->department->mobile; ?>
                                        </td>
                                    </tr>
                                </table>
                            <?php } ?>
                        <?php } else { ?>
                            <table class="table table-no-border no-footer no-header" style="display:none;">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('inc', 'inc_did_you_know'); ?></b></td>
                                </tr>
                                <tr colspan="2" style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">
                                        <p>hiihhi</p>
                                    <td>

                                </tr>
                            </table>
                        <?php    }  ?>


                        <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">

                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('inc', 'inc_employee_info'); ?></b></td>
                                </tr>
                                <tr colspan="2" style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: center;">
                                        <?php echo $param['name']; ?> (<?php echo $param['patientid']; ?>)
                                        <br>
                                        <?php if ($param['contactnumber'] != '') { ?>
                                            <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
                                        <?php } ?>
                                    <td>

                                </tr>
                            </table>



                        </div>

                    </div>
                <?php } ?>
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