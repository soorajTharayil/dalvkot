<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_ssi_bundle');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;SSI Bundle care policy - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_ssi_bundle_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Is the patient diagnosed by following all clinical protocols?</b></td>
                            <td><input class="form-control" type="text" name="identification_details" value="<?php echo $param['identification_details']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are allergies mentioned?</b></td>
                            <td><input class="form-control" type="text" name="vital_signs" value="<?php echo $param['vital_signs']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the 5 moments of hand hygiene followed?</b></td>
                            <td><input class="form-control" type="text" name="surgery" value="<?php echo $param['surgery']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the patient been scrubbed or bathed with an antiseptic solution prior to surgery?</b></td>
                            <td><input class="form-control" type="text" name="complaints_communicated" value="<?php echo $param['complaints_communicated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the patient’s hair clipped or removed as required?</b></td>
                            <td><input class="form-control" type="text" name="intake" value="<?php echo $param['intake']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the patient’s skin cleaned before surgery?</b></td>
                            <td><input class="form-control" type="text" name="output" value="<?php echo $param['output']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are prophylactic antibiotics administered within 60 minutes before the incision?</b></td>
                            <td><input class="form-control" type="text" name="allergies" value="<?php echo $param['allergies']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are all surgical team members scrubbed and in proper OT attire?</b></td>
                            <td><input class="form-control" type="text" name="medication" value="<?php echo $param['medication']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the surgical instruments properly sterilized?</b></td>
                            <td><input class="form-control" type="text" name="diagnostic" value="<?php echo $param['diagnostic']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have informed consents been taken and duly signed?</b></td>
                            <td><input class="form-control" type="text" name="lab_results" value="<?php echo $param['lab_results']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the patient covered with a drape?</b></td>
                            <td><input class="form-control" type="text" name="pending_investigation" value="<?php echo $param['pending_investigation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are blood glucose levels monitored and maintained?</b></td>
                            <td><input class="form-control" type="text" name="medicine_order" value="<?php echo $param['medicine_order']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is foot traffic in the surgical area restricted to a minimum?</b></td>
                            <td><input class="form-control" type="text" name="facility_communicated" value="<?php echo $param['facility_communicated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the patient details, surgery, site, and procedures read before the incision?</b></td>
                            <td><input class="form-control" type="text" name="health_education" value="<?php echo $param['health_education']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the counts of instruments and consumables listed out before the procedure?</b></td>
                            <td><input class="form-control" type="text" name="risk_assessment" value="<?php echo $param['risk_assessment']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is a sterile technique followed throughout the procedure?</b></td>
                            <td><input class="form-control" type="text" name="urethral" value="<?php echo $param['urethral']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is hypothermia maintained during the procedure?</b></td>
                            <td><input class="form-control" type="text" name="urine_sample" value="<?php echo $param['urine_sample']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are vitals and fluid balances continuously monitored?</b></td>
                            <td><input class="form-control" type="text" name="bystander" value="<?php echo $param['bystander']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are counts of instruments and consumables performed after the procedure?</b></td>
                            <td><input class="form-control" type="text" name="instruments" value="<?php echo $param['instruments']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is a sterile dressing applied?</b></td>
                            <td><input class="form-control" type="text" name="sterile" value="<?php echo $param['sterile']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are post-operative antibiotics administered?</b></td>
                            <td><input class="form-control" type="text" name="antibiotics" value="<?php echo $param['antibiotics']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the surgical site assessed?</b></td>
                            <td><input class="form-control" type="text" name="surgical_site" value="<?php echo $param['surgical_site']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are necessary wound management instructions documented?</b></td>
                            <td><input class="form-control" type="text" name="wound" value="<?php echo $param['wound']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are pre-operative, intra-operative, and post-operative notes and advice documented?</b></td>
                            <td><input class="form-control" type="text" name="documented" value="<?php echo $param['documented']; ?>"></td>
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