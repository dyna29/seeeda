<?php
	/*
	*Template Name: Home Template Bk
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  
	?> 
<!-- Hero Section -->
<section class="  text-center custom-section" id= "parallelogram">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1 class="display-4"><?php echo get_field('banner_top_title');?></h1>
				<p class="lead"><?php echo get_field('banner_sub_title');?></p>
			</div>
			<div class="col-md-6">
				<img src="<?php echo get_field('banner');?>" class="banner-side-image">
			</div>
		</div>
		<div class="search-section-container ">
			<form action="<?php echo site_url('search-results');?>" method="post">
				<div class="search-section">
					<?php echo  create_brand_and_model_dropdowns(0);?>
					<div class="search-item">
						<label for="parts">Model Year</label>
						<?php echo get_model_year_terms_dropdown();?>
					</div>
					<div class="search-item">
						<label for="parts">Spare Parts</label>
						<?php echo get_spare_part_terms_dropdown();?>
					</div>
					<div class="search-item">
						<label for="parts">&nbsp;</label>
						<button type="submit" id="search-now    ">SEARCH</button>
					</div>
				</div>
			</form>
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
<section class="brands" style="background:url(<?php echo get_stylesheet_directory_uri();?>/images/brand-bg.png)">
	<!-- Content Section -->
	<div class="container  ">
		<h2>EXPLORE POPULAR BRANDS</h2>
		<div class="row">
			<div class="col-md-12">
				<ul class="brand-row row">
					<?php 
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
						<div class="brand-item filter-item"  filter="brand" item="<?php echo $brand->term_id;?>">
							<img src="<?php echo $image;?>">
							<h4><?php echo $brand->name;?></h4>
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
	endwhile;  
	get_footer();?>
	 
