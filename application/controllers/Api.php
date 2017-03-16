<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

	public $public_methods = array();

	function __construct() {
		parent::__construct();
		if (!$this->input->post()) {
			$this->output->set_status_header('401');
			die;
		}
	}

	private function _error() {
		parent::json_output(array('code' => '0', 'message' => 'Internal Server Error !!!'));
		return;
	}

	private function _get_user() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('user_security_hash', 'User Security Hash', 'trim|required|exact_length[32]');
		if ($this->form_validation->run()) {
			$this->load->model('User_model');
			return $this->User_model->get_active_user_by_id_and_security_hash($this->input->post('user_id'), $this->input->post('user_security_hash'));
		}
		return array();
	}

	private function _get_all_configurations() {
		$this->load->model('Configuration_model');
		$configurations_array = $this->Configuration_model->get_all_configurations();
		$configurations_key_value_array = array();
		foreach ($configurations_array as $configuration) {
			$configurations_key_value_array[$configuration['configuration_key']] = $configuration['configuration_value'];
		}
		return $configurations_key_value_array;
	}

	function index() {
		parent::json_output(array('code' => '1', 'message' => 'OK', 'data' => array('configurations' => $this->_get_all_configurations())));
		return;
	}

	function signup() {
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('User_model');
		$this->form_validation->set_rules('user_name', 'Login', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('user_contact', 'Phone', 'trim|required');
		if ($this->form_validation->run()) {
			$time_now = date('Y-m-d H:i:s');
			$password = parent::generate_random_string('alnum');
			$user_details_array = array(
				'groups_id' => '4',
				'user_login' => $this->input->post('user_email'),
				'user_login_salt' => md5($time_now),
				'user_login_password' => md5(md5(md5($time_now) . $password)),
				'user_password_hash' => $this->encrypt->encode($password, md5(md5(md5($time_now) . $password))),
				'user_security_hash' => md5($time_now . $password),
				'user_name' => $this->input->post('user_name'),
				'user_email' => $this->input->post('user_email'),
				'user_contact' => $this->input->post('user_contact'),
				'user_status' => '0',
				'force_change_password' => '1',
				'user_created' => $time_now
			);
			$user_id = $this->User_model->add($user_details_array);
			if ($user_id > 0) {
				$email_details_array = array(
					'user_name' => $this->input->post('user_name'),
					'user_email' => $this->input->post('user_email'),
					'user_id' => $user_id,
					'user_security_hash' => $user_details_array['user_security_hash']
				);
				$email_id1 = parent::add_email_to_queue('', '', $this->input->post('user_email'), $user_id, 'Confirm Email Address', parent::render_view($email_details_array, 'email', 'email/templates/add_user', TRUE));
				if ($email_id1 > 0) {
					$file_contents = file_get_contents(base_url() . 'email/cron/' . $email_id1);
					if ($file_contents === '1') {
						$email_id2 = parent::add_email_to_queue('', '', $this->config->item('admin_email'), '1', 'New User Signup', parent::render_view($user_details_array, 'email', 'email/templates/admin_add_user', TRUE));
						if ($email_id2 > 0) {
							$file_contents = file_get_contents(base_url() . 'email/cron/' . $email_id2);
							if ($file_contents === '1') {
								parent::json_output(array('code' => '1', 'message' => 'User Signup Successful.', 'data' => $user_details_array));
								return;
							}
						}
					}
				}
			}
		}
		$this->_error();
	}

	function login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_login', 'Username OR Email ID', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('login_log_longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('login_log_latitude', 'Latitude', 'trim|required');
		if ($this->form_validation->run()) {
			$this->load->model('Auth_model');
			$user_details_array = $this->Auth_model->login(trim($this->input->post('user_login')));
			$this->load->library('encrypt');
			if (
					count($user_details_array) > 0 &&
					strtolower(trim($this->input->post('user_login_password'))) === strtolower($this->encrypt->decode($user_details_array['user_password_hash'], $user_details_array['user_login_password']))
			) {
				$this->Auth_model->update_user_login($user_details_array['user_id']);
				$this->Auth_model->add_login_log(array(
					'users_id' => $user_details_array['user_id'],
					'login_log_from' => '2',
					'login_log_mode' => 'mobile',
					'login_log_ip_address' => $this->input->server('REMOTE_ADDR'),
					'login_log_user_agent' => $this->input->server('HTTP_USER_AGENT'),
					'login_log_longitude' => $this->input->post('login_log_longitude'),
					'login_log_latitude' => $this->input->post('login_log_latitude'),
					'login_log_created' => date('Y-m-d H:i:s')
				));
				$user_details_array['configurations'] = $this->_get_all_configurations();
				parent::json_output(array('code' => '1', 'message' => 'Logged In Successfully.', 'data' => $user_details_array));
				return;
			}
		}
		$this->_error();
	}

	function session_login() {
		$user_details_array = $this->_get_user();
		if (count($user_details_array) > 0) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('login_log_longitude', 'Longitude', 'trim|required');
			$this->form_validation->set_rules('login_log_latitude', 'Latitude', 'trim|required');
			if ($this->form_validation->run()) {
				$this->load->model('Auth_model');
				$this->Auth_model->update_user_login($user_details_array['user_id']);
				$this->Auth_model->add_login_log(array(
					'users_id' => $user_details_array['user_id'],
					'login_log_from' => '2',
					'login_log_mode' => 'mobile',
					'login_log_ip_address' => $this->input->server('REMOTE_ADDR'),
					'login_log_user_agent' => $this->input->server('HTTP_USER_AGENT'),
					'login_log_longitude' => $this->input->post('login_log_longitude'),
					'login_log_latitude' => $this->input->post('login_log_latitude'),
					'login_log_created' => date('Y-m-d H:i:s')
				));
				$user_details_array['configurations'] = $this->_get_all_configurations();
				parent::json_output(array('code' => '1', 'message' => 'Logged In Successfully.', 'data' => $user_details_array));
				return;
			}
		}
		$this->_error();
	}

	function recover() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email_address', 'User ID OR Email', 'trim|required');
		if ($this->form_validation->run()) {
			$this->load->model('Auth_model');
			$user_details_array = $this->Auth_model->get_user_by_username_or_email($this->input->post('email_address'));
			if (count($user_details_array) > 0 && isset($user_details_array['group_slug']) && $user_details_array['group_slug'] === 'user') {
				$new_password = parent::generate_random_string();
				$time_now = date('Y-m-d H:i:s');
				$this->load->library('encrypt');
				$user_update_array = array(
					'user_login_salt' => md5($time_now),
					'user_login_password' => md5(md5(md5($time_now) . $new_password)),
					'user_password_hash' => $this->encrypt->encode($new_password, md5(md5(md5($time_now) . $new_password))),
					'user_security_hash' => md5($time_now . $new_password),
					'user_modified' => $time_now,
					'force_change_password' => '1'
				);
				$this->load->model('User_model');
				if ($this->User_model->edit_user_by_user_id($user_details_array['user_id'], $user_update_array)) {
					$email_details_array = array(
						'user_name' => $user_details_array['user_name'],
						'user_email' => $user_details_array['user_email'],
						'user_login_password' => $new_password
					);
					$email_id = parent::add_email_to_queue('', '', $user_details_array['user_email'], $user_details_array['user_id'], 'Your Account Password', parent::render_view($email_details_array, 'email', 'email/templates/forgot_password', TRUE));
					if ($email_id > 0) {
						$file_contents = file_get_contents(base_url() . 'email/cron/' . $email_id);
						if ($file_contents === '1') {
							parent::json_output(array('code' => '1', 'message' => 'We have sent an email with new password.', 'data' => $user_update_array['user_security_hash']));
							return;
						}
					}
				}
			}
		}
		$this->_error();
	}

	function change_password() {
		$user_details_array = $this->_get_user();
		if (count($user_details_array) > 0 && isset($user_details_array['group_slug']) && $user_details_array['group_slug'] === 'user') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_login_password', 'Password', 'trim|required');
			$this->form_validation->set_rules('confirm_login_password', 'Confirm Password', 'trim|required|matches[user_login_password]');
			if ($this->form_validation->run()) {
				$new_password = $this->input->post('user_login_password');
				$time_now = date('Y-m-d H:i:s');
				$this->load->library('encrypt');
				$user_update_array = array(
					'user_login_salt' => md5($time_now),
					'user_login_password' => md5(md5(md5($time_now) . $new_password)),
					'user_password_hash' => $this->encrypt->encode($new_password, md5(md5(md5($time_now) . $new_password))),
					'user_security_hash' => md5($time_now . $new_password),
					'user_modified' => $time_now
				);
				$this->load->model('User_model');
				if ($this->User_model->edit_user_by_user_id($user_details_array['user_id'], $user_update_array)) {
					parent::json_output(array('code' => '1', 'message' => 'Password Changed Successfully.', 'data' => $user_update_array));
					return;
				}
			}
		}
		$this->_error();
	}

	function edit_profile() {
		$user_details_array = $this->_get_user();
		if (count($user_details_array) > 0 && isset($user_details_array['group_slug']) && in_array($user_details_array['group_slug'], array('user'))) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_email', 'Email', 'trim|valid_email|edit_unique[users.user_email.user_id.' . $user_details_array['user_id'] . ']');
			$this->form_validation->set_rules('user_contact', 'Phone', 'trim|required');
			$this->form_validation->set_rules('user_name', 'Name', 'trim|required');
			if ($this->form_validation->run()) {
				$user_update_array = array();
				$user_update_array['user_email'] = $this->input->post('user_email');
				$user_update_array['user_login'] = $this->input->post('user_email');
				$user_update_array['user_name'] = $this->input->post('user_name');
				$user_update_array['user_contact'] = $this->input->post('user_contact');
				$user_update_array['user_modified'] = date('Y-m-d H:i:s');
				$this->load->model('User_model');
				if ($this->User_model->edit_user_by_user_id($user_details_array['user_id'], $user_update_array)) {
					$user_details_array = $this->_get_user();
					parent::json_output(array('code' => '1', 'message' => 'Account Edited Successfully.', 'data' => $user_details_array));
					return;
				}
			}
		}
		$this->_error();
	}

}
