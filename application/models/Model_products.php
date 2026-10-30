<?php

class Model_products extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fetch product data by ID or all products if no ID is provided
    public function getProductData($id = null)
    {
        if ($id) {
            $sql = "SELECT products.*, categories.name as category_name 
                    FROM products 
                    LEFT JOIN categories ON categories.id = products.category_id 
                    WHERE products.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT products.*, categories.name as category_name 
                FROM products 
                LEFT JOIN categories ON categories.id = products.category_id 
                ORDER BY products.id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // Fetch only active products
    public function getActiveProductData()
    {
        $sql = "SELECT * FROM products WHERE availability = ? ORDER BY id DESC";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    // Insert new product
    public function create($data)
    {
        if ($data) {
            $insert = $this->db->insert('products', $data);
            return ($insert == true) ? true : false;
        }
    }

    // Update product by ID
    public function update($data, $id)
    {
        if ($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('products', $data);
            return ($update == true) ? true : false;
        }
    }

    // Remove a product by ID
    public function remove($id)
    {
        if (empty($id)) {
            return false; // Return false if no product ID is provided
        }

        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    // Count total products in the database
    public function countTotalProducts()
    {
        $sql = "SELECT * FROM products";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    // Fetch low quantity products
    public function getLowQuantityProducts()
    {
        $this->db->where('CAST(qty AS UNSIGNED) <= CAST(low_quantity AS UNSIGNED)');
        $query = $this->db->get('products');
        return $query->result_array();
    }


    // Count low quantity products
    public function countLowQuantityProducts()
    {
        $this->db->where('CAST(qty AS UNSIGNED) <= CAST(low_quantity AS UNSIGNED)');
        $query = $this->db->get('products');
        return $query->num_rows();
    }


    // Fetch high quantity products
    public function getHighQuantityProducts()
    {
        $this->db->where('high_quantity > 0 AND CAST(qty AS UNSIGNED) > high_quantity'); // 0 = no upper limit set
        $query = $this->db->get('products');
        return $query->result_array();
    }

    // Count high quantity products
    public function countHighQuantityProducts()
    {
        $this->db->where('high_quantity > 0 AND CAST(qty AS UNSIGNED) > high_quantity'); // 0 = no upper limit set
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    public function get_products_forWorkOrder()
    {
        $this->db->select('id, name, sku, quantity, store_id');
        $this->db->from('products');
        $query = $this->db->get();
        return $query->result_array(); // returns array of ARRAYS
    }

    public function get_product_by_id($id)
    {
        return $this->db->where('id', $id)->get('products')->row();
    }

    public function reduce_stock($id, $qty)
    {
        $this->db->set('qty', 'qty - ' . (int)$qty, false)
            ->where('id', $id)
            ->update('products');
    }


    public function getActiveProductData2()
    {
        $sql = "SELECT * FROM products WHERE availability = ? ORDER BY id DESC";
        $query = $this->db->query($sql, array(1));
        $products = $query->result_array();

        $filteredProducts = [];

        foreach ($products as $product) {
            if ((int)$product['qty'] < 1) {
                continue; // Skip products with qty less than 1
            }

            if (!empty($product['store_id'])) {
                $storeSql = "SELECT name FROM stores WHERE id = ?";
                $storeQuery = $this->db->query($storeSql, array($product['store_id']));
                $storeResult = $storeQuery->row_array();

                $product['store'] = $storeResult['name'] ?? null;
                unset($product['store_id']);
            }

            $filteredProducts[] = $product;
        }

        return $filteredProducts;
    }
}
