<?php 
	get_header();
	 
	  while ( have_posts() ) : the_post();
					 	$post_id = pll_get_post( 110,pll_current_language() );
					$pinlink =  get_permalink($post_id);
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	 $curr_junkyard  = pll_get_post( get_the_ID(),'en' );
	  $sbrand = 0; 
	  $searchfor =array();
	  $sspare_part=array();
	  $swheel_size= ""; 
	  $swheel_lug_nut= ""; 
	  $swheel_type= ""; 
	  
		if(isset($_REQUEST["brand"])){
			 
			$sbrand = sanitize_text_field($_REQUEST["brand"]);
			if($sbrand !=0 && $sbrand !=""){
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $sbrand ),
				);
				 $searchfor[] = "brand <strong>'".get_term( $sbrand )->name."'</strong> ";
			}
		}  
		if(isset($_REQUEST["model"])){
			 
			$smodel = sanitize_text_field($_REQUEST["model"]);
			if($smodel !=0 && $smodel !=""){
			 $tax_query[] = array(
				'taxonomy' => 'brand',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $smodel ),
			);
			
				 $searchfor[]=  " model <strong>'".get_term( $smodel )->name."'</strong> ";
			}
		} 
		if(isset($_REQUEST["model_year"])){
			 
			$smodel_year = sanitize_text_field($_REQUEST["model_year"]);
			if($smodel_year !=0 && $smodel_year !=""){
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $smodel_year ),
			);
			}
				 $searchfor[]= " model year <strong>'".get_term( $smodel_year )->name."'</strong>  ";
		}  
		if(isset($_REQUEST["spare_part"])){
		  
			 
			 foreach ($_REQUEST['spare_part'] as $value) {
        // Save each value to the database
		
		 
    }
	
	 
			$sspare_part =  ($_REQUEST["spare_part"]);
 $sspare_part_arr = array();
			if($sspare_part !=0 && $sspare_part !=""){
				foreach ($sspare_part as $value) {
			$sspare_part_arr[] = (int) $value;
				}
			 $tax_query[] = array(
				'taxonomy' => 'spare-part-type',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    =>  $sspare_part_arr  , 
			);
			}
			 $searchfor[]= "spare part type ";
			 foreach($_REQUEST["spare_part"] as $sp){
				$searchfor[]= "<strong> '".get_term( $sp )->name."'</strong>";
			 }
		} 
		if(isset($_REQUEST["wheel_size"])){
			 
			$swheel_size = sanitize_text_field($_REQUEST["wheel_size"]);
			if($swheel_size !=0 && $swheel_size !=""){
			 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => array( $swheel_size ),
			);
			}
			
				$searchfor[]= "wheel size <strong>'".get_term( $swheel_size )->name."'</strong>";
		} 
		if(isset($_REQUEST["wheel_lug_nut"])){
			 
			$swheel_lug_nut = sanitize_text_field($_REQUEST["wheel_lug_nut"]);
			if($swheel_lug_nut !=0 && $swheel_lug_nut !=""){
			 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-lug-nut',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => array( $swheel_lug_nut ),
			);
			}
			
				$searchfor[]= "wheel size <strong>'".get_term( $swheel_size )->name."'</strong>";
		}
  $meta_query  =array();
		if(isset($_REQUEST["wheel_type"])){
			$swheel_type = sanitize_text_field($_REQUEST["wheel_type"]);
			if(  $swheel_type !=""){
     $meta_query = array(
        array(
            'key'     => 'wheel_type',
            'value'   => $swheel_type,
            'compare' => '='
        )
    );
}
		}
		 
 $searchfor = implode(", ",$searchfor);
				$args = array(
					'post_type' => array('vehicle', 'spare-part'), 
					'posts_per_page' => -1, // Get all posts
				);

				// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				}
				if ( !empty(  $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
 
				$junkyards = array();
		 
				$loop        = new WP_Query($args);
				$prev_parent = '';
				if ($loop->have_posts()) {

					while ($loop->have_posts()):
						$loop->the_post(); 
							$junkyards[] = get_post_meta(get_the_ID(),'_associated_junkyard',true);

					endwhile;
				wp_reset_postdata();
				}
					 
					$junkyards = array_unique($junkyards);
					 
					 
					?>
<!-- Hero Section -->
<section   id= "search-form" class="search-form junkyard" style="background:url(<?php echo get_stylesheet_directory_uri();?>/images/junkyards-banner.jpg)">
	<div class="container">
		<div class="search-section-container grey ">
			<form action="<?php echo $pinlink;?>" method="post" class="search-form">
				<div class="search-section">
					<?php echo create_brand_and_model_dropdowns($brand);?>
					<div class="search-item brand-model-container">
						<label for="parts"><?php echo pll__('Model Year');?></label>
						<?php echo get_model_year_terms_dropdown($smodel_year);?>
					</div>
					<div class="search-item brand-model-container">
						<label for="parts"><?php echo pll__('Spare Parts');?></label>
						<?php echo get_spare_part_terms_dropdown($sspare_part);?>
					</div>
					<div class="search-item">
						<label for="parts">&nbsp;</label>
				<input type="hidden" id="sbrand" value="<?php echo $brand;?>">
				<input type="hidden" id="smodel" value="<?php echo $smodel;?>">
				<input type="hidden" id="wheel-size" name="wheel_size" value="<?php echo $swheel_size;?>">
				<input type="hidden" id="wheel-lug-nut" name="wheel_lug_nut" value="<?php echo $swheel_lug_nut;?>">
				<input type="hidden" id="wheel-type" name="wheel_type" value="<?php echo $swheel_type;?>">
				<input type="hidden" id="sjunkyards" value="<?php echo implode(",",$junkyards);?>">
				<input type="hidden" id="junkyard"  value="<?php echo get_the_ID();?>">
						<button type="submit"><?php echo pll__('Search');?></button>
					</div>
				</div> 
			</form>
		</div>
		<div class="junkyard-info-section-container ">
		 <h1><?php echo get_the_title();?></h1>
		 <h3><?php echo get_field('sub_text');?></h3>
		 	 <span class="contact-info"><a target="_blank" class="whatsapp-call" junkyard="<?php echo $curr_junkyard;?>"  href="https://api.whatsapp.com/send?phone=<?php echo get_field('whatsapp');?>&amp;text=I%27d%20have%20an%20enquiry...."><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-whatsapp-logo-48-single.png"><span class="desktop-view"><?php echo get_field('phone');?></span></a></span> 
			 	 <span class="contact-info"><a  href="tel:<?php echo get_field('phone');?>"  class="phone-call" junkyard="<?php echo $curr_junkyard;?>" ><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-phone-48-single.png"><span class="desktop-view"><?php echo get_field('phone');?></span></a></span> 
		 <span class="contact-info"><a  href="<?php echo get_field('google_location');?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-location-48-single.png"><span class="desktop-view"> <?php echo get_field('address');?></span></a></span>
	<!--<ul class="social-links">
	<li><a href="<?php echo get_field('facebook_link');?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-facebook-logo-48.png"></a></li>
	<li><a href="<?php echo get_field('instagram_link');?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-instagram-logo-48.png"></a></li>
	<li><a href="<?php echo get_field('twitter_link');?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-twitterx-48.png"></a></li>
	<li><a href="<?php echo get_field('linkedin_link');?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-linkedin-logo-48.png"></a></li>
	</ul>-->
		</div>
	
	</div>
</section>
<section   id= "junkyard-details">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
						<ul class="result-header row">
				<!--	<li>
					 
						<span>Showing <span id="total-row-start">1</span>-<span id="total-row-end"></span> of <span id="total-pages"> --</span> results</span>
					</li>-->
					<li>
						<!--Display : 
						<div class="display-rows-dropdown">
							<select id="display-rows" class="display-rows">
								<option value="24">24 Per Page</option>
								<option value="48">48 Per Page</option>
								<option value="100">100 Per Page</option>
							</select>
						</div>-->
					</li>
					<li>
						<!--D<div class="sort-dropdown">
							<select id="sort-by" class="sort-select">
								<option value="popularity">Sort by Popularity</option>
								<option value="date">Sort by Date</option>
								<option value="price">Sort by Price</option>
							</select>
						</div>-->
					</li>
				</ul>
 <div class="vehicle-list"> 
						<?php  
						
					 
								echo fetch_vehicle_posts($sbrand,$smodel,$smodel_year,$sspare_category, $swheel_size ,$swheel_lug_nut,$swheel_type,$curr_junkyard);
								
								?>
						 
					</div>
					
					
					
					 <div class="spare-list"> 
						<?php  
						
					 
								echo fetch_spare_posts($sbrand,$smodel,$smodel_year,$sspare_category, $swheel_size ,$swheel_lug_nut,$swheel_type,$curr_junkyard);
								
								?>
						 
					</div>
		</div>
	</div>
	</div>
</section>
<section class="brands junkyard" style="background:url(<?php echo get_stylesheet_directory_uri();?>/images/brand-bg.png)">
	<!-- Content Section -->
	<div class="container  ">
		<h2><?php echo pll__('EXPLORE AVAILABLE BRANDS');?></h2>
		<div class="row">
			<div class="col-md-12">
				<ul class="brand-row row">
			 
 <?php
// Define the custom post types you want to query
$post_types = array('spare-part', 'vehicle');

// Initialize an array to hold parent brand terms
$parent_brands = array();

foreach ($post_types as $post_type) {
    // Query posts with the specific meta key and value
    $args = array(
        'post_type'  => $post_type,
        'meta_query' => array(
            array(
                'key'     => '_associated_junkyard',
                'value'   => $curr_junkyard,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1 // Retrieve all matching posts
    );
    
    $query = new WP_Query($args);

    // Loop through each post
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the 'brand' taxonomy terms for the post
            $brands = get_the_terms(get_the_ID(), 'brand');

            if ($brands && !is_wp_error($brands)) {
                foreach ($brands as $brand) {
                    // Find the top-level parent term
                    $parent_brand = $brand;
                    while ($parent_brand->parent != 0) {
                        $parent_brand = get_term($parent_brand->parent, 'brand');
                    }

                    // Store parent brands uniquely by term ID
                    $parent_brands[$parent_brand->term_id] = $parent_brand;
                }
            }
        }
        wp_reset_postdata();
    }
}

// Display the parent brands
foreach ($parent_brands as $parent_brand) {
   	 $image = get_field('thumbnail', $parent_brand);
?>
 
					<li>
						 <div class="brand-item brand-filter-item"  filter="brand" item="<?php echo $parent_brand->term_id;?>">
							<img src="<?php echo $image;?>">
							<h4><?php echo esc_html($parent_brand->name);?></h4>
						</div>
					</li>
					<?php 
	  
}
						?>				
				</ul> 
			</div>
		</div>
	</div>
</section>
 
<?php
	endwhile;  
	get_footer();?>