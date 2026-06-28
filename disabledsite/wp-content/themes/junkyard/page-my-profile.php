<?php 
/*
*Template Name: MY PROFILE
*/  
get_header('user');

  
while ( have_posts() ) : the_post(); 
	get_currentuserinfo();
	$current_user = wp_get_current_user();
	$user_email = $current_user->user_email;
	$display_name = $current_user->display_name;										
	$username = $current_user->user_login;
	$user_phone = get_user_meta(get_current_user_id(),'user_phone', true);
	$user_address = get_user_meta(get_current_user_id(),'user_address', true);
	if(isset($_REQUEST['display_name'])){
		$upassword = sanitize_text_field($_REQUEST['upassword']);
		$display_name = sanitize_text_field($_REQUEST['display_name']);
		if ( $upassword && $upassword !== '' ) {
  wp_update_user( array(
    'ID'        => get_current_user_id(),
    'user_pass' => $upassword,
) );

// Refresh the user session tokens to keep the user logged in
wp_clear_auth_cookie();
wp_set_current_user( get_current_user_id());
wp_set_auth_cookie( get_current_user_id() );

     update_user_meta(get_current_user_id(),'uqbttdrow',$upassword);
	 

}
  	 wp_update_user( array(
    'ID'           => get_current_user_id(),
    'display_name' => $display_name
) );
		$success_msg =  pll__('Profile Updated Successfully'); 
	}
	?> 
	<div class="main-panel">
	<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<a class="navbar-brand" href="javascript:;"><?php echo pll__('User Profile');?></a>
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
						<?php 
						if($success_msg !=''){ ?>
							<div class="alert alert-success">
							<span>
								<b><?php echo $success_msg;?></b></span>
							</div>
						<?php } ?>
						<div class="card">
							<div class="card-header card-header-primary">
								<h4 class="card-title"><?php echo pll__('My Profile');?>  </h4>
								<p class="card-category"><?php echo pll__('Edit my profile here');?></p>
							</div>
							<div class="card-body">
								<form   method='post' action='' id='my-profile'>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="bmd-label-floating"><?php echo pll__('Username');?></label>
												<div class="textvalue"><?php echo $username;?></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="bmd-label-floating"><?php echo pll__('Display Name');?></label>
												<input type="text" class="form-control" name='display_name'id='display_name'  value="<?php echo $display_name;?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="bmd-label-floating"><?php echo pll__('New Password');?></label>
												<input type="password" class="form-control" name='upassword'id='upassword'  value="">
											</div>
										</div>
									</div>
									 
									<button type="button" class="btn btn-primary pull-right " name='update_profile' onclick=" validate_form()">
									<?php echo pll__('Update Profile');?>
									</button>
									<div class="clearfix"></div>
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
<script>
	function validate_form(){
		jQuery('.input-error').remove()
		error=0
		if(jQuery('#display_name').val()==''){
			error=1
			jQuery('#display_name').after('<span class="input-error"><?php echo pll__("Please enter display name");?></span>')
		} 
	 
		if( error==0){
			jQuery("#my-profile").submit();
		} 
	} 
</script>
