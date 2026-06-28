<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Seeeda</title> 
   <meta property="og:title" content="Welcome to Seeeda">
   <meta property="og:description" content="Find Spare Parts Quickly, Easily, and at the Best Prices. Seeeda, Shop Now!">
   <meta property="og:image" content="<?php echo get_stylesheet_directory_uri();?>/images/share-logo.jpg">
   <meta property="og:logo" content="<?php echo get_stylesheet_directory_uri();?>/images/share-logo.jpg" />
   <meta property="og:url" content="https://seeeda.com/">
   <meta property="og:type" content="website">
   <link rel="image_src" href="<?php echo get_stylesheet_directory_uri();?>/images/share-logo.jpg">
    <meta charset="UTF-8"> 
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/images/seeeda-favicon.png">  

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> 
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
 
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
     <?php wp_head();?>  

</head>
<body class="<?php echo pll_current_language();?>">
<header class="sticky-header"> 
  <div class="container">
   
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="<?php echo site_url();?>"><img class="junkyard-logo" src="<?php echo get_stylesheet_directory_uri();?>/images/seeeda-logo.png"></a>
		 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
		<a href="tel:+965 99359196" class="quickcall mobile"><img src="<?php echo get_stylesheet_directory_uri();?>/images/call-ringing.png">+965 99359196</a><?php 
				$current_page_id = get_the_ID(); 
				$template = get_page_template();
			 
						if(pll_current_language()=='en') 
						{ 
					$post_id = pll_get_post( $current_page_id,'ar' );
					$pinlink =  get_permalink($post_id);

					if(basename($template)=="page-search-results.php"){
						$brand = $_REQUEST["brand"];
						$brand_id =  pll_get_term($brand, 'ar');  
						$model = $_REQUEST["model"];
						$model_id =  pll_get_term($model, 'ar');  
						
						$model_year = $_REQUEST["model_year"];
						$model_year_id =  pll_get_term($model_year, 'ar'); 
						$spare_parts = $_REQUEST["spare_part"];
						$sparepartqueryar = array();
						 foreach($spare_parts as $spare_part){
							$spare_part_id =  pll_get_term($spare_part, 'ar');
							$sparepartqueryar[] = "&spare_part[]=".$spare_part_id;
						 }
						
						 $sparepartqueryar = implode("",$sparepartqueryar);
						 
						$wheel_size = $_REQUEST["wheel_size"];
						$wheel_size_id =  pll_get_term($wheel_size, 'ar'); 
						$wheel_lug_nut = $_REQUEST["wheel_lug_nut"];
						$wheel_lug_nut_id =  pll_get_term($wheel_lug_nut, 'ar'); 
						$wheel_type = $_REQUEST["wheel_type"];
						$pinlink = $pinlink."?brand=".$brand_id."&model=".$model_id."&model_year=".$model_year_id.$sparepartqueryar."&wheel_size=".$wheel_size_id."&wheel_lug_nut=".$wheel_lug_nut_id."&wheel_type=".$wheel_type;
					}
						?>
							<a href='<?php echo $pinlink;?> '  class='lang-ar mobile'>
							عربي
							</a>
						<?php 
						} 
						?>
						<?php 
						if(pll_current_language()=='ar') 
						{ 
					
					$post_id = pll_get_post( $current_page_id,'en' );
					$pinlink =  get_permalink($post_id);

					if(basename($template)=="page-search-results.php"){
						$brand = $_REQUEST["brand"];
						$brand_id =  pll_get_term($brand, 'en');  
						$model = $_REQUEST["model"];
						$model_id =  pll_get_term($model, 'en');  
						
						$model_year = $_REQUEST["model_year"];
						$model_year_id =  pll_get_term($model_year, 'en'); 
						$spare_parts = $_REQUEST["spare_part"];
						$sparepartqueryar = array();
						 foreach($spare_parts as $spare_part){
							$spare_part_id =  pll_get_term($spare_part, 'en');
							$sparepartqueryar[] = "&spare_part[]=".$spare_part_id;
						 }
						
						 $sparepartqueryar = implode("",$sparepartqueryar);
						 
						$wheel_size = $_REQUEST["wheel_size"];
						$wheel_size_id =  pll_get_term($wheel_size, 'en'); 
						$wheel_lug_nut = $_REQUEST["wheel_lug_nut"];
						$wheel_lug_nut_id =  pll_get_term($wheel_lug_nut, 'en'); 
						$wheel_type = $_REQUEST["wheel_type"];
						$pinlink = $pinlink."?brand=".$brand_id."&model=".$model_id."&model_year=".$model_year_id.$sparepartqueryar."&wheel_size=".$wheel_size_id."&wheel_lug_nut=".$wheel_lug_nut_id."&wheel_type=".$wheel_type;
					}
						?> 
							<a href='<?php echo $pinlink;?>' class='lang-en mobile'>
								English
							</a>
						<?php 
						} 
						?>
       
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
				<?php 
					$post_id = pll_get_post( 2,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?>
                    <a class="nav-link" href="<?php echo $pinlink;?>"><?php echo pll__('Home');?></a>
                </li>
				<?php 
					$post_id = pll_get_post( 126,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?> 
				<?php 
					$post_id = pll_get_post( 229,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $pinlink;?>"><?php echo pll__('Brands');?></a>
                </li>
				<?php 
					$post_id = pll_get_post( 234,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $pinlink;?>"><?php echo pll__('Spare Parts');?></a>
                </li>
				<?php 
					$post_id = pll_get_post( 161,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $pinlink;?>"><?php echo pll__("Seller's Help");?></a>
                </li>
				<?php 
					$post_id = pll_get_post( 231,pll_current_language() );
					$pinlink =  get_permalink($post_id);
				?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $pinlink;?>"><?php echo pll__('Contact Us');?></a>
                </li>
            </ul>
				<div class="flags">
			<?php
// Get the page by slug 'header-options'
$page = get_page_by_path('header-options');

// Check if the page exists and has the repeater field 'countries'
if ($page && have_rows('countries', $page->ID)) {
    // Loop through the repeater field rows
    while (have_rows('countries', $page->ID)) {
        the_row();
        
        // Get the subfields
        $country = get_sub_field('country');
        $flag = get_sub_field('flag'); // Assuming this is an image field
        $location = get_sub_field('location');
      ?>
	  	<div class="flag">
			<a href="<?php echo $location;?>" target="_blank">
				<img class="kuwaitlogo" src="<?php echo $flag;?>" alt="<?php echo $country;?>" title="<?php echo $country;?>">
			</a>
		</div>
	  <?php
        
    }
}  
?>

		</div>
	
			<a href="tel:+965 99359196" class="quickcall desktop"><img src="<?php echo get_stylesheet_directory_uri();?>/images/call-ringing.png">+965 99359196</a>
				<?php 
				
                
						if(pll_current_language()=='en') 
						{ 
					$post_id = pll_get_post( $current_page_id,'ar' );
					$pinlink =  get_permalink($post_id);
                  
					if(basename($template)=="page-search-results.php"){
						$brand = $_REQUEST["brand"];
						$brand_id =  pll_get_term($brand, 'ar');  
						$model = $_REQUEST["model"];
						$model_id =  pll_get_term($model, 'ar');  
						
						$model_year = $_REQUEST["model_year"];
						$model_year_id =  pll_get_term($model_year, 'ar'); 
						$spare_parts = $_REQUEST["spare_part"];
						$sparepartqueryar = array();
						 foreach($spare_parts as $spare_part){
							$spare_part_id =  pll_get_term($spare_part, 'ar');
							$sparepartqueryar[] = "&spare_part[]=".$spare_part_id;
						 }
						
						 $sparepartqueryar = implode("",$sparepartqueryar);
						 
						$wheel_size = $_REQUEST["wheel_size"];
						$wheel_size_id =  pll_get_term($wheel_size, 'ar'); 
						$wheel_lug_nut = $_REQUEST["wheel_lug_nut"];
						$wheel_lug_nut_id =  pll_get_term($wheel_lug_nut, 'ar'); 
						$wheel_type = $_REQUEST["wheel_type"];
						$pinlink = $pinlink."?brand=".$brand_id."&model=".$model_id."&model_year=".$model_year_id.$sparepartqueryar."&wheel_size=".$wheel_size_id."&wheel_lug_nut=".$wheel_lug_nut_id."&wheel_type=".$wheel_type;
					}
				 
						?>
							<a href='<?php echo $pinlink;?> '  class='lang-ar desktop'>
							عربي
							</a>
						<?php 
						} 
						?>
						<?php 
						if(pll_current_language()=='ar') 
						{ 
					
						$post_id = pll_get_post( $current_page_id,'en' );
						$pinlink =  get_permalink($post_id);

						if(basename($template)=="page-search-results.php"){
							$brand = $_REQUEST["brand"];
							$brand_id =  pll_get_term($brand, 'en');  
							$model = $_REQUEST["model"];
							$model_id =  pll_get_term($model, 'en');  
							
							$model_year = $_REQUEST["model_year"];
							$model_year_id =  pll_get_term($model_year, 'en'); 
							$spare_parts = $_REQUEST["spare_part"];
							$sparepartqueryar = array();
							 foreach($spare_parts as $spare_part){
								$spare_part_id =  pll_get_term($spare_part, 'en');
								$sparepartqueryar[] = "&spare_part[]=".$spare_part_id;
							 }
							
							 $sparepartqueryar = implode("",$sparepartqueryar);
							 
							$wheel_size = $_REQUEST["wheel_size"];
							$wheel_size_id =  pll_get_term($wheel_size, 'en'); 
							$wheel_lug_nut = $_REQUEST["wheel_lug_nut"];
							$wheel_lug_nut_id =  pll_get_term($wheel_lug_nut, 'en'); 
							$wheel_type = $_REQUEST["wheel_type"];
							$pinlink = $pinlink."?brand=".$brand_id."&model=".$model_id."&model_year=".$model_year_id.$sparepartqueryar."&wheel_size=".$wheel_size_id."&wheel_lug_nut=".$wheel_lug_nut_id."&wheel_type=".$wheel_type;
						}
						?> 
							<a href='<?php echo $pinlink;?>' class='lang-en desktop'>
								English
							</a>
						<?php 
						} 
						?>
        </div>
    </nav>
        </div> 
    </header>
      