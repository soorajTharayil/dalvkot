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
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Medication administration audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_medication_administration_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td>
                                <b>Patient UHID</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="patientid" value="<?php echo $param['patientid']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you checked own medications and verified the medication order, including drug name, dose, route, time, and frequency?</b></td>
                            <td>
                                <input class="form-control" type="text" name="gloves" value="<?php echo $param['gloves']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you confirm that the prescribed medicine is written in the order?</b></td>
                            <td>
                                <input class="form-control" type="text" name="mask" value="<?php echo $param['mask']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is the medication tray stocked with all required articles?</b></td>
                            <td>
                                <input class="form-control" type="text" name="cap" value="<?php echo $param['cap']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you perform handwashing or use hand rub before administering the medication to patient?</b></td>
                            <td>
                                <input class="form-control" type="text" name="apron" value="<?php echo $param['apron']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you greet and identify the patient using two identification methods?</b></td>
                            <td>
                                <input class="form-control" type="text" name="lead_apron" value="<?php echo $param['lead_apron']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you explained the procedure to the patient and verified their allergic status?</b></td>
                            <td>
                                <input class="form-control" type="text" name="explained_procedure" value="<?php echo $param['use_xray_barrior']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you check and ensure that all medications are present at the patient’s side with patient’s file?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medications_present" value="<?php echo $param['patient_file']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you verified the medicine for its name, expiry date, color, and texture?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_verified" value="<?php echo $param['verified']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you explain the drug indication, expected action, reaction, and side effects to the patient or relatives?</b></td>
                            <td>
                                <input class="form-control" type="text" name="drug_explained" value="<?php echo $param['indication']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is all medicine available for use at the bedside on time?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_available" value="<?php echo $param['medicine']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>For high-alert drugs, did you ensure verification by one staff nurse before administration?</b></td>
                            <td>
                                <input class="form-control" type="text" name="high_alert_verified" value="<?php echo $param['alert']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you labeled the prepared medicine with the drug name and dilution?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_labeled" value="<?php echo $param['dilution']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are you administering the medication as per approved techniques?</b></td>
                            <td>
                                <input class="form-control" type="text" name="approved_techniques" value="<?php echo $param['administering']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you provide privacy for the patient if needed?</b></td>
                            <td>
                                <input class="form-control" type="text" name="privacy_provided" value="<?php echo $param['privacy']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>For multi-dose vials, did you note the date and time of opening on the medicine?</b></td>
                            <td>
                                <input class="form-control" type="text" name="vials_noted" value="<?php echo $param['vials']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you check the patency and status of the cannula, including the date and time of cannulation near the site?</b></td>
                            <td>
                                <input class="form-control" type="text" name="cannula_checked" value="<?php echo $param['cannula']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>After IV administration, did you flush the line with normal saline?</b></td>
                            <td>
                                <input class="form-control" type="text" name="line_flushed" value="<?php echo $param['flush']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are IV medications being run on time, and have they been discontinued or discarded appropriately?</b></td>
                            <td>
                                <input class="form-control" type="text" name="iv_medications" value="<?php echo $param['medications']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>After administering the medication, did you reassess the patient for any reactions and ensure their comfort?</b></td>
                            <td>
                                <input class="form-control" type="text" name="reassessed" value="<?php echo $param['reassess']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>For oral medications, have you ensured that the patient has taken the medications and that no medicine is left unattended?</b></td>
                            <td>
                                <input class="form-control" type="text" name="oral_medications" value="<?php echo $param['oral']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you discarded waste and replaced used articles?</b></td>
                            <td>
                                <input class="form-control" type="text" name="waste_discarded" value="<?php echo $param['discarded']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Did you perform handwashing or use hand rub after the procedure?</b></td>
                            <td>
                                <input class="form-control" type="text" name="handwashing_after" value="<?php echo $param['handwashing']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have you recorded the procedure in the documents immediately after completing it?</b></td>
                            <td>
                                <input class="form-control" type="text" name="procedure_recorded" value="<?php echo $param['procedures']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis" value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected by</b></td>
                            <td><input class="form-control" type="text" name="name" value="<?php echo $param['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
                        </tr>


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