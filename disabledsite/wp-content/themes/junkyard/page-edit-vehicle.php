<?php 
/*
*Template Name: Edit Vehicle Template
*/ 
get_header('user');
while ( have_posts() ) : the_post(); 
	$success_msg=''; 
	$error_msg=''; 
	if(isset($_REQUEST["id"])){
		$vehicle_id_en = pll_get_post($_REQUEST["id"],'en' );
	    $vehicle_id_ar = pll_get_post($_REQUEST["id"],'ar' );
	 
	} 
	 echo $vehicle_id_ar ;
	if(isset($_REQUEST["success_msg"])){
		$success_msg = $_REQUEST["success_msg"];
	}
	if(isset($_REQUEST["error_msg"])){
		$error_msg = $_REQUEST["error_msg"];
	} 
	global $wpdb;
	$current_user = wp_get_current_user(); 
	$user = new WP_User( get_current_user_id() );
	$user_role  =  array();
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
		$user_role[] = $role;
	}
	  
	if(isset($_REQUEST['save_vehicle'])){  
		//	$vehicle_name_en = sanitize_text_field($_REQUEST['vehicle_name']);
		//$vehicle_name_ar = sanitize_text_field($_REQUEST['vehicle_name_ar']);
		 if( (in_array("junkyards_administrator", $user_role)) )
		{
			$associated_junkyard = sanitize_text_field($_REQUEST['associated_junkyard']);
		}else{
			 $associated_junkyard = get_user_meta(get_current_user_id(), '_junkyard_manager_user', true); 
		}
		$brand_model =  sanitize_text_field($_REQUEST['brand_model']);
		$model_year =  sanitize_text_field($_REQUEST['model_year']);

$model_year = (int) $model_year;
		$arabic_term_id = pll_get_term($model_year, 'ar');
		$model_year_ar = (int) $arabic_term_id;
	
		$term = get_term($model_year, 'model-year'); // Replace 'category' with your taxonomy.
		if (!is_wp_error($term)) {
			$model_year_name =  $term->name;
		}$term = get_term($arabic_term_id, 'model-year'); // Replace 'category' with your taxonomy.
		if (!is_wp_error($term)) {
			$model_year_name_ar =  $term->name;
		}
		$brand_modelarr = explode("-",$brand_model);
		$brand_model = array();		 
		$brand_model_ar = array();$brand_name =array();	$brand_name_ar =array();		 
		foreach ($brand_modelarr as $value) {
			$brand_model[] = (int) $value;
			$arabic_term_id = pll_get_term($value, 'ar');
			$brand_model_ar[] = (int) $arabic_term_id;
			$term = get_term($value, 'brand'); // Replace 'category' with your taxonomy.
			if (!is_wp_error($term)) {
				$brand_name[] =  $term->name;
			}
			$term = get_term($arabic_term_id, 'brand'); // Replace 'category' with your taxonomy.
			if (!is_wp_error($term)) {
				$brand_name_ar[] =  $term->name;
			}
		}
		   $vehicle_name_en  = $model_year_name." ".implode(" ",$brand_name);
		   $vehicle_name_ar  = $model_year_name_ar." ".implode(" ",$brand_name_ar);

 
		$engine_type =  ($_REQUEST['engine_type']); 
		$cost = sanitize_text_field($_REQUEST['cost']);
		$spare_part_type_arr =  ($_REQUEST['spare_part_type']);
		$wheel_size_arr =  ($_REQUEST['wheel_size']);
	 
		$wheel_lug_nut_arr =  ($_REQUEST['wheel_lug_nut']);
		$wheel_type  =  ($_REQUEST['wheel_type']);
 
	 
		$post_update = array( 
			'ID'         => $vehicle_id_en,
			'post_title' => $vehicle_name_en,
			'post_type' =>'vehicle','post_status'=>'publish','lang'=>'en',
		);
		$vehicle_id_en =  wp_update_post( $post_update );
		
		pll_set_post_language($vehicle_id_en, 'en');
		$post_update = array( 
			'ID'         => $vehicle_id_ar,
			'post_title' => $vehicle_name_ar,
			'post_type' =>'vehicle','post_status'=>'publish','lang'=>'ar',
		);
		$vehicle_id_ar =  wp_update_post( $post_update );
		
		 
		update_field( '_associated_junkyard', $associated_junkyard ,$vehicle_id_en);
		update_field( '_associated_junkyard', $associated_junkyard ,$vehicle_id_ar);
		update_field( 'cost', $cost ,$vehicle_id_en);
		update_field( 'cost', $cost ,$vehicle_id_ar);
		update_field( 'wheel_type', $wheel_type ,$vehicle_id_en);
		update_field( 'wheel_type', $wheel_type ,$vehicle_id_ar);
	 

	 wp_set_object_terms( $vehicle_id_en,  $brand_model, 'brand', true );
	 wp_set_object_terms( $vehicle_id_ar,  $brand_model_ar, 'brand', true );
	 
	 
	 wp_set_object_terms( $vehicle_id_en,  $model_year, 'model-year', true );
	 wp_set_object_terms( $vehicle_id_ar,  $model_year_ar, 'model-year', true );
	 
	 
	 $spare_part_type = array();		 
		$spare_part_type_ar = array();		 
		foreach ($spare_part_type_arr as $value) {
			$spare_part_type[] = (int) $value;
			$arabic_term_id = pll_get_term($value, 'ar');
			$spare_part_type_ar[] = (int) $arabic_term_id;
		}
		
		  if(isset($_REQUEST['wheel_size']) || isset($_REQUEST['wheel_lug_nut']) || isset($_REQUEST['wheel_type'])   ){
			// Define the term name and taxonomy
			$term_name = 'Wheels and Tires';
			$taxonomy = 'spare-part-type';

			// Fetch the term object by name
			$term = get_term_by('name', $term_name, $taxonomy);

			// Check if the term exists and get the ID
			if ($term) {
				$term_id = $term->term_id;
				$spare_part_type[] = (int) $term_id;
			$arabic_term_id = pll_get_term($term_id, 'ar');
			$spare_part_type_ar[] = (int) $arabic_term_id;
			}  
		}
	 wp_set_object_terms( $vehicle_id_en,  $spare_part_type, 'spare-part-type', true );
	 wp_set_object_terms( $vehicle_id_ar,  $spare_part_type_ar, 'spare-part-type', true );
	 
	  $wheel_size = array();		 
		$wheel_size_ar = array();		 
		foreach ($wheel_size_arr as $value) {
			$wheel_size[] = (int) $value;
			$arabic_term_id = pll_get_term($value, 'ar');
			$wheel_size_ar[] = (int) $arabic_term_id;
		}
	 wp_set_object_terms( $vehicle_id_en,  $wheel_size, 'wheel-size', true );
	 wp_set_object_terms( $vehicle_id_ar,  $wheel_size_ar, 'wheel-size', true );
	 
	 
	 $wheel_lug_nut = array();		 
		$wheel_lug_nut_ar = array();		 
		foreach ($wheel_lug_nut_arr as $value) {
			$wheel_lug_nut[] = (int) $value;
			$arabic_term_id = pll_get_term($value, 'ar');
			$wheel_lug_nut_ar[] = (int) $arabic_term_id;
		}
	 wp_set_object_terms( $vehicle_id_en,  $wheel_lug_nut, 'wheel-lug-nut', true );
	 wp_set_object_terms( $vehicle_id_ar,  $wheel_lug_nut_ar, 'wheel-lug-nut', true );
	 
	 
			$arabic_term_id = pll_get_term($engine_type, 'ar');
			$engine_type_ar = (int) $arabic_term_id;
	  
	 wp_set_object_terms( $vehicle_id_en,  (int)$engine_type, 'engine-type', true );
	 wp_set_object_terms( $vehicle_id_ar,  (int)$engine_type_ar, 'engine-type', true );
	 $file = $_FILES['featured_image'];	 
		/*if($file['name']!=''){ 
			// check security nonce which one we created in html form and sending with data.
			//	check_ajax_referer('uploadingFile', 'security');
			// removing white space
			$filename = preg_replace('/\s+/', '-', $_FILES["featured_image"]["name"]);
			// removing special character but keep . character because . seprate to extantion of file
			$filename = preg_replace('/[^A-Za-z0-9.\-]/', '', $filename);
			// rename file using time
			$filename = time().'-'.$filename;
			// upload file
			if($ret = wp_upload_bits($filename, null, file_get_contents($_FILES["featured_image"]["tmp_name"])))
			{
				 
				if (!$ret['error']) {
					$wp_filetype = wp_check_filetype($filename, null );
					$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_parent' => 0,
					'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' => '',
					'post_status' => 'inherit'
					);
					 
					$attachment_id = wp_insert_attachment( $attachment, $ret['file'], 0 );
					if (!is_wp_error($attachment_id)){
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						$attachment_data = wp_generate_attachment_metadata( $attachment_id, $ret['file'] );
						wp_update_attachment_metadata( $attachment_id,  $attachment_data );
						 
					   set_post_thumbnail(  $vehicle_id_ar,   $attachment_id );
					   set_post_thumbnail(  $vehicle_id_en,   $attachment_id );
					}
				}
			}  
		}*/
		 
		$success_msg = 'Vehicle Updated Successfully';
	} 
	 
	?> 
	<style>
	a.view-document {
		width: 120px;
		display: block;
		font-weight: bold;
		text-transform: capitalize;
	}
	input#display_in_news ,input#display_on_banner  {
		width: 15px;
	}
	input.form-control.featured_image {
		opacity: 1;
		position: relative;
	 
		color: unset;
	}
	.document-item img {
		border-radius: 5px;
	}
	.document-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: inline-block;
		border-radius: 5px;
		position: relative;
		margin-right: 15px;
	}

	a.delete-file-fp {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
	}
	.element input[type=file] {
		position: relative;
	}
	div#moreImageUploadLink a {
		color: #fff;
	}

	div#moreImageUploadLink {
		background: #01c45f;
		width: 150px;
		color: #fff;
		text-align: center;
		font-weight: bold;
		border-radius: 5px;
	}
	input#floor_plans1 {
		margin-bottom: 15px;
	}
	a.delete-file {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px; 
	}
	div#moreImageUploadgalleryLink {
		background: #01c45f;
		width: 150px;
		color: #fff;
		text-align: center;
		font-weight: bold;
		border-radius: 5px;    margin-top: 10px;
	}
	div#moreImageUploadgalleryLink a{
	   margin-top:10px;
		color: #fff;
		
	}
	.gallery-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: block;
	}
	.form-group label {
		display: block;
	}
	a.delete-file-fp {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		position: absolute;
		z-index: 9;
		right: 5px;
		background: #fff;
		width: 15px;
		height: 15px;
		/* display: flex; */
		text-align: center;
		top: 5px;
		padding: 0;
		margin: 0;
		line-height: 1.5;
		border-radius: 9px;
		font-size: 10px;
	}
	.gallery-item {
		margin-bottom: 15px;
		max-height: 100px;
		display: inline-block;
		border-radius: 5px;
		position: relative;
		margin-right: 15px;
	}
	.gallery-item img {
		border-radius: 5px;
	}
	a.delete-file {
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		color: red;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 11px;
		position: absolute;
		z-index: 9;
		right: 5px;
		background: #fff;
		width: 15px;
		height: 15px;
		/* display: flex; */
		text-align: center;
		top: 5px;
		padding: 0;
		margin: 0;
		line-height: 1.5;
		border-radius: 9px;
		font-size: 10px;
	}
	.element.gallery-item {
		display: block;
	}

	input.form-control.featured_image {
		opacity: 1;
		position: relative;
	 
		color: unset;
	}

	.form-group img {
		border-radius: 5px;
	}
	h3 {
    font-size: 15px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 30px;
    border: 1px solid #2f5eab;
    background: #2f5eab;
    color: #fff;
    padding: 5px;
}

/**/

.btn-zap { 
  display:block; 
  width:18px; height:18px; 
  line-height:18px; font-size:14px;
  border-radius:50%; 
  background:#aaa; color:#fff;
  margin:3px auto;
  text-align:center;
  padding:0;
} 
.btn-zap:disabled { 
  background:#aaa; color:#fff;
  opacity:.5; 
  cursor:default; }

.growTextarea { overflow:hidden; }

/*...*/

.table-editable { 
  width:100%; 
  background:#f2f2f2; 
  border:.9px solid #d2d2d2; 
  border-spacing:4px; border-collapse:separate;
}

.table-editable tbody tr:last-child td { 
  padding-bottom:14px;
}
.table-editable th,
.table-editable td {
  padding:0; 
}



.table-controls { 
  vertical-align:top; 
  text-align:center;
  padding-top: 2px; }
.table-zapper {
  width:30px;
}

.table-submit { 
  padding:2px 7px 8px 10px; }

table.table-editable-label {
    width: 100%;
    background: #f2f2f2;
    border: 0.9px solid #d2d2d2;
    border-spacing: 4px;
    border-collapse: separate;
}



	</style>
	<div class="main-panel">
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-brand" href="javascript:;"><?php echo pll__('Add Customer');?></a>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
			 	<?php  get_template_part( 'left', 'header' );?> 
			</div>
		</nav>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success" <?php if($success_msg  =='') { ?>style='display:none;'<?php  }  ?>>
							<span>
								<b><?php echo $success_msg;?></b>
							</span>
					</div>
					<div class="card">
						<div class="card-header card-header-primary">
							<h4 class="card-title"><?php echo pll__('Edit Vehicle');?></h4>
							<p class="card-category"></p>
						</div>
						<?php 
						$_associated_junkyard = get_post_meta( $vehicle_id_en,'_associated_junkyard',true);  
						$featuredimage = wp_get_attachment_image_src( get_post_thumbnail_id( $vehicle_id_en ), 'full' ); 	
						?>
						<div class="card-body">
							<form action='' method='post' class='frm-addeditvehicle'    enctype='multipart/form-data'>
							
								<div class="row attachment-upload" >
								
									<?php if( (in_array("junkyards_administrator", $user_role)) )
										{?>
<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Junkyard');?></label>
	 <?php
 
    echo '<select name="associated_junkyard" id="junkyard-select" class="form-control  " >';
    echo '<option value="">Select a Junkyard</option>'; // Default empty option
 
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
			$selected = "";
			if($_associated_junkyard==get_the_ID()){
				$selected = "selected";
			}
			 echo '<option value="'.get_the_ID().'" '.$selected.'>'.get_the_title().'</option>'; // Default empty option
		}
				wp_reset_postdata();
	}
  

    echo '</select>';
 
?>

		</div>
		</div><?php } ?>
									<!--<div class="col-md-12">
										<div class="form-group"> 
											<label class="bmd-label-floating upload-label"><?php echo pll__('Featured Image');?></label>	
										</div>
									</div>	
									<?php 
									$featured_image = $featuredimage[0];
									if($featuredimage[0]==""){
										$featured_image =  get_stylesheet_directory_uri()."/images/junkyard-placeholder.png";
									}
									?>
									<div class="col-md-12">
										<div class="form-group"><img src='<?php echo $featured_image;?>' width='100px' height='100px'>
										 <input type="file" class="form-control featured_image"  name="featured_image"  >
										</div>
									</div>-->
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Vehicle name');?>(EN)</label>
											<input type="text" class="form-control  "  name="vehicle_name" id='vehicle_name' value="<?php echo get_the_title($vehicle_id_en);?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Vehicle name');?>(AR)</label>
											<input type="text" class="form-control  "  name="vehicle_name_ar" id='vehicle_name_ar' value="<?php echo get_the_title($vehicle_id_ar);?>" >
										</div>
									</div> 
	
		<div class="col-md-6">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Brand/Model');?></label>
		<select class="form-control  "  name="brand_model"id='brand_model' >
		<option value="0"></option> 
		<?php
		
		
 $terms = wp_get_post_terms($vehicle_id_en, 'brand', array(
    'parent' => 0 // Only fetch terms with no parent (parent = 0)
));

// Check if terms are available and loop through them
if (!is_wp_error($terms) && !empty($terms)) {
    foreach ($terms as $term) {
        $selected_brand =  $term->term_id; // Display the term name (or use $term->term_id for the term ID)
    }
} 

		
 $terms = wp_get_post_terms($vehicle_id_en, 'brand', array(
    'parent' => $selected_brand // Only fetch terms with no parent (parent = 0)
));

// Check if terms are available and loop through them
if (!is_wp_error($terms) && !empty($terms)) {
    foreach ($terms as $term) {
        $selected_model =  $term->term_id; // Display the term name (or use $term->term_id for the term ID)
    }
} 
// Get all terms from the 'brand' taxonomy at the top level (parent terms)
$brand_terms = get_terms(array(
    'taxonomy' => 'brand',
    'parent'   => 0, // Get only top-level terms
    'hide_empty' => false, // Show terms even if they have no posts
));

if (!empty($brand_terms) && !is_wp_error($brand_terms)) :
    foreach ($brand_terms as $parent_term) {
        // Display the parent term name
        $brand = esc_html($parent_term->name) ;
        $brand_id = esc_html($parent_term->term_id) ;
        
        // Get second-level terms (child terms) of the current parent term
        $child_terms = get_terms(array(
            'taxonomy' => 'brand',
            'parent'   => $parent_term->term_id,
            'hide_empty' => false,
        ));

        if (!empty($child_terms) && !is_wp_error($child_terms)) {
           
            foreach ($child_terms as $child_term) {
                // Display the second-level term name
                $model = esc_html($child_term->name) ;
				$model_id = esc_html($child_term->term_id) ;
				?>
		<option value="<?php echo $brand_id;?>-<?php echo $model_id;?>" <?php if($selected_brand == $brand_id && $selected_model == $model_id) { ?> selected <?php } ?>><?php echo $brand;?> <?php echo $model;?></option> 
		<?php
            }
        
        } else{
				?>
		<option value="<?php echo $brand_id;?>"><?php echo $brand;?></option> 
		<?php
		}
		
		
    }
 
endif;
?>
		</select>
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
 
		<label class="bmd-label-floating"><?php echo pll__('Model Year');?></label>
		<select class="form-control  "  name="model_year"id='model_year' >
		<option value="0"></option> 
		<?php
	 
$terms = wp_get_post_terms($vehicle_id_en, 'model-year');

// Check if a term exists and output it
if (!is_wp_error($terms) && !empty($terms)) {
    $term = $terms[0]; // Since it’s single-selection, get the first term only
   $selected_model_year =  $term->term_id; // Display the term name
    // You can also use $term->term_id if needed
} 
			// Fetch all terms from 'model_year' taxonomy ordered by term name (ascending)
$model_year_terms = get_terms(array(
    'taxonomy'   => 'model-year',  // Replace with your taxonomy name
    'hide_empty' => false,         // Set to true to hide terms with no posts
    'orderby'    => 'name',        // Order by term name
    'order'      => 'ASC',         // 'ASC' for ascending order, 'DESC' for descending order
	'fields'     => 'all',         // Ensure we get all data for debugging
));

if ( ! empty( $model_year_terms ) && ! is_wp_error( $model_year_terms ) ) {
	    // Sort the terms numerically by their names (which are years)
    usort( $model_year_terms, function( $a, $b ) {
        return intval( $b->name ) - intval( $a->name ); // Reverse the comparison for descending order
    });
    // Loop through the terms and output them
    foreach ( $model_year_terms as $term ) {
     
?>
    <option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if($term->term_id== $selected_model_year ) { ?> selected <?php } ?>>
        <?php echo esc_html( $term->name ); ?>
    </option>
<?php 
}
}
?>
		</select>
		</div>
		</div>
		
		<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Engine Type');?></label>
		<select class="form-control  "  name="engine_type"id='engine_type' >
		<option value="0"></option> 
		<?php
		 
$terms = wp_get_post_terms($vehicle_id_en, 'engine-type');

// Check if a term exists and output it
if (!is_wp_error($terms) && !empty($terms)) {
    $term = $terms[0]; // Since it’s single-selection, get the first term only
   $selected_engine_type =  $term->term_id; // Display the term name
    // You can also use $term->term_id if needed
} 
			// Fetch all terms from 'model_year' taxonomy ordered by term name (ascending)
$model_year_terms = get_terms(array(
    'taxonomy'   => 'engine-type',  // Replace with your taxonomy name
    'hide_empty' => false,         // Set to true to hide terms with no posts
    'orderby'    => 'name',        // Order by term name
    'order'      => 'ASC',         // 'ASC' for ascending order, 'DESC' for descending order
	'fields'     => 'all',         // Ensure we get all data for debugging
));

if ( ! empty( $model_year_terms ) && ! is_wp_error( $model_year_terms ) ) {
	    // Sort the terms numerically by their names (which are years)
    usort( $model_year_terms, function( $a, $b ) {
        return intval( $b->name ) - intval( $a->name ); // Reverse the comparison for descending order
    });
    // Loop through the terms and output them
    foreach ( $model_year_terms as $term ) {
     
?>
    <option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if($term->term_id== $selected_engine_type ) { ?> selected <?php } ?>>
        <?php echo esc_html( $term->name ); ?>
    </option>
<?php 
}
}
?>
		</select>
		</div>
		</div>	 
		<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Enter Vehicle Cost');?></label>
		<input type="text" class="form-control  "  name="cost"id='cost'   value="<?php echo get_post_meta($vehicle_id_en,'cost',true);?>" >
		</div>
		</div>
			<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Spare Parts');?></label>
<?php

$terms = wp_get_post_terms($vehicle_id_en, 'spare-part-type');
 
$selected_spare_part_type = array();

foreach($terms  as $termsp ){
	$selected_spare_part_type[] = $termsp->term_id;
}

// Fetch all terms from the 'spare-part-type' taxonomy
$spare_part_termsori = get_terms(array(
    'taxonomy'   => 'spare-part-type',  // Replace with your taxonomy name
    'hide_empty' => false,               // Set to true to hide terms with no posts
    'parent'    => 0,              // Order by term name
    'orderby'    => 'name',              // Order by term name
    'fields'     => 'all',               // Get all fields of terms
    'hierarchical' => true,              // Ensure terms are retrieved hierarchically
));
// Filter out terms with the name "Wheels and Tires"
$spare_part_terms = array_filter($spare_part_termsori, function($term) {
    return $term->name !== 'Wheels and Tires';
});

if ( ! empty( $spare_part_terms ) && ! is_wp_error( $spare_part_terms ) ) {
 

    // Loop through the terms and display them as checkboxes
    foreach ( $spare_part_terms as $term ) {
        // Check if the term has a parent (is a child term)
        $checked  ="";
            // It's a parent term 
           if(in_array($term->term_id, $selected_spare_part_type )){
			   $checked  ="checked";
			   } 
			   
		    echo '<div class="sp-block"><h6> <input type="checkbox" name="spare_part_type[]" value="'.$term->term_id.'" id="sp'.$term->term_id.'" '.$checked.'><label  for="sp'.$term->term_id.'">'.$term->name. '</label></h6>';
           
        ?>
		<div class="checkuncheck"><a href="javascript:void(0)" class="checkall" sp="<?php echo $term->term_id;?>" id="checkall"><?php echo pll__('Check All');?></a>|<a href="javascript:void(0)" class="uncheckall"  sp="<?php echo $term->term_id;?>"  id="uncheckall"><?php echo pll__('Uncheck All');?></a></div>
		<ul class="row">
	
		<?php
		
		$spare_part_childterms = get_terms(array(
    'taxonomy'   => 'spare-part-type',  // Replace with your taxonomy name
    'hide_empty' => false,               // Set to true to hide terms with no posts
    'parent'    => $term->term_id ,              // Order by term name
    'orderby'    => 'name',              // Order by term name
    'fields'     => 'all',               // Get all fields of terms
    'hierarchical' => true,              // Ensure terms are retrieved hierarchically
));
		  // Loop through the terms and display them as checkboxes
   foreach ( $spare_part_childterms as $childterm ) {
		?>
		<li class="col-md-4"><input type="checkbox" name="spare_part_type[]" parent= "<?php echo $term->term_id;?>" class="child-spare sp-<?php echo $term->term_id;?>" value="<?php echo $childterm->term_id;?>" <?php if(in_array($childterm->term_id, $selected_spare_part_type )){ ?> checked <?php } ?>  id="sp<?php echo $childterm->term_id;?>"><label  for="sp<?php echo $childterm->term_id;?>"><?php echo $childterm->name;?></label></li>
		
		<?php
	}
       ?></ul></div><?php 
    }

 
   
    // Add JavaScript to handle Select All / Unselect All functionality
    ?>
   
    <?php
}  
if( in_array("junkyard_manager", $user_role)){
								
	$_junkyard  =  get_user_meta(get_current_user_id(), '_junkyard_manager_user', true);
	$capability =  get_field('capability',$_junkyard);
}

if( (in_array("junkyards_administrator", $user_role)) ||   (in_array("junkyard_manager", $user_role) && (in_array('wheels and tires',$capability)))  )
{
echo '<h6>'. pll__('Wheels and Tires').'</h6>';
 echo '<div class="sp-block"><span class="wheel-category">'. pll__('Size').':</span> ';

?>
	<ul class="row">
	
		<?php
		$terms = wp_get_post_terms($vehicle_id_en, 'wheel-size');
$selected_wheel_size = array();

foreach($terms  as $termsp ){
	$selected_wheel_size[] = $termsp->term_id;
}
		$spare_part_childterms = get_terms(array(
    'taxonomy'   => 'wheel-size',  // Replace with your taxonomy name
    'hide_empty' => false,               // Set to true to hide terms with no posts
    'parent'    =>0 ,              // Order by term name
    'orderby'    => 'name',              // Order by term name
    'fields'     => 'all',               // Get all fields of terms
    'hierarchical' => true,              // Ensure terms are retrieved hierarchically
));
		  // Loop through the terms and display them as checkboxes


		  if (!is_wp_error($spare_part_childterms)) {
			// Sort terms by the numeric part of their names
			usort($spare_part_childterms, function ($a, $b) {
				// Extract the numeric part from the term names
				$numA = (int) preg_replace('/\D+/', '', $a->name);
				$numB = (int) preg_replace('/\D+/', '', $b->name);
		
				return $numA <=> $numB; // Sort in ascending order
			});
		}
   foreach ( $spare_part_childterms as $childterm ) {
		?>
		<li class="col-md-4"><input type="checkbox" name="wheel_size[]" value="<?php echo $childterm->term_id;?>" <?php if(in_array($childterm->term_id, $selected_wheel_size )) { ?> checked <?php } ?>><?php echo $childterm->name;?></li>
		
		<?php
	}
       ?></ul> </div>
	   <?php
	   echo '<div class="sp-block"><span class="wheel-category">'. pll__('Number of Lug nuts').' :</span> ';

?>
	<ul class="row">
	
		<?php
				$terms = wp_get_post_terms($vehicle_id_en, 'wheel-lug-nut');
$selected_wheel_lug_nut = array();

foreach($terms  as $termsp ){
	$selected_wheel_lug_nut[] = $termsp->term_id;
}
		$spare_part_childterms = get_terms(array(
    'taxonomy'   => 'wheel-lug-nut',  // Replace with your taxonomy name
    'hide_empty' => false,               // Set to true to hide terms with no posts
    'parent'    =>0 ,              // Order by term name
    'orderby'    => 'name',              // Order by term name
    'fields'     => 'all',               // Get all fields of terms
    'hierarchical' => true,              // Ensure terms are retrieved hierarchically
));
		  // Loop through the terms and display them as checkboxes
   foreach ( $spare_part_childterms as $childterm ) {
		?>
		<li class="col-md-4"><input type="checkbox" name="wheel_lug_nut[]" value="<?php echo $childterm->term_id;?>" <?php if(in_array($childterm->term_id, $selected_wheel_lug_nut )) { ?> checked <?php } ?>><?php echo $childterm->name;?></li>
		
		<?php
	}
       ?></ul></div>

<?php 
 
 echo '<div class="sp-block"><span class="wheel-category">'. pll__('Wheel Type').':</span> ';
 echo get_post_meta($vehicle_id_en,'wheel_type',true);
?>	 
	<ul class="row">  
		<li class="col-md-4"><input type="radio" name="wheel_type" value="Original" <?php if(get_post_meta($vehicle_id_en,'wheel_type',true)=="Original") {?>checked <?php } ?>><?php echo  pll__('Original (OEM)');?></li>
		<li class="col-md-4"><input type="radio" name="wheel_type" value="After-Market" <?php if(get_post_meta($vehicle_id_en,'wheel_type',true)=="After-Market") {?>checked <?php } ?>><?php echo  pll__('After-Market (Non-Original)');?></li>
		
		 </ul> </div>
		 
		 <?php } ?>
		</div>
		</div>
	 

	 
 

	 


		</div>

	 
								<button type="submit" class="btn btn-primary pull-right" id="save-vehicle" name="save_vehicle" onclick ='return validate_form_vehicle()'  ><?php echo pll__('Save Vehicle');?></button>
								<div class="clearfix"></div>
							</div>
						</form>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
<?php
endwhile;  
get_footer('user');?> 
 

<script type="text/javascript">
function  validate_form_vehicle(){
		 error = 0

		 $('.error').remove()
 vehicle_name = jQuery('#vehicle_name').val()
  vehicle_name_ar = jQuery('#vehicle_name_ar').val()
				 if(vehicle_name==""){
				jQuery('#vehicle_name').parent().append("<span class='error'><?php echo pll__('Please Enter Vehicle Name In English !');?></span>")
				jQuery('#vehicle_name').focus();
				error = 1;
			}
				 if(vehicle_name_ar==""){
				jQuery('#vehicle_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Vehicle Name In Arabic !');?></span>")
				jQuery('#vehicle_name_ar').focus();
				error = 1;
			}
			
			 $(".contractor_no").each(function(){
        // Test if the div element is empty
        if($(this).is(":empty")){
            $(this).css("background", "yellow");
        }
			 })
     
			if(error ==0){
return true			}else{
	return false;
}
}
		 
	
	$(document).ready(function() {
		$("#approved_by").select2()
		$("input[id^='documents']").each(function() {
			var id = parseInt(this.id.replace("documents", ""));
			$("#documents" + id).change(function() {
				if ($("#documents" + id).val() != "") {
					$("#moreImageUploadLink").show();
				}
			});
		});
	 
	 //delete row
$(".btnDeleteRow").click(function() {
	console.log('btnDeleteRow ')
  var rowCount = $(this).closest('table').find('tbody').length;
  if (rowCount > 1) {
    $(this).closest('tbody').remove(); 
  } 
  rowCount --; 
  if (rowCount <= 1) { 
    $(document).find('.btnDeleteRow').prop('disabled', true);  
  }
});

//add row
$(".btnAddRow").click(function() { 
  var table = $(this).closest('table');
  var lastRow = table.find('tbody').last();
  console.log(lastRow)
  var newRow = lastRow.clone(true, true); 
  newRow.find('input, textarea, select').val('');
  newRow.find('.growTextarea').css('height','auto');
  newRow.insertAfter(lastRow);
  table.find('.btnDeleteRow').removeAttr("disabled");
});



// growTextarea function: use for testing that the the javascript
// is also copied when row is cloned.  to confirm, 
// type several lines into Location, add a row, & repeat

function growTextarea (i,elem) {
    var elem = $(elem);
    var resizeTextarea = function( elem ) {
        var scrollLeft = window.pageXOffset || (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollTop  = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;  
        elem.css('height', 'auto').css('height', elem.prop('scrollHeight') );
        window.scrollTo(scrollLeft, scrollTop);
    };

    elem.on('input', function() {
        resizeTextarea( $(this) );
    });

    resizeTextarea( $(elem) );
}

$('.growTextarea').each(growTextarea);
	});
 
	function del_uploadedfpfile(){
		jQuery('.document-item-delete').val(1)
		jQuery('.document-item').hide()
		
	}
	function del_uploadedfpfile2(){
		jQuery('.document-item-delete-2').val(1)
		jQuery('.document-item-2').hide()
		
	}
 
	
	function del_file(eleId) {
		var ele = document.getElementById("delete_file" + eleId);
		ele.parentNode.removeChild(ele);
	}

</script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#brand_model').select2();
    $('#junkyard-select').select2();
   $('#model_year').select2();
 
});
</script>
