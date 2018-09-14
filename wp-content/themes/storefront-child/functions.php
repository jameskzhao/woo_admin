<?php
function get_hours($type='pickup'){
    global $wpdb;
    $query = "SELECT * FROM store_time WHERE type = '{$type}'";
    if($query_results = $wpdb->get_results($query)){
        foreach($query_results as $single_result){
            $single_result->start_hour = date('h:i', strtotime($single_result->start_hour));
            $single_result->end_hour = date('h:i', strtotime($single_result->end_hour));
            $single_result->close_start_hour = date('h:i', strtotime($single_result->close_start_hour));
            $single_result->close_end_hour = date('h:i', strtotime($single_result->close_end_hour));
        }
        return $query_results;
    }
}
function find_hours_by_day($pickup_hours, $weekday){
	foreach($pickup_hours as $hours){
		if($hours->weekday == $weekday){
			return $hours;
		}
	}
}
function find_submenu($menu_array, $parent_menu_id)
{
    $return_array = array();
    foreach ($menu_array as $single_menu) {
        if ($parent_menu_id == $single_menu->menu_item_parent) {
            $new_obj = new StdClass;
            $new_obj->title = $single_menu->title;
            $new_obj->url = $single_menu->url;
            array_push($return_array, $new_obj);
        }
    }
    return $return_array;
}
function buildTree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->wpse_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}
function get_header_nav($menu_slug)
{
    $items = wp_get_nav_menu_items( $menu_slug );
    return  $items ? buildTree( $items, 0 ) : null;
}