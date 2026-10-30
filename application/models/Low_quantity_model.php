<?php
// File: application/models/Low_quantity_model.php

class Low_quantity_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Define the method get_low_quantity_count() here
    public function get_low_quantity_count()
    {
        // Example query to get count of low quantity products
        $this->db->where('qty <= low_quantity');
        $this->db->from('products');
        return $this->db->count_all_results();
    }
}
