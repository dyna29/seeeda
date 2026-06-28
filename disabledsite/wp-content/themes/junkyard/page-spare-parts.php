<?php
	/*
	*Template Name: Spare Parts Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  
					 
					?>
<!-- Hero Section --> 
 
<section class="brands"  >
<form action="<?php echo site_url('search-results');?>" method="post" style="display:none">
				<div class="search-section home">
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
						<button type="submit" id="search-now">SEARCH</button>
					</div>
					<div class="search-item"> 		</div>
				</div>
			</form>
	<!-- Content Section -->
	<div class="container  ">
		<h2><?php echo pll__('EXPLORE BY SPARE PARTS');?></h2>
		<div class="row">
			<div class="col-md-12">
				<ul class="brand-row row spare single">
					<?php 
						$spareparttypes = get_terms( array(
						'taxonomy' => 'spare-part-type',
						'hide_empty' => false,'parent' =>0
						));
						
						// Create the Brand dropdown
						if ( !empty($spareparttypes) && !is_wp_error($spareparttypes) ) {
						foreach ( $spareparttypes as $spare_part_type ) {
						 $image = get_field('thumbnail', $spare_part_type);
						?>
					<li>
						<div class="brand-item spare-part-item filter-item sp<?php echo $spare_part_type->term_id;?>  "  filter="spare-part-type" item="<?php echo $spare_part_type->term_id;?>">
													<img src="<?php echo $image;?>" alt="<?php echo $image;?>" title="<?php echo $spare_part_type->name;?>">
<span class="label"><?php echo $spare_part_type->name;?></span>													
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