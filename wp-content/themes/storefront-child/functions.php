<?php
require_once 'utilities.php';
add_action('init', 'leap_enqueue_script');
function get_param($name, $default = null)
{
    return isset($_POST[$name]) ? $_POST[$name] : isset($_GET[$name]) ? $_GET[$name] : $default;
}
function leap_enqueue_script()
{
    wp_enqueue_script("jquery");
}

function get_variation_products($product_id)
{
    $args = array(
        'post_type' => 'product_variation',
        'post_status' => array('private', 'publish'),
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'asc',
        'post_parent' => $product_id, //     get parent post-ID
    );
    $variations = get_posts($args);
    $return_array = array();
    foreach ($variations as $variation) {

        //         get variation ID
        $variation_ID = $variation->ID;

        //         get variations meta
        $product_variation = new WC_Product_Variation($variation_ID);

        //         //         get variation featured image
        //         $variation_image = $product_variation->get_image();

        //         //         get variation price
        //         $variation_price = $product_variation->get_price_html();

        //         //         to get variation meta, simply use get_post_meta() WP functions and you're done
        // // ... do your thing here
        array_push($return_array, $product_variation->get_data());
    }
    return $return_array;
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
add_filter('woocommerce_checkout_fields', 'addBootstrapToCheckoutFields');
function addBootstrapToCheckoutFields($fields)
{
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'form-group';
            $field['class'][] = 'col-sm-6';
            // add form-control to the actual input
            $field['input_class'][] = 'form-control';
        }
    }
    return $fields;
}
function output_payment_button()
{
    $order_button_text = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));
    echo '<div class="text-center"><input type="submit" class="btn btn-primary" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '" /></div>';
}
add_action('woocommerce_review_order_after_payment', 'output_payment_button');
function remove_woocommerce_order_button_html()
{
    return '';
}
add_filter('woocommerce_order_button_html', 'remove_woocommerce_order_button_html');
add_action('woocommerce_thankyou', 'woocommerce_thankyou_change_order_status', 10, 1);
function woocommerce_thankyou_change_order_status($order_id)
{
    if (!$order_id) {
        return;
    }
    $order = wc_get_order($order_id);
    if ($order->get_status() == 'processing') {
        $order->update_status('new');
    }
}
//remove some fields from billing form
//ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
function leap_custom_billing_fields($fields = array())
{
    unset($fields['billing_company']);
    unset($fields['billing_address_2']);
    unset($fields['billing_country']);
    return $fields;
}
add_filter('woocommerce_billing_fields', 'leap_custom_billing_fields');
/**
 * Add custom field to the checkout page
 */

add_action('woocommerce_after_order_notes', 'leap_custom_checkout_field');

function leap_custom_checkout_field($checkout)
{
    echo '<div id="custom_checkout_field"><h2>' . __('Pickup/Delivery Time') . '</h2>';
    $hour_options = get_hour_options();
    $field_data = array(
        'type' => 'select',
        'class' => array(
            'state_select form-control',
        ),
        'options' => $hour_options,
        'label' => __('Wish time'),
    );
    woocommerce_form_field(
        'wish_time',
        $field_data,
        $checkout->get_value('wish_time')
    );
    $order_type_data = array(
        'type' => 'select',
        'class' => array(
            'state_select form-control',
        ),
        'options' => ['pickup' => 'pickup', 'delivery' => 'delivery'],
        'label' => __('Order type'),
    );
    woocommerce_form_field(
        'order_type',
        $order_type_data,
        $checkout->get_value('order_type')
    );
    echo '</div>';
}

/**
 * Update the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'leap_custom_checkout_field_update_order_meta');

function leap_custom_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['wish_time'])) {
        update_post_meta($order_id, '_order_wish_time', sanitize_text_field($_POST['wish_time']));
        
    }
    $order_type = WC()->session->get('order_type');
    if(empty($order_type)){$order_type='pickup';}
    update_post_meta($order_id, '_order_type', $order_type);
}
/**
 * Remove 'xxx has been added' message after adding to cart
 */
add_filter('wc_add_to_cart_message', 'remove_add_to_cart_message');

function remove_add_to_cart_message()
{
    return;
}


/**
 * Hide coupon form everywhere
 */
 
function hide_coupon_field( $enabled ) {
	if ( is_cart() || is_checkout() ) {
		$enabled = false;
	}
	
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field' );