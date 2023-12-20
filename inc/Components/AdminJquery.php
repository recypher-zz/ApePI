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
                    });
                });

                $('.submit_api').on("click", function() {
                    var data = {
                        "name" : $('.api_name').val(),
                        "table" : $('.table').val(),
                        "columns" : $('.column').val(),
                        "method_type" : $('.method_type').val(),
                        "action" : 'save_route'
                    }

                    $.post(ajaxurl, data, function(response) {
                        console.log(data);
                        console.log(response);
                    })
                })
            })
        </script> <?php
    }
}
?>