<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_medication_administration');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);

?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip"
                            title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Medication administration
                        audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_medication_administration_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td>
                                <b>Audit Details</b>
                            </td>
                            <td style="overflow: clip;">
                                Audit Name: <?php echo $param['audit_type']; ?>
                                <br>
                                Date & Time of Audit: <?php echo date('Y-m-d H:i', strtotime($row->datetime)); ?>
                                <br>
                                Audit by: <?php echo $param['audit_by']; ?>

                                <!-- Hidden inputs -->
                                <input class="form-control" type="hidden" name="audit_type"
                                    value="<?php echo $param['audit_type']; ?>" />
                                <input class="form-control" type="hidden" name="datetime"
                                    value="<?php echo $row->datetime; ?>" />
                                <input class="form-control" type="hidden" name="audit_by"
                                    value="<?php echo $param['audit_by']; ?>" />
                            </td>
                        </tr>


                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td style="width: 43%;"><b>Patient MID</b></td>
                            <td>
                                <input class="form-control" type="text" name="mid_no"
                                    value="<?php echo $param['mid_no']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Patient Name</b></td>
                            <td>
                                <input class="form-control" type="text" name="patient_name"
                                    value="<?php echo $param['patient_name']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Patient Age</b></td>
                            <td>
                                <input class="form-control" type="text" name="patient_age"
                                    value="<?php echo $param['patient_age']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Patient Gender</b></td>
                            <td>
                                <select class="form-control" name="patient_gender">
                                    <option value="" <?php if (empty($param['patient_gender']))
                                        echo 'selected'; ?>>
                                    </option>
                                    <option value="Male" <?php if ($param['patient_gender'] == 'Male')
                                        echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($param['patient_gender'] == 'Female')
                                        echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if ($param['patient_gender'] == 'Other')
                                        echo 'selected'; ?>>Other</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Area</b></td>
                            <td>
                                <select class="form-control" name="location">
                                    <option value="">Select Area</option>
                                    <?php
                                    $areas = $this->db->get('bf_audit_area')->result_array();
                                    foreach ($areas as $a) {
                                        $selected = ($param['location'] == $a['title']) ? 'selected' : '';
                                        echo "<option value='{$a['title']}' $selected>{$a['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Department</b></td>
                            <td>
                                <select class="form-control" name="department">
                                    <option value="">Select Department</option>
                                    <?php
                                    $departments = $this->db->get('bf_audit_department')->result_array();
                                    foreach ($departments as $d) {
                                        $selected = ($param['department'] == $d['title']) ? 'selected' : '';
                                        echo "<option value='{$d['title']}' $selected>{$d['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Attended Doctor</b></td>
                            <td>
                                <select class="form-control" name="attended_doctor">
                                    <option value="">Select Doctor</option>
                                    <?php
                                    $doctors = $this->db->get('bf_audit_doctor')->result_array();
                                    foreach ($doctors as $doc) {
                                        $selected = ($param['attended_doctor'] == $doc['title']) ? 'selected' : '';
                                        echo "<option value='{$doc['title']}' $selected>{$doc['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        // Common max datetime to disable future selection
                        $maxDatetime = date('Y-m-d\TH:i');
                        ?>

                        <!-- 🟩 Admission Date & Time (Editable) -->
                        <tr>
                            <td><b>Admission / Visit Date & Time</b></td>
                            <td>
                                <?php
                                $admissionDatetime = '';
                                if (!empty($param['initial_assessment_hr6']) && $param['initial_assessment_hr6'] != '1970-01-01 05:30:00') {
                                    $admissionDatetime = date('Y-m-d\TH:i', strtotime($param['initial_assessment_hr6']));
                                } else {
                                    $admissionDatetime = $maxDatetime; // Default current date-time
                                }
                                ?>
                                <input class="form-control datetime-picker" type="datetime-local" id="admissionDatetime"
                                    name="initial_assessment_hr6" value="<?php echo $admissionDatetime; ?>"
                                    max="<?php echo $maxDatetime; ?>">
                            </td>
                        </tr>

                        <!-- 🟩 Discharge Date & Time (Editable) -->
                        <tr>
                            <td><b>Discharge Date & Time</b></td>
                            <td>
                                <?php
                                $dischargeDatetime = '';
                                if (!empty($param['discharge_date_time']) && $param['discharge_date_time'] != '1970-01-01 05:30:00') {
                                    $dischargeDatetime = date('Y-m-d\TH:i', strtotime($param['discharge_date_time']));
                                } else {
                                    $dischargeDatetime = ''; // Leave empty if no valid value
                                }
                                ?>
                                <input class="form-control datetime-picker" type="datetime-local" id="dischargeDatetime"
                                    name="discharge_date_time" value="<?php echo $dischargeDatetime; ?>"
                                    max="<?php echo date('Y-m-d\TH:i'); ?>">
                            </td>
                        </tr>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                // Select all datetime pickers
                                const pickers = document.querySelectorAll(".datetime-picker");

                                pickers.forEach(function (input) {
                                    // Dynamically restrict to current date/time as maximum
                                    input.max = new Date().toISOString().slice(0, 16);

                                    // Auto-open picker on click (modern browsers)
                                    input.addEventListener("click", function () {
                                        if (this.showPicker) this.showPicker();
                                    });
                                });
                            });
                        </script>



                        <script>
                            // Force open calendar picker when clicking anywhere in the input box
                            document.querySelectorAll('.datetime-picker').forEach(function (input) {
                                input.addEventListener('click', function () {
                                    this.showPicker(); // Opens the native calendar/clock popup
                                });
                            });
                        </script>
                        <style>
                            .datetime-picker {
                                cursor: pointer;
                            }
                        </style>
                        <tr>
                            <td><b>Have you checked own medications and verified the medication order, including drug
                                    name, dose, route, time, and frequency?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medication_order"
                                    value="<?php echo isset($param['gloves']) ? htmlspecialchars($param['gloves'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medication_order_text"
                                        value="<?php echo isset($param['gloves_text']) ? htmlspecialchars($param['gloves_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you confirm that the prescribed medicine is written in the order?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_written"
                                    value="<?php echo isset($param['mask']) ? htmlspecialchars($param['mask'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medicine_written_text"
                                        value="<?php echo isset($param['mask_text']) ? htmlspecialchars($param['mask_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the medication tray stocked with all required articles?</b></td>
                            <td>
                                <input class="form-control" type="text" name="tray_stocked"
                                    value="<?php echo isset($param['cap']) ? htmlspecialchars($param['cap'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="tray_stocked_text"
                                        value="<?php echo isset($param['cap_text']) ? htmlspecialchars($param['cap_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you perform handwashing or use hand rub before administering the medication to
                                    patient?</b></td>
                            <td>
                                <input class="form-control" type="text" name="handwash_before"
                                    value="<?php echo isset($param['apron']) ? htmlspecialchars($param['apron'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="handwash_before_text"
                                        value="<?php echo isset($param['apron_text']) ? htmlspecialchars($param['apron_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you greet and identify the patient using two identification methods?</b></td>
                            <td>
                                <input class="form-control" type="text" name="patient_identification"
                                    value="<?php echo isset($param['lead_apron']) ? htmlspecialchars($param['lead_apron'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="patient_identification_text"
                                        value="<?php echo isset($param['lead_apron_text']) ? htmlspecialchars($param['lead_apron_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have you explained the procedure to the patient and verified their allergic
                                    status?</b></td>
                            <td>
                                <input class="form-control" type="text" name="explained_procedure"
                                    value="<?php echo isset($param['use_xray_barrior']) ? htmlspecialchars($param['use_xray_barrior'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="explained_procedure_text"
                                        value="<?php echo isset($param['use_xray_barrior_text']) ? htmlspecialchars($param['use_xray_barrior_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you check and ensure that all medications are present at the patient’s side with
                                    patient’s file?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medications_present"
                                    value="<?php echo isset($param['patient_file']) ? htmlspecialchars($param['patient_file'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medications_present_text"
                                        value="<?php echo isset($param['patient_file_text']) ? htmlspecialchars($param['patient_file_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have you verified the medicine for its name, expiry date, color, and texture?</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="medicine_verified"
                                    value="<?php echo isset($param['verified']) ? htmlspecialchars($param['verified'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medicine_verified_text"
                                        value="<?php echo isset($param['verified_text']) ? htmlspecialchars($param['verified_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you explain the drug indication, expected action, reaction, and side effects to
                                    the patient or relatives?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_explained"
                                    value="<?php echo isset($param['indication']) ? htmlspecialchars($param['indication'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="drug_explained_text"
                                        value="<?php echo isset($param['indication_text']) ? htmlspecialchars($param['indication_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is all medicine available for use at the bedside on time?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_available"
                                    value="<?php echo isset($param['medicine']) ? htmlspecialchars($param['medicine'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medicine_available_text"
                                        value="<?php echo isset($param['medicine_text']) ? htmlspecialchars($param['medicine_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>For high-alert drugs, did you ensure verification by one staff nurse before
                                    administration?</b></td>
                            <td>
                                <input class="form-control" type="text" name="high_alert_verified"
                                    value="<?php echo isset($param['alert']) ? htmlspecialchars($param['alert'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="high_alert_verified_text"
                                        value="<?php echo isset($param['alert_text']) ? htmlspecialchars($param['alert_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have you labeled the prepared medicine with the drug name and dilution?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_labeled"
                                    value="<?php echo isset($param['dilution']) ? htmlspecialchars($param['dilution'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="medicine_labeled_text"
                                        value="<?php echo isset($param['dilution_text']) ? htmlspecialchars($param['dilution_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are you administering the medication as per approved techniques?</b></td>
                            <td>
                                <input class="form-control" type="text" name="approved_techniques"
                                    value="<?php echo isset($param['administering']) ? htmlspecialchars($param['administering'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="approved_techniques_text"
                                        value="<?php echo isset($param['administering_text']) ? htmlspecialchars($param['administering_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you provide privacy for the patient if needed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="privacy_provided"
                                    value="<?php echo isset($param['privacy']) ? htmlspecialchars($param['privacy'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="privacy_provided_text"
                                        value="<?php echo isset($param['privacy_text']) ? htmlspecialchars($param['privacy_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>For multi-dose vials, did you note the date and time of opening on the medicine?</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="vials_noted"
                                    value="<?php echo isset($param['vials']) ? htmlspecialchars($param['vials'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="vials_noted_text"
                                        value="<?php echo isset($param['vials_text']) ? htmlspecialchars($param['vials_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you check the patency and status of the cannula, including the date and time of
                                    cannulation near the site?</b></td>
                            <td>
                                <input class="form-control" type="text" name="cannula_checked"
                                    value="<?php echo isset($param['cannula']) ? htmlspecialchars($param['cannula'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="cannula_checked_text"
                                        value="<?php echo isset($param['cannula_text']) ? htmlspecialchars($param['cannula_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>After IV administration, did you flush the line with normal saline?</b></td>
                            <td>
                                <input class="form-control" type="text" name="line_flushed"
                                    value="<?php echo isset($param['flush']) ? htmlspecialchars($param['flush'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="line_flushed_text"
                                        value="<?php echo isset($param['flush_text']) ? htmlspecialchars($param['flush_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are IV medications being run on time, and have they been discontinued or discarded
                                    appropriately?</b></td>
                            <td>
                                <input class="form-control" type="text" name="iv_medications"
                                    value="<?php echo isset($param['medications']) ? htmlspecialchars($param['medications'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="iv_medications_text"
                                        value="<?php echo isset($param['medications_text']) ? htmlspecialchars($param['medications_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>After administering the medication, did you reassess the patient for any reactions
                                    and ensure their comfort?</b></td>
                            <td>
                                <input class="form-control" type="text" name="reassessed"
                                    value="<?php echo isset($param['reassess']) ? htmlspecialchars($param['reassess'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="reassessed_text"
                                        value="<?php echo isset($param['reassess_text']) ? htmlspecialchars($param['reassess_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>For oral medications, have you ensured that the patient has taken the medications and
                                    that no medicine is left unattended?</b></td>
                            <td>
                                <input class="form-control" type="text" name="oral_medications"
                                    value="<?php echo isset($param['oral']) ? htmlspecialchars($param['oral'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="oral_medications_text"
                                        value="<?php echo isset($param['oral_text']) ? htmlspecialchars($param['oral_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have you discarded waste and replaced used articles?</b></td>
                            <td>
                                <input class="form-control" type="text" name="waste_discarded"
                                    value="<?php echo isset($param['discarded']) ? htmlspecialchars($param['discarded'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="waste_discarded_text"
                                        value="<?php echo isset($param['discarded_text']) ? htmlspecialchars($param['discarded_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Did you perform handwashing or use hand rub after the procedure?</b></td>
                            <td>
                                <input class="form-control" type="text" name="handwashing_after"
                                    value="<?php echo isset($param['handwashing']) ? htmlspecialchars($param['handwashing'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="handwashing_after_text"
                                        value="<?php echo isset($param['handwashing_text']) ? htmlspecialchars($param['handwashing_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have you recorded the procedure in the documents immediately after completing it?</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="procedure_recorded"
                                    value="<?php echo isset($param['procedures']) ? htmlspecialchars($param['procedures'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="procedure_recorded_text"
                                        value="<?php echo isset($param['procedures_text']) ? htmlspecialchars($param['procedures_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis"
                                    value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Uploaded Files</b></td>
                            <td>
                                <?php
                                // $param = json_decode($record->dataset, true);
                                $existingFiles = !empty($param['files_name']) ? $param['files_name'] : [];
                                ?>

                                <!-- 🗂 Existing Files Section -->
                                <div id="existing-files">
                                    <?php if (!empty($existingFiles)) { ?>
                                        <!-- <label><b>Current Files:</b></label> -->
                                        <ul id="file-list" style="list-style-type:none; padding-left:0;">
                                            <?php foreach ($existingFiles as $index => $file) { ?>
                                                <li data-index="<?php echo $index; ?>"
                                                    style="margin-bottom:6px; background:#f8f9fa; padding:6px 10px; border-radius:6px; display:flex; align-items:center; justify-content:space-between;">
                                                    <a href="<?php echo htmlspecialchars($file['url']); ?>" target="_blank"
                                                        style="text-decoration:none; color:#007bff;">
                                                        <?php echo htmlspecialchars($file['name']); ?>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger remove-file"
                                                        style="margin-left:10px; padding:2px 6px; font-size:12px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>
                                        <p id="no-files">No files uploaded</p>
                                    <?php } ?>
                                </div>

                                <!-- 📤 Dynamic Upload Inputs -->
                                <div class="form-group" id="upload-container" style="margin-top:10px;">
                                    <label><b>Add New Files:</b></label>
                                    <div class="upload-row"
                                        style="display:flex; align-items:center; margin-bottom:6px;">
                                        <input type="file" name="uploaded_files[]" class="form-control upload-input"
                                            style="flex:1; margin-right:10px;">
                                        <button type="button" class="btn btn-danger btn-sm remove-upload"
                                            style="display:none;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- ➕ Add More Files Button -->
                                <button type="button" id="add-more-files" class="btn btn-sm btn-success"
                                    style="margin-top:5px;">
                                    <i class="fa fa-plus"></i> Add More Files
                                </button>

                                <!-- Hidden input for removed old files -->
                                <input type="hidden" name="remove_files_json" id="remove_files_json" value="">
                            </td>
                        </tr>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {

                                // 🗑️ Handle removing existing old files
                                const removeInput = document.getElementById("remove_files_json");
                                let removedIndexes = [];

                                document.querySelectorAll(".remove-file").forEach(btn => {
                                    btn.addEventListener("click", function () {
                                        const li = this.closest("li");
                                        const index = li.getAttribute("data-index");
                                        removedIndexes.push(index);
                                        removeInput.value = JSON.stringify(removedIndexes);
                                        li.remove();
                                        if (document.querySelectorAll("#file-list li").length === 0) {
                                            document.getElementById("existing-files").innerHTML = "<p id='no-files'>No files uploaded</p>";
                                        }
                                    });
                                });

                                // ➕ Dynamic "Add More Files"
                                const addMoreBtn = document.getElementById("add-more-files");
                                const uploadContainer = document.getElementById("upload-container");

                                addMoreBtn.addEventListener("click", function () {
                                    const newRow = document.createElement("div");
                                    newRow.className = "upload-row";
                                    newRow.style.cssText = "display:flex; align-items:center; margin-bottom:6px;";

                                    const input = document.createElement("input");
                                    input.type = "file";
                                    input.name = "uploaded_files[]";
                                    input.className = "form-control upload-input";
                                    input.style.cssText = "flex:1; margin-right:10px;";

                                    const removeBtn = document.createElement("button");
                                    removeBtn.type = "button";
                                    removeBtn.className = "btn btn-danger btn-sm remove-upload";
                                    removeBtn.innerHTML = '<i class="fa fa-times"></i>';
                                    removeBtn.addEventListener("click", function () {
                                        newRow.remove();
                                    });
                                    removeBtn.style.display = "inline-block";

                                    newRow.appendChild(input);
                                    newRow.appendChild(removeBtn);
                                    uploadContainer.appendChild(newRow);
                                });
                            });
                        </script>


                        <tr>
                            <td colspan="2">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button">
                                            <?php echo 'Reset'; ?>
                                        </button>
                                        <div class="or"></div>
                                        <button type="submit" class="ui positive button" style="text-align: left;">
                                            <?php echo display('save') ?>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateAdherenceRate() {
        var adheringStaff = parseInt(document.getElementById('initial_assessment_hr').value);
        var auditedStaff = parseInt(document.getElementById('total_admission').value);

        if (isNaN(adheringStaff) || adheringStaff < 0) {
            alert("Enter the number of staff adhering to safety precautions.");
            return;
        }

        if (isNaN(auditedStaff) || auditedStaff <= 0) {
            alert("Enter the number of staff audited.");
            return;
        }

        if (adheringStaff > auditedStaff) {
            alert("The number of staff adhering to safety precautions must be less than the number of staff audited.");
            return;
        }

        var adherencePercentage = (adheringStaff / auditedStaff) * 100;
        var calculatedResult = adherencePercentage % 1 === 0 ? adherencePercentage.toString() : adherencePercentage.toFixed(2);

        document.getElementById('calculatedResult').value = calculatedResult;

        console.log("Calculated result:", calculatedResult);
    }
</script>