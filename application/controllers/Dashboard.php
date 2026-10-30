<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in(); // Ensure the user is logged in

        $this->data['page_title'] = 'Dashboard';

        // Load models
        $this->load->model('model_products');
        $this->load->model('model_orders');
        $this->load->model('model_users');
        $this->load->model('model_stores');
        $this->load->model('Model_workorder');
    }

    public function index()
    {
        // Fetch counts and other data
        $this->data['total_products'] = $this->model_products->countTotalProducts();
        $this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
        $this->data['total_users'] = $this->model_users->countTotalUsers();
        $this->data['total_stores'] = $this->model_stores->countTotalStores();

        // Get Summary Statistics
        $this->data['workorder_stats'] = $this->Model_workorder->get_summary();

        // Fetch low quantity product count
        $this->data['low_quantity_count'] = $this->model_products->countLowQuantityProducts();

        // Fetch high quantity product count
        $this->data['high_quantity_count'] = $this->model_products->countHighQuantityProducts();
        $this->data['pending_wo'] = count($this->Model_workorder->statusBased_workOrder('Pending'));
        $this->data['inProgress_wo'] = count($this->Model_workorder->statusBased_workOrder('In Progress'));

        $user_id = $this->session->userdata('id');
        $this->data['is_admin'] = ($user_id == 1);


        // Temporary logic to enrich work orders with user info

        // fetch all work orders
        $this->data['work_orders'] = $this->Model_workorder->get_all_work_orders();
        $work_orders = $this->data['work_orders'];

        $work_permission = ["requester", "checker", "endorser", "receiver", "supervisor",  "approver"];

        $permissions = [];

        foreach ($work_permission as $wok) {
            if (in_array($wok, $this->permission)) {
                $permissions[] = $wok;
            }
        }

        // Enrich work orders with user data
        foreach ($work_orders as &$order) {
            $userFields = [
                'requested_by' => 'requestor',
                'checked_by' => 'checker',
                'endorsed_by' => 'endorser',
                'received_by' => 'receiver',
                'approved_by' => 'approver'
            ];
            $signatures = json_decode($order->signatures, true) ?? []; // decode safely

            $sign_need = 0;
            foreach ($userFields as $field => $role) {
                $userId = isset($order->$field) ? $order->$field : null;

                if (is_numeric($userId) && $this->model_users->user_exists($userId)) {
                    $userData = $this->model_users->getUserData($userId);

                    // Replace field with user info
                    $order->$field = [
                        'id'        => $userData['id'],
                        'firstname' => $userData['firstname'],
                        'lastname'  => $userData['lastname']
                    ];

                    // Only count if role is in signatures and still unsigned
                    if (
                        $role !== 'requestor' &&
                        isset($signatures[$role]) &&
                        $signatures[$role] === false &&
                        $this->session->id == $userData['id']
                    ) {
                        $sign_need++;
                    }
                } else {
                    // Fallback for missing or invalid user
                    if (in_array($role, $permissions)) {
                        $order->$field = null;
                    }
                }
            }

            $order->sign_need = $sign_need;
        }

        // end ---



        // Render the view
        $this->render_template('dashboard', $this->data);
    }
}
