<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_ppe_audit');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);
// print_r($param);
?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Radiology Safety audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_ppe_audit_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                                <b>Staff name</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="staffname" value="<?php echo $param['staffname']; ?>">
                            </td>
                        </tr>
                        <?php if ($param['department']) { ?>
                            <tr>
                                <td><b>Department</b></td>
                                <td>
                                    <input class="form-control" type="text" name="department" value="<?php echo $param['department']; ?>">
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($row->comment) { ?>
                            <tr>
                                <td><b>Staff engaged in</b></td>
                                <td>
                                    <input class="form-control" type="text" name="comment_l" value="<?php echo $param['comment_l']; ?>">
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td><b>Is personal protective equipment (LED apron, thyroid shield, gonad shield, LED goggles, LED gloves) being used appropriately?</b></td>
                            <td>
                                <input class="form-control" type="text" name="gloves"
                                    value="<?php echo htmlspecialchars($param['gloves'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="gloves_text"
                                        value="<?php echo isset($param['gloves_text']) ? htmlspecialchars($param['gloves_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td><b>Is the TLD badge being used correctly by staff?</b></td>
                            <td>
                                <input class="form-control" type="text" name="mask"
                                    value="<?= htmlspecialchars($param['mask'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="mask_text"
                                        value="<?= htmlspecialchars($param['mask_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the patient identification policy followed by staff to performing tests?</b></td>
                            <td>
                                <input class="form-control" type="text" name="cap"
                                    value="<?= htmlspecialchars($param['cap'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="cap_text"
                                        value="<?= htmlspecialchars($param['cap_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the staff following the hand hygiene policy as required?</b></td>
                            <td>
                                <input class="form-control" type="text" name="apron"
                                    value="<?= htmlspecialchars($param['apron'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="apron_text"
                                        value="<?= htmlspecialchars($param['apron_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Do staff demonstrate knowledge of the ALARA Principle in their daily practices?</b></td>
                            <td>
                                <input class="form-control" type="text" name="leadApron"
                                    value="<?= htmlspecialchars($param['leadApron'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="leadApron_text"
                                        value="<?= htmlspecialchars($param['leadApron_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the radiation warning light activated by staff prior to conducting tests?</b></td>
                            <td>
                                <input class="form-control" type="text" name="xrayBarrior"
                                    value="<?= htmlspecialchars($param['xrayBarrior'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="xrayBarrior_text"
                                        value="<?= htmlspecialchars($param['xrayBarrior_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Do staff adequately screen female patients prior to performing tests?</b></td>
                            <td>
                                <input class="form-control" type="text" name="tld"
                                    value="<?= htmlspecialchars($param['tld'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="tld_text"
                                        value="<?= htmlspecialchars($param['tld_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Do staff provide adequate PPE to patients to minimize radiation exposure before the procedure?</b></td>
                            <td>
                                <input class="form-control" type="text" name="ppe_to_patients"
                                    value="<?= htmlspecialchars($param['ppe_to_patients'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div style="margin-top: 5px;">
                                    Remarks:
                                    <input class="form-control" type="text" name="ppe_to_patients_text"
                                        value="<?= htmlspecialchars($param['ppe_to_patients_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        placeholder="Remarks">
                                </div>
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