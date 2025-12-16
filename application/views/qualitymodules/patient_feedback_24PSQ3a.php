<div class="content">

    <?php
    // Check if 'id' is passed via POST or GET
    if ($this->input->post('id') || $this->input->get('id')) {
        $email = $this->session->userdata['email'];

        $hide = true;

        // Get 'id' value from POST or GET
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }

        // Query database for feedback details based on the 'id'
        $this->db->where('id', $id);
        $query = $this->db->get('bf_feedback_24PSQ4c');
        $results = $query->result();

        // Check if results exist
        if (count($results) >= 1) {
            foreach ($results as $result) {
                // Decode JSON data for the specific feedback
                $param = json_decode($result->dataset, true);
    ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 24. PSQ3c - <?php echo $result->id; ?> (General Patients)</h3>
                            </div>

                            <?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
                                <div class="btn-group" style="float: right;">
                                    <a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_24PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
                                </div>
                            <?php } ?>

                            <div class="panel-body" style="background: #fff;">
                                <table class="table table-striped table-bordered no-footer dtr-inline" style="font-size: 16px;">
                                    <tr>
                                        <td><b>Sum of time taken for discharge</b></td>
                                        <td><?php echo $result->sum_of_discharge_time; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Number of patients discharged</b></td>
                                        <td><?php echo $result->no_of_patients_discharged; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Avg. time taken for discharge</b></td>
                                        <td>
                                            <?php
                                            // Benchmark time (4 hours) in seconds
                                            $benchmarkSeconds = $param['benchmark8'] * 60 * 60;

                                            // Convert the calculatedResult to seconds
                                            list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $result->avg_discharge_time);
                                            $calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

                                            // Check if calculatedResult is less than benchmark
                                            $color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';
                                            ?>
                                            <span style="color: <?php echo $color; ?>">
                                                <?php echo $result->avg_discharge_time; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Bench Mark Time</b></td>
                                        <td><?php echo $param['benchmark8']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data analysis</b></td>
                                        <td><?php echo $param['dataAnalysis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Corrective action</b></td>
                                        <td><?php echo $param['correctiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Preventive action</b></td>
                                        <td><?php echo $param['preventiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>KPI recorded by</b></td>
                                        <td><?php echo $param['name']; ?> , <?php echo $param['patientid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data collection on</b></td>
                                        <td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?> <br>
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
    <?php }
    } ?>

    <?php if ($hide == false) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo form_open(); ?>
                        <table class="table">
                            <tr>
                                <th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
                                <td class="" style="border:none !important;">
                                    <input type="text" class="form-control" placeholder="Enter Feedback ID" maxlength="15" size="10" name="pid">
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

    <div class="row">
        <div class="col-sm-12">
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

                <canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>
            </div>
        </div>
    </div>

    <style>
        ul.feedback {
            margin: 0px;
            padding: 0px;
        }

        ul.feedback li {
            list-style: none;
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
            font-weight: bold;
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data
        var benchmark = "<?php echo $param['benchmark8']; ?>"; // Benchmark value
        var calculated = "<?php echo $result->avg_discharge_time; ?>"; // Calculated value
        var monthyear = "<?php echo date('d-M-Y', strtotime($result->datetime)); ?>"; // Date value

        // Parse times to seconds
        var benchmarkSeconds = parseTimeToSeconds(benchmark);
        var calculatedSeconds = parseTimeToSeconds(calculated);

        // Determine colors based on comparison
        var calculatedColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)'; // Red if calculated is greater, otherwise green
        var calculatedBorderColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)';

        // Create the chart
        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            responsive: true,
            data: {
                labels: ['Benchmark Time', 'Avg. time taken for discharge'],
                datasets: [{
                    label: 'Benchmark Time compared with Avg. time taken for discharge',
                    data: [benchmarkSeconds, calculatedSeconds],
                    backgroundColor: ['rgba(56, 133, 244, 1)', calculatedColor], // Blue color for benchmark
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var value = context.raw;
                                return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
                            }
                        }
                    },
                    legend: {
                        labels: {
                            boxWidth: 30, // Hide the legend color box
                            font: {
                                size: 16 // Adjust label font size if needed
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Avg. time taken for discharge for general patients for ' + monthyear,
                        font: {
                            size: 24 // Increase this value to adjust the title font size
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                const timeValue = index === 0 ? benchmarkSeconds : calculatedSeconds;
                                return [label, '(' + secondsToTime(timeValue) + ')'];
                            },
                            font: {
                                size: 20,
                                family: 'vazir'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 20
                            }
                        }
                    }
                }
            }
        });

        // Function to convert time string (hh:mm:ss) to seconds
        function parseTimeToSeconds(timeString) {
            var timeArray = timeString.split(':');
            return (parseInt(timeArray[0]) * 3600) + (parseInt(timeArray[1]) * 60) + parseInt(timeArray[2]);
        }

        // Function to convert seconds to time string (hh:mm:ss)
        function secondsToTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var seconds = seconds % 60;
            return hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    </script>

    <script>
        function printChart() {
            const canvas = document.getElementById('barChart');
            const dataUrl = canvas.toDataURL(); // Get image data of canvas
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
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>24.PSQ4c- Time taken for discharge(General Patients)</h3>
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
            const canvas = document.getElementById('barChart');
            const image = canvas.toDataURL('image/png'); // Convert canvas to image data

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = image;
            link.download = '24.PSQ4c- Time taken for discharge(General Patients).png'; // Name of downloaded file
            link.click(); // Trigger download
        }
    </script>
</div>

<div class="content">

    <?php
    // Check if 'id' is passed via POST or GET
    if ($this->input->post('id') || $this->input->get('id')) {
        $email = $this->session->userdata['email'];

        $hide = true;

        // Get 'id' value from POST or GET
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }

        // Query database for feedback details based on the 'id'
        $this->db->where('id', $id);
        $query = $this->db->get('bf_feedback_24PSQ4c');
        $results = $query->result();

        // Check if results exist
        if (count($results) >= 1) {
            foreach ($results as $result) {
                // Decode JSON data for the specific feedback
                $param = json_decode($result->dataset, true);
    ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 24. PSQ3c - <?php echo $result->id; ?> (Insurance Patients)</h3>
                            </div>

                            <?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
                                <div class="btn-group" style="float: right;">
                                    <a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_24PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
                                </div>
                            <?php } ?>

                            <div class="panel-body" style="background: #fff;">
                                <table class="table table-striped table-bordered no-footer dtr-inline" style="font-size: 16px;">
                                    <tr>
                                        <td><b>Sum of time taken for discharge</b></td>
                                        <td><?php echo $result->sum_of_discharge_time_ins; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Number of patients discharged</b></td>
                                        <td><?php echo $result->no_of_patients_discharged_ins; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Avg. time taken for discharge</b></td>
                                        <td>
                                            <?php
                                            // Benchmark time (4 hours) in seconds
                                            $benchmarkSeconds = $param['benchmark9'] * 60 * 60;

                                            // Convert the calculatedResult to seconds
                                            list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $result->avg_discharge_time_ins);
                                            $calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

                                            // Check if calculatedResult is less than benchmark
                                            $color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';
                                            ?>
                                            <span style="color: <?php echo $color; ?>">
                                                <?php echo $result->avg_discharge_time_ins; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Bench Mark Time</b></td>
                                        <td><?php echo $param['benchmark9']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data analysis</b></td>
                                        <td><?php echo $param['dataAnalysis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Corrective action</b></td>
                                        <td><?php echo $param['correctiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Preventive action</b></td>
                                        <td><?php echo $param['preventiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>KPI recorded by</b></td>
                                        <td><?php echo $param['name']; ?> , <?php echo $param['patientid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data collection on</b></td>
                                        <td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?> <br>
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
    <?php }
    } ?>

    <?php if ($hide == false) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo form_open(); ?>
                        <table class="table">
                            <tr>
                                <th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
                                <td class="" style="border:none !important;">
                                    <input type="text" class="form-control" placeholder="Enter Feedback ID" maxlength="15" size="10" name="pid">
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

    <div class="row">
        <div class="col-sm-12">
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
                <canvas id="barChart2" width="400" height="200" style="width: 50%;padding:50px;"></canvas>
            </div>
        </div>
    </div>

    <style>
        ul.feedback {
            margin: 0px;
            padding: 0px;
        }

        ul.feedback li {
            list-style: none;
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
            font-weight: bold;
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data
        var benchmark = "<?php echo $param['benchmark9']; ?>"; // Benchmark value
        var calculated = "<?php echo $result->avg_discharge_time_ins; ?>"; // Calculated value
        var monthyear = "<?php echo date('d-M-Y', strtotime($result->datetime)); ?>"; // Date value

        // Parse times to seconds
        var benchmarkSeconds = parseTimeToSeconds(benchmark);
        var calculatedSeconds = parseTimeToSeconds(calculated);

        // Determine colors based on comparison
        var calculatedColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)'; // Red if calculated is greater, otherwise green
        var calculatedBorderColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)';

        // Create the chart
        var ctx = document.getElementById('barChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            responsive: true,
            data: {
                labels: ['Benchmark Time', 'Avg. time taken for discharge'],
                datasets: [{
                    label: 'Benchmark Time compared with Avg. time taken for discharge',
                    data: [benchmarkSeconds, calculatedSeconds],
                    backgroundColor: ['rgba(56, 133, 244, 1)', calculatedColor], // Blue color for benchmark
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var value = context.raw;
                                return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
                            }
                        }
                    },
                    legend: {
                        labels: {
                            boxWidth: 30, // Hide the legend color box
                            font: {
                                size: 16 // Adjust label font size if needed
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Avg. time taken for discharge for insurance patients for ' + monthyear,
                        font: {
                            size: 24 // Increase this value to adjust the title font size
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                const timeValue = index === 0 ? benchmarkSeconds : calculatedSeconds;
                                return [label, '(' + secondsToTime(timeValue) + ')'];
                            },
                            font: {
                                size: 20,
                                family: 'vazir'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 20
                            }
                        }
                    }
                }
            }
        });

        // Function to convert time string (hh:mm:ss) to seconds
        function parseTimeToSeconds(timeString) {
            var timeArray = timeString.split(':');
            return (parseInt(timeArray[0]) * 3600) + (parseInt(timeArray[1]) * 60) + parseInt(timeArray[2]);
        }

        // Function to convert seconds to time string (hh:mm:ss)
        function secondsToTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var seconds = seconds % 60;
            return hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    </script>

    <script>
        function printChart() {
            const canvas = document.getElementById('barChart2');
            const dataUrl = canvas.toDataURL(); // Get image data of canvas
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
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>24.PSQ4c- Time taken for discharge(Insurance Patients)</h3>
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
            const canvas = document.getElementById('barChart2');
            const image = canvas.toDataURL('image/png'); // Convert canvas to image data

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = image;
            link.download = '24.PSQ4c- Time taken for discharge(Insurance Patients).png'; // Name of downloaded file
            link.click(); // Trigger download
        }
    </script>
</div>


<div class="content">

    <?php
    // Check if 'id' is passed via POST or GET
    if ($this->input->post('id') || $this->input->get('id')) {
        $email = $this->session->userdata['email'];

        $hide = true;

        // Get 'id' value from POST or GET
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }

        // Query database for feedback details based on the 'id'
        $this->db->where('id', $id);
        $query = $this->db->get('bf_feedback_24PSQ4c');
        $results = $query->result();

        // Check if results exist
        if (count($results) >= 1) {
            foreach ($results as $result) {
                // Decode JSON data for the specific feedback
                $param = json_decode($result->dataset, true);
    ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 24. PSQ3c - <?php echo $result->id; ?> (Corporate Patients)</h3>
                            </div>

                            <?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
                                <div class="btn-group" style="float: right;">
                                    <a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_24PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
                                </div>
                            <?php } ?>

                            <div class="panel-body" style="background: #fff;">
                                <table class="table table-striped table-bordered no-footer dtr-inline" style="font-size: 16px;">
                                    <tr>
                                        <td><b>Sum of time taken for discharge</b></td>
                                        <td><?php echo $result->sum_of_discharge_time_cop; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Number of patients discharged</b></td>
                                        <td><?php echo $result->no_of_patients_discharged_cop; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Avg. time taken for discharge</b></td>
                                        <td>
                                            <?php
                                            // Benchmark time (4 hours) in seconds
                                            $benchmarkSeconds = $param['benchmark7'] * 60 * 60;

                                            // Convert the calculatedResult to seconds
                                            list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $result->avg_discharge_time_cop);
                                            $calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

                                            // Check if calculatedResult is less than benchmark
                                            $color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';
                                            ?>
                                            <span style="color: <?php echo $color; ?>">
                                                <?php echo $result->avg_discharge_time_cop; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Bench Mark Time</b></td>
                                        <td><?php echo $param['benchmark7']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data analysis</b></td>
                                        <td><?php echo $param['dataAnalysis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Corrective action</b></td>
                                        <td><?php echo $param['correctiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Preventive action</b></td>
                                        <td><?php echo $param['preventiveAction']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>KPI recorded by</b></td>
                                        <td><?php echo $param['name']; ?> , <?php echo $param['patientid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Data collection on</b></td>
                                        <td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?> <br>
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
    <?php }
    } ?>

    <?php if ($hide == false) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo form_open(); ?>
                        <table class="table">
                            <tr>
                                <th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
                                <td class="" style="border:none !important;">
                                    <input type="text" class="form-control" placeholder="Enter Feedback ID" maxlength="15" size="10" name="pid">
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

    <div class="row">
        <div class="col-sm-12">
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

                <canvas id="barChart3" width="400" height="200" style="width: 50%;padding:50px;"></canvas>
            </div>
        </div>
    </div>

    <style>
        ul.feedback {
            margin: 0px;
            padding: 0px;
        }

        ul.feedback li {
            list-style: none;
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
            font-weight: bold;
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data
        var benchmark = "<?php echo $param['benchmark7']; ?>"; // Benchmark value
        var calculated = "<?php echo $result->avg_discharge_time_cop; ?>"; // Calculated value
        var monthyear = "<?php echo date('d-M-Y', strtotime($result->datetime)); ?>"; // Date value

        // Parse times to seconds
        var benchmarkSeconds = parseTimeToSeconds(benchmark);
        var calculatedSeconds = parseTimeToSeconds(calculated);

        // Determine colors based on comparison
        var calculatedColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)'; // Red if calculated is greater, otherwise green
        var calculatedBorderColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)';

        // Create the chart
        var ctx = document.getElementById('barChart3').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            responsive: true,
            data: {
                labels: ['Benchmark Time', 'Avg. time taken for discharge'],
                datasets: [{
                    label: 'Benchmark Time compared with Avg. time taken for discharge',
                    data: [benchmarkSeconds, calculatedSeconds],
                    backgroundColor: ['rgba(56, 133, 244, 1)', calculatedColor], // Blue color for benchmark
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var value = context.raw;
                                return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
                            }
                        }
                    },
                    legend: {
                        labels: {
                            boxWidth: 30, // Hide the legend color box
                            font: {
                                size: 16 // Adjust label font size if needed
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Avg. time taken for discharge for corporate patients for ' + monthyear,
                        font: {
                            size: 24 // Increase this value to adjust the title font size
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                const timeValue = index === 0 ? benchmarkSeconds : calculatedSeconds;
                                return [label, '(' + secondsToTime(timeValue) + ')'];
                            },
                            font: {
                                size: 20,
                                family: 'vazir'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 20
                            }
                        }
                    }
                }
            }
        });

        // Function to convert time string (hh:mm:ss) to seconds
        function parseTimeToSeconds(timeString) {
            var timeArray = timeString.split(':');
            return (parseInt(timeArray[0]) * 3600) + (parseInt(timeArray[1]) * 60) + parseInt(timeArray[2]);
        }

        // Function to convert seconds to time string (hh:mm:ss)
        function secondsToTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var seconds = seconds % 60;
            return hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    </script>

    <script>
        function printChart() {
            const canvas = document.getElementById('barChart3');
            const dataUrl = canvas.toDataURL(); // Get image data of canvas
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
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>24.PSQ4c- Time taken for discharge(Corporate Patients)</h3>
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
            const canvas = document.getElementById('barChart3');
            const image = canvas.toDataURL('image/png'); // Convert canvas to image data

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = image;
            link.download = '24.PSQ4c- Time taken for discharge(Corporate Patients).png'; // Name of downloaded file
            link.click(); // Trigger download
        }
    </script>
</div>