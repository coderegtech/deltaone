<?php
class Model_workorder extends CI_Model
{

    public function insert($data)
    {
        $this->db->insert('work_order', $data);
        return $this->db->insert_id();
    }

    public function insert_supply($work_order_id, $item_id, $quantity)
    {
        $this->db->insert('work_order_supplies', [
            'work_order_id' => $work_order_id,
            'product_id' => $item_id,
            'quantity' => $quantity
        ]);
    }


    public function generate_request_no()
    {
        $date = date('Ymd');

        $this->db->trans_start();

        $row = $this->db->get_where('request_sequence', ['date' => $date])->row();

        $seq = $row ? $row->last_seq + 1 : 1;

        $this->db->replace('request_sequence', ['date' => $date, 'last_seq' => $seq]);

        $this->db->trans_complete();

        return 'OPS-' . $date . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function get_summary()
    {
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('work_order');
        $this->db->group_by('status');
        $query = $this->db->get();

        // Default Stats
        $stats = [
            'total'       => 0,
            'in progress' => 0,
            'pending'     => 0,
            'completed'   => 0,
            'closed'      => 0,
        ];

        foreach ($query->result() as $row) {
            $status = strtolower($row->status);
            if (isset($stats[$status])) {
                $stats[$status] = (int) $row->count;
            }
            $stats['total'] += (int) $row->count;
        }

        return $stats;
    }
    public function statusBased_workOrder($status)
    {
        if (empty($status)) {
            return [];
        }

        $this->db->select('*');
        $this->db->from('work_order');
        $this->db->where('status', $status);
        $this->db->order_by('request_date', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Get All Work Orders ordered by:
     * 1. status rank: in_progress > pending > completed > closed
     * 2. priority_mode rank: Emergency > Normal
     * 3. newest request_date first
     */
    public function get_all_work_orders()
    {
        $status_order = "FIELD(status, 'Pending','In Progress',  'Completed', 'Closed')";
        $priority_order = "FIELD(priority_mode, 'Emergency', 'Normal')";

        $this->db->from('work_order');
        $this->db->order_by($status_order, '', false);
        $this->db->order_by($priority_order, '', false);
        $this->db->order_by('request_date', 'DESC');
        $this->db->order_by('request_time', 'DESC');

        return $this->db->get()->result();
    }


    public function get_user_data($ids = [])
    {
        if (empty($ids)) {
            return [];
        }

        // Ensure IDs are unique and valid integers
        $ids = array_filter(array_map('intval', $ids));
        if (empty($ids)) {
            return [];
        }

        $this->db->select('id, firstname, lastname');
        $this->db->from('users');
        $this->db->where_in('id', $ids);
        $query = $this->db->get();

        $result = $query->result_array();

        // Map users by ID for easier reference
        $users = [];
        foreach ($result as $row) {
            $users[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
        }

        return $users;
    }
    public function get_workOrder_byId($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return [];
        }

        $this->db->select('*');
        $this->db->from('work_order');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row_array(); // returns a single row as associative array
    }
}
