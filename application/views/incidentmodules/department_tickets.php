<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>
		<?php
		include 'info_buttons_int.php';
		require 'pc_table_variables.php';

		$dates = get_from_to_date();
		$email = $this->session->userdata['email'];
		$fdate = $dates['fdate'];
		$tdate = $dates['tdate'];
		$pagetitle = $dates['pagetitle'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$days = $dates['days'];
		$all_feedback = $this->efeedor_model->get_feedback('bf_employees_incident', 'bf_feedback_incident', $fdatet, $tdate);
		$sresult = $this->efeedor_model->setup_result('setup_incident');


		$table_patients = 'bf_employees_incident';
		$table_feedback = 'bf_feedback_incident';
		$table_tickets = 'tickets_incident';
		$sorttime = 'asc';
		$department = 'department';
		$type = 'incident';
		$setup = 'setup_incident';

		//$int_department =	$this->departmenthead_model->departmenthead_values($table_patients, $table_feedback, $table_tickets, $sorttime, $department, $setup, $type);

		$alltickets = $this->ticketsincidents_model->alltickets();
		$opentickets = $this->ticketsincidents_model->read();
		$closedtickets = $this->ticketsincidents_model->read_close();
		$addressed = $this->ticketsincidents_model->addressedtickets();


		$inc_department['alltickets'] = count($alltickets);
		$inc_department['opentickets'] = count($opentickets);
		$inc_department['closedticket'] = count($closedtickets);
		$inc_department['addressedtickets'] = count($addressed);

		$shortkey = array();
		$setarray = array();
		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
			$shortkey[$r->shortkey] = $r->type;
		}
		$setarray_active = array();





		$tickets = array();
		$i = 0;
		foreach ($alltickets as $row) {

			$tickets[$i] = $row;
			$i++;
		}

		$totaltickets = count($tickets);
		$openticket = 0;
		$closedticket = 0;
		foreach ($tickets as $r) {
			if ($r->status == 'Closed') {
				$closedticket++;
			} else {
				$openticket++;
			}
		}


		$this->db->where('type', 'incident');
		$this->db->where_in('department.slug', $this->session->userdata['question_array'][$type]);
		//$this->db->group_by('description');
		$query = $this->db->get('department');
		$result = $query->result();
		$overallarray = array();
		$tcount = 0;

		foreach ($result as $ps) {

			//print_r($result);

			$setarray_active[] = $shortkey[$ps->slug];
			$this->db->where('type', 'incident');
			$this->db->where('name', $ps->name);
			$query = $this->db->get('department');
			$pq = $query->result();

			foreach ($pq as $p) {
				foreach ($tickets as $rk) {
					//echo '<pre>';
					//print_r($tickets); 

					if ($rk->departmentid == $p->dprt_id) {
						$tcount++;
					}
				}
			}
		}
		$setarray_active = array_unique($setarray_active);

		foreach ($result as $ps) {
			$count = 0;
			//print_r($result);
			$this->db->where('type', 'incident');
			$this->db->where('name', $ps->name);
			$query = $this->db->get('department');
			$pq = $query->result();
			foreach ($pq as $p) {
				foreach ($tickets as $rk) {
					if ($rk->departmentid === $p->dprt_id) {
						$count++;
					}
				}
			}
			if (count($tickets) > 0) {
				$percentage = ($count / $tcount) * 100;
			} else {
				$percentage = 0;
			}
			if ($t == 0) {

				if ($count > 0) {
					$t = 1;
					$ratebartext .= $percentage;
					$ratebarparaname .= '"' . $ps->name . '-' . round($percentage) . '% (' . $count . ')"';
					$ratebarparanamev .= $count . '/' . $tcount;
				}
			} else {
				if ($count > 0) {
					$ratebartext .= ',' . $percentage;
					$ratebarparaname .= ',"' . $ps->name . '-' . round($percentage) . '% (' . $count . ')"';
					$ratebarparanamev .= ',' . $count . '/' . $tcount;
				}
			}
		}
		//exit;
		?>
		<?php




		$tickets = array();
		$ticketbydepartment = array();
		$ticketbydepartmentopen = array();
		$ticketbydepartmentname = array();
		foreach ($alltickets as $row) {
			$this->db->where('id', $row->feedabckid);
			$query = $this->db->get('bf_feedback_incident');

			$patient = $query->result();

			$this->db->where('dprt_id', $row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();

			$slug2 = preg_replace('/[^A-Za-z0-9-]+/', ' ', $department[0]->description);
			$row->slug = $slug2;
			$slug = $patient[0]->id . preg_replace('/[^A-Za-z0-9-]+/', ' ', $department[0]->description);
			$tickets[] = $row;
			$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2] * 1 + 1;
			$ticketbydepartmentname[$slug2] = $department[0]->description;
		}


		$highest_complain = '';
		$lowest_complain = '';
		$i = 0;
		foreach ($ticketbydepartment as $key => $depart) {
			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
			// print_r($closed);

			$open = $ticketbydepartmentopen[$key] * 1;
			if ($i == 0) {
				$highest_complain = $key;
			}
			$lowest_complain = $key;
			$html .= '<tr>
    				<td>' . $ticketbydepartmentname[$key] . '</td>
    				<td>' . $ticketbydepartment_percentage[$key] . '%</td>
    				<td>' . $ticketbydepartment[$key] . '</td>
    			
    			</tr>';
			$i++;
		}


		?>


		<?php if (ismodule_active('INCIDENT') === true  && isfeature_active('TOTAL-INCIDENTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_total_incidents'); ?><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ticket"></i>
							</div>
							<a href="<?php echo base_url($this->uri->segment(1) . '/alltickets'); ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>

						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true  && isfeature_active('OPEN-INCIDENTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo  $inc_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_open_incidents'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-envelope-open-o"></i>
							</div>
							<a href="<?php echo base_url($this->uri->segment(1) . '/opentickets'); ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true  && isfeature_active('IN-REJECTED-INCIDENTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['rejecttickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Rejected incident <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $int_link_rejecttickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('INCIDENT') === true  && isfeature_active('ADDRESSED-INCIDENTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_addressed_incidents'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo base_url($this->uri->segment(1) . '/addressedtickets'); ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true  && isfeature_active('CLOSED-INCIDENTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['closedticket'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_closed_incidents'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-check-circle-o"></i>
							</div>
							<a href="<?php echo base_url($this->uri->segment(1) . '/closedtickets'); ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

	<!-- Key Highlights -->
	<div class="row" style="display: none;">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:hidden;">

			<div class="panel panel-default">
				<div class="panel-heading">

					<h4><?php echo lang_loader('inc', 'inc_key_takeaways'); ?><a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This section will give you a complete understanding of the performance of every parameters and department over the selected period of time."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h4>

				</div>

				<div class="p-l-30 p-r-30">
					<div class="panel-body" style="height: 150px; display:inline;">
						<div class="alert alert-success">
							<span style="font-size: 15px">
								<?php echo lang_loader('inc', 'inc_you_have_received_least_complaints_in'); ?> <strong><?php echo $lowest_complain; ?></strong>

							</span>
						</div>
						<div class="alert alert-warning ">
							<span style="font-size: 15px">
								<?php echo lang_loader('inc', 'inc_you_have_received_most_complaints_in'); ?><strong><?php echo $highest_complain; ?></strong>

							</span>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Close Key Highlights -->



	<!-- Ticket Pie chart & Tickets -->
	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('inc', 'inc_incident_analysis'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('inc', 'inc_incident_analysis_tooltip'); ?>."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></h3>
				</div>


				<div class="panel-body" style="height: 495px;" id="pie_donut">
					<div class="message_inner chart-container">
						<canvas id="canvaspie"></canvas>
					</div>
				</div>


			</div>
		</div>

		<div class="col-lg-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('inc', 'inc_recent_incidents'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientticket_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsincidents_model->alltickets();
						$ticket_data = $a;

						$this->db->select("*");
						$this->db->from($setup);
						// $this->db->where('parent', 0);
						$query = $this->db->get();
						$reasons  = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->title] = $row->title;
						}


						foreach ($ticket_data as $ticketdata) {
						?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
										<?php echo 'INC-' . $ticketdata->id ?>
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
										<i class="fa fa-ticket"></i><b> <?php echo $ticketdata->department->description; ?></b>
									</p>

									<?php if ($ticketdata->feed->reason == true) { ?>
										<p class="inbox-item-text">
											<?php
											foreach ($ticketdata->feed->reason as $key => $value) {
												if ($titles[$key] == $ticketdata->department->description) {
													if (in_array($key, $keys)) { ?>
														<i class="fa fa-frown-o" aria-hidden="true"></i>
														<?php echo $res[$key]; ?>
														<br>
													<?php 	} ?>
												<?php 	} ?>
											<?php 	} ?>
										</p>
									<?php 	} ?>

									<?php if ($ticketdata->feed->comment == true) { ?>

										<?php
										foreach ($ticketdata->feed->comment as $key => $value) { ?>
											<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">

												<?php
												if (strlen($value) > 60) {
													$value = substr($value, 0, 60) . '  ' . ' ...';
												} ?>
												<?php if ($value) { ?>
													<i class="fa fa-comment-o"></i><?php echo lang_loader('inc', 'inc_description'); ?> :
													"<?php echo $value; ?>"
												<?php 	} ?>

											</p>
										<?php 	} ?>
									<?php 	} ?>



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
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;">View All</a></div>
			</div>

		</div>
		<!-- /.row -->
	</div>

	<!-- /.row -->
</div>
</div>



<style>
	.chart-container {

		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		width: 460px !important;
		margin: 0px auto;


	}

	#why_patient_choose {
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
<style>
	.panel-body {
		height: 531px;
	}
</style>

<script>
	/*var randomScalingFactor = function() {
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


	//showpiechart();*/
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
						multistringText.push(res[tooltipItems.index] + ' Incidents');
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