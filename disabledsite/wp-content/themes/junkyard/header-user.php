<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="windows-1256" />
			<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/apple-icon.png">
			<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/img/fav.png">
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
			<title>
				Seeeda
			</title>
			<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
			<!--     Fonts and icons     -->
			<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
			<!-- CSS Files -->
			<link href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
			<!-- CSS Just for demo purpose, don't include it in your project -->
			<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
			<link href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
			<link href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/css/responsive.dataTables.min.css" rel="stylesheet" />
			<link href="<?php echo get_stylesheet_directory_uri(); ?>/employee-portal/assets/css/custom.css?v=<?php echo date('ymdhis')?>" rel="stylesheet" /> 
			<?php wp_head();?> 
			<?php 
			if(!(is_user_logged_in()))
			{
				?> 
				<script>        
					document.location =  '<?php echo site_url();?>';
				</script>
				<?php
				exit;
			}
			global $post;
			$user_role = array();
			$user = new WP_User( get_current_user_id() );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role )
					$user_role[] = $role;
			}
		 
		 
			if( !(in_array("junkyards_administrator", $user_role))&&    !(in_array("junkyard_manager", $user_role))  )
			{
			?> 
				<script>        
					document.location =  '<?php echo site_url();?>';
				</script>
			<?php
			} 
			?>
	</head>
	<body <?php body_class(); ?>>
		<div class="wrapper ">
			<div class="sidebar" data-color="purple" data-background-color="white"  >
				<div class="logo user-name">
					<?php $current_user = wp_get_current_user();?>
					<i class="material-icons">person</i><h4><?php echo $current_user->display_name ;?></h4>
					</a>
				</div>
				<div class="sidebar-wrapper">
					<ul class="nav">
					<?php
					$data = get_userdata( get_current_user_id());
					if ( is_object( $data) ) 
					{
						
						if( (in_array("junkyards_administrator", $user_role))||   (in_array("junkyard_manager", $user_role))  )
						{
						$page = get_page_by_title('User Dashboard');
						$post_id = pll_get_post( $page->ID,pll_current_language() );
						$link = get_permalink($post_id); 
						?> 
						<li class="nav-item ">
							<a href="<?php echo $link; ?>" class="nav-link " >
								<i class="material-icons">dashboard</i> <?php echo pll__('User Dashboard');?>
							</a>
						</li>
						<?php 
						
						}
						if( (in_array("junkyards_administrator", $user_role))||   (in_array("junkyard_manager", $user_role))  )
						{
						$page = get_page_by_title('My Profile');
						$post_id = pll_get_post( $page->ID,pll_current_language() );
						$link = get_permalink($post_id); 
						?> 
						<li class="nav-item ">
							<a href="<?php echo $link; ?>" class="nav-link " >
								<i class="material-icons">assignment_ind</i> <?php echo pll__('My Profile');?>
							</a>
						</li>
						<?php 
						}
						if( (in_array("junkyards_administrator", $user_role))   )
						{
							$page = get_page_by_title('Store Management');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Store Management');?>
								</a>
							</li>
							<?php
						 
						}
						 
						if( in_array("junkyard_manager", $user_role)){
								
							$_junkyard  =  get_user_meta(get_current_user_id(), '_junkyard_manager_user', true);
							$capability =  get_field('capability',$_junkyard);

							if(!is_array($capability)){
								$capability = array();
							}
						}
					 
						if( (in_array("junkyards_administrator", $user_role)) ||   (in_array("junkyard_manager", $user_role) && (in_array('vehicle',$capability)))  )
						{
							$page = get_page_by_title('Vehicle Management');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Vehicle Management');?>
								</a>
							</li>
							<?php
						 
						}
						if( (in_array("junkyards_administrator", $user_role))||   (in_array("junkyard_manager", $user_role) && (in_array('spare parts',$capability)))    )
						{
						 $page = get_page_by_title('Spare Part Management');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Spare Part Management');?>
								</a>
							</li>
							<?php
							
						}
						if( (in_array("junkyards_administrator", $user_role))  )
						{
							 $page = get_page_by_title('Brand List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Brand List');?>
								</a>
							</li>
							<?php
							
							
						}
						if( (in_array("junkyards_administrator", $user_role))   )
						{
							 $page = get_page_by_title('Model List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Model List');?>
								</a>
							</li>
							<?php
						}
						if( (in_array("junkyards_administrator", $user_role))   )
						{
							 $page = get_page_by_title('Model Year List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Model Year List');?>
								</a>
							</li>
							<?php
						}
						if( (in_array("junkyards_administrator", $user_role))  )
						{
							 $page = get_page_by_title('Spare Part Type List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Spare Part Type List');?>
								</a>
							</li>
							<?php
						}
						if( (in_array("junkyards_administrator", $user_role))   )
						{ 
							 $page = get_page_by_title('Spare Part Sub Type List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id);
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Spare Part Sub Type List');?>
								</a>
							</li>
							<?php
							
						}
						if( (in_array("junkyards_administrator", $user_role))  )
						{
							
							 $page = get_page_by_title('Wheel Size List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id); 
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Wheel Size List');?>
								</a>
							</li>
							<?php
							
							
						}
						if( (in_array("junkyards_administrator", $user_role))  )
						{ 
							 $page = get_page_by_title('Wheel Lug Nut List');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id);
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Wheel Lug Nut List');?>
								</a>
							</li>
							<?php
						}
							if( (in_array("junkyards_administrator", $user_role))||   (in_array("junkyard_manager", $user_role))    )
						{
					 $page = get_page_by_title('Calling Reports');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id);
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Calling Reports');?>
								</a>
							</li>
							<?php
						}
			 
							if( (in_array("junkyards_administrator", $user_role))   )
						{
					 $page = get_page_by_title('Frontend Settings');
							$post_id = pll_get_post( $page->ID,pll_current_language() );
							$link = get_permalink($post_id);
							?> 
							<li class="nav-item ">
								<a href="<?php echo $link; ?>" class="nav-link " >
									<i class="material-icons">grading</i> <?php echo pll__('Frontend Settings');?>
								</a>
							</li>
							<?php
						}
				}
				?>
				</ul>
				</div>
			</div>