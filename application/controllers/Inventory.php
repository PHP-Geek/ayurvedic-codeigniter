<?php

// Controller : Inventory.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Inventory_model');
    }

    function index() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function datatable() {
        parent::allow(array('administrator'));
        $this->load->library('Datatables');
        $this->datatables->select('inventory_id, product_name, user_name, inventory_product_quantity, inventory_product_price, DATE_FORMAT(inventory_created,"%e-%b-%Y %l:%i %p")')->from('inventories');
        $this->datatables->join('products', 'products.product_id=inventories.products_id', 'left');
        $this->datatables->join('users', 'users.user_id=inventories.inventory_from_users_id', 'left');
        $this->datatables->where('inventories.inventory_to_users_id', $this->session->userdata('user')['user_id']);
        echo $this->datatables->generate();
    }

    function add() {
        parent::allow(array('administrator'));
        $data = array();
        $this->load->helper('form');
        $this->load->model('Product_model');
        if ($this->input->post()) {
            pr($this->input->post());
            $this->load->library('form_validation');
            $this->form_validation->set_rules('inventory_from_users_id', 'Factory Name', 'trim|required|integer');
            $this->form_validation->set_rules('inventory_bill_number', 'Bill Number', 'trim|required');
            $this->form_validation->set_rules('inventory_bill_date', 'Date of Bill', 'trim|required');
            $this->form_validation->set_rules('product_quantity_id[]', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('product_quantity_volume[]', 'Product Quantity', 'trim|required');
            $this->form_validation->set_rules('product_quantity_price[]', 'Product Price', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $inventory_insert_array = array(
                    'products_id' => $this->input->post('product_id'),
                    'inventory_from_users_id' => $this->input->post('inventory_from_users_id'),
                    'inventory_to_users_id' => $this->session->userdata('user')['user_id'],
                    'inventory_description' => $this->input->post('inventory_description') == "" ? "" : $this->input->post('inventory_description'),
                    'inventory_product_quantity' => $this->input->post('inventory_product_quantity'),
                    'inventory_product_price' => $this->input->post('inventory_product_price'),
                    'inventory_created' => $time_now,
                );
                if ($this->Inventory_model->add($inventory_insert_array)) {
                    $product_details_array = $this->Product_model->get_product_by_id($this->input->post('product_id'));
                    $this->Product_model->edit_product_by_id($product_details_array['product_id'], array(
                        'product_quantity' => $product_details_array['product_quantity'] + (int) $this->input->post('inventory_product_quantity'),
                        'product_modified' => $time_now
                    ));
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        $this->load->model('User_model');
        $data['products_details_array'] = $this->Product_model->get_all_active_products_details();
        $data['factory_users_details_array'] = $this->User_model->get_all_active_users_by_group_id('3');
        parent::render_view($data);
    }

    function get_product_by_category_id() {
        parent::allow(array('administrator'));
        $this->load->library('form_validation');
        $this->load->model('Product_model');
        $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required');
        if ($this->form_validation->run()) {
            parent::json_output($this->Product_model->get_products_by_category_id($this->input->post('category_id')));
            return;
        } else {
            echo validation_errors();
            die;
        }
        die('0');
    }

}
