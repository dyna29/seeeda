<?php
	/*
	*Template Name: Seller's Help Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	  
					 
					?>
<!-- Hero Section -->
<section class="filtering"><img src="<?php echo get_stylesheet_directory_uri();?>/images/junkyard-placeholder.png" class="pulsate"></section>
 
<section   id= "sellers-help">
	
<div class="container">
   
		<h2><?php echo pll__("Seller's Help");?></h2>

    <!-- Seller Section -->
    <div class="seller-section">
        <!-- Bootstrap Row for Layout -->
        <div class="row">
            <!-- First Image -->
            <div class="col-md-4">
                <img class="seller-image" src="<?php echo get_field('image_left');?>" alt="Seller Image 1">
            </div>

            <!-- Description -->
            <div class="col-md-4 d-flex align-items-center ">
                <?php the_field('content');?>
            </div>

            <!-- Second Image -->
            <div class="col-md-4">
                <img class="seller-image seller-image2  " src="<?php echo get_field('image_right');?>" alt="Seller Image 2">
            </div>
        </div>

        <!-- Contact Info Section -->
        <div class="contact-info pt-4 border-top">
		
		  <div class="row">
            <!-- First Image -->
            <div class="col-md-12">
			
               <div class="sellerform">
			     <h3><?php echo pll__("Seller Registration Form");?></h3>
				 <?php if(pll_current_language()=="en"){ ?>
			   <?php echo do_shortcode('[contact-form-7 id="db61c22" title="Seller Form"]');?>
				 <?php } ?>
				 <?php if(pll_current_language()=="ar"){ ?>
			   <?php echo do_shortcode('[contact-form-7 id="ebe1fda" title="Seller Form (AR)"]');?>
			   <?php } ?>
			   
			   </div>
            </div>

            <!-- Description -->
            <div class="col-md-12  ">
             <h3 class="seller-contact-info-title"><?php echo pll__("Contact Information");?></h3>
          <ul class="sellercontact"><li><p><strong><?php echo pll__("Phone");?>:</strong> <a href="tel:<?php echo get_field('phone');?>"><?php echo get_field('phone');?></a></p></li><li><p><strong><?php echo pll__("Email");?>:</strong> <a href="mailto:seller@example.com"><?php echo get_field('e_mail');?></a></p></li></ul>
        
            </div>

          
            </div>
    </div>
</div>
</section>
<?php
	endwhile;  
	get_footer();?>