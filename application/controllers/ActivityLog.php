<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLog extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Activity Log';
    }


    public function index()
    {
        // echo "<pre>";
        // print_r($this->permission);
        // echo "<pre>";
        if (!in_array('viewActivityLog', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->load->model('model_activitylog');

        $data['user_permission'] = $this->permission;

        $page     = $this->input->get('page') ?? 1;
        $per_page = 15;
        $offset   = ($page - 1) * $per_page;

        $filters = [
            'user_name'   => $this->input->get('user_name'),
            'action_type' => $this->input->get('action_type'),
            'start_date'  => $this->input->get('start_date'), // e.g. '2025-08-01'
            'end_date'    => $this->input->get('end_date')    // e.g. '2025-08-18'
        ];

        $data = $this->model_activitylog->get_logs_paginated($per_page, $offset, $filters);
        $data['start_index'] =  $offset + 1;
        $data['end_index'] = min($offset + $per_page, $data['total_rows']);
        $data['current_page'] = (int) $this->input->get('page') ?: 1;

        $data['total_pages'] = ceil($data['total_rows'] / $per_page);
        $data['query_string'] = '&' . http_build_query(array_filter($filters));




        // // Display results
        // echo "Showing " . count($data['logs']) . " of " . $data['total_rows'] . " logs.";
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        $this->render_template('activitylog/index', $data);
    }


    public function create() {}


    public function update($id) {}


    public function remove() {}
}