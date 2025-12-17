<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_mock_drill');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Code Blue - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_mock_drill_blue_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td>
                                <b>Audit Details</b>
                            </td>
                            <td style="overflow: clip;">
                                Audit Name: <?php echo $row->name; ?>
                                <br>
                                Date & Time of Audit: <?php echo date('Y-m-d H:i', strtotime($row->datetime)); ?>
                                <br>
                                Audit by: <?php echo $row->name; ?>

                                <!-- Hidden inputs -->
                                <input class="form-control" type="hidden" name="audit_type"
                                    value="<?php echo $param['audit_type']; ?>" />
                                <input class="form-control" type="hidden" name="datetime"
                                    value="<?php echo $row->datetime; ?>" />
                                <input class="form-control" type="hidden" name="name"
                                    value="<?php echo $row->name; ?>" />
                            </td>
                        </tr>


                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td>
                                <b>Location</b>
                            </td>
                            <td>
                            <input class="form-control" type="text" name="location" value="<?php echo $row->location; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Hospital Emergency Code</b></td>
                            <td>
                                <input class="form-control" type="text" name="checklist" value="<?php echo $param['checklist']; ?>" disabled>
                                <input class="form-control" type="text" style="display: none;" name="checklist" value="<?php echo $param['checklist']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Spot activation time</b></td>
                            <td>
                                <input class="form-control" type="text" name="initial_assessment_hr1" value="<?php echo $param['initial_assessment_hr1']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Announcement time</b></td>
                            <td>
                                <input class="form-control" type="text" name="initial_assessment_hr2" value="<?php echo $param['initial_assessment_hr2']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of code announcements</b></td>
                            <td><input class="form-control" type="text" name="number_of_code" value="<?php echo $param['number_of_code']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Team arrival time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr3" value="<?php echo $param['initial_assessment_hr3']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Number of Respondents</b></td>
                            <td><input class="form-control" type="text" name="respondents" value="<?php echo $param['respondents']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the crash cart or emergency kit available?</b></td>
                            <td><input class="form-control" type="text" name="emergency" value="<?php echo $param['emergency']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patient identified?</b></td>
                            <td><input class="form-control" type="text" name="identified" value="<?php echo $param['identified']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patients response checked?</b></td>
                            <td><input class="form-control" type="text" name="response" value="<?php echo $param['response']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patients circulation (pulse) checked?</b></td>
                            <td><input class="form-control" type="text" name="circulation" value="<?php echo $param['circulation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the airway cleared?</b></td>
                            <td><input class="form-control" type="text" name="airway" value="<?php echo $param['airway']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patients breathing checked?</b></td>
                            <td><input class="form-control" type="text" name="breathing" value="<?php echo $param['breathing']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was CPR started?</b></td>
                            <td><input class="form-control" type="text" name="cpr" value="<?php echo $param['cpr']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were compressions given as per standard?</b></td>
                            <td><input class="form-control" type="text" name="compressions" value="<?php echo $param['compressions']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were rescue breaths given?</b></td>
                            <td><input class="form-control" type="text" name="rescue" value="<?php echo $param['rescue']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were patient transportation modes available?</b></td>
                            <td><input class="form-control" type="text" name="mode" value="<?php echo $param['mode']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were proper safety measures used?</b></td>
                            <td><input class="form-control" type="text" name="safety_measure" value="<?php echo $param['safety_measure']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was a lift available?</b></td>
                            <td><input class="form-control" type="text" name="lift_avail" value="<?php echo $param['lift_avail']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patient shifted to the CCU?</b></td>
                            <td><input class="form-control" type="text" name="shift_ccu" value="<?php echo $param['shift_ccu']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Blue clearance time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr4" value="<?php echo $param['initial_assessment_hr4']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the medical team available in the CCU?</b></td>
                            <td><input class="form-control" type="text" name="medical" value="<?php echo $param['medical']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the CCU ready to receive the patient with adequate life support measures?</b></td>
                            <td><input class="form-control" type="text" name="adequate" value="<?php echo $param['adequate']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the patients condition assessed?</b></td>
                            <td><input class="form-control" type="text" name="condition" value="<?php echo $param['condition']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was DC shock applied?</b></td>
                            <td><input class="form-control" type="text" name="shock" value="<?php echo $param['shock']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were deviations communicated?</b></td>
                            <td><input class="form-control" type="text" name="deviations_c" value="<?php echo $param['deviations_c']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was there a repetition of deviated areas?</b></td>
                            <td><input class="form-control" type="text" name="repetition" value="<?php echo $param['repetition']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were all events of Code Blue debriefed?</b></td>
                            <td><input class="form-control" type="text" name="debriefed" value="<?php echo $param['debriefed']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Blue closure time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr5" value="<?php echo $param['initial_assessment_hr5']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="comments" value="<?php echo $param['comments']; ?>"></td>
                        </tr>


                        <tr>
                            <td><b>Data collected by</b></td>
                            <td><input class="form-control" type="text" name="name" value="<?php echo $row->name; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input  class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input  class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
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
                                            <?php echo display('reset') ?>
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