<?php

/**
 * Description of LogModel
 *
 * @author Adeleke Oladapo
 */

class LogModel extends CI_Model {
    
    private $table = 'log';
    
    function __construct() {
        parent::__construct();
    }
    
    function insertLog($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    function getLogs($sort_field = false, $sort_order_mode = false, $filter_field = false, $filter_value = false, $page = false, $page_size = false){ 
        $this->db->select('*');
        $this->db->order_by($sort_field, $sort_order_mode);
        ($filter_value) ? $this->db->where($filter_field, $filter_value) : '';
        ($page) ? $this->db->limit($page_size, $page) : $this->db->limit($page_size);
        $query = $this->db->get($this->table);
        return ($query->num_rows()) ? $query->result() : [];
    }
    
    function getLog($id){
        $this->db->select('*');
        $this->db->where('log_id', $id);
        $query = $this->db->get($this->table);
        return ($query->num_rows()) ? $query->row() : null;
    }
    
}
