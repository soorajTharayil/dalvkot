<div class="col-lg-12">
	<!-- Asset History area -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php if ($this->session->userdata('isLogIn') == true) { ?>
				<h3>Asset Life Cycle</h3>
			<?php } ?>
		</div>
		<div class="panel-body" style="height: auto; overflow: auto;">
			<?php
			$nodata = true;
			?>
			<div class="timeline">
				<?php
				$replyMessages = array_reverse($department->replymessage);
				$assetRepairCount = 0;
				$totalDowntimeSeconds = 0; // Initialize total downtime in seconds
				foreach ($replyMessages as $index => $r):
					if ($r->ticket_status === 'Asset Malfunction') {
						$assetRepairCount++;
					}
				?>
					<?php if ($r) {
						$nodata = false;
						// Fetch matching users based on message content
						$this->db->select('user.firstname, user.lastname');
						$this->db->from('asset_ticket_message');
						$this->db->join('user', 'user.user_id = asset_ticket_message.created_by'); // Assuming 'user_id' is the common key
						$this->db->where('asset_ticket_message.message', $r->message); // Condition to match the message
						$query = $this->db->get();
						$user = $query->row();
					?>
						<div class="timeline-item">
							<div class="timeline-badge">
								<span><?php echo date('d M, Y', strtotime($r->created_on)); ?></span>
							</div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h5><?php echo $r->ticket_status; ?></h5>
									<small><?php echo date('g:i A', strtotime($r->created_on)); ?></small>
								</div>
								<div class="timeline-body">
									<?php if ($r->ticket_status == 'Preventive Maintenance') { ?>
										<p><strong>Preventive Maintenance Date:</strong> <?php echo $r->preventive_maintenance_date; ?></p>
										<p><strong>Upcoming Preventive Maintenance Due:</strong> <?php echo $r->upcoming_preventive_maintenance_date; ?></p>
									<?php } ?>
									<?php if ($r->ticket_status == 'Asset Calibration') { ?>
										<p><strong>Last Calibration Date:</strong> <?php echo $r->asset_calibration_date; ?></p>
										<p><strong>Upcoming Calibration Due:</strong> <?php echo $r->upcoming_calibration_date; ?></p>
									<?php } ?>
									<?php if ($r->ticket_status == 'Preventive ') { ?>
										<p><strong>Preventive Maintenance Date:</strong> <?php echo $r->preventive_maintenance_date; ?></p>
										<p><strong>Upcoming Preventive Maintenance Due:</strong> <?php echo $r->upcoming_preventive_maintenance_date; ?></p>
									<?php } ?>
									<?php if ($r->ticket_status == 'Asset Warranty') { ?>
										<p><strong>Warranty Start Date:</strong> <?php echo $r->warrenty; ?></p>
										<p><strong>Warranty End Date:</strong> <?php echo $r->warrenty_end; ?></p>
									<?php } ?>
									<?php if ($r->ticket_status == 'Asset AMC/CMC') { ?>
										<p><strong>Contract Type:</strong> <?php echo $r->contract; ?></p>
										<p><strong>AMC/ CMC Start Date:</strong> <?php echo $r->contract_start_date; ?></p>
										<p><strong>AMC/ CMC End Date:</strong> <?php echo $r->contract_end_date; ?></p>
										<p><strong>AMC/ CMC Cost:</strong> <?php echo $r->contract_service_charges; ?></p>

									<?php } ?>
									<?php if ($r->ticket_status == 'Asset Assign' || $r->ticket_status == 'Asset Reassign' || $r->ticket_status == 'Asset Transfer') { ?>

										<p><strong>Allocated User:</strong> <?php echo $r->action; ?></p>
										<p><strong>Allocated Department:</strong> <?php echo $r->depart; ?></p>
										<p><strong>Comment:</strong> <?php echo $r->reply; ?></p>

									<?php } ?>

									<?php if ($r->ticket_status == 'Asset Malfunction') : ?>

										<p><strong>Malfunction Date & Time:</strong> <?php echo $r->repair_start_time; ?></p>

									
										<!-- <?php if (!empty($r->expense_cost)) : ?>
											<p><strong>Relative Expense:</strong> <?php echo $r->expense_cost; ?></p>
										<?php endif; ?> -->
									<?php endif; ?>

									<?php if ($r->ticket_status == 'Asset Restore') : ?>

										<p><strong>Restore Date & Time:</strong> <?php echo $r->restore_start_date_time; ?></p>

									
										<?php if (!empty($r->expense_cost)) : ?>
											<p><strong>Relative Expense:</strong> <?php echo $r->expense_cost; ?></p>
										<?php endif; ?>
									<?php endif; ?>

									<?php if ($r->ticket_status === 'Asset Sold') : ?>
										<p><strong>Sale Date:</strong> <?= !empty($r->sold_start_date_time) ? $r->sold_start_date_time : 'N/A'; ?></p>

										<?php if (!empty($r->sale_price)) : ?>
											<p><strong>Sale Price:</strong> <?= $r->sale_price; ?></p>
										<?php endif; ?>
										<?php if (!empty($r->reply)) : ?>
											<p><strong>Remarks:</strong> <?= $r->reply; ?></p>
										<?php endif; ?>
									<?php endif; ?>



									<?php if ($r->ticket_status == 'Asset Broken' || $r->ticket_status == 'Asset Malfunction' || $r->ticket_status == 'Asset Restore' || $r->ticket_status == 'Asset Lost' || $r->ticket_status == 'Asset Dispose' || $r->ticket_status == 'Preventive Maintenance' || $r->ticket_status == 'Asset Warranty' || $r->ticket_status == 'Asset AMC/CMC' || $r->ticket_status == 'Asset Calibration') { ?>
										<p><strong>Comment:</strong> <?php echo $r->reply; ?></p>
									<?php } ?>


									<?php if ($r->ticket_status == 'Asset in Use') { ?>

									<?php } ?>


								</div>
							</div>
						</div>
					<?php } ?>
				<?php endforeach; ?>
				
			</div>

			<?php if ($nodata == true) { ?>
				<h3 style="text-align: center; color: tomato;">No Data Available</h3>
			<?php } ?>
		</div>
	</div>
</div>

<style>
	.timeline {
		position: relative;
		padding: 30px 0;
		font-family: Arial, sans-serif;
	}

	.timeline::before {
		content: '';
		position: absolute;
		left: 50%;
		top: 0;
		bottom: 0;
		width: 6px;
		background: rgba(0, 128, 0, 0.7);
		border-radius: 4px;
		z-index: 1;
	}

	.timeline-item-date {
		position: absolute;
		top: -40px;
		/* Adjusted to move above the line */
		left: 50%;
		transform: translateX(-50%);
		background: rgba(0, 128, 0, 0.7);
		color: white;
		padding: 5px 10px;
		border-radius: 4px;
		font-size: 14px;
		font-weight: bold;
		z-index: 2;
		/* Ensure it appears above the line */
	}

	.timeline-item {
		position: relative;
		width: 45%;
		padding: 15px 25px;
		margin-bottom: 30px;
		border-radius: 8px;
		transition: transform 0.2s;
	}

	.timeline-item:hover {
		transform: scale(1.02);
	}

	.timeline-item:nth-child(odd) {
		left: 5%;
	}

	.timeline-item:nth-child(even) {
		left: 56%;
	}

	.timeline-item:nth-child(odd)::before {
		content: '';
		position: absolute;
		top: 50px;
		/* Adjusted to move the line down */
		right: -30px;
		width: calc(50% - 30px);
		height: 2px;
		background: rgba(0, 128, 0, 0.7);
		z-index: 0;
	}

	.timeline-item:nth-child(odd)::after {
		content: '';
		position: absolute;
		top: 45px;
		/* Adjusted to position the arrow correctly */
		right: -10px;
		border-width: 5px;
		border-style: solid;
		border-color: transparent transparent transparent rgba(0, 128, 0, 0.7);
		z-index: 0;
	}

	.timeline-item:nth-child(even)::before {
		content: '';
		position: absolute;
		top: 50px;
		/* Adjusted to move the line down */
		left: -30px;
		width: calc(50% - 30px);
		height: 2px;
		background: rgba(0, 128, 0, 0.7);
		z-index: 0;
	}

	.timeline-item:nth-child(even)::after {
		content: '';
		position: absolute;
		top: 45px;
		/* Adjusted to position the arrow correctly */
		left: -18px;
		border-width: 5px;
		border-style: solid;
		border-color: transparent rgba(0, 128, 0, 0.7) transparent transparent;
		z-index: 0;
	}

	.timeline-badge {
		position: absolute;
		top: 10px;
		left: -50px;
		width: 80px;
		height: auto;
		background: rgba(0, 128, 0, 0.7);
		color: #fff;
		text-align: center;
		padding: 10px;
		border-radius: 4px;
		font-size: 14px;
		font-weight: bold;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
	}

	.timeline-panel {
		background: #fff;
		border-radius: 8px;
		padding: 20px;
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
		position: relative;
		z-index: 2;
	}

	.timeline-heading h5 {
		font-weight: bold;
		color: rgba(0, 128, 0, 0.7);
		margin: 0 0 5px;
	}

	.timeline-body p {
		margin: 5px 0;
		line-height: 1.6;
	}

	.timeline-body strong {
		color: #555;
	}

	@media (max-width: 768px) {
		.timeline-item {
			width: 90%;
			left: 5%;
		}

		.timeline-badge {
			left: auto;
			right: 0;
			transform: translateX(-50%);
		}

		.timeline-panel {
			padding: 15px;
		}
	}
</style>