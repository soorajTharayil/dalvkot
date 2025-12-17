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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Code Pink - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_mock_pink_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Was the description of the child included in the announcement?</b></td>
                            <td><input class="form-control" type="text" name="child_announce" value="<?php echo $param['child_announce']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the Code Pink team activated?</b></td>
                            <td><input class="form-control" type="text" name="code_pink_team" value="<?php echo $param['code_pink_team']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were all exit points closed?</b></td>
                            <td><input class="form-control" type="text" name="exit_points" value="<?php echo $param['exit_points']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were security guards positioned at all entry/exit points</b></td>
                            <td><input class="form-control" type="text" name="security_guard" value="<?php echo $param['security_guard']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was counseling provided to the mother?</b></td>
                            <td><input class="form-control" type="text" name="counseling_to_mother" value="<?php echo $param['counseling_to_mother']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were all areas, including exteriors, terrace searched?</b></td>
                            <td><input class="form-control" type="text" name="searched" value="<?php echo $param['searched']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were suspicious persons within the hospital premises checked?</b></td>
                            <td><input class="form-control" type="text" name="suspicious" value="<?php echo $param['suspicious']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were all areas closely examined through CCTV?</b></td>
                            <td><input class="form-control" type="text" name="cctv" value="<?php echo $param['cctv']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was the child handed over?</b></td>
                            <td><input class="form-control" type="text" name="handing" value="<?php echo $param['handing']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Were all events described to the mother?</b></td>
                            <td><input class="form-control" type="text" name="events" value="<?php echo $param['events']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Pink clearance time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr4" value="<?php echo $param['initial_assessment_hr4']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are deviations explained?</b></td>
                            <td><input class="form-control" type="text" name="deviations" value="<?php echo $param['deviations']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have all events of Code Pink been debriefed?</b></td>
                            <td><input class="form-control" type="text" name="debrief_p" value="<?php echo $param['debrief_p']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Pink closure time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr5" value="<?php echo $param['initial_assessment_hr5']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="comments" value="<?php echo $param['comments']; ?>"></td>
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