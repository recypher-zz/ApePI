<?php
namespace ApePI\Core;

class Admin {

    public function __construct() {
        $this->settings = new Settings();
        add_action('admin_menu', array( $this, 'add_menu' ) );
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
