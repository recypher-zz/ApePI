<?php
namespace ApePI\Core\Components;
class PatchRoute{
    public static function patch_route($data, $table_name){
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
}
}

?>