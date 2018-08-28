<?php
require_once '../auth-header.php';
$delivery_available = $_POST['delivery_available'] == 1 ? 'Y' : 'N';
$pickup_available = $_POST['pickup_available'] == 1 ? 'Y' : 'N';
save_settings($delivery_available, $pickup_available);
$return_array = array(
    'success' => 'Y'
);
echo json_encode($return_array);
if ($_POST['delivery_available'] == 1) {
    //save details only when delivery is available
    $delivery_open_array = $_POST['delivery_open'];
    for ($i = 1; $i <= count($delivery_open_array); $i++) {
        if ($delivery_open_array[$i] == 1) {
            $open = 'Y';
            $open_from_time = $_POST['delivery_open_from_hr'][$i] . ':' . $_POST['delivery_open_from_min'][$i];
            $open_till_time = $_POST['delivery_open_till_hr'][$i] . ':' . $_POST['delivery_open_till_min'][$i];
            $close_from_time = $_POST['delivery_close_from_hr'][$i] . ':' . $_POST['delivery_close_from_min'][$i];
            $close_till_time = $_POST['delivery_close_till_hr'][$i] . ':' . $_POST['delivery_close_till_min'][$i];
        } else {
            $open = 'N';
            $open_from_time = '';
            $open_till_time = '';
            $close_from_time = '';
            $close_till_time = '';
        }
        $insertSql = "INSERT INTO store_time (weekday, open, start_hour, end_hour, close_start_hour, close_end_hour, type) VALUES(%d, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE open = %s, start_hour = %s, end_hour = %s, close_start_hour = %s, close_end_hour = %s";
        $insertValues = array(
            $i,
            $open,
            $open_from_time,
            $open_till_time,
            $close_from_time,
            $close_till_time,
            'delivery',
            $open,
            $open_from_time,
            $open_till_time,
            $close_from_time,
            $close_till_time,
        );
        $query = $wpdb->prepare($insertSql, $insertValues);
        $wpdb->query($query);
    }
} else {
    delete_settings('delivery');
}

if ($_POST['pickup_available'] == 1) {
    //save details only when pickup is available
    $pickup_open_array = $_POST['pickup_open'];
    for ($i = 1; $i <= count($pickup_open_array); $i++) {
        if ($pickup_open_array[$i] == 1) {
            $open = 'Y';
            $open_from_time = $_POST['pickup_open_from_hr'][$i] . ':' . $_POST['pickup_open_from_min'][$i];
            $open_till_time = $_POST['pickup_open_till_hr'][$i] . ':' . $_POST['pickup_open_till_min'][$i];
            $close_from_time = $_POST['pickup_close_from_hr'][$i] . ':' . $_POST['pickup_close_from_min'][$i];
            $close_till_time = $_POST['pickup_close_till_hr'][$i] . ':' . $_POST['pickup_close_till_min'][$i];
        } else {
            $open = 'N';
            $open_from_time = '';
            $open_till_time = '';
            $close_from_time = '';
            $close_till_time = '';
        }
        $insertSql = "INSERT INTO store_time (weekday, open, start_hour, end_hour, close_start_hour, close_end_hour, type) VALUES(%d, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE open = %s, start_hour = %s, end_hour = %s, close_start_hour = %s, close_end_hour = %s";
        $insertValues = array(
            $i,
            $open,
            $open_from_time,
            $open_till_time,
            $close_from_time,
            $close_till_time,
            'pickup',
            $open,
            $open_from_time,
            $open_till_time,
            $close_from_time,
            $close_till_time,
        );
        $query = $wpdb->prepare($insertSql, $insertValues);
        $wpdb->query($query);
    }
}else{
    delete_settings('pickup');
}

function save_settings($delivery_available, $pickup_available)
{
    global $wpdb;
    $updateSql = "UPDATE store_settings SET delivery = %s, pickup = %s WHERE id = 1";
    $updateValues = array($delivery_available, $pickup_available);
    $wpdb->query($wpdb->prepare($updateSql, $updateValues));
}
function delete_settings($type){
    global $wpdb;
    $query = "DELETE FROM store_time WHERE type = '$type'";
    $wpdb->query($query);
}