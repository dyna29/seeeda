<?php

function remove_wp_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'remove_wp_dashboard_widgets');


function custom_dashboard_menu() {
    add_menu_page(
        'Custom Dashboard',  // Page title
        'Dashboard',          // Menu title
        'edit_vehicle',     // Capability
        'custom-dashboard',   // Menu slug
        'custom_dashboard_content', // Callback function
        'dashicons-dashboard', // Icon
        2                     // Position
    );
}
add_action('admin_menu', 'custom_dashboard_menu');

function custom_dashboard_content() {
    echo '<h1>Welcome to your Custom Dashboard!</h1>';
    echo '<p>This is a fully custom dashboard tailored for your needs.</p>';
}
function remove_default_dashboard_menu_item() {
    
        remove_menu_page('index.php'); // Removes the default dashboard menu for non-admins
     
}
add_action('admin_menu', 'remove_default_dashboard_menu_item');
function redirect_users_after_login( $redirect_to, $request, $user ) {
    // If not an admin, redirect to custom dashboard page
	
	exit;
	$user_role = array();
			$user = new WP_User( get_current_user_id() );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role )
					$user_role[] = $role;
			}
     if ( in_array( 'junkyards_administrator', $user->roles ) || in_array( 'junkyard_manager', $user->roles )   ) {
      
            return site_url('user-dashboard'); // Non-admins go to the custom dashboard
        
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_users_after_login', 10, 3);
