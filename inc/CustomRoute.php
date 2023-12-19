<?php
namespace ApePI\Core;

class CustomRoute{
    public static function register_custom_routes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $routes = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        foreach ($routes as $route) {
            $table_name = $wpdb->prefix . 'custom_routes';
            $unserialize_columns = unserialize( $route['route_columns'] );
            $columns_to_return = explode( ',', $unserialize_columns );

            register_rest_route('apepi/v1', '/' . $route['route_name'], array(
                'methods' => $route['route_method'],
                'callback' => function ( $data ) use ($table_name, $columns_to_return) {
                    global $wpdb;
                    $results = $wpdb->get_results("SELECT " . implode(', ', $columns_to_return) . " FROM $table_name", ARRY_A);
                    return $results;
                },
            ) );
        }

        add_action('rest_api_init', 'register_custom_routes');
    }

    public static function save_custom_route($route_name, $route_table, $route_columns, $route_method, $route_callback) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $wpdb->insert($table_name, array(
            'route_name' => $route_name,
            'route_table' => $route_table,
            'route_columns' => serialize($route_columns),
            'route_method' => $route_method,
            'route_callback' => $route_callback,
        ));
    }
}
?>