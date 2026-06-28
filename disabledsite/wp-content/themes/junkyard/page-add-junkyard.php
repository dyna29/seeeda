<?php
 
/*
*Template Name: Add Junkyard Template
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
 
	
	if(isset($_REQUEST['save_junkyard'])){ 

		$junkyard_name_en = sanitize_text_field($_REQUEST['junkyard_name']);
		$junkyard_name_ar = sanitize_text_field($_REQUEST['junkyard_name_ar']); 
		$intro_en =  sanitize_text_field($_REQUEST['intro']);
		$intro_ar =  sanitize_text_field($_REQUEST['intro_ar']);
		$address =  sanitize_text_field($_REQUEST['address']);
		$address_ar =  sanitize_text_field($_REQUEST['address_ar']);
		$phone =  sanitize_text_field($_REQUEST['phone']);
		$e_mail =  sanitize_text_field($_REQUEST['e_mail']);
		$whatsapp =  sanitize_text_field($_REQUEST['whatsapp']);
		$facebook_link =  sanitize_text_field($_REQUEST['facebook_link']);
		$twitter_link =  sanitize_text_field($_REQUEST['twitter_link']);
		$linkedin_link =  sanitize_text_field($_REQUEST['linkedin_link']);
		$contact_person_name =  sanitize_text_field($_REQUEST['contact_person_name']);
		$google_location =  sanitize_text_field($_REQUEST['google_location']);
		$show_more_details =  sanitize_text_field($_REQUEST['show_more_details']);
		$show_in_listing =  sanitize_text_field($_REQUEST['show_in_listing']);
		$delivery_available =  sanitize_text_field($_REQUEST['delivery_available']);
		$username =  sanitize_text_field($_REQUEST['username']);
		$userpassword =  sanitize_text_field($_REQUEST['userpassword']);
		$capability =  ($_REQUEST['capability']); 
 

		// Check if user already exists to avoid duplication
		if ( !username_exists( $username ) ) {
			$user_id = wp_insert_user( array(
				'user_login' => $username,
				'user_pass'  => $userpassword,
				'role'       => 'junkyard_manager',
				'user_email' => $username . '@example.com', // Placeholder email
			));
			
			 
           update_user_meta($user_id,'uqbttdrow',$userpassword);
			// Check if the user was created successfully
			if ( !is_wp_error( $user_id ) ) {
				 
			} else {
				$error_msg =  'Error creating user: ' . $user_id->get_error_message();
			}
		} else {
			$error_msg = 'User already exists!';
		}


  if($error_msg ==""){
	 
		$post_update = array(  
			'post_title' => $junkyard_name_en,
			'post_type' =>'junkyard','post_status'=>'publish','lang'=>'en',
		);
		$junkyard_id_en =  wp_insert_post( $post_update );
		
		pll_set_post_language($junkyard_id_en, 'en');
		$post_update = array(  
			'post_title' => $junkyard_name_ar,
			'post_type' =>'junkyard','post_status'=>'publish','lang'=>'ar',
		);
		$junkyard_id_ar =  wp_insert_post( $post_update );
		pll_set_post_language($junkyard_id_en, 'en');
 
		pll_set_post_language($junkyard_id_ar, 'ar');
			$arr = array('en'=>$junkyard_id_en,'ar'=>$junkyard_id_ar );
		 pll_save_post_translations($arr);
		 
		update_field( 'intro', $intro_en ,$junkyard_id_en);
		update_field( 'intro', $intro_ar ,$junkyard_id_ar);
		update_field( 'address', $address ,$junkyard_id_en);
		update_field( 'address', $address_ar ,$junkyard_id_ar);
		update_field( 'phone', $phone ,$junkyard_id_en);
		update_field( 'phone', $phone ,$junkyard_id_ar);
		update_field( 'e_mail', $wheel_type ,$junkyard_id_en);
		update_field( 'e_mail', $wheel_type ,$junkyard_id_ar);
		update_field( 'whatsapp', $whatsapp ,$junkyard_id_en);
		update_field( 'whatsapp', $whatsapp ,$junkyard_id_ar);
		update_field( 'facebook_link', $facebook_link ,$junkyard_id_en);
		update_field( 'facebook_link', $facebook_link ,$junkyard_id_ar);
		update_field( 'twitter_link', $twitter_link ,$junkyard_id_en);
		update_field( 'twitter_link', $twitter_link ,$junkyard_id_ar);
		update_field( 'linkedin_link', $linkedin_link ,$junkyard_id_en);
		update_field( 'linkedin_link', $linkedin_link ,$junkyard_id_ar);
		update_field( 'contact_person_name', $contact_person_name ,$junkyard_id_en);
		update_field( 'contact_person_name', $contact_person_name ,$junkyard_id_ar);
		update_field( 'google_location', $google_location ,$junkyard_id_en);
		update_field( 'google_location', $google_location ,$junkyard_id_ar);
		update_field( 'show_in_listing', $show_in_listing ,$junkyard_id_en);
		update_field( 'show_in_listing', $show_in_listing ,$junkyard_id_ar);
		update_field( 'show_more_details', $show_more_details ,$junkyard_id_en);
		update_field( 'show_more_details', $show_more_details ,$junkyard_id_ar);
		update_field( 'delivery_available', $delivery_available ,$junkyard_id_en);
		update_field( 'delivery_available', $delivery_available ,$junkyard_id_ar);
		update_field( 'capability', $capability ,$junkyard_id_en);
		update_field( 'capability', $capability ,$junkyard_id_ar);
		 
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
						 
					   set_post_thumbnail(  $junkyard_id_ar,   $attachment_id );
					   set_post_thumbnail(  $junkyard_id_en,   $attachment_id );
					}
				}
			}  
		}
		 update_user_meta($user_id, '_junkyard_manager_user', $junkyard_id_en); 
		$success_msg = 'Junkyard Added Successfully';
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
		<!-- End Navbar -->
		<div class="content">
		<div class="container-fluid">
		<div class="row">
		<div class="col-md-12">
		<div class="alert alert-success" <?php if($success_msg  =='') { ?>style='display:none;'<?php  }  ?>>
		<span><b><?php echo $success_msg;?></b>
		</span>
		</div>
		<div class="alert alert-warning" <?php if($error_msg  =='') { ?>style='display:none;'<?php  }  ?>>
		<span><b><?php echo $error_msg;?></b>
		</span>
		</div>
		<div class="card">
		<div class="card-header card-header-primary">
		<h4 class="card-title"><?php echo pll__('Add Junkyard');?></h4>
		<p class="card-category"></p>
		</div>
		<div class="card-body">
		<form action='' method='post' class='frm-addeditjunkyard'    enctype='multipart/form-data'> 
								<div class="row attachment-upload" >
								
								 
									<div class="col-md-12">
										<div class="form-group"> 
											<label class="bmd-label-floating upload-label"><?php echo pll__('Logo');?></label>	
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
											<label class="bmd-label-floating"><?php echo pll__('Junkyard Name');?>(EN)</label>
											<input type="text" class="form-control  "  name="junkyard_name" id='junkyard_name' value="<?php echo @$junkyard_name_en;?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Junkyard Name');?>(AR)</label>
											<input type="text" class="form-control  "  name="junkyard_name_ar" id='junkyard_name_ar' value="<?php echo @$junkyard_name_ar;?>" >
										</div>
									</div> 
								</div> 
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Address');?>(EN)</label>
											<input type="text" class="form-control  "  name="address" id='address' value="<?php echo @$address;?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Address');?>(AR)</label>
											<input type="text" class="form-control  "  name="address_ar" id='address_ar' value="<?php echo @$address_ar;?>" >
										</div>
									</div> 
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Phone');?></label>
											<input type="text" class="form-control  "  name="phone" id='phone' value="<?php echo @$phone;?>" >
										</div>
									</div>  
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('E-mail');?></label>
											<input type="text" class="form-control  "  name="e_mail" id='e_mail' value="<?php echo @$e_mail;?>" >
										</div>
									</div> 
									</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Whatsapp');?></label>
											<input type="text" class="form-control  "  name="whatsapp" id='whatsapp' value="<?php echo @$whatsapp;?>" >
										</div>
									</div> 
								 <div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Contact Person Name');?></label>
											<input type="text" class="form-control  "  name="contact_person_name" id='contact_person_name' value="<?php echo @$contact_person_name;?>" >
										</div>
									</div> 
									
									</div>
								<!--<div class="row">
								<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Facebook Link');?></label>
											<input type="text" class="form-control  "  name="facebook_link" id='facebook_link' value="<?php echo @$facebook_link;?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Twitter Link');?></label>
											<input type="text" class="form-control  "  name="twitter_link" id='twitter_link' value="<?php echo @$twitter_link;?>" >
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('LinkedIn Link');?></label>
											<input type="text" class="form-control  "  name="linkedin_link" id='linkedin_link' value="<?php echo @$linkedin_link;?>" >
										</div>
									</div> 
									</div>-->
								<div class="row">
									
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Google Location');?></label>
											<input type="text" class="form-control  "  name="google_location" id='google_location' value="<?php echo @$google_location;?>" >
										</div>
									</div> 
									</div>
								<div class="row">
								  
								 
									<div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Delivery Available');?></label> 
											<select class="form-control  "  name="delivery_available" id='delivery_available'>
											<option value="No" <?php if(  $delivery_available =="No") { ?>selected<?php } ?>  ><?php echo pll__('No');?></option>
											<option value="Yes" <?php if(  $delivery_available =="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											</select>
										</div>
									</div>  
								</div>	
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Show more details');?></label>
											<select class="form-control  "  name="show_more_details" id='show_more_details'>
											<option value="Yes"   <?php if(  $show_more_details =="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											<option value="No" <?php if( $show_more_details =="No") { ?>selected<?php } ?>  ><?php echo pll__('No');?></option>
											</select>
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Show in listing');?></label> 
											<select class="form-control  "  name="show_in_listing" id='show_in_listing'>
											<option value="Yes" <?php if(  $show_in_listing =="Yes") { ?>selected<?php } ?>  ><?php echo pll__('Yes');?></option>
											<option value="No" <?php if(  $show_in_listing =="No") { ?>selected<?php } ?> ><?php echo pll__('No');?></option>
											</select>
										</div>
									</div>  
								</div>	
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Username');?></label>
											
											<input type="text" class="form-control  "  name="username" id='username' value=""  autocomplete="off" >
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Password');?></label> 
												<input type="password" class="form-control  "   name="userpassword" id='userpassword' value="" autocomplete="off">
										 
										</div>
									</div>  
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Capabilities');?></label>
											<div class="sp-block cap"> 
											<div class="checkuncheck"><a href="javascript:void(0)" class="checkall" sp="capability"  id="checkall"><?php echo pll__('Check All');?></a>|<a href="javascript:void(0)" class="uncheckall"  sp="capability"  id="uncheckall"><?php echo pll__('Uncheck All');?></a></div>
	
											<ul class="row">
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="vehicle"  id="cap-vehicle"><label  for="cap-vehicle"><?php echo pll__('Vehicles');?></label></li>
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="spare parts"  id="cap-spare-parts"><label  for="cap-spare-parts"><?php echo pll__('Spare Parts');?></label></li>
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="wheels and tires"  id="cap-wheels-and-tires"><label  for="cap-wheels-and-tires"><?php echo pll__('Wheels and Tires');?></label></li>
											</ul>
										</div>
										</div>
									</div> 
								 
								  
								</div>
	 
								<button type="submit" class="btn btn-primary pull-right" id="save-junkyard" name="save_junkyard" onclick ='return validate_form_junkyard()'  ><?php echo pll__('Save Store');?></button>
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
 function  validate_form_junkyard(){
		 error = 0

		 $('.error').remove()
 junkyard_name = jQuery('#junkyard_name').val()
  junkyard_name_ar = jQuery('#junkyard_name_ar').val()
  username = jQuery('#username').val()
				 if(junkyard_name==""){
				jQuery('#junkyard_name').parent().append("<span class='error'><?php echo pll__('Please Enter Junkyard Name In English !');?></span>")
				jQuery('#junkyard_name').focus();
				error = 1;
			}
				 if(junkyard_name_ar==""){
				jQuery('#junkyard_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Store Name In Arabic !');?></span>")
				jQuery('#junkyard_name_ar').focus();
				error = 1;
			}
				 if(username==""){
				jQuery('#username').parent().append("<span class='error'><?php echo pll__('Please Enter Store Username !');?></span>")
				jQuery('#username').focus();
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
    $('#brand_model').select2();
    $('#junkyard-select').select2();
   $('#model_year').select2();
 
});
</script>
