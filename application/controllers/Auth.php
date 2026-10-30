<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
		$this->load->model('model_activitylog');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$email_exists = $this->model_auth->check_email($this->input->post('email'));

			if ($email_exists == TRUE) {
				$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

				if ($login) {

					$logged_in_sess = array(
						'id' => $login['id'],
						'username'  => $login['username'],
						'email'     => $login['email'],
						'logged_in' => TRUE
					);

					$log_data = [
						'user_name'    => $login['email'],
						'action_type'  => 'Login',
						'description'  => 'System Login'
						// log_time auto-filled by model
					];

					$log_id = $this->model_activitylog->create_log($log_data);

					if ($log_id) {
						log_message('info', "Login log created. ID: {$log_id}");
					} else {
						log_message('error', "Failed to create login log.");
					}



					$this->session->set_userdata($logged_in_sess);
					redirect('dashboard', 'refresh');
				} else {
					$this->data['errors'] = 'Incorrect username/password combination';
					$this->load->view('login', $this->data);
				}
			} else {
				$this->data['errors'] = 'Email does not exists';

				$this->load->view('login', $this->data);
			}
		} else {
			// false case
			$this->load->view('login');
		}
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{


		$user_name = $this->session->userdata('email');

		// ✅ Step 2: Create logout log
		if ($user_name) {
			$log_data = [
				'user_name'    => $user_name,
				'action_type'  => 'Logout',
				'description'  => 'System Logout'
				// log_time auto-filled
			];

			$log_id = $this->model_activitylog->create_log($log_data);

			if ($log_id) {
				log_message('info', "Logout log created. ID: {$log_id}");
			} else {
				log_message('error', "Failed to log logout for user: {$user_name}");
			}
		} else {
			log_message('debug', "Logout attempted with no active session.");
		}

		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
}
