<?php
 
/*
*Template Name: Add Model Template
*/ 
get_header('user'); 
			$user_role = array();
			$user = new WP_User( get_current_user_id() );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role )
					$user_role[] = $role;
			}
if( !(in_array("junkyards_administrator", $user_role))   )
			{
			?> 
				<script>        
					document.location =  '<?php echo site_url('user-dashboard');?>';
				</script>
			<?php
			} 
while ( have_posts() ) : the_post(); 
	$success_msg=''; 
	$error_msg=''; 
	$customer_for = '';
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
 
	
	if(isset($_REQUEST['save_brand'])){ 

		$brand_model = sanitize_text_field($_REQUEST['brand_model']);
		$brand_name_en = sanitize_text_field($_REQUEST['brand_name']);
		$brand_name_ar = sanitize_text_field($_REQUEST['brand_name_ar']);
 
			// Add the term to the taxonomy
			$new_term = wp_insert_term(
				$brand_name_en, // Term name
				'brand', // Taxonomy name
				[
				   
					'parent' => $brand_model, // Set parent term ID if needed; 0 means top-level
				]
			);
			if (!( is_wp_error( $new_term ) )) {
			 pll_set_term_language($new_term['term_id'],'en'); 
			 
			  $ar_brand_model = pll_get_term($brand_model, 'ar');	
			 $brand_en = $new_term['term_id'];
		  
		 
			// Add the term to the taxonomy
			$new_term = wp_insert_term(
				$brand_name_ar, // Term name
				'brand', // Taxonomy name
				[
				   
					'parent' => $ar_brand_model, // Set parent term ID if needed; 0 means top-level
				]
			);
			
			 pll_set_term_language($new_term['term_id'],'ar'); 
			  $brand_ar = $new_term['term_id'];
			  
			  $arr = array('en'=>$brand_en,'ar'=>$brand_ar  );
		 pll_save_term_translations($arr);
	 
  
		$success_msg =   pll__('Model Added Successfully');
			}else{
				
		$err_msg = pll__('Model Exists');
			}
	} 
	?> 
	<style>

	input#display_in_news ,input#display_on_banner  {
	width: 15px;
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
	</style>
	<div class="main-panel">
		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-model" href="javascript:;"><?php echo pll__('Add Customer');?></a>
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
		<!-- End Navbar -->
		<div class="content">
		<div class="container-fluid">
		<div class="row">
		<div class="col-md-12">
		<div class="alert alert-success" <?php if($success_msg  =='') { ?>style='display:none;'<?php  }  ?>>
		<span><b><?php echo $success_msg;?></b>
		</span>
		</div>
		
		<div class="alert alert-danger" <?php if($err_msg  =='') { ?>style='display:none;'<?php  }  ?>>
		<span><b><?php echo $err_msg;?></b>
		</span>
		</div>
		<div class="card">
		<div class="card-header card-header-primary">
		<h4 class="card-title"><?php echo pll__('Add Model');?></h4>
		<p class="card-category"></p>
		</div>
		<div class="card-body">
		<form action='' method='post' class='frm-addeditbrand'    enctype='multipart/form-data'> 
					 
									<div class="row">
	
		<div class="col-md-12">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Brand');?></label>
	<select class="form-control  "  name="brand_model"id='brand_model' >
		<option value="0"></option> 
		<?php
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
        
       
     
				?>
		<option value="<?php echo $brand_id;?>"><?php echo $brand;?></option> 
		<?php
		 
		
		
    }
 
endif;
?>
		</select>
		</div>
		</div>
		 
	
	 
	</div>
		<div class="row">
	
		<div class="col-md-6">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Model name');?>(EN)</label>
		<input type="text" class="form-control  "  name="brand_name" id='brand_name' value="" >
		</div>
		</div>
			<div class="col-md-6">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Model name');?>(AR)</label>
		<input type="text" class="form-control  "  name="brand_name_ar" id='brand_name_ar' value="" >
		</div>
		</div>

	
	 
	</div>
	 
	 
		<button type="submit" class="btn btn-primary pull-right" id="save-model" name="save_brand" onclick ='return validate_form_brand()' ><?php echo pll__('Save Model');?></button>
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
 function  validate_form_brand(){
		 error = 0

		 $('.error').remove()
 brand_name = jQuery('#brand_name').val()
  brand_name_ar = jQuery('#brand_name_ar').val()
				 if(brand_name==""){
				jQuery('#brand_name').parent().append("<span class='error'><?php echo pll__('Please Enter Model Name In English !');?></span>")
				jQuery('#brand_name').focus();
				error = 1;
			}
				 if(brand_name_ar==""){
				jQuery('#brand_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Model Name In Arabic !');?></span>")
				jQuery('#brand_name_ar').focus();
				error = 1;
			}
			if(error ==0){
return true			}else{
	return false;
}
		 
	}
$(document).ready(function() {
	
	
	
$("input[id^='documents']").each(function() {
var id = parseInt(this.id.replace("documents", ""));
$("#documents" + id).change(function() {
if ($("#documents" + id).val() != "") {
$("#moreImageUploadLink").show();
}
});
});

});

function del_uploadedfpfile(item){
jQuery('.document-item-delete-'+item).val(1)
jQuery('.document-item-'+item).hide()

}

function del_uploadedfpfile2(){
jQuery('.document-item-delete-2').val(1)
jQuery('.document-item-2').hide()

}
$(document).ready(function() {
var upload_number = 2;
var uploadgallery_number = 2;
$('#attachMore').click(function() {
//add more file
var moreUploadTag = '';
moreUploadTag += '<div class="element"><label for="documents"' + upload_number + '>Upload File</label>';
moreUploadTag += '<input type="file" id="documents' + upload_number + '" name="documents[]"/>';
moreUploadTag += ' <a href="javascript:del_file(' + upload_number + ')"   class="delete-file" style="cursor:pointer;" onclick="return confirm("Are you really want to delete ?")">x</a></div>';
$('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
upload_number++;
});

});

function del_file(eleId) {
var ele = document.getElementById("delete_file" + eleId);
ele.parentNode.removeChild(ele);
}


</script>

<script>
$(document).ready(function() {
    // Initialize Select2
	$('#brand_model').select2({
					placeholder: globalvar.show_all, // Placeholder text
					allowClear: true,   // Adds the 'X' clear button     
                    sorter: function(data) {
                        return data.sort(function(a, b) {
                            return a.text.localeCompare(b.text); // Sort alphabetically
                        });
                    }
				});
    $('#junkyard-select').select2();
   $('#model_year').select2();
 
});
</script>
