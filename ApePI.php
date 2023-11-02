<?php

/**
 * Plugin Name: ApePI
 * Plugin URI: https://www.wordpress.org/ApePI
 * Description: Create JSON endpoints for data in WordPress
 * Version 1.0
 * Requires at least: 5.6
 * Author: Ken Niemerg (Cypher)
 * Author URI: None
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ApePI
 * Domain Path: /languages
 */

if ( ! defined('ABSPATH') ){
    exit;
}

if ( ! class_exists( 'ApePI' ) ) {
    class ApePI{
        public function __construct() {
            $this->define_constants();

            add_action('admin_menu', array( $this, 'add_menu' ) );
        }

        public function define_constants(){
            define( 'APEPI_PATH', plugin_dir_path( __FILE__ ) );
            define( 'APEPI_URL', plugin_dir_url( __FILE__ ) );
            define( 'APEPI_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        public static function uninstall(){

        }

        public function add_menu(){
            add_menu_page(
                'ApePI Options',
                'ApePI',
                'administrator',
                'apepi_admin',
                null,
                'dashicons-images-alt2'
            );            
        }
    }
}