<?php
namespace ApePI\Core\Components;

class ListRoutes {

    public static function list_routes(){
        global $wpdb;
        $routes = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'custom_routes');
        
        return $routes;
    }
}

?>