<?php 
/*
*Template Name: Edit Junkyard Template
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
	if(isset($_REQUEST["id"])){
		$junkyard_id_en = pll_get_post($_REQUEST["id"],'en' );
	    $junkyard_id_ar = pll_get_post($_REQUEST["id"],'ar' );
	    $junkyard_id_curr = pll_get_post($_REQUEST["id"],pll_current_language() );
	} 
 
										$user = get_users( array(
												'meta_key'   => '_junkyard_manager_user',
												'meta_value' => $junkyard_id_en,
												'fields'      => 'ID' // To retrieve only the user ID
											) ); 
											if ( ! empty( $user ) ) {
												// User ID
												$user_id = $user[0];
											}
								  
									// Get the results
									$user_info = get_userdata( $user_id );

									if ( $user_info ) {
										$username = $user_info->user_login;
									}

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


if ( $userpassword && $userpassword !== 'password' ) {
    // Update the user's password
    wp_set_password( $userpassword, $user_id );
     update_user_meta($user_id,'uqbttdrow',$userpassword);
}
  
	 
		$post_update = array( 
			'ID'         => $junkyard_id_en,
			'post_title' => $junkyard_name_en,
			'post_type' =>'junkyard','post_status'=>'publish','lang'=>'en',
		);
		 
		$junkyard_id_en =  wp_update_post( $post_update );
		
		pll_set_post_language($junkyard_id_en, 'en');
		$post_update = array( 
			'ID'         => $junkyard_id_ar,
			'post_title' => $junkyard_name_ar,
			'post_type' =>'junkyard','post_status'=>'publish','lang'=>'ar',
		);
		$junkyard_id_ar =  wp_update_post( $post_update );
 
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
		  
		$success_msg = pll__('Junkyard Updated Successfully');
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
							<h4 class="card-title"><?php echo pll__('Edit Junkyard');?></h4>
							<p class="card-category"></p>
						</div>
						<?php 
						$_associated_junkyard = get_post_meta( $junkyard_id_en,'_associated_junkyard',true);  
						$featuredimage = wp_get_attachment_image_src( get_post_thumbnail_id( $junkyard_id_en ), 'full' ); 	
						?>
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
											<input type="text" class="form-control  "  name="junkyard_name" id='junkyard_name' value="<?php echo get_the_title($junkyard_id_en);?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Junkyard Name');?>(AR)</label>
											<input type="text" class="form-control  "  name="junkyard_name_ar" id='junkyard_name_ar' value="<?php echo get_the_title($junkyard_id_ar);?>" >
										</div>
									</div> 
								</div> 
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Address');?>(EN)</label>
											<input type="text" class="form-control  "  name="address" id='address' value="<?php echo get_field('address',$junkyard_id_en);?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Address');?>(AR)</label>
											<input type="text" class="form-control  "  name="address_ar" id='address_ar' value="<?php echo get_field('address',$junkyard_id_ar);?>" >
										</div>
									</div> 
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Phone');?></label>
											<input type="text" class="form-control  "  name="phone" id='phone' value="<?php echo get_field('phone',$junkyard_id_curr);?>" >
										</div>
									</div>  
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('E-mail');?></label>
											<input type="text" class="form-control  "  name="e_mail" id='e_mail' value="<?php echo get_field('e-mail',$junkyard_id_curr);?>" >
										</div>
									</div> 
									</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Whatsapp');?></label>
											<input type="text" class="form-control  "  name="whatsapp" id='whatsapp' value="<?php echo get_field('whatsapp',$junkyard_id_curr);?>" >
										</div>
									</div> 
								 <div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Contact Person Name');?></label>
											<input type="text" class="form-control  "  name="contact_person_name" id='contact_person_name' value="<?php echo get_field('contact_person_name',$junkyard_id_curr);?>" >
										</div>
									</div> 
									
									</div>
								<!--<div class="row">
								<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Facebook Link');?></label>
											<input type="text" class="form-control  "  name="facebook_link" id='facebook_link' value="<?php echo get_field('facebook_link',$junkyard_id_curr);?>" >
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Twitter Link');?></label>
											<input type="text" class="form-control  "  name="twitter_link" id='twitter_link' value="<?php echo get_field('twitter_link',$junkyard_id_curr);?>" >
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('LinkedIn Link');?></label>
											<input type="text" class="form-control  "  name="linkedin_link" id='linkedin_link' value="<?php echo get_field('linkedin_link',$junkyard_id_curr);?>" >
										</div>
									</div> 
									</div>-->
								<div class="row">
									
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Google Location');?></label>
											<input type="text" class="form-control  "  name="google_location" id='google_location' value="<?php echo get_field('google_location',$junkyard_id_curr);?>" >
										</div>
									</div> 
									</div>
								<div class="row">
									 
								 
									<div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Delivery Available');?></label> 
											<select class="form-control  "  name="delivery_available" id='delivery_available'>
											<option value="No" <?php if( get_field('delivery_available',$junkyard_id_curr)=="No") { ?>selected<?php } ?> ><?php echo pll__('No');?></option>
											<option value="Yes" <?php if( get_field('delivery_available',$junkyard_id_curr)=="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											</select>
										</div>
									</div>  
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Show more details');?></label>
											<select class="form-control  "  name="show_more_details" id='show_more_details'>
											<option value="Yes" <?php if( get_field('show_more_details',$junkyard_id_curr)=="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											<option value="No" <?php if( get_field('show_more_details',$junkyard_id_curr)=="No") { ?>selected<?php } ?>><?php echo pll__('No');?></option>
											</select>
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Show in listing');?></label> 
											<select class="form-control  "  name="show_in_listing" id='show_in_listing'>
											<option value="Yes" <?php if( get_field('show_in_listing',$junkyard_id_curr)=="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											<option value="No" <?php if( get_field('show_in_listing',$junkyard_id_curr)=="No") { ?>selected<?php } ?> ><?php echo pll__('No');?></option>
											</select>
										</div>
									</div>  
								</div>
	 <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Username');?></label>
											
											<input type="text" class="form-control  "  name="username" id='username' value="<?php echo $username;?>" readonly  autocomplete="off">
										</div>
									</div> 
								 
									<div class="col-md-6">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Password');?></label> 
												<input type="password" class="form-control  "   name="userpassword" id='userpassword' value="password"  autocomplete="off">
										 
										</div>
									</div>  
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Capabilities');?></label>
											<div class="sp-block cap"> 
											<div class="checkuncheck"><a href="javascript:void(0)" class="checkall" sp="capability"  id="checkall"><?php echo pll__('Check All');?></a>|<a href="javascript:void(0)" class="uncheckall"  sp="capability"  id="uncheckall"><?php echo pll__('Uncheck All');?></a></div>
											<?php $capability = get_field('capability',$junkyard_id_curr);
											if(!(is_array($capability))){
												$capability = array();
											}
											?>
											<ul class="row">
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="vehicle"  id="cap-vehicle" <?php if(in_array('vehicle',$capability)){ ?> checked <?php } ?>><label  for="cap-vehicle"><?php echo pll__('Vehicles');?></label></li>
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="spare parts"  id="cap-spare-parts" <?php if(in_array('spare parts',$capability)){ ?> checked <?php } ?>><label  for="cap-spare-parts"><?php echo pll__('Spare Parts');?></label></li>
												<li class="col-md-4"><input type="checkbox" name="capability[]" class="sp-capability" value="wheels and tires"  id="cap-wheels-and-tires" <?php if(in_array('wheels and tires',$capability)){ ?> checked <?php } ?>><label  for="cap-wheels-and-tires"><?php echo pll__('Wheels and Tires');?></label></li>
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
				 if(junkyard_name==""){
				jQuery('#junkyard_name').parent().append("<span class='error'><?php echo pll__('Please Enter Store Name In English !');?></span>")
				jQuery('#junkyard_name').focus();
				error = 1;
			}
				 if(junkyard_name_ar==""){
				jQuery('#junkyard_name_ar').parent().append("<span class='error'><?php echo pll__('Please Enter Store Name In Arabic !');?></span>")
				jQuery('#junkyard_name_ar').focus();
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
