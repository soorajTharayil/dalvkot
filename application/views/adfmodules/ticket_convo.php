<div class="col-lg-12">

	<!-- Total Product Sales area -->

	<div class="panel panel-default">


		<div class="panel-heading">
			<?php if ($this->session->userdata('isLogIn') == false) { ?>
				<h3><?php echo lang_loader('adf','adf_ticket_thread'); ?></h3>
			<?php } else { ?>
				<h3><?php echo lang_loader('adf','adf_ticket_history'); ?></h3>
			<?php } ?>
		</div>
		<div class="panel-body" style="    height: auto;     overflow: auto;">
			<?php
			$nodata = true;
			?>
			<div class="message_inner">
				<?php foreach ($department->replymessage as $r) { ?>
					<?php if ($r) { ?>

						<?php
						$nodata = false;

						?>

						<a href="javascript:return false;">
							<div class="inbox-item">
								<strong class="inbox-item-author"><?php echo $r->message; ?> </strong>
								<br>
								<span class="inbox-item-date"><?php echo date('g:i A, d-m-y', strtotime($r->created_on)); ?></span>

								<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
									<b><?php echo lang_loader('adf','adf_action'); ?></b>:
									<?php echo $r->ticket_status; ?>
								</p>
								<?php if ($r->ticket_status == 'Transfered') { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
										<?php if ($r->action) { ?>
											<b><?php echo $r->action; ?></b>
										<?php } ?>
									</p>
								<?php } ?>
								<?php if ($r->reply) { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
										<b><?php echo lang_loader('adf','adf_comment'); ?></b>: 
										<?php echo $r->reply; ?>
									</p>
								<?php } ?>
								<?php if ($r->ticket_status == 'Closed') { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"> <?php if ($r->rootcause) { ?>
											<b><?php echo lang_loader('adf','adf_root_cause'); ?></b>:

											<?php echo $r->rootcause; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"> <?php if ($r->corrective) { ?>
											<b><?php echo lang_loader('adf','adf_capa'); ?></b>:

											<?php echo $r->corrective; ?>
										<?php } ?>
									</p>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
										<?php if ($r->picture) : ?>
									
											<?php
											$file_extension = pathinfo($r->picture, PATHINFO_EXTENSION);
											if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'xls', 'xlsx'])) :
											?>
												
												<?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
													<br>
													<img style="width: 100px; " src="<?php echo base_url() . '/' . $r->picture; ?>"> <br>
													<a style="margin:5px; font-size:14px;" href="<?php echo base_url() . '/' . $r->picture; ?>" download>Download Image</a>
												<?php elseif ($file_extension === 'pdf') : ?>
													<br>
													<embed src="<?php echo base_url() . '/' . $r->picture; ?>" type="application/pdf" width="200" height="200" /><br>
													<a style="margin:5px; font-size:14px;" href="<?php echo base_url() . '/' . $r->picture; ?>" download>Download Pdf</a>
												<?php elseif (in_array($file_extension, ['xls', 'xlsx'])) : ?>
													<!-- Display Excel file content here -->
													<!-- Example: You can provide a link to download the Excel file -->
													<br>
													<a style="font-size:14px;" href="<?php echo base_url() . '/' . $r->picture; ?>" download>Download Excel File</a>
												<?php endif; ?>
											<?php else : ?>
												<!-- Handle other file types here -->
												File type not supported.
											<?php endif; ?>
										<?php endif; ?>
									</p>

								<?php } ?>



							</div>
						</a>

						<?php //	} 
						?>
					<?php	} ?>

				<?php } ?>

				<?php if ($nodata == true) { ?>
					<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('adf','adf_ticket_is_open'); ?></h3>
				<?php  }
				?>

			</div>
		</div>
	</div>
</div>


<!-- /.row -->
