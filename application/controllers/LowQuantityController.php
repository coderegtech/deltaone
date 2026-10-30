<?php
class LowIndex extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('modal_products');
    }

    public function index()
    {
        // Load the view to display low quantity products
        $this->render_template('lowindex', []);
    }

    public function fetchLowProductData()
    {
        // Fetch all low quantity products from the model
        $result = array('data' => array());

        $data = $this->modal_products->getLowQuantityProducts(); // Modify this method in your Products_model

        foreach ($data as $product) {
            $availability = ($product['qty'] <= 0) ? '<span class="label label-danger">Out of stock</span>' : '<span class="label label-success">In stock</span>';

            $buttons = '
            <a href="' . base_url('products/edit/' . $product['id']) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm remove-btn" data-id="' . $product['id'] . '"><i class="fa fa-trash"></i></button>
            ';

            $result['data'][] = array(
                '<img src="' . base_url($product['image']) . '" class="img-thumbnail" width="50" height="50">',
                $product['name'],
                $product['item_number'],
                $product['cost'],
                $product['qty'],
                isset($product['store']) ? $product['store'] : 'N/A',
                $availability,
                $buttons
            );
        }

        echo json_encode($result);
    }
}
