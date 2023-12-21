<?php
namespace ApePI\Core\Components;

class GetRoute {
    public static function get_route($table_name, $columns_to_return){
        global $wpdb;
        $results = $wpdb->get_results("SELECT " . implode(', ', $columns_to_return) . " FROM $table_name", ARRAY_A);
        return wp_send_json($results);
    }
}

?>