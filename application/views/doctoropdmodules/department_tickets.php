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
		$table_patients = 'bf_opatients';
		$table_feedback = 'bf_feedback_doctors_opd';
		$table_tickets = 'tickets_doctor_opd';
		$sorttime = 'asc';
		$department = 'department';
		$type = 'doctoropd';
		$setup = 'setup_doctor_opd';




		//$ip_department = $this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);
		$alltickets = $this->ticketsopddoctor_model->alltickets();
		$opentickets = $this->ticketsopddoctor_model->read();
		$closedtickets = $this->ticketsopddoctor_model->read_close();
		$addressed = $this->ticketsopddoctor_model->addressedtickets();


		$ip_department['alltickets'] = count($alltickets);
		$ip_department['opentickets'] = count($opentickets);
		$ip_department['closedticket'] = count($closedtickets);
		$ip_department['addressedtickets'] = count($addressed);

		$shortkey = array();
		$setarray = array();

		foreach ($sresult as $r) {

			$setarray[$r->type] = $r->title;
			$shortkey[$r->shortkey] = $r->type;
		}

		// Pie chart code for checkbox counting 
		$this->db->select('tickets_doctor_opd.*,bf_feedback_doctors_opd.dataset as dataset');
		$this->db->from('tickets_doctor_opd');
		$this->db->join('bf_feedback_doctors_opd', 'bf_feedback_doctors_opd.id = tickets_doctor_opd.feedbackid', 'inner');
		$this->db->join('bf_opatients', 'bf_opatients.id = bf_feedback_doctors_opd.pid', 'inner');
		$this->db->join('department', 'department.dprt_id = tickets_doctor_opd.departmentid', 'inner');
		$this->db->where('bf_feedback_doctors_opd.datet <=', $fdate);
		$this->db->where('bf_feedback_doctors_opd.datet >=', $tdate);
		$this->db->where_in('department.slug', $this->session->userdata['question_array'][$type]);
		$this->db->where('department.type', 'doctoropd');
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();

		$test = $query->result();


		$this->db->select('department.*');
		$this->db->from('department');
		$this->db->join('setup_doctor_opd', 'setup_doctor_opd.shortkey = department.slug');
		$this->db->where_in('department.slug', $this->session->userdata['question_array'][$type]);
		$this->db->where('setup_doctor_opd.parent', 0);
		$this->db->where('department.type', 'doctoropd');
		$query = $this->db->get();
		$department_head_list = $query->result();
		// echo '<pre>';
		// print_r($this->session->userdata['question_array'][$type]); 
		// print_r($department_head_list); exit;

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
				if($value > 0){
				$t = 1;
				$ratebartext .= $percentage;
				$ratebarparaname .= '"' . $feedback_report_label[$key] . ' ' . round($percentage) . '% (' . $value . ')"';
				$ratebarparanamev .= $value . '/' . $numer_of_event;
				}
			} else {
				if($value > 0){
				$ratebartext .= ',' . $percentage;
				$ratebarparaname .= ',"' . $feedback_report_label[$key] . ' ' . round($percentage) . '% (' . $value . ')"';
				$ratebarparanamev .= ',' . $value . '/' . $numer_of_event;
				}
			}
		}
		// END Pie chart code for checkbox counting 
		$feedback_report_count = array_filter($feedback_report_count, function ($value) {
			return $value !== 0;
		});

		arsort($feedback_report_count);
		$maxCountSortedArray = $feedback_report_count;

		$this->db->select("*");
		$this->db->from($setup);
		$this->db->where('parent', 0);
		$query = $this->db->get();
		$reasons = $query->result();

		$maxSelected = null;
		$leastSelected = null;
		$maxSelCount = null;
		$leastSelCount = null;

		foreach ($reasons as $row) {
			$res[$row->shortkey] = $row->shortname;
		}

		foreach ($maxCountSortedArray as $key => $value) {
			if (isset($res[$key])) {

				if ($maxSelCount === null || $value > $maxSelCount) {
					$maxSelected = $res[$key];
					$maxSelCount = $value;
				}

				if ($leastSelCount === null || $value < $leastSelCount) {
					$leastSelected = $res[$key];
					$leastSelCount = $value;
				}
			}
		}

		?>






		<?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TOTAL-TICKETS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ip_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op', 'op_total_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickets_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ticket"></i>
							</div>
							<a href="<?php echo $ip_link_alltickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op', 'op_view_list'); ?></a>

						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-OPEN-TICKETS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo  $ip_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op', 'op_open_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-envelope-open-o"></i>
							</div>
							<a href="<?php echo $ip_link_opentickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op', 'op_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-ADDRESSED-TICKETS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ip_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op', 'op_addressed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $ip_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op', 'op_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php	} ?>
		<?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-CLOSED-TICKETS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ip_department['closedticket'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op', 'op_closed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-check-circle-o"></i>
							</div>
							<a href="<?php echo $ip_link_closedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op', 'op_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php	} ?>
	</div>


	<div class="row">
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('op', 'op_negative_events_analysis'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('op', 'op_negative_analysis_tooltip'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></h3>
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
					<h3><?php echo lang_loader('op', 'op_recent_tickets'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientticket_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsopddoctor_model->alltickets();
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
										<?php echo 'OPT-' . $ticketdata->id ?>
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
										<i class="fa fa-ticket"></i><?php echo lang_loader('op', 'op_rated'); ?><b> <?php echo $ticketdata->ratingt; ?></b><?php echo ' for ' ?><b><?php echo $ticketdata->department->description; ?></b>
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

										
											?>
											<?php if ($comm) { ?>
												<?php if ($zz[$key33] == $ticketdata->department->description) {  ?>
													<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
														<span style="overflow: clip; word-break: break-all;">
															<i class="fa fa-comment-o"></i> <?php echo lang_loader('op', 'op_comment'); ?> :
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
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op', 'op_view_all'); ?></a></div>
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