<?php
namespace ApePI\Core;
use ApePI\Core\Components\PostRoute;
use ApePI\Core\Components\GetRoute;
use ApePI\Core\Components\PatchRoute;

class CustomRoute{

    public function __construct(){
        add_action('rest_api_init', array($this, 'register_custom_routes'));
    }

    public function register_custom_routes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $routes = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        foreach ($routes as $route) {
            $table_name = $route['route_table'];
            $unserialize_columns = unserialize( $route['route_columns'] );
            $columns_to_return = $unserialize_columns;
            $method = $route['route_method'];

            register_rest_route('apepi/v1', '/' . $route['route_name'], array(
                'methods' => $route['route_method'],
                'callback' => function ( $data ) use ($table_name, $columns_to_return, $method) {
                    switch ($method){
                        case "GET":
                            GetRoute::get_route($table_name, $columns_to_return);
                            break;
                        case "POST":
                            PostRoute::post_route($data, $table_name);
                            break;
                        case "PATCH":
                            PatchRoute::patch_route($data, $table_name);
                            break;
                        case "DELETE":
                            return "$method not supported yet";
                            break;

                    }
                },
            ) );
        }
    }

    public function save_custom_route($route_name, $route_table, $route_columns, $route_method, $route_callback) {
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