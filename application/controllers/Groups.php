<?php

class Groups extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Groups';


		$this->load->model('model_groups');
		$this->load->model('model_activitylog');
	}

	/* 
	* It redirects to the manage group page
	* As well as the group data is also been passed to display on the view page
	*/
	public function index()
	{

		if (!in_array('viewGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$groups_data = $this->model_groups->getGroupData();
		$this->data['groups_data'] = $groups_data;

		$this->render_template('groups/index', $this->data);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation is for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{

		if (!in_array('createGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('group_name', 'Group name', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$permission = serialize($this->input->post('permission'));

			$data = array(
				'group_name' => $this->input->post('group_name'),
				'permission' => $permission
			);

			$create = $this->model_groups->create($data);
			if ($create == true) {


				$user_name = $this->session->userdata('email');

				// ✅ Record Log
				if ($user_name) {
					$log_data = [
						'user_name'    => $user_name,
						'action_type'  => 'Create',
						'description'  => "Creating Group: [{$data['group_name']}]"
						// log_time auto-filled
					];

					$log_id = $this->model_activitylog->create_log($log_data);

					if ($log_id) {
						log_message('info', "Create Group log successful. ID: {$log_id}");
					} else {
						log_message('error', "Failed to add log create group for user: {$user_name}");
					}
				}








				$this->session->set_flashdata('success', 'Successfully created');
				redirect('groups/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('groups/create', 'refresh');
			}
		} else {
			// false case
			$this->render_template('groups/create', $this->data);
		}
	}

	/*
	* If the validation is not valid, then it redirects to the edit group page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function edit($id = null)
	{

		if (!in_array('updateGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {

			$this->form_validation->set_rules('group_name', 'Group name', 'required');

			if ($this->form_validation->run() == TRUE) {
				// true case
				$permission = serialize($this->input->post('permission'));

				$data = array(
					'group_name' => $this->input->post('group_name'),
					'permission' => $permission
				);

				$update = $this->model_groups->edit($data, $id);
				if ($update == true) {

					$user_name = $this->session->userdata('email');

					// ✅ adding log
					if ($user_name) {
						$log_data = [
							'user_name'    => $user_name,
							'action_type'  => 'Update',
							'description'  => "Update Group: [{$data['group_name']}]"
							// log_time auto-filled
						];

						$log_id = $this->model_activitylog->create_log($log_data);

						if ($log_id) {
							log_message('info', "Added Log for Update Group. ID: {$log_id}");
						} else {
							log_message('error', "Failed to add log Update Group for user: {$user_name}");
						}
					}





					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('groups/', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('groups/edit/' . $id, 'refresh');
				}
			} else {
				// false case
				$group_data = $this->model_groups->getGroupData($id);
				$this->data['group_data'] = $group_data;
				$this->render_template('groups/edit', $this->data);
			}
		}
	}

	/*
	* It removes the removes information from the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function delete()
	{
		if (!in_array('deleteGroup', $this->permission)) {
			$response['success'] = false;
			$response['messages'] = "You don't have permission to access this page";
			echo json_encode($response);
			return;
		}

		$group_id = $this->input->post('group_id');
		$response = array();

		if ($group_id) {

			$delete = $this->model_groups->delete($group_id);

			if ($delete == true) {

				// Creating Log
				$user_name = $this->session->userdata('email');

				if ($user_name) {
					$log_data = [
						'user_name'    => $user_name,
						'action_type'  => 'Delete',
						'description'  => "Delete Group: [{$group_id}]"
						// log_time auto-filled
					];

					$log_id = $this->model_activitylog->create_log($log_data);

					if ($log_id) {
						log_message('info', "Added log: Delete Group. ID: {$log_id}");
					} else {
						log_message('error', "Failed to Add Log: Delete Group for user: {$user_name}");
					}
				}



				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the group information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}

		echo json_encode($response);
	}
	public function update($id = null)
	{
		// 🔐 Permission check
		if (!in_array('updateGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			// 🛡️ Validate input
			$this->form_validation->set_rules('group_name', 'Group name', 'required');

			if ($this->form_validation->run() == TRUE) {
				// ✅ Valid input: prepare data
				$permission = serialize($this->input->post('permission'));

				$data = array(
					'group_name' => $this->input->post('group_name'),
					'permission' => $permission
				);

				// 🛠️ Update group in DB
				$update = $this->model_groups->edit($data, $id);
				if ($update == true) {



					// Creating Log
					$user_name = $this->session->userdata('email');

					if ($user_name) {
						$log_data = [
							'user_name'    => $user_name,
							'action_type'  => 'Update',
							'description'  => "Update Group: [{$data['group_name']}]"
							// log_time auto-filled
						];

						$log_id = $this->model_activitylog->create_log($log_data);

						if ($log_id) {
							log_message('info', "Added log: Update Group. ID: {$log_id}");
						} else {
							log_message('error', "Failed to Add Log: Update Group for user: {$user_name}");
						}
					}









					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('groups/edit/' . $id, 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('groups/edit/' . $id, 'refresh');
				}
			}
		} else {
			// false case
			$group_data = $this->model_groups->getGroupData($id);
			$this->data['group_data'] = $group_data;
			$this->render_template('groups/edit', $this->data);
		}
	}
}
