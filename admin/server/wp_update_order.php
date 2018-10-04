<?php
require_once '../woo-header.php';
$order_id = intval($_POST['id']);
if ($order_id) {
    try {
        $data = [
            'status' => $_POST['status'],
        ];
        $result = $woocommerce->put("orders/{$order_id}", $data);
        echo json_encode($result);
    } catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
        $return_array = [
            'error'=>$e->getMessage(),
        ];
        echo json_encode($return_array);
    }

}
