<?php

namespace ApePI\Core\Components;

class AdminJquery {
    public function admin_jquery() {
        ?>
        <script>
            jQuery(document).ready(function($){
                $('.table').on("change", function() {
                    var data = {
                        "table" : $(this).val(),
                        "action" : 'columns',
                    }

                    $.post(ajaxurl, data, function(response) {
                        console.log(data);
                        console.log(response);
                        $("#returned_columns").html(response);
                    })
                })

                $('.endpoint_selector').on("change", '.column', function() {
                    var data = {
                        "table" : $('.table').val(),
                        "column" : $(this).val(),
                        "action" : 'return_data'
                    }

                    $.post(ajaxurl, data, function(response) {
                        console.log(data);
                        console.log(response);
                        $(".returned_data").html(response);
                    })
                })
            })
        </script> <?php
    }
}
?>