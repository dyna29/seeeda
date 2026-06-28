<?php 
/*
*Template Name: Frontend Settings Template
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
	  
	if(isset($_REQUEST['save_settings'])){  
	$disable_ad = sanitize_text_field($_REQUEST['disable_ad']);	 
	$link = sanitize_text_field($_REQUEST['link']);	 
	
	update_post_meta(2,'disable_ad',$disable_ad);
	update_post_meta(164,'disable_ad',$disable_ad);
	update_post_meta(2,'ad_link',$link);
	update_post_meta(164,'ad_link',$link);
   $file = $_FILES['homepage_banner'];	 
		if($file['name']!=''){ 
			// check security nonce which one we created in html form and sending with data.
			//	check_ajax_referer('uploadingFile', 'security');
			// removing white space
			$filename = preg_replace('/\s+/', '-', $_FILES["homepage_banner"]["name"]);
			// removing special character but keep . character because . seprate to extantion of file
			$filename = preg_replace('/[^A-Za-z0-9.\-]/', '', $filename);
			// rename file using time
			$filename = time().'-'.$filename;
			// upload file
			if($ret = wp_upload_bits($filename, null, file_get_contents($_FILES["homepage_banner"]["tmp_name"])))
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
					 
					    update_field('banner', $attachment_id, 2 );
					    update_field('banner', $attachment_id, 164 );
					}
				}
			}  
		} 
   $file = $_FILES['ad_banner'];	 
		if($file['name']!=''){ 
			// check security nonce which one we created in html form and sending with data.
			//	check_ajax_referer('uploadingFile', 'security');
			// removing white space
			$filename = preg_replace('/\s+/', '-', $_FILES["ad_banner"]["name"]);
			// removing special character but keep . character because . seprate to extantion of file
			$filename = preg_replace('/[^A-Za-z0-9.\-]/', '', $filename);
			// rename file using time
			$filename = time().'-'.$filename;
			// upload file
			if($ret = wp_upload_bits($filename, null, file_get_contents($_FILES["ad_banner"]["tmp_name"])))
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
					 
					    update_field('ad_banner', $attachment_id, 2 );
					    update_field('ad_banner', $attachment_id, 164 );
					}
				}
			}  
		}
		  
		$success_msg = pll__('Frontend Settings Updated Successfully');
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

	input.form-control.ad_banner, input.form-control.homepage_banner {
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
							<h4 class="card-title"><?php echo pll__('Frontend Settings');?></h4>
							<p class="card-category"></p>
						</div>
						<?php 
						$homepage_banner = get_field('banner',  2 );
						$ad_banner = get_field('ad_banner',  2 );
						?>
						<div class="card-body">
							<form action='' method='post' class='frm-addeditjunkyard'    enctype='multipart/form-data'>
							
						 	<div class="row attachment-upload" >
								
								 
									<div class="col-md-12">
										<div class="form-group"> 
											<label class="bmd-label-floating upload-label"><?php echo pll__('Home Page Banner');?></label>	
										</div>
									</div>	
									<?php 
								 
									?>
									<div class="col-md-12">
										<div class="form-group"><img src='<?php echo $homepage_banner;?>' width='auto' height='100px'>
										 <input type="file" class="form-control homepage_banner"  name="homepage_banner"  >
										</div>
									</div>
								</div>
						 	<div class="row attachment-upload" >
								
								 
									<div class="col-md-12">
										<div class="form-group"> 
											<label class="bmd-label-floating upload-label"><?php echo pll__('Ad Banner(1920px * 600px)');?></label>	
										</div>
									</div>	
									<?php 
								 
									?>
									<div class="col-md-12">
										<div class="form-group"><img src='<?php echo $ad_banner;?>' width='auto' height='100px'>
										 <input type="file" class="form-control ad_banner"  name="ad_banner"  >
										</div>
									</div>
								</div>
								 		<div class="row">
										 <div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Link');?></label>
											<input type="text" class="form-control  "  name="link" id='link' value="<?php echo get_post_meta(2,'ad_link',true);?>" >
										</div>
									</div> 
									<div class="col-md-12">
										<div class="form-group">
											<label class="bmd-label-floating"><?php echo pll__('Disable Ad');?></label>
											<select class="form-control  "  name="disable_ad" id='disable_ad'>
											<option value="No" <?php if( get_post_meta(2,'disable_ad',true)=="No") { ?>selected<?php } ?>><?php echo pll__('No');?></option>
											<option value="Yes" <?php if( get_post_meta(2,'disable_ad',true)=="Yes") { ?>selected<?php } ?> ><?php echo pll__('Yes');?></option>
											</select>
										</div>
									</div> 
								  
								</div>
 
								<button type="submit" class="btn btn-primary pull-right" id="save-settings" name="save_settings"  ><?php echo pll__('Save Settings');?></button>
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
 
 
