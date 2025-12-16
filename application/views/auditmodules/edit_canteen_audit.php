<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_toilet_cleaning');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Toilet cleaning checklist - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_toilet_cleaning_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">

                        <tr>
                            <td><b>Room/ Area</b></td>
                            <td>
                                <input class="form-control" type="text" name="area" value="<?php echo $param['area']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is the toilet cleaned properly?</b></td>
                            <td><input class="form-control" type="text" name="identification_details" value="<?php echo $param['identification_details']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are all surfaces disinfected?</b></td>
                            <td><input class="form-control" type="text" name="vital_signs" value="<?php echo $param['vital_signs']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are mirrors cleaned thoroughly?</b></td>
                            <td><input class="form-control" type="text" name="surgery" value="<?php echo $param['surgery']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the floor cleaned?</b></td>
                            <td><input class="form-control" type="text" name="complaints_communicated" value="<?php echo $param['complaints_communicated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are supplies restocked adequately?</b></td>
                            <td><input class="form-control" type="text" name="intake" value="<?php echo $param['intake']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the trash emptied?</b></td>
                            <td><input class="form-control" type="text" name="output" value="<?php echo $param['output']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are toilets free from bad odor?</b></td>
                            <td><input class="form-control" type="text" name="allergies" value="<?php echo $param['allergies']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the exhaust fan cleaned properly?</b></td>
                            <td><input class="form-control" type="text" name="medication" value="<?php echo $param['medication']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is there any water leakage or damage observed?</b></td>
                            <td><input class="form-control" type="text" name="diagnostic" value="<?php echo $param['diagnostic']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are floor mats clean and properly placed?</b></td>
                            <td><input class="form-control" type="text" name="lab_results" value="<?php echo $param['lab_results']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are housekeeping equipment arranged in the designated spaces?</b></td>
                            <td><input class="form-control" type="text" name="pending_investigation" value="<?php echo $param['pending_investigation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the cleaning checklist properly filled out and signed?</b></td>
                            <td><input class="form-control" type="text" name="medicine_order" value="<?php echo $param['medicine_order']; ?>"></td>
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