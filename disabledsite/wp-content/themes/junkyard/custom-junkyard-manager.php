<?php  


function add_brand_capabilities_to_junkyard_admin() {
    // Get the 'junkyard_administrator' role
    $role = get_role('junkyard_manager');
 if ($role) {
    // Add capabilities specific to the 'brand' taxonomy
    $role->add_cap('manage_model-year');  // Capability to manage the 'brand' taxonomy
    $role->add_cap('edit_model-year');    // Capability to edit terms in 'brand'
    $role->add_cap('delete_model-year');  // Capability to delete terms in 'brand'
    $role->add_cap('assign_model-year');  // Capability to assign terms in 'brand' to posts
 }
    $role = get_role('junkyards_administrator');
 if ($role) {
    // Add capabilities specific to the 'brand' taxonomy
    $role->add_cap('manage_model-year');  // Capability to manage the 'brand' taxonomy
    $role->add_cap('edit_model-year');    // Capability to edit terms in 'brand'
    $role->add_cap('delete_model-year');  // Capability to delete terms in 'brand'
    $role->add_cap('assign_model-year');  // Capability to assign terms in 'brand' to posts
 }
}
add_action('init', 'add_brand_capabilities_to_junkyard_admin');

// Register the meta box
function add_junkyard_manager_creation_metabox() {
	 if (function_exists('pll_current_language') && pll_current_language() == 'en') {
    add_meta_box(
        'junkyard_manager_creation_box',   // Meta box ID
        'Create/Edit Junkyard Manager',    // Meta box title
        'junkyard_manager_creation_html',  // Callback function to display form
        'junkyard',           // Custom post type slug (replace with your actual slug)
        'side',                            // Context
        'high'                             // Priority
    );
	 }
}
add_action('add_meta_boxes', 'add_junkyard_manager_creation_metabox');

// Callback function to display the form
function junkyard_manager_creation_html($post) {
    // Security nonce for verification
    wp_nonce_field('create_junkyard_manager_nonce', 'junkyard_manager_nonce');

    // Check if a junkyard manager user is already associated with the post
    $junkyard_manager_id = get_post_meta($post->ID, '_junkyard_manager_user', true);
    $junkyard_manager_user = !empty($junkyard_manager_id) ? get_userdata($junkyard_manager_id) : null;

    // Username field (readonly if user exists)
    if ($junkyard_manager_user) {
        // If user exists, show readonly username
        ?>
        <label for="junkyard_manager_username">Username (readonly):</label>
        <input type="text" id="junkyard_manager_username" name="junkyard_manager_username" value="<?php echo esc_attr($junkyard_manager_user->user_login); ?>" readonly><br><br>
        <?php
    } else {
        // If no user exists, allow username input
        ?>
        <label for="junkyard_manager_username">Username:</label>
        <input type="text" id="junkyard_manager_username" name="junkyard_manager_username" required><br><br>
        <?php
    }

    // Email field (readonly if user exists)
    if ($junkyard_manager_user) {
        ?>
        <label for="junkyard_manager_email">Email (readonly):</label>
        <input type="email" id="junkyard_manager_email" name="junkyard_manager_email" value="<?php echo esc_attr($junkyard_manager_user->user_email); ?>" readonly><br><br>
        <?php
    } else {
        ?>
        <label for="junkyard_manager_email">Email:</label>
        <input type="email" id="junkyard_manager_email" name="junkyard_manager_email" required><br><br>
        <?php
    }

    // Password field (editable to update)
    ?>
    <label for="junkyard_manager_password">New Password:</label>
    <input type="password" id="junkyard_manager_password" name="junkyard_manager_password" placeholder="Enter new password"><br><br>
    <?php
}

// Save the new or updated user when the post is saved
function create_or_update_junkyard_manager_user($post_id) {
    // Verify the nonce before saving
    if (!isset($_POST['junkyard_manager_nonce']) || !wp_verify_nonce($_POST['junkyard_manager_nonce'], 'create_junkyard_manager_nonce')) {
        return $post_id;
    }

    // Check if a user already exists for the post
    $junkyard_manager_id = get_post_meta($post_id, '_junkyard_manager_user', true);

    if (empty($junkyard_manager_id)) {
        // If no user exists, create a new one
        if (isset($_POST['junkyard_manager_username']) && isset($_POST['junkyard_manager_email']) && isset($_POST['junkyard_manager_password'])) {
            $username = sanitize_text_field($_POST['junkyard_manager_username']);
            $email = sanitize_email($_POST['junkyard_manager_email']);
            $password = sanitize_text_field($_POST['junkyard_manager_password']);

            // Ensure the username and email don't already exist
            if (!username_exists($username) && !email_exists($email)) {
                // Create the new user with the "Junkyard Manager" role
                $user_id = wp_create_user($username, $password, $email);
                if (!is_wp_error($user_id)) {
                    $user = new WP_User($user_id);
                    $user->set_role('junkyard_manager');

                    // Save the user ID in post meta
                    update_post_meta($post_id, '_junkyard_manager_user', $user_id);
                }
            }
        }
    } else {
        // If a user already exists, update the password if provided
        if (isset($_POST['junkyard_manager_password']) && !empty($_POST['junkyard_manager_password'])) {
            $new_password = sanitize_text_field($_POST['junkyard_manager_password']);
            wp_set_password($new_password, $junkyard_manager_id);
        }
    }
}
add_action('save_post', 'create_or_update_junkyard_manager_user');



//vehicle to Junkyard


 function add_junkyard_metabox() {
    add_meta_box(
        'junkyard_selector',
        'Select Junkyard',
        'junkyard_selector_callback',
        array('vehicle','spare-part'), // Assuming the custom post type is 'vehicle'
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_junkyard_metabox');

function junkyard_selector_callback($post) {
	 
    $current_user = wp_get_current_user();
    $user_role = $current_user->roles[0];

    // Check if the current user is a junkyard_administrator
    if (in_array('junkyards_administrator', $current_user->roles) || in_array('administrator', $current_user->roles)) {
			 
        // Get all junkyards
        $junkyards = get_posts(array(
            'post_type' => 'junkyard',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'lang' => 'en',
        )); 
        $selected_junkyard = get_post_meta($post->ID, '_associated_junkyard', true);

        echo '<label for="junkyard_selector">Select Junkyard:</label>';
        echo '<select id="junkyard_selector" name="junkyard_selector">';
        foreach ($junkyards as $junkyard) {
            $selected = ($junkyard->ID == $selected_junkyard) ? 'selected' : '';
            echo '<option value="' . esc_attr($junkyard->ID) . '" ' . $selected . '>' . esc_html($junkyard->post_title) . '</option>';
        }
        echo '</select>';
    } elseif (in_array('junkyard_manager', $current_user->roles)) {
        // Auto-assign for junkyard_manager
        $junkyard_id = get_user_meta($current_user->ID, '_junkyard_manager_user', true);
        if ($junkyard_id) {
            echo '<input type="hidden" name="junkyard_selector" value="' . esc_attr($junkyard_id) . '" />';
        }
    }
}


function get_junkyard_for_manager($user_id = null) {
    // Get the current user if no user ID is provided
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    // Check if the user has the 'junkyard_manager' role
    $user = get_userdata($user_id);
    if (in_array('junkyard_manager', $user->roles)) {
        // Query for the junkyard post associated with this user
        $args = array(
            'post_type'  => 'junkyard',
            'meta_query' => array(
                array(
                    'key'   => '_junkyard_manager_user', // Meta key linking junkyard to user
                    'value' => $user_id,                 // Current user's ID
                    'compare' => '='
                ),
            ),
            'posts_per_page' => 1, // Only expect one junkyard per manager
        );

        $junkyard_query = new WP_Query($args);

        if ($junkyard_query->have_posts()) {
            // Return the junkyard post if found
            return $junkyard_query->posts[0];
        }
    }

    // Return false if no junkyard found or user is not a junkyard_manager
    return false;
}


// Save the selected junkyard when a vehicle post is saved
function save_junkyard_selection($post_id) {

 $current_user = wp_get_current_user();
			$user_role = $current_user->roles[0];
    // Check if the current user is a junkyard_manager

    if (in_array('junkyard_manager', $current_user->roles)) {
		
		    // Query for the junkyard post associated with this user
        $args = array(
            'post_type'  => 'junkyard',
            'meta_query' => array(
                array(
                    'key'   => '_junkyard_manager_user', // Meta key linking junkyard to user
                    'value' => get_current_user_id(),                 // Current user's ID
                    'compare' => '='
                ),
            ),
            'posts_per_page' => 1, // Only expect one junkyard per manager
        );
 
        $junkyard_query = new WP_Query($args);

        if ($junkyard_query->have_posts()) {
          update_post_meta($post_id, '_associated_junkyard',$junkyard_query->posts[0]->ID);
			 
        }
			

 
		
	}else{
		 if (array_key_exists('junkyard_selector', $_POST)) {
				update_post_meta($post_id, '_associated_junkyard', $_POST['junkyard_selector']);
			}
			  
	}
}
add_action('save_post', 'save_junkyard_selection');


function filter_vehicles_for_manager($query) {
    // Check if we are in the admin area and querying the 'vehicle' post type
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'vehicle') {
        // Get the current user
        $current_user_id = get_current_user_id();
        $user = wp_get_current_user();

        // Check if the user has the 'junkyard_manager' role
        if (in_array('junkyard_manager', (array) $user->roles)) {
            // Get the associated junkyard
            $junkyard = get_junkyard_for_manager($current_user_id); // Use the previous function

            if ($junkyard) {
                // Filter by associated junkyard
                $query->set('meta_query', array(
                    array(
                        'key'     => '_associated_junkyard',
                        'value'   => $junkyard->ID,
                        'compare' => '='
                    ),
                ));
            } else {
                // If no junkyard is found, you might want to show no results
                $query->set('posts_per_page', 0); // Show no vehicles if no junkyard is associated
            }
        }
    }
}
add_action('pre_get_posts', 'filter_vehicles_for_manager');
function add_junkyard_column($columns) {
    // Get the position of the date column
	 if (current_user_can('junkyards_administrator') ||current_user_can('manage_options')) {
    $date_position = array_search('date', array_keys($columns));

    // Insert the Junkyard column before the Date column
    $columns = array_slice($columns, 0, $date_position, true) + 
               array('junkyard' => 'Junkyard') + 
               array_slice($columns, $date_position, null, true);
}
    return $columns;
	 
}
add_filter('manage_vehicle_posts_columns', 'add_junkyard_column');

function display_junkyard_column($column, $post_id) {
    if ($column === 'junkyard') {
        $associated_junkyard_id = get_post_meta($post_id, '_associated_junkyard', true);
         
        if ($associated_junkyard_id) {
            $junkyard_post = get_post($associated_junkyard_id);
            if ($junkyard_post) {
                echo esc_html($junkyard_post->post_title);
            } else {
                echo 'No Junkyard';
            }
        } else {
            echo 'Not Assigned';
        }
    }
}
add_action('manage_vehicle_posts_custom_column', 'display_junkyard_column', 10, 2);


function add_spare_part_column($columns) {
    // Get the position of the date column
	 if (current_user_can('junkyards_administrator')||current_user_can('manage_options')) {
    $date_position = array_search('date', array_keys($columns));

    // Insert the Junkyard column before the Date column
    $columns = array_slice($columns, 0, $date_position, true) + 
               array('junkyard' => 'Junkyard') + 
               array_slice($columns, $date_position, null, true);
}
    return $columns;
	 
}
add_filter('manage_spare-part_posts_columns', 'add_spare_part_column');

function display_junkyard_spare_part_column($column, $post_id) {
    if ($column === 'junkyard') {
        $associated_junkyard_id = get_post_meta($post_id, '_associated_junkyard', true);
     
        if ($associated_junkyard_id) {
            $junkyard_post = get_post($associated_junkyard_id);
            if ($junkyard_post) {
                echo esc_html($junkyard_post->post_title);
            } else {
                echo 'No Junkyard';
            }
        } else {
            echo 'Not Assigned';
        }
    }
}
add_action('manage_spare-part_posts_custom_column', 'display_junkyard_spare_part_column', 10, 2);
function redirect_junkyard_users_to_dashboard() {
    // Get the current user's role
    if (is_admin() && !defined('DOING_AJAX')) { // Prevent AJAX requests from being redirected
        $user = wp_get_current_user();
        
        // Check if the user has the targeted roles
        if (in_array('junkyards_administrator', $user->roles) || in_array('junkyard_manager', $user->roles)) {
            // Redirect to the user dashboard page
            wp_redirect(home_url('/user-dashboard'));
            exit;
        }
    }
}
add_action('admin_init', 'redirect_junkyard_users_to_dashboard');