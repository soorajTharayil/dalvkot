<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_central_line_insert');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Central Line Insertion checklist - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_central_line_insert_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Patient Name</b></td>
                            <td>
                                <input class="form-control" type="text" name="patientname" value="<?php echo $param['patientname']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Patient UHID</b></td>
                            <td>
                                <input class="form-control" type="text" name="patientid" value="<?php echo $param['patientid']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Age</b></td>
                            <td>
                                <input class="form-control" type="text" name="age" value="<?php echo $param['age']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Staff name</b></td>
                            <td>
                                <input class="form-control" type="text" name="staffname" value="<?php echo $param['staffname']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Have alternatives been considered and documented?</b></td>
                            <td><input class="form-control" type="text" name="identification_details" value="<?php echo $param['identification_details']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the patient been confirmed using two identifications?</b></td>
                            <td><input class="form-control" type="text" name="vital_signs" value="<?php echo $param['vital_signs']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the clinical reasons for insertion specified, communicated to the patient/bystander, and documented?</b></td>
                            <td><input class="form-control" type="text" name="surgery" value="<?php echo $param['surgery']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the need, possible complications, potential outcomes, and procedure been explained, and has the patient/bystander's informed consent been obtained by the performing doctor?</b></td>
                            <td><input class="form-control" type="text" name="complaints_communicated" value="<?php echo $param['complaints_communicated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have the person performing the procedure and their assistants performed hand hygiene?</b></td>
                            <td><input class="form-control" type="text" name="intake" value="<?php echo $param['intake']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the person performing the procedure wearing PPE?</b></td>
                            <td><input class="form-control" type="text" name="output" value="<?php echo $param['output']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the person performing the procedure using sterile gloves?</b></td>
                            <td><input class="form-control" type="text" name="allergies" value="<?php echo $param['allergies']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the insertion kit available?</b></td>
                            <td><input class="form-control" type="text" name="medication" value="<?php echo $param['medication']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the insertion site been prepared with chlorhexidine/alcohol, and has hand hygiene been re-performed?</b></td>
                            <td><input class="form-control" type="text" name="diagnostic" value="<?php echo $param['diagnostic']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the site been properly positioned and draped?</b></td>
                            <td><input class="form-control" type="text" name="lab_results" value="<?php echo $param['lab_results']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was local anesthesia or sedation used?</b></td>
                            <td><input class="form-control" type="text" name="pending_investigation" value="<?php echo $param['pending_investigation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Was aseptic technique maintained throughout the insertion, and was hand hygiene re-performed?</b></td>
                            <td><input class="form-control" type="text" name="medicine_order" value="<?php echo $param['medicine_order']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is it ensured that lumens are not cut?</b></td>
                            <td><input class="form-control" type="text" name="facility_communicated" value="<?php echo $param['facility_communicated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are unused ports clamped?</b></td>
                            <td><input class="form-control" type="text" name="health_education" value="<?php echo $param['health_education']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has blood been aspirated from each lumen, and is the site cleaned?</b></td>
                            <td><input class="form-control" type="text" name="risk_assessment" value="<?php echo $param['risk_assessment']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the site been checked and cleaned with chlorhexidine?</b></td>
                            <td><input class="form-control" type="text" name="urethral" value="<?php echo $param['urethral']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has sterile dressing been applied, and has hand hygiene been re-performed?</b></td>
                            <td><input class="form-control" type="text" name="urine_sample" value="<?php echo $param['urine_sample']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the placement been verified by X-Ray?</b></td>
                            <td><input class="form-control" type="text" name="bystander" value="<?php echo $param['bystander']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the patient/bystander been educated regarding central line care and the frequency of follow-ups, and has the procedure been documented?</b></td>
                            <td><input class="form-control" type="text" name="instruments" value="<?php echo $param['instruments']; ?>"></td>
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