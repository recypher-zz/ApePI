<?php
namespace ApePI\Core;

if( ! class_exists( 'ApePI_Settings' ) ){
    class Settings{
        
        function create_table_dropdown() {
            require(APEPI_PATH . 'inc/components/table_dropdown.php');
        }
    }
}
