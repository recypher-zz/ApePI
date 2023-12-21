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

    public function create_column_dropdown() {
        global $wpdb;
        $response = '';
        $table = $_POST['table'];
        
        $query = "SHOW COLUMNS FROM " . $table;

        $columns = $wpdb->get_results( $query, ARRAY_N );
        if ($columns) {
            
            $response .= '<select name="selected_column" id="" class="column" multiple><option value="#"> Select A Column... </option>';
            foreach ( $columns as $column ) {
                $column_name = $column[0];
                $response .= '<option value="' . esc_attr($column_name) . '">' . esc_html($column_name) . '</option>';
            }
            $response .= '</select>';
        } else {
            $response .= '<p>No columns found for this table.</p>';
        }
        wp_send_json($response);
    }

    public function return_data(){
        global $wpdb;

        $table = $_POST['table'];
        $column = $_POST['column'];

        $query = "SELECT " . $column . " FROM " . $table;

        $data = $wpdb->get_results( $query, ARRAY_N );

        if ($data) {
            wp_send_json($data);
        } else {
            echo '<p>No data was found in this table for those columns.</p>';
        }
    }

    public function render(){
        require_once(APEPI_PATH . 'views/api_creation.php');
        api_creation_screen($this->create_table_dropdown());
    }
}
?>