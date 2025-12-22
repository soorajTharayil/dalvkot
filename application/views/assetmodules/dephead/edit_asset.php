<?php
$id = $this->uri->segment(3);
//$this->db->order_by('id', 'asc');
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_asset_creation');
$result = $query->result();

if (!empty($result)) {
    foreach ($result as $row) {
        $encodedImage = $row->image;
        $pat = json_decode($row->dataset, true);

        // echo '<pre>';
        // print_r($pat);
        // echo '</pre>';
        // exit;
    }
}
?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="ASSET MANAGEMENT">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;EDIT ASSET DETAILS - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('asset/edit_asset_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Asset Code</b></td>
                            <td>
                                <input class="form-control" type="text" id="patientid" name="patientid" value="<?php echo $pat['patientid']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Asset Name</b></td>
                            <td>
                                <input class="form-control" type="text" id="assetname" name="assetname" value="<?php echo $pat['assetname']; ?>">
                                <br>

                            </td>
                        </tr>
                        <tr>
                            <td><b>Asset Group</b></td>
                            <td>
                                <select name="ward" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)">
                                    <option disabled>Select Asset Group/Category</option>
                                    <?php
                                    $this->db->select('title');
                                    $query = $this->db->get('bf_departmentasset');
                                    $result = $query->result();

                                    $selectedGroup = $pat['ward'];

                                    foreach ($result as $row) {
                                        if ($row->title != 'ALL') {
                                            $selected = ($row->title == $selectedGroup) ? 'selected' : '';
                                            echo '<option value="' . str_replace('&', '%26', $row->title) . '" ' . $selected . '>' . $row->title . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Asset Brand</b></td>
                            <td><input class="form-control" type="text" id="brand" name="brand" value="<?php echo $pat['brand']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Asset Model</b></td>
                            <td><input class="form-control" type="text" id="model" name="model" value="<?php echo $pat['model']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Asset Serial No</b></td>
                            <td><input class="form-control" type="text" id="serial" name="serial" value="<?php echo $pat['serial']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Asset Location</b></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <label for="locationsite" style="white-space: nowrap; margin: 0;"><b>Area:</b></label>
                                    <input class="form-control" type="text" id="locationsite" name="locationsite" value="<?php echo $pat['locationsite']; ?>" style="flex: 1;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label for="bedno" style="white-space: nowrap; margin: 0;"><b>Site:</b></label>
                                    <input class="form-control" type="text" id="bedno" name="bedno" value="<?php echo $pat['bedno']; ?>" style="flex: 1;">
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td><b>Asset Department</b></td>
                            <td>
                                <select name="depart" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)">
                                    <option disabled>Select Asset Department</option>
                                    <?php
                                    $this->db->select('title');
                                    $query = $this->db->get('bf_asset_location');
                                    $result = $query->result();

                                    $selectedDept = $pat['depart'];

                                    foreach ($result as $row) {
                                        if ($row->title != 'ALL') {
                                            $selected = ($row->title == $selectedDept) ? 'selected' : '';
                                            echo '<option value="' . str_replace('&', '%26', $row->title) . '" ' . $selected . '>' . $row->title . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>



                        <tr>
                            <td><b>Asset User</b></td>
                            <td>
                                <select name="assigned" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)">
                                    <option disabled>Select Asset User</option>
                                    <?php
                                    $this->db->select('firstname');
                                    $query = $this->db->get('user');
                                    $result = $query->result();

                                    $selectedUser = $pat['assigned'];

                                    foreach ($result as $row) {
                                        if ($row->firstname != 'Developer') {
                                            $selected = ($row->firstname == $selectedUser) ? 'selected' : '';
                                            echo '<option value="' . str_replace('&', '%26', $row->firstname) . '" ' . $selected . '>' . $row->firstname . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>


                        <tr>
                            <td><b>Purchase Date</b></td>
                            <td><input class="form-control" type="date" name="purchaseDate" value="<?php echo $pat['purchaseDate']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Install Date</b></td>
                            <td><input class="form-control" type="date" name="installDate" value="<?php echo $pat['installDate']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Invoice No</b></td>
                            <td><input class="form-control" type="text" name="invoice" value="<?php echo $pat['invoice']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>GRN No</b></td>
                            <td><input class="form-control" type="text" name="grn_no" value="<?php echo $pat['grn_no']; ?>"></td>
                        </tr>

                        <tr>
                            <td><b>Last Preventive Maintenance Date:</b></td>
                            <td><input class="form-control" type="date" name="preventive_maintenance_date" value="<?php echo $pat['lastMaintenance']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Upcoming Preventive Maintenance Due:</b></td>
                            <td><input class="form-control" type="date" name="upcoming_preventive_maintenance_date" value="<?php echo $pat['upcomingMaintenance']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>PM Reminder Alert 1:</b></td>
                            <td><input class="form-control" type="date" name="reminder_alert_1" value="<?php echo $pat['reminder_alert_1']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>PM Reminder Alert 2:</b></td>
                            <td><input class="form-control" type="date" name="reminder_alert_2" value="<?php echo $pat['reminder_alert_2']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Last Calibration Date:</b></td>
                            <td><input class="form-control" type="date" name="asset_calibration_date" value="<?php echo $pat['lastCalibration']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Upcoming Calibration Due:</b></td>
                            <td><input class="form-control" type="date" name="upcoming_calibration_date" value="<?php echo $pat['upcomingCalibration']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Calibration Reminder Alert 1:</b></td>
                            <td><input class="form-control" type="date" name="calibration_reminder_alert_1" value="<?php echo $pat['calibration_reminder_alert_1']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        <tr>
                            <td><b>Calibration Reminder Alert 2:</b></td>
                            <td><input class="form-control" type="date" name="calibration_reminder_alert_2" value="<?php echo $pat['calibration_reminder_alert_2']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>

                        

                        <tr>
                            <td><b>Warranty Start Date</b></td>
                            <td><input class="form-control" type="date" name="warrenty" value="<?php echo $pat['warrenty']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>
                        <tr>
                            <td><b>Warranty End Date</b></td>
                            <td><input class="form-control" type="date" name="warrenty_end" value="<?php echo $pat['warrenty_end']; ?>" onclick="this.showPicker && this.showPicker();"></td>
                        </tr>
                        <tr>
                            <td><b>Asset Quantity/ Unit Price</b></td>
                            <td>
                                <div class="row">
                                    <!-- Quantity input -->
                                    <div class="col-md-4">
                                        <input class="form-control" type="number" id="assetquantity" name="assetquantity" value="<?php echo $pat['assetquantity']; ?>" placeholder="Quantity">
                                    </div>
                                    <!-- Unit Price input -->
                                    <div class="col-md-4">
                                        <input class="form-control" type="number" id="unitprice" name="unitprice" value="<?php echo $pat['unitprice']; ?>" placeholder="Unit Price">
                                    </div>
                                    <!-- Calculate button -->
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary" onclick="calculateTimeFormat()">
                                            Calculate Total Price
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="formattedTime" name="formattedTime" value="">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total Price</b></td>
                            <td><input class="form-control" type="number" name="totalprice" value="<?php echo $pat['totalprice']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Depreciation Rate</b></td>
                            <td>
                                <div class="row">
                                    <!-- Depreciation Rate input -->
                                    <div class="col-md-6">
                                        <input class="form-control" type="number" name="depreciation" value="<?php echo $pat['depreciation']; ?>" placeholder="Depreciation Rate (%)">
                                    </div>
                                    <!-- Calculate button -->
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" onclick="currentAssetValue()">
                                            Calculate Asset Value
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Total Asset Value</b></td>
                            <td><input class="form-control" type="number" name="assetCurrentValue" value="<?php echo $pat['assetCurrentValue']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>AMC/CMC Details</b></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <label for="contract" style="white-space: nowrap; margin: 0;"><b>Contract Type:</b></label>
                                    <input class="form-control" type="text" name="contract" id="contract" value="<?php echo $pat['contract']; ?>" style="flex: 1;">
                                </div>

                                <?php if ($pat['contract'] === 'AMC') { ?>
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <label for="amcStartDate" style="white-space: nowrap; margin: 0;"><b>Start Date:</b></label>
                                        <input class="form-control" type="date" name="amcStartDate" id="amcStartDate" value="<?php echo $pat['amcStartDate']; ?>" style="flex: 1;" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <label for="amcEndDate" style="white-space: nowrap; margin: 0;"><b>End Date:</b></label>
                                        <input class="form-control" type="date" name="amcEndDate" id="amcEndDate" value="<?php echo $pat['amcEndDate']; ?>" style="flex: 1;" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <label for="amcServiceCharges" style="white-space: nowrap; margin: 0;"><b>Service Charges:</b></label>
                                        <input class="form-control" type="text" name="amcServiceCharges" id="amcServiceCharges" value="<?php echo $pat['amcServiceCharges']; ?>" style="flex: 1;">
                                    </div>
                                <?php } elseif ($pat['contract'] === 'CMC') { ?>
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <label for="cmcStartDate" style="white-space: nowrap; margin: 0;"><b>Start Date:</b></label>
                                        <input class="form-control" type="date" name="cmcStartDate" id="cmcStartDate" value="<?php echo $pat['cmcStartDate']; ?>" style="flex: 1;" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <label for="cmcEndDate" style="white-space: nowrap; margin: 0;"><b>End Date:</b></label>
                                        <input class="form-control" type="date" name="cmcEndDate" id="cmcEndDate" value="<?php echo $pat['cmcEndDate']; ?>" style="flex: 1;" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <label for="cmcServiceCharges" style="white-space: nowrap; margin: 0;"><b>Service Charges:</b></label>
                                        <input class="form-control" type="text" name="cmcServiceCharges" id="cmcServiceCharges" value="<?php echo $pat['cmcServiceCharges']; ?>" style="flex: 1;">
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>


                        <tr>
                            <td><b>Supplier Info</b></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <label for="supplierinfo" style="white-space: nowrap; margin: 0;"><b>Supplier Name:</b></label>
                                    <input class="form-control" type="text" id="supplierinfo" name="supplierinfo" value="<?php echo $pat['supplierinfo']; ?>" style="flex: 1;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <label for="servicename" style="white-space: nowrap; margin: 0;"><b>Service Person Name:</b></label>
                                    <input class="form-control" type="text" id="servicename" name="servicename" value="<?php echo $pat['servicename']; ?>" style="flex: 1;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <label for="servicecon" style="white-space: nowrap; margin: 0;"><b>Service Contact:</b></label>
                                    <input class="form-control" type="text" id="servicecon" name="servicecon" value="<?php echo $pat['servicecon']; ?>" style="flex: 1;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label for="servicemail" style="white-space: nowrap; margin: 0;"><b>Service Email:</b></label>
                                    <input class="form-control" type="text" id="servicemail" name="servicemail" value="<?php echo $pat['servicemail']; ?>" style="flex: 1;">
                                </div>
                            </td>
                        </tr>



                        <tr>
                            <td><b>Additional Notes</b></td>
                            <td><input class="form-control" type="text" id="dataAnalysis" name="dataAnalysis" value="<?php echo $pat['dataAnalysis']; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button">
                                            <?php echo 'Reset' ; ?>
                                        </button>
                                        <div class="or"></div>
                                        <button type="submit" id="saveButton" class="ui positive button" style="text-align: left;">
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
    var valuesEdited = false;
    var calculationDone = false;

    function onValuesEdited() {
        valuesEdited = true;
        calculationDone = false;
    }

    document.getElementById('assetquantity').addEventListener('input', onValuesEdited);
    document.getElementById('unitprice').addEventListener('input', onValuesEdited);

    function checkValuesBeforeSubmit(event) {
        if (valuesEdited && !calculationDone) {
            alert('Please calculate the total price before saving.');
            event.preventDefault();
            return false;
        }
        return true;
    }

    document.getElementById('saveButton').addEventListener('click', function(event) {
        if (!checkValuesBeforeSubmit(event)) {
            event.preventDefault();
        } else {
            // Perform form submission
            document.querySelector('.form-inner').submit();
        }
    });

    document.querySelector('button[onclick="calculateTimeFormat()"]').addEventListener('click', calculateTimeFormat);

    function calculateTimeFormat() {
        var quantity = document.getElementById('assetquantity').value;
        var unitPrice = document.getElementById('unitprice').value;

        if (!quantity || quantity <= 0) {
            alert("Please enter a valid quantity.");
            return;
        }

        if (!unitPrice || unitPrice <= 0) {
            alert("Please enter a valid unit price.");
            return;
        }

        var totalPrice = quantity * unitPrice;
        document.querySelector('input[name="totalprice"]').value = totalPrice;

        calculationDone = true;
        valuesEdited = false;
    }
</script>

<script>
    var depreciationValuesEdited = false;
    var depreciationCalculationDone = false;

    function onDepreciationValuesEdited() {
        depreciationValuesEdited = true;
        depreciationCalculationDone = false;
    }

    // Track changes on input fields
    document.getElementById('unitprice').addEventListener('input', onDepreciationValuesEdited);
    document.getElementById('depreciation').addEventListener('input', onDepreciationValuesEdited);
    document.getElementById('installdate').addEventListener('change', onDepreciationValuesEdited);

    function checkDepreciationBeforeSubmit(event) {
        if (depreciationValuesEdited && !depreciationCalculationDone) {
            alert('Please calculate the asset value before saving.');
            event.preventDefault();
            return false;
        }
        return true;
    }

    document.getElementById('saveButton').addEventListener('click', function(event) {
        if (!checkDepreciationBeforeSubmit(event)) {
            event.preventDefault();
        } else {
            document.querySelector('.form-inner').submit();
        }
    });

    // Button: Calculate Asset Value
    document.querySelector('button[onclick="calculateAssetValue()"]').addEventListener('click', calculateAssetValue);

    function calculateAssetValue() {
        var unitPrice = parseFloat(document.getElementById('unitprice').value);
        var depreciationRate = parseFloat(document.getElementById('depreciation').value);
        var installDateStr = document.getElementById('installdate').value;

        if (!unitPrice || unitPrice <= 0) {
            alert("Please enter a valid unit price.");
            return;
        }

        if (!depreciationRate || depreciationRate <= 0) {
            alert("Please enter a valid depreciation rate.");
            return;
        }

        if (!installDateStr) {
            alert("Please enter a valid install date.");
            return;
        }

        var installDate = new Date(installDateStr);
        var currentDate = new Date();
        var msPerDay = 1000 * 60 * 60 * 24;
        var durationDays = (currentDate - installDate) / msPerDay;
        var durationYears = Math.max(0, durationDays / 365);

        // SLM Method
        var depreciationValue = unitPrice * (depreciationRate / 100) * durationYears;
        var currentAssetValue = unitPrice - depreciationValue;

        document.getElementById('calculatedDepreciation').value = depreciationValue.toFixed(2);
        document.getElementById('assetCurrentValue').value = currentAssetValue.toFixed(2);

        depreciationCalculationDone = true;
        depreciationValuesEdited = false;
    }
</script>
