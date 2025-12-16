<!-- This  page shows List Of roles / Floor -->
<div class="content">
    <div class="row">

        <!--  table area start -->

        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("role/create") ?>"> <i class="fa fa-plus"></i>&nbsp;Add</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">

                    <!-- table head start -->
                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>
                                <th>Role</th>
                                <th><?php echo lang_loader('sg','sg_action'); ?></th>


                            </tr>
                        </thead>
                        <!-- table head end -->

                        <!-- table body start -->
                        <tbody>
                            <?php if (!empty($departments)) { ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($departments as $department) { ?>
                                    <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $department->title; ?></td>
                                        

                                        <td class="center">

                                            <a href="<?php echo base_url("role/edit/$department->guid") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>

                                            <a href="<?php echo base_url("role/delete/$department->guid") ?>" onclick="return confirm('<?php echo display('are_you_sure') ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>

                                        </td>

                                    </tr>
                                    <?php $sl++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    <!-- table body end -->

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
 <!-- table area stop -->
    </div>
</div>
<style>
    .dt-buttons.btn-group {
        display: none;
    }
</style>
