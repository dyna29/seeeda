<?php 
/*
*Template Name: USER DASHBOARD 
*/  
get_header('user');
while ( have_posts() ) : the_post(); 
	$user_role = array();
	$user = new WP_User( get_current_user_id() );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
			$user_role[] = $role;
	}
	?> 
	<div class="main-panel"> 
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
			<?php  get_template_part( 'left', 'header' );?> 
			</div>
		</nav> 
		<div class="content">
			<div class="container-fluid">
				<div class="row">
				
								<?php if( (in_array("junkyards_administrator", $user_role))  )
						{
							
							
							// Fetch all Junkyards
$junkyard_query = new WP_Query([
    'post_type' => 'junkyard',
    'posts_per_page' => -1,
    'post_status' => 'publish','lang'=>pll_current_language()
]);

// Initialize an array to store the counts
$junkyard_data = [];

if ($junkyard_query->have_posts()) {
    while ($junkyard_query->have_posts()) {
        $junkyard_query->the_post();
        $junkyard_id = get_the_ID(); // Current junkyard ID
        $junkyard_name = get_the_title(); // Junkyard title

        // Count associated spare parts
        $spare_parts_count = new WP_Query([
            'post_type' => 'spare-part',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_associated_junkyard',
                    'value' => pll_get_post(  $junkyard_id,'en' ),
                    'compare' => '=',
                ],
            ],
        ]);

        // Count associated vehicles
        $vehicles_count = new WP_Query([
            'post_type' => 'vehicle',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_associated_junkyard',
                    'value' => pll_get_post(  $junkyard_id,'en' ),
                    'compare' => '=',
                ],
            ],
        ]);

        // Store the counts in the array
        $junkyard_data[] = [
            'name' => $junkyard_name,
            'vehicles' => $vehicles_count->found_posts,
            'spare_parts' => $spare_parts_count->found_posts,
        ];

        // Reset post data
        wp_reset_postdata();
    }
}

// Reset the query
wp_reset_postdata();
							?> 
							<style>
							.card .card-title {
    margin-top: 0;
    margin-bottom: 3px;
    font-weight: bold;
}
							</style>	<div class="col-md-6">
						<div class="card card-chart">
		
			
							<div class="card-body">
								<h4 class="card-title"><?php echo pll__('Analysis of Junkyard Inventory: Vehicle and Spare Part Distribution');?></h4>
								<p class="card-category">
													  <canvas id="junkyardChart"></canvas>	
													  	</div>
														<div class="card-footer">
														</div>
													</div>
												</div>
						<?php } 
						if(   (in_array("junkyard_manager", $user_role))  )
						{
						?>    
						
						<?php
// Assuming you have the Junkyard ID
$junkyard_id = get_user_meta(get_current_user_id(), '_junkyard_manager_user', true); 
// Function to get counts per brand for a specific junkyard
// Function to get brand-wise counts for a specific post type
function get_brandwise_counts($post_type, $taxonomy, $junkyard_id) {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ]);

    $data = [];
    foreach ($terms as $term) {
        $post_count = new WP_Query([
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_associated_junkyard',
                    'value' => pll_get_post(  $junkyard_id,'en' ),
                    'compare' => '=',
                ],
            ],
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ],
            ],
        ]);
        if($post_count->found_posts !=0){
        $data[$term->name] = $post_count->found_posts; // Keyed by brand name
		}
        wp_reset_postdata();
    }

    return $data;
}

// Get brand-wise counts for vehicles and spare parts
$vehicle_counts = get_brandwise_counts('vehicle', 'brand', pll_get_post(  $junkyard_id,'en' ));
$spare_part_counts = get_brandwise_counts('spare-part', 'brand',pll_get_post(  $junkyard_id,'en' ));

// Combine data for the chart
$chart_data = [
    'brands' => array_unique(array_merge(array_keys($vehicle_counts), array_keys($spare_part_counts))),
    'vehicle_counts' => $vehicle_counts,
    'spare_part_counts' => $spare_part_counts,
];
?> 	<div class="col-md-6">
						<div class="card card-chart">
		
			
							<div class="card-body">
								<h4 class="card-title"><?php echo pll__('Analysis of Junkyard Inventory: Vehicle and Spare Part Distribution');?></h4>
								<p class="card-category">  <canvas id="brandWiseChart"></canvas>
									</div>
														<div class="card-footer">
														</div>
													</div>
												</div>
								<?php } 
						 
						?>
													
											 
											</div>
										</div>
									</div>


<?php
endwhile;  
get_footer('user');?> 
<!-- Include Chartist.js CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<?php if( (in_array("junkyards_administrator", $user_role))  )
						{
							?>

 <script>
        // Data generated from PHP
        const junkyardData = <?php echo json_encode($junkyard_data); ?>;

        // Extract data for the chart
        const labels = junkyardData.map(item => item.name);
        const vehicleCounts = junkyardData.map(item => item.vehicles);
        const sparePartCounts = junkyardData.map(item => item.spare_parts);

        // Chart.js initialization
        const ctx = document.getElementById('junkyardChart').getContext('2d');
        const junkyardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Junkyard names
                datasets: [
                    {
                        label: '<?php echo pll__('Number of Vehicles');?>',
                        data: vehicleCounts, // Vehicle counts
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: '<?php echo pll__('Number of Spare Parts');?>',
                        data: sparePartCounts, // Spare part counts
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',rtl: true,
                    },
                },
                scales: {
                    x: {
						 reverse: true, // Reverse X-axis for RTL
                        title: {
                            display: true,
                            text: '<?php echo pll__('Junkyards');?>',rtl: true,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: '<?php echo pll__('Count');?>',rtl: true,
                        },
                    },
                },
            },
        });
    </script>
<?php } 
						if(   (in_array("junkyard_manager", $user_role))  )
						{
						?>
						 <script>
        // Data from PHP
        const chartData = <?php echo json_encode($chart_data); ?>;

        // Function to generate random colors
        function generateRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Process the data
        const brands = chartData.brands; // Array of all brands
        const vehicleData = brands.map(brand => chartData.vehicle_counts[brand] || 0); // Vehicle counts
        const sparePartData = brands.map(brand => chartData.spare_part_counts[brand] || 0); // Spare part counts

        // Generate random colors for each brand
        const brandColors = brands.map(generateRandomColor);

        // Chart.js Pie Chart
        const ctx = document.getElementById('brandWiseChart').getContext('2d');
        const brandWiseChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: brands, // Brand names
                datasets: [
                    {
                        label: '<?php echo pll__('Vehicles');?>',
                        data: vehicleData, // Vehicle counts
                        backgroundColor: brandColors, // Use unique colors for vehicles
                        borderColor: brandColors.map(color => darkenColor(color)), // Darken border color
                        borderWidth: 1,
                    },
                    {
                        label: '<?php echo pll__('Spare Parts');?>',
                        data: sparePartData, // Spare part counts
                        backgroundColor: brandColors.map(color => lightenColor(color)), // Lighten color for spare parts
                        borderColor: brandColors.map(color => darkenColor(color)), // Darken border color
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const datasetLabel = tooltipItem.dataset.label;
                                const value = tooltipItem.raw;
                                return `${datasetLabel}: ${value}`;
                            },
                        },
                    },
                    legend: {
                        position: 'top',
                    },
                },
            },
        });

        // Function to lighten a color
        function lightenColor(color) {
            let colorObj = hexToRgb(color);
            colorObj.r = Math.min(255, colorObj.r + 50);
            colorObj.g = Math.min(255, colorObj.g + 50);
            colorObj.b = Math.min(255, colorObj.b + 50);
            return rgbToHex(colorObj);
        }

        // Function to darken a color
        function darkenColor(color) {
            let colorObj = hexToRgb(color);
            colorObj.r = Math.max(0, colorObj.r - 50);
            colorObj.g = Math.max(0, colorObj.g - 50);
            colorObj.b = Math.max(0, colorObj.b - 50);
            return rgbToHex(colorObj);
        }

        // Helper function to convert hex to RGB
        function hexToRgb(hex) {
            let r = parseInt(hex.substring(1, 3), 16);
            let g = parseInt(hex.substring(3, 5), 16);
            let b = parseInt(hex.substring(5, 7), 16);
            return { r, g, b };
        }

        // Helper function to convert RGB to hex
        function rgbToHex(rgb) {
            return '#' + ((1 << 24) | (rgb.r << 16) | (rgb.g << 8) | rgb.b).toString(16).slice(1).toUpperCase();
        }
    </script>
					 
	<?php } 
						 
						?>