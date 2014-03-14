<?php

class CRUD_model extends CI_Model
{
    
    protected $_table = null;
    protected $_primary_key = null;
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * @usage
     *  All:    $this->user_model->get();
     *  Single: $this->user_model->get(2);
     *  Custom: $this->user_model->get(array('age' => '32', 'gender' => 'male'))
     */
    public function get($id = null, $order_by = null)
    {       
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);
        } 
        
        if (is_array($id)) {
            foreach ($id as $_key => $_value) {
                $this->db->where($_key, $_value);
            }
        }
        
        $q = $this->db->get($this->_table);
        return $q->result_array();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * @param array $data
     * 
     * @usage $result = $this->user_model->insert(['login' => 'Jethro']);
     */
    public function insert($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * @usage $result = $this->user_model->update(['login' => 'Peggy'], 3);
     *          $this->user_model->update(['login' => 'Ted'], ['date_created' => '0']);
     */
    public function update($new_data, $where)
    {
        if (is_numeric($where)) {
            $this->db->where($this->_primary_key, $where);
        }
        elseif (is_array($where)) {
            foreach ($where as $_key => $_value) {
                $this->db->where($_key, $_value);
            }
        }
        else {
            die("You must pass a second parameter to the UPDATE() method.");
        }
        
        $this->db->update($this->_table, $new_data);
        return $this->db->affected_rows();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * @usage insertUpdate(['name' => 'ted'], 12)
     * 
     */
    public function insertUpdate($data, $id = false)
    {
        if (!$id) {
            die("You must pass a second parameter to the insertUPDATE() method.");
        }
        
        $this->db->select($this->_primary_key);
        $this->db->where($this->_primary_key, $id);
        $q = $this->db->get($this->_table);
        $result = $q->num_rows();
        
        if ($result == 0) {
            return $this->insert($data);
        }
        
        return $this->update($data, $id);
        
        
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * @usage $this->user_model->delete(6);
     *        $this->user_model->delete(array('name' => 'Markus'))
     */
    public function delete($id)
    {
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);
        }
        elseif (is_array($id)) {
            foreach ($id as $_key => $_value) {
                $this->db->where($_key, $_value);
            }
        }
        else {
            die("You must pass a parameter to the DELETE() method.");
        }
        
        $this->db->delete($this->_table);
        return $this->db->affected_rows();
    }
    
    // ------------------------------------------------------------------------
    
}