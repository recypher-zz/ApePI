<?php
namespace ApePI\Core\Components;
class PostRoute {
    public static function post_route($data, $table_name){
        global $wpdb;

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
    }
}

?>