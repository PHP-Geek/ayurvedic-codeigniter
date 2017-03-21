<?php

// Model : Product_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function save($product_details_array) {
        if (isset($product_details_array['product_id'])) {
            return $this->db->where('product_id', $product_details_array['product_id'])->update('products', $product_details_array);
        }
        if ($this->db->insert('products', $product_details_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function add_product($product_insert_array) {
        if ($this->db->insert('products', $product_insert_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function get_all_active_products() {
        return $this->db->get_where('products', array('product_status' => '1'))->result_array();
    }

    function get_all_active_products_details() {
        return $this->db->join('product_quantities', 'product_quantities.products_id=products.product_id AND product_quantity_status = 1', 'left')
                        ->join('units', 'units.unit_id=product_quantities.units_id', 'left')
                        ->order_by('product_id')
                        ->get_where('products', array('product_status' => '1'))->result_array();
    }

    function get_all_active_categories() {
        return $this->db->get_where('categories', array('category_status' => '1'))->result_array();
    }

    function get_products_by_category_id($category_id) {
        return $this->db->get_where('products', array('categories_id' => $category_id, 'product_status' => '1'))->result_array();
    }

    function get_product_by_id($product_id) {
        $this->db->join('categories', 'categories.category_id=products.categories_id', 'left');
        return $this->db->get_where('products', array('product_id' => $product_id))->row_array();
    }

    function edit_product_by_id($product_id, $product_update_array) {
        return $this->db->where('product_id', $product_id)->update('products', $product_update_array);
    }

    function add_product_quantities_batch($product_quantities_insert_batch_array) {
        return $this->db->insert_batch('product_quantities', $product_quantities_insert_batch_array);
    }

    function edit_product_quantities_by_product_id($product_id, $product_quantity_update_array) {
        return $this->db->where('products_id', $product_id)->update('product_quantities', $product_quantity_update_array);
    }

    function get_product_quantities_by_product_id($product_id) {
        $this->db->join('units', 'units.unit_id=product_quantities.units_id', 'left');
        return $this->db->where(array('products_id' => $product_id, 'product_quantity_status' => '1'))->get('product_quantities')->result_array();
    }

}
