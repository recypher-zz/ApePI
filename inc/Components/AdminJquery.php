<?php

namespace ApePI\Core\Components;

class AdminJquery {
    public function admin_jquery() {
        ?>
        <script>
            jQuery(document).ready(function($){
                $('.table').on("change", function() {
                    $.ajax({
                        url : ajaxurl,
                        action : 'columns',
                        data : {
                            "table" : $(this).val(),
                        },
                        success: function(data) {
                            console.log(data);
                            console.log(response);
                        }
                    })
                })
            })
        </script> <?php
    }
}
?>