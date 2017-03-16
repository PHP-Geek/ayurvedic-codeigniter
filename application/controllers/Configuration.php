<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Configuration_model');
    }

    function category(){
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function product_datatable() {
        parent::allow(array('administrator'));
        $this->load->library('Datatables');
        $this->datatables->select('product_id, category_name, product_name, product_description, product_is_display, product_image, product_quantity, product_sale_price, product_status')->from('products');
        $this->datatables->join('categories', 'categories.category_id=products.product_id', 'left');
        $this->datatables->where('products.product_status != -1');
        echo $this->datatables->generate();
    }

    function product() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function add_product() {
        parent::allow(array('administrator'));
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->model('Product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|is_unique[products.product_name]');
            $this->form_validation->set_rules('product_description', 'Product Description', 'trim|required');
            $this->form_validation->set_rules('product_image_file_name', 'Product Image', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $products_insert_array = array(
                    'categories_id' => $this->input->post('category_id'),
                    'product_name' => $this->input->post('product_name'),
                    'product_slug' => url_title($this->input->post('product_name'), '-', TRUE),
                    'product_description' => $this->input->post('product_description'),
                    'product_is_display' => $this->input->post('product_is_display'),
                    'product_image' => $this->input->post('product_image_file_name'),
                    'product_quantity' => '',
                    'product_sale_price' => $this->input->post('product_sale_price'),
                    'product_status' => '1',
                    'product_created' => $time_now,
                );
                if ($this->Product_model->add_product($products_insert_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        $data['category_details_array'] = $this->Configuration_model->get_all_categories();
        parent::render_view($data);
    }

    function product_status() {
        parent::allow(array('administrator'));
        if ($this->input->post()) {
            $this->load->model('Product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('product_status', 'Product Status', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $product_edit_array = array(
                    'product_status' => ($this->input->post('product_status') === 'true') ? '1' : '0',
                    'product_modified' => $time_now
                );
                if ($this->Product_model->edit_product_by_id($this->input->post('product_id'), $product_edit_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function product_display_status() {
        parent::allow(array('administrator'));
        if ($this->input->post()) {
            $this->load->model('Product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('products_display_status', 'Product Display Status', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $product_edit_array = array(
                    'product_is_display' => ($this->input->post('products_display_status') === 'true') ? '1' : '0',
                    'product_modified' => $time_now
                );
                if ($this->Product_model->edit_product_by_id($this->input->post('product_id'), $product_edit_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function edit_product($product_id = 0) {
        parent::allow(array('administrator'));
        if($product_id !== 0){
            $this->load->model('Product_model');
            $data = array();
            $data['product_details_array'] = $this->Product_model->get_product_by_id($product_id);
            if(count($data['product_details_array']) > 0 && $data['product_details_array']['product_status'] == '1') {
                $this->load->helper('form');
                if ($this->input->post()) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('category_id', 'Categories Id', 'trim|required');
                    $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
                    $this->form_validation->set_rules('product_description', 'Product Description', 'trim|required');
                    $this->form_validation->set_rules('product_image_file_name', 'Product Image', 'trim|required');
                    $this->form_validation->set_error_delimiters('', '<br />');
                    if ($this->form_validation->run()) {
                        $time_now = date('Y-m-d H:i:s');
                        $product_edit_array = array (
                            'categories_id' => $this->input->post('category_id'),
                            'product_name' => $this->input->post('product_name'),
                            'product_slug' => url_title($this->input->post('product_name'), '-', TRUE),
                            'product_description' => $this->input->post('product_description'),
                            'product_is_display' => ($this->input->post('product_is_display') == 'true') ? '1' : '0',
                            'product_image' => $this->input->post('product_image_file_name'),
                            'product_quantity' => '',
                            'product_sale_price' => $this->input->post('product_sale_price'),
                            'product_status' => '1',
                            'product_modified' => $time_now,
                        );
                        if ($this->Product_model->edit_product_by_id($product_id,$product_edit_array)) {
                            die('1');
                        }
                    } else {
                        echo validation_errors();
                        die;
                    }
                    die('0');
                }

                $data['category_details_array'] = $this->Configuration_model->get_all_categories();
                parent::render_view($data);
                return;
            }
        }
        redirect('configuration/product','refresh');
    }

    function category_datatable() {
        parent::allow(array('administrator'));
        $this->load->library('Datatables');
        $this->datatables->select('category_id, category_name ,category_status')->from('categories');
        $this->datatables->where('categories.category_status != -1');
        echo $this->datatables->generate();
    }

    function upload_files() {
        parent::upload_files();
    }

    function add_category() {
        parent::allow(array('administrator'));
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $category_insert_array = array(
                    'category_name' => $this->input->post('category_name'),
                    'category_slug' => url_title($this->input->post('category_name'), '-', TRUE),
                    'category_status' => '1',
                    'category_created' => $time_now,
                );
                if ($this->Configuration_model->add_category($category_insert_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        parent::render_view($data);
    }

    function edit_category($category_id = 0) {
        parent::allow(array('administrator'));
        if ($category_id !== 0) {
            $data = array();
            $data['category_details_array'] = $this->Configuration_model->get_category_by_id($category_id);
            if (count($data['category_details_array']) > 0 && $data['category_details_array']['category_status'] == '1') {
                $this->load->helper('form');
                if ($this->input->post()) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

                    $this->form_validation->set_error_delimiters('', '<br />');
                    if ($this->form_validation->run()) {
                        $time_now = date('Y-m-d H:i:s');
                        $category_edit_array = array(
                            'category_name' => $this->input->post('category_name'),
                            'category_slug' => url_title($this->input->post('category_name'), '-', TRUE),
                            'category_status' => '1',
                            'category_modified' => $time_now,
                        );
                        if ($this->Configuration_model->edit_category($category_id, $category_edit_array)) {
                            die('1');
                        }
                    } else {
                        echo validation_errors();
                        die;
                    }
                    die('0');
                }
                parent::render_view($data);
                return;
            }
        }
        redirect('configuration/category', 'refresh');
    }

    function change_category_status() {
        parent::allow(array('administrator'));
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('category_status', 'Category Status', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $category_edit_array = array(
                    'category_status' => ($this->input->post('category_status') === 'true') ? '1' : '0',
                    'category_modified' => $time_now
                );
                if ($this->Configuration_model->edit_category($this->input->post('category_id'), $category_edit_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function delete_category() {
        parent::allow(array('administrator'));
        if ($this->input->post('category_id')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $category_details_array = $this->Configuration_model->get_category_by_id($this->input->post('category_id'));
                if (count($category_details_array) > 0) {
                    $category_edit_array = array(
                        'category_status' => '-1',
                        'category_modified' => date('Y-m-d H:i:s')
                    );
                    if ($this->Configuration_model->edit_category($this->input->post('category_id'), $category_edit_array)) {
                        die('1');
                    }
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function delete_product() {
        parent::allow(array('administrator'));
        if ($this->input->post('product_id')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $this->load->model('Product_model');
                $product_details_array = $this->Product_model->get_product_by_id($this->input->post('product_id'));
                if(count($product_details_array) > 0) {
                    $product_edit_array = array(
                        'product_status' => '-1',
                        'product_modified' => date('Y-m-d H:i:s')
                    );
                    if ($this->Product_model->edit_product_by_id($this->input->post('product_id'), $product_edit_array)) {
                        die('1');
                    }
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

}
