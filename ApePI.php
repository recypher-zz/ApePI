<?php
/**
 * Plugin Name: ApePI
 * Plugin URI: https://www.wordpress.org/ApePI
 * Description: Create JSON endpoints for data in WordPress
 * Version 0.1.0
 * Author: Ken Niemerg (Cypher)
 * Author URI: None
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ApePI
 * Domain Path: /languages
 */
namespace ApePI\Core;



define( 'APEPI_PATH', plugin_dir_path( __FILE__ ) );
define( 'APEPI_URL', plugin_dir_url( __FILE__ ) );
define( 'APEPI_VERSION', '1.0.0' ); 


if ( ! defined( 'WPINC' ) )  die;

if ( ! class_exists( 'ApePI' ) ) {
    class ApePI{
        public function __construct() {
            require_once( 'autoloader.php' );

            $this->autoloader = new Autoloader();
            $this->autoloader->register();

            wp_register_style( 'BootstrapCSS', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
            wp_enqueue_style( 'BootstrapCSS' );

            wp_register_script( 'BootstrapJS', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' );
            wp_enqueue_script( 'BootstrapJS' );

            register_activation_hook( __FILE__, array( $this, 'activate' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
            register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );
            $this->admin = new Admin();
        }
        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }
        public static function deactivate(){
            flush_rewrite_rules();
        }
        public static function uninstall(){
        }
    }
}
$apePI = new ApePI();