<?php
	/*
	*Template Name: Home Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  
 	$post_id = pll_get_post( 110,pll_current_language() );
					$pinlink =  get_permalink($post_id);
 ?>	
<!-- Hero Section -->
<section class="  text-center custom-section" id= "parallelogram">
	<div class="container">
		<div class="row">
		
			<div class="col-md-6 mobile-view">
			<h1 class="display-4  mobile-view"><?php echo get_field('banner_top_title');?></h1> 
				<img src="<?php echo get_stylesheet_directory_uri();?>/images/seeeda-banner.png" class="banner-side-image">
			</div>
			<div class="col-md-6">
				<h1 class="display-4 desktop-view"><?php echo get_field('banner_top_title');?></h1> 
					<div class="search-section-container ">
		 	<form action="<?php echo $pinlink;?>" method="get" class="search-form">
				<div class="search-section home">
					<?php echo  create_brand_and_model_dropdowns(0);?>
					<div class="search-item  brand-model-container">
						<label for="parts"><?php echo pll__('Model Year');?></label>
						<?php echo get_model_year_terms_dropdown();?>
					</div>
					<div class="search-item brand-model-container">
						<label for="parts"><?php echo pll__('Spare Parts');?></label>
						<?php echo get_spare_part_terms_dropdown();?>
					</div>
					<div class="search-item"> 
						<button type="button" id="search-now"><?php echo pll__('Search');?></button>
					</div>
					<div class="search-item"> 		</div>
				</div>
			</form> 
		</div>
			</div>
			<div class="col-md-6 desktop-view">
				<img src="<?php echo get_stylesheet_directory_uri();?>/images/seeeda-banner.png" class="banner-side-image">
			</div>
		</div>
	
	</div>
</section>
 <style>
        .model-year, .spare-category, .spare-parts, .back-arrow {
            display: none;
            margin-top: 10px;
        }
        .back-arrow {
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
        }.btn-primary:hover {
    color:  #000 !important;
    background-color: #fff !important;
    border-color: #000 !important;
}.btn-primary {
    color:  #000 !important;
    background-color: #fff !important;
    border-color: #000 !important;
}
    </style>
	<?php
if(get_post_meta(2,'disable_ad',true) =="No"){	
	if( get_field('ad_banner') !=""){ ?>
	<section class="ad-banner" >
	<!-- Content Section -->
 
				 <a href="<?php echo get_field('ad_link');?>" target="_blank"><div class="ad-banner-block" style="background:url(<?php echo get_field('ad_banner');?>)"></div></a>
			 
</section>
	<?php }
 }
?>
<section class="brands" style="background:url(<?php echo get_stylesheet_directory_uri();?>/images/brand-bg.png)">
	<!-- Content Section -->
	<div class="container  ">
		<h2><?php echo pll__('EXPLORE POPULAR BRANDS');?></h2>
		<div class="row">
			<div class="col-md-12">
				<ul class="brand-row row">
					<?php /*
						$brands = get_terms( array(
						'taxonomy' => 'brand',
						'hide_empty' => false,'parent' =>0
						));
						
						// Create the Brand dropdown
						if ( !empty($brands) && !is_wp_error($brands) ) {
						foreach ( $brands as $brand ) {
						 $image = get_field('thumbnail', $brand);
						?>
					<li>
							<div class="brand-item filter-item-pop"  filter="brand" item="<?php echo $brand->term_id;?>"  data-toggle="modal" data-target="#searchModal">
						<img src="<?php echo $image;?>">
							<h4><?php echo $brand->name;?></h4>
						</div>
					</li>
					<?php 
						}
						} */


						
// Step 1: Get terms where ACF field 'manufacturing_origin' is 'Chinese'
$chinese_brands = get_terms([
    'taxonomy'   => 'brand',
    'hide_empty' => false,'parent' =>0, 'order_by' =>'name','order'=>'desc','lang'=>'en',
    'meta_query' => [
        [
            'key'     => 'manufacturing_origin', // ACF field name
            'value'   => 'Chinese',
            'compare' => '='
        ]
    ]
]);

// Step 2: Get all terms from the 'brand' taxonomy
$all_brands = get_terms([
    'taxonomy'   => 'brand',
    'hide_empty' => false,'parent' =>0,'order_by' =>'name','order'=>'desc','lang'=>'en',
]);

// Step 3: Filter out the Chinese brands from the complete list
$rest_brands = array_filter($all_brands, function ($term) use ($chinese_brands) {
    foreach ($chinese_brands as $chinese_brand) {
        if ($term->term_id === $chinese_brand->term_id) {
            return false;
        }
    }
    return true;
});

// Step 4: Loop through the results
 
if (!empty($chinese_brands)) {
    foreach ($chinese_brands as $brand) {
		$image = get_field('thumbnail', $brand); 
										$brand_curr = pll_get_term($brand->term_id, pll_current_language());	
									 
										$brand_curr= get_term($brand_curr, 'brand');
         ?>
		 <li>
							<div class="brand-item filter-item-pop"  filter="brand" item="<?php echo $brand_curr->term_id;?>"  data-toggle="modal" data-target="#searchModal">
						<img src="<?php echo $image;?>">
							<h4><?php echo $brand_curr->name;?></h4>
						</div>
					</li>
		 <?php
    }
}  

 
if (!empty($rest_brands)) {
    foreach ($rest_brands as $brand) {
		$image = get_field('thumbnail', $brand);
		$brand_curr = pll_get_term($brand->term_id, pll_current_language());	
									 
										$brand_curr= get_term($brand_curr, 'brand');
		?>
		<li>
						   <div class="brand-item filter-item-pop"  filter="brand" item="<?php echo $brand_curr->term_id;?>"  data-toggle="modal" data-target="#searchModal">
					   <img src="<?php echo $image;?>">
						   <h4><?php echo $brand_curr->name;?></h4>
					   </div>
				   </li>
		<?php
    }
}  
 
						?>				
				</ul> 
			</div>
		</div>
	</div>
</section>
  
<?php 
 
$post_id = pll_get_post( 110,pll_current_language() );
					$pinlink =  get_permalink($post_id);
?>
 
<?php 
$post_id = pll_get_post( 110,pll_current_language() );
					$pinlink =  get_permalink($post_id);
?>
<style>
    .modal-dialog {
        max-width: 80%;
        margin: 1.75rem auto;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form action="<?php echo $pinlink;?>" method="post" class="search-form-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       			<div class="search-section-container ">
		
				<div class="search-section home">
					<?php echo  create_brand_and_model_dropdowns_2(0);?>
					<div class="search-item  brand-model-container">
						<label for="parts"><?php echo pll__('Model Year');?></label>
						<?php echo get_model_year_terms_dropdown_2();?>
					</div>
					<div class="search-item brand-model-container">
						<label for="parts"><?php echo pll__('Spare Parts');?></label>
						<?php echo get_spare_part_terms_dropdown_2();?>
					</div>
				 
					<div class="search-item"> 		</div>
				</div>
			
		</div>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-primary" id="search-now-2"><?php echo pll__('Search');?></button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php

 

	endwhile;  
	get_footer();?>
	 
