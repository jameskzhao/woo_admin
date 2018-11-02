<?php
$current_time = current_time('mysql');
$current_timestamp = current_time('timestamp');
$current_date = date('Y-m-d', $current_timestamp);


function get_estimated_wait_time()
{
    global $wpdb;
    $query = "SELECT * FROM store_settings LIMIT 1";
    return $wpdb->get_results($query)[0]->estimated_wait_time;
}
function get_hours($type = 'pickup')
{
    global $wpdb;
    $query = "SELECT * FROM store_time WHERE type = '{$type}'";
    if ($query_results = $wpdb->get_results($query)) {
        foreach ($query_results as $single_result) {
            $single_result->start_hour = date('H:i', strtotime($single_result->start_hour));
            $single_result->end_hour = date('H:i', strtotime($single_result->end_hour));
            $single_result->close_start_hour = date('H:i', strtotime($single_result->close_start_hour));
            $single_result->close_end_hour = date('H:i', strtotime($single_result->close_end_hour));
        }
        return $query_results;
    }
}

function get_today_hours($type = 'pickup')
{
    global $wpdb, $current_timestamp;
    $day_of_week = date('w', $current_timestamp);
    $hours_array = get_hours($type);
    $hours_today = find_hours_by_day($hours_array, $day_of_week);
    return $hours_today;
}

function get_hour_options()
{
    global $current_timestamp;
    $estimated_wait_time = get_estimated_wait_time();
    $current_hour_min = date('H:i', $current_timestamp + ($estimated_wait_time * 60));
    $date = new DateTime(date('Y-m-d 00:00:00', $current_timestamp));
    $count = 24 * 60 / 15;
    $time_arr = array();
    $hours_today = get_today_hours();

    while ($count--) {
        $time_arr[] = $date->add(new DateInterval("P0Y0DT0H15M"))->format("H:i");
    }
    $return_array = array('');
    foreach ($time_arr as $single_time) {
        if (($single_time >= max($hours_today->start_hour, $current_hour_min) && $single_time <= $hours_today->close_start_hour) || ($single_time >= max($hours_today->close_end_hour, $current_hour_min) && $single_time <= $hours_today->end_hour)) {
            $return_array[$single_time] = $single_time;
        }
    }
    return $return_array;
}

function find_hours_by_day($pickup_hours, $weekday)
{
    foreach ($pickup_hours as $hours) {
        if ($hours->weekday == $weekday) {
            return $hours;
        }
    }
}
function get_store_settings($param = "*"){
    global $wpdb;
    $query = "SELECT $param FROM store_settings LIMIT 1";
    return $wpdb->get_results($query)[0];
}