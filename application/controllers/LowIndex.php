<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LowIndex extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in(); // Ensure the user is logged in

        $this->data['page_title'] = 'Low Quantity Products';

        // Load the model
        $this->load->model('model_products');
    }

    public function index()
    {
        // Fetch low quantity products
        $this->data['low_quantity_products'] = $this->model_products->getLowQuantityProducts();

        // Render the view
        $this->render_template('lowindex', $this->data);
    }
}
