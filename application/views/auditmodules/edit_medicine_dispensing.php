<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_medicine_dispense');
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
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Medication management process audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_medicine_dispense_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            document.addEventListener("DOMContentLoaded", function() {
                                // Select all datetime pickers
                                const pickers = document.querySelectorAll(".datetime-picker");

                                pickers.forEach(function(input) {
                                    // Dynamically restrict to current date/time as maximum
                                    input.max = new Date().toISOString().slice(0, 16);

                                    // Auto-open picker on click (modern browsers)
                                    input.addEventListener("click", function() {
                                        if (this.showPicker) this.showPicker();
                                    });
                                });
                            });
                        </script>



                        <script>
                            // Force open calendar picker when clicking anywhere in the input box
                            document.querySelectorAll('.datetime-picker').forEach(function(input) {
                                input.addEventListener('click', function() {
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
                            <td><b>Consultant Name</b></td>
                            <td>
                                <input class="form-control" type="text" name="consultant_name" value="<?php echo $param['consultant_name']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Diagnosis</b></td>
                            <td>
                                <input class="form-control" type="text" name="diagnosis" value="<?php echo $param['diagnosis']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Medicine Name</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicinename" value="<?php echo $param['medicinename']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                I. DOCTORS
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                1. Incorrect Prescription
                            </td>
                        </tr>

                        <tr>
                            <td><b>a. Has the correct drug been selected for the patient's condition?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_medicine" value="<?php echo $param['correct_medicine']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_medicine_text" placeholder="Remarks" value="<?php echo $param['correct_medicine_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>b. Has the appropriate dose been prescribed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_quantity" value="<?php echo $param['correct_quantity']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_quantity_text" placeholder="Remarks" value="<?php echo $param['correct_quantity_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>c. Has the correct unit of measurement for the drug dose been used?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_expiry" value="<?php echo $param['medicine_expiry']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="medicine_expiry_text" placeholder="Remarks" value="<?php echo $param['medicine_expiry_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>d. Has the correct frequency of administration been specified?</b></td>
                            <td>
                                <input class="form-control" type="text" name="apron" value="<?php echo $param['apron']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="apron_text" placeholder="Remarks" value="<?php echo $param['apron_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>e. Has the correct route of administration been mentioned?</b></td>
                            <td>
                                <input class="form-control" type="text" name="lead_apron" value="<?php echo $param['lead_apron']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="lead_apron_text" placeholder="Remarks" value="<?php echo $param['lead_apron_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>f. Has the correct drug concentration been prescribed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="use_xray_barrior" value="<?php echo $param['use_xray_barrior']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="use_xray_barrior_text" placeholder="Remarks" value="<?php echo $param['use_xray_barrior_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>g. Has the correct rate of administration been indicated?</b></td>
                            <td>
                                <input class="form-control" type="text" name="administration_rate" value="<?php echo $param['administration_rate']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="administration_rate_text" placeholder="Remarks" value="<?php echo $param['administration_rate_text']; ?>">
                            </td>
                        </tr>



                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                2. Therapeutic Duplication
                            </td>
                        </tr>


                        <tr>
                            <td><b>a. Has the prescription been checked for therapeutic duplication?</b></td>
                            <td>
                                <input class="form-control" type="text" name="therapeutic_duplication" value="<?php echo $param['therapeutic_duplication']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="therapeutic_duplication_text" placeholder="Remarks" value="<?php echo $param['therapeutic_duplication_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                3. Illegible Handwriting
                            </td>
                        </tr>


                        <tr>
                            <td><b>a. Is the handwriting legible and easily understandable?</b></td>
                            <td>
                                <input class="form-control" type="text" name="handwriting_legible" value="<?php echo $param['handwriting_legible']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="handwriting_legible_text" placeholder="Remarks" value="<?php echo $param['handwriting_legible_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                4. Non-approved Abbreviations
                            </td>
                        </tr>


                        <tr>
                            <td><b>a. Have only approved medical abbreviations been used in the prescription?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medical_abbreviations" value="<?php echo $param['medical_abbreviations']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="medical_abbreviations_text" placeholder="Remarks" value="<?php echo $param['medical_abbreviations_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                5. Non-usage of Capital Letters for Drug Names
                            </td>
                        </tr>


                        <tr>
                            <td><b>a. Have drug names been written using capital letters to avoid confusion?</b></td>
                            <td>
                                <input class="form-control" type="text" name="capital_letters" value="<?php echo $param['capital_letters']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="capital_letters_text" placeholder="Remarks" value="<?php echo $param['capital_letters_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>b. Has the drug been prescribed using its generic name?</b></td>
                            <td>
                                <input class="form-control" type="text" name="generic_name" value="<?php echo $param['generic_name']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="generic_name_text" placeholder="Remarks" value="<?php echo $param['generic_name_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>c. Has the drug dose been modified considering potential drug-drug interactions?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_interaction" value="<?php echo $param['drug_interaction']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="drug_interaction_text" placeholder="Remarks" value="<?php echo $param['drug_interaction_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>d. Has the timing, dose, or choice of drug been adjusted considering food-drug interactions?</b></td>
                            <td>
                                <input class="form-control" type="text" name="food_drug" value="<?php echo $param['food_drug']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="food_drug_text" placeholder="Remarks" value="<?php echo $param['food_drug_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>e. Has the correct drug been dispensed as per the prescription?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_dispensed" value="<?php echo $param['drug_dispensed']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="drug_dispensed_text" placeholder="Remarks" value="<?php echo $param['drug_dispensed_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>f. Has the correct dose of the medication been dispensed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="dose_dispensed" value="<?php echo $param['dose_dispensed']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="dose_dispensed_text" placeholder="Remarks" value="<?php echo $param['dose_dispensed_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>g. Has the correct formulation (e.g., tablet, syrup, injection) been dispensed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="formulation_dispensed" value="<?php echo $param['formulation_dispensed']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="formulation_dispensed_text" placeholder="Remarks" value="<?php echo $param['formulation_dispensed_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>h. Has the pharmacist ensured that expired or near-expiry drugs are not dispensed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="expired_drungs" value="<?php echo $param['expired_drungs']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="expired_drungs_text" placeholder="Remarks" value="<?php echo $param['expired_drungs_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>i. Has the medication been properly labeled with accurate patient and drug information?</b></td>
                            <td>
                                <input class="form-control" type="text" name="accurate_patient" value="<?php echo $param['accurate_patient']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="accurate_patient_text" placeholder="Remarks" value="<?php echo $param['accurate_patient_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>j. Was the medication dispensed within the defined acceptable timeframe?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medication_dispese" value="<?php echo $param['medication_dispese']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="medication_dispese_text" placeholder="Remarks" value="<?php echo $param['medication_dispese_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>k. Has any generic or therapeutic substitution been done only after consulting the prescribing doctor?</b></td>
                            <td>
                                <input class="form-control" type="text" name="generic_substitution" value="<?php echo $param['generic_substitution']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="generic_substitution_text" placeholder="Remarks" value="<?php echo $param['generic_substitution_text']; ?>">
                            </td>
                        </tr>



                        <tr>
                            <td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
                                II. NURSES
                            </td>
                        </tr>

                        <tr>
                            <td><b>a. Has the medication been administered to the correct patient?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_patient" value="<?php echo $param['correct_patient']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_patient_text" placeholder="Remarks" value="<?php echo $param['correct_patient_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>b. Has any prescribed dose been unintentionally omitted?</b></td>
                            <td>
                                <input class="form-control" type="text" name="dose_omitted" value="<?php echo $param['dose_omitted']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="dose_omitted_text" placeholder="Remarks" value="<?php echo $param['dose_omitted_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>c. Has the correct dose of the medication been administered?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medication_dose" value="<?php echo $param['medication_dose']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="medication_dose_text" placeholder="Remarks" value="<?php echo $param['medication_dose_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>d. Has the correct drug been administered as per the prescription?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_administered" value="<?php echo $param['drug_administered']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="drug_administered_text" placeholder="Remarks" value="<?php echo $param['drug_administered_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>e. Has the correct dosage form (e.g., tablet, injection, syrup) been used?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_dosage" value="<?php echo $param['correct_dosage']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_dosage_text" placeholder="Remarks" value="<?php echo $param['correct_dosage_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>f. Has the correct route of administration (e.g., oral, IV, IM) been followed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_route" value="<?php echo $param['correct_route']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_route_text" placeholder="Remarks" value="<?php echo $param['correct_route_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>g. Has the medication been administered at the correct rate?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_rate" value="<?php echo $param['correct_rate']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_rate_text" placeholder="Remarks" value="<?php echo $param['correct_rate_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>h. Has the medication been administered for the correct duration?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_duration" value="<?php echo $param['correct_duration']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_duration_text" placeholder="Remarks" value="<?php echo $param['correct_duration_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>i. Has the medication been given at the correct time as prescribed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="correct_time" value="<?php echo $param['correct_time']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="correct_time_text" placeholder="Remarks" value="<?php echo $param['correct_time_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>j. Has the drug administration been properly documented?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_administration" value="<?php echo $param['drug_administration']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="drug_administration_text" placeholder="Remarks" value="<?php echo $param['drug_administration_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>k. Has the documentation by nursing staff been complete and accurate?</b></td>
                            <td>
                                <input class="form-control" type="text" name="nursing_staff" value="<?php echo $param['nursing_staff']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="nursing_staff_text" placeholder="Remarks" value="<?php echo $param['nursing_staff_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>l. Has there been any documentation without actual drug administration?</b></td>
                            <td>
                                <input class="form-control" type="text" name="documentation_drug" value="<?php echo $param['documentation_drug']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="documentation_drug_text" placeholder="Remarks" value="<?php echo $param['documentation_drug_text']; ?>">
                            </td>
                        </tr>



                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis" value="<?php echo $param['dataAnalysis']; ?>"></td>
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
                            document.addEventListener("DOMContentLoaded", function() {

                                // 🗑️ Handle removing existing old files
                                const removeInput = document.getElementById("remove_files_json");
                                let removedIndexes = [];

                                document.querySelectorAll(".remove-file").forEach(btn => {
                                    btn.addEventListener("click", function() {
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

                                addMoreBtn.addEventListener("click", function() {
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
                                    removeBtn.addEventListener("click", function() {
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
                                            <?php echo 'Reset' ; ?>
                                        </button>
                                        <div class="or"></div>
                                        <button type="submit" class="ui positive button" style="text-align: left;">
                                            <?php echo 'Save' ; ?>
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