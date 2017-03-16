<?php

// Model : Inventory_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function add($inventory_insert_array) {
        if ($this->db->insert('inventories', $inventory_insert_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function edit($inventory_id, $inventory_edit_array) {
        return $this->db->where('inventory_id', $inventory_id)->update('inventories', $inventory_edit_array);
    }

    function get_inventory_by_id($inventory_id) {
        return $this->db->join('products', 'products.product_id=inventories.products_id', 'left')
                        ->get_where('inventories', array('inventory_id' => $inventory_id))->row_array();
    }

    function get_all_inventory() {
        return $this->db->get('inventories')->result_array();
    }

}
