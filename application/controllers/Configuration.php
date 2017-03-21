<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Configuration_model');
    }

    function category() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function product_datatable() {
        parent::allow(array('administrator'));
        $this->load->library('Datatables');
        $this->datatables->select("product_id, category_name, product_name, product_description, product_quantity, IF(product_image_1 = '', '', (CONCAT('" . base_url() . 'uploads/products/' . "',DATE_FORMAT(product_created,'%Y/%m/%d/%H/%i/%s/'),product_image_1))) AS image_url_1, IF(product_image_2 = '', '', (CONCAT('" . base_url() . 'uploads/products/' . "',DATE_FORMAT(product_created,'%Y/%m/%d/%H/%i/%s/'),product_image_2))) AS image_url_2, product_is_display, product_status")->from('products');
        $this->datatables->join('categories', 'categories.category_id=products.product_id', 'left');
        $this->datatables->where('products.product_status != -1');
        echo $this->datatables->generate();
    }

    function list_product() {
        parent::allow(array('administrator'));
        $data = array();
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

    function product($product_id = 0) {
        parent::allow(array('administrator'));
        $data = array();
        $time_now = date('Y-m-d H:i:s');
        $this->load->model('Product_model');
        if ($product_id !== 0) {
            $data['product_quantities_details_array'] = $this->Product_model->get_product_quantities_by_product_id($product_id);
            $data['product_details_array'] = $this->Product_model->get_product_by_id($product_id);
            if (count($data['product_details_array']) == 0) {
                redirect('configuration/list_product', 'refresh');
            }
            $data['product_details_array']['product_modified'] = $time_now;
        } else {
            $data['product_details_array']['product_quantity'] = 0;
            $data['product_details_array']['product_status'] = 1;
            $data['product_details_array']['product_created'] = $time_now;
        }
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'Categories Id', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('product_description', 'Product Description', 'trim|required');
            $this->form_validation->set_rules('product_quantity_volume[]', 'Product Sale Price Volume', 'trim|required');
            $this->form_validation->set_rules('product_images[]', 'Product Image', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                foreach ($this->input->post('product_quantity_volume') as $key => $product_quantity_volume) {
                    if ($product_quantity_volume != "" || $this->input->post('unit_id')[$key] != "" || $this->input->post('product_quantity_price')[$key] != "") {
                        if ($product_quantity_volume == "" || $this->input->post('unit_id')[$key] == "" || $this->input->post('product_quantity_price')[$key] == "") {
                            die('Please fill Sale price for particular volume.');
                        }
                    }
                }
                foreach ($this->input->post('product_images') as $key => $product_image) {
                    $upload_thumbnail[$key] = $product_image;
                    if (is_file(FCPATH . 'uploads/' . $upload_thumbnail[$key])) {
                        $upload_image_directory = FCPATH . 'uploads/products/' . date('Y/m/d/H/i/s', strtotime($time_now));
                        if (!is_dir($upload_image_directory)) {
                            mkdir($upload_image_directory, 0777, TRUE);
                        }
                        if (parent::resize_image(FCPATH . 'uploads/' . $upload_thumbnail[$key], $upload_image_directory . '/' . $upload_thumbnail[$key], 150, 150)) {
                            unlink(FCPATH . 'uploads/' . $upload_thumbnail[$key]);
                        }
                    }
                }
                $data['product_details_array']['categories_id'] = $this->input->post('category_id');
                $data['product_details_array']['product_name'] = $this->input->post('product_name');
                $data['product_details_array']['product_slug'] = url_title($this->input->post('product_name'), '-', TRUE);
                $data['product_details_array']['product_description'] = $this->input->post('product_description');
                $data['product_details_array']['product_is_display'] = ($this->input->post('product_is_display') == 1 ? 1 : 0);
                $data['product_details_array']['product_image_1'] = $upload_thumbnail[0];
                $data['product_details_array']['product_image_2'] = isset($upload_thumbnail[1]) ? $upload_thumbnail[1] : "";
                if ($product_id == 0) {
                    $product_id = $this->Product_model->save($data['product_details_array']);
                }
                if ($product_id > 0) {
                    $this->Product_model->edit_product_quantities_by_product_id($product_id, array(
                        'product_quantity_status' => '-1',
                        'product_quantity_modified' => $time_now
                    ));
                    if (count($this->input->post('product_quantity_volume')) > 0) {
                        foreach ($this->input->post('product_quantity_volume') as $key => $product_quantity_volume) {
                            $product_quantity_insert_array[] = array(
                                'products_id' => $product_id,
                                'units_id' => $this->input->post('unit_id')[$key],
                                'product_quantity_volume' => $product_quantity_volume,
                                'product_quantity_price' => $this->input->post('product_quantity_price')[$key],
                                'product_quantity_status' => 1,
                                'product_quantity_created' => $time_now
                            );
                        }
                        $this->Product_model->add_product_quantities_batch($product_quantity_insert_array);
                        die('1');
                    }
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        $data['category_details_array'] = $this->Configuration_model->get_all_categories();
        $data['units_array'] = $this->Configuration_model->get_all_units();
        parent::render_view($data);
        return;
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
                if (count($product_details_array) > 0) {
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
