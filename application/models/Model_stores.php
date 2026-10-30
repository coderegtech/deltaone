<?php 

class Model_stores extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get the active store data */
    public function getActiveStore()
    {
        $sql = "SELECT * FROM `stores` WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    /* Get all stores */
    public function getStores()
    {
        $this->db->select('*');
        $this->db->from('stores'); // Adjust the table name as per your database schema
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return result as an array
        } else {
            return []; // Return an empty array if no records found
        }
    }

    /* Get store data by ID */
    public function getStoresData($id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM `stores` WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM `stores`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data)
    {
        if ($data) {
            $insert = $this->db->insert('stores', $data);
            return ($insert == true) ? true : false;
        }
    }

    public function update($data, $id)
    {
        if ($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('stores', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('stores');
            return ($delete == true) ? true : false;
        }
    }

    public function countTotalStores()
    {
        $sql = "SELECT * FROM `stores` WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}
