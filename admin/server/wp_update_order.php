<?php
require_once '../woo-header.php';
$order_id = intval($_POST['id']);
$order_status = $_POST['status'];

if ($order_id) {
    try {
        if($order_status=='trash'){
            $result = $woocommerce->delete("orders/{$order_id}");
        }else{
            $data = [
                'status' => $order_status,
            ];
            $result = $woocommerce->put("orders/{$order_id}", $data);
        }
        echo json_encode($result);
    } catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
        $return_array = [
            'error' => $e->getMessage(),
        ];
        echo json_encode($return_array);
    }

}