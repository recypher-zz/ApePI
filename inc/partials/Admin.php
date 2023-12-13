<?php
namespace ApePI\Core;

require(APEPI_PATH . 'inc/partials/Settings.php');
require(APEPI_PATH . 'autoloader.php');

class Admin {

    public function __construct() {
        $this->settings = new Settings();
        $this->autoloader = new Autoloader();
        add_action('admin_menu', array( $this, 'add_menu' ) );
        $this->apepi_settings_page();
    }
    
    public function add_menu(){
        add_menu_page(
            'ApePI Options',
            'ApePI',
            'manage_options',
            'apepi_admin',
            array( $this, 'apepi_settings_page' ),
            'dashicons-database-view'
        );
    }

    public function apepi_settings_page(){
        $this->settings->create_table_dropdown();
    }
}