<?php


function fetch_junkyard_posts($junkyards,$sbrand,$smodel,$smodel_year,$sspare_part,$swheel_size,$swheel_lug_nut,$swheel_type,$paged = 1) {
	 
	 $args = array(
        'post_type' => 'junkyard',  // Your custom post type
        'posts_per_page' => -1,      // Limit the number of posts
		'post__in'       => $junkyards,
               
    );

 
    $query = new WP_Query($args);
 
    if ($query->have_posts()) {
  $i=0;
        while ($query->have_posts()) {  $query->the_post();
			$i++;
			
		}
	}
    $args = array(
        'post_type' => 'junkyard',  // Your custom post type
        'posts_per_page' => 5,      // Limit the number of posts
        'paged' => $paged , 
		'post__in'       => $junkyards,           // Current page number
    );
	 
      $start = ($paged * 5) - 4;
	  $end = $start;
	  
    $query = new WP_Query($args);
$html ="";
    if ($query->have_posts()) {
  
			
			 $html  = $html . '<div class="junkyard-item-container">';
			 
			  $html  = $html . '<div class="junkyard-item-row header">';
			 $html  = $html . '<div class="junkyard-item">';  
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">';
			$html  = $html . '<strong>'.pll__('Name of Store').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">';
			$html  = $html . '<strong>'.pll__('Location').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">';
			$html  = $html . '<strong>'.pll__('Vehicle Available').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">';
			$html  = $html . '<strong>'.pll__('Spare parts Available').'</strong>'; 
			$html  = $html . '</div>'; ;
			$html  = $html . '</div>';  
		 while ( $query->have_posts() ) : $query->the_post();	
			
			 
			
			$currentid = get_the_ID();
			$show_in_listing = get_field('show_in_listing',$currentid);
  if($show_in_listing != "No"){
  if($sbrand !=0 && $sbrand !=""){
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $sbrand ),
				);
				 $searchfor[] = "brand <strong>'".get_term( $sbrand )->name."'</strong> ";
			}
	 
		 
			if($smodel !=0 && $smodel !=""){
			 $tax_query[] = array(
				'taxonomy' => 'brand',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $smodel ),
			);
			
				 
			} 
	 
			if($smodel_year !=0 && $smodel_year !=""){
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $smodel_year ),
			);
			}
			 
		 
			if( count($sspare_part)){
			 $tax_query[] = array(
				'taxonomy' => 'spare-part-type',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    =>  $sspare_part ,
			);
			}
			if($swheel_size !=0 && $swheel_size !=""){
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_size ),
			);
			}
		
		//get no of vehicles found	  
		$junkyard_curr = pll_get_post( get_the_ID(),'en' );
					$pinlink =  get_permalink($post_id);
		$args2 = array(
			'post_type' => array('vehicle'), 
			'posts_per_page' => -1, // Get all posts
			'lang' => pll_current_language(), // Get all posts
			'meta_query' => array(
				array(
					'key'     => '_associated_junkyard',       // The custom field key
					'value'   => $junkyard_curr,          // The value to compare 
					'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
				),
			),
		);
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
		// Only add the tax_query if there are conditions
		if ( !empty( $tax_query ) ) {
 	$args2['tax_query'] = $tax_query;
	 	$args2['tax_query'][] = array('relation'=>'AND'); 
		}
if ( !empty(  $meta_query ) ) {
			 		$args2['meta_query'] = $meta_query;
		 	$args2['meta_query'][] = array('relation'=>'AND'); 
				}
				
			//	echo pll_current_language();
		 	//  echo "<pre>";
		// var_dump( $tax_query);
		// var_dump($args2);
		$cquery = new WP_Query($args2);
		$v=0;
 
		if ( $cquery->have_posts() ) :
			while ( $cquery->have_posts() ) : $cquery->the_post();
//echo "counting...";
				$v++;
			endwhile;
			wp_reset_postdata();
		endif;	
		// Define the query arguments
		$args2 = array(
			'post_type' => array('spare-part','vehicle'),
			'meta_query' => array(
			array(
				'key' => '_associated_junkyard',
				'value' => $junkyard_curr,
				'compare' => '='
			)
			),
			'posts_per_page' => -1 // Get all matching posts
		);
 
		// Run the query

		$query2 = new WP_Query($args2);
 $spimgs = "";
		// Loop through the results
		if ($query2->have_posts()) {
			$spimgs = "<ul class='sp-avail'>";
			$spimgsarr = array();
			while ($query2->have_posts()) {
				$query2->the_post();
 $curr_junkyard  = pll_get_post( $currentid,'en' );
				// Get the taxonomy terms for the current post
				$terms = get_the_terms(get_the_ID(), 'spare-part-type');

				if ($terms && !is_wp_error($terms)) {
					foreach ($terms as $term) {
						if($term->parent==0){
							$spimgsarr[] = "<li><img src='".get_field('thumbnail', $term)."' ></li>";
						}
					}
				}
			}
			$spimgsarr = array_unique($spimgsarr);
			$spimgsarr = implode("",$spimgsarr);
			$spimgs = $spimgs.$spimgsarr."</ul>";
		}

		 
			 $featuredimage = wp_get_attachment_image_src(get_post_thumbnail_id($currentid), 'full');
            // Output your post content here 
			
			 if(is_null($featuredimage[0])){
				  $junkyard_image = get_stylesheet_directory_uri().'/images/junkyard-placeholder.png';
			 }else{
				 $junkyard_image = $featuredimage[0];
			 }
			$show_more_details = get_field('show_more_details',$currentid);
			$showclass="";
			if($show_more_details=="Yes"){
				$showclass="go-to-junkyard";
			}
			 $html  = $html . '<div class="junkyard-item-row desktop-view">';
			 $html  = $html . '<div class="junkyard-item first">'; 
			 	if(get_field('delivery_available',$currentid)=="Yes"){
			 $html  = $html . ' <div class="delivery-label">';
         $html  = $html . pll__('Delivery Available');
     $html  = $html . '</div>';
				}
				
				
			$html  = $html . '<a href="javascript:void(0)" junkyard="'.get_permalink($currentid).'" class="'.$showclass.'"><img src="'.$junkyard_image.'" alt="Junkyard Logo" class="junkyard-logo"></a>';
					$html  = $html . '<div class="  junkyard-actions">';
			$html  = $html . '<strong><a  target="_blank" class="whatsapp-call" junkyard="'.$curr_junkyard.'" href="https://api.whatsapp.com/send?phone='.get_field('whatsapp',$currentid).' &amp;text=I%27d%20have%20an%20enquiry...."><img src="'.get_stylesheet_directory_uri().'/images/icons8-whatsapp-logo-24.png"></a> ';
			$html  = $html . '<a  target="_blank" href="tel:'.get_field('phone',$currentid).' " class="phone-call" junkyard="'.$curr_junkyard.'" ><img src="'.get_stylesheet_directory_uri().'/images/icons8-phone-48.png"></i></a>';
			$html  = $html . '<a href="'.get_field('google_location',$currentid).'" target="_blank"><img src="'.get_stylesheet_directory_uri().'/images/icons8-location-48.png"></a></strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">'; 
			$html  = $html . '<p>'.get_the_title($currentid).'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">'; 
			$html  = $html . '<p>'.get_field('address',$currentid).'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">'; 
			$html  = $html . '<p>'.$v.'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">';
			
			$html  = $html . '<p>'.$spimgs.'</p>';
			$html  = $html . '</div>';
	
		 
			
			$html  = $html . '</div>'; 
			 $html  = $html . '<div class="junkyard-item-row mobile-view">';
			 $html  = $html . '<div class="junkyard-item first">'; 
			
			$html  = $html . '<a href="javascript:void(0)" junkyard="'.get_permalink($currentid).'" class="'.$showclass.'"><img src="'.$junkyard_image.'" alt="Junkyard Logo" class="junkyard-logo"></a>';
					$html  = $html . '<div class="  junkyard-actions">';
			$html  = $html . '<strong><a   target="_blank" class="whatsapp-call" junkyard="'.$curr_junkyard.'"  href="https://api.whatsapp.com/send?phone='.get_field('whatsapp',$currentid).' &amp;text=I%27d%20have%20an%20enquiry...."><img src="'.get_stylesheet_directory_uri().'/images/icons8-whatsapp-logo-24.png"></a> ';
			$html  = $html . '<a target="_blank" href="tel:'.get_field('phone',$currentid).' "  class="phone-call" junkyard="'.$curr_junkyard.'"><img src="'.get_stylesheet_directory_uri().'/images/icons8-phone-48.png"></i></a>';
			$html  = $html . '<a href="'.get_field('google_location',$currentid).'" target="_blank"><img src="'.get_stylesheet_directory_uri().'/images/icons8-location-48.png"></a></strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-item">'; 
		$html  = $html . '<h4>'.get_the_title($currentid).'</h4>';
				$html  = $html . '<p>'.get_field('address',$currentid).'</p>';
				 	if(get_field('delivery_available',$currentid)=="Yes"){
			 $html  = $html . ' <div class="delivery-label">';
         $html  = $html . pll__('Delivery Available');
     $html  = $html . '</div>';
				}
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-item">'; 
			$html  = $html . '<p><strong>'.pll__('Vehicle Available').':</strong> '.$v.'</p>';
	 
			
			$html  = $html . '<p><strong>'.pll__('Spare parts Available').':</strong>'.$spimgs.'</p>';
			$html  = $html . '</div>';
	
		 
			
			$html  = $html . '</div>'; 
          $end++;
  }
        endwhile;
$end--;
        // Pagination
        $total_pages = $query->max_num_pages;
		     $html  = $html . '</div>';
		
        if ($total_pages > 1) {
            $html  = $html . '<div class="pagination" total_pages="'.$total_pages.'"   totalcount="'.$i.'"    start-row ="'.$start.'"  end-row ="'.$end.'" >';
            for ($i = 1; $i <= $total_pages; $i++) {
				$active = "";
				if($paged==$i){
					$active = "active";
				}
                $html  = $html . '<span class="page-numbers '.$active.'" data-page="' . $i . '"  >' . $i . '</span>';
            }
            $html  = $html . '</div>';
        }

        wp_reset_postdata();  // Restore original post data
		 
        return $html; // Return the buffered content
		
    } else {
        return 'No junkyard posts found.';
    }
}



function load_junkyard_posts() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1; // Get the page number from the AJAX request
    $junkyards = $_POST['junkyards'] ; // Get the page number from the AJAX request
    $sbrands = $_POST['sbrands'] ; // Get the page number from the AJAX request
    $smodel = $_POST['smodel'] ; // Get the page number from the AJAX request
    $smodel_year = $_POST['smodel_year'] ; // Get the page number from the AJAX request
    $sspare_part = $_POST['sspare_part'] ; // Get the page number from the AJAX request
    $swheel_size = $_POST['swheel_size'] ; // Get the page number from the AJAX request
    $swheel_lug_nut = $_POST['swheel_lug_nut'] ; // Get the page number from the AJAX request
    $swheel_type = $_POST['swheel_type'] ; // Get the page number from the AJAX request
		 
	$junkyards = explode(",",$junkyards);
 
     $html = fetch_junkyard_posts($junkyards,$sbrands,$smodel,$smodel_year,$sspare_part,$swheel_size,$swheel_lug_nut,$swheel_type,$paged);
	$result = 1;
    echo json_encode(array(
        'html' => $html,
        'paging' => $paged 
    ));
    wp_die();  // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_load_junkyard_posts', 'load_junkyard_posts');
add_action('wp_ajax_nopriv_load_junkyard_posts', 'load_junkyard_posts'); // For non-logged in users




function fetch_spare_posts($brand,$model,$model_year,$spare_category,$swheel_size,$swheel_lug_nut,$swheel_type,$junkyard,  $paged = 1) {
	$junkyard = pll_get_post( $junkyard,'en' );
		if($brand !=""){
			 
		 
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $brand ),
				);
				 $searchfor = "brand  '".get_term( $sbrand )->name."'";
		}  
		 if($model !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'brand',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model ),
			);
		} 
		if($model_year !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model_year ),
			);
		} 
		if($swheel_size !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_size ),
			);
		} 
		if($swheel_lug_nut !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-lug-nut',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_lug_nut ),
			);
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
		
		
				$args = array(
					'post_type' => array('spare-part'), 
					'posts_per_page' => -1, // Get all posts
							'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
				);



				// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				}
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				
 
 
    $query = new WP_Query($args);
 
    if ($query->have_posts()) {
  $i=0;
        while ($query->have_posts()) {  $query->the_post();
			$i++;
			 
		}
	}
    $args = array(
        'post_type' => array('spare-part'),   // Your custom post type
        'posts_per_page' => -1,      // Limit the number of posts
        'paged' => $paged ,  
 'orderby' => 'modified', // Order by the post modified date
    'order' => 'DESC',       // Order in descending order (latest first)
		'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
    );
		// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				} 
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				
				
				 
      $start = ($paged * 5) - 4;
	  $end = $start;
    $query = new WP_Query($args);
$html ="";
    if ($query->have_posts()) {
   $html  = $html . '<div class="vehicle-spare-list-box">';
      $html  = $html . '<h4>Spare parts Found</h4>';
   
			 $html  = $html . '<div class="junkyard-details-row header">';
			 $html  = $html . '<div class="junkyard-items">';  
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Item Name').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Brand').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Model').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Year').'</strong>'; 
			$html  = $html . '</div>';  
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Cost').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '</div>';
        while ($query->have_posts()) {
            $query->the_post();
			 $featuredimage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'ful');
            // Output your post content here 
			
			 if(is_null($featuredimage[0])){
				  $vs_image = get_stylesheet_directory_uri().'/images/junkyard-placeholder.png';
			 }else{
				 $vs_image = $featuredimage[0];
			 }
			 
			  $brand = wp_get_post_terms(get_the_ID(), 'brand', array("fields" => "all"));
			  $model_year = wp_get_post_terms(get_the_ID(), 'model-year', array("fields" => "all"));
				$brands_hierarchy = get_post_terms_hierarchy(get_the_ID(), 'brand'); 
 
 
			 
		       $vs_image = get_field('thumbnail', $brands_hierarchy["parent"]);
			 $html  = $html . '<div class="junkyard-details-row desktop-view">';
		 $html  = $html . '<div class="junkyard-items">'; 
			 	$html  = $html . '<img src="'.$vs_image.'" alt="Store Logo" class="junkyard-logo">';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_the_title().'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$brands_hierarchy["parent"]->name.'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$brands_hierarchy["child"]->name.'</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$model_year[0]->name.'</p>';
			$html  = $html . '</div>';  
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_field('cost').' KWD</p>';
			
			$html  = $html . '</div>'; 
			 
			$html  = $html . '</div>'; 
			
			 $html  = $html . '<div class="junkyard-details-row mobile-view">'; 
	 
			 $html  = $html . '<div class="junkyard-items">'; 
			 $html  = $html . '<div class="junkyard-thumb">'; 
			 
		 	$html  = $html . '<img src="'.$vs_image.'" alt="Store Logo" class="junkyard-logo">'; 
			$html  = $html . '</div>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<h5>'.get_the_title().'</h5>'; 
			$html  = $html . '<p>'.$brand[0]->name.' '.$brand[1]->name.' '.$model_year[0]->name.'</p>'; 
			$html  = $html . '<p>'.get_field('engine_type').'</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_field('cost').' KWD</p>';
			$html  = $html . '</div>'; 
			 
          $end++;
        }
$end--;


			$html  = $html . '</div>'; 
        // Pagination
        $total_pages = $query->max_num_pages;
		
		
        if ($total_pages > 1) {
            $html  = $html . '<div class="pagination" total_pages="'.$total_pages.'"   totalcount="'.$i.'"    start-row ="'.$start.'"  end-row ="'.$end.'" >';
            for ($i = 1; $i <= $total_pages; $i++) {
				$active = "";
				if($paged==$i){
					$active = "active";
				}
                $html  = $html . '<span class="vs-page-numbers '.$active.'" data-page="' . $i . '"  >' . $i . '</span>';
            }
            $html  = $html . '</div>';
        }

        wp_reset_postdata();  // Restore original post data
		 
        return $html; // Return the buffered content
		
    }  
}



       // Recursive function to display terms in hierarchical order
        function display_terms_hierarchical($terms, $parent_id = 0, $level = 0) {
            foreach ($terms as $term) {
                if ($term->parent == $parent_id) {
                    // $html .= str_repeat('----', $level); // Indentation for hierarchy
                     if($parent_id==0){ $html .= '<span class="bullet-span parent-level">  ' . esc_html($term->name) . '</span> '; }else
						 { $html .= '<span class="bullet-span"> ' . esc_html($term->name) . '</span> '; }
					 if($parent_id==0){
                   $data  =  display_terms_hierarchical($terms, $term->term_id, $level + 1) ; // Recursive call for child terms
				   if( $data =="")
				   {  
			   $data = "";
			   }else{
				 //  $data  .=  "<span class='bullet-spansmall'>(".display_terms_hierarchical($terms, $term->term_id, $level + 1).")</span>"; // Recursive call for child terms
				  
			   }
$html .= 	$data ;				
					}else{
						 
                   $html .=  display_terms_hierarchical($terms, $term->term_id, $level + 1) ; // Recursive call for child terms
					 }
                }
            }
			
			return $html;
        }
function get_post_terms_hierarchy($post_id, $taxonomy) {
    // Fetch all terms for the post
    $terms = wp_get_post_terms($post_id, $taxonomy, [
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }

    // Separate terms into parents and children
    $terms_hierarchy = [];
    foreach ($terms as $term) {
	 
        if ($term->parent == 0) {
            $terms_hierarchy["parent"]=$term;
        } else {
           
            $terms_hierarchy["child"]=$term;
        }
    }

    return $terms_hierarchy;
}


function fetch_vehicle_posts($brand,$model,$model_year,$spare_category,$swheel_size,$swheel_lug_nut,$swheel_type,$junkyard,  $paged = 1) {
	$junkyard_curr = pll_get_post( $junkyard,'en' );
		if($brand !=""){
			 
		 
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $brand ),
				);
				 $searchfor = "brand  '".get_term( $sbrand )->name."'";
		}  
		 if($model !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'brand',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model ),
			);
		} 
		if($model_year !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model_year ),
			);
		} 
		if($swheel_size !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_size ),
			);
		} 
		if($swheel_lug_nut !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-lug-nut',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_lug_nut ),
			);
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
				$args = array(
					'post_type' => array('vehicle'), 
					'posts_per_page' => -1, // Get all posts
							'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard_curr,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
				);



				// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				}
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				


    $query = new WP_Query($args);
 
    if ($query->have_posts()) {
  $i=0;
        while ($query->have_posts()) {  $query->the_post();
			$i++;
			 
		}
	}
	

	
    $args = array(
        'post_type' => array('vehicle'),   // Your custom post type
        'posts_per_page' => -1,      // Limit the number of posts
       
 'orderby' => 'modified', // Order by the post modified date
    'order' => 'DESC',       // Order in descending order (latest first)
		'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard_curr,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
    );
		// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				} 
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				
				
				 
      $start = ($paged * 5) - 4;
	  $end = $start;
 
    $query = new WP_Query($args);
$html ="";
    if ($query->have_posts()) {
   $html  = $html . '<div class="vehicle-spare-list-box">';
   $html  = $html . '<h4>Vehicles Found</h4>';
   
   
			 $html  = $html . '<div class="junkyard-details-row header">';
			 
			 $html  = $html . '<div class="junkyard-items">';  
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Item Name').'</strong>'; 
			$html  = $html . '</div>';
			//$html  = $html . '<div class="junkyard-items">';
			//$html  = $html . '<strong>'.pll__('Brand').'</strong>'; 
			//$html  = $html . '</div>';
			//$html  = $html . '<div class="junkyard-items">';
			//$html  = $html . '<strong>'.pll__('Model').'</strong>'; 
			//$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Year').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Engine Type').'</strong>'; 
			$html  = $html . '</div>'; 
			//$html  = $html . '<div class="junkyard-items">';
			//$html  = $html . '<strong>'.pll__('Cost').'</strong>'; 
			//$html  = $html . '</div>'; 
			$html  = $html . '</div>';
			$i = 0;
        while ($query->have_posts()) {
			$i++; 	 
		 
            $query->the_post();
			/* $featuredimage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'ful');
            // Output your post content here 
			
			 if(is_null($featuredimage[0])){
				  $vs_image = get_stylesheet_directory_uri().'/images/junkyard-placeholder.png';
			 }else{
				 $vs_image = $featuredimage[0];
			 }*/
			 
			  $brand = wp_get_post_terms(get_the_ID(), 'brand', array("fields" => "all"));
			  $model_year = wp_get_post_terms(get_the_ID(), 'model-year', array("fields" => "all"));
			  $engine_type = wp_get_post_terms(get_the_ID(), 'engine-type', array("fields" => "all"));
			  
 
$brands_hierarchy = get_post_terms_hierarchy(get_the_ID(), 'brand');
 
 
			 
		       $vs_image = get_field('thumbnail', $brands_hierarchy["parent"]);
			   	  
			 $html  = $html . '<div class="junkyard-details-row desktop-view">'; 
			 $html  = $html . '<div class="junkyard-items">'; 
			 $html  = $html . '<a href="javascript:void(0)" class="show-more-vinfo" ind = "'.$i.'"><span class="plus">+</span><span class="minus">-</span></a>';
			$html  = $html . '<img src="'.$vs_image.'" alt="Store Logo" class="junkyard-logo">';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_the_title().'</p>';
			$html  = $html . '</div>';
			//$html  = $html . '<div class="junkyard-items">'; 
			//$html  = $html . '<p>'.$brands_hierarchy["parent"]->name.'</p>';
			//$html  = $html . '</div>';
			//$html  = $html . '<div class="junkyard-items">'; 
			//$html  = $html . '<p>'.$brands_hierarchy["child"]->name.'</p>';
			//$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$model_year[0]->name.'</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$engine_type[0]->name.'</p>';
			$html  = $html . '</div>'; 
			//$html  = $html . '<div class="junkyard-items">'; 
			//$html  = $html . '<p>'.get_field('cost').' KWD</p>';
			//$html  = $html . '</div>'; 
$html  = $html . '<div class="vehicle-info vehicle-info-'.$i.'">';
		 
 
 
    $post_id = get_the_ID(); 
 
    // Define the taxonomy name
    $taxonomy = 'spare-part-type'; 

    // Retrieve the terms for the current post
    $terms = get_the_terms($post_id, $taxonomy);
 
    // Check if terms exist
    if ($terms && !is_wp_error($terms)) {

        // Sort terms by parent-child relationship (if needed)
        usort($terms, function($a, $b) {
            return $a->parent - $b->parent; // Sort by parent ID to display in hierarchy
        });

 

         $html .= '<div class="taxonomy-hierarchy">';
        $html .= display_terms_hierarchical($terms); // Call the recursive function to display terms
         $html .= '</div>';
    } else {
         $html .= 'No terms found for this post.';
    }

			$html  = $html . '</div>';  
 
			$html  = $html . '</div>';  
			
			
			 $html  = $html . '<div class="junkyard-details-row mobile-view">'; 
	 
			 $html  = $html . '<div class="junkyard-items">'; 
			 $html  = $html . '<div class="junkyard-thumb">'; 
			$html  = $html . '<a href="javascript:void(0)" class="show-more-vinfo" ind = "'.$i.'"><span class="plus">+</span><span class="minus">-</span></a>';
	  
		 	$html  = $html . '<img src="'.$vs_image.'" alt="Store Logo" class="junkyard-logo">'; 
			$html  = $html . '</div>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<h5>'.get_the_title().'</h5>'; 
			$html  = $html . '<p>'.$brand[0]->name.' '.$brand[1]->name.' '.$model_year[0]->name.'</p>'; 
			$html  = $html . '<p>'.$engine_type[0]->name.'</p>';
			$html  = $html . '</div>'; 
	 
			$html  = $html . '<div class="vehicle-info vehicle-info-'.$i.'">';
		 
 
 
 

// Initialize the HTML variable
$html .= '<ul>';
 $terms = get_the_terms(get_the_ID(), 'spare-part-type');
  usort($terms, function($a, $b) {
        return $a->parent - $b->parent; // Order by parent ID (ascending)
    });
	$prevparent="";
if ($terms && !is_wp_error($terms)) {
    // Get only top-level terms (parent = 0) among assigned terms
   

    // Display the top-level terms
    
        foreach ($terms as $term) {
			if($term->parent != 0){
				
			
			if($prevparent !=$term->parent){
				$prevparent  =$term->parent;
				$pterm = get_term($prevparent, 'spare-part-type');

				 $html .= '<h5>' . $pterm->name . '</h5>';
			}
        $html .= '<li>' . esc_html($term->name) . '</li>'; 
		}
        }
    
}
$html .= '</ul>';

 
			$html  = $html . '</div>';  
			$html  = $html . '</div>';  
          $end++;
        }
$end--;


			$html  = $html . '</div>';  
			
			
			
			
        // Pagination
        $total_pages = $query->max_num_pages;
		
		
     

        wp_reset_postdata();  // Restore original post data
		 
        return $html; // Return the buffered content
		
    }  
}




function fetch_vehicle_spare_posts($brand,$model,$model_year,$spare_category,$swheel_size,$swheel_lug_nut,$swheel_type,$junkyard,  $paged = 1) {
	
		if($brand !=""){
			 
		 
			  $tax_query[] = array(
					'taxonomy' => 'brand',
					'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
					'terms'    => intval( $brand ),
				);
				 $searchfor = "brand  '".get_term( $sbrand )->name."'";
		}  
		 if($model !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'brand',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model ),
			);
		} 
		if($model_year !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'model-year',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $model_year ),
			);
		} 
		if($swheel_size !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-size',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_size ),
			);
		} 
		if($swheel_lug_nut !=""){ 
			 $tax_query[] = array(
				'taxonomy' => 'wheel-lug-nut',
				'field'    => 'ID',  // You can also use 'term_id' if you are passing IDs
				'terms'    => intval( $swheel_lug_nut ),
			);
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
				$args = array(
					'post_type' => array('vehicle', 'spare-part'), 
					'posts_per_page' => -1, // Get all posts
							'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
				);



				// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				}
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				
 
 
    $query = new WP_Query($args);
 
    if ($query->have_posts()) {
  $i=0;
        while ($query->have_posts()) {  $query->the_post();
			$i++;
			 
		}
	}
    $args = array(
        'post_type' => array('vehicle', 'spare-part'),   // Your custom post type
        'posts_per_page' => 5,      // Limit the number of posts
        'paged' => $paged ,  
 'orderby' => 'modified', // Order by the post modified date
    'order' => 'DESC',       // Order in descending order (latest first)
		'meta_query' => array(
        array(
            'key'     => '_associated_junkyard',       // The custom field key
            'value'   => $junkyard,          // The value to compare 
            'compare' => '=',            // Comparison operator (>, >=, =, !=, etc.)
        ),
    ),
    );
		// Only add the tax_query if there are conditions
				if ( !empty( $tax_query ) ) {
					$args['tax_query'] = $tax_query;
					$args['tax_query'][] = array('relation'=>'AND'); 
				} 
				if ( !empty( $meta_query ) ) {
					$args['meta_query'] = $meta_query;
					$args['meta_query'][] = array('relation'=>'AND'); 
				}
				
				
				 
      $start = ($paged * 5) - 4;
	  $end = $start;
    $query = new WP_Query($args);
$html ="";
    if ($query->have_posts()) {
   $html  = $html . '<div class="vehicle-spare-list-box">';
   
   
			 $html  = $html . '<div class="junkyard-details-row">';
			 $html  = $html . '<div class="junkyard-items">';  
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Item Name').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Brand').'</strong>'; 
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Model').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Year').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Engine Type').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">';
			$html  = $html . '<strong>'.pll__('Cost').'</strong>'; 
			$html  = $html . '</div>'; 
			$html  = $html . '</div>';
        while ($query->have_posts()) {
            $query->the_post();
			 $featuredimage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'ful');
            // Output your post content here 
			
			 if(is_null($featuredimage[0])){
				  $vs_image = get_stylesheet_directory_uri().'/images/junkyard-placeholder.png';
			 }else{
				 $vs_image = $featuredimage[0];
			 }
			 
			  $brand = wp_get_post_terms(get_the_ID(), 'brand', array("fields" => "all"));
			  $model_year = wp_get_post_terms(get_the_ID(), 'model-year', array("fields" => "all"));
		 
			 $html  = $html . '<div class="junkyard-details-row">';
			 $html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<img src="'.$vs_image.'" alt="Store Logo" class="junkyard-logo">';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_the_title().'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$brand[0]->name.'</p>';
			$html  = $html . '</div>';
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$brand[1]->name.'</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.$model_year[0]->name.'</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_field('engine_type').' KWD</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '<div class="junkyard-items">'; 
			$html  = $html . '<p>'.get_field('cost').' KWD</p>';
			$html  = $html . '</div>'; 
			$html  = $html . '</div>'; 
          $end++;
        }
$end--;


			$html  = $html . '</div>'; 
        // Pagination
        $total_pages = $query->max_num_pages;
		
		
        if ($total_pages > 1) {
            $html  = $html . '<div class="pagination" total_pages="'.$total_pages.'"   totalcount="'.$i.'"    start-row ="'.$start.'"  end-row ="'.$end.'" >';
            for ($i = 1; $i <= $total_pages; $i++) {
				$active = "";
				if($paged==$i){
					$active = "active";
				}
                $html  = $html . '<span class="vs-page-numbers '.$active.'" data-page="' . $i . '"  >' . $i . '</span>';
            }
            $html  = $html . '</div>';
        }

        wp_reset_postdata();  // Restore original post data
		 
        return $html; // Return the buffered content
		
    } else {
        return 'No store posts found.';
    }
}



function load_vehicle_spare_posts() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1; // Get the page number from the AJAX request
    $brand = $_POST['brand'] ; 
    $model = $_POST['model'] ; 
    $model_year = $_POST['model_year'] ; 
    $spare_category = $_POST['spare_category'] ; 
    $wheel_size = $_POST['wheel_size'] ; 
    $junkyard = $_POST['junkyard'] ; 
		 
 
 
     $html = fetch_vehicle_spare_posts($brand,$model,$model_year,$spare_category,$wheel_size,$paged);
	$result = 1;
    echo json_encode(array(
        'html' => $html,
        'paging' => $paged 
    ));
    wp_die();  // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_load_vehicle_spare_posts', 'load_vehicle_spare_posts');
add_action('wp_ajax_nopriv_load_vehicle_spare_posts', 'load_vehicle_spare_posts'); // For non-logged in users




function load_modal_content() {
    // You can generate or fetch content here (e.g., database query)
    $content = '<p>This content was loaded via AJAX.</p>';

    // Output the content
    echo $content;
    wp_die(); // Required to properly terminate the AJAX call
}
add_action( 'wp_ajax_load_modal_content', 'load_modal_content' );
add_action( 'wp_ajax_nopriv_load_modal_content', 'load_modal_content' ); // For non-logged-in users
