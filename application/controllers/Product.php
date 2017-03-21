<?php

// Controller : Inventory.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }
    
    function get_product_by_id() {
        parent::allow(array('administrator'));
        parent::json_output(array('product_details' => $this->Product_model->get_product_by_id($this->input->post('product_id')),
            'product_quantity_details' => $this->Product_model->get_product_quantities_by_product_id($this->input->post('product_id'))));
        return;
    }

}
