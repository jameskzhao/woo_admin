<?php
function get_hours($type = 'pickup')
{
    global $wpdb;
    $query = "SELECT * FROM store_time WHERE type = '{$type}'";
    if ($query_results = $wpdb->get_results($query)) {
        foreach ($query_results as $single_result) {
            $single_result->start_hour = date('H:i', strtotime($single_result->start_hour));
            $single_result->end_hour = date('H:i', strtotime($single_result->end_hour));
            $single_result->close_start_hour = date('H:i', strtotime($single_result->close_start_hour));
            $single_result->close_end_hour = date('H:i', strtotime($single_result->close_end_hour));
        }
        return $query_results;
    }
}
function get_variation_products($product_id)
{
    $args = array(
        'post_type' => 'product_variation',
        'post_status' => array('private', 'publish'),
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'asc',
        'post_parent' => $product_id, // get parent post-ID
    );
    $variations = get_posts($args);
    $return_array = array();
    foreach ($variations as $variation) {

        // get variation ID
        $variation_ID = $variation->ID;

        // get variations meta
        $product_variation = new WC_Product_Variation($variation_ID);

        // // get variation featured image
        // $variation_image = $product_variation->get_image();

        // // get variation price
        // $variation_price = $product_variation->get_price_html();

        // // to get variation meta, simply use get_post_meta() WP functions and you're done
        // // ... do your thing here
        array_push($return_array, $product_variation->get_data());
    }
    return $return_array;
}
function find_hours_by_day($pickup_hours, $weekday)
{
    foreach ($pickup_hours as $hours) {
        if ($hours->weekday == $weekday) {
            return $hours;
        }
    }
}
function find_submenu($menu_array, $parent_menu_id)
{
    $return_array = array();
    foreach ($menu_array as $single_menu) {
        if ($parent_menu_id == $single_menu->menu_item_parent) {
            $new_obj = new StdClass;
            $new_obj->title = $single_menu->title;
            $new_obj->url = $single_menu->url;
            array_push($return_array, $new_obj);
        }
    }
    return $return_array;
}
function buildTree(array &$elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as &$element) {
        if ($element->menu_item_parent == $parentId) {
            $children = buildTree($elements, $element->ID);
            if ($children) {
                $element->wpse_children = $children;
            }

            $branch[$element->ID] = $element;
            unset($element);
        }
    }
    return $branch;
}
function get_header_nav($menu_slug)
{
    $items = wp_get_nav_menu_items($menu_slug);
    return $items ? buildTree($items, 0) : null;
}

function ajax_login_init()
{

    if(!wp_register_script('ajax-login-script', get_template_directory_uri() . '/ajax-login-script.js', array('jquery'), '', true)){
        error_log('register ajax-login failed');
    }
    if(!wp_enqueue_script('ajax-login-script')){
        error_log('enqueue ajax-login failed');
    }

    wp_localize_script('ajax-login-script', 'ajax_login_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...'),
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function ajax_login(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}