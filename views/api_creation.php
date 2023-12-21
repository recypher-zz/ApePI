<?php

function api_creation_screen($data){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <label for="route_name">Endpoint Name:</label>
                <input class="api_name" name="route_name" type="text"> 
            </div>
            
        </div>
        <div class="endpoint_selector">
            <?php $data; ?>
            <div id="returned_columns">

            </div>
            <div>
                <select class="method_type">
                    <option value="#"> Select a Method... </option>
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PATCH">PATCH</option>
                    <option value="DELETE">DELETE</option>
                </select>
            </div>

            <div>
                <pre class="returned_data">

                </pre>
            </div>

            <div>
                <button class="submit_api">Submit</button>
            </div>
        </div>
    </div>

    
    <?php
}

?>