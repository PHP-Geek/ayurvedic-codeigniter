<?php

// Controller : Inventory.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

}
