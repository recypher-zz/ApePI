<?php
namespace ApePI\Core\Components;

class DataSelector{
    public function __construct() {
        add_action( 'wp_ajax_columns', array( $this, 'create_column_dropdown' ) );
        add_action( 'wp_ajax_return_data', array( $this, 'return_data' ) );
    }

    public function create_table_dropdown() {
        global $wpdb;

        $query = "SHOW TABLES";
        $tables = $wpdb->get_results( $query, ARRAY_N );

        if ( $tables ) {

            ?>
            <select class="table" name="selected_table">
            <option value="#"> Select A Table... </option>

            <?php
            foreach ( $tables as $table ) {
                $table_name = $table[0];
                echo '<option value="' . esc_attr($table_name) . '">' . esc_html($table_name) . '</option>';
            }

            echo '</select>';
        } else {
            echo '<p>No tables found in the database.</p>';
        }
    }

    public function create_column_dropdown( $table ) {
        global $wpdb;
        
        $query = "SHOW COLUMNS FROM " . $table;

        $columns = $wpdb->get_results( $query, ARRAY_N );

        if ($columns) {
            ?>
            <select name="selected_column" id="" class="column">
            <option value="#"> Select A Column... </option>
            <?php
            foreach ( $columns as $column ) {
                $column_name = $column[0];
                echo '<option value="' . esc_attr($column_name) . '">' . esc_html($column_name) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<p>No columns found for this table.</p>';
        }
    }

    public function return_data( $table, $column ){
        global $wpdb;

        $query = "SELECT " . $column . " FROM " . $table;

        $data = $wpdb->get_results( $query, ARRAY_N );

        if ($data) {
            wp_send_json($data);
        } else {
            echo '<p>No data was found in this table for those columns.</p>';
        }
    }

    public function render(){
        ?>
        <div class="endpoint_slector">
            <?php $this->create_table_dropdown();?>
            <div id="returned_columns">

            </div>

            <div>
                <pre class="returned_data">

                </pre>
            </div>
        </div>
        <?php
    }
}
?>