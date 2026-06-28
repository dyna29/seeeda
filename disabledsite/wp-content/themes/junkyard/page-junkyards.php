<?php
	/*
	*Template Name: Junkyards Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  
					 
					?>
<!-- Hero Section -->
<section class="filtering"><img src="<?php echo get_stylesheet_directory_uri();?>/images/junkyard-placeholder.png" class="pulsate"></section>
 
<section   id= "junkyards">
	 
		<h2><?php echo pll__('Junkyards');?></h2>
	<div class="container">
		<div class="row"> 
			<div class="col-md-12">
		 
				<div class="search-result-block row">
					<div class="junkyard-list"> 
						<?php 
						 
								echo fetch_all_junkyard_posts();
							 
							?>
						 
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
	endwhile;  
	get_footer();?>