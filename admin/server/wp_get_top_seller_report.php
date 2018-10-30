<?php
require_once '../auth-header.php';
require_once '../woo-header.php';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
try {
    $data = array(
        'date_min' => $start_date,
        'date_max' => $end_date,
    );
    $report_result = $woocommerce->get('reports/top_sellers', $data);
    echo json_encode($report_result);
} catch (HttpClientException $e) {
    $e->getMessage(); // Error message.
    $e->getRequest(); // Last request data.
    $e->getResponse(); // Last response data.
}

