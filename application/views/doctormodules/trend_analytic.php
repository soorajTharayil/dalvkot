<?php

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


/* START TABLES FROM DATABASE */
$table_feedback = 'bf_feedback_doctors';
$table_patients = 'bf_opatients';
$sorttime = 'asc';
$setup = 'setup_doctor';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_doctor';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_doctor_message';
$type = 'doctor';
$department = 'department';
$reopen = 'Reopen';
/* END TABLES FROM DATABASE */

$type = $this->uri->segment(3);
$query = $this->db->select('title,shortname,id,shortkey')
    ->from('setup_doctor')
    ->where('type', $type)
    ->get();
$result = $query->result();
$alltickets = $this->ticketsdoctor_model->alltickets();
// For count of total feedbacks and for charts only.
// $ip_feedbacks_count = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// $ip_feedback = [];
// // Iterate over all tickets
// foreach ($ip_feedbacks_count as $feedback_count) {
//     // Decode the JSON `dataset` into a PHP array
//     $dataset = json_decode($feedback_count->dataset, true);

// // echo '<pre>';
// // print_r($dataset); 
//     // Check if the type exists within the `reasonSet` array
//     if (isset($dataset['reasonSet'][$type])) {
//         // Add to the result array
//         $ip_feedback[$feedback_count->id] = $feedback_count;
//     }
// }
$allFeedback = $this->efeedor_model->get_feedback('bf_opatients', 'bf_feedback_doctors', $fdate, $tdate);
$setup = $this->efeedor_model->setup_result('setup_doctor');
// Call model to pull data based on the passed parameter
$data = $this->Trend_analytic_model->get_response_count($type, $allFeedback, $setup);
// Assuming $data is the array you posted
$feedback_total_count = array_sum($data['value']);

// echo "Total count: " . $feedback_total_count; // Output: Total count: 11
// echo '<pre>';
// print_r($ip_feedback); exit;
$query = $this->db->select('dprt_id,name,slug')
    ->from('department')
    ->where('setkey', $type)
    ->where('type', 'doctor')
    ->get();
$departmentList = $query->result();

$title_category = $result[0]->title;
$welcometext = "This page offers a centralized view of key metrics, trends, and breakdowns within the <strong>" . $title_category . "</strong> category, enabling in-depth analysis and easy identification of areas for improvement.";
// Initialize the arrays
$parameterList = [];
$parameterTicketCount = [];

$ip_ticket = [];
$ip_open_ticket = [];
$ip_closed_ticket = [];

foreach ($departmentList as $key => $row) {
    // Store the shortname
    $parameterList[$key] = $row->name;

    // Initialize the ticket count
    $parameterTicketCount[$key] = 0;

    // Iterate over all tickets
    foreach ($alltickets as $ticket) {
        // Check if department IDs match
        if ($type == $ticket->department->setkey) {
            $ip_ticket[$ticket->id] = $ticket;

            // Check for reasons in the ticket
            if (isset($ticket->feed->reason) && is_object($ticket->feed->reason)) {
                foreach ($ticket->feed->reason as $p => $r) {
                    // Check if the reason key matches the shortkey
                    if ($p == $row->slug && $r == 1) {
                        $parameterTicketCount[$key]++;
                    }
                }

                // Categorize tickets by status
                if (isset($ticket->status)) {
                    if ($ticket->status === 'Open') {
                        $ip_open_ticket[$ticket->id] = $ticket;
                    } elseif ($ticket->status === 'Closed') {
                        $ip_closed_ticket[$ticket->id] = $ticket;
                    }
                }
            }
        }
    }
}
// echo '<pre>';
// print_r($ip_ticket);
// exit;
$total_tickect_ip = count($ip_ticket);
$total_tickect_closed_ip = count($ip_closed_ticket);
$total_tickect_open_ip = count($ip_open_ticket);

$satisfied_patient = $feedback_total_count - $total_tickect_ip ;

if ($total_tickect_closed_ip > 0 && $total_tickect_ip > 0) {
    $ticket_resolution_rate = round(($total_tickect_closed_ip / $total_tickect_ip) * 100);
} else {
    $ticket_resolution_rate = 0;
}

$total_resolution_time = 0;
$closed_tickets = 0;

foreach ($alltickets as $ticket) {
    if ($ticket->status == 'Closed' && isset($ticket->created_on, $ticket->last_modified)) {
        $closed_tickets++;
        $total_resolution_time += strtotime($ticket->last_modified) - strtotime($ticket->created_on);
    }
}

if ($closed_tickets > 0 && $total_resolution_time > 0) {
    $average_resolution_time = $total_resolution_time / $closed_tickets;
} else {
    $average_resolution_time = 0;
}

$ticket_close_rate = secondsToTime($average_resolution_time);



// Find the key of the maximum value
$maxKey = array_search(max($parameterTicketCount), $parameterTicketCount);

// Filter out 0 values for minimum calculation
$nonZeroCounts = array_filter($parameterTicketCount, function ($value) {
    return $value > 0; // Keep only values greater than 0
});

// Find the key of the minimum non-zero value
$minKey = array_search(min($nonZeroCounts), $parameterTicketCount);



?>

<div class="content">

    <div class="col-lg-12" style="margin-bottom: 30px;">
        <div style="margin-bottom: 15px; margin-top: 10px; ">

            <h4 style="font-size:18px;font-weight:normal; margin-top: 0px;">
                <span class="typing-text"></span>
            </h4>
            <!-- &nbsp;&nbsp;&nbsp;&nbsp;<span class="typing-text"></span> </h4> -->
        </div>
    </div>



    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo $feedback_total_count; ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"> Total Feedbacks <a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_total_feedback_tooltip'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-comments-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo count($ip_ticket); ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small">Total Tickets <a href="javascript:void()" data-toggle="tooltip" title="Total number of negative feedbacks received by the category for the given period"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-ticket"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_satisfied_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>





    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo $satisfied_patient; ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"> Satisfied Doctor <a href="javascript:void()" data-toggle="tooltip" title="Patients who rated above average and have no negative experiences in your category."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-smile-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo count($ip_ticket); ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"> Unsatisfied Doctor <a href="javascript:void()" data-toggle="tooltip" title="Patients who rated below average and have one or more negative experiences in your category."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-frown-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo $total_tickect_open_ip; ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"> Open Tickets <a href="javascript:void()" data-toggle="tooltip" title="Number of tickets yet to be addressed or closed."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-envelope-open-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo $total_tickect_closed_ip; ?>
                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"> Closed Tickets <a href="javascript:void()" data-toggle="tooltip" title="Number of tickets resolved."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-check-circle-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2><span class="count-number">
                            <?php echo $ticket_resolution_rate; ?>
                        </span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                            </i></span></h2>
                    <div class="small"><?php echo lang_loader('ip', 'ip_ticket_resolution_rate'); ?> <a href="javascript:void()" data-toggle="tooltip" title="Metric used to measure the efficiency and effectiveness of the team to close the negative feedbacks."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                    <i class="fa fa-clock-o"></i>
                    </div>
                    <!-- <a href="<?php echo $ip_link_ticket_resolution_rate; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->

                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 30px;">
        <div class="panel panel-bd">
            <div class="panel-body" style="height: 100px;">
                <div class="statistic-box">
                    <h2>
                        <?php echo $ticket_close_rate; ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
                    </h2>
                    <div class="small"><?php echo lang_loader('ip', 'ip_average_resolution_time'); ?> <a href="javascript:void()" data-toggle="tooltip" title="The average amount of time taken by the team to close the tickets."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
                    <div class="icon">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                </div>
                <!-- <a href="<?php echo $ip_link_average_resolution_time; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_list'); ?></a> -->

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 col-sm-12 col-md-12" style="overflow:auto;margin-bottom: 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Doctor Rating Distribution for <?php echo $result[0]->title; ?>
                        <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip"
                            title="Bar chart displaying the distribution of doctor ratings for this category.">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                    </h3>
                </div>
                <div class="panel-body" style="height:260px;" id="bar">
                    <div class="message_inner bar_chart">
                        <div id="chartLoader" style="display: none; text-align: center;">Loading...</div>
                        <div id="chartContainer" style="margin: 0 auto; max-width: 100%;">
                            <canvas id="feedbackChart" width="700" height="150"></canvas>
                        </div>
                        <!-- Display Answered and Skipped Counts -->
                        <p id="feedbackSummary" style="text-align: center; margin-top: 10px;"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Product Sales area -->
        <div class="col-lg-12 col-sm-12 col-md-12" style="margin-bottom: 30px;">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Feedback Volume for <?php echo $result[0]->title; ?> Over Time <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="A chart showing the number of patient feedback received over time."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body" style="  height:380px;" id="line">
                    <div class="message_inner line_chart">
                        <canvas id="net_permoter_analysis"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-12 col-sm-12 col-md-12" style="margin-bottom: 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Performance Percentage by <?php echo $result[0]->title; ?> Over Time
                        <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="Line chart showing the category's performance score or percentage over time, based on Doctor Ratings.">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                    </h3>
                </div>
                <div class="panel-body" style="height:380px;" id="line">
                    <div class="message_inner line_chart">
                        <canvas id="patient_satisfaction_analysis" style="display: block; height: 250px; width: 100%;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- key takeaways -->

        <?php if (count($ip_ticket) > 5 && $parameterList[$maxKey] !== $parameterList[$minKey]) { ?>
            <!-- Key Highlights -->
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:hidden;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Key Takeaways for <?php echo $result[0]->title; ?> Experience <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="AI-generated recommendations highlighting key insights based on rating scores and negative feedback received for the category."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h4>
                        </div>
                        <div class="p-l-30 p-r-30">
                            <div class="panel-body" style="height: 150px; display:inline;">
                                <div class="alert alert-success">
                                    <span style="font-size: 15px">
                                        <?php echo "<strong>" . $parameterList[$maxKey] . "</strong>"; ?> had the most negative feedback in the <?php echo "<strong>" . $result[0]->title . "</strong>"; ?>

                                    </span>
                                </div>
                                <div class="alert alert-warning ">
                                    <span style="font-size: 15px">
                                        <?php echo "<strong>" . $parameterList[$minKey] . "</strong>"; ?> received the least negative feedback in the <?php echo "<strong>" . $result[0]->title . "</strong>"; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Close Key Highlights -->

        <div class="col-lg-6 col-sm-6 col-md-6" style="margin-bottom: 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Negative Experience Breakdown for <?php echo $result[0]->title; ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="This pie chart illustrates the distribution of negative feedback across different areas within the category, showing the percentage contribution of each parameter to the total."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body " style="height:480px;">
                    <div class="message_inner  center-chart">
                        <canvas id="satisfactionChart_forTicket_piechart" style="width: 600px !important; height: 100% !important;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('ip', 'ip_recent_tickets'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="List of recent tickets during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsdoctor_model->alltickets();
						$ticket_data = $a;
                        $setup = 'setup_doctor';
                        $this->db->select("*");
                        $this->db->from($setup);
                        $this->db->where('parent', 0);
                        $this->db->where('type', $this->uri->segment(3)); // Adding 'type' condition with segment 3
                        
						$query = $this->db->get();
						$reasons  = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->type] = $row->title;
						}


						foreach ($ip_ticket as $ticketdata) {
						?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
										<?php echo 'IPDT-' . $ticketdata->id ?>
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
										<i class="fa fa-ticket"></i> <?php echo lang_loader('ip', 'ip_rated'); ?> <b><?php echo $ticketdata->ratingt; ?></b><?php echo ' for ' ?><b><?php echo $ticketdata->department->description; ?></b>
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
										<?php
										// echo $key33;
										if ($key33) { ?>
											<?php $comm = $value;

											// print_r($dep); 
											?>
											<?php if ($comm) {
												//print_r($dep[$key33]); 
											?>
												<?php if ($dep[$key33] == $ticketdata->department->description) { ?>
													<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">
														<span style="overflow: clip; word-break: break-all;">
															<i class="fa fa-comment-o"></i> <?php echo lang_loader('ip', 'ip_comment'); ?> :
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
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;"><?php echo lang_loader('ip', 'ip_view_all'); ?></a></div>
			</div>

		</div>


        <!-- <div class="col-lg-6 col-sm-12 col-md-12" style="margin-bottom: 30px;">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Negative Feedback Frequency Analysis for <?php echo $result[0]->title; ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $netpromoteranalysis_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body" style="height:380px;" id="line">
                    <div class="message_inner line_chart">
                        <canvas id="satisfactionChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-lg-12 col-sm-12 col-md-12" style="margin-bottom: 30px;">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Trends in Negative Feedback for <?php echo $result[0]->title; ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="Negative feedbacks received for this specific category over the designated period."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body" style="  height:380px;" id="line">
                    <div class="message_inner line_chart">
                        <canvas id="satisfactionChart_forTicket"></canvas>
                    </div>
                </div>
            </div>
        </div>





    </div>
</div>


<!-- Loader for the chart data -->
<div id="chartLoader" style="display:none;">Loading...</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* CSS to center the chart within the panel */
    .center-chart {
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>

<script>
    // Function to load chart data from API
    function loadRelativePerformance() {
        var apiUrl = '<?php echo base_url(); ?>/trend_analytic/parameter_relative_performance/<?php echo $this->uri->segment(3); ?>'; // Replace with dynamic parameter
        document.getElementById('chartLoader').style.display = 'block'; // Show loader

        // Fetch the data from the API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                if (data.status === 'success') {
                    // Parse and use the data to generate the chart
                    var ctx = document.getElementById('patient_satisfaction_analysis').getContext('2d');
                    var feedbackChart = new Chart(ctx, {
                        type: 'bar', // Bar chart
                        data: {
                            labels: data.label, // Customize as needed
                            datasets: [{
                                label: 'Performance Percentage',
                                data: data.data, // Use the data from API response
                                backgroundColor: "rgba(75, 192, 192, 0.7)", // Semi-transparent bar color
                                borderColor: "rgb(75, 192, 192)", // Border color for the bars
                                borderWidth: 1 // Thickness of the bar borders
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    ticks: {
                                        fontSize: 16, // Font size for X-axis labels
                                        fontStyle: 'bold', // Optional: make the font bold
                                        maxRotation: 0,
                                        minRotation: 0
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Week', // X-axis title
                                        fontSize: 16 // Font size for X-axis title
                                    }
                                },
                                y: {
                                    ticks: {
                                        fontSize: 16, // Font size for Y-axis labels
                                        beginAtZero: true,
                                        stepSize: 10, // Adjust step size for the Y-axis
                                        min: 0, // Minimum value for the Y-axis
                                        max: 100, // Maximum value for the Y-axis
                                        callback: function(value) {
                                            return value + '%'; // Format Y-axis labels with percentage
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Satisfaction (%)', // Y-axis title
                                        fontSize: 16 // Font size for Y-axis title
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            // Get the value of the bar
                                            const value = context.raw;
                                            // Return value with % symbol
                                            return `${value}%`;
                                        }
                                    }
                                },
                                legend: {
                                    display: true,
                                    position: 'top' // Position of the legend
                                }
                            }
                        }
                    });
                } else {
                    alert('Error fetching data: ' + data.message);
                }
            })
            .catch(error => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                console.error('Error:', error);
            });
    }

    // Call the function to load the chart data
    loadRelativePerformance();
</script>



<script>
    // Define the parameters and data
    const labels = <?php print(json_encode($parameterList)); ?>;
    const data = <?php print(json_encode($parameterTicketCount)); ?>; // Replace these values with your actual data

    // Calculate the total sum of the data
    const total = data.reduce((sum, value) => sum + value, 0);

    // Modify the labels to include percentages
    const labelsWithPercentages = labels.map((label, index) => {
        const percentage = Math.round((data[index] / total) * 100);
        return `${label} (${percentage}%)`;
    });

    // Initialize the pie chart
    const ctx = document.getElementById('satisfactionChart_forTicket_piechart').getContext('2d');
    const satisfactionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labelsWithPercentages,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ],
                hoverBackgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const dataIndex = tooltipItem.dataIndex; // Index of the hovered slice
                            const count = data[dataIndex]; // Count value of the slice
                            const percentage = Math.round((count / total) * 100); // Calculate rounded percentage
                            const label = labels[dataIndex]; // Get the corresponding label

                            // Customize the tooltip with headings
                            return [
                                `Negative Feedback Percentage: ${percentage}%`,
                                `Negative Feedback Count: ${count}`
                            ];
                        }
                    },
                    displayColors: false // Disable the colored box in the tooltip
                }
            }
        }
    });
</script>





<script>
    // Function to load chart data from API
    function loadChartData() {
        var apiUrl = '<?php echo base_url(); ?>/trend_analytic/feedback_status_count/<?php echo $this->uri->segment(3); ?>'; // Replace with dynamic parameter
        document.getElementById('chartLoader').style.display = 'block'; // Show loader

        // Fetch the data from the API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                if (data.status === 'success') {
                    // Parse and use the data to generate the chart
                    var ctx = document.getElementById('feedbackChart').getContext('2d');
                    var feedbackChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Worst', 'Poor', 'Average', 'Good', 'Excellent'], // Customize as needed
                            datasets: [{
                                label: 'Doctor Ratings',
                                data: data.data, // Use the data from API response
                                backgroundColor: [
                                    'rgba(255, 139, 96, 0.8)', // #FF8B60
                                    'rgba(255, 178, 70, 0.8)', // #FFB246
                                    'rgba(255, 216, 76, 0.8)', // #FFD84C
                                    'rgba(169, 215, 140, 0.8)', // #A9D78C
                                    'rgba(107, 200, 163, 0.8)' // #6BC8A3
                                ],
                                borderColor: [
                                    'rgba(255, 139, 96, 1)', // #FF8B60
                                    'rgba(255, 178, 70, 1)', // #FFB246
                                    'rgba(255, 216, 76, 1)', // #FFD84C
                                    'rgba(169, 215, 140, 1)', // #A9D78C
                                    'rgba(107, 200, 163, 1)' // #6BC8A3
                                ],


                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else {
                    //alert('Error fetching data: ' + data.message);
                }
            })
            .catch(error => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                console.error('Error:', error);
            });
    }

    // Call the function to load the chart data
    loadChartData();
</script>


<script>
    // Function to load chart data from API
    function loadResponseCount() {
        var apiUrl = '<?php echo base_url(); ?>/trend_analytic/get_response_count/<?php echo $this->uri->segment(3); ?>'; // Replace with dynamic parameter
        document.getElementById('chartLoader').style.display = 'block'; // Show loader

        // Fetch the data from the API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                if (data.status === 'success') {
                    // Parse and use the data to generate the chart
                    var ctx = document.getElementById('net_permoter_analysis').getContext('2d');
                    var feedbackChart = new Chart(ctx, {
                        type: 'line', // Changed to 'line' chart
                        data: {
                            labels: data.label, // Customize as needed
                            datasets: [{
                                label: 'No. of Feedbacks',
                                data: data.data, // Use the data from API response
                                fill: false, // No fill under the line
                                borderColor: "rgb(75, 192, 192)", // Line color
                                backgroundColor: "rgb(75, 192, 192)", // Point color
                                tension: 0.1, // Curve smoothing
                                pointStyle: 'circle', // Point style
                                pointRadius: 5, // Point size
                                borderWidth: 2 // Line thickness
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    ticks: {
                                        fontSize: 16, // Font size for X-axis labels
                                        fontStyle: 'bold', // Optional: make the font bold
                                        maxRotation: 0,
                                        minRotation: 0
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Week', // X-axis title
                                        fontSize: 16 // Font size for X-axis title
                                    }
                                },
                                y: {
                                    ticks: {
                                        fontSize: 16, // Font size for Y-axis labels
                                        beginAtZero: true,
                                        stepSize: 10, // Adjust step size for the Y-axis
                                        min: 0, // Minimum value for the Y-axis
                                        max: 100, // Maximum value for the Y-axis
                                        callback: function(value) {
                                            return value + '%'; // Optional: format Y-axis labels with percentage
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Satisfaction (%)', // Y-axis title
                                        fontSize: 16 // Font size for Y-axis title
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top' // Position of the legend
                                }
                            }
                        }
                    });
                } else {
                    // alert('Error fetching data: ' + data.message);
                }
            })
            .catch(error => {
                document.getElementById('net_permoter_analysis').style.display = 'none'; // Hide loader
                console.error('Error:', error);
            });
    }

    // Call the function to load the chart data
    loadResponseCount();
</script>



<script>
    // Function to load chart data from API
    function ticketPercentage() {
        var apiUrl = '<?php echo base_url(); ?>/trend_analytic/ticket_percentage/<?php echo $this->uri->segment(3); ?>'; // Replace with dynamic parameter
        document.getElementById('chartLoader').style.display = 'block'; // Show loader

        // Fetch the data from the API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                if (data.status === 'success') {
                    // Parse and use the data to generate the chart
                    var ctx = document.getElementById('satisfactionChart').getContext('2d');
                    var feedbackChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.label, // Customize as needed
                            datasets: [{
                                label: 'Number of Patients',
                                data: data.data, // Use the data from API response
                                fill: false,
                                borderColor: "#28a745", // Changed line color to green
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    ticks: {
                                        fontSize: 26, // Font size for X-axis labels
                                        fontStyle: 'bold', // Optional: make the font bold
                                        maxRotation: 0,
                                        minRotation: 0
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Week', // X-axis title
                                        fontSize: 16 // Font size for X-axis title
                                    }
                                },
                                y: {
                                    ticks: {
                                        fontSize: 26, // Font size for Y-axis labels
                                        beginAtZero: true,
                                        stepSize: 10, // Adjust step size for the Y-axis
                                        min: 0, // Minimum value for the Y-axis
                                        max: 100, // Maximum value for the Y-axis
                                        callback: function(value) {
                                            return value + '%'; // Optional: format Y-axis labels with percentage
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Satisfaction (%)', // Y-axis title
                                        fontSize: 16 // Font size for Y-axis title
                                    }
                                }
                            }
                        }
                    });
                } else {
                    //alert('Error fetching data: ' + data.message);
                }
            })
            .catch(error => {
                document.getElementById('satisfactionChart').style.display = 'none'; // Hide loader
                console.error('Error:', error);
            });
    }

    // Call the function to load the chart data
    ticketPercentage();
</script>




<script>
    // Function to load chart data from API
    function ticketCount() {
        var apiUrl = '<?php echo base_url(); ?>/trend_analytic/ticket_count/<?php echo $this->uri->segment(3); ?>'; // Replace with dynamic parameter
        document.getElementById('chartLoader').style.display = 'block'; // Show loader

        // Fetch the data from the API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chartLoader').style.display = 'none'; // Hide loader
                if (data.status === 'success') {
                    // Parse and use the data to generate the chart
                    var ctx = document.getElementById('satisfactionChart_forTicket').getContext('2d');
                    var feedbackChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.label, // Customize as needed
                            datasets: [{
                                label: 'Negative feedback count',
                                data: data.data, // Use the data from API response
                                fill: false,
                                borderColor: "#28a745",
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    ticks: {
                                        fontSize: 26, // Font size for X-axis labels
                                        fontStyle: 'bold', // Optional: make the font bold
                                        maxRotation: 0,
                                        minRotation: 0
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Week', // X-axis title
                                        fontSize: 16 // Font size for X-axis title
                                    }
                                },
                                y: {
                                    ticks: {
                                        fontSize: 26, // Font size for Y-axis labels
                                        beginAtZero: true,
                                        stepSize: 10, // Adjust step size for the Y-axis
                                        min: 0, // Minimum value for the Y-axis
                                        max: 100, // Maximum value for the Y-axis
                                        callback: function(value) {
                                            return value + '%'; // Optional: format Y-axis labels with percentage
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Satisfaction (%)', // Y-axis title
                                        fontSize: 16 // Font size for Y-axis title
                                    }
                                }
                            }
                        }
                    });
                } else {
                    //alert('Error fetching data: ' + data.message);
                }
            })
            .catch(error => {
                document.getElementById('satisfactionChart_forTicket').style.display = 'none'; // Hide loader
                console.error('Error:', error);
            });
    }

    // Call the function to load the chart data
    ticketCount();
</script>
<style>
    #line canvas {
        height: 350px !important;
        width: 100% !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var typed = new Typed(".typing-text", {
            strings: ["<?php echo $welcometext; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });
</script>