<?php
namespace ApePI\Core\Components;

class ListRoutes {

    public static function list_routes(){
        global $wpdb;
        $response = '';
        $site_url = get_option('siteurl');
        $routes = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'custom_routes');

        $registered_routes = [];

        foreach ($routes as $route) {
            $registered_routes[] = [
                'name' => $route['route_name'],
                'table' => $route['route_table'],
                'columns' => $route['route_columns'],
                'method' => $route['route_method']
            ];
        }

        $response .= '<p>' . $site_url . '/apepi/v1/' . $route['name'] . '</p>';
        $response .= '<p>Method: ' . $route['method'] . '</p>';

        return wp_send_json($response);
    }
}

?>