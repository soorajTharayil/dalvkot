<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_31PSQ3d');
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
                            title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;31. PSQ3d -
                        <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_31PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                        <tr>
                            <td><strong><?php echo lang_loader('ip', 'emp'); ?></strong></td>
                            <td>
                                <b> <?php echo $param['name']; ?></b>
                                (<?php echo $param['patientid']; ?>)

                                <br>
                                <?php if ($param['contactnumber'] != '') { ?>
                                    <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>


                                <?php } ?>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Total no. of handovers done appropriately</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center;">
                                    <span class="has-float-label">
                                        <input class="form-control"
                                            value="<?php echo $param['initial_assessment_hr']; ?>"
                                            oninput="restrictToNumerals(event); calculateHandoversRate();" type="number"
                                            id="formula_para1_hr"
                                            style="padding-top: 2px; padding-left: 6px; margin-top: 9px; width: 90%;" />
                                        <input class="form-control" style="display:none" name="initial_assessment_hr"
                                            value="<?php echo $param['initial_assessment_hr']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_min"
                                            value="<?php echo $param['initial_assessment_min']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_sec"
                                            value="<?php echo $param['initial_assessment_sec']; ?>" />
                                        <input class="form-control" style="display:none" name="name"
                                            value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid"
                                            value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber"
                                            value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email"
                                            value="<?php echo $param['email']; ?>" />
                                        <span style="margin-left: 4px; margin-right: 9px;"></span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total no. of handover opportunities</b></td>
                            <td>
                                <input class="form-control" type="number" id="total_admission" name="total_admission"
                                    value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateHandoversRate()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">


                                    Calculate appropriate handovers
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Percentage of appropriate handovers during shift change</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult" name="calculatedResult"
                                    value="<?php echo $param['calculatedResult']; ?>" readonly>


                            </td>
                        </tr>
                        <tr>
                            <td><b>Data analysis</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis"
                                    value="<?php echo $param['dataAnalysis']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><b>Corrective action</b></td>
                            <td><input class="form-control" type="text" name="correctiveAction"
                                    value="<?php echo $param['correctiveAction']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><b>Preventive action</b></td>
                            <td><input class="form-control" type="text" name="preventiveAction"
                                    value="<?php echo $param['preventiveAction']; ?>" required></td>
                        </tr>



                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected"
                                    value="<?php echo $row->datetime; ?>"></td>
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
                                        <button type="submit" id="saveButton" class="ui positive button"
                                            style="text-align: left;">
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
    // Initialize flags to track if values have been edited and if calculation is done
    var valuesEdited = false;
    var calculationDone = false;

    // Function to call when values are edited
    function onValuesEdited() {
        valuesEdited = true;
        calculationDone = false; // Reset calculation flag when values are edited
    }

    // Add event listeners to input elements to call the onValuesEdited function
    document.getElementById('formula_para1_hr').addEventListener('input', onValuesEdited);
    document.getElementById('total_admission').addEventListener('input', onValuesEdited);

    // Function to check if values have been edited before form submission
    function checkValuesBeforeSubmit() {
        if (valuesEdited && !calculationDone) {
            alert('Please calculate before saving');
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Add an event listener to the save button
    document.getElementById('saveButton').addEventListener('click', function () {

        if (checkValuesBeforeSubmit()) {
            // Proceed with save action
            console.log('Data saved successfully.');
            // You can use AJAX or form submission here
        }
    });

    // Add event listener to the calculate button
    document.querySelector('button[onclick="calculateHandoversRate()"]').addEventListener('click', calculateHandoversRate);

    function calculateHandoversRate() {
        var appropriateHandovers = parseInt(document.getElementById('formula_para1_hr').value);
        var handoverOpportunities = parseInt(document.getElementById('total_admission').value);

        document.querySelector('input[name="initial_assessment_hr"]').value = appropriateHandovers;
        document.querySelector('input[name="total_admission"]').value = handoverOpportunities;

        // Validate inputs for appropriateHandovers and handoverOpportunities
        if (isNaN(appropriateHandovers) || appropriateHandovers < 0) {
            alert("Enter the total number of handovers done appropriately.");
            return;
        }

        if (isNaN(handoverOpportunities) || handoverOpportunities < 0) {
            alert("Enter the total number of handover opportunities.");
            return;
        }

        if (appropriateHandovers > handoverOpportunities) {
            alert("The no. of handovers done appropriately must be less than the total no. of handover opportunities.");
            return;
        }

        var calculatedResult;

        // Case 1: both zero → 0
        if (appropriateHandovers === 0 && handoverOpportunities === 0) {
            calculatedResult = 0;
        }
        // Case 2: denominator = 0 → avoid division by zero
        else if (handoverOpportunities === 0) {
            calculatedResult = 0;
        } else {
            // Calculate the percentage of appropriate handovers during shift change
            calculatedResult = ((appropriateHandovers / handoverOpportunities) * 100).toFixed(2);
        }

        document.getElementById('calculatedResult').value = calculatedResult;

        console.log("Calculated result:", calculatedResult);
        calculationDone = true;
    }
    // ✅ Restrict input to numerals with decimals
    function restrictToNumerals(event) {
        const inputElement = event.target;
        const cursorPos = inputElement.selectionStart;
        const currentValue = inputElement.value;

        // Allow only digits and a single decimal point
        let filteredValue = currentValue
            .replace(/[^0-9.]/g, '') // Remove non-numeric except '.'
            .replace(/(\..*?)\./g, '$1'); // Keep only first '.'

        // Prevent multiple leading zeros unless it's "0." pattern
        filteredValue = filteredValue.replace(/^0{2,}/, '0');
        if (filteredValue.startsWith('0') && !filteredValue.startsWith('0.')) {
            filteredValue = filteredValue.replace(/^0+/, '0');
        }

        // Update the field without moving cursor
        if (filteredValue !== currentValue) {
            const diff = currentValue.length - filteredValue.length;
            inputElement.value = filteredValue;
            inputElement.setSelectionRange(cursorPos - diff, cursorPos - diff);
        }
    }
</script>