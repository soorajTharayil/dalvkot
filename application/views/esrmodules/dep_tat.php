<!-- This page shows the list of departments -->
<div class="content">
	<?php

	$email = $this->session->userdata['email'];
	// $this->db->where('department.type', 'inpatient');
	// $this->db->group_by('type,description');
	
	
	$this->db->select('*');
	$this->db->where('department.type','esr');
	$query = $this->db->get('department');
	$departments = $query->result();
	?>
	<div class="row">
		<!--  table area start-->
		<div class="col-lg-12">
			<div class="panel panel-default thumbnail">


				<div class="panel-body">
					<table class="datatables table table-striped table-bordered" cellspacing="0" width="100%">
						<!-- table head start -->
						<thead>
							<tr>
								<th><?php echo display('serial') ?></th>
								<th><?php echo lang_loader('isr','isr_department'); ?></th>
								<th><?php echo lang_loader('isr','isr_issue'); ?></th>
								<th><?php echo lang_loader('isr','isr_tat_set'); ?></th>


								<!-- <th><?php echo lang_loader('isr','isr_action'); ?>s</th> -->
							</tr>
						</thead>
						<!-- table head end -->

						<!-- table body start -->
						<tbody>
							<?php if (!empty($departments)) { ?>
								<?php $sl = 1;
								$i = 0; ?>
								<?php foreach ($departments as $department) { ?>


									<?php #  print_r($departments);
									?>
									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
										<td><?php echo $sl; ?></td>
									
										<td><?php echo $department->description; ?></td>
										<td><?php echo $department->name; ?></td>
										<td><?php 
										
										
										$value2 = $this->isr_model->convertSecondsToTime($department->close_time);
										$dep_tat = '';
										if ($value2['days'] != 0) {
											$dep_tat .=  $value2['days'] . ' days, ';
										}
										if ($value2['hours'] != 0) {
											$dep_tat .=  $value2['hours'] . ' hrs, ';
										}
										if ($value2['minutes'] != 0) {
											$dep_tat .= $value2['minutes'] . ' mins.';
										}
			
										
										echo $dep_tat; ?></td>


										<!-- <td class="center">
                                        <a href="<?php echo base_url("department/edit/$department->dprt_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                        
                                    </td> -->
									</tr>
									<?php $sl++;
									$i++ ?>
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