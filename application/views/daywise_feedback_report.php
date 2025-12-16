<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/utils.js"></script>

<?php
	//echo '<pre>';
	
	
	$labels = array();
	$value = array();
	$date = date('Y-m-d',strtotime("-1 days"));
	for($i=0;$i<31;$i++){
		$this->db->select('datet,count(id) as t');
		$this->db->where('datet',$date);
		//$this->db->order_by('datet','DESC');
		$feedback = $this->db->get('bf_feedback')->result();
		$labels[] = date('dF,Y',strtotime($date));
		$value[] = $feedback[0]->t;
		$date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
	}
?>
 <section class="main">
	        
	        <section class="tab-content">
	            
	           <section id="dashboard">
			   <div id="container" style="width: 100%;">
							<canvas id="canvas_<?php echo $key; ?>"></canvas>
						</div>
			   </section>
			</section>
	</section>
<script>
	function load_graph<?php echo $key; ?>(){
		var color = Chart.helpers.color;
		var barChartData = {
			labels: [<?php echo '"'.implode('","',$labels).'"'; ?>],
			datasets: [{
				
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: [<?php echo implode(',',$value); ?>],
				fill: false
			}]

		};


			var ctx = document.getElementById('canvas_<?php echo $key; ?>').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'line',
				data: barChartData,
				options: {
					responsive: true,
					scales: {
                        yAxes: [
                            {
                                ticks: {
                                    min: 0, // it is for ignoring negative step.
                                    
                                    beginAtZero: true,
                                    stepSize: 5 // if i use this it always set it '1', which look very awkward if it have high value  e.g. '100'.
                                }
                            }
                        ]
                    },
					legend: {
						display: false
					},
					title: {
						display: false,
						text: 'Day Wise Feedback'
					}
				}
			});

		}
		load_graph<?php echo $key; ?>();

</script>
