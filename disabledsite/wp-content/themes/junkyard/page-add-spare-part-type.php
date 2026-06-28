<?php
 
/*
*Template Name: Add Spare Part Type Template
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
 
	
	if(isset($_REQUEST['save_spare_part_type'])){ 

		$spare_part_type_name_en = sanitize_text_field($_REQUEST['spare_part_type_name']);
		$spare_part_type_name_ar = sanitize_text_field($_REQUEST['spare_part_type_name_ar']);
 
			// Add the term to the taxonomy
			$new_term = wp_insert_term(
				$spare_part_type_name_en, // Term name
				'spare-part-type', // Taxonomy name
				[
				   
					'parent' => 0, // Set parent term ID if needed; 0 means top-level
				]
			);
				if (!( is_wp_error( $new_term ) )) {
					
					$term_exists = term_exists($spare_part_type_name_ar, 'spare-part-type');

						if ($term_exists) {
							$spare_part_type_name_ar = $spare_part_type_name_ar."(ar)";
						}
			 pll_set_term_language($new_term['term_id'],'en'); 
			 $spare_part_type_en = $new_term['term_id'];
		  
		 
			// Add the term to the taxonomy
			$new_term = wp_insert_term(
				$spare_part_type_name_ar, // Term name
				'spare-part-type', // Taxonomy name
				[
				   
					'parent' => 0, // Set parent term ID if needed; 0 means top-level
				]
			);
			
			 pll_set_term_language($new_term['term_id'],'ar'); 
			  $spare_part_type_ar = $new_term['term_id'];
			  
			  $arr = array('en'=>$spare_part_type_en,'ar'=>$spare_part_type_ar  );
		 pll_save_term_translations($arr);
	 
 
	 $file = $_FILES['featured_image'];	 
		if($file['name']!=''){ 
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
						  
					    update_field('thumbnail', $attachment_id, "term_".$spare_part_type_ar);
						 update_field('thumbnail', $attachment_id, "term_".$spare_part_type_en );
					}
				}
			}  
		}
		 
		$success_msg = 'Spare Part Type Added Successfully';
		}else{
				
		$err_msg = 'Spare Part Type Exists';
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
					<a class="navbar-spare_part_type" href="javascript:;"><?php echo pll__('Add Customer');?></a>
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
		<div class="card">
		<div class="card-header card-header-primary">
		<h4 class="card-title"><?php echo pll__('Add Spare Part Type');?></h4>
		<p class="card-category"></p>
		</div>
		<div class="card-body">
		<form action='' method='post' class='frm-addeditspare_part_type'    enctype='multipart/form-data'> 
								<div class="row attachment-upload" >
								
								 
									<div class="col-md-12">
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
									</div>
								</div>
		<div class="row">
	
		<div class="col-md-6">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Spare Part Type name');?>(EN)</label>
		<input type="text" class="form-control  "  name="spare_part_type_name" id='spare_part_type_name' value="" >
		</div>
		</div>
			<div class="col-md-6">
		<div class="form-group">
		<label class="bmd-label-floating"><?php echo pll__('Spare Part Type name');?>(AR)</label>
		<input type="text" class="form-control  "  name="spare_part_type_name_ar" id='spare_part_type_name_ar' value="" >
		</div>
		</div>

	
	 
	</div>
	 
	 
		<button type="submit" class="btn btn-primary pull-right" id="save-spare_part_type" name="save_spare_part_type" onclick ='return validate_form_spare_part_type()' ><?php echo pll__('Save Spare Part Type');?></button>
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
 function  validate_form_spare_part_type(){
		 error = 0

		 $('.error').remove()
 spare_part_type_name = jQuery('#spare_part_type_name').val()
  spare_part_type_name_ar = jQuery('#spare_part_type_name_ar').val()
				 if(spare_part_type_name==""){
				jQuery('#spare_part_type_name').parent().append("<span class='error'><?php echo pll__('Please Enter Spare Part Type Name In English !');?></span>")
				jQuery('#spare_part_type_name').focus();
				error = 1;
			}
				 if(spare_part_type_name_ar==""){
				jQuery('#spare_part_type_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Spare Part Type Name In Arabic !');?></span>")
				jQuery('#spare_part_type_name_ar').focus();
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
    $('#spare_part_type_model').select2();
    $('#junkyard-select').select2();
   $('#model_year').select2();
 
});
</script>
