<?php

namespace ApePI\Core\Components;

class ColumnDropdown {
    public function __construct($table) {
        
        global $wpdb;

        $query = "SHOW COLUMNS FROM " . $table;

        $columns = $wpdb->get_results( $query, ARRAY_N );

        if ($columns) {
            echo '<select class="column" name="selected_column">';
            echo '<option value="#"> Select A Column... </option>';

            foreach ($columns as $column) {
                $column_name = $column[0];
                echo '<option value="' . esc_attr($column_name) . '">' . esc_html($column_name) . '</option>';
            }

            echo '</select>';
        } else {
            echo '<p>No columns found for this table.</p>';
        }


    }
}

?>