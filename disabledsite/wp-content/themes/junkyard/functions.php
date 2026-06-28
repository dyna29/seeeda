<?php
require_once get_stylesheet_directory() . "/inc/custom-translations.php";
require_once get_stylesheet_directory() . "/inc/custom-dashboard.php";
require_once get_stylesheet_directory() . "/inc/custom-junkyard-manager.php";
require_once get_stylesheet_directory() . "/inc/custom-posttype-taxonomy.php";
require_once get_stylesheet_directory() . "/inc/custom-search-result.php";
require_once get_stylesheet_directory() . "/inc/custom-junkyards.php";
show_admin_bar(false);
if (function_exists("add_theme_support")) {
    add_theme_support("post-thumbnails");
    add_theme_support("widgets");
    add_post_type_support("page", "excerpt");
    register_nav_menus([
        "primary" => __("Primary Navigation", "junkyard"),
    ]);
    //add_image_size('gallery-thumb-small', 382, 310, true);
}
//login admin
// Custom Login Logo
function custom_login_logo()
{
    ?>
    <style type="text/css">
        #login h1 a {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/seeeda-logo.png');
            background-size: contain;
               width: 100%;
    height: 60px;
        }
    </style>
<?php
}

add_action("login_enqueue_scripts", "custom_login_logo");

function wpb_widgets_init()
{
    
    register_sidebar(array(
        'name' => 'Employee Widget',
        'id' => 'employee-widget',
        'before_widget' => '<div class="chw-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="chw-title">',
        'after_title' => '</h2>'
    ));
    
}
add_action('widgets_init', 'wpb_widgets_init');

 function junkyard_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check? 
    global $user;
	
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {

        if ( in_array( 'junkyards_administrator', $user->roles ) || in_array( 'junkyard_manager', $user->roles )   ) {
		 
		
         return site_url().'/user-dashboard';
        } elseif (in_array( 'administrator', $user->roles )){
			 return site_url().'/wp-admin/index.php';
		}
		else{
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}
add_filter( 'login_redirect', 'junkyard_login_redirect', 10, 3 );
// Enqueue custom login page styles
function custom_login_stylesheet()
{
    wp_enqueue_style(
        "custom-login",
        get_stylesheet_directory_uri() .
            "/css/login-style.css?v=ver" .
            date("YMDHIS")
    );
}
add_action("login_enqueue_scripts", "custom_login_stylesheet");
// Enqueue custom admin styles
function custom_admin_styles()
{
    wp_enqueue_style(
        "custom-admin-styles",
        get_stylesheet_directory_uri() .
            "/css/admin-style.css?v=ver" .
            date("YMDHIS")
    );
}
add_action("admin_enqueue_scripts", "custom_admin_styles");
function custom_admin_scripts()
{
    // Enqueue custom JavaScript for the admin area
    wp_enqueue_script(
        "custom-admin-js", // Handle name for the script
        get_template_directory_uri() . "/js/custom-admin.js", // Path to the script
        ["jquery"], // Dependencies (load jQuery first)
        null, // Version (you can specify or use null)
        true // Load in the footer
    );
}
add_action("admin_enqueue_scripts", "custom_admin_scripts");
if (!is_admin()) {
    function de_script()
    {
        wp_dequeue_script("jquery");
        wp_deregister_script("jquery");
        wp_register_script(
            "jquery",
            get_stylesheet_directory_uri() . "/js/jquery-3.6.3.min.js",
            false,
            null
        );
        wp_enqueue_script("jquery");
    }
    //  add_action('wp_print_scripts', 'de_script', 10);
}
function theme_enqueue_styles()
{
    //  wp_enqueue_style('plugins', get_stylesheet_directory_uri() . '/css/plugins.css', array(), date('ymdhis'));

    wp_enqueue_style(
        "junkyard-style",
        get_stylesheet_directory_uri() . "/style.css",
        [],
        date("ymdhis")
    );
}

add_action("wp_enqueue_scripts", "theme_enqueue_styles");
function theme_enqueue_scripts()
{
    // Enqueue Select2 CSS and JS
    wp_enqueue_style(
        "select2-css",
        "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    );
    wp_enqueue_script(
        "select2-js",
        "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js",
        ["jquery"],
        null,
        true
    );

    wp_register_script(
        "global-var",
        get_stylesheet_directory_uri() . "/js/custom.js",
        ["jquery"],
        date("ymdhis"),
        true
    );
    $globalvar = [
        "assets" => get_stylesheet_directory_uri(),
        "ajax_url" => admin_url("admin-ajax.php"),
        "show_all" => pll__("Show All"),
    ];
    wp_localize_script("global-var", "globalvar", $globalvar);

    // Enqueued script with localized data.
    wp_enqueue_script("global-var");
}
add_action("wp_enqueue_scripts", "theme_enqueue_scripts");

function get_brand_terms_dropdown()
{
    // Get all terms from the 'brand' taxonomy
    $brands = get_terms([
        "taxonomy" => "brand",
        "hide_empty" => false, // Show all brands even if no posts are assigned
    ]);

    // Create a select dropdown
    if (!empty($brands) && !is_wp_error($brands)) {
        echo '<select id="brand-dropdown" name="brand" class="brand-select"  >';
		
     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
        foreach ($brands as $brand) {
            echo '<option value="' .
                esc_attr($brand->term_id) .
                '">' .
                esc_html($brand->name) .
                "</option>";
        }
        echo "</select>";
    }
}
function get_model_year_terms_dropdown_2($smodel_year = 0)
{
    // Get all terms from the 'model' taxonomy
$model_years = get_terms( array(
									'taxonomy' => 'model-year',
									'hide_empty' => false,'parent' =>0,'order_by' =>'name','order'=>'desc'
								));
							// Sort terms by integer value of name
		if ( ! is_wp_error( $terms ) ) {
    usort( $model_years, function( $a, $b ) {
        return intval( $b->name ) - intval( $a->name ); // Change order to descending
    });

   
}
    // Create a select dropdown
    if (!empty($model_years) && !is_wp_error($model_years)) {
        echo '<select id="model_year-dropdown2" name="model_year" class="model_year-select">';
		
     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
        foreach ($model_years as $model_year) {
            $selected = "";
            if ($smodel_year == $model_year->term_id) {
                $selected = "selected";
            }
            echo '<option  value="' .
                esc_attr($model_year->term_id) .
                '"  ' .
                $selected .
                "  >" .
                esc_html($model_year->name) .
                "</option>";
        }
        echo "</select>";
    }
}
function get_model_year_terms_dropdown($smodel_year = 0)
{
    // Get all terms from the 'model' taxonomy
$model_years = get_terms( array(
									'taxonomy' => 'model-year',
									'hide_empty' => false,'parent' =>0,'order_by' =>'name','order'=>'desc'
								));
							// Sort terms by integer value of name
		if ( ! is_wp_error( $terms ) ) {
    usort( $model_years, function( $a, $b ) {
        return intval( $b->name ) - intval( $a->name ); // Change order to descending
    });

   
}
    // Create a select dropdown
    if (!empty($model_years) && !is_wp_error($model_years)) {
        echo '<select id="model_year-dropdown" name="model_year" class="model_year-select">';
		
     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
        foreach ($model_years as $model_year) {
            $selected = "";
            if ($smodel_year == $model_year->term_id) {
                $selected = "selected";
            }
            echo '<option  value="' .
                esc_attr($model_year->term_id) .
                '"  ' .
                $selected .
                "  >" .
                esc_html($model_year->name) .
                "</option>";
        }
        echo "</select>";
    }
}
function get_spare_part_terms_dropdown_2($sspare_part = array())
{ 
    // Get all terms from the 'model' taxonomy
    $spare_parts = get_terms([
        "taxonomy" => "spare-part-type",
        "hide_empty" => false, // Show all brands even if no posts are assigned
        "parent" => 0,
    ]);
    if (!empty($spare_parts) && !is_wp_error($spare_parts)) {
        // Sort terms by name programmatically
        usort($spare_parts, function($a, $b) {
            return strcmp($a->name, $b->name); // Compare term names alphabetically
        });
         }
    // Create a select dropdown
    if (!empty($spare_parts) && !is_wp_error($spare_parts)) {
        echo '<select id="spare_part-dropdown2" name="spare_part[]" class="spare_part-select"  multiple="multiple">';
		
		 
        foreach ($spare_parts as $spare_part) {
            $selected = "";
            if (in_array( $spare_part->term_id,$sspare_part)) {
                $selected = "selected";
            }
            echo '<option  value="' .
                esc_attr($spare_part->term_id) .
                '"  ' .
                $selected .
                ">" .
                esc_html($spare_part->name) .
                "</option>";
        }
        echo "</select>";
    }
}

function get_spare_part_terms_dropdown($sspare_part = array())
{ 
    // Get all terms from the 'model' taxonomy
    $spare_parts = get_terms([
        "taxonomy" => "spare-part-type",
        "hide_empty" => false, // Show all brands even if no posts are assigned
        "parent" => 0,
    ]);
    if (!empty($spare_parts) && !is_wp_error($spare_parts)) {
        // Sort terms by name programmatically
        usort($spare_parts, function($a, $b) {
            return strcmp($a->name, $b->name); // Compare term names alphabetically
        });
         }
    // Create a select dropdown
    if (!empty($spare_parts) && !is_wp_error($spare_parts)) {
        echo '<select id="spare_part-dropdown" name="spare_part[]" class="spare_part-select"  multiple="multiple">';
		
		 
        foreach ($spare_parts as $spare_part) {
            $selected = "";
            if (in_array( $spare_part->term_id,$sspare_part)) {
                $selected = "selected";
            }
            echo '<option  value="' .
                esc_attr($spare_part->term_id) .
                '"  ' .
                $selected .
                ">" .
                esc_html($spare_part->name) .
                "</option>";
        }
        echo "</select>";
    }
}

function create_brand_and_model_dropdowns_2($selected_brand)
{
    // Get all terms from the 'brand' taxonomy
    $brands = get_terms([
        "taxonomy" => "brand",
        "hide_empty" => false, 'orderby'  => 'name',
        'order'    => 'ASC', // Use 'DESC' for descending order
        "parent" => 0,
    ]);
    if (!empty($brands) && !is_wp_error($brands)) {
        // Sort terms by name programmatically
        usort($brands, function($a, $b) {
            return strcmp($a->name, $b->name); // Compare term names alphabetically
        });
         }
    // Create the Brand dropdown
    if (!empty($brands) && !is_wp_error($brands)) {
        echo ' <div class="search-item brand-model-container"><label for="brand-dropdown">'.pll__('Brand').'</label>';
        echo '<select id="brand-dropdown2" name="brand" class="brand-select">';

     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
        foreach ($brands as $brand) {
            $selected = "";
            if ($selected_brand == $brand->term_id) {
                $selected = "selected";
            }
            echo '<option value="' .
                esc_attr($brand->term_id) .
                '"  ' .
                $selected .
                "  >" .
                esc_html($brand->name) .
                "</option>";
        }
        echo "</select></div>";
    }

    // Empty Model dropdown (will be populated dynamically based on selected brand)
    echo ' <div class="search-item brand-model-container dd-model"><label for="model-dropdown">'.pll__('Model').'</label>';
    echo '<select id="model-dropdown2" name="model" class="model-select">';
    echo "</select></div>";
	
	$brands = get_terms([
        "taxonomy" => "brand",
        "hide_empty" => false,
       'orderby'    => 'name', // Order by term name
    'order'      => 'ASC',  // Ascending order
    ]);
// Check if terms exist
$brandmodels = array();
if (!empty($brands) && !is_wp_error($brands)) {
	 foreach ($brands as $brand) {
		 if($brand->parent !=0){
			$brandmodels[] = "$brand->parent=>$brand->name=>$brand->term_id"; 
		 }
		 
	 }
	
}
echo "<div style='display:none' class='model-data2' data='".implode(",",$brandmodels)."' ></div>";
}
function create_brand_and_model_dropdowns($selected_brand)
{
    // Get all terms from the 'brand' taxonomy
    $brands = get_terms([
        "taxonomy" => "brand",
        "hide_empty" => false,
        "parent" => 0,'orderby'    => 'name', // Order by term name
    'order'      => 'ASC',  // Ascending order
    ]);
// Check if terms exist
if (!empty($brands) && !is_wp_error($brands)) {
    // Sort terms by name programmatically
    usort($brands, function($a, $b) {
        return strcmp($a->name, $b->name); // Compare term names alphabetically
    });
     }
    // Create the Brand dropdown
    if (!empty($brands) && !is_wp_error($brands)) {
        echo ' <div class="search-item brand-model-container"><label for="brand-dropdown">'.pll__('Brand').'</label>';
        echo '<select id="brand-dropdown" name="brand" class="brand-select">';

     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
        foreach ($brands as $brand) {
            $selected = "";
            if ($selected_brand == $brand->term_id) {
                $selected = "selected";
            }
            echo '<option value="' .
                esc_attr($brand->term_id) .
                '"  ' .
                $selected .
                "  >" .
                esc_html($brand->name) .
                "</option>";
        }
        echo "</select></div>";
    }

    // Empty Model dropdown (will be populated dynamically based on selected brand)
    echo ' <div class="search-item brand-model-container dd-model"><label for="model-dropdown">'.pll__('Model').'</label>';
    echo '<select id="model-dropdown" name="model" class="model-select">';
    echo "</select></div>";
	
	  $brands = get_terms([
        "taxonomy" => "brand",
        "hide_empty" => false,
       'orderby'    => 'name', // Order by term name
    'order'      => 'ASC',  // Ascending order
    ]);
// Check if terms exist
$brandmodels = array();
if (!empty($brands) && !is_wp_error($brands)) {
	 foreach ($brands as $brand) {
		 if($brand->parent !=0){
			$brandmodels[] = "$brand->parent=>$brand->name=>$brand->term_id"; 
		 }
		 
	 }
	
}
echo "<div style='display:none' class='model-data' data='".implode(",",$brandmodels)."' ></div>";
}

function get_models_by_brand()
{
    if (isset($_POST["brand_id"]) && !empty($_POST["brand_id"])) {
        $brand_id = intval($_POST["brand_id"]);

        // Fetch all models (sub-level taxonomy terms) based on selected brand
        $models = get_terms([
            "taxonomy" => "brand", // Assuming 'model' is the sub-level taxonomy
            "hide_empty" => false,
            "parent" => $brand_id,'orderby'    => 'name', // Order by term name
    'order'      => 'ASC',  // Ascending order
        ]);
// Check if terms exist
if (!empty($models) && !is_wp_error($models)) {
    // Sort terms alphabetically and place "Other Models" last
    usort($models, function($a, $b) {
        if ($a->name === 'Other Models') {
            return 1; // Place "Other Models" at the end
        }
        if ($b->name === 'Other Models') {
            return -1; // Place "Other Models" at the end
        }
        return strcmp($a->name, $b->name); // Sort alphabetically
    });

    // Display sorted terms
    echo '<ul>';
    foreach ($models as $term) {
        echo '<li>' . esc_html($term->name) . '</li>';
    }
    echo '</ul>';
} else {
    echo 'No terms found.';
}
        // Populate the dropdown with the fetched models
        if (!empty($models) && !is_wp_error($models)) {
			
     echo '<option value="0" disabled selected>'.pll__('Show All').'</option>';
            foreach ($models as $model) {
                echo '<option value="' .
                    esc_attr($model->term_id) .
                    '">' .
                    esc_html($model->name) .
                    "</option>";
            }
        } else {
            echo '<option value="">'.pll__('No models available').'</option>';
        }
    }

    wp_die(); // Always die in functions that are called via AJAX
}
add_action("wp_ajax_get_models_by_brand", "get_models_by_brand");
add_action("wp_ajax_nopriv_get_models_by_brand", "get_models_by_brand");
function custom_spare_part_columns($columns) {
    $columns['spare-part-type'] = __('Spare Part Type');
    $columns['wheel-width'] = __('Wheel Width');
    return $columns;
}
add_filter('manage_spare_part_posts_columns', 'custom_spare_part_columns');

function custom_spare_part_column_content($column, $post_id) {
    switch ($column) {
        case 'spare-part-type':
            $terms = get_the_term_list($post_id, 'spare-part-type', '', ', ', '');
            echo is_string($terms) ? $terms : '—';
            break;
        case 'wheel-width':
            $terms = get_the_term_list($post_id, 'whee-width', '', ', ', '');
            echo is_string($terms) ? $terms : '—';
            break;
    }
}
add_action('manage_spare_part_posts_custom_column', 'custom_spare_part_column_content', 10, 2);
 
// Function to add Arabic terms to existing English "model-year" terms with Polylang translations
function add_arabic_model_year_terms() {
    // Define the taxonomy and language codes for Polylang
    $taxonomy = 'model-year';
    $english_lang = 'en';
    $arabic_lang = 'ar';

    // Loop through the years from 1960 to 2024
    for ($year = 1961; $year <= 2024; $year++) {
		echo  "testing";
        $english_term = (string) $year;  // English term in Western numerals
        $arabic_term = convert_to_arabic_numbers($year);  // Arabic term in Arabic numerals
	echo   $arabic_term ;
        // Find the English term by name and verify its language is set to English
        $english_term_object = get_term_by('name', $english_term, $taxonomy);
		echo $english_term;
		var_dump( $english_term_object);
		
        if ($english_term_object && pll_get_term_language($english_term_object->term_id) === $english_lang) {
            // Check if the Arabic term already exists
           
				
				echo "arabic";
                // Arabic term doesn't exist, so create it
                $arabic_term_id = wp_insert_term(
                    $arabic_term,
                    $taxonomy,
                    ['slug' => sanitize_title($arabic_term)]
                );

                if (!is_wp_error($arabic_term_id)) {
                    $arabic_term_id = $arabic_term_id['term_id'];

                    // Set language for the new Arabic term
                    pll_set_term_language($arabic_term_id, $arabic_lang);

                    // Link the Arabic term to the existing English term
                    pll_save_term_translations([
                        $english_lang => $english_term_object->term_id,
                        $arabic_lang => $arabic_term_id,
                    ]);
                }else{
					echo "error";
				}
             
        }
	 
    }
}

// Helper function to convert a year number to Arabic numerals
function convert_to_arabic_numbers($year) {
    $western_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $arabic_numbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    return str_replace($western_numbers, $arabic_numbers, (string) $year);
}

function fetch_brands_for_datatable() {
    $brands = get_terms([
        'taxonomy' => 'brand',
        'hide_empty' => false,
        'parent' => 0,
        'meta_query' => [
            'relation' => 'OR',
            [
                'key' => 'sort_order',
                'compare' => 'EXISTS',
            ], 
        ],
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ]);

    $data = [];
    foreach ($brands as $brand) {
        $sort_order = get_term_meta($brand->term_id, 'sort_order', true);
        $data[] = [
            'id' => $brand->term_id,
            'name' => $brand->name,
            'description' => $brand->description,
            'sort_order' => $sort_order ? intval($sort_order) : 0,
        ];
    }

    wp_send_json($data);
}
add_action('wp_ajax_fetch_brands', 'fetch_brands_for_datatable');
add_action('wp_ajax_nopriv_fetch_brands', 'fetch_brands_for_datatable');
function update_brand_sort_order_frontend() {
    check_ajax_referer('update_sort_order', 'nonce');
assign_sort_order_to_terms( 'brand');
    $term_id = absint($_POST['term_id']);
    $sort_order = intval($_POST['sort_order']);

   /*  if ($term_id && update_term_meta($term_id, 'sort_order', $sort_order)) {
        wp_send_json_success(['message' => __('Sort order updated successfully.', 'textdomain')]);
    } else {
        wp_send_json_error(['message' => __('Failed to update sort order.', 'textdomain')]);
    } */
}
add_action('wp_ajax_update_brand_sort_order', 'update_brand_sort_order_frontend');


function assign_sort_order_to_terms($taxonomy = 'brands') {
    // Get all terms in the taxonomy
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,'parent'=>0,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return __('No terms found or error occurred.', 'textdomain');
    }

    // Find the max current sort_order
    $max_sort_order = 0;
    foreach ($terms as $term) {
        $current_sort_order = intval(get_term_meta($term->term_id, 'sort_order', true));
        if ($current_sort_order > $max_sort_order) {
            $max_sort_order = $current_sort_order;
        }
    }

    // Assign sort_order to terms without one
    $current_order = $max_sort_order + 1;
    foreach ($terms as $term) {
        $current_sort_order = intval(get_term_meta($term->term_id, 'sort_order', true));
        if ($current_sort_order === 0) {
            update_term_meta($term->term_id, 'sort_order', $current_order);
            $current_order++;
        }
    }

    return __('Sort order assigned successfully.', 'textdomain');
}



function whatsapp_junkyard()
{
    if (isset($_POST["junkyard"]) && !empty($_POST["junkyard"])) {
        $junkyard = intval($_POST["junkyard"]);

       global $wpdb;

// Define the table name
$table_name = $wpdb->prefix . 'callings';

// Define the data to insert
$data = array(
    'calling_date' => current_time('mysql'), // Current date and time
    'junkyard' => $junkyard ,                        // Junkyard ID
    'calling_type' => 'Phone'            // Calling type
);

// Define the format for each value (datetime, integer, string)
$format = array('%s', '%d', '%s');

// Insert the data
$inserted = $wpdb->insert($table_name, $data, $format);  
	}
    wp_die(); // Always die in functions that are called via AJAX

}
add_action("wp_ajax_whatsapp_junkyard", "whatsapp_junkyard");
add_action("wp_ajax_nopriv_whatsapp_junkyard", "whatsapp_junkyard");
function phone_junkyard()
{
    if (isset($_POST["junkyard"]) && !empty($_POST["junkyard"])) {
        $junkyard = intval($_POST["junkyard"]);
global $wpdb;

// Define the table name
$table_name = $wpdb->prefix . 'callings';

// Define the data to insert
$data = array(
    'calling_date' => current_time('mysql'), // Current date and time
    'junkyard' => $junkyard ,                        // Junkyard ID
    'calling_type' => 'WhatsApp'            // Calling type
);

// Define the format for each value (datetime, integer, string)
$format = array('%s', '%d', '%s');

// Insert the data
$inserted = $wpdb->insert($table_name, $data, $format);
         
	}
    wp_die(); // Always die in functions that are called via AJAX
}
add_action("wp_ajax_phone_junkyard", "phone_junkyard");
add_action("wp_ajax_nopriv_phone_junkyard", "phone_junkyard");

add_action('send_headers', function() {
    if (is_search()) {
        header("Cache-Control: max-age=3600, must-revalidate");
    }
});
 