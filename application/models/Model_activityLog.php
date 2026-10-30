<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_activityLog extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_log($data = [])
    {
        if (!isset($data['user_name'], $data['action_type'])) {
            return false; // or throw an exception if preferred
        }
        // ✅ Set timezone locally for logging only
        date_default_timezone_set('Asia/Manila');

        // ✅ Optional: auto-fill timestamp if not provided
        if (!isset($data['log_time'])) {
            $data['log_time'] = date('Y-m-d H:i:s');
        }

        // ✅ Insert into activity_log table
        $insert = $this->db->insert('activity_log', $data);

        // ✅ Return insert status or new ID
        return $insert ? $this->db->insert_id() : false;
    }

    public function get_logs_paginated($limit = 10, $offset = 0, $filters = [])
    {
        // a bare end date ('2025-08-18') means "through the end of that day", not midnight
        if (!empty($filters['end_date']) && strlen($filters['end_date']) === 10) {
            $filters['end_date'] .= ' 23:59:59';
        }

        // ✅ Apply filters: user_name, action_type
        if (!empty($filters['user_name'])) {
            $this->db->where('user_name', $filters['user_name']);
        }

        if (!empty($filters['action_type'])) {
            $this->db->where('action_type', $filters['action_type']);
        }

        // ✅ Apply date range filter
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where('log_time >=', $filters['start_date']);
            $this->db->where('log_time <=', $filters['end_date']);
        }

        // ✅ Get paginated results
        $query = $this->db
            ->order_by('log_time', 'DESC')
            ->limit($limit, $offset)
            ->get('activity_log');

        $results = $query->result_array();

        // ✅ Get total count for pagination UI
        $this->db->from('activity_log');

        if (!empty($filters['user_name'])) {
            $this->db->where('user_name', $filters['user_name']);
        }

        if (!empty($filters['action_type'])) {
            $this->db->where('action_type', $filters['action_type']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where('log_time >=', $filters['start_date']);
            $this->db->where('log_time <=', $filters['end_date']);
        }

        $total = $this->db->count_all_results();

        return [
            'logs'       => $results,
            'total_rows' => $total
        ];
    }
}
