<?php
	/*
	*Template Name: Search Result Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 
	 	$post_id = pll_get_post( 110,pll_current_language() );
					$pinlink =  get_permalink($post_id);
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  $sbrand = 0; 
	  $searchfor =array();
	  $sspare_part=array();
	  $swheel_size=  ""; 
	  $swheel_lug_nut=  ""; 
	  $swheel_type= "";  

	 
		if(isset($_REQUEST["brand"])){
			 
			$sbrand = sanitize_text_field($_REQUEST["brand"]);
			if($sbrand !=0 && $sbrand !=""){
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $sbrand ),
				);
				
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
			
			$strtranslation = pll__("Junkyards for brand '<%sbrand%>', model '<%smodel%>'");
			$strtranslation = str_replace("<%sbrand%>","<strong>".get_term( $sbrand )->name."</strong>",$strtranslation);
			$strtranslation = str_replace("<%smodel%>","<strong>".get_term( $smodel )->name."</strong>",$strtranslation);
			$searchfor[]  = $strtranslation;
			//<strong>'".get_term( $sbrand )->name."'</strong>
			}
		} 

		if(isset($_REQUEST["model_year"])){
		 
		if(  $_REQUEST["model_year"]   !="" && $_REQUEST["model_year"]  !="0"){
			$smodel_year = sanitize_text_field($_REQUEST["model_year"]);
			if($smodel_year !=0 && $smodel_year !=""){
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $smodel_year ),
			);
			}

			$strtranslation = pll__(", model year '<%smodelyear%>'");
			
			$strtranslation = str_replace("<%smodelyear%>","<strong>".get_term( $smodel_year )->name."</strong>",$strtranslation);
			$searchfor[]  = $strtranslation;
				// $searchfor[]= " model year <strong>'".get_term( $smodel_year )->name."'</strong>  ";
		} 
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
			 $sparrpartsnames  =array();

			 $strtranslation = pll__(", spare part type '<%sspareparttype%>'");
			 if(!(is_array($_REQUEST["spare_part"]))){
				 $arr_spare_part = array();
				 $arr_spare_part[] = $_REQUEST["spare_part"];
			 }else{
				 $arr_spare_part  = $_REQUEST["spare_part"];
			 }
			  
			 foreach($arr_spare_part as $sp){
			 
				$sparrpartsnames[] = "<strong> ".get_term( $sp )->name."</strong>";
			 }
		 
			 $sparrpartsnames  = implode(",",$sparrpartsnames);
			$strtranslation = str_replace("<%sspareparttype%>","<strong>".$sparrpartsnames."</strong>",$strtranslation);
			$searchfor[]  = $strtranslation;
		} 
		if(isset($_REQUEST["wheel_size"])){
			 
			$swheel_size = sanitize_text_field($_REQUEST["wheel_size"]);
			 
			if($swheel_size !="0" && $swheel_size !=""){
			 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => array( $swheel_size ),
			);
			
			$strtranslation = pll__(", wheel size '<%swheelsize%>'");
			
			$strtranslation = str_replace("<%swheelsize%>","<strong>".get_term( $swheel_size )->name."</strong>",$strtranslation);
			$searchfor[]  = $strtranslation;}
			//	$searchfor[]= "wheel size <strong>'".get_term( $swheel_size )->name."'</strong>";
		} 
		if(isset($_REQUEST["wheel_lug_nut"])){
			 
			$swheel_lug_nut = sanitize_text_field($_REQUEST["wheel_lug_nut"]);
			if($swheel_lug_nut !="0" && $swheel_lug_nut !=""){
			 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-lug-nut',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => array( $swheel_lug_nut ),
			);
			
			$strtranslation = pll__(", wheel lug nut '<%swheel_lug_nut%>'");
			$strtranslation = str_replace("<%swheel_lug_nut%>","<strong>".get_term( $swheel_lug_nut )->name."</strong>",$strtranslation);
			$searchfor[]  = $strtranslation;
			}
				 
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

$strtranslation = pll__(", wheel type '<%swheel_type%>'");
$strtranslation = str_replace("<%swheel_type%>","<strong>".pll__($swheel_type)."</strong>",$strtranslation);
$searchfor[]  = $strtranslation;
		}
		 
 $searchfor = implode(" ",$searchfor);
				$args = array(
					'post_type' => array('vehicle', 'spare-part'), 
					'posts_per_page' => -1, // Get all posts
					'post_status' => 'publish', // Get all posts
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
		 //  	 echo "<pre>";
	// var_dump($args);
				$loop        = new WP_Query($args);
				$prev_parent = '';
				if ($loop->have_posts()) {

					while ($loop->have_posts()):
						$loop->the_post(); 
							$junkyards[] = get_post_meta(get_the_ID(),'_associated_junkyard',true);

					endwhile;
				wp_reset_postdata();
				}
			  	//    echo "<pre>";
	// var_dump($junkyards);	  
					$junkyards = array_unique($junkyards);
					 
					?>
<!-- Hero Section -->
<section class="filtering"><img src="<?php echo get_stylesheet_directory_uri();?>/images/seeeda-logo.png" class="pulsate"></section>
<section   id= "search-form">
	<div class="container">
		<div class="search-section-container grey ">
			<form action="<?php echo $pinlink;?>" method="get" class="search-form">
				<div class="search-section">
					<?php echo create_brand_and_model_dropdowns($brand);?>
					<div class="search-item  brand-model-container">
						<label for="parts"><?php echo pll__('Model Year');?></label>
						<?php echo get_model_year_terms_dropdown($smodel_year);?>
					</div>
					<div class="search-item ">
						<label for="parts"><?php echo pll__('Spare Parts');?></label> 
						<?php echo get_spare_part_terms_dropdown($sspare_part);?>
					</div>
					<div class="search-item">
						<label for="parts " class="desktop-view">&nbsp;</label> 
						<button type="button" id="search-now"><?php echo pll__('Search');?></button>
					</div>
				</div>
				<input type="hidden" id="sbrand" value="<?php echo $brand;?>">
				<input type="hidden" id="smodel" value="<?php echo $smodel;?>">
				<input type="hidden" id="wheel-size" name="wheel_size" value="<?php echo $swheel_size;?>">
				<input type="hidden" id="wheel-lug-nut" name="wheel_lug_nut" value="<?php echo $swheel_lug_nut;?>">
				<input type="hidden" id="wheel-type" name="wheel_type" value="<?php echo $swheel_type;?>">
				<input type="hidden" id="sjunkyards" value="<?php echo implode(",",$junkyards);?>">
			</form>
		</div>
	</div>
</section>
<section   id= "search-form">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="sidebar-filter">
				<a href="javascript:void(0)" class="search-close">x</a>
					<h3><?php echo pll__('Search');?></h3>
					<hr> 
					<div class="filter" >
						<h5><?php echo pll__('Search by brand');?></h5>
						<ul class="brand-row row search-brands">
							<?php 
								$brands = get_terms( array(
								'taxonomy' => 'brand',
								'hide_empty' => false,'parent' =>0,'order_by' =>'name','order'=>'desc','lang'=>'en'
								));
								$i = 0;
								// Create the Brand dropdown
								if ( !empty($brands) && !is_wp_error($brands) ) {
									foreach ( $brands as $brand ) 
									{
										$i++;
										$image = get_field('thumbnail', $brand);
										$brand_curr = pll_get_term($brand->term_id, pll_current_language());	
									 
										$brand_curr= get_term($brand_curr, 'brand'); 
								?>
							<li <?php if($i >8 ){ ?>class="hiddenbranditem"<?php } ?>>
								<div class="brand-item filter-item <?php if($sbrand==$brand_curr->term_id){ ?>active<?php } ?>"   filter="brand" item="<?php echo $brand_curr->term_id;?>" >
									<img src="<?php echo $image;?>"> 
								</div>
							</li>
							<?php 
									}
								}
								?>				
						</ul>
						<a href="javascript:void(0)" id="showmorebrands"><span class="hiddenbranditem active"><?php echo pll__('view more');?><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-chevron-24-dn.png"></span><span class="hiddenbranditem ">view less<img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-chevron-24-up.png"></span></a>
						<h5><?php echo pll__('Search by year');?></h5>
						<ul class="brand-row row search-years">
							<?php 
								$model_years = get_terms( array(
									'taxonomy' => 'model-year',
									'hide_empty' => false,'parent' =>0,'order_by' =>'name','order'=>'desc','lang'=>'en'
								));
							// Sort terms by integer value of name
		if ( ! is_wp_error( $terms ) ) {
    usort( $model_years, function( $a, $b ) {
        return intval( $b->name ) - intval( $a->name ); // Change order to descending
    });

   
}
								// Create the Brand dropdown
								if ( !empty($model_years) && !is_wp_error($model_years) ) 
								{
									$i = 0;
									foreach ( $model_years as $model_year ) 
									{ 
										$model_year_curr = pll_get_term($model_year->term_id, pll_current_language());	
									 
										$model_year_curr= get_term($model_year_curr, 'model-year'); 
									  $i++;
									?>
								<li <?php if($i >12 ){ ?>class="hiddencategoryitem"<?php } ?>>
									<div class="brand-item filter-item <?php if($smodel_year==$model_year_curr->term_id){ ?>active<?php } ?>"   filter="model-year" item="<?php echo $model_year_curr->term_id;?>">
										<?php echo $model_year_curr->name;?>
									</div>
								</li>
								<?php 
									}
								}
								?>				
						</ul>
						<a href="javascript:void(0)" id="showmoreyears"><span class="hiddencategoryitem active"><?php echo pll__('view more');?><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-chevron-24-dn.png"></span><span class="hiddencategoryitem ">view less<img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-chevron-24-up.png"></span></a>
						<h5><?php echo pll__('Search by spare parts');?></h5>
						<ul class="brand-row row spare">
							<?php 
							 
				$spare_part_types = get_terms( array(
    'taxonomy'   => 'spare-part-type', // The taxonomy name
    'parent'    => 0,         // Order by term_id
      'hide_empty' => false,             // Show all terms, including empty ones
	'order_by' =>'name','order'=>'ASC','lang'=>'en'
) );
$wheeloptions = "";
if ( ! empty( $spare_part_types ) && ! is_wp_error( $spare_part_types ) ) {
	foreach ( $spare_part_types as $spare_part_type ) {
								
										$image = get_field('thumbnail', $spare_part_type);
										$has_popup_filter = get_field('has_popup_filter', $spare_part_type);
										$pop_up_id = get_field('pop_up_id', $spare_part_type);
											
										if($spare_part_type->name == "Wheels and Tires" && $sspare_part==$spare_part_type->term_id){
											$wheeloptions = "active";
										}
										$spare_part_type_curr = pll_get_term($spare_part_type->term_id, pll_current_language());	
									 
										$spare_part_type_curr= get_term($spare_part_type_curr, 'spare-part-type'); 
										?>
											<li>
												<div class="brand-item <?php if($has_popup_filter =="Yes"){ ?><?php echo $pop_up_id; ?><?php }else{ ?>filter-item<?php } ?>  sp<?php echo $spare_part_type_curr->term_id;?> <?php  if (in_array( $spare_part_type_curr->term_id,$sspare_part))  { ?>active<?php } ?>"  filter="spare-part-type" item="<?php echo $spare_part_type_curr->term_id;?>">
													<img src="<?php echo $image;?>" alt="<?php echo $image;?>" title="<?php echo $spare_part_type_curr->name;?>"> <span class="icon-label"><?php echo $spare_part_type_curr->name;?></span>
												</div>
											</li>
									<?php 
									}
								}
								?>				
						</ul>
						<div class="wheelwidth <?php echo $wheeloptions;?>">
							<h5><?php echo pll__('Search by wheel size');?></h5>
						
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
			<span class="search-for-text"><?php echo $searchfor;?>  </span>
				<ul class="result-header row">
					<li>
					<?php $showing =  pll__('Showing <%SHOWING%> - of <%RESULTS%> results');
					$showing =  str_replace("<%SHOWING%>","<span id='total-row-start'>1</span>",$showing);
					$showing =  str_replace("<%RESULTS%>","<span id='total-pages'>1</span>",$showing);
					?>
					<!--	<span><?php echo $showing;?>  </span>-->
					</li>
					<li>
					<a href="javascript:void(0)" class="show-filter"><img src="<?php echo get_stylesheet_directory_uri();?>/images/filter.png" class="filter-icon"> <?php echo pll__('Filter');?></a>
					</li>
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
						<!--<div class="sort-dropdown">
							<select id="sort-by" class="sort-select">
								<option value="popularity">Sort by Popularity</option>
								<option value="date">Sort by Date</option>
								<option value="price">Sort by Price</option>
							</select>
						</div>-->
					</li>
				</ul>
				<div class="search-result-block row">
					<div class="junkyard-list"> 
						<?php 
							if(count($junkyards )){
								echo fetch_junkyard_posts($junkyards,$sbrand,$smodel,$smodel_year,$sspare_part,$swheel_size,$swheel_lug_nut,$swheel_type);
							}else{
							?>
							<div class="junkyard-item">
								<div class="junkyard-details">
									<h4><?php echo pll__('No Stores found!');?></h4>
								</div>
							</div>
							<?php
								}
								?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="wheel-filter">
<div id="wheel-filter-box"><a href="javascript:void(0)" id="close-wheel-filter">x</a>
<label><?php echo pll__('Wheel Size');?></label>
<ul class="wheel-size-row row">
							<?php 
								$model_years = get_terms(array(
									'taxonomy'   => 'wheel-size',  // Replace with your taxonomy name
									'hide_empty' => false,               // Set to true to hide terms with no posts
									'parent'    =>0 ,              // Order by term name
									'orderby'    => 'name',              // Order by term name
									'fields'     => 'all',               // Get all fields of terms
									'hierarchical' => true,              // Ensure terms are retrieved hierarchically
								));
										  // Loop through the terms and display them as checkboxes
								
								
										  if (!is_wp_error($model_years)) {
											// Sort terms by the numeric part of their names
											usort($model_years, function ($a, $b) {
												// Extract the numeric part from the term names
												$numA = (int) preg_replace('/\D+/', '', $a->name);
												$numB = (int) preg_replace('/\D+/', '', $b->name);
										
												return $numA <=> $numB; // Sort in ascending order
											});
										}
								
								// Create the Brand dropdown
								if ( !empty($model_years) && !is_wp_error($model_years) ) 
								{
									foreach ( $model_years as $model_year ) 
									{ 
									?>
								<li>
									<input type="checkbox" class="wheel_size" value="<?php echo $model_year->term_id;?>">
										<?php echo $model_year->name;?>
								 
								</li>
								<?php 
									}
								}
								?>				
						</ul>
						
						
<label><?php echo pll__('Number of Lug nuts');?></label>
<ul class="wheel-size-row row">
							<?php 
								$model_years = get_terms( array(
									'taxonomy' => 'wheel-lug-nut',
									'hide_empty' => false,'parent' =>0,'order_by' =>'ID','order'=>'desc','number'=>24
								));
								
								// Create the Brand dropdown
								if ( !empty($model_years) && !is_wp_error($model_years) ) 
								{
									foreach ( $model_years as $model_year ) 
									{ 
									?>
								<li>
									<input type="checkbox" class="wheel_lugnut" value="<?php echo $model_year->term_id;?>">
										<?php echo $model_year->name;?>
								 
								</li>
								<?php 
									}
								}
								?>				
						</ul>
						
						<label><label><?php echo pll__('Wheel Type');?></label></label>
<ul class="wheel-size-row row">
						 
								<li>
									<input type="checkbox" class="wheel_type" value="Original">
										<?php echo pll__('Original (OEM)');?>
								 
								</li>
								<li>
									<input type="checkbox" class="wheel_type" value="After-Market">
										<?php echo pll__('After-Market (Non-Original)');?>
								 
								</li>
								 			
						</ul>
<button id="filterwheels"><?php echo pll__('Filter');?></div>
</div>
</div>
<?php
	endwhile;  
	get_footer();?>