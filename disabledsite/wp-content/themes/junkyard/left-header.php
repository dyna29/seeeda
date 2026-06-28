<?php 

$last_login = get_user_meta(get_current_user_id(), 'last_login', true);
 $timestamp = strtotime($last_login);

    // Format the date as dd-mm-yyyy
    $formatted_date = date('d-m-Y H:i:s', $timestamp);
?>
 <ul class="navbar-nav">
       
              <li class="nav-item"> 
			   <a class="nav-link watch-box" href="#">
                  <i class="material-icons">watch</i><b><?php echo pll__('Last Login');?>: </b> <span class='last-login-txt'><?php echo  $formatted_date;?></span>
                  <p class="d-lg-none d-md-block">
                    Last Login 
                  </p>
                </a> 
              </li>
              <li class="nav-item">
                <?php if(pll_current_language()=='en') 
				{ 
					$post_id = pll_get_post( get_the_ID(),'ar' );
					$link =  get_permalink($post_id);
			 
				 
				 
						
	 	
					?>
					<a href='<?php echo $link;?> ' class='lang-kuwait'>
						<img src='<?php echo get_stylesheet_directory_uri(); ?>/images/AR-icon@2x.png' class='lang-icon'>
					</a>
					<?php 
				} 
				?>
				<?php if(pll_current_language()=='ar') 
				{ 
					$post_id = pll_get_post( get_the_ID(),'en' );
					$link=  get_permalink($post_id);
					if(isset($_REQUEST['id'])){
						
						$id = pll_get_post( $_REQUEST['id'],'en' );
						 if($id==''){ $id =  $_REQUEST['id']; }
						$link = $link.'/?id='.$id;
					}
				 
				 
					?> 
					<a href='<?php echo $link;?>' class='lang-kuwait'>
						<img src='<?php echo get_stylesheet_directory_uri(); ?>/images/EN-icon@2x.png'  data-aos="zoom-in"  data-aos-easing="ease-out-cubic" data-aos-duration="1000" class='lang-icon'>
					</a>
				<?php 
				} 
				?>
              </li>
              <li class="nav-item">
			  
			  <?php 
			   	$page = get_page_by_title('User Dashboard');
					$post_id = pll_get_post( $page->ID,pll_current_language() );
					$vlink = get_permalink($post_id); 
			  ?>
                <a class="nav-link" href="<?php echo $vlink;?>">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
             
			   <li class="nav-item">
                <a class="nav-link" href="<?php echo wp_logout_url();?>">
                  <i class="material-icons">logout</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="<?php echo site_url('my-profile')?>">Profile</a>  
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo wp_logout_url();?>">Log out</a>
                </div>
              </li>
            </ul>