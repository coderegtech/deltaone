<?php

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserData($userId = null)
	{
		if ($userId) {
			$sql = "SELECT * FROM `users` WHERE id = ?";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `users` WHERE id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getUserGroup($userId = null)
	{
		if (!$userId) {
			return null;
		}

		$sql = "SELECT * FROM `user_group` WHERE user_id = ?";
		$query = $this->db->query($sql, array($userId));
		$result = $query->row_array();

		if (!$result || !isset($result['group_id'])) {
			return ['id' => 'null', 'group_name' => 'Unassigned', 'permission' => ''];
		}

		$group_id = $result['group_id'];
		$g_sql = "SELECT * FROM `groups` WHERE id = ?";
		$g_query = $this->db->query($g_sql, array($group_id));
		$q_result = $g_query->row_array();

		return $q_result ?: null;
	}

	public function create($data = '', $group_id = null)
	{

		if ($data && $group_id) {
			$create = $this->db->insert('users', $data);

			$user_id = $this->db->insert_id();

			$group_data = array(
				'user_id' => $user_id,
				'group_id' => $group_id
			);

			$group_data = $this->db->insert('user_group', $group_data);

			return [
				'success' => ($create == true && $group_data) ? true : false,
				'user_id' => ($create == true && $group_data) ? $user_id : null
			];
		}
	}

	public function edit($data = array(), $id = null, $group_id = null)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('users', $data);

		if ($group_id) {
			// user group
			$update_user_group = array('group_id' => $group_id);
			$this->db->where('user_id', $id);
			$user_group = $this->db->update('user_group', $update_user_group);
			return ($update == true && $user_group == true) ? true : false;
		}

		return ($update == true) ? true : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('users');
		$this->db->where('user_id', $id)->delete('user_group');
		return ($delete == true) ? true : false;
	}

	public function countTotalUsers()
	{
		$sql = "SELECT * FROM `users`";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	public function get_all_users()
	{
		$this->db->select('id, firstname, lastname');
		$this->db->from('users');
		$this->db->order_by('firstname', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}
	public function user_exists($id)
	{
		return $this->db->where('id', $id)->get('users')->row() ? true : false;
	}


	public function getUserGroupsByPermission($permission = null)
	{
		if (!$permission) {
			return [];
		}

		$length = strlen($permission);
		$search = 's:' . $length . ':"' . $permission . '"';

		$sqlGroups = "SELECT * FROM `groups` WHERE `permission` LIKE ?";
		$queryGroups = $this->db->query($sqlGroups, array('%' . $search . '%'));
		$groupList = $queryGroups->result_array();

		if (empty($groupList)) {
			return []; // No matching groups found
		}

		$groupIds = array_column($groupList, 'id');

		$placeholders = implode(',', array_fill(0, count($groupIds), '?'));

		$sqlUserGroups = "SELECT * FROM `user_group` WHERE `group_id` IN ($placeholders)";
		$queryUserGroups = $this->db->query($sqlUserGroups, $groupIds);
		$userGroupRows = $queryUserGroups->result_array();

		return $userGroupRows;
	}

	public function getUsersByIds(array $userGroups)
	{
		// Step 1: Extract user_id values
		$userIds = array_column($userGroups, 'user_id');

		$all_users = $this->db->get('users')->result_array();

		$filteredUsers = [];

		foreach ($all_users as $user) {
			if (in_array($user['id'], $userIds)) {
				$obj = new stdClass();
				$obj->id        = $user['id'];
				$obj->firstname = $user['firstname'];
				$obj->lastname  = $user['lastname'];
				$filteredUsers[] = $obj;
			}
		}

		return $filteredUsers;
	}
}
