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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;PPE audit - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_ppe_audit_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

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
                        <?php if ($param['gloves']) { ?>
                        <tr>
                            <td><b>Is the staff wearing gloves?</b></td>
                            <td>
                                <input class="form-control" type="text" name="gloves" value="<?php echo $param['gloves']; ?>">
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['mask']) { ?>
                        <tr>
                            <td><b>Is the staff wearing mask?</b></td>
                            <td><input class="form-control" type="text" name="mask" value="<?php echo $param['mask']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['cap']) { ?>
                        <tr>
                            <td><b>Is the staff wearing cap?</b></td>
                            <td><input class="form-control" type="text" name="cap" value="<?php echo $param['cap']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['apron']) { ?>
                        <tr>
                            <td><b>Is the staff wearing apron?</b></td>
                            <td><input class="form-control" type="text" name="apron" value="<?php echo $param['apron']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['leadApron']) { ?>
                        <tr>
                            <td><b>Is the staff wearing lead apron?</b></td>
                            <td><input class="form-control" type="text" name="leadApron" value="<?php echo $param['leadApron']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['xrayBarrior']) { ?>
                        <tr>
                            <td><b>Is X-ray barrier used?</b></td>
                            <td><input class="form-control" type="text" name="xrayBarrior" value="<?php echo $param['xrayBarrior']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['tld']) { ?>
                        <tr>
                            <td><b>Is TLD badge used?</b></td>
                            <td><input class="form-control" type="text" name="tld" value="<?php echo $param['tld']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <?php if ($param['general_comment']) { ?>
                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="general_comment" value="<?php echo $param['general_comment']; ?>"></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><b>Data collected by</b></td>
                            <td><input class="form-control" type="text" name="name" value="<?php echo $param['name']; ?>"></td>
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