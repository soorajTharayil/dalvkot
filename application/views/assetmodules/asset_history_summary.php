<div class="summary_section">
	<?php
	function formatIndianCurrency($amount)
	{
		$amount = round($amount); // If you want to remove decimals
		$num = (string)$amount;
		$len = strlen($num);
		if ($len > 3) {
			$last3 = substr($num, -3);
			$restUnits = substr($num, 0, $len - 3);
			$restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
			return $restUnits . "," . $last3;
		} else {
			return $num;
		}
	}
	?>

	<?php
	$transferCount = 0;
	$malfunctionCount = 0;
	$totalRepairExpense = 0;
	$totalDowntimeSeconds = 0;
	$preventiveCount = 0;
	$calibrationCount = 0;

	$repairQueue = [];

	foreach ($department->replymessage as $r) {
		switch ($r->ticket_status) {
			case 'Asset Transfer':
				$transferCount++;
				break;

			case 'Asset Malfunction':
				$malfunctionCount++;
				if (!empty($r->repair_start_time)) {
					$repairQueue[] = strtotime($r->repair_start_time); 
				}
				break;

			case 'Asset Restore':
				if (!empty($r->restore_start_date_time)) {
					$restoreTime = strtotime($r->restore_start_date_time);

					// Dequeue one repair time and calculate downtime
					if (!empty($repairQueue)) {
						$repairTime = array_shift($repairQueue);
						if ($restoreTime > $repairTime) {
							$totalDowntimeSeconds += ($restoreTime - $repairTime);
						}
					}
				}

				if (!empty($r->expense_cost)) {
					$totalRepairExpense += floatval($r->expense_cost);
				}
				break;

			case 'Preventive Maintenance':
				$preventiveCount++;
				break;

			case 'Asset Calibration':
				$calibrationCount++;
				break;
		}

		// Fetch user based on message
		if ($r) {
			$nodata = false;
			$this->db->select('user.firstname, user.lastname');
			$this->db->from('asset_ticket_message');
			$this->db->join('user', 'user.user_id = asset_ticket_message.created_by');
			$this->db->where('asset_ticket_message.message', $r->message);
			$query = $this->db->get();
			$user = $query->row();
		}
	}


	// Format downtime to human-readable
	$totalDays = floor($totalDowntimeSeconds / (24 * 60 * 60));
	$totalDowntimeSeconds %= (24 * 60 * 60);
	$totalHours = floor($totalDowntimeSeconds / (60 * 60));
	$totalDowntimeSeconds %= (60 * 60);
	$totalMinutes = floor($totalDowntimeSeconds / 60);
	$formattedDowntime = "{$totalDays} days, {$totalHours} hours, {$totalMinutes} minutes";
	?>

	<!-- HTML Table to Show Summary -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php if ($this->session->userdata('isLogIn') == true) { ?>
				<h3>Asset activity summary</h3>
			<?php } ?>
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Asset Metric</th>
						<th>Count / Value</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Asset transfer count</td>
						<td><?php echo $transferCount; ?></td>
					</tr>
					<tr>
						<td>Malfunction incidents</td>
						<td><?php echo $malfunctionCount; ?></td>
					</tr>
					<tr>
						<td>Malfunction repair expenses</td>
						<td>₹<?php echo formatIndianCurrency($totalRepairExpense); ?></td>
					</tr>
					<tr>
						<td>Total Downtimes</td>
						<td><?php echo $formattedDowntime; ?></td>
					</tr>
					<tr>
						<td>Preventive maintenance count</td>
						<td><?php echo $preventiveCount; ?></td>
					</tr>
					<tr>
						<td>Calibration events count</td>
						<td><?php echo $calibrationCount; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>