<div class="content">
    <div class="row">

        <!--  table area -->

        <div class="col-sm-12">

            <div class="panel panel-default thumbnail">





                <div class="panel-body">

                    <table width="100%" class="datatableto table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>
                                <th>Patient Name</th>

                                <th>Recomended Staff</th>
                                <th>Date</th>



                            </tr>

                        </thead>

                        <?php

                        $fdate = date('Y-m-d', strtotime('+1 days'));

                        $tdate = date('Y-m-d', strtotime('-30 days'));

                        $this->db->select('bf_outfeedback.*,bf_opatients.name as name');

                        $this->db->from('bf_outfeedback');

                        $this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

                        if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {

                            $this->db->where('bf_opatients.ward', $_SESSION['ward']);
                        }

                        //$this->db->where('bf_outfeedback.datetime <=',$fdate);

                        //$this->db->where('bf_outfeedback.datetime >=',$tdate );

                        $this->db->order_by('datetime', 'desc');

                        $query = $this->db->get();

                        $feedbacktaken = $query->result();

                        //var_dump($feedbacktaken);

                        ?>

                        <tbody>

                            <?php if (!empty($feedbacktaken)) { ?>

                                <?php $sl = 1; ?>

                                <?php foreach ($feedbacktaken as $f) {

                                    $param = json_decode($f->dataset);
                                    if ($param->staffname != '' || $param->staffname != NULL) {


                                ?>

                                    <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">

                                        <td><?php echo $sl; ?></td>

                                        <td><?php echo $f->name; ?> </td>



                                        <td><?php echo $param->staffname; ?></td>

                                        <td><?php echo date('F d,Y', strtotime($f->datetime)); ?></td>



                                    </tr>

                                    <?php $sl++; ?>

                                <?php } ?>

                            <?php } }?>

                        </tbody>

                    </table> <!-- /.table-responsive -->

                </div>

            </div>

        </div>

    </div>
</div>