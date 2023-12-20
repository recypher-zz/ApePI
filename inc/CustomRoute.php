<?php
namespace ApePI\Core;

class CustomRoute{

    public function __construct(){
        add_action('rest_api_init', array($this, 'register_custom_routes'));
    }

    public function register_custom_routes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $routes = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        foreach ($routes as $route) {
            $table_name = $route['route_table'];
            $unserialize_columns = unserialize( $route['route_columns'] );
            $columns_to_return = $unserialize_columns;
            $method = $route['route_method'];

            register_rest_route('apepi/v1', '/' . $route['route_name'], array(
                'methods' => $route['route_method'],
                'callback' => function ( $data ) use ($table_name, $columns_to_return, $method) {
                    global $wpdb;

                    switch ($method){
                        case "GET":
                            $results = $wpdb->get_results("SELECT " . implode(', ', $columns_to_return) . " FROM $table_name", ARRAY_A);
                            return wp_send_json($results);
                            break;
                        case "POST":
                            $posted_data = $data->get_params();

                            if (empty($posted_data)) {
                                return rest_ensure_response(array('error' => 'Invalid request data'));
                            }

                            
                            $columns = array_keys($posted_data);
                            $values = array_values($posted_data);

                            
                            $columns = array_map('sanitize_text_field', $columns);
                            $values = array_map('sanitize_text_field', $values);

                            
                            if (count($columns) !== count($values)) {
                                return rest_ensure_response(array('error' => 'Mismatched number of columns and values'));
                            }

                            $sql_columns = implode(', ', $columns);
                            $sql_values = implode("', '", $values);
                            $sql = "INSERT INTO $table_name ($sql_columns) VALUES ('$sql_values')";

                            $wpdb->query($sql);
                            return rest_ensure_response(array('message' => 'Data inserted successfully'));
                            break;
                        case "PATCH":
                            $posted_data = $data->get_params();

                            if (empty($posted_data)) {
                                return rest_ensure_response(array('error' => 'Invalid request...'));
                            }

                            $update_data = array();
                            foreach ($posted_data as $key => $value) {

                                $key = sanitize_text_field($key);
                                $value = sanitize_text_field($value);

                                $update_data[$key] = $value;
                            }

                            if (empty($update_data)) {
                                return rest_ensure_response(array('error' => 'No valid data'));
                            }

                            $where = array();
                            $columns = array_keys($posted_data);
                            
                            foreach ($columns as $column) {
                                if (isset($posted_data[$column])) {
                                    $where[] = $column . " = '" . sanitize_text_field($posted_data[$column]) . "'"; 
                                }
                            }

                            if (empty($where)) {
                                return rest_ensure_response(array('error' => 'No valid conditions'));
                            }

                            $sql_where = implode(' AND ', $where);
                            $sql_update = implode(', ', array_map(function ($key, $value) {
                                return $key . " = '" . $value . "'";
                            }, array_keys($update_data), $update_data));

                            $sql = "UPDATE $table_name SET $sql_update WHERE $sql_where";

                            $wpdb->query($sql);
                            break;
                        case "DELETE":
                            return "$method not supported yet";
                            break;

                    }
                },
            ) );
        }
    }

    public function save_custom_route($route_name, $route_table, $route_columns, $route_method, $route_callback) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_routes';
        $wpdb->insert($table_name, array(
            'route_name' => $route_name,
            'route_table' => $route_table,
            'route_columns' => serialize($route_columns),
            'route_method' => $route_method,
            'route_callback' => $route_callback,
        ));
    }
}
?>