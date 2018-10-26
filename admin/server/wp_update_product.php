<?php
require_once '../woo-header.php';
$product_id = intval($_POST['id']);

if ($product_id) {
    try {
        $data = [
            'in_stock' => $_POST['in_stock'],
            'name' => $_POST['name'],
        ];
        $result = $woocommerce->put("products/{$product_id}", $data);
        echo json_encode($result);
    } catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
        $return_array = [
            'error' => $e->getMessage(),
        ];
        echo json_encode($return_array);
    }

}