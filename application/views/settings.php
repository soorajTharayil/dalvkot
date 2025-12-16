<?php
$google_review_link_tooltip = "This is the link shared with happy patients to provide a Google review.";
$google_review_tooltip = "Set custom Google review benchmark values based on PSAT and NPS scores";
$ip_discharge_feedback_link_tooltip = "This link captures inpatient discharge feedback online and can be sent via SMS or email through the HMS/HIS upon patient discharge.";
$outpatient_feedback_link_tooltip = "This link captures outpatient discharge feedback online and can be sent via SMS or email through the HMS/HIS after OP consultation/ billing";
$patient_complaints_request_link_tooltip = "This online link captures inpatient complaints and service requests, and it can be sent via SMS or email through the HMS/HIS during inpatient admission. Patients can use this link to raise complaints or requests throughout their stay.";
$internal_service_request_link_tooltip = "This link enables hospital staff to submit service requests for any issues identified within the hospital premises";
$healthcare_incident_link_tooltip = "This link allows hospital staff to report any healthcare incidents identified within the hospital premises.";
$staff_grievance_link_tooltip = "This link enables hospital staff to report staff-related grievances during their tenure";
$adf_feedback_link_tooltip = "This online link captures feedback related to the admission and can be sent via SMS or email through the HMS/HIS upon patient discharge";
$feedback_complaint_inpatients_link_tooltip = "This universally accessible link, embedded in QR codes strategically placed in each inpatient room and across the premises, facilitates the collection of feedback and complaints tailored to patients' preferences and requirements.";
$quality_module_healthcare_staffs_link_tooltip = "This standardized link is utilized by all healthcare employees to report service requests, healthcare incidents, and grievances.";
$android_apk_tooltip = "This hospital-tailored Android APK file is designed for seamless installation of the dedicated app on mobile or tablet devices carried by patient coordinators. It serves the purpose of efficiently gathering patient feedback and managing complaints.";
$inpatient_qr_code_tooltip = "This QR code is configured with links for inpatient complaints and feedback. It can be incorporated into QR code posters for placement in inpatient areas and rooms.";
$outpatient_qr_code_tooltip = "This QR code is configured with links for outpatient feedback. It can be incorporated into QR code posters for placement in outpatient areas";
$inpatient_qr_code_poster_tooltip = "These are printable QR poster designs that can be used by the hospital for placement in inpatient areas and rooms.";
$outpatient_qr_code_poster_tooltip = "These are printable QR poster designs that can be used by the hospital for placement in outpatient areas";

?>

<div class="content">

    <div class="row">

        <?php

        $department = $this->db->where('setting_id', 2)->get('setting')->result();

        $department = $department[0];

        // print_r($department);

        ?>

        <?php $accHID = $department->description; ?>

        <?php $acctype = $department->validity_key; ?>





        <!--  form area -->

        <div class="col-sm-12">

            <div class="panel panel-default thumbnail">





                <div class="panel-body panel-form">

                    <div class="row">

                        <div class="col-md">



                            <?php echo form_open_multipart('settings/supplementary_info', 'class="form-inner"'); ?>



                            <?php

                            if (isfeature_active('ADMINS-OVERALL-PAGE') === false) {

                                // User with role 0

                            ?>



                                <!-- Google Review Link -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_google_review_link'); ?> <i class="text-danger">*</i></label>

                                    <div class="col-xs-9">

                                        <input name="google_review_link" placeholder="Less than 30 characters" type="text" maxlength="30" type="text" class="form-control" id="google_review_link" value="<?php echo $department->google_review_link ?>" required>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-3">
                                        <h4>Set Google review benchmark</h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="psat_score">PSAT Score:</label>
                                        <select id="psat_score" name="psat_score" class="form-control">
                                            <option value="3 & above" <?php echo isset($department->psat_score) && $department->psat_score == 3 ? 'selected' : ''; ?>>3 & above</option>
                                            <option value="4 & above" <?php echo isset($department->psat_score) && $department->psat_score == 4 ? 'selected' : ''; ?>>4 & above</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="nps_score">NPS Score:</label>
                                        <select id="nps_score" name="nps_score" class="form-control">
                                            <option value="7 & above" <?php echo isset($department->nps_score) && $department->nps_score == 7 ? 'selected' : ''; ?>>7 & above</option>
                                            <option value="8 & above" <?php echo isset($department->nps_score) && $department->nps_score == 8 ? 'selected' : ''; ?>>8 & above</option>
                                            <option value="9 & above" <?php echo isset($department->nps_score) && $department->nps_score == 9 ? 'selected' : ''; ?>>9 & above</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <button id="save_button" class="ui positive button"><?php echo display('save') ?></button>
                                    </div>
                                </div>




                                <!-- IP Feedback Link -->



                                <div class="form-group row">

                                    <label for="ip_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_ip_feedback_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->ip_feedback = base_url() . 'ip'; ?>

                                        <input name="ip_feedback" type="text" class="form-control" id="ip_feedback" value="<?php echo $department->ip_feedback ?>">

                                        <input type="hidden" name="ip_feedback_hidden" value="<?php echo $department->ip_feedback; ?>">

                                    </div>

                                </div>




                                <!-- OP Feedback Link -->



                                <div class="form-group row">

                                    <label for="op_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_op_feedback_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->op_feedback = base_url() . 'op'; ?>

                                        <input name="op_feedback" type="text" class="form-control" id="op_feedback" value="<?php echo $department->op_feedback ?>">

                                        <input type="hidden" name="op_feedback_hidden" value="<?php echo $department->op_feedback; ?>">

                                    </div>

                                </div>





                                <!-- PCF Feedback Link -->



                                <div class="form-group row">

                                    <label for="pcf_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_patient_cr_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->pcf_feedback = base_url() . 'pcf'; ?>

                                        <input name="pcf_feedback" type="text" class="form-control" id="pcf_feedback" value="<?php echo $department->pcf_feedback ?>">

                                        <input type="hidden" name="pcf_feedback_hidden" value="<?php echo $department->pcf_feedback; ?>">

                                    </div>

                                </div>





                                <!-- ISR Feedback Link -->



                                <div class="form-group row">

                                    <label for="esr_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_isr_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->esr_feedback = base_url() . 'sr'; ?>

                                        <input name="esr_feedback" type="text" class="form-control" id="esr_feedback" value="<?php echo $department->esr_feedback ?>">

                                        <input type="hidden" name="esr_feedback_hidden" value="<?php echo $department->esr_feedback; ?>">

                                    </div>

                                </div>





                                <!-- INC Feedback Link -->



                                <div class="form-group row">

                                    <label for="inci_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_healthcare_inc_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->inci_feedback = base_url() . 'in'; ?>

                                        <input name="inci_feedback" type="text" class="form-control" id="inci_feedback" value="<?php echo $department->inci_feedback ?>">

                                        <input type="hidden" name="inci_feedback_hidden" value="<?php echo $department->inci_feedback; ?>">

                                    </div>

                                </div>





                                <!-- SG Feedback Link -->



                                <div class="form-group row">

                                    <label for="sg_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_sg_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->sg_feedback = base_url() . 'gr'; ?>

                                        <input name="sg_feedback" type="text" class="form-control" id="sg_feedback" value="<?php echo $department->sg_feedback ?>">

                                        <input type="hidden" name="sg_feedback_hidden" value="<?php echo $department->sg_feedback; ?>">

                                    </div>

                                </div>





                                <!-- ADF Feedback Link -->



                                <div class="form-group row">

                                    <label for="adf_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_adf_feedback_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->adf_feedback = base_url() . 'adf'; ?>

                                        <input name="adf_feedback" type="text" class="form-control" id="adf_feedback" value="<?php echo $department->adf_feedback ?>">

                                        <input type="hidden" name="adf_feedback_hidden" value="<?php echo $department->adf_feedback; ?>">

                                    </div>

                                </div>





                                <!-- Feedback & complaint link for Inpatients -->

                                <div class="form-group row">

                                    <label for="online_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_fc_link_ip'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->online_feedback = base_url() . 'qrscan'; ?>

                                        <input name="online_feedback" type="text" class="form-control" id="online_feedback" value="<?php echo $department->online_feedback ?>">

                                        <input type="hidden" name="online_feedback_hidden" value="<?php echo $department->online_feedback; ?>">

                                    </div>

                                </div>



                                <!-- Quality module link for healthcare staffs -->

                                <div class="form-group row">

                                    <label for="staff_log_feedback" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_quality_module_link'); ?></label>

                                    <div class="col-xs-9">

                                        <?php $department->staff_log_feedback = base_url() . 'form_login'; ?>

                                        <input name="staff_log_feedback" type="text" class="form-control" id="staff_log_feedback" value="<?php echo $department->staff_log_feedback ?>">

                                        <input type="hidden" name="staff_log_feedback_hidden" value="<?php echo $department->staff_log_feedback; ?>">

                                    </div>

                                </div>

                                <!-- QR Code Image -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_fc_common_qr_code'); ?></label>

                                    <div class="col-xs-9">

                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->qr_code_image; ?>" style="height:200px;">

                                        <input name="qr_code_image" type="file" class="form-control">

                                    </div>

                                </div>

                                <!-- Inpatient QR Code -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_ip_qr_code'); ?></label>

                                    <div class="col-xs-9">

                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->ip_qr_code_image; ?>" style="height:200px;">

                                        <input name="ip_qr_code_image" type="file" class="form-control">

                                    </div>

                                </div>

                                <!-- Outpatient QR Code -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_op_qr_code'); ?></label>

                                    <div class="col-xs-9">

                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->op_qr_code_image; ?>" style="height:200px;">

                                        <input name="op_qr_code_image" type="file" class="form-control">

                                    </div>

                                </div>

                                <!-- Inpatient QR Code poster -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_ip_qr_code_poster'); ?></label>

                                    <div class="col-xs-9">

                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->ipposter_qr_code_image; ?>" style="height:200px;">

                                        <input name="ipposter_qr_code_image" type="file" class="form-control">

                                    </div>

                                </div>

                                <!-- Outpatient QR code poster -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_op_qr_code_poster'); ?></label>

                                    <div class="col-xs-9">

                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->opposter_qr_code_image; ?>" style="height:200px;">

                                        <input name="opposter_qr_code_image" type="file" class="form-control">

                                    </div>

                                </div>



                                <!-- Android APP(apk) -->

                                <div class="form-group row">

                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_android_app'); ?></label>

                                    <div class="col-xs-9">

                                        <a target="_blank" href="<?php echo base_url(); ?>uploads/<?php echo $department->android_apk; ?>" style="height:200px;"><?php echo $department->android_apk; ?></a>

                                        <input name="android_apk" type="file" class="form-control">

                                    </div>

                                </div>





                                <div class="form-group row">

                                    <div class="col-sm-offset-3 col-sm-6">

                                        <div class="ui buttons">

                                            <button type="reset" class="ui button"><?php echo display('reset') ?></button>

                                            <div class="or"></div>

                                            <button class="ui positive button"><?php echo display('save') ?></button>

                                        </div>

                                    </div>

                                </div>



                            <?php



                            } else {

                                // User with role other than 0

                            ?>


                                <div style="padding-left: 35px; padding-bottom: 15px; padding-top: 15px;">


                                    <fieldset class="info-section">
                                        <h3>Google Review Section</h3>
                                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                            <!-- Google Review Link -->
                                            <tr id="row1">

                                                <th><?php echo lang_loader('global', 'global_google_review_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $google_review_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php
                                                    // Ensure the URL starts with "http://" or "https://"
                                                    $google_review_link = $department->google_review_link;
                                                    if (strpos($google_review_link, 'http://') !== 0 && strpos($google_review_link, 'https://') !== 0) {
                                                        $google_review_link = 'https://' . $google_review_link;
                                                    }
                                                    ?>
                                                    <a href="<?php echo $google_review_link; ?>" target="_blank"><?php echo $google_review_link; ?></a>

                                                </td>

                                            </tr>

                                            <!--Set custom Google Review value -->
                                            <tr id="row2">
                                                <th>Set Google review benchmark
                                                    <span>
                                                        <a title="<?php echo $google_review_tooltip; ?>">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </a>
                                                    </span>
                                                </th>
                                                <td>
                                                    <label for="psat_score">PSAT Score:</label>
                                                    <!-- PSAT Dropdown -->
                                                    <select id="psat_score" name="psat_score">
                                                        <option value="3 & above" <?php echo isset($department->psat_score) && $department->psat_score == 3 ? 'selected' : ''; ?>>3 & above</option>
                                                        <option value="4 & above" <?php echo isset($department->psat_score) && $department->psat_score == 4 ? 'selected' : ''; ?>>4 & above</option>

                                                    </select>

                                                    <label for="nps_score" style="margin-left: 15px;">NPS Score:</label>
                                                    <!-- NPS Dropdown -->
                                                    <select id="nps_score" name="nps_score">
                                                        <option value="7 & above" <?php echo isset($department->nps_score) && $department->nps_score == 7 ? 'selected' : ''; ?>>7 & above</option>
                                                        <option value="8 & above" <?php echo isset($department->nps_score) && $department->nps_score == 8 ? 'selected' : ''; ?>>8 & above</option>
                                                        <option value="9 & above" <?php echo isset($department->nps_score) && $department->nps_score == 9 ? 'selected' : ''; ?>>9 & above</option>
                                                    </select>

                                                    <button id="save_button" class="ui positive button"><?php echo display('save') ?></button>

                                                </td>

                                            </tr>

                                        </table>
                                    </fieldset>

                                    <fieldset class="info-section">
                                        <h3>Input Feedback Form Section</h3>
                                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                            <!-- IP Feedback Link -->
                                            <?php if (ismodule_active('IP') === true) { ?>

                                                <tr>

                                                    <th><?php echo lang_loader('global', 'global_ip_feedback_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ip_discharge_feedback_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span> </th>

                                                    <td>

                                                        <a href="<?php echo $department->ip_feedback ?>" target="_blank"><?php echo $department->ip_feedback ?></a>

                                                    </td>

                                                </tr>

                                            <?php } ?>

                                            <!-- OP Feedback Link -->
                                            <?php if (ismodule_active('OP') === true) { ?>

                                                <tr>

                                                    <th>Outpatient Feedback Link <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $outpatient_feedback_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                    <td>

                                                        <a href="<?php echo $department->op_feedback ?>" target="_blank"><?php echo $department->op_feedback ?></a>

                                                    </td>

                                                </tr>

                                            <?php } ?>

                                            <!-- PCF Feedback Link -->
                                            <?php if (ismodule_active('PCF') === true) { ?>

                                                <tr>

                                                    <th><?php echo lang_loader('global', 'global_patient_cr_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $patient_complaints_request_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                    <td>

                                                        <a href="<?php echo $department->pcf_feedback ?>" target="_blank"><?php echo $department->pcf_feedback ?></a>

                                                    </td>

                                                </tr>

                                            <?php } ?>

                                            <!-- ESR Feedback Link -->
                                            <!-- <?php if (ismodule_active('ISR') === true) { ?>

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_isr_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $internal_service_request_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <a href="<?php echo $department->esr_feedback ?>" target="_blank"><?php echo $department->esr_feedback ?></a>

                                                </td>

                                            </tr>

                                        <?php } ?> -->



                                            <!-- INC Feedback Link -->

                                            <!-- <?php if (ismodule_active('INCIDENT') === true) { ?>

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_healthcare_inc_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $healthcare_incident_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <a href="<?php echo $department->inci_feedback ?>" target="_blank"><?php echo $department->inci_feedback ?></a>

                                                </td>

                                            </tr>

                                        <?php } ?> -->



                                            <!-- SG Feedback Link -->

                                            <!-- <?php if (ismodule_active('GRIEVANCE') === true) { ?>

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_sg_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $staff_grievance_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <a href="<?php echo $department->sg_feedback ?>" target="_blank"><?php echo $department->sg_feedback ?></a>

                                                </td>

                                            </tr>

                                        <?php } ?> -->


                                            <!-- ADF Feedback Link -->

                                            <?php if (ismodule_active('ADF') === true) { ?>

                                                <tr>

                                                    <th><?php echo lang_loader('global', 'global_adf_feedback_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $adf_feedback_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                    <td>

                                                        <a href="<?php echo $department->adf_feedback ?>" target="_blank"><?php echo $department->adf_feedback ?></a>

                                                    </td>

                                                </tr>

                                            <?php } ?>


                                            <?php if (ismodule_active('PCF') === true) { ?>
                                                <!-- Online Feedback Link -->

                                                <tr>

                                                    <th><?php echo lang_loader('global', 'global_fc_link_ip'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $feedback_complaint_inpatients_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                    <td>

                                                        <a href="<?php echo $department->online_feedback ?>" target="_blank"><?php echo $department->online_feedback ?></a>

                                                    </td>

                                                </tr>
                                            <?php } ?>

                                            <!-- Quality module link for healthcare staffs -->
                                            <?php if (ismodule_active('ISR') === true) { ?>
                                                <tr>

                                                    <th><?php echo lang_loader('global', 'global_quality_module_link'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $quality_module_healthcare_staffs_link_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                    <td>

                                                        <a href="<?php echo $department->staff_log_feedback ?>" target="_blank"><?php echo $department->staff_log_feedback ?></a>

                                                    </td>

                                                </tr>
                                            <?php } ?>

                                        </table>
                                    </fieldset>

                                    <fieldset class="info-section">
                                        <h3>Android APK Section</h3>
                                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                            <!-- Android APP(apk) -->
                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_android_app'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $android_apk_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <button class="btn btn-success" type="download" style="background:#fff;">

                                                        <a target="_blank" href="<?php echo base_url(); ?>uploads/<?php echo $department->android_apk; ?>">

                                                            <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download_android_app'); ?>

                                                        </a>

                                                    </button>

                                                </td>

                                            </tr>
                                        </table>
                                    </fieldset>

                                    <fieldset class="info-section">
                                        <h3>QR Code Section</h3>
                                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_ip_qr_code'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $inpatient_qr_code_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php

                                                    $imagePath = base_url() . 'uploads/' . $department->ip_qr_code_image;

                                                    $pdfPath = base_url() . 'uploads/' . $department->ip_qr_code_image;

                                                    $isImage = in_array(pathinfo($department->ip_qr_code_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);



                                                    if ($isImage) :

                                                        // Display image

                                                    ?>

                                                        <div>

                                                            <img src="<?php echo $imagePath; ?>" style="height:200px;">

                                                        </div>



                                                    <?php endif; ?>



                                                    <!-- Download button (common for both image and PDF) -->

                                                    <div style="text-align: left;">

                                                        <br>

                                                        <button class="btn btn-success" type="button" style="background:#fff;">

                                                            <a target="_blank" href="<?php echo $isImage ? $imagePath : $pdfPath; ?>">

                                                                <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download'); ?>

                                                            </a>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>



                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_op_qr_code'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $outpatient_qr_code_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php

                                                    $imagePath = base_url() . 'uploads/' . $department->op_qr_code_image;

                                                    $pdfPath = base_url() . 'uploads/' . $department->op_qr_code_image;

                                                    $isImage = in_array(pathinfo($department->op_qr_code_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);



                                                    if ($isImage) :

                                                        // Display image

                                                    ?>

                                                        <div>

                                                            <img src="<?php echo $imagePath; ?>" style="height:200px;">

                                                        </div>



                                                    <?php endif; ?>



                                                    <!-- Download button (common for both image and PDF) -->

                                                    <div style="text-align: left;">

                                                        <br>

                                                        <button class="btn btn-success" type="button" style="background:#fff;">

                                                            <a target="_blank" href="<?php echo $isImage ? $imagePath : $pdfPath; ?>">

                                                                <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download'); ?>

                                                            </a>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                            <!-- common qr code  -->

                                            <tr>

                                                <th>Feedback & complaint common QR Code <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $outpatient_qr_code_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php

                                                    $imagePath = base_url() . 'uploads/' . $department->qr_code_image;

                                                    $pdfPath = base_url() . 'uploads/' . $department->qr_code_image;

                                                    $isImage = in_array(pathinfo($department->qr_code_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);



                                                    if ($isImage) :

                                                        // Display image

                                                    ?>

                                                        <div>

                                                            <img src="<?php echo $imagePath; ?>" style="height:200px;">

                                                        </div>



                                                    <?php endif; ?>



                                                    <!-- Download button (common for both image and PDF) -->

                                                    <div style="text-align: left;">

                                                        <br>

                                                        <button class="btn btn-success" type="button" style="background:#fff;">

                                                            <a target="_blank" href="<?php echo $isImage ? $imagePath : $pdfPath; ?>">

                                                                <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download'); ?>

                                                            </a>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        </table>
                                    </fieldset>

                                    <fieldset class="info-section">
                                        <h3>QR Code Poster Section</h3>
                                        <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_ip_qr_code_poster'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $inpatient_qr_code_poster_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php

                                                    $imagePath = base_url() . 'uploads/' . $department->ipposter_qr_code_image;

                                                    $pdfPath = base_url() . 'uploads/' . $department->ipposter_qr_code_image;

                                                    $isImage = in_array(pathinfo($department->ipposter_qr_code_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);



                                                    if ($isImage) :

                                                        // Display image

                                                    ?>

                                                        <div>

                                                            <img src="<?php echo $imagePath; ?>" style="height:200px;">

                                                        </div>



                                                    <?php endif; ?>



                                                    <!-- Download button (common for both image and PDF) -->

                                                    <div style="text-align: left;">

                                                        <br>

                                                        <button class="btn btn-success" type="button" style="background:#fff;">

                                                            <a target="_blank" href="<?php echo $isImage ? $imagePath : $pdfPath; ?>">

                                                                <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download'); ?>

                                                            </a>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                            <tr>

                                                <th><?php echo lang_loader('global', 'global_op_qr_code_poster'); ?> <span><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $outpatient_qr_code_poster_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></span></th>

                                                <td>

                                                    <?php

                                                    $imagePath = base_url() . 'uploads/' . $department->opposter_qr_code_image;

                                                    $pdfPath = base_url() . 'uploads/' . $department->opposter_qr_code_image;

                                                    $isImage = in_array(pathinfo($department->opposter_qr_code_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);



                                                    if ($isImage) :

                                                        // Display image

                                                    ?>

                                                        <div>

                                                            <img src="<?php echo $imagePath; ?>" style="height:200px;">

                                                        </div>



                                                    <?php endif; ?>



                                                    <!-- Download button (common for both image and PDF) -->

                                                    <div style="text-align: left;">

                                                        <br>

                                                        <button class="btn btn-success" type="button" style="background:#fff;">

                                                            <a target="_blank" href="<?php echo $isImage ? $imagePath : $pdfPath; ?>">

                                                                <i class="fa fa-download"></i> <?php echo lang_loader('global', 'global_download'); ?>

                                                            </a>

                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        </table>
                                    </fieldset>


                                </div>




                            <?php } ?>



                            <?php echo form_close() ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<style>
    .info-section {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }

    .info-section h3 {
        font-size: 1.2em;
        font-weight: bold;
        color: #333;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
        color: #333;
        width: 40%;
    }

    .table td {
        width: 60%;
    }


    .table td a:hover {
        text-decoration: underline;
    }

    .form-group {
        display: flex;
        align-items: center;
    }

    .form-group label {
        margin-right: 10px;
    }

    .form-group select {
        margin-right: 15px;
    }

    .ui.positive.button {
        margin-left: 15px;
    }

    /* Style for the dropdowns */
    select {
        display: inline-block;
        padding: 8px 12px;
        font-size: 14px;
        line-height: 1.5;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        width: auto;
        margin-right: 15px;

    }

    label {
        font-size: 14px;
        color: #333;
        margin-right: 5px;
    }

    /* Style for the save button */
    #save_button {
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #28a745;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }


    #save_button:hover {
        background-color: #218838;
    }
</style>

<script>
    function saveGoogle() {
        document.getElementById('save_button').addEventListener('click', function() {

            // Get selected values from the dropdowns
            var selectedPSAT = document.getElementById('psat_score').value;
            var selectedNPS = document.getElementById('nps_score').value;

            // Call the AngularJS function to update the scope variables
            var scope = angular.element(document.getElementById('save_button')).scope();
            scope.$apply(function() {
                scope.updateFeedbackScores(selectedPSAT, selectedNPS);
            });

            // Create a hidden form to submit the data (if still required)
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo site_url('settings/supplementary_info'); ?>';

            // Create and append hidden inputs for the PSAT and NPS scores
            form.appendChild(createHiddenInput('psat_score', selectedPSAT));
            form.appendChild(createHiddenInput('nps_score', selectedNPS));

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();

        });

        // Helper function to create a hidden input field
        function createHiddenInput(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    }

    // Initialize the saveGoogle function when the page is ready
    document.addEventListener('DOMContentLoaded', saveGoogle);


    function ip_qr_code_image() {

        var downloadLink = document.createElement('a');

        downloadLink.href = "<?php echo base_url(); ?>uploads/<?php echo $department->ip_qr_code_image; ?>";

        downloadLink.download = "ip_qr_code_image.png";

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);

    }



    function op_qr_code_image() {

        var downloadLink = document.createElement('a');

        downloadLink.href = "<?php echo base_url(); ?>uploads/<?php echo $department->op_qr_code_image; ?>";

        downloadLink.download = "op_qr_code_image.png";

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);

    }



    function ipposter_qr_code_image() {

        var downloadLink = document.createElement('a');

        downloadLink.href = "<?php echo base_url(); ?>uploads/<?php echo $department->ipposter_qr_code_image; ?>";

        downloadLink.download = "ipposter_qr_code_image.png";

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);

    }



    function opposter_qr_code_image() {

        var downloadLink = document.createElement('a');

        downloadLink.href = "<?php echo base_url(); ?>uploads/<?php echo $department->opposter_qr_code_image; ?>";

        downloadLink.download = "opposter_qr_code_image.png";

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);

    }
</script>