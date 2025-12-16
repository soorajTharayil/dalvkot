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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Code Red - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_mock_drill_red_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

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
                            <td><b>Have they tried to assess the situation?</b></td>
                            <td><input class="form-control" type="text" name="situation" value="<?php echo $param['situation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is there availability of fire fighting equipment?</b></td>
                            <td><input class="form-control" type="text" name="fire" value="<?php echo $param['fire']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have they demonstrated the use of fire fighting equipment?</b></td>
                            <td><input class="form-control" type="text" name="demonstrated" value="<?php echo $param['demonstrated']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the lift closed?</b></td>
                            <td><input class="form-control" type="text" name="lift" value="<?php echo $param['lift']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are the fire doors opened?</b></td>
                            <td><input class="form-control" type="text" name="doors" value="<?php echo $param['doors']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the patient safety officer announced evacuation?</b></td>
                            <td><input class="form-control" type="text" name="safety" value="<?php echo $param['safety']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are transportation modes available for evacuation?</b></td>
                            <td><input class="form-control" type="text" name="transportation" value="<?php echo $param['transportation']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Is the triage arranged?</b></td>
                            <td><input class="form-control" type="text" name="action" value="<?php echo $param['action']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have they cleared the assembly point?</b></td>
                            <td><input class="form-control" type="text" name="assembly_point" value="<?php echo $param['assembly_point']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Has the safety officer and team revisited the spot for follow-up?</b></td>
                            <td><input class="form-control" type="text" name="follow_up" value="<?php echo $param['follow_up']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Red clearance time</b></td>
                            <td><input class="form-control" type="text" name="initial_assessment_hr4" value="<?php echo $param['initial_assessment_hr4']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Are deviations explained?</b></td>
                            <td><input class="form-control" type="text" name="deviations" value="<?php echo $param['deviations']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Have all events of Code Red been debriefed?</b></td>
                            <td><input class="form-control" type="text" name="debrief" value="<?php echo $param['debrief']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Code Red closure time</b></td>
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