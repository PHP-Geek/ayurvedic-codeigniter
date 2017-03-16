<?php

// Model : Page_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function add($page_insert_array) {
		if ($this->db->insert('pages', $page_insert_array)) {
			return $this->db->insert_id();
		}
		return 0;
	}

	function edit($page_id, $page_edit_array) {
		return $this->db->where('page_id', $page_id)->update('pages', $page_edit_array);
	}

	function get_page_by_id($page_id) {
		return $this->db->get_where('pages', array('page_id' => $page_id))->row_array();
	}

	function get_page_by_slug($page_slug) {
		return $this->db->get_where('pages', array('page_slug' => $page_slug))->row_array();
	}

	function get_all_pages() {
		return $this->db->get('pages')->result_array();
	}

}
