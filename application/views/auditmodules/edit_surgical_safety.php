<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_surgical_safety');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Operating Room Safety
                        audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_surgical_safety_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Surgery name</b></td>
                            <td>
                                <input class="form-control" type="text" name="surgeryname"
                                    value="<?php echo $param['surgeryname']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Surgery date</b></td>
                            <td>
                                <input class="form-control" type="text" name="initial_assessment_hr1"
                                    value="<?php echo $param['initial_assessment_hr1']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Has the patient's identity been confirmed by verifying the ID band?</b></td>
                            <td>
                                <input class="form-control" type="text" name="antibiotic"
                                    value="<?php echo $param['antibiotic']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="antibiotic_text"
                                    placeholder="Remarks" value="<?php echo $param['antibiotic_text']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Has the surgical site been marked?</b></td>
                            <td>
                                <input class="form-control" type="text" name="checklist"
                                    value="<?php echo $param['checklist']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="checklist_text"
                                    placeholder="Remarks" value="<?php echo $param['checklist_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the informed consent been completed and documented?</b></td>
                            <td>
                                <input class="form-control" type="text" name="bundle_care"
                                    value="<?php echo $param['bundle_care']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="bundle_care_text"
                                    placeholder="Remarks" value="<?php echo $param['bundle_care_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the availability of artificial dentures, eyes, or other appliances been
                                    checked?</b></td>
                            <td>
                                <input class="form-control" type="text" name="time_out"
                                    value="<?php echo $param['time_out']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="time_out_text"
                                    placeholder="Remarks" value="<?php echo $param['time_out_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have HIV, HBsAg, and HCV tests been completed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="unplanned_return"
                                    value="<?php echo $param['unplanned_return']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="unplanned_return_text" placeholder="Remarks"
                                    value="<?php echo $param['unplanned_return_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td><b>Has the time of last oral intake (fluid/food) been mentioned?</b></td>
                            <td>
                                <input class="form-control" type="text" name="last_oral"
                                    value="<?php echo $param['last_oral']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="last_oral_text"
                                    placeholder="Remarks" value="<?php echo $param['last_oral_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the patient's weight been documented?</b></td>
                            <td>
                                <input class="form-control" type="text" name="patients_weight"
                                    value="<?php echo $param['patients_weight']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="patients_weight_text" placeholder="Remarks"
                                    value="<?php echo $param['patients_weight_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the time of urine voiding been documented?</b></td>
                            <td>
                                <input class="form-control" type="text" name="urine_void"
                                    value="<?php echo $param['urine_void']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="urine_void_text"
                                    placeholder="Remarks" value="<?php echo $param['urine_void_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the anaesthesia safety check been completed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="anaesthesia"
                                    value="<?php echo $param['anaesthesia']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="anaesthesia_text"
                                    placeholder="Remarks" value="<?php echo $param['anaesthesia_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td><b>Has the patient's drug allergy history been verified?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_allergy"
                                    value="<?php echo $param['drug_allergy']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="drug_allergy_text" placeholder="Remarks"
                                    value="<?php echo $param['drug_allergy_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has antibiotic prophylaxis been verified as given prior to surgery?</b></td>
                            <td>
                                <input class="form-control" type="text" name="prophylaxis"
                                    value="<?php echo $param['prophylaxis']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="prophylaxis_text"
                                    placeholder="Remarks" value="<?php echo $param['prophylaxis_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Was the antibiotic given within the last 60 minutes before surgery?</b></td>
                            <td>
                                <input class="form-control" type="text" name="antibiotic_given"
                                    value="<?php echo $param['antibiotic_given']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="antibiotic_given_text" placeholder="Remarks"
                                    value="<?php echo $param['antibiotic_given_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has it been checked whether thromboprophylaxis has been ordered?</b></td>
                            <td>
                                <input class="form-control" type="text" name="thromboprophylaxis"
                                    value="<?php echo $param['thromboprophylaxis']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="thromboprophylaxis_text" placeholder="Remarks"
                                    value="<?php echo $param['thromboprophylaxis_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have the surgeon, anaesthesia professionals, and nurse verbally confirmed the
                                    incision time, patient identity, surgical site, and procedure?</b></td>
                            <td>
                                <input class="form-control" type="text" name="anaesthesia_professionals"
                                    value="<?php echo $param['anaesthesia_professionals']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="anaesthesia_professionals_text" placeholder="Remarks"
                                    value="<?php echo $param['anaesthesia_professionals_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have the anticipated clinical events been reviewed by the surgeon, anaesthesia team,
                                    and nursing team?</b></td>
                            <td>
                                <input class="form-control" type="text" name="clinical_events"
                                    value="<?php echo $param['clinical_events']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="clinical_events_text" placeholder="Remarks"
                                    value="<?php echo $param['clinical_events_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have any anticipated equipment issues or concerns been reviewed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="anticipated_equipment"
                                    value="<?php echo $param['anticipated_equipment']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="anticipated_equipment_text" placeholder="Remarks"
                                    value="<?php echo $param['anticipated_equipment_text']; ?>">
                            </td>
                        </tr>


                        <tr>
                            <td><b>Has it been confirmed whether any prosthesis or special equipment is required and
                                    available for the surgery?</b></td>
                            <td>
                                <input class="form-control" type="text" name="prosthesis"
                                    value="<?php echo $param['prosthesis']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="prosthesis_text"
                                    placeholder="Remarks" value="<?php echo $param['prosthesis_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the display of essential imaging been checked and confirmed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="imaging"
                                    value="<?php echo $param['imaging']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text" name="imaging_text"
                                    placeholder="Remarks" value="<?php echo $param['imaging_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the name of the procedure been recorded?</b></td>
                            <td>
                                <input class="form-control" type="text" name="procedure_name"
                                    value="<?php echo $param['procedure_name']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="procedure_name_text" placeholder="Remarks"
                                    value="<?php echo $param['procedure_name_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have the counts of instruments, sponges, needles, and other items been checked and
                                    confirmed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="instruments_counts"
                                    value="<?php echo $param['instruments_counts']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="instruments_counts_text" placeholder="Remarks"
                                    value="<?php echo $param['instruments_counts_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the closure time been documented?</b></td>
                            <td>
                                <input class="form-control" type="text" name="closure_time"
                                    value="<?php echo $param['closure_time']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="closure_time_text" placeholder="Remarks"
                                    value="<?php echo $param['closure_time_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Has the specimen labeling been completed with the correct patient name?</b></td>
                            <td>
                                <input class="form-control" type="text" name="specimen_labeling"
                                    value="<?php echo $param['specimen_labeling']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="specimen_labeling_text" placeholder="Remarks"
                                    value="<?php echo $param['specimen_labeling_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are there any equipment problems that need to be addressed or reported?</b></td>
                            <td>
                                <input class="form-control" type="text" name="equipment_report"
                                    value="<?php echo $param['equipment_report']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="equipment_report_text" placeholder="Remarks"
                                    value="<?php echo $param['equipment_report_text']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Have the surgeon, anaesthesia professionals, and nurse reviewed the key concerns for
                                    the patient’s recovery and ongoing management?</b></td>
                            <td>
                                <input class="form-control" type="text" name="patients_recovery"
                                    value="<?php echo $param['patients_recovery']; ?>">
                                <input class="form-control" style="margin-top:10px;" type="text"
                                    name="patients_recovery_text" placeholder="Remarks"
                                    value="<?php echo $param['patients_recovery_text']; ?>">
                            </td>
                        </tr>



                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis"
                                    value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>
                        <!-- 
                         -->
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
                                            <?php echo 'Save'; ?>
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