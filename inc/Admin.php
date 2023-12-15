<?php
namespace ApePI\Core;
use ApePI\Core\Components\AdminJquery;
use ApePI\Core\Components\DataSelector;

class Admin {

    public function __construct() {
        $this->dataselector = new DataSelector();
        $this->admin_jquery = new AdminJquery();

        add_action('admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_footer', array($this, 'admin_jquery' ) );
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
        $this->dataselector->render();
    }

    public function admin_jquery() {
        $this->admin_jquery->admin_jquery();
    }
}
