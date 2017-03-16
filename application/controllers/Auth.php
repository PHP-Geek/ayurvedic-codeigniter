<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public $public_methods = array();

	function __construct() {
		parent::__construct();
		$this->load->model('Auth_model');
	}

	function index() {
		redirect('login', 'refresh');
	}

	function login() {
		if (isset($_SESSION['user']['user_id'])) {
			redirect('dashboard', 'refresh');
			return;
		}
		$data = array();
		$this->load->helper('form');
		if ($this->input->post()) {
			if (!isset($_SESSION['login_failed_count'])) {
				$_SESSION['login_failed_count'] = 0;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_login', 'Email', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('user_login_password', 'Password', 'trim|required');
			if ($_SESSION['login_failed_count'] > 2) {
				$this->form_validation->set_rules('captcha_image', 'Secure Image', 'trim|required|exact_length[6]|numeric|callback_validate_captcha');
			}
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			if ($this->form_validation->run()) {
               
				$user_details_array = $this->Auth_model->login(base64_decode(base64_decode(trim($this->input->post('user_login')))));
				$this->load->library('encrypt');
				if (
						count($user_details_array) > 0 &&
						strtolower(base64_decode(base64_decode($this->input->post('user_login_password')))) === md5(md5(strtolower($this->encrypt->decode($user_details_array['user_password_hash'], $user_details_array['user_login_password']))))
				) {
					$_SESSION['user'] = $user_details_array;
					$this->Auth_model->update_user_login($user_details_array['user_id']);
					$this->Auth_model->add_login_log(array(
						'users_id' => $user_details_array['user_id'],
						'login_log_from' => '1',
						'login_log_mode' => 'email',
						'login_log_ip_address' => $this->input->server('REMOTE_ADDR'),
						'login_log_user_agent' => $this->input->server('HTTP_USER_AGENT'),
						'login_log_created' => date('Y-m-d H:i:s')
					));
					unset($_SESSION['login_failed_count']);
//					if (isset($_SESSION['redirect_url']) && $_SESSION['redirect_url'] !== '') {
//						$redirect_url = $_SESSION['redirect_url'];
//						unset($_SESSION['redirect_url']);
//						die($redirect_url);
//					}
					die('1');
				}
			}
			$_SESSION['login_failed_count'] ++;
			if ($_SESSION['login_failed_count'] > 2) {
				die('-1');
			}
			die('0');
		}
		if (isset($_SESSION['login_failed_count']) && $_SESSION['login_failed_count'] > 2) {
			$data['captcha_image'] = parent::create_captcha();
		}
		$data['title'] = 'Login';
		parent::render_view($data);
	}

	function signup() {
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('user_email', 'Name', 'trim|required|valid_email|is_unique[users.user_email]');
			$this->form_validation->set_rules('user_login_password', 'Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			if ($this->form_validation->run()) {
				$time_now = date('Y-m-d H:i:s');
				$this->load->library('encrypt');
				$this->load->model('User_model');
				$user_insert_array = array(
					'groups_id' => '3',
					'user_login' => $this->input->post('user_email'),
					'user_login_salt' => md5($time_now),
					'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
					'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
					'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
					'user_name' => $this->input->post('user_name'),
					'user_email' => $this->input->post('user_email'),
					'user_status' => 1,
					'user_created' => $time_now
				);
				if ($this->User_model->add($user_insert_array) > 0) {
					die('1');
				}
				die('0');
			}
			echo validation_errors();
			die;
		}
		$data = array();
		$data['title'] = 'Signup';
		parent::render_view($data, 'auth');
	}

	function logout() {
		session_destroy();
		redirect('login', 'refresh');
	}

	function verify($user_id, $user_security_hash) {
		$data = array();
		$this->load->model('User_model');
		$user_details_array = $this->User_model->get_user_by_id($user_id);
		if (count($user_details_array) > 0 && isset($user_details_array['user_security_hash']) && $user_details_array['user_security_hash'] == $user_security_hash) {
			$this->load->library('encrypt');
			$time_now = date('Y-m-d H:i:s');
			$password = $this->encrypt->decode($user_details_array['user_password_hash'], $user_details_array['user_login_password']);
			$user_update_array = array(
				'user_security_hash' => md5($time_now . $password),
				'user_status' => '1',
				'user_modified' => $time_now
			);
			if ($this->User_model->edit_user_by_user_id($user_id, $user_update_array)) {
				$email_details_array = array(
					'user_name' => $user_details_array['user_name'],
					'user_login' => $user_details_array['user_email'],
					'user_login_password' => $password
				);
				$email_id1 = parent::add_email_to_queue('', '', $user_details_array['user_email'], $user_id, 'Your Account Password', parent::render_view($email_details_array, 'email', 'email/templates/verify', TRUE));
				if ($email_id1 > 0) {
					$file_contents = file_get_contents(base_url() . 'email/cron/' . $email_id1);
				}
				$data['success_message'] = 'Account Verified Successfully.<br/>Please check your email for login instructions.';
			}
		}
		parent::render_view($data, 'auth');
	}

	function validate_email() {
		$this->load->library('form_validation');
		if ($this->input->post('user_email') !== '') {
			if ($this->input->post('user_email')) {
				$this->form_validation->set_rules('user_email', 'Email', 'trim|required|is_unique[users.user_email]');
			}
			if ($this->form_validation->run()) {
				die('true');
			}
		}
		die('false');
	}

	function recover() {
		$data = array();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_address', 'User ID OR Email', 'trim|required');
			$this->form_validation->set_rules('captcha_image', 'Secure Image', 'trim|required|exact_length[6]|numeric|callback_validate_captcha');
			$this->form_validation->set_error_delimiters("", "<br/>");
			if ($this->form_validation->run()) {
				$user_details_array = $this->Auth_model->get_user_by_username_or_email($this->input->post('email_address'));
				if (count($user_details_array) > 0) {
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
								$data['success'] = 'We have sent an email with new password.';
							}
						}
					}
				} else {
					$data['error'] = 'Invalid Email ID !!!';
				}
			} else {
				$data['error'] = validation_errors();
			}
		}
		$data['captcha_image'] = parent::create_captcha();
		parent::render_view($data, 'auth');
	}

	function credentials() {
		parent::allow(array('administrator'));
		$this->load->library('encrypt');
		$this->load->database();
		$user_details_array = $this->db->get('users')->result_array();
		$data = array();
		foreach ($user_details_array as $key => $user_detail) {
			$data['users'][$key] = $user_detail;
			$data['users'][$key]['password'] = $this->encrypt->decode($user_detail['user_password_hash'], $user_detail['user_login_password']);
		}
		parent::render_view($data, 'common');
	}

	function crud() {
		parent::allow(array('administrator'));
		$data = array();
		$this->load->database();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('table', 'Table', 'trim|required');
			$this->form_validation->set_rules('controller', 'Controller', 'trim|required');
			if ($this->form_validation->run()) {
				$data['table'] = $this->input->post('table');
				$data['controller'] = ucfirst($this->input->post('controller'));
				$data['controller_lower'] = strtolower($this->input->post('controller'));
				$data['controller_word'] = ucwords(str_replace('_', ' ', $this->input->post('controller')));
				$data['table_structure_array'] = $this->db->query('SHOW FULL COLUMNS FROM ' . $this->input->post('table'))->result_array();
				$data['columns_array'] = array();
				$data['joined_tables_array'] = array();
				$data['joined_tables_columns_array'] = array();
				foreach ($data['table_structure_array'] as $column) {
					$data['columns_array'][] = $column['Field'];
					if ($column['Comment'] !== '' && (strpos($column['Comment'], ' FROM ') !== FALSE)) {
						$joined_table_array = explode(' FROM ', trim($column['Comment']));
						$joined_table = end($joined_table_array);
						$data['joined_tables_array'][$joined_table] = $data['table'] . '.' . $column['Field'] . ' = ' . $joined_table . '.' . $joined_table_array[0];
						$joined_table_structure_array = $this->db->query('SHOW FULL COLUMNS FROM ' . $joined_table)->result_array();
						foreach ($joined_table_structure_array as $joined_array) {
							$data['joined_tables_columns_array'][] = $joined_array['Field'];
						}
					}
				}
				parent::render_view($data, 'common');
				return;
			}
		}
		$data['tables'] = $this->db->query('SHOW TABLES')->result_array();
		parent::render_view($data, 'common');
	}

}
