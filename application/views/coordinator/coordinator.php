<div class="content">
    <div class="row">
        <!--  table area -->
        <div class="col-sm-12">
            <div class="panel panel-default ">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("Coordinator/create") ?>"> <i class="fa fa-plus"></i> Add Coordinator </a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Image</th>

                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($departments)) { ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($departments as $department) { ?>
                                    <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $department->guid; ?></td>
                                        <td><?php echo $department->name; ?></td>
                                        <td><?php echo $department->files; ?></td>

                                        <td class="center">
                                            <a href="<?php echo base_url("Coordinator/edit/$department->guid") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo base_url("Coordinator/delete/$department->guid") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
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