<div class="col-lg-12">

	<!-- Total Product Sales area -->

	<div class="panel panel-default">


		<div class="panel-heading">
		<h3>Ticket History</h3>
		</div>
		<div class="panel-body" style="    height: auto;     overflow: auto;">
			<?php
			$nodata = true;
			?>
			<div class="timeline">
				<?php foreach ($department->replymessage as $index => $r): ?>
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
								
								
								<p><strong>Action:</strong> <?php echo $r->action; ?></p>
								<!-- <?php if ($r->reply && $r->ticket_status != 'Described' && $r->ticket_status != 'Assigned' && $r->ticket_status != 'Re-assigned'&& $r->ticket_status != 'Reopen' ): ?>
									<p style="word-wrap: break-word; overflow-wrap: break-word; white-space: pre-line;">
										<strong>Reply:</strong> <?php echo $r->reply; ?>
									</p>
								<?php endif; ?> -->

								<?php if ($r->ticket_status == 'Described') { ?>
									<?php if ($r->reply) { ?>
										<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;">
											<b>Description</b>:
											<?php echo $r->reply; ?>
											<p class="inbox-item-text" style="overflow: clip; word-break: break-all; font-size: 14px;">
										<?php if ($r->describe_picture) : ?>
											<?php
											$file_extension = pathinfo($r->describe_picture, PATHINFO_EXTENSION);
											$file_url = base_url($r->describe_picture); // Adjust path as per your setup
											?>

											<?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
												<!-- Display Image -->
												<br>
												<img style="width: 100px;" src="<?php echo $file_url; ?>"> <br>
												<a style="margin:5px; font-size:14px;" href="<?php echo $file_url; ?>" download>Download Image</a>

											<?php elseif ($file_extension === 'pdf') : ?>
												<!-- Display PDF -->
												<br>
												<embed src="<?php echo $file_url; ?>" type="application/pdf" width="200" height="200" /><br>
												<a style="margin:5px; font-size:14px;" href="<?php echo $file_url; ?>" download>Download PDF</a>

											<?php elseif (in_array($file_extension, ['xls', 'xlsx', 'csv'])) : ?>
												<!-- Display link for Excel and CSV files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download <?php echo strtoupper($file_extension); ?> File</a>

											<?php elseif (in_array($file_extension, ['txt'])) : ?>
												<!-- Display link for text files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Text File</a>

											<?php elseif (in_array($file_extension, ['doc', 'docx'])) : ?>
												<!-- Display link for Word documents -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Word Document</a>

											<?php elseif (in_array($file_extension, ['zip', 'rar'])) : ?>
												<!-- Display link for compressed files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Compressed File</a>

											<?php elseif (in_array($file_extension, ['bmp', 'tiff'])) : ?>
												<!-- Display link for image files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Image File</a>

											<?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov', 'm4a', 'wav', 'wma'])) : ?>
												<!-- Display link for video and audio files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Media File</a>

											<?php else : ?>
												<!-- Handle unsupported file types -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download File</a>
												<!-- Optional message for unsupported previews -->
												<!-- File type not supported for preview -->
											<?php endif; ?>
										<?php endif; ?>
									</p>
										</p>
									<?php } ?>
								<?php } ?>
								<?php if ($r->reply && $r->ticket_status != 'Described') { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;">
										<b><?php echo lang_loader('inc', 'inc_comment'); ?></b>:
										<?php echo $r->reply; ?>
									</p>
								<?php } ?>
								<?php if ($r->ticket_status == 'Closed') { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;"> <?php if ($r->rootcause) { ?>
											<b><?php echo lang_loader('inc', 'inc_root_cause'); ?></b>:

											<?php echo $r->rootcause; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;"> <?php if ($r->corrective) { ?>
											<b>Corrective</b>:

											<?php echo $r->corrective; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;"> <?php if ($r->preventive) { ?>
											<b>Preventive</b>:

											<?php echo $r->preventive; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;"> <?php if ($r->resolution_note) { ?>
											<b>Resolution note </b>:

											<?php echo $r->resolution_note; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all; font-size: 14px;">
										<?php if ($r->picture) : ?>
											<?php
											$file_extension = pathinfo($r->picture, PATHINFO_EXTENSION);
											$file_url = base_url($r->picture); // Adjust path as per your setup
											?>

											<?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
												<!-- Display Image -->
												<br>
												<img style="width: 100px;" src="<?php echo $file_url; ?>"> <br>
												<a style="margin:5px; font-size:14px;" href="<?php echo $file_url; ?>" download>Download Image</a>

											<?php elseif ($file_extension === 'pdf') : ?>
												<!-- Display PDF -->
												<br>
												<embed src="<?php echo $file_url; ?>" type="application/pdf" width="200" height="200" /><br>
												<a style="margin:5px; font-size:14px;" href="<?php echo $file_url; ?>" download>Download PDF</a>

											<?php elseif (in_array($file_extension, ['xls', 'xlsx', 'csv'])) : ?>
												<!-- Display link for Excel and CSV files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download <?php echo strtoupper($file_extension); ?> File</a>

											<?php elseif (in_array($file_extension, ['txt'])) : ?>
												<!-- Display link for text files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Text File</a>

											<?php elseif (in_array($file_extension, ['doc', 'docx'])) : ?>
												<!-- Display link for Word documents -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Word Document</a>

											<?php elseif (in_array($file_extension, ['zip', 'rar'])) : ?>
												<!-- Display link for compressed files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Compressed File</a>

											<?php elseif (in_array($file_extension, ['bmp', 'tiff'])) : ?>
												<!-- Display link for image files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Image File</a>

											<?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov', 'm4a', 'wav', 'wma'])) : ?>
												<!-- Display link for video and audio files -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download Media File</a>

											<?php else : ?>
												<!-- Handle unsupported file types -->
												<br>
												<a style="font-size:14px;" href="<?php echo $file_url; ?>" download>Download File</a>
												<!-- Optional message for unsupported previews -->
												<!-- File type not supported for preview -->
											<?php endif; ?>
										<?php endif; ?>
									</p>



								<?php } ?>


							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

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


<!-- /.row -->