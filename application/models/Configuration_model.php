<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuration_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_configurations() {
        return $this->db->order_by('configuration_id', 'asc')->get('configurations')->result_array();
    }

    function update_configurations($configuration_update_array) {
        $this->db->update_batch('configurations', $configuration_update_array, 'configuration_key');
        return TRUE;
    }

    function get_configuration_by_key($configuration_key) {
        return $this->db->get_where('configurations', array('configuration_key' => $configuration_key))->row_array();
    }

    function add_category($category_insert_array) {
        if ($this->db->insert('categories', $category_insert_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }
    
    function edit_category($category_id, $category_edit_array) {
        return $this->db->where('category_id', $category_id)->update('categories', $category_edit_array);
    }
    
    function get_category_by_id($category_id) {
        return $this->db->get_where('categories', array('category_id' => $category_id))->row_array();
    }
    
    function get_all_categories() {
        return $this->db->where('category_status','1')->get('categories')->result_array();
    }

}