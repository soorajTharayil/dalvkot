<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	include 'audit_tables.php';


	/* START DATE AND CALENDER */
	$dates = get_from_to_date();
	$pagetitle = $dates['pagetitle'];
	$fdate = $dates['fdate'];
	$tdate = $dates['tdate'];
	$pagetitle = $dates['pagetitle'];
	$fdate = date('Y-m-d', strtotime($fdate));
	$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
	$days = $dates['days'];
	/* END DATE AND CALENDER */

	$table_feedback = 'bf_feedback_ctscan_time';
	$table_patients = 'bf_patients';
	$sorttime = 'asc';
	$setup = 'setup';
	$asc = 'asc';
	$desc = 'desc';

	$feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	$ip_feedbacks_count = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
	if ($feedbacktaken) {


	?>

		<div class="row">

			<!-- Audit details -->
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<strong>Audit Details</strong>
					</div>

					<div class="panel-body" style="font-size:14px; line-height:1.5;">

						<?php
						// Frequency (case-insensitive by title)
						$auditTitle = 'CT Scan waiting time';
						$norm = mb_strtolower($auditTitle, 'UTF-8');

						$row = $this->db->select('frequency, target')
							->from('bf_audit_frequency')
							->where("LOWER(title) = " . $this->db->escape($norm), NULL, FALSE)
							->limit(1)->get()->row();

						$freq   = $row ? $row->frequency : 'N/A';


						// Load all users
						$users = $this->db->select('user.*, roles.role_id')
							->join('roles', 'user.user_role = roles.role_id')
							->order_by('roles.role_id', 'asc')
							->get('user')->result();

						// Per-user permission check (example feature: AUDIT-FORM1)
						$custodian_names = [];
						if (!empty($users)) {
							foreach ($users as $user) {
								$this->db->from('user_permissions as UP');
								$this->db->select('F.feature_name');
								$this->db->join('features as F', 'UP.feature_id = F.feature_id');
								$this->db->where('UP.user_id', $user->user_id);
								$this->db->where('UP.status', 1);
								$perms = $this->db->get()->result();

								foreach ($perms as $p) {
									if (strcasecmp(trim($p->feature_name), 'AUDIT-FORM7') === 0) {
										$custodian_names[] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8');
										break;
									}
								}
							}
						}
						$custodian_names = array_unique($custodian_names);

						// Last audit date (using your current array shape)
						$lastDate = (!empty($feedbacktaken) && !empty($feedbacktaken[0]->datet))
							? date('d-M-Y', strtotime($feedbacktaken[0]->datet))
							: 'N/A';
						?>

						<table class="table table-bordered table-condensed" style="margin:0;">
							<tbody>
								<tr>
									<th style="width:240px;">Audit Definition</th>
									<td>Tracks CT scan waiting time from billing to procedure completion as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to optimize workflow, ensure safety, and enhance patient satisfaction.</td>
								</tr>
								<tr>
									<th>Audit Frequency</th>
									<td>
										<?= htmlspecialchars($freq, ENT_QUOTES, 'UTF-8'); ?>

									</td>
								</tr>
								<tr>
									<th>Last Audit Date</th>
									<td><?= $lastDate; ?></td>
								</tr>
								<tr>
									<th>Audit Custodians</th>
									<td><?= !empty($custodian_names) ? implode(', ', $custodian_names) : 'N/A'; ?></td>
								</tr>
							</tbody>
						</table>

					</div>

				</div>
			</div>


			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div style="float: right; margin-top: 10px; margin-right: 10px;">
						<span style="font-size:17px"><strong>Download Chart:</strong></span>
						<span style="margin-right: 10px;">
							<i data-placement="bottom" class="fa fa-file-pdf-o" style="font-size: 20px; color: red; cursor: pointer;"
								onclick="printChart()" data-toggle="tooltip" title="Download Chart as PDF"></i>
						</span>
						<span>
							<i data-placement="bottom" class="fa fa-file-image-o" style="font-size: 20px; color: green; cursor: pointer;"
								onclick="downloadChartImage()" data-toggle="tooltip"
								title="Download Chart as Image"></i>
						</span>
					</div>
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
							<?php $text = "In the " .  $dates['pagetitle'] . "," . "a total of " . count($ip_feedbacks_count) . " audits were conducted." ?>
							<span class="typing-text"></span>
						</span>
						<span id="audit-report-text" style="display: none;">
							<?php echo "In the " . $dates['pagetitle'] . ", a total of " . count($ip_feedbacks_count) . " audits were conducted."; ?>
						</span>
					</div>
					<div class="panel-body" style="height:250px;" id="bar">
						<div class="message_inner line_chart">
							<canvas id="resposnsechart"></canvas>

						</div>
					</div>
				</div>

			</div>

			<!-- Table start -->
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
						<div>
							<strong>CT SCAN WAITING TIME REPORT - Audit Summary</strong>
						</div>
						<div>
							<a class="btn btn-success" target="_blank" data-placement="bottom" data-toggle="tooltip"
								title="Download detailed audit report"
								href="<?php echo base_url($this->uri->segment(1)) . '/overall_ct_scan' ?>">
								<i class="fa fa-download"></i>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<table class="ctscantime table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
								<th>Audit by</th>
								<th>Audit Date</th>

								<?php if (allfeedbacks_page('feedback_id') == true) { ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
								<?php } ?>


								<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'ip_patient_details'); ?></th>
								
								<th>Area</th>
								<th>Department</th>
								<th>Attended Doctor</th>
								<th>View</th>
								

							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php foreach ($feedbacktaken as $r) {
									// echo '<pre>';
									// print_r($r);
									$param = json_decode($r->dataset);
									$id = $r->id;
									$check = true;


								?>

									<tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>" onclick="window.location='<?php echo $ctscan_wait_time_feedback . $id; ?>';" style="cursor: pointer;">
										<td><?php echo $sl; ?></td>
										<td><?php echo $r->name; ?></td>
										<td style="white-space: nowrap;">
											<?php if ($r->datetime) { ?>
												<?php echo date('d-M-Y', strtotime($r->datetime)); ?><br>
												<?php echo date('g:i a', strtotime($r->datetime)); ?>
											<?php } ?>
										</td>
										<?php if (allfeedbacks_page('feedback_id') == true) { ?>
											<td>
												<a href="<?php echo  $ctscan_wait_time_feedback . $id; ?>">IPDF-<?php echo $id; ?></a>
											</td>
										<?php } ?>
										<td style="overflow: clip;">
											<?php echo $param->patient_name; ?> (<?php echo $param->mid_no; ?>)
											<br>
											Age: <?php echo $param->patient_age; ?>
											<br>
											Gender: <?php echo $param->patient_gender; ?>
										</td>

										<td><?php echo $param->location; ?></td>
										<td><?php echo $param->department; ?></td>
										<td><?php echo $param->attended_doctor; ?></td>
										<td>
											<a href="<?php echo $ctscan_wait_time_feedback . $id; ?>"
												class="btn btn-info btn-sm"
												style="padding: 6px 14px; font-size: 13px;">
												View Details
											</a>
											<?php if (isfeature_active('DELETE-AUDIT') === true) { ?>
												<a class="btn btn-sm btn-danger"
													href="<?php echo base_url($this->uri->segment(1) . '/delete_audit/' . $id . '?table=' . urlencode($table_feedback) . '&redirect=' . urlencode(current_url())); ?>"
													onclick="return confirm('Are you sure you want to delete this audit record?');"
													title="Delete the audit record"
													style="font-size: 14px; margin-top:10px; padding: 4px 12px; width: 80px; margin-left: 15px;">
													<i class="fa fa-trash" style="font-size:16px;"></i> Delete
												</a>
											<?php } ?>
										</td>


										<?php /* if ($r->error_prone_comment) { ?>
											<td><?php echo $r->error_prone_comment; ?></td>
										<?php } else { ?>
											<td><?php echo "-" ?></td>
										<?php } */ ?>

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
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text", {
			strings: ["<?php echo $text; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>

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


<!-- <script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script> -->

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
		height: 250px;
		width: 1024px;
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

<script>
	var url = window.location.href;
	var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
	domain = domain.split("/")[0];

	function resposnsechart(callback) {

		var xhr = new XMLHttpRequest();
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_ctscan_time"; // Replace with your API endpoint
		xhr.open("GET", apiUrl, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var responseData = JSON.parse(xhr.responseText);
				callback(responseData); // Call the callback function with the API data
			}
		};
		xhr.send();
	}

	function resposnseChart(apiData) {
		var labels = apiData.map(function(item) {
			return item.label_field;
		});

		var dataPoints = apiData.map(function(item) {
			return item.all_detail.count;
		});
		if (dataPoints.length == 1) {
			dataPoints.push(null);
			labels.push(" ");
		}
		// Create Chart.js chart
		var ctx = document.getElementById("resposnsechart").getContext("2d");
		ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
		ctx.canvas.parentNode.style.height = "100%";

		// Create a linear gradient fill for the chart
		var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
		gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
		gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)

		var myChart = new Chart(ctx, {
			type: "line",
			data: {
				labels: labels,
				datasets: [{
					label: "Audit Analysis",
					data: dataPoints,
					backgroundColor: gradientFill,
					borderColor: "rgba(0, 128, 0, 1)",
					borderWidth: 1,
					pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
					pointBorderColor: "rgba(0, 128, 0, 1)",
					pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
					pointHoverBorderColor: "rgba(0, 128, 0, 1)",
				}, ],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: "Chart.js Line Chart",
				},
				tooltips: {
					enabled: true,
					mode: "single",
					callbacks: {
						label: function(tooltipItems, data) {
							var multistringText = [];
							var dataIndex = tooltipItems.index; // Get the index of the hovered data point
							var all_detail = apiData[dataIndex].all_detail;
							multistringText.push("Audits Conducted: " + all_detail.count);
							return multistringText;
						},
					},
				},
				hover: {
					mode: "nearest",
					intersect: true,
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Month",
						},
					}, ],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Value",
						},
						ticks: {

							min: 0,
							padding: 25,
							// forces step size to be 5 units
							stepSize: 30,
						},
					}, ],
				},
			},
		});
	}

	// Call the fetchDataFromAPI function and pass the callback function to create the chart
	setTimeout(function() {
		resposnsechart(resposnseChart);
	}, 1000);
	/*patient_feedback_analysis*/
</script>

<script>
	function printChart() {
		const canvas = document.getElementById('resposnsechart');
		const dataUrl = canvas.toDataURL();

		const reportText = document.getElementById('audit-report-text').innerText;

		const windowContent = `
		<html>
		<head>
			<title>Print Chart</title>
			<style>
				body {
					text-align: center;
					margin: 0;
					padding: 20px;
					font-family: Arial;
				}
				h3, p {
					margin-bottom: 10px;
				}
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>CT SCAN WAITING TIME REPORT</h3>
			<p>${reportText}</p>
			<img src="${dataUrl}" alt="Chart">
		</body>
		</html>
	`;

		const printWin = window.open('', '', 'width=800,height=600');
		printWin.document.open();
		printWin.document.write(windowContent);
		printWin.document.close();
		printWin.focus();

		setTimeout(() => {
			printWin.print();
			printWin.close();
		}, 500);
	}
</script>
<script>
	function downloadChartImage() {
		const canvas = document.getElementById('resposnsechart');
		const chartImage = canvas.toDataURL('image/png');

		const reportText = document.getElementById('audit-report-text').innerText;

		// Create new canvas
		const newCanvas = document.createElement('canvas');
		const ctx = newCanvas.getContext('2d');

		const width = canvas.width;
		const height = canvas.height;
		const extraHeight = 60; // Space for text

		newCanvas.width = width;
		newCanvas.height = height + extraHeight;

		// White background
		ctx.fillStyle = '#fff';
		ctx.fillRect(0, 0, newCanvas.width, newCanvas.height);

		// Draw the report text
		ctx.fillStyle = '#000';
		ctx.font = '20px Arial';
		ctx.fillText(reportText, 10, 30);

		// Draw the chart image after it loads
		const img = new Image();
		img.onload = function() {
			ctx.drawImage(img, 0, extraHeight);

			// Create downloadable image
			const finalImage = newCanvas.toDataURL('image/png');
			const link = document.createElement('a');
			link.href = finalImage;
			link.download = 'CT SCAN WAITING TIME REPORT.png';
			link.click();
		};
		img.src = chartImage;
	}
</script>