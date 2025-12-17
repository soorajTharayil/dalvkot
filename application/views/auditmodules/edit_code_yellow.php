<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_mock_drill');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);
// echo '<pre>';
// 			print_r($param);
// 			echo '</pre>';
// 			exit;
?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Code Yellow - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_mock_drill_yellow_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                                Audit by: <?php echo $param['name']; ?>

                                <!-- Hidden inputs -->
                                <input class="form-control" type="hidden" name="audit_type"
                                    value="<?php echo $param['audit_type']; ?>" />
                                <input class="form-control" type="hidden" name="datetime"
                                    value="<?php echo $row->datetime; ?>" />
                                <input class="form-control" type="hidden" name="name"
                                    value="<?php echo $param['name']; ?>" />
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
                            <td><b>Mock Drill start time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr1" value="<?php echo $param['initial_assessment_hr1']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Team arrival time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr2" value="<?php echo $param['initial_assessment_hr2']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Code Yellow Announced</b></td>
                            <td><input class="form-control" type="text" name="yell2" value="<?php echo $param['yell2']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Code Yellow team activated</b></td>
                            <td><input class="form-control" type="text" name="yell3" value="<?php echo $param['yell3']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Equipped ambulance sent to the site of disaster</b></td>
                            <td><input class="form-control" type="text" name="yell4" value="<?php echo $param['yell4']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Normal admissions are stopped immediately</b></td>
                            <td><input class="form-control" type="text" name="yell5" value="<?php echo $param['yell5']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Command nucleus activated</b></td>
                            <td><input class="form-control" type="text" name="yell6" value="<?php echo $param['yell6']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Team reported at command nucleus</b></td>
                            <td><input class="form-control" type="text" name="yell7" value="<?php echo $param['yell7']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Disaster card distributed</b></td>
                            <td><input class="form-control" type="text" name="yell8" value="<?php echo $param['yell8']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Pre defined area for creation of disaster ward evacuated</b></td>
                            <td><input class="form-control" type="text" name="yell9" value="<?php echo $param['yell9']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Disaster ward created</b></td>
                            <td><input class="form-control" type="text" name="yell10" value="<?php echo $param['yell10']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Medicines & other consumables reaches the disaster ward</b></td>
                            <td><input class="form-control" type="text" name="yell11" value="<?php echo $param['yell11']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Security controls the crowd</b></td>
                            <td><input class="form-control" type="text" name="yell12" value="<?php echo $param['yell12']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Reception desk positioned at the main entrance of the hospital</b></td>
                            <td><input class="form-control" type="text" name="yell13" value="<?php echo $param['yell13']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Patient identification by the designated team member done</b></td>
                            <td><input class="form-control" type="text" name="yell14" value="<?php echo $param['yell14']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>First patient reported</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr3" value="<?php echo $param['initial_assessment_hr3']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Triaging Done</b></td>
                            <td><input class="form-control" type="text" name="yell16" value="<?php echo $param['yell16']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Patient shifted to ICU/OT</b></td>
                            <td><input class="form-control" type="text" name="yell17" value="<?php echo $param['yell17']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Patient shifted to disaster ward</b></td>
                            <td><input class="form-control" type="text" name="yell18" value="<?php echo $param['yell18']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Patient discharged by</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr4" value="<?php echo $param['initial_assessment_hr4']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Media handling done by spokes person</b></td>
                            <td><input class="form-control" type="text" name="yell19" value="<?php echo $param['yell19']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Blood bank in charge reported at the command nucleus</b></td>
                            <td><input class="form-control" type="text" name="yell20" value="<?php echo $param['yell20']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Dietician Reports at the command nucleus</b></td>
                            <td><input class="form-control" type="text" name="yell21" value="<?php echo $param['yell21']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Store in charge reports at the command nucleus</b></td>
                            <td><input class="form-control" type="text" name="yell22" value="<?php echo $param['yell22']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Pharmacy in charge reports at the command nucleus</b></td>
                            <td><input class="form-control" type="text" name="yell23" value="<?php echo $param['yell23']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Code Yellow called off at</b></td>
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
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
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