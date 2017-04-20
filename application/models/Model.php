<?php

/**
 * Description of SchoolModel
 *
 * @author Adeleke Oladapo
 */

class Model extends CI_Model {
    
    private $table_command = 'command', $table_test = 'test', $table_log = 'log', $handle, $myfile = "application/config/last-command.txt";
    
    function __construct() {
        parent::__construct();
    }
    
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
    
    function getNextCommand($row_command_id){
        $this->db->select('*');
        $this->db->where('command_id >', $row_command_id);
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
        $this->db->update($this->table_test, $data);
        
        $data->device_id = $device_id;
    }
    
    function deleteTest($device_id){
        $this->db->where('device_id', $device_id);
        $this->db->delete($this->table_test);
    }
    
    function logTestError($test){
        if($test->contact1 != 'Off'){
            if($test->contact1 == 'On'){
                $device_log = $this->getDeviceLog($test->device_id, 'contact1', 0);
                if($device_log){
                    $device_log->fixed = 1;
                    $device_log->time_fixed = $this->penguin->getTime();
                    $this->updateLog($device_log);
                }
            }else{
                $log = new stdClass();
                $log->device_id = $test->device_id;
                $log->error = $test->contact1;
                $log->source = 'contact1';
                $log->error_time = $this->penguin->getTime();
                $this->insertLog($log);
            }
        }
        
        if($test->contact2 != 'Off'){
            if($test->contact2 == 'On'){
                $device_log = $this->getDeviceLog($test->device_id, 'contact2', 0);
                if($device_log){
                    $device_log->fixed = 1;
                    $device_log->time_fixed = $this->penguin->getTime();
                    $this->updateLog($device_log);
                }
            }else{
                $log = new stdClass();
                $log->device_id = $test->device_id;
                $log->error = $test->contact2;
                $log->source = 'contact2';
                $log->error_time = $this->penguin->getTime();
                $this->insertLog($log);
            }
        }
    }
    
    
    /////////////// END TEST ///////////////
    
    
    
    /////////////// LOG //////////////////

    function insertLog($data){
        $this->db->insert($this->table_log, $data);
        return $this->db->insert_id();
    }
    
    function getLogs($sort_field = false, $sort_order_mode = false, $filter_field = false, $filter_value = false, $page = false, $page_size = false){ 
        $this->db->select('*');
        $this->db->order_by($sort_field, $sort_order_mode);
        ($filter_value) ? $this->db->where($filter_field, $filter_value) : '';
        ($page) ? $this->db->limit($page_size, $page) : $this->db->limit($page_size);
        $query = $this->db->get($this->table_log);
        return ($query->num_rows()) ? $query->result() : [];
    }
    
    function getLog($id){
        $this->db->select('*');
        $this->db->where('log_id', $id);
        $query = $this->db->get($this->table_log);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
    function getDeviceLog($device_id, $source, $fixed){
        $this->db->select('*');
        $this->db->where('device_id', $device_id);
        $this->db->where('source', $source);
        $this->db->where('fixed', $fixed);
        $query = $this->db->get($this->table_log);
        return ($query->num_rows()) ? $query->row() : FALSE;
    }
    
    function updateLog($data){
        $this->db->where('log_id', $data->log_id);
        return $this->db->update($this->table_log, $data);
    }
    
    ////////////// END LOG /////////////    
    
    
    
    
    
    
    /////////////////// FILE //////////////////
    
    
    function setLastDeviceID($device_id){
        $this->handle = fopen($this->myfile, "w") or die("Unable to open file!");
        fwrite($this->handle, $device_id);
    }
    
    function getLastDeviceID(){
        $this->handle = fopen($this->myfile, "r") or die("Unable to open file!");
        return fgets($this->handle);
    }
    
    function __destruct() {
        
    }
    
}
