<?php
require_once '../auth-header.php';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
echo json_encode(get_order_stats($start_date, $end_date));
function get_order_stats($start_date, $end_date){
    global $wpdb;
    $query = "SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders, year(posts.post_date) AS report_year, month(posts.post_date) AS report_month, day(posts.post_date) AS report_date FROM wp_posts AS posts
    LEFT JOIN wp_postmeta AS meta ON posts.ID = meta.post_id
    WHERE meta.meta_key = '_order_total'
    AND posts.post_type = 'shop_order'
    AND posts.post_status IN ('wc-pickup', 'wc-ready', 'wc-completed')
    AND date(posts.`post_date`) <= '{$end_date}'
    AND date(posts.`post_date`) >= '{$start_date}'
    GROUP BY DATE(posts.post_date)";
    if($query_results = $wpdb->get_results($query)){
        return $query_results;
    }
}