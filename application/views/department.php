<!-- This page shows the list of departments -->
<br>
<div class="content">

    <div class="row">
        <!--  table area start-->
        <div class="col-sm-12">
            <div class="panel panel-default thumbnail">


                <div class="panel-body">
                <table class="datatablett table table-striped table-bordered" cellspacing="0" width="100%">
                     <!-- table head start -->
                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>
                                <th>Department Name</th>
                                <th>Contact Person</th>
                                <th>Mobile</th>
                                <th>Email</th>

                                <!-- <th>Actions</th> -->
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
                                        <td><?php echo $department->description; ?></td>
                                        <td><?php echo $department->pname; ?></td>
                                        <td><?php echo $department->mobile; ?></td>
                                        <td><?php echo $department->email; ?></td>


                                        <!-- <td class="center">
                                        <a href="<?php echo base_url("department/edit/$department->dprt_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        
                                    </td> -->
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
         <!--  table area end-->
    </div>
</div>
<style>
    .dt-buttons.btn-group {
        display: none;
    }
</style>