<div class="col-lg-12">

	<!-- Total Product Sales area -->

	<div class="panel panel-default">


		<div class="panel-heading">
			<?php if ($this->session->userdata('isLogIn') == false) { ?>
				<h3><?php echo lang_loader('inc', 'inc_incident_thread'); ?></h3>
			<?php } else { ?>
				<h3>Incident Timeline & History</h3>
			<?php } ?>
		</div>
		<div class="panel-body" style="    height: auto;     overflow: auto;">
			<?php
			$nodata = true;
			?>
			<div class="timeline">
				<?php foreach ($department->replymessage as $index => $r):
					// echo '<pre>';
					// print_r($department->status);exit;
					$tick_status = $department->status;
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

								<!-- <a onclick="selectAndScroll()">Edit</a> -->
								<?php if ($r->ticket_status != 'Assigned'): ?>
									<?php if ($r->ticket_status != 'Re-assigned'): ?>
										<p><strong>Action:</strong> <?php echo $r->action; ?></p>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ($r->process_monitor_note) { ?>
									<p><strong>Notes : </strong> <?php echo $r->process_monitor_note; ?></p>
								<?php } ?>






								<?php if ($r->ticket_status == 'Transfered'): ?>
									<p><strong>Action:</strong> <?php echo $r->action; ?><strong> (Team Leader)</strong></p>
									<p><strong>Transferred by:</strong> <?php echo $r->message; ?></p>
									<p style="overflow: clip; word-break: break-all;font-size: 14px;">
										<strong>Comment:</strong> <?php echo $r->reply; ?>
									</p>
								<?php endif; ?>

								<?php if ($r->ticket_status == 'Assigned'): ?>
									<?php
									if (
										ismodule_active('INCIDENT') === true &&
										isfeature_active('IN-EDIT-USERS-INCIDENTS') === true &&
										$tick_status != 'Closed'
									) {
										?>
										<!-- Edit/Save buttons -->
										<div class="text-end mb-2">
											<button type="button" class="btn btn-sm btn-outline-primary"
												onclick="selectAndScroll()">
												<i class="fa fa-edit"></i> Edit User
											</button>
										</div>

										<?php
									}
									?>
									<p><strong>Action:</strong> <?php echo $r->action; ?><strong>(Team Leader)</strong></p>

									<p><strong>Process Monitor:</strong> <?php echo $r->action_for_process_monitor; ?></p>
									<p><strong>Assigned by:</strong> <?php echo $r->message; ?></p>
									<p>
										<strong>TAT due date:</strong>
										<?php
										if (!empty($r->assign_tat_due_date)) {
											echo date('d M, Y - g:i A', strtotime($r->assign_tat_due_date));
										} else {
											echo 'N/A';
										}
										?>
									</p>
								<?php endif; ?>

								<?php if ($r->ticket_status == 'Re-assigned'): ?>
									<p><strong>Action:</strong> <?php echo $r->action; ?><strong>(Team Leader)</strong></p>
									<p><strong>Process Monitor:</strong> <?php echo $r->reassign_action_for_process_monitor; ?>
									</p>
									<p><strong>Re-assigned by:</strong> <?php echo $r->message; ?></p>
									<p>
										<strong>TAT due date:</strong>
										<?php
										if (!empty($r->assign_tat_due_date)) {
											echo date('d M, Y - g:i A', strtotime($r->assign_tat_due_date));
										} else {
											echo 'N/A';
										}
										?>
									</p>

								<?php endif; ?>
								<?php if ($r->ticket_status == 'Described') { ?>
									<?php
									if (
										ismodule_active('INCIDENT') === true &&
										isfeature_active('IN-EDIT-RCA-INCIDENTS') === true &&
										$tick_status != 'Closed'
									) {
										?>
										<!-- Edit/Save buttons -->
										<div class="text-end mb-2 action-buttons-<?php echo $r->id; ?>">
											<button type="button" class="btn btn-sm btn-outline-primary edit-btn"
												data-id="<?php echo $r->id; ?>">
												<i class="fa fa-edit"></i> Edit RCA / CAPA
											</button>
											<button type="button" class="btn btn-sm btn-success save-btn"
												data-id="<?php echo $r->id; ?>" style="display:none;">
												<i class="fa fa-save"></i> Save
											</button>
										</div>
										<?php
									}
									?>



									<div class="card shadow-sm mb-3">
										<?php if ($r->rca_tool_describe) { ?>
											<div><strong>Root Cause Analysis (RCA)</strong></div>
										<?php } ?>

										<!-- Editable wrapper -->
										<div class="editable-section" id="editable-<?php echo $r->id; ?>">
											<div class="card-body" style="font-size: 14px; line-height:1.6;">

												<?php if ($r->rootcause_describe_brief) { ?>
													<p><b>RCA in brief:</b> <?php echo $r->rootcause_describe_brief; ?></p>
												<?php } ?>
												<?php if ($r->rootcause_describe) { ?>
													<p><b>RCA :</b> <?php echo $r->rootcause_describe; ?></p>
												<?php } ?>

												<?php if ($r->rca_tool_describe) { ?>
													<p><b>Tool Applied:</b> <?php echo $r->rca_tool_describe; ?></p>
												<?php } ?>

												<?php if ($r->rca_tool_describe == '5WHY') { ?>
													<ul class="list-unstyled">
														<li><b>WHY 1:</b> <?php echo $r->fivewhy_1_describe; ?></li>
														<li><b>WHY 2:</b> <?php echo $r->fivewhy_2_describe; ?></li>
														<li><b>WHY 3:</b> <?php echo $r->fivewhy_3_describe; ?></li>
														<li><b>WHY 4:</b> <?php echo $r->fivewhy_4_describe; ?></li>
														<li><b>WHY 5:</b> <?php echo $r->fivewhy_5_describe; ?></li>
													</ul>
												<?php } ?>

												<?php if ($r->rca_tool_describe == '5W2H') { ?>
													<dl>
														<?php if ($r->fivewhy2h_1_describe) { ?>
															<dt>What happened?</dt>
															<dd><?php echo $r->fivewhy2h_1_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_2_describe) { ?>
															<dt>Why did it happen?</dt>
															<dd><?php echo $r->fivewhy2h_2_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_3_describe) { ?>
															<dt>Where did it happen?</dt>
															<dd><?php echo $r->fivewhy2h_3_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_4_describe) { ?>
															<dt>When did it happen?</dt>
															<dd><?php echo $r->fivewhy2h_4_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_5_describe) { ?>
															<dt>Who was involved?</dt>
															<dd><?php echo $r->fivewhy2h_5_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_6_describe) { ?>
															<dt>How did it happen?</dt>
															<dd><?php echo $r->fivewhy2h_6_describe; ?></dd>
														<?php } ?>
														<?php if ($r->fivewhy2h_7_describe) { ?>
															<dt>How much/How many (impact/cost)?</dt>
															<dd><?php echo $r->fivewhy2h_7_describe; ?></dd>
														<?php } ?>
													</dl>
												<?php } ?>

												<?php if ($r->corrective_describe) { ?>
													<p><b>Corrective Action:</b> <?php echo $r->corrective_describe; ?></p>
												<?php } ?>

												<?php if ($r->preventive_describe) { ?>
													<p><b>Preventive Action:</b> <?php echo $r->preventive_describe; ?></p>
												<?php } ?>

												<?php if ($r->verification_comment_describe) { ?>
													<p><b>Lesson Learned :</b> <?php echo $r->verification_comment_describe; ?></p>
												<?php } ?>
												<?php if (!empty($r->describe_picture)): ?>
													<?php
													// Handle both old single file string and new JSON array
													$files = json_decode($r->describe_picture, true);
													if (!is_array($files)) {
														$files = [$r->describe_picture];
													}

													foreach ($files as $file):
														$file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
														$file_url = base_url('assets/images/describeimage/' . $file);
														?>
														<div class="mt-3">
															<b>Attached File:</b><br>

															<?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
																<img class="img-thumbnail mt-2" style="max-width:150px;"
																	src="<?php echo $file_url; ?>">
																<br>
																<a class="btn btn-sm btn-outline-primary mt-2"
																	href="<?php echo $file_url; ?>" download>Download Image</a>

															<?php elseif ($file_extension === 'pdf'): ?>
																<embed src="<?php echo $file_url; ?>" type="application/pdf" width="250"
																	height="200" class="mt-2">
																<br>
																<a class="btn btn-sm btn-outline-danger mt-2"
																	href="<?php echo $file_url; ?>" download>Download PDF</a>

															<?php elseif (in_array($file_extension, ['xls', 'xlsx', 'csv'])): ?>
																<a class="btn btn-sm btn-outline-success mt-2"
																	href="<?php echo $file_url; ?>" download>
																	Download <?php echo strtoupper($file_extension); ?> File
																</a>

															<?php elseif (in_array($file_extension, ['doc', 'docx'])): ?>
																<a class="btn btn-sm btn-outline-info mt-2" href="<?php echo $file_url; ?>"
																	download>
																	Download Word Document
																</a>

															<?php elseif (in_array($file_extension, ['zip', 'rar'])): ?>
																<a class="btn btn-sm btn-outline-secondary mt-2"
																	href="<?php echo $file_url; ?>" download>
																	Download Compressed File
																</a>

															<?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov', 'm4a', 'wav', 'wma'])): ?>
																<a class="btn btn-sm btn-outline-dark mt-2" href="<?php echo $file_url; ?>"
																	download>
																	Download Media File
																</a>

															<?php else: ?>
																<a class="btn btn-sm btn-outline-primary mt-2"
																	href="<?php echo $file_url; ?>" download>
																	Download File
																</a>
															<?php endif; ?>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>


											</div>
										</div>
									</div>
								<?php } ?>

								<script>
									$(document).ready(function () {

										// 🟩 EDIT button click
										$(document).off('click', '.edit-btn').on('click', '.edit-btn', function (e) {
											e.preventDefault();

											var id = $(this).data('id');
											var section = $('#editable-' + id);

											// Convert <p>/<li>/<dd> into editable inputs
											section.find('p, li, dd').each(function () {
												var $this = $(this);
												var label = '';
												var value = '';

												var $bold = $this.find('b, strong').first();
												if ($bold.length) {
													label = $.trim($bold.text().replace(':', ''));
													var html = $this.html();
													var parts = html.split('</b>');
													if (parts.length > 1) {
														value = parts[1].replace(/[:]/g, '')
															.replace(/<\/?[^>]+(>|$)/g, '')
															.replace(/&nbsp;/g, ' ')
															.trim();
													}
												} else if ($this.is('dd')) {
													var dt = $this.prev('dt').text().trim();
													label = dt.replace(/\?/, '').trim();
													value = $this.text().trim();
												}

												if (!label) return;

												var labelKey = label.replace(/[^a-zA-Z0-9]+/g, '_')
													.replace(/_+/g, '_')
													.replace(/^_+|_+$/g, '')
													.toLowerCase();

												if (label.toLowerCase() === 'tool applied') {
													$this.html('<b>' + label + ':</b> ' + value +
														'<input type="hidden" class="editable-input" name="' + labelKey + '" value="' + value + '">');
													return;
												}

												var inputEl = (value.length > 80)
													? $('<textarea class="form-control form-control-sm editable-input" rows="2"></textarea>').val(value).attr('name', labelKey)
													: $('<input type="text" class="form-control form-control-sm editable-input">').val(value).attr('name', labelKey);

												if ($bold.length) {
													$this.html($bold.prop('outerHTML') + ': ').append(inputEl);
												} else if ($this.is('dd')) {
													$this.html(inputEl);
												}
											});

											// Toggle buttons
											$(".action-buttons-" + id + " .edit-btn").hide();
											$(".action-buttons-" + id + " .save-btn").show();

											// 🟦 Add file upload section (multiple)
											var fileSection = `
			<div class="file-upload-section mt-3" id="file-section-${id}">
				<hr>
				<label><b>Attached Files:</b></label>
				<div class="current-files mt-2"></div>
				<div class="new-files mt-2">
					<input type="file" name="describe_picture[]" class="form-control form-control-sm upload-input mb-2" accept="*/*" multiple>
				</div>
			</div>`;
											if ($('#file-section-' + id).length === 0) {
												section.append(fileSection);
											}

											// 🟨 Load existing files
											var existingFiles = <?php echo json_encode(!empty($r->describe_picture) ? explode(',', $r->describe_picture) : []); ?>;
											if (existingFiles.length > 0) {
												var html = '';
												existingFiles.forEach(function (file) {
													var fileUrl = "<?php echo base_url('assets/images/describeimage/'); ?>" + file.trim();
													var ext = file.split('.').pop().toLowerCase();
													var preview = '';

													if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
														preview = `<img src="${fileUrl}" class="img-thumbnail" style="max-width:120px;">`;
													} else if (ext === 'pdf') {
														preview = `<embed src="${fileUrl}" width="120" height="100">`;
													} else {
														preview = `<a href="${fileUrl}" target="_blank">${file}</a>`;
													}
													html += `<div class="file-item mt-2">${preview}
					<button type="button" class="btn btn-sm btn-danger ms-2 remove-old-file" data-file="${file}">Remove</button></div>`;
												});
												$('#file-section-' + id + ' .current-files').html(html);
											}
										});

										// 🟥 Remove existing file
										$(document).off('click', '.remove-old-file').on('click', '.remove-old-file', function () {
											var fileName = $(this).data('file');
											var container = $(this).closest('.file-item');
											container.remove();
											var hidden = $('<input type="hidden" name="remove_files[]">').val(fileName);
											$('#file-section-' + $(this).closest('.file-upload-section').attr('id').split('-')[2]).append(hidden);
										});

										// 🟨 SAVE button
										$(document).off('click', '.save-btn').on('click', '.save-btn', function (e) {
											e.preventDefault();
											e.stopImmediatePropagation();

											var id = $(this).data('id');
											var section = $('#editable-' + id);

											// 🟡 Validate mandatory fields before saving
											var isEmpty = false;
											section.find('.editable-input').each(function () {
												if ($(this).val().trim() === '') {
													isEmpty = true;
													$(this).addClass('is-invalid'); // optional red highlight
												} else {
													$(this).removeClass('is-invalid');
												}
											});
											if (isEmpty) {
												alert('⚠️ Please fill all mandatory fields before saving.');
												return;
											}

											if (!confirm("Are you sure you want to save these changes?")) return;


											var id = $(this).data('id');
											var section = $('#editable-' + id);
											var formData = new FormData();
											formData.append('id', id);

											section.find('.editable-input').each(function () {
												formData.append($(this).attr('name'), $(this).val());
											});

											// Collect new files
											var fileInput = section.find('input[type="file"][name="describe_picture[]"]')[0];
											if (fileInput && fileInput.files.length > 0) {
												for (var i = 0; i < fileInput.files.length; i++) {
													formData.append('describe_picture[]', fileInput.files[i]);
												}
											}

											// Removed files
											section.find('input[name="remove_files[]"]').each(function () {
												formData.append('remove_files[]', $(this).val());
											});

											formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

											var saveBtn = $(".action-buttons-" + id + " .save-btn");
											saveBtn.prop('disabled', true).text('Saving...');

											$.ajax({
												url: "<?php echo base_url('ticketsincident/update_described_rca'); ?>",
												type: "POST",
												data: formData,
												contentType: false,
												processData: false,
												success: function (responseText) {
													saveBtn.prop('disabled', false).text('Save');
													try {
														var response = JSON.parse(responseText.trim());
														if (response.status === 'success') {
															alert('✅ RCA updated successfully!');
															setTimeout(() => location.reload(), 500);
														} else {
															alert('⚠️ Update failed.');
														}
													} catch {
														alert('✅ RCA updated successfully!');
														setTimeout(() => location.reload(), 500);
													}
												},
												error: function (xhr, status, error) {
													saveBtn.prop('disabled', false).text('Save');
													console.error('❌ AJAX Error:', status, error);
													alert('⚠️ Error saving data.');
												}
											});
										});
									});
								</script>





								<style>
									.editable-input {
										margin: 3px 0;
									}

									.text-end {
										text-align: right;
									}
								</style>



								<?php if ($r->reply && $r->ticket_status != 'Described' && $r->ticket_status != 'Transfered') { ?>
									<p class="inbox-item-text" style="overflow: clip; word-break: break-all;font-size: 14px;">
										<b><?php echo lang_loader('inc', 'inc_comment'); ?></b>:
										<?php echo $r->reply; ?>
									</p>
								<?php } ?>
								<div class="card shadow-sm mb-3">
									<?php if ($r->ticket_status == 'Closed') { ?>
										<?php
										if (
											ismodule_active('INCIDENT') === true &&
											isfeature_active('IN-EDIT-CLOSED-INCIDENTS') === true
										) {
											?>
											<!-- Edit/Save buttons for Closed -->
											<div class="text-end mb-2 action-buttons-<?php echo $r->id; ?>">
												<button type="button" class="btn btn-sm btn-outline-primary edit-closed-btn"
													data-id="<?php echo $r->id; ?>">
													<i class="fa fa-edit"></i> Edit Closure Remarks
												</button>
												<button type="button" class="btn btn-sm btn-success save-closed-btn"
													data-id="<?php echo $r->id; ?>" style="display:none;">
													<i class="fa fa-save"></i> Save
												</button>
											</div>
											<?php
										}
										?>
									<?php } ?>
									<?php if ($r->rca_tool) { ?>
										<div><strong>Root Cause Analysis (RCA) for Incident</strong></div>
									<?php } ?>

									<!-- Editable Wrapper -->
									<div class="editable-closed" id="closed-<?php echo $r->id; ?>">
										<div class="card-body" style="font-size:14px; line-height:1.6;">

											<?php if ($r->rca_tool) { ?>
												<p><b>Tool Applied:</b> <?php echo $r->rca_tool; ?></p>
											<?php } ?>

											<?php if ($r->rca_tool == 'DEFAULT') { ?>
												<p><b>RCA:</b> <?php echo $r->rootcause; ?></p>
											<?php } ?>


											<?php if ($r->rca_tool == '5WHY') { ?>
												<ul class="list-unstyled">
													<li><b>WHY 1:</b> <?php echo $r->fivewhy_1; ?></li>
													<li><b>WHY 2:</b> <?php echo $r->fivewhy_2; ?></li>
													<li><b>WHY 3:</b> <?php echo $r->fivewhy_3; ?></li>
													<li><b>WHY 4:</b> <?php echo $r->fivewhy_4; ?></li>
													<li><b>WHY 5:</b> <?php echo $r->fivewhy_5; ?></li>
												</ul>
											<?php } ?>

											<?php if ($r->rca_tool == '5W2H') { ?>
												<dl>
													<?php if ($r->fivewhy2h_1) { ?>
														<dt>What happened?</dt>
														<dd><?php echo $r->fivewhy2h_1; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_2) { ?>
														<dt>Why did it happen?</dt>
														<dd><?php echo $r->fivewhy2h_2; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_3) { ?>
														<dt>Where did it happen?</dt>
														<dd><?php echo $r->fivewhy2h_3; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_4) { ?>
														<dt>When did it happen?</dt>
														<dd><?php echo $r->fivewhy2h_4; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_5) { ?>
														<dt>Who was involved?</dt>
														<dd><?php echo $r->fivewhy2h_5; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_6) { ?>
														<dt>How did it happen?</dt>
														<dd><?php echo $r->fivewhy2h_6; ?></dd><?php } ?>
													<?php if ($r->fivewhy2h_7) { ?>
														<dt>How much/How many (impact/cost)?</dt>
														<dd><?php echo $r->fivewhy2h_7; ?></dd><?php } ?>
												</dl>
											<?php } ?>

											<?php if ($r->corrective) { ?>
												<p><b>Closure Corrective Action:</b> <?php echo $r->corrective; ?></p>
											<?php } ?>

											<?php if ($r->preventive) { ?>
												<p><b>Closure Preventive Action:</b> <?php echo $r->preventive; ?></p>
											<?php } ?>

											<?php if ($r->verification_comment) { ?>
												<p><b>Closure Verification Remark:</b> <?php echo $r->verification_comment; ?>
												</p>
											<?php } ?>

											<?php if (!empty($r->picture)): ?>
												<?php
												$files = json_decode($r->picture, true);
												if (!empty($files)):
													foreach ($files as $file):
														$file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
														$file_url = base_url('assets/images/capaimage/' . $file);
														?>
														<div class="mt-3">
															<b>Attached File:</b><br>

															<?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
																<img class="img-thumbnail mt-2" style="max-width:150px;"
																	src="<?php echo $file_url; ?>">
																<br>
																<a class="btn btn-sm btn-outline-primary mt-2"
																	href="<?php echo $file_url; ?>" download>Download Image</a>

															<?php elseif ($file_extension === 'pdf'): ?>
																<embed src="<?php echo $file_url; ?>" type="application/pdf" width="250"
																	height="200" class="mt-2">
																<br>
																<a class="btn btn-sm btn-outline-danger mt-2"
																	href="<?php echo $file_url; ?>" download>Download PDF</a>

															<?php elseif (in_array($file_extension, ['xls', 'xlsx', 'csv'])): ?>
																<a class="btn btn-sm btn-outline-success mt-2"
																	href="<?php echo $file_url; ?>" download>Download
																	<?php echo strtoupper($file_extension); ?> File</a>

															<?php elseif (in_array($file_extension, ['doc', 'docx'])): ?>
																<a class="btn btn-sm btn-outline-info mt-2" href="<?php echo $file_url; ?>"
																	download>Download Word Document</a>

															<?php elseif (in_array($file_extension, ['zip', 'rar'])): ?>
																<a class="btn btn-sm btn-outline-secondary mt-2"
																	href="<?php echo $file_url; ?>" download>Download Compressed File</a>

															<?php elseif (in_array($file_extension, ['mp4', 'avi', 'mov', 'm4a', 'wav', 'wma'])): ?>
																<a class="btn btn-sm btn-outline-dark mt-2" href="<?php echo $file_url; ?>"
																	download>Download Media File</a>

															<?php else: ?>
																<a class="btn btn-sm btn-outline-primary mt-2"
																	href="<?php echo $file_url; ?>" download>Download File</a>
															<?php endif; ?>
														</div>
													<?php endforeach; endif; ?>
											<?php endif; ?>


										</div>
									</div>
								</div>

								<script>
									$(document).ready(function () {

										// 🟩 EDIT BUTTON CLICK
										$(document).off('click', '.edit-closed-btn').on('click', '.edit-closed-btn', function (e) {
											e.preventDefault();
											var id = $(this).data('id');
											var section = $('#closed-' + id);

											// Make text fields editable
											section.find('p, li, dd').each(function () {
												var $this = $(this);
												var label = '';
												var value = '';
												var $bold = $this.find('b, strong').first();

												if ($bold.length) {
													label = $.trim($bold.text().replace(':', ''));
													var html = $this.html();
													var parts = html.split('</b>');
													if (parts.length > 1) {
														value = parts[1].replace(/<\/?[^>]+(>|$)/g, '').trim();
													}
												} else if ($this.is('dd')) {
													label = $this.prev('dt').text().trim();
													value = $this.text().trim();
												}
												if (!label) return;

												const fieldMap = {
													'Tool Applied': 'tool_applied',
													'RCA': 'rca',
													'WHY 1': 'why_1',
													'WHY 2': 'why_2',
													'WHY 3': 'why_3',
													'WHY 4': 'why_4',
													'WHY 5': 'why_5',
													'What happened?': 'what_happened',
													'Why did it happen?': 'why_did_it_happen',
													'Where did it happen?': 'where_did_it_happen',
													'When did it happen?': 'when_did_it_happen',
													'Who was involved?': 'who_was_involved',
													'How did it happen?': 'how_did_it_happen',
													'How much/How many (impact/cost)?': 'how_much_how_many_impact_cost',
													'Closure Corrective Action': 'closure_corrective_action',
													'Closure Preventive Action': 'closure_preventive_action',
													'Closure Verification Remark': 'closure_verification_remark'
												};

												var labelKey = fieldMap[label] || label.replace(/[^a-zA-Z0-9]+/g, '_').toLowerCase();

												if (label.toLowerCase() === 'tool applied') {
													$this.html('<b>' + label + ':</b> <span class="text-muted">' + value + '</span>' +
														'<input type="hidden" class="editable-input" name="tool_applied" value="' + value + '">');
													return;
												}

												var input = (value.length > 80)
													? $('<textarea class="form-control form-control-sm editable-input" rows="2"></textarea>')
														.val(value).attr('name', labelKey)
													: $('<input type="text" class="form-control form-control-sm editable-input">')
														.val(value).attr('name', labelKey);

												if ($bold.length) { $this.html($bold.prop('outerHTML') + ': ').append(input); }
												else if ($this.is('dd')) { $this.html(input); }
											});

											// 🟩 MULTIPLE FILE UPLOAD SECTION
											var fileSection = `
			<div class="file-upload-section mt-3" id="file-section-${id}">
				<hr>
				<label><b>Attached Files:</b></label>
				<div class="current-files mt-2"></div>
				<div class="new-files mt-2">
					<div class="file-input-wrapper mb-2">
						<input type="file" name="pictures[]" class="form-control form-control-sm" multiple>
					</div>
					<button type="button" class="btn btn-sm btn-outline-primary add-more-files mt-2">
						<i class="fa fa-plus"></i> Add More Files
					</button>
				</div>
			</div>`;
											if ($('#file-section-' + id).length === 0) section.append(fileSection);

											// 🟦 Load existing files from data attribute
											var existingFiles = section.data('pictures') || [];
											var baseUrl = "<?php echo base_url('assets/images/capaimage/'); ?>";
											var previewHTML = '';

											existingFiles.forEach(function (file) {
												var fileUrl = baseUrl + file;
												var ext = file.split('.').pop().toLowerCase();
												var filePreview = '';

												if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
													filePreview = `<img src="${fileUrl}" class="img-thumbnail" style="max-width:120px;">`;
												} else if (ext === 'pdf') {
													filePreview = `<embed src="${fileUrl}" width="150" height="120">`;
												} else {
													filePreview = `<a href="${fileUrl}" target="_blank">${file}</a>`;
												}

												previewHTML += `
				<div class="existing-file mt-2 d-flex align-items-center gap-2">
					${filePreview}
					<button type="button" class="btn btn-sm btn-danger remove-old-file" data-file="${file}">
						<i class="fa fa-trash"></i> Remove
					</button>
				</div>`;
											});
											$('#file-section-' + id + ' .current-files').html(previewHTML);

											$(".action-buttons-" + id + " .edit-closed-btn").hide();
											$(".action-buttons-" + id + " .save-closed-btn").show();
										});

										// 🟦 ADD MORE FILE INPUT
										$(document).off('click', '.add-more-files').on('click', '.add-more-files', function () {
											var newInput = `
			<div class="file-input-wrapper mb-2">
				<input type="file" name="pictures[]" class="form-control form-control-sm" multiple>
				<button type="button" class="btn btn-sm btn-danger remove-new-file mt-1">Remove</button>
			</div>`;
											$(this).before(newInput);
										});

										// 🟥 REMOVE NEW FILE INPUT
										$(document).off('click', '.remove-new-file').on('click', '.remove-new-file', function () {
											$(this).closest('.file-input-wrapper').remove();
										});

										// 🟥 REMOVE EXISTING OLD FILE
										$(document).off('click', '.remove-old-file').on('click', '.remove-old-file', function () {
											var fileName = $(this).data('file');
											var parent = $(this).closest('.file-upload-section');
											$(this).closest('.existing-file').remove();

											// Add hidden input to mark for deletion
											var hidden = `<input type="hidden" name="remove_files[]" value="${fileName}">`;
											parent.append(hidden);
										});

										// 🟦 SAVE CHANGES
										$(document).off('click', '.save-closed-btn').on('click', '.save-closed-btn', function (e) {
											e.preventDefault();

											var id = $(this).data('id');
											var section = $('#closed-' + id);

											// ✅ MANDATORY FIELD VALIDATION (added)
											var isEmpty = false;
											section.find('.editable-input').each(function () {
												if ($(this).val().trim() === '') {
													isEmpty = true;
													$(this).addClass('is-invalid');
												} else {
													$(this).removeClass('is-invalid');
												}
											});
											if (isEmpty) {
												alert('⚠️ Please fill all mandatory fields before saving.');
												return;
											}

											if (!confirm("Save Closed RCA changes?")) return;

											var id = $(this).data('id');
											var section = $('#closed-' + id);
											var formData = new FormData();
											formData.append('id', id);

											section.find('.editable-input').each(function () {
												formData.append($(this).attr('name'), $(this).val());
											});

											// ✅ Add all file inputs
											section.find('input[type="file"][name="pictures[]"]').each(function () {
												if (this.files && this.files.length > 0) {
													for (let i = 0; i < this.files.length; i++) {
														formData.append('pictures[]', this.files[i]);
													}
												}
											});

											// ✅ Add removal list
											section.find('input[name="remove_files[]"]').each(function () {
												formData.append('remove_files[]', $(this).val());
											});

											// ✅ Add CSRF token
											formData.append('<?php echo $this->security->get_csrf_token_name(); ?>',
												'<?php echo $this->security->get_csrf_hash(); ?>');

											$.ajax({
												url: "<?php echo base_url('ticketsincident/update_closed_rca'); ?>",
												type: "POST",
												data: formData,
												contentType: false,
												processData: false,
												success: function (res) {
													try {
														var data = JSON.parse(res);
														alert(data.message);
														if (data.status === 'success') location.reload();
													} catch {
														alert('✅ Saved successfully!');
														location.reload();
													}
												},
												error: function (xhr) {
													alert('❌ Error saving. Check console.');
													console.log(xhr.responseText);
												}
											});
										});
									});
								</script>






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
<script>
	function selectAndScroll() {

		// Select "Re-assigned" option and trigger change
		$('#changeAction').val('reassign').trigger('change');

		// Scroll to element only if it exists
		var $target = $('#changeAction'); // replace with your actual ID
		if ($target.length) {
			$('html, body').animate({
				scrollTop: $target.offset().top
			}, 800); // smooth scroll
		} else {
			console.warn('Target element not found:', '#targetElementId');
		}
	}


</script>


<!-- /.row -->