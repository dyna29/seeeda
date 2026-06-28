<?php
	/*
	*Template Name: Contact Us Template
	*/ 
	get_header();
	 
	 while ( have_posts() ) : the_post();
	 $homefeaturedimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	 $contact_en_id = pll_get_post( get_the_ID(),'en' ); 
					 
					?>
<!-- Hero Section -->
<section class="filtering"><img src="<?php echo get_stylesheet_directory_uri();?>/images/junkyard-placeholder.png" class="pulsate"></section>
 
<section   id= "contact-us">
	
<!-- Include Bootstrap CSS (Add this in the <head> section of your theme) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container ">
    <h2 class="text-center "><?php echo pll__("Contact Us");?></h1>
    
    <div class="row">
        <!-- Left Column: Contact Info and Map -->
        <div class="col-md-12"> 
            <p class="center-align"><?php echo pll__("If you have any questions, feel free to reach out to us!");?></p>
            
            <ul class="contact-info">
				<li><p><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-phone-30.png" > <a href="tel:<?php echo  get_field('phone_no',$contact_en_id); ?>"><?php echo  get_field('phone_no'); ?></a></p></li>
				<li><p><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-mail-50.png" > <a href="mailto:info@seeeda.com">info@seeeda.com</a></p></li>
			</ul>
              <ul class="contact-info">
				<li><p><img src="<?php echo get_stylesheet_directory_uri();?>/images/icons8-location.png" > <a href="https://maps.app.goo.gl/DHdvi6mifkZcKF6Y6?g_st=iw" target="_blank">Al Sharqiya Tower, Basement, Office 17, Jaber Al Mubarak Street, Block 2, Sharq, Kuwait.
</a></p></li>
				 	</ul>
            
             
            <!-- Replace the src link with your Google Maps embed link -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3476.5355945664323!2d47.988246499999995!3d29.383884199999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf854b3b713747%3A0x788ed852f0c7f537!2z2KjYsdisINin2YTYtNix2YLZitipIFNoYXJxeWlhIFRvd2Vy!5e0!3m2!1sen!2sin!4v1736312209049!5m2!1sen!2sin" 
                width="100%" 
                height="250" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" class="map"></iframe>
        </div>
        
      
    </div>
</div>
 

</div>
</section>
<?php
	endwhile;  
	get_footer();?>