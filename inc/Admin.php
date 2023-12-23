<?php
namespace ApePI\Core;

use ApePI\Core\Components\AdminJquery;
use ApePI\Core\Components\DataSelector;
use ApePI\Core\Components\ListRoutes;
use ApePI\Core\CustomRoute;

class Admin {

    public function __construct() {
        $this->dataselector = new DataSelector();
        $this->admin_jquery = new AdminJquery();
        $this->custom_route = new CustomRoute();

        add_action('admin_menu', array( $this, 'add_creation_menu' ) );
        add_action( 'admin_footer', array( $this, 'admin_jquery' ) );
        add_action( 'wp_ajax_save_route', array( $this, 'save_custom_route' ) );
    }
    
    public function add_creation_menu(){
        add_menu_page(
            'ApePI Endpoint Creation',
            'ApePI',
            'manage_options',
            'apepi_admin',
            array( $this, 'apepi_settings_page' ),
            'dashicons-database-view'
        );

        // Added submenu page using the slug from the above menu as the parent
        add_submenu_page(
            'apepi_admin',   		             // parent slug
            'ApePI Endpoint Viewer',             // page_title
            'Endpoints',                         // menu_title
            'manage_options',                    // capability
            'apepi_admin_view_endpoints',        // menu_slug
            array( $this, 'list_endpoints' ),    // callback
        );
    }

    public function save_custom_route(){
        global $wpdb;
        $table_name = APEPI_TABLE;

        $query = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE route_name = %s", $_POST['name']);
        $count = $wpdb->get_var($query);

        if ($count == 0){
            $this->custom_route->save_custom_route($_POST['name'],$_POST['table'], $_POST['columns'], $_POST['method_type'], "test()");
            $this->custom_route->register_custom_routes();
        } else {
            return wp_send_json("Can't do that right now");
        }
    }

    public function apepi_settings_page(){
        $this->dataselector->render();
    }

    public function admin_jquery() {
        $this->admin_jquery->admin_jquery();
    }

    public function list_endpoints() {
        $site_url = get_option('siteurl');
        require_once(APEPI_PATH . 'views/api_endpoint_list.php');

        api_endpoint_list( ListRoutes::list_routes(), $site_url );
    }
}
