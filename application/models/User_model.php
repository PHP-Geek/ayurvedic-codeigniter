<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function save($user_details_array) {
        if (isset($user_details_array['user_id'])) {
            return $this->db->where('user_id', $user_details_array['user_id'])->update('users', $user_details_array);
        }
        if ($this->db->insert('users', $user_details_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function add($user_insert_array) {
        if ($this->db->insert('users', $user_insert_array)) {
            return $this->db->insert_id();
        }
        return 0;
    }

    function get_user_by_id($user_id) {
//        $this->db->join('groups', 'groups.group_id = users.groups_id', 'left');
        return $this->db->get_where('users', array('user_id' => $user_id))->row_array();
    }

    function get_active_user_by_id_and_security_hash($user_id, $user_security_hash) {
        $this->db->join('groups', 'groups.group_id = users.groups_id', 'left');
        return $this->db->get_where('users', array('user_id' => $user_id, 'user_security_hash' => $user_security_hash, 'user_status' => '1'))->row_array();
    }

    function edit_user_by_user_id($user_id, $user_details_array) {
        return $this->db->where('user_id', $user_id)->update('users', $user_details_array);
    }

    function get_all_users() {
        return $this->db->get_where('users', array('groups_id' => 3))->result_array();
    }

    function get_all_active_users_by_group_id($group_id) {
        return $this->db->get_where('users', array('groups_id' => $group_id, 'user_status' => '1'))->result_array();
    }

}
