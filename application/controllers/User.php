<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    function index() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function change_password() {
        parent::allow(array('administrator', 'manager', 'dispatcher'));
        $data = array();
        $data['user_details_array'] = $this->User_model->get_user_by_id($_SESSION['user']['user_id']);
        if ($data['user_details_array']['user_status'] === '-1') {
            redirect('auth/logout');
        }
        $this->load->library('encrypt');
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('user_confirm_password', 'Confirm Password ', 'trim|required|matches[user_login_password]');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $user_details_array = array(
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                    'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                    'force_change_password' => '0',
                    'user_modified' => $time_now
                );
                if ($this->User_model->edit_user_by_user_id($_SESSION['user']['user_id'], $user_details_array)) {
                    parent::regenerate_session();
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('Error Changing Password !!!');
        }
        parent::render_view($data);
    }

    function profile() {
        parent::allow(array('administrator', 'manager', 'dispatcher'));
        $data = array();
        $this->load->helper('form');
        $data['user_details_array'] = $this->User_model->get_user_by_id($_SESSION['user']['user_id']);
        if ($this->input->post()) {
            $this->load->library('form_validation');
            if ($this->input->post('user_profile_image')) {
                $this->form_validation->set_rules('user_profile_image', 'Image Details', 'trim|required');
            } else if ($this->input->post('user_login')) {
                $this->form_validation->set_rules('user_login', 'Username', 'trim|required|edit_unique[users.user_login.user_id.' . $data['user_details_array']['user_id'] . ']');
                $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|edit_unique[users.user_email.user_id.' . $data['user_details_array']['user_id'] . ']');
                $this->form_validation->set_rules('user_contact', 'Contact', 'trim|required');
            }
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                if ($this->input->post('user_profile_image')) {
                    $user_profile_image = json_decode($this->input->post('user_profile_image'));
                    if (
                            isset($user_profile_image->x) &&
                            isset($user_profile_image->y) &&
                            isset($user_profile_image->w) &&
                            $user_profile_image->w > 0 &&
                            isset($user_profile_image->h) &&
                            $user_profile_image->h > 0 &&
                            file_exists(FCPATH . 'uploads/' . $user_profile_image->file)
                    ) {

                        $destination_path = FCPATH . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created']));
                        @mkdir($destination_path, 0755, TRUE);
                        if (parent::crop_image(FCPATH . 'uploads/' . $user_profile_image->file, $destination_path . $user_profile_image->file, $user_profile_image->w, $user_profile_image->h, $user_profile_image->x, $user_profile_image->y) == '1') {
                            $user_edit_array = array(
                                'user_profile_image' => $user_profile_image->file,
                                'user_modified' => $time_now
                            );
                            if ($this->User_model->edit_user_by_user_id($_SESSION['user']['user_id'], $user_edit_array)) {
                                @unlink($destination_path . $_SESSION['user']['user_profile_image']);
                                parent::regenerate_session();
                                die('1');
                            }
                        }
                    }
                } else if ($this->input->post('user_login')) {
                    $user_edit_array = array(
                        'user_login' => $this->input->post('user_login'),
                        'user_name' => $this->input->post('user_name'),
                        'user_email' => $this->input->post('user_email'),
                        'user_contact' => $this->input->post('user_contact'),
                        'user_modified' => $time_now
                    );
                    if ($this->User_model->edit_user_by_user_id($_SESSION['user']['user_id'], $user_edit_array)) {
                        parent::regenerate_session();
                        die('1');
                    }
                    die('0');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        parent::render_view($data);
    }

    function upload_files() {
        parent::upload_files();
    }

    function list_factory() {
        parent::allow(array('administrator'));
        $data = array();
        parent::render_view($data);
    }

    function factory_datatable() {
        parent::allow(array('administrator'));
        $this->load->library('Datatables');
        $this->datatables->select('user_id, user_name, user_address, user_email, user_contact, user_status')->from('users');
        $this->datatables->where('users.groups_id', '3');
        echo $this->datatables->generate();
    }

    function factory($user_id = 0) {
        parent::allow(array('administrator'));
        $data = array();
        $time_now = date('Y-m-d H:i:s');
        if ($user_id !== 0) {
            $data['user_details_array'] = $this->User_model->get_user_by_id($user_id);
            $data['user_details_array']['user_modified'] = $time_now;
        } else {
            $data['user_details_array']['groups_id'] = '3';
            $data['user_details_array']['user_status'] = '1';
            $data['user_details_array']['user_created'] = $time_now;
        }
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('user_email', 'User Email', 'trim|required');
            $this->form_validation->set_rules('user_contact', 'User Contact', 'trim|required');
            $this->form_validation->set_rules('user_address', 'User Address', 'trim|required');
            if ($this->form_validation->run()) {
                $data['user_details_array']['user_name'] = $this->input->post('user_name');
                $data['user_details_array']['user_login'] = $this->input->post('user_email');
                $data['user_details_array']['user_email'] = $this->input->post('user_email');
                $data['user_details_array']['user_contact'] = $this->input->post('user_contact');
                $data['user_details_array']['user_address'] = $this->input->post('user_address');
                if ($this->User_model->save($data['user_details_array'])) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
            die('0');
        }
        parent::render_view($data, '', 'user/factory');
        return;
    }

    function change_status() {
        parent::allow(array('administrator'));
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('user_status', 'User Status', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $user_edit_array = array(
                    'user_status' => ($this->input->post('user_status') === 'true') ? '1' : '0',
                    'user_modified' => $time_now
                );
                if ($this->User_model->edit_user_by_user_id($this->input->post('user_id'), $user_edit_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function delete() {
        parent::allow(array('administrator'));
        if ($this->input->post('user_id')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_error_delimiters('', '<br />');
            if ($this->form_validation->run()) {
                $user_details_array = $this->User_model->get_user_by_id($this->input->post('user_id'));
                if (count($user_details_array) > 0) {
                    $user_edit_array = array(
                        'user_status' => '-1',
                        'user_modified' => date('Y-m-d H:i:s')
                    );
                    if ($this->User_model->edit($this->input->post('user_id'), $user_edit_array)) {
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
