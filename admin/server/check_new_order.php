<?php
require_once '../auth-header.php';
$max_id = $_POST['max_order_id'];
$current_date = current_time('Y-m-d');
if($max_id){
    $filter = " AND ID > {$max_id} ";
}else{
    $filter = " AND DATE (post_date) = {$current_date}";
}
$query = "SELECT COUNT(ID) as order_count FROM wp_posts WHERE post_type = 'shop_order' AND post_status = 'wc-new' {$filter}";

if($query_result = $wpdb->get_results($query)){
    $order_count = intval($query_result[0]->order_count);
    $error_code = 0;
    $error_message = '';
}else{
    $order_count = 0;
}

$return_array = array(
    'error_code' => $error_code,
    'error_message' => $error_message,
    'new_order_count' => $order_count,
);
echo json_encode($return_array);