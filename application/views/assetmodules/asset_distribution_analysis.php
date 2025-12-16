<div class="container-fluid">
    <!-- 1. Asset Group Chart -->
    <div class="col-lg-7 col-sm-12 col-md-6" style="width: 80%;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Asset distribution by Asset Group/ Category
                    <a href="javascript:void()" data-toggle="tooltip" title="This pie chart shows how assets are divided into various categories and their percentage of the total.">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </h3>
            </div>
            <div class="panel-body" style="height: 495px;" id="chart_group">
                <div class="message_inner chart-container">
                    <canvas id="chartAssetGroup"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Asset Department Chart -->
    <div class="col-lg-7 col-sm-12 col-md-6" style="width: 80%;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Asset distribution by Asset Department
                    <a href="javascript:void()" data-toggle="tooltip" title="Breakdown of assets based on departments.">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </h3>
            </div>
            <div class="panel-body" style="height: 495px;" id="chart_department">
                <div class="message_inner chart-container">
                    <canvas id="chartAssetDepartment"></canvas>
                </div>
            </div>
        </div>
    </div>

   

    <!-- 3. Asset Floor Chart -->
    <div class="col-lg-7 col-sm-12 col-md-6" style="width: 80%;">
        <div class="panel panel-default">
            <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">
                    Asset distribution by Floor/ Site
                    <a href="javascript:void()" data-toggle="tooltip" title="Asset distribution across different building floors.">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </h3>

                <!-- Department Dropdown -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 16px;"><strong>Department</strong></span>
                    <div class="btn-group">
                        <button type="button" style="background: #62c52d; border: none; width: 150px;"
                            class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span id="selectedDepartment">ALL</span>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu" style="text-align: left; width: 100%;">
                            <?php
                            $this->db->order_by('title');
                            $this->db->group_by('title');
                            $query = $this->db->get('bf_ward_esr');
                            $ward = $query->result();

                            foreach ($ward as $rw) {
                                if ($rw->title) {
                                    echo '<li><a class="dropdown-item" href="javascript:void(0)" onclick="tickets_recived_by_floor_set(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                    echo '<div class="dropdown-divider"></div>';
                                } else {
                                    echo '<li><a class="dropdown-item" href="javascript:void(0)" onclick="tickets_recived_by_floor_set(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="height: 495px;" id="chart_floor">
                <div class="message_inner chart-container">
                    <canvas id="chartAssetFloor"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Asset Grade Chart -->
    <div class="col-lg-7 col-sm-12 col-md-6" style="width: 80%;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Asset distribution by Asset Grade
                    <a href="javascript:void()" data-toggle="tooltip" title="Categorization of assets according to grade or condition.">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </h3>
            </div>
            <div class="panel-body" style="height: 495px;" id="chart_grade">
                <div class="message_inner chart-container">
                    <canvas id="chartAssetGrade"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function loadChart(endpoint, canvasId, chartType = 'pie') {
        try {
            const response = await fetch('<?php echo base_url(); ?>asset/' + endpoint);
            const data = await response.json();

            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: [
                            '#4caf50', '#2196f3', '#ff9800', '#9c27b0',
                            '#f44336', '#FF9F40', '#C9CBCF', '#8E44AD'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: chartType === 'bar' ? 'top' : 'right',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            bodyFont: {
                                size: 14
                            },
                            titleFont: {
                                size: 15
                            }
                        }
                    },
                    ...(chartType === 'bar' && {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        size: 13
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 13
                                    }
                                }
                            }
                        }
                    })
                }

            });
        } catch (err) {
            console.error('Error loading chart:', err);
        }
    }


    window.onload = function() {
        loadChart('ticket_dashboard_pie', 'chartAssetGroup', 'pie'); // Pie chart
        loadChart('asset_department_chart', 'chartAssetDepartment', 'pie'); // Pie chart
        loadChart('asset_grade_chart', 'chartAssetGrade', 'bar'); // Bar chart
        loadChart('asset_floor_chart', 'chartAssetFloor', 'pie'); // Pie chart
    };
</script>


<style>
    .chart-container {
        position: relative;
        height: 100%;
        width: 100%;
        max-height: 100%;
        /* restrict overflow */
        max-width: 100%;
    }

    canvas {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
</style>

<script>
    function tickets_recived_by_floor_set(value) {
        // Update the UI with selected department name
        document.getElementById('selectedDepartment').innerText = value;

        // Prepare the API URL
        var domain = window.location.hostname; // Automatically get current domain
        var apiUrl = "https://" + domain + "/analytics_asset/tickets_recived_by_floor_set?settype=" + encodeURIComponent(value);

        // Create and send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("GET", apiUrl, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var responseData = JSON.parse(xhr.responseText);
                    // Call your chart update/rendering function
                    ticketsRecivedByDepartment(responseData);
                } catch (e) {
                    console.error("Invalid JSON response", e);
                }
            }
        };
        xhr.send();
    }
</script>

<script>
    function ticketsRecivedByDepartment(data) {
        const labels = data.map(item => item.bed_no);
        const values = data.map(item => item.data_field);

        // Check if chart instance exists
        if (window.chartAssetFloor) {
            // Update existing chart
            window.chartAssetFloor.data.labels = labels;
            window.chartAssetFloor.data.datasets[0].data = values;
            window.chartAssetFloor.update();
        } else {
            // Create chart for the first time
            const ctx = document.getElementById('chartAssetFloor').getContext('2d');
            window.chartAssetFloor = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Assets by Bed No',
                        data: values,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });
        }
    }
</script>