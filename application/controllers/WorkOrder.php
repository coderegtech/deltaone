<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WorkOrder extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Work Order';
        $this->load->model('Model_workorder');
        $this->load->model('Model_products');
        $this->load->model('Model_users');
        $this->load->model('model_activitylog');
    }

    public function index()
    {
        // Optional permission check
        if (!in_array('viewWorkOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        // Get Summary Statistics
        $stats = $this->Model_workorder->get_summary();

        // Get Work Order List
        $work_orders = $this->Model_workorder->get_all_work_orders();


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

                if (is_numeric($userId) && $this->Model_users->user_exists($userId)) {
                    $userData = $this->Model_users->getUserData($userId);

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

        // Prepare data for view
        $data = [
            'stats' => $stats,
            'work_orders' => $work_orders,
            'permissions' => $permissions,

        ];

        // Optional debug output
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        // Render the view
        $this->render_template('work_order/index', $data);
    }

    // CREATE FORM
    public function create()
    {
        if (!in_array('createWorkOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $data['request_no'] = $this->Model_workorder->generate_request_no();
        $data['products'] = $this->Model_products->getActiveProductData2(); // For dropdown search

        // requested by list users: 
        $requesters = $this->Model_users->getUserGroupsByPermission('requester');
        $data['requesters'] = $this->Model_users->getUsersByIds($requesters); // For Requested By dropdown



        // checked by list users: 
        $checker = $this->Model_users->getUserGroupsByPermission('checker');
        $data['checkers'] = $this->Model_users->getUsersByIds($checker); //
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";


        $this->render_template('work_order/create', $data);
    }


    public function store()
    {
        if (!in_array('createWorkOrder', $this->permission)) {
            echo json_encode(['success' => false, 'errors' => ["You don't have permission to create work orders."]]);
            return;
        }

        $this->load->model('Model_workorder');
        $this->load->model('Model_products');
        $this->load->model('Model_users');

        $errors = [];

        // Collect POST data
        $request_no     = $this->input->post('request_no', true);
        $request_date   = $this->input->post('request_date', true);
        $request_time   = $this->input->post('request_time', true);
        $priority_mode  = $this->input->post('priority_mode', true);
        $type_of_project = $this->input->post('type_of_project', true);
        $request_title  = trim($this->input->post('request_title', true));
        $description    = trim($this->input->post('description', true));
        $proposed_activities = trim($this->input->post('proposed_activities', true));
        $important_usage = trim($this->input->post('important_usage', true));
        $consequence    = trim($this->input->post('consequence_of_inaction', true));
        $safety_concerns = trim($this->input->post('safety_concerns', true));
        $requested_by   = $this->input->post('requested_by', true);
        $checked_by   = $this->input->post('checked_by', true);
        $supplies = json_decode($this->input->post('supplies'), true); // force array



        // --- VALIDATION ---
        if (empty($request_no)) {
            $request_no = $this->Model_workorder->generate_request_no();
        }
        // request_no becomes a directory name below, so keep it to the generated format's characters
        if (!preg_match('/^[A-Za-z0-9-]{1,50}$/', $request_no)) $errors[] = "Invalid Request No.";
        if (empty($request_date) || !DateTime::createFromFormat('Y-m-d', $request_date)) $errors[] = "Request Date is required (YYYY-MM-DD).";
        if (empty($request_time)) $errors[] = "Request Time is required.";
        if (!in_array($priority_mode, ['Emergency', 'Normal'])) $errors[] = "Invalid Priority Mode.";
        if (empty($request_title) || strlen($request_title) > 200) $errors[] = "Request Title is required and max 200 chars.";
        if (strlen($description) > 1000) $errors[] = "Description cannot exceed 1000 chars.";
        if (strlen($proposed_activities) > 1000) $errors[] = "Proposed Activities cannot exceed 1000 chars.";
        if (strlen($important_usage) > 300) $errors[] = "Important Usage cannot exceed 300 chars.";
        if (strlen($consequence) > 500) $errors[] = "Consequence cannot exceed 500 chars.";
        if (strlen($safety_concerns) > 500) $errors[] = "Safety Concerns cannot exceed 500 chars.";

        if (!empty($type_of_project) && is_array($type_of_project)) {
            $type_of_project = serialize($type_of_project);
        } else {
            $errors[] = "Type of project is required.";
        }
        // Validate requested_by and checked_by exists in users table
        if (!$this->Model_users->user_exists($requested_by)) {
            $errors[] = "Invalid Requested By user.";
        }
        if (!$this->Model_users->user_exists($checked_by)) {
            $errors[] = "Invalid Checked By user.";
        }
        // echo json_encode($supplies);
        // Validate supplies and stock
        if (!empty($supplies)) {
            foreach ($supplies as $index => $item) {
                $itemId = isset($item['item_id']) ? $item['item_id'] : null;
                $quantity = isset($item['quantity']) ? (int) $item['quantity'] : null;

                if (!$itemId || $quantity === null) {
                    $errors[] = "Missing data for supply #{$index}.";
                    continue;
                }

                $product = $this->Model_products->get_product_by_id($itemId);

                if (!$product) {
                    $errors[] = "Invalid product ID: {$itemId}";
                } elseif ($quantity > $product->qty) {
                    $errors[] = "Insufficient stock for {$product->name}. Requested: {$quantity}, Available: {$product->qty}";
                }
            }
        }


        // echo json_encode($errors);

        // Validate attachments 
        $uploaded_files = [];
        $accepted = [];
        if (!empty($_FILES['attachments']['name'][0])) {
            if (count($_FILES['attachments']['name']) > 5) {
                $errors[] = "Maximum 5 attachments allowed.";
            } else {
                // trust neither the client MIME type nor the name: check extension AND real image content
                $image_types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png'];
                for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
                    if ($_FILES['attachments']['error'][$i] != 0) continue;
                    $ext = strtolower(pathinfo($_FILES['attachments']['name'][$i], PATHINFO_EXTENSION));
                    $info = @getimagesize($_FILES['attachments']['tmp_name'][$i]);
                    if (!in_array($ext, ['jpg', 'jpeg', 'png']) || !$info || !isset($image_types[$info[2]])) {
                        $errors[] = "Invalid file type for attachment #" . ($i + 1) . " (JPG or PNG only).";
                        continue;
                    }
                    $accepted[$i] = $image_types[$info[2]];
                }
            }
        }

        // move files only once everything is valid, so rejected requests leave nothing behind
        if (empty($errors) && $accepted) {
            $relative_dir = "uploads/work_orders/{$request_no}/";
            if (!is_dir(FCPATH . $relative_dir)) mkdir(FCPATH . $relative_dir, 0755, true);
            foreach ($accepted as $i => $ext) {
                $filename = time() . "_{$i}." . $ext;
                if (move_uploaded_file($_FILES['attachments']['tmp_name'][$i], FCPATH . $relative_dir . $filename)) {
                    $uploaded_files[] = $relative_dir . $filename;
                } else {
                    $errors[] = "Failed to upload attachment #" . ($i + 1);
                }
            }
        }

        // If errors exist, redirect back with errors
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }

        $signatures = json_encode([
            'checker' => false,
            'endorser' => false,
            'receiver' => false,
            'approver' => false
        ]);
        // --- INSERT INTO DB ---
        $data = [
            'request_no'        => $request_no,
            'request_date'      => $request_date,
            'request_time'      => $request_time,
            'priority_mode'     => $priority_mode,
            'type_of_project'   => $type_of_project,
            'request_title'     => $request_title,
            'description'       => $description,
            'proposed_activities' => $proposed_activities,
            'important_usage'   => $important_usage,
            'consequence_of_inaction' => $consequence,
            'safety_concerns'   => $safety_concerns,
            'signatures'        => $signatures,
            'requested_by'      => $requested_by,
            'checked_by'        => $checked_by,
            'attachments'       => json_encode($uploaded_files),
            'status'            => 'Pending'
        ];

        $work_order_id = $this->Model_workorder->insert($data);

        if ($work_order_id) {
            // Creating Log
            $user_name = $this->session->userdata('email');

            if ($user_name) {
                $log_data = [
                    'user_name'    => $user_name,
                    'action_type'  => 'Create',
                    'description'  => "Create Work Request: [{$work_order_id}]"
                    // log_time auto-filled
                ];

                $log_id = $this->model_activitylog->create_log($log_data);

                if ($log_id) {
                    log_message('info', "Added log: Create User. ID: {$log_id}");
                } else {
                    log_message('error', "Failed to Add Log: Create User for user: {$user_name}");
                }
            }
        }
        // Insert supplies if any
        if (!empty($supplies)) {
            foreach ($supplies as $item) {
                $this->Model_workorder->insert_supply($work_order_id, $item['item_id'], $item['quantity']);
                // $this->Model_products->reduce_stock($item['item_id'], $item['quantity']);
                // do not reduce yet since its still pending
            }
        }

        // $this->session->set_flashdata('success', 'Work Order created successfully.');
        // redirect('work_order/index');
        echo json_encode([
            'success' => true
        ]);
        return;
    }


    public function edit($workorder_id = null)
    {
        if (!in_array('updateWorkOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $work_order = $this->Model_workorder->get_workOrder_byId($workorder_id);

        if (empty($work_order)) {
            show_error("Work order not found", 404);
        }

        $userFields = [
            'requested_by' => 'requestor',
            'checked_by' => 'checker',
            'endorsed_by' => 'endorser',
            'received_by' => 'receiver',
            'shift_supervisor_before' => 'supervisor',
            'shift_supervisor_after' => 'supervisor',
            'approved_by' => 'approver'
        ];

        $permissions = ['requestor', 'checker', 'endorser', 'receiver', 'supervisor', 'approver'];
        $sign_need = 0;

        foreach ($userFields as $field => $role) {
            $userId = isset($work_order[$field]) ? $work_order[$field] : null;

            if (is_numeric($userId) && $this->Model_users->user_exists($userId)) {
                $userData = $this->Model_users->getUserData($userId);

                $work_order[$field] = [
                    'id'        => $userData['id'],
                    'firstname' => $userData['firstname'],
                    'lastname'  => $userData['lastname']
                ];
            } else {
                if (in_array($role, $permissions)) {
                    $work_order[$field] = true;
                    $sign_need++;
                } else {
                    $work_order[$field] = null;
                }
            }
        }

        $status = $work_order['status'];
        $statusToStage = [
            'Pending'     => 2,
            'In Progress' => 3,
            'Completed'   => 4,
            'Closed'      => 5
        ];


        $work_order['current_stage'] = $statusToStage[$status] ?? 1; // Default to stage 1 if status is unknown
        // fetch users
        $work_order['list_of_performers'] = $this->Model_users->get_all_users();

        $work_order['sign_need'] = $sign_need;
        // echo "<pre>";
        // print_r($work_order['list_of_performers']);
        // echo "</pre>";

        $this->render_template('work_order/edit', $work_order);
    }
}
