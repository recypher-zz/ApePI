<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <select name="select-table" id="apepi_SelectColumn">
        <?php
            global $wpdb;
            $sql_query        = '%%';
            $results          = $wpdb->get_results( $wpdb->prepare( 'SHOW TABLES LIKE %s', $sql_query ) );
            $table_name_array = array();

            foreach ( $results as $index => $value ) {
                foreach ( $value as $table_name_temp ) {
                    array_push( $table_name_array, $table_name_temp );
                }
            }

            foreach ( $table_name_array as $table ) {
                echo '<option value=' . esc_attr( $tb );
                echo ' > ' . esc_html( $table ) . ' </option>';
            }
        ?>
    </select>
</div>