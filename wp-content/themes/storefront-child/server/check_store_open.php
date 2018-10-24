<?php
define('WP_USE_THEMES', false);
require_once(__DIR__."/../../../../wp-load.php");
$current_timestamp = current_time('timestamp');

$emergency_settings = get_emergency_settings();
if($emergency_settings->emergency=='E'){
    $store_closed = $current_timestamp > strtotime($emergency_settings->emergency_expire)? 'N' : 'Y';
    $emergency_expire = $emergency_settings->emergency_expire;
}else{
    $store_closed = $emergency_settings->emergency;
}
$return_array = array(
    'store_closed' => $store_closed,
    'current_timestamp' => date('Y-m-d H:i:s', $current_timestamp),
    'emergency_expire' => $emergency_expire
);
echo json_encode($return_array);
function get_emergency_settings()
{
    global $wpdb;
    $query = "SELECT emergency, emergency_expire FROM store_settings WHERE id = 1";
    return $wpdb->get_results($query)[0];
}