<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>
		<?php
		include 'info_buttons_ip.php';
		require 'ip_table_variables.php';

		$dates = get_from_to_date();
		$email = $this->session->userdata['email'];
		$fdate = $dates['fdate'];
		$tdate = $dates['tdate'];
		$pagetitle = $dates['pagetitle'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$days = $dates['days'];

		// $ip_feedbacks_count = $this->efeedor_model->get_feedback('bf_patients', 'bf_feedback_adf', $fdatet, $tdate);
		$key_value_setup = $this->efeedor_model->key_value_setup('setup_adf');
		$sresult = $this->efeedor_model->setup_result('setup_adf');


		$table_feedback = 'bf_feedback_adf';
		$table_patients = 'bf_patients';
		$table_tickets = 'tickets_adf';
		$sorttime = 'asc';
		$department = 'department';
		$type = 'adf';
		$setup_adf = 'setup_adf';




		// $ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup_adf, $type);

		$alltickets = $this->ticketsadf_model->alltickets();
		$opentickets = $this->ticketsadf_model->read();
		$closedtickets = $this->ticketsadf_model->read_close();
		$addressed = $this->ticketsadf_model->addressedtickets();


		$ip_department['alltickets'] = count($alltickets);
		$ip_department['opentickets'] = count($opentickets);
		$ip_department['closedtickets'] = count($closedtickets);
		$ip_department['addressedtickets'] = count($addressed);
		// print_r($ip_department);
		// exit;
		$shortkey = array();
		$setarray = array();

		foreach ($sresult as $r) {

			$setarray[$r->type] = $r->title;
			$shortkey[$r->shortkey] = $r->type;
		}

		// Pie chart code for checkbox counting 
		$this->db->select('tickets_adf.*,bf_feedback_adf.dataset as dataset');
		$this->db->from('tickets_adf');
		$this->db->join('bf_feedback_adf', 'bf_feedback_adf.id = tickets_adf.feedbackid', 'inner');
		$this->db->join('bf_patients', 'bf_patients.id = bf_feedback_adf.pid', 'inner');
		$this->db->join('department', 'department.dprt_id = tickets_adf.departmentid', 'inner');
		$this->db->where('bf_feedback_adf.datet <=', $fdate);
		$this->db->where('bf_feedback_adf.datet >=', $tdate);
		$this->db->where_in('department.slug', $this->session->userdata['question_array'][$type]);
		$this->db->where('department.type', 'adf');
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();

		$test = $query->result();


		$this->db->select('department.*');
		$this->db->from('department');
		$this->db->join('setup_adf', 'setup_adf.shortkey = department.slug');
		$this->db->where_in('department.slug', $this->session->userdata['question_array'][$type]);
		$this->db->where('setup_adf.parent', 0);
		$this->db->where('department.type', 'adf');
		$query = $this->db->get();
		$department_head_list = $query->result();

		$feedback_report_count = array();
		$feedback_report_label = array();
		foreach ($department_head_list as $row) {
			$feedback_report_count[$row->slug] = 0;
			$feedback_report_label[$row->slug] = $row->name;
			$active_slugs[] = $row->slug;
		}

		// print_r($active_slugs);
		$numer_of_event = 0;
		foreach ($test as $row) {
			$dset = json_decode($row->dataset);
			foreach ($dset->reason as $key => $value) {
				if ($value === true) {
					// print_r($key);
					if (in_array($key, $active_slugs)) {
						$feedback_report_count[$key] = $feedback_report_count[$key] + 1;
						$numer_of_event++;
					}
				}
			}
		}
		// sort($feedback_report_count);
		// print_r($feedback_report_count);
		foreach ($feedback_report_count as $key => $value) {
			if ($value > 0) {
				$percentage = ($value / $numer_of_event) * 100;
			} else {
				$percentage = 0;
			}
			if ($t == 0) {
				if($count > 0){
				$t = 1;
				$ratebartext .= $percentage;
				$ratebarparaname .= '"' . $feedback_report_label[$key] . ' ' . round($percentage) . '% (' . $value . ')"';
				$ratebarparanamev .= $value . '/' . $numer_of_event;
				}
			} else {
				if($count > 0){
				$ratebartext .= ',' . $percentage;
				$ratebarparaname .= ',"' . $feedback_report_label[$key] . ' ' . round($percentage) . '% (' . $value . ')"';
				$ratebarparanamev .= ',' . $value . '/' . $numer_of_event;
				}
			}
		}
		// END Pie chart code for checkbox counting 
		?>






<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TOTAL-TICKETS') === true) { ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('adf','adf_total_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickets_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-ticket"></i>
						</div>
						<a href="<?php echo $ip_link_alltickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf','adf_view_list'); ?></a>

					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-OPEN-TICKETS') === true) { ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo  $ip_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('adf','adf_open_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-envelope-open-o"></i>
						</div>
						<a href="<?php echo $ip_link_opentickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf','adf_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-ADDRESSED-TICKETS') === true) { ?>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('adf','adf_addressed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-reply"></i>
						</div>
						<a href="<?php echo $ip_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf','adf_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-CLOSED-TICKETS') === true) { ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('adf','adf_closed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-check-circle-o"></i>
						</div>
						<a href="<?php echo $ip_link_closedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf','adf_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="row">
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf','adf_negative_events_analysis'); ?> <a href="javascript:void()" data-toggle="tooltip" title="This pie chart gives you detailed metrics on no. of tickets_adf received by each department."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></h3>
				</div>
				<div class="panel-body" style="height: 495px;" id="pie_donut">
					<div class="message_inner chart-container">
						<canvas id="canvaspie"></canvas>

					</div>
				</div>
			</div>
		</div>


		<!-- Total Product Sales area -->


		<div class="col-lg-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf','adf_recent_tickets'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientticket_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsadf_model->alltickets();
						$ticket_data = $a;

						$this->db->select("*");
						$this->db->from($setup);
						$this->db->where('parent', 0);
						$query = $this->db->get();
						$reasons  = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->title] = $row->title;
							$zz[$row->type] = $row->title;
						}


						foreach ($ticket_data as $ticketdata) {
						?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
									<?php echo 'ADFT-' . $ticketdata->id ?>
										<span style="float: right;font-size:10px;"><?php
																					echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?></span>
									</p>

									<p class="inbox-item-text">
										<i class="fa fa-user-plus"></i> <?php echo $ticketdata->feed->name; ?> (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), from
										<?php
										if ($ticketdata->feed->bedno) {
											echo $ticketdata->feed->bedno;
											echo ' in ';
										}
										?>
										<?php echo $ticketdata->feed->ward . '.'; ?>
									</p>
									<p class="inbox-item-text">
										<i class="fa fa-ticket"></i><?php echo lang_loader('adf','adf_rated'); ?><b><?php echo $ticketdata->ratingt; ?></b><?php echo ' for ' ?><b><?php echo $ticketdata->department->description; ?></b>
									</p>

									<?php if ($ticketdata->feed->reason == true) { ?>
										<p class="inbox-item-text">
											<?php
											foreach ($ticketdata->feed->reason as $key => $value) {
												if ($value) {
													if ($titles[$key] == $ticketdata->department->description) {
														if (in_array($key, $keys)) { ?>
															<i class="fa fa-frown-o" aria-hidden="true"></i>
															<?php echo $res[$key]; ?>
															<br>
														<?php 	} ?>
													<?php 	} ?>
												<?php 	} ?>
											<?php 	} ?>
										</p>
									<?php 	} ?>

									<?php foreach ($ticketdata->feed->comment as $key33 => $value) { ?>
										<?php if ($key33) { ?>
											<?php $comm = $value;

											// print_r($key33); 
											?>
											<?php if ($comm) { ?>
												<?php if ($zz[$key33] == $ticketdata->department->description) { ?>
													<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
														<span style="overflow: clip; word-break: break-all;">
															<i class="fa fa-comment-o"></i><?php echo lang_loader('adf','adf_comment'); ?> :
															<?php
															if (strlen($comm) > 60) {
																$comm = substr($comm, 0, 60) . '  ' . ' ...';
															} ?>
															<?php echo '"' . $comm . '"'; ?>.
														</span>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										<?php } ?>




													<p class="inbox-item-text" style="font-size:10px;">
														<?php if ($ticketdata->status == 'Closed') { ?>
															<span style="color:  #198754;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
															<?php echo 'Closed'; ?>
														<?php } ?>
														<?php if ($ticketdata->status == 'Addressed') { ?>
															<span style="color:  #f0ad4e;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
															<?php echo 'Addressed'; ?>
														<?php } ?>
														<?php if ($ticketdata->status == 'Open' || $ticketdata->status == 'Reopen' || $ticketdata->status == 'Transfered') { ?>
															<span style="color: #d9534f;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
															<?php echo 'Open'; ?>
														<?php }  ?>

														<?php
														echo date('g:i A, d-m-y', strtotime($ticketdata->last_modified)); ?>
													</p>
								</div>
							</a>
						<?php } ?>
						<?php  ?>
					</div>
				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf','adf_view_all'); ?></a></div>
			</div>

		</div>

		<!-- /.row -->
	</div>
</div>


</div>
<style>
	.panel-body {
		height: 531px;
	}
</style>

<script>
	var randomScalingFactor = function() {
		return Math.round(Math.random() * 100);
	};

	var config = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
					<?php echo $ratebartext; ?>
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.orange,
					window.chartColors.green,
					window.chartColors.grey,
					window.chartColors.yellow,
					window.chartColors.purple,
					window.chartColors.olive,
					window.chartColors.patter1,
					window.chartColors.patter2,
					window.chartColors.patter3,
					window.chartColors.patter4,
					window.chartColors.patter5,
					window.chartColors.khaki

				],
				label: 'Overall Performance Chart'
			}],
			labels: [<?php echo $ratebarparaname; ?>]
		},
		options: {
			responsive: true,
			tooltipTemplate: "<%= Math.round(circumference / 6.283 * 100) %>%",
		}
	};

	window.onload = function() {
		var ctx = document.getElementById('chart-area').getContext('2d');
		window.myPie = new Chart(ctx, config);
	};


	//showpiechart();
</script>
<script>



</script>

<script>



</script>
<script>
	var randomScalingFactor = function() {

		return Math.round(Math.random() * 100);

	};


	var indexshow = "<?php echo $ratebarparanamev; ?>";
	var res = indexshow.split(",");
	var config = {

		type: 'pie',


		data: {

			datasets: [{

				data: [

					<?php echo $ratebartext; ?>

				],

				backgroundColor: [

					window.chartColors.red,
					window.chartColors.orange,
					window.chartColors.green,
					window.chartColors.grey,
					window.chartColors.yellow,
					window.chartColors.purple,
					window.chartColors.olive,
					window.chartColors.patter1,
					window.chartColors.patter2,
					window.chartColors.patter3,
					window.chartColors.patter4,
					window.chartColors.patter5,
					window.chartColors.khaki

				],

				label: 'Dataset 1',

			}],

			labels: [<?php echo $ratebarparaname; ?>]

		},

		options: {

			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				enabled: true,
				mode: 'single',
				callbacks: {
					label: function(tooltipItems, data, labels) {
						var multistringText = [];

						//console.log(tooltipItems);
						multistringText.push(data.labels[tooltipItems.index]);
						multistringText.push(res[tooltipItems.index] + ' Negative Events');
						return multistringText;
					}
				}
			},


		}

	};

	window.onload = function() {

		var ctx = document.getElementById('canvaspie').getContext('2d');

		window.myPie = new Chart(ctx, config);

	};





	showpiechart();
</script>




<style>
	.chart-container {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		width: 460px !important;
		margin: 0px auto;
		height: 450px;
		width: 200px;
	}


	.progress {
		margin-bottom: 10px;
	}

	.mybarlength {
		text-align: right;
		margin-right: 18px;
		font-weight: bold;
	}

	.panel-body {
		height: 531px;
	}

	.bar_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 500px;
		width: 1024px;
	}


	.line_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 270px;
		width: 200px;
	}

	@media screen and (max-width: 1024px) {
		#pie_donut {
			overflow-x: scroll;
		}

		#bar {
			overflow-x: scroll;
		}

		#line {
			overflow-x: scroll;
			overflow-y: scroll;
		}
	}
</style>