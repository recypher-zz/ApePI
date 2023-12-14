<?php
namespace ApePI\Core\Components;

class TableDropdown {
    public function __construct() {
        global $wpdb;

        $query = "SHOW TABLES";
        $tables = $wpdb->get_results( $query, ARRAY_N );

        if ($tables) {
            echo '<select class="table" name="selected_table">';
            echo '<option value="#"> Select A Table... </option>';

            foreach ($tables as $table) {
                $table_name = $table[0];
                echo '<option value="' . esc_attr($table_name) . '">' . esc_html($table_name) . '</option>';
            }

            echo '</select>';
        } else {
            echo '<p>No tables found in the database.</p>';
        }

        echo '<div id="returned_columns">';
        echo '</div>';
    }
    }

?>