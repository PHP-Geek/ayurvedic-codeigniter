<?php

// Model : Page_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function add_product($product_insert_array) {
        if ($this->db->insert('products', $product_insert_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function get_all_active_categories() {
        return $this->db->get_where('categories', array('category_status' => '1'))->result_array();
    }

    function get_products_by_category_id($category_id) {
        return $this->db->get_where('products', array('categories_id' => $category_id, 'product_status' => '1'))->result_array();
    }

    function get_product_by_id($product_id) {
        return $this->db->get_where('products', array('product_id' => $product_id))->row_array();
    }

    function edit_product_by_id($product_id, $product_update_array) {
        return $this->db->where('product_id', $product_id)->update('products', $product_update_array);
    }

}
