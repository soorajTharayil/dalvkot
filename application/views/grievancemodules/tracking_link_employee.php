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
        $query = $this->db->get('setup_esr');
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
                    <?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Auto Closed') { ?>
                        <span class="navheader" style="color: #198754;"><?php echo lang_loader('sg','sg_resolved'); ?></span>
                        <span class="navheader" style="color:  #198754;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php } ?>
                    <?php if ($department->status == 'Addressed') { ?>
                        <span class="navheader"><?php echo lang_loader('sg','sg_inprogress'); ?></span>
                        <span class="navheader" style="color:  #f0ad4e;font-weight: bold;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php } ?>
                    <?php if ($department->status == 'Open') { ?>
                        <span class="navheader" style="color: #d9534f;"><?php echo lang_loader('sg','sg_assigned'); ?></span>
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
                <?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Auto Closed') { ?>

                    <p class="message-note">
                    <?php echo lang_loader('sg','sg_concern_resolved'); ?>
                    </p>
                <?php } ?>
                <?php if ($department->status == 'Addressed') { ?>
                    <p class="message-note">
                    <?php echo lang_loader('sg','sg_concern_assigned'); ?>
                    </p>
                <?php } ?>
                <?php if ($department->status == 'Open') { ?>
                    <p class="message-note">
                    <?php echo lang_loader('sg','sg_concern_registered'); ?>
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

                <?php if ($department->status == 'Closed' || $department->status == 'Reopen' || $department->status == 'Auto Closed') { ?>
                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                        <table class="table table-no-border no-footer no-header">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('sg','sg_request_summary'); ?></b></td>
                            </tr>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_department_name'); ?></td>
                                <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_issue_concerns'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
                            </tr>
                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                           
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_closed_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->last_modified)); ?>
                                    <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                </td>
                            </tr>
                            <?php if (isr_tat('employee_link') === true) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_time_taken'); ?></td>
                                    <td style="text-align: left;">
                                        <?php
                                        $createdOn = strtotime($department->created_on);
                                        $lastModified = strtotime($department->last_modified);
                                        $timeDifferenceInSeconds = $lastModified - $createdOn;
                                        $value = $this->grievance_model->convertSecondsToTime($timeDifferenceInSeconds);
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
                            <?php    } ?>
                        </table>
                    </div>
                <?php } else { ?>

                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                        <table class="table table-no-border no-footer">
                            <tr>
                                <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('sg','sg_service_request_details'); ?></b></td>
                            </tr>
                            <span class="navheader">
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_priority'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo ' ' . $param['priority'] . '. ';  ?>
                                    </td>
                                </tr>
                            </span>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_site'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo 'From ' . $param['bedno'] . '. ';  ?>
                                    <?php echo 'In ' . $param['ward'] . '.';  ?>
                                </td>
                            </tr>
                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_issue_concerns'); ?></td>
                                <td style="text-align: left;"><?php echo $issues; ?></td>
                            </tr>

                            <?php if ($comment) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_comment'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo '"' . $comment . '"'; ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr style="margin-left: 10px;margin-right: 10px;">
                                <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_created_on'); ?></td>
                                <td style="text-align: left;">
                                    <?php echo date('g:i a,', strtotime($department->created_on)); ?>
                                    <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                </td>
                            </tr>
                            <?php if ($department->last_modified > $department->created_on) { ?>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_updated_on'); ?></td>
                                    <td style="text-align: left;">
                                        <?php echo date('g:i a,', strtotime($department->last_modified)); ?>
                                        <?php echo date('d-m-y', strtotime($department->last_modified)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">
                    <?php if (isr_tat('department_information') === true) { ?>
                        <?php if ($department->department->pname) { ?>
                            <table class="table table-no-border no-footer no-header">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('sg','sg_department_info'); ?></b></td>
                                </tr>
                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_department_name'); ?></td>
                                    <td style="text-align: left;"><?php echo $department->department->description; ?></td>
                                </tr>

                                <tr style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;"><?php echo lang_loader('sg','sg_contact'); ?></td>
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
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('sg','sg_did_you_know'); ?></b></td>
                                </tr>
                                <tr colspan="2" style="margin-left: 10px;margin-right: 10px;">
                                    <td style="text-align: left;width:30px;">
                                        <p>hiihhi</p>
                                    <td>

                                </tr>
                            </table>
                        <?php    }  ?>


                        <div class="inbox" style=" margin-bottom: 0px; margin-top: 0px;">

                            <table class="table table-no-border no-footer no-header">
                                <tr>
                                    <td class="inbox-item-author" colspan="2" style="text-align: center;"><b><?php echo lang_loader('sg','sg_employee_info'); ?></b></td>
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
            </style>