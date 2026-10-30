<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jobOrder extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    // In JobOrder_model.php
    public function getPrioritizedJobOrders($limit, $offset)
    {
        $sql = "
        SELECT * 
        FROM job_order 
        ORDER BY 
            FIELD(status, 'Pending', 'Approved', 'Rejected'), 
            created DESC 
        LIMIT ? OFFSET ?
    ";

        $query = $this->db->query($sql, array($limit, $offset));
        return $query->result_array();
    }

    public function countJobOrders()
    {
        return $this->db->count_all('job_order');
    }
}
