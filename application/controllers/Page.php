<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Page_model');
    }

    function home() {
        $data = array();
        parent::render_view($data, 'common', 'page/home');
    }

    function about_us() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function contact_us() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function myaccount() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function checkout() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function cart() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function terms() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function faq() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function order() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function category() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function singleproduct() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function products() {
        $data = array();
        parent::render_view($data, 'common');
    }

    function index() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data,'common');
    }

    function page_not_found() {
        set_status_header(404);
        $data = array();
        $data['title'] = '404 Page Not Found';
        $data['keywords'] = '';
        $data['description'] = '';
        parent::render_view($data, 'common', 'page/page_not_found');
    }

}
