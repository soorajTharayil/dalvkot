<div class="content">
    <div class="row">
        <!--  table area -->
        <div class="col-sm-12">
            <div class="panel panel-default ">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <!-- <a class="btn btn-success" href="<?php echo base_url("audit_custodians/create") ?>"> <i class="fa fa-plus"></i> Add </a> -->
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>
                                <th>Audit Name</th>
                                <th>Audit Custodians</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($departments)) { ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($departments as $department) { ?>
                                    <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                        <td><?php echo $sl; ?></td>
                                        <td style="width: 30%;"><?php echo $department->title; ?></td>
                                        <td><?php echo $department->bed_no; ?></td>
                                        
                                    </tr>
                                    <?php $sl++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>