<?php

/**
 * Description of SchoolModel
 *
 * @author Adeleke Oladapo
 */

class CommandModel extends CI_Model {
    
    private $table_command = 'command', $table_test = 'test';
    
    function insertCommand($data){
        if($this->getCommandByDeviceID($data->device_id)){
            $this->updateCommand($data->device_id, $data);
            return;
        }
        $this->db->insert($this->table_command, $data);
        return $this->db->insert_id();
    }
    
    function getCommands($sort_field = false, $sort_order_mode = false, $filter_field = false, $filter_value = false, $page = false, $page_size = false){ 
        $this->db->select('*');
        $this->db->order_by($sort_field, $sort_order_mode);
        ($filter_value) ? $this->db->where($filter_field, $filter_value) : '';
        ($page) ? $this->db->limit($page_size, $page) : $this->db->limit($page_size);
        $query = $this->db->get($this->table_command);
        return ($query->num_rows()) ? $query->result() : [];
    }
    
    function getCommand($id){
        $this->db->select('*');
        $this->db->where('command_id', $id);
        $query = $this->db->get($this->table_command);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
    function getCommandByDeviceID($device_id){
        $this->db->select('*');
        $this->db->where('device_id', $device_id);
        $query = $this->db->get($this->table_command);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
    function updateCommand($device_id, $data){
        $this->db->where('device_id', $device_id);
        return $this->db->update($this->table_command, $data);
    }
    
    //////////////////////// TEST //////////////////////////
    
    function insertTest($data){
        if($this->getTestByDeviceID($data->device_id)){
            $this->updateTest($data->device_id, $data);
            return $this->getTestByDeviceID($data->device_id)->status;
        }
        $this->db->insert($this->table_test, $data);
        return $this->db->insert_id();
    }
    
    function getTests($sort_field = false, $sort_order_mode = false, $filter_field = false, $filter_value = false, $page = false, $page_size = false){ 
        $this->db->select('*');
        $this->db->order_by($sort_field, $sort_order_mode);
        ($filter_value) ? $this->db->where($filter_field, $filter_value) : '';
        ($page) ? $this->db->limit($page_size, $page) : $this->db->limit($page_size);
        $query = $this->db->get($this->table_test);
        return ($query->num_rows()) ? $query->result() : [];
    }
    
    function getTest($id){
        $this->db->select('*');
        $this->db->where('test-id', $id);
        $query = $this->db->get($this->table_test);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
    function getTestByDeviceID($device_id){
        $this->db->select('*');
        $this->db->where('device_id', $device_id);
        $query = $this->db->get($this->table_test);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
    function updateTest($device_id, $data){
        $this->db->where('device_id', $device_id);
        return $this->db->update($this->table_test, $data);
    }
    
}
