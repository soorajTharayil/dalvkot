<div class="content">

	<div class="row">
		<!-- alert message -->
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>
		<!-- content -->

		<?php

		$dates = get_from_to_date();
		$fdate = $dates['fdate'];
		$tdate = $dates['tdate'];
		$pagetitle = $dates['pagetitle'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$days = $dates['days'];

		$sresult = $this->efeedor_model->setup_result('setup');


		// print_r($sresult);
		// foreach	($sresult as $key => $p){
		// 	$this->db->where('type', 'inr');
		// }

		?>


		<!-- Total Product Sales area -->

		<div class="col-sm-12">
			<div class="panel panel-default">
			<div class="panel-heading no-print">
                    <div class="btn-group" disabled>
                        <a class="btn btn-success" href="<?php echo base_url("question/add") ?>"> <i class="fa fa-plus"></i> Add Question </a>
                    </div>
                </div>
				<div class="panel-body">

					<table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<th><?php echo lang_loader('adf','adf_slno'); ?></th>
							<th>Title</th>
							<th>Question</th>
							<th>Shortkey</th>
							<th>Title 2L</th>
							<th>Ques 2L</th>
							<th>Title 3L</th>
							<th>Lang 3L</th>
							<th><?php echo lang_loader('adf','adf_action'); ?></th>

						</thead>
						<tbody>
							<?php $sl = 1; ?>
							<?php foreach ($sresult as $r) { ?>
								<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
									<td><?php echo $sl; ?></td>
									<td><?php echo $r->title; ?></td>
									<td><?php echo $r->question; ?></td>
									<td><?php echo $r->shortname; ?></td>
									<td><?php echo $r->titlek; ?></td>
									<td><?php echo $r->questionk; ?></td>
									<td><?php echo $r->titlem; ?></td>
									<td><?php echo $r->questionm; ?></td>
									<td class="center">
										<a href="<?php  echo base_url("question/edit/$r->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
										<a href="<?php // echo base_url("r/delete/$r->id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>')"><i class="fa fa-trash"></i></a>
									</td>

								</tr>
								<?php $sl++; ?>
							<?php } ?>
						</tbody>
					</table>


				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.row -->

	</div>
</div>

<style>
	.panel-body {
		height: auto;
	}
</style>

<style>
	.progress {
		margin-bottom: 10px;
	}
</style>