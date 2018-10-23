<?php
require_once '../auth-header.php';

$status = $_POST['status'];
$expiration_time = $_POST['exp_time'];

if (isset($status)) {
    
    $updateSql = "UPDATE store_settings SET emergency = %s, emergency_expire = %s WHERE id = 1";
    $updateValues = array($status, $expiration_time);
    $query = $wpdb->prepare($updateSql, $updateValues);
    $wpdb->query($query);
    $error_code = 0;
    $error_message = '';
}else{
    $error_code = 1;
    $error_message = 'Missing required field';
}
$return_array = array(
    'error_code' => $error_code,
    'error_message' => $error_message,
);
echo json_encode($return_array);

