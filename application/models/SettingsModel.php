<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsModel extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }

    /**
     * Get list of items from a table with filtering, pagination, and ordering
     */
    public function getItemsList($table, $config, $filter='', $start=0, $length='-1', $order = '')
    {
        $sql = "SELECT * FROM $table WHERE 1=1 $filter $order";
            
        $count = $this->Get_info->select_query("SELECT count(*) AS `rows` FROM ($sql) AS `temp`")[0]['rows'];
        if ($length != '-1') {
            $sql .= " LIMIT $start,$length";
        }
        $data = $this->Get_info->select_query($sql);

        if ($data) {
            return ['data' => $data, 'count' => $count];
        } else {
            return ['data' => array(), 'count' => 0];
        }
    }

    /**
     * Get details of a specific item
     */
    public function getItemDetails($table, $config, $id)
    {
        $this->db->where($config['primary_key'], $id);
        return $this->db->get($table)->row_array();
    }

    /**
     * Add a new item to a table
     */
    public function addItem($table, $data)
    {
        $result = $this->db->insert($table, $data);
        
        if ($result) {
            $insert_id = $this->db->insert_id();
            $this->UserModel->AddUserLog($table, 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }
    
    /**
     * Update an existing item
     */
    public function updateItem($table, $config, $id, $data)
    {
        $this->db->where($config['primary_key'], $id);
        $update = $this->db->update($table, $data);
        
        if ($update) {
            $this->UserModel->AddUserLog($table, 'update', $id);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Delete an item from a table
     */
    public function deleteItem($table, $config, $id)
    {
        $this->db->where($config['primary_key'], $id);
        $delete = $this->db->delete($table);
        
        if ($delete) {
            $this->UserModel->AddUserLog($table, 'delete', $id);
            return true;
        } else {
            return false;
        }
    }
} 