<?php

function api_endpoint_list( $routes, $site_url ) {
    ?>
    <div class="container">
        <?php  
        foreach ($routes as $route) {
        ?>  <div class="row">
                <div class="col-4">
                    <p><?php echo $site_url ?>/wp-json/apepi/v1/<?php echo $route->route_name ?></p>
                    <p>Method: <?php echo $route->route_method ?>
                </div>
            </div>
        <?php
        }
        ?>

        </div>
    </div>

    <?php
}
?>