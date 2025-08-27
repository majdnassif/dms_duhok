<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RemoteConnectionMapperHelper
{
    /**
     * Get single branch connection info by branch_id
     */
    public static function getLocation($branch_id): array
    {
        $CI =& get_instance();  // get CI super object
        $CI->load->database();
        $CI->load->library('Crypt');

        $sql = "
            SELECT
                id,
                name,
                base_url,
                hostname,
                username,
                password,
                `database`
            FROM
                remote_connections
            WHERE id = ?
        ";

        $query = $CI->db->query($sql, [$branch_id]);
        $row   = $query->row_array();

        if ($row) {
            return [
                'id'        => $row['id'],
                'name'      => $row['name'],
                'base_url'  => $CI->crypt->MediaDecrypt($row['base_url']),
                'hostname'  => $CI->crypt->MediaDecrypt($row['hostname']),
                'username'  => $CI->crypt->MediaDecrypt($row['username']),
                'password'  => $CI->crypt->MediaDecrypt($row['password']),
                'database'  => $CI->crypt->MediaDecrypt($row['database']),
            ];
        }

        return [];
    }

    /**
     * Get all connections where is_current = 0
     */
//    public static function all(): array
//    {
//        $CI =& get_instance();
//        $CI->load->database();
//        $CI->load->library('Crypt');
//
//        $sql = "
//            SELECT
//                id,
//                name,
//                base_url,
//                hostname,
//                username,
//                password,
//                `database`
//            FROM
//                remote_connections
//            WHERE is_current = 0
//        ";
//
//        $query  = $CI->db->query($sql);
//        $result = [];
//
//        foreach ($query->result_array() as $row) {
//            $result[$row['id']] = [
//                'name'      => $row['name'],
//                'base_url'  => $CI->crypt->MediaDecrypt($row['base_url']),
//                'hostname'  => $CI->crypt->MediaDecrypt($row['hostname']),
//                'username'  => $CI->crypt->MediaDecrypt($row['username']),
//                'password'  => $CI->crypt->MediaDecrypt($row['password']),
//                'database'  => $CI->crypt->MediaDecrypt($row['database']),
//            ];
//        }
//
//        return $result;
//    }
    public static function all(): array
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->library('Crypt');

        $sql = "
            SELECT
                id,
                name
            FROM
                remote_connections
            WHERE is_current = 0
        ";

        $query  = $CI->db->query($sql);
        $result = [];

        foreach ($query->result_array() as $row) {
            $result[$row['id']] = [
                'name'      => $row['name']
            ];
        }

        return $result;
    }
}
