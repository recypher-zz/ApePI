<?php
namespace ApePI\Core;

class CustomRoute{

    public function __construct(){
        add_action('rest_api_init', 'register_custom_routes');
    }
    public function register_custom_routes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $routes = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        foreach ($routes as $route) {
            register_rest_route('apepi/v1', '/' . $route['route_name'], array(
                'methods' => $route['route_method'],
                'callback' => $route['route_callback'],
            ) );
        }
    }

    public function save_custom_route($route_name, $route_method, $route_callback) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $wpdb->insert($table_name, array(
            'route_name' => $route_name,
            'route_method' => $route_method,
            'route_callback' => $route_callback,
        ));
    }
}
?>