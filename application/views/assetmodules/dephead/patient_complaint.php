<div class="content">
	<?php
	$hide = false;
	if ($this->input->post('pid') || $this->input->get('patientid')) {
		$hide = true;
		if ($this->input->post('pid')) {
			$pid = $this->input->post('pid');
		} else {
			$pid = $this->input->get('patientid');
		}
		$this->db->where('patientid', $pid);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('bf_feedback_asset_creation');
		$results = $query->result();

		foreach ($results as $result) {
			$id = $result->id;
			$encodedImage = $result->image;
			$pat = json_decode($result->dataset, true);
		}
	?>
		<?php if ($pat) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>
						<a href="javascript:void()" data-toggle="tooltip" title="ASSET MANAGEMENT">
							<i class="fa fa-question-circle" aria-hidden="true"></i>
						</a>
						ASSET DETAILS
					</h3>
				</div>

				<div class="panel-body" style="background: #fff;">
					<table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
						<tr>
							<td><strong>Asset details</strong></td>
							<td>
								<?php if (!empty($pat['patientid'])): ?>
									Asset Code: <?php echo $pat['patientid']; ?><br>
								<?php endif; ?>

								<?php if (!empty($pat['assetname'])): ?>
									Asset Name: <?php echo $pat['assetname']; ?><br>
								<?php endif; ?>

								<?php if (!empty($pat['ward']) && $pat['ward'] != 'Select Asset Group/ Category'): ?>
									Asset Group: <?php echo $pat['ward']; ?><br>
								<?php else: ?>
									Asset Group: -<br>
								<?php endif; ?>

								<?php if (!empty($pat['brand'])): ?>
									Asset Brand: <?php echo $pat['brand']; ?><br>
								<?php endif; ?>

								<?php if (!empty($pat['model'])): ?>
									Asset Model: <?php echo $pat['model']; ?><br>
								<?php endif; ?>

								<?php if (!empty($pat['serial'])): ?>
									Asset Serial No.: <?php echo $pat['serial']; ?><br>
								<?php endif; ?>

								<?php if (!empty($pat['assigned']) && $pat['assigned'] != 'Select Asset User'): ?>
									Allocated User: <?php echo $pat['assigned']; ?><br>
								<?php else: ?>
									Allocated User: -<br>
								<?php endif; ?>

								<?php if (!empty($pat['depart']) && $pat['depart'] != 'Select Asset Department'): ?>
									Allocated Department: <?php echo $pat['depart']; ?><br>
								<?php else: ?>
									Allocated Department: -<br>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td><strong>Asset Location</strong></td>
							<td>
								Area: <?php if (!empty($pat['locationsite']) && $pat['locationsite'] != 'Select Floor/ Area') {
											echo $pat['locationsite'];
										} else {
											echo '-';
										} ?>
								<br>
								Site: <?php if (!empty($pat['bedno']) && $pat['bedno'] != 'Select Site') {
											echo $pat['bedno'];
										} else {
											echo '-';
										} ?>
							</td>
						</tr>
						<tr>
							<td><strong>Purchase & Warranty Info</strong></td>
							<td>
								Purchase Date:
								<?php
								echo (!empty($pat['purchaseDate']) && strtotime($pat['purchaseDate']) !== false)
									? $pat['purchaseDate']
									: 'N/A';
								?>
								<br>
								Install Date:
								<?php
								echo (!empty($pat['installDate']) && strtotime($pat['installDate']) !== false)
									? $pat['installDate']
									: 'N/A';
								?>
								<br>

								Warranty Start Date:
								<?php
								echo (!empty($pat['warrenty']) && strtotime($pat['warrenty']) !== false)
									? $pat['warrenty']
									: 'N/A';
								?>
								<br>

								Warranty End Date:
								<?php
								echo (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false)
									? $pat['warrenty_end']
									: 'N/A';
								?>

								<br>
								Reminder Alert 1:
								<?php
								if (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false) {
									$warranty_end_date = new DateTime($pat['warrenty_end']);
									$reminder_1_date = $warranty_end_date->modify('-15 days')->format('Y-m-d');
									echo $reminder_1_date;
								} else {
									echo 'N/A';
								}
								?>
								<br>
								Reminder Alert 2:
								<?php
								if (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false) {
									$warranty_end_date = new DateTime($pat['warrenty_end']);
									$reminder_2_date = $warranty_end_date->modify('-2 days')->format('Y-m-d');
									echo $reminder_2_date;
								} else {
									echo 'N/A';
								}
								?>
								<br>

							</td>
						</tr>

						<tr>
							<td><strong>Asset Financial Info</strong></td>
							<td>
								Asset Quantity: <?php echo htmlspecialchars($pat['assetquantity'] ?? 'N/A'); ?>
								<br>
								Unit Price: ₹<?php echo htmlspecialchars($pat['unitprice'] ?? 'N/A'); ?>
								<br>
								Total Price: ₹<?php echo htmlspecialchars($pat['totalprice'] ?? 'N/A'); ?>
								<br>
								Depreciation Rate: <?php echo htmlspecialchars($pat['depreciation'] ?? 'N/A'); ?>%
								<br>
								<?php
								// Calculate total asset value at the current date and time
								$purchaseDate = !empty($pat['purchaseDate']) && strtotime($pat['purchaseDate']) !== false ? $pat['purchaseDate'] : null;
								$unitPrice = $pat['unitprice'] ?? 0;
								$depreciationRate = $pat['depreciation'] ?? 0;

								$currentAssetValue = 'N/A';

								if ($purchaseDate && $unitPrice > 0 && $depreciationRate > 0) {
									$purchaseTimestamp = strtotime($purchaseDate);
									$currentTimestamp = time();

									// Calculate number of years since purchase
									$yearsSincePurchase = ($currentTimestamp - $purchaseTimestamp) / (365 * 24 * 60 * 60);

									// Calculate depreciation amount
									$depreciationAmount = ($unitPrice * $depreciationRate / 100) * $yearsSincePurchase;

									// Calculate current asset value
									$currentAssetValue = $unitPrice - $depreciationAmount;
								}
								?>
								Total Asset Value: ₹<?php echo ($currentAssetValue !== 'N/A' ? number_format($currentAssetValue, 2) : $currentAssetValue); ?>
							</td>
						</tr>



						<tr>
							<td><strong>AMC/ CMC Details</strong></td>
							<td>
								Contract Type: <?php echo $pat['contract']; ?>
								<br>
								Start Date:
								<?php
								if ($pat['contract'] === 'AMC') {
									echo $pat['amcStartDate'];
								} elseif ($pat['contract'] === 'CMC') {
									echo $pat['cmcStartDate'];
								}
								?>
								<br>
								End Date:
								<?php
								if ($pat['contract'] === 'AMC') {
									echo $pat['amcEndDate'];
								} elseif ($pat['contract'] === 'CMC') {
									echo $pat['cmcEndDate'];
								}
								?>
								<br>
								Cost:
								<?php
								if ($pat['contract'] === 'AMC') {
									echo $pat['amcServiceCharges'];
								} elseif ($pat['contract'] === 'CMC') {
									echo $pat['cmcServiceCharges'];
								}
								?>
								<br>

								<?php
								$endDate = null;
								if ($pat['contract'] === 'AMC') {
									$endDate = $pat['amcEndDate'];
								} elseif ($pat['contract'] === 'CMC') {
									$endDate = $pat['cmcEndDate'];
								}

								if ($endDate) {
									// Try to parse the date silently
									$endDateTime = DateTime::createFromFormat('Y-m-d', $endDate);

									// If date is valid, proceed with calculations
									if ($endDateTime !== false) {
										$originalEndDate = clone $endDateTime;

										// Calculate Reminder Alert 1 (30 days before end date)
										$reminder1Date = clone $originalEndDate;
										$reminder1 = $reminder1Date->modify('-30 days')->format('d-m-Y');

										// Calculate Reminder Alert 2 (15 days before end date)
										$reminder2Date = clone $originalEndDate;
										$reminder2 = $reminder2Date->modify('-15 days')->format('d-m-Y');

										echo "Reminder Alert 1: $reminder1<br>";
										echo "Reminder Alert 2: $reminder2";
									}
									// If date is invalid, do nothing (no error shown)
								}
								?>
							</td>


						</tr>

						<tr>
							<td> <strong>Supplier Info</strong> </td>
							<td>
								Supplier Name: <?php echo $pat['supplierinfo']; ?>
								<br>
								Service Person Name: <?php echo $pat['servicename']; ?>
								<br>
								Service Person Contact: <?php echo $pat['servicecon']; ?>
								<br>
								Service Person Email: <?php echo $pat['servicemail']; ?>

							</td>
						</tr>

						<tr>
							<td><strong>Preventive Maintenance</strong></td>
							<td>
								<!-- Last Preventive Maintenance Date -->
								<div style="display: flex; align-items: center;">
									<span>Last Preventive Maintenance Date:</span>
									<span><strong><?php echo  $preventive_maintenance_date1; ?></strong></span>
								</div>
								<br>

								<!-- Upcoming Preventive Maintenance Due -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Upcoming Preventive Maintenance Due:</span>
									<span><strong><?php echo  $upcoming_preventive_maintenance_date1; ?></strong></span>
								</div>
								<br>

								<!-- Set Reminder Alert 1 (Default: 15 days before) -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Reminder Alert 1:</span>
									<span><strong><?php echo  $reminder_alert_11; ?></strong></span>
								</div>
								<br>

								<!-- Set Reminder Alert 2 (Default: 2 days before) -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Reminder Alert 2:</span>
									<span><strong><?php echo  $reminder_alert_21; ?></strong></span>
								</div>
							</td>
						</tr>

						<tr>
							<td><strong>Asset Calibration</strong></td>
							<td>
								<!-- Last Preventive Maintenance Date -->
								<div style="display: flex; align-items: center;">
									<span>Last Calibration Date:</span>
									<span><strong><?php echo  $asset_calibration_date1; ?></strong></span>
								</div>
								<br>

								<!-- Upcoming Preventive Maintenance Due -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Upcoming Calibration Due:</span>
									<span><strong><?php echo  $upcoming_calibration_date1; ?></strong></span>
								</div>
								<br>

								<!-- Set Reminder Alert 1 (Default: 15 days before) -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Reminder Alert 1:</span>
									<span><strong><?php echo  $calibration_reminder_alert_11; ?></strong></span>
								</div>
								<br>

								<!-- Set Reminder Alert 2 (Default: 2 days before) -->
								<div style="display: flex; align-items: center; margin-top: -15px;">
									<span>Reminder Alert 2:</span>
									<span><strong><?php echo  $calibration_reminder_alert_21; ?></strong></span>
								</div>
							</td>
						</tr>



						<!-- <?php if (!empty($pat['assigned']) && $department->status === 'Asset Assign') { ?>
                            <tr>
                                <td> <strong>Assigned to</strong> </td>
                                <td>
                                    Asset Group: <?php echo $pat['ward']; ?>
                                </td>
                            </tr>
                        <?php } ?> -->

						<?php if (!empty($pat['image'])) { ?>
							<tr>
								<td><strong>Asset Image</strong></td>
								<td>
									<?php if (!empty($pat['image'])) {
										$encodedImage = $pat['image']; ?>
										<a href="<?php echo $encodedImage; ?>" download="Asset_Image.png">
											<img src="<?php echo $encodedImage; ?>"
												style="max-width: 400px; max-height: 300px; object-fit: contain; cursor: pointer;"
												alt="Rendered Image">
										</a>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
							</tr>
						<?php } ?>

						<tr>
							<td><strong>Attached Documents</strong></td>
							<td>
								<?php
								// Assuming $pat['files_name'] contains the decoded data from your database
								if (!empty($pat['files_name']) && is_array($pat['files_name'])) {
									foreach ($pat['files_name'] as $file) {
										if (!empty($file['name']) && !empty($file['url'])) {
											echo '<a href="' . htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8') . '" download="' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '">';
											echo htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
											echo '</a><br>';
										}
									}
								} else {
									echo 'No files available';
								}
								?>
							</td>
						</tr>




						<?php if (!empty($pat['qrCodeUrl'])) { ?>
							<tr>
								<td><strong>Asset QR Code</strong></td>
								<td>
									<?php if (!empty($pat['qrCodeUrl'])) {
										$qrCodeImage = $pat['qrCodeUrl']; ?>
										<a href="<?php echo $qrCodeImage; ?>" download="QR_Code_Image.png">
											<img src="<?php echo $qrCodeImage; ?>"
												style="max-width: 400px; max-height: 300px; object-fit: contain; cursor: pointer;"
												alt="Rendered QR Code Image">
										</a>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
							</tr>
						<?php } ?>


					</table>
				</div>
			</div>

			<br>

		<?php } else {  ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default ">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf', 'pcf_no_record_found'); ?> <br>
								<a href="<?php echo base_url(uri_string(1)); ?>">
									<button type="button" href="javascript:void()" data-toggle="tooltip" title="Back" class="btn btn-sm btn-success" style="text-align: center;">
										<i class="fa fa-arrow-left"></i>
									</button>

								</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
		<?php }  ?>
	<?php } ?>
	<?php if ($hide == false) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo form_open(); ?>
						<table class="table">
							<tr>
								<th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('pcf', 'pcf_find_by_patient'); ?></th>
								<td class="" style="border:none !important;">
									<input type="text" class="form-control" placeholder="Enter Patient ID" maxlength="15" size="10" name="pid">
								</td>
								<th class="" style="text-align:left;">
									<p style="text-align:left;"><a href="javascript:void()" data-toggle="tooltip" title="Search"><button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button></a>
								</th>
							</tr>
						</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<style>
	ul.feedback {
		margin: 0px;
		padding: 0px;
	}

	li#feedback {
		list-style: none;
		padding: 5px;
		width: 100%;
		background: #f7f7f7;
		margin: 8px;
		box-shadow: -1px 1px 0px #ccc;
		border-radius: 5px;
	}

	li#feedback h4 {
		margin: 0px;
	}

	span.fa.fa-star {
		visibility: hidden;
	}

	.checked {
		color: orange;
		visibility: visible !important;
	}

	ul.feedback li {
		list-style: none;
	}
</style>

<script>
	function openImageInNewTab(imageUrl) {
		window.open(imageUrl, '_blank');
	}
</script>