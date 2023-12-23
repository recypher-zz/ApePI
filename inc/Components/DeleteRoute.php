<?php
namespace ApePI\Core\Components;

class DeleteRoute {
    public static function delete_route($data, $table_name) {
        global $wpdb;

        $where = [];
        $where_format = [];

        foreach ($data as $column => $value) {
            $where[] = $wpdb->prepare("$column = %s", $value);
        }

        $where_sql = implode(' AND ', $where);

        $sql = "DELETE FROM $table_name WHERE $where_sql";
        $result = $wpdb->query($sql);

        if (false !== $result) {
            return new \WP_REST_Response('Items delete successfully', 200);
        } else {
            return new \WP_Error('apepi_delete_error', 'Error in deleting items', ['status' => 500]);
        }
    }
}


?>