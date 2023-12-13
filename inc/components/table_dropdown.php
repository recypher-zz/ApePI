<?php
global $wpdb;

$tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);

if ($tables) {
    echo '<select name="selected_table">';

    foreach ($tables as $table) {
        $table_name = $table[0];
        echo '<option value="' . esc_attr($table_name) . '">' . esc_html($table_name) . '</option>';
    }

    echo '</select>';
} else {
    echo '<p>No tables found in the database.</p>';
}
?>