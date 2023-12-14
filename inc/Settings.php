<?php
namespace ApePI\Core;
use ApePI\Core\Components\TableDropdown;
use ApePI\Core\Components\ColumnDropdown;

if( ! class_exists( 'Settings' ) ){
    class Settings{

        public function __construct() {
            add_action( 'wp_ajax_columns', array($this, 'create_column_dropdown') );
        }
        
        public function create_table_dropdown() {
            $this->table_dropdown = new TableDropdown();
        }

        public function create_column_dropdown() {
            $column_dropdown = new ColumnDropdown($_POST["table"]);
            wp_send_json($column_dropdown);
        }
    }
}
