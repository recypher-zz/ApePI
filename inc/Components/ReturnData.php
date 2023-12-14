<?php
namespace ApePI\Core\Components;

class ReturnData {
    public function __construct($table, $column){
        
        global $wpdb;

        $query = "SELECT " . $column . " FROM " . $table;

        $data = $wpdb->get_results( $query, ARRAY_N );

        if ($data) {
            wp_send_json($data);
        }else {
            echo '<p>No data was found in this table for those columns.</p>';
        }
    }
}
?>