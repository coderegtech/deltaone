<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Products';

        $this->load->model('model_products');
        $this->load->model('model_brands');
        $this->load->model('model_category');
        $this->load->model('model_stores');
        $this->load->model('model_attributes');
        $this->load->model('model_activitylog');
    }

    public function index()
    {
        if (!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('products/index', $this->data);
    }

    public function fetchLowProduct()
    {
        $result = array('data' => array());

        $data = $this->model_products->getLowQuantityProducts();

        foreach ($data as $key => $value) {
            $store_data = $this->model_stores->getStoresData($value['store_id']);
            $buttons = '';


            $img = '<img src="' . html_escape(base_url($value['image'])) . '" alt="' . html_escape($value['name']) . '" class="img-circle" width="50" height="50" />';

            $availability = ($value['availability'] == 1)
                ? '<span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-100/80 rounded-full">Active</span>'
                : '<span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100/80 rounded-full">Inactive</span>';

            $qty_status = '';
            if ($value['high_quantity'] > 0 && $value['qty'] > $value['high_quantity']) {
                $qty_status = '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Over supply!</span>';
                $name_style = 'text-red-600';
            } else {
                $name_style = '';
            }

            $result['data'][$key] = array(
                $img,
                '<span class="' . $name_style . '">' . html_escape($value['name']) . '</span>',
                html_escape($value['sku']),
                $value['price'],
                $value['qty'] . ' ' . $qty_status,
                $store_data['name'],
                $availability,
                $buttons,
                $value['id']
            );
        }

        echo json_encode($result);
    }

    public function fetchHighProduct() {}

    public function fetchProductData()
    {
        $result = array('data' => array());

        $data = $this->model_products->getProductData();

        foreach ($data as $key => $value) {
            $store_data = $this->model_stores->getStoresData($value['store_id']);
            $buttons = '';


            $img = '<img src="' . html_escape(base_url($value['image'])) . '" alt="' . html_escape($value['name']) . '" class="img-circle" width="50" height="50" />';

            $availability = ($value['availability'] == 1)
                ? '<span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-100/80 rounded-full">Active</span>'
                : '<span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100/80 rounded-full">Inactive</span>';

            $qty_status = '';
            if ($value['qty'] <= 0) {
                $qty_status = '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Out of stock!</span>';
                $name_style = 'text-red-600';
            } elseif ($value['qty'] <= $value['low_quantity']) {
                $qty_status = '<span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded">Low!</span>';
                $name_style = 'text-red-600';
            } elseif ($value['high_quantity'] > 0 && $value['qty'] > $value['high_quantity']) {
                $qty_status = '<span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Over supply!</span>';
                $name_style = 'text-red-600';
            } else {
                $name_style = '';
            }

            $result['data'][$key] = array(
                $img,
                '<span class="' . $name_style . '">' . html_escape($value['name']) . '</span>',
                html_escape($value['sku']),
                $value['price'],
                $value['qty'] . ' ' . $qty_status,
                $store_data['name'],
                $availability,
                $buttons,
                $value['id']
            );
        }

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('part_number', 'Part Number', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('low_quantity', 'Low Quantity', 'trim|required');
        $this->form_validation->set_rules('high_quantity', 'High Quantity', 'trim|required');
        $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $upload_image = $this->upload_image();

            $data = array(
                'name' => $this->input->post('product_name'),
                'part_number' => $this->input->post('part_number'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'image' => $upload_image,
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                'brand_id' => json_encode($this->input->post('brands')),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'low_quantity' => $this->input->post('low_quantity'),
                'high_quantity' => $this->input->post('high_quantity'),
            );

            $create = $this->model_products->create($data);
            if ($create == true) {

                // Creating Log
                $user_name = $this->session->userdata('email');

                if ($user_name) {
                    $log_data = [
                        'user_name'    => $user_name,
                        'action_type'  => 'Create',
                        'description'  => "Creating Product: [{$data['name']}]"
                        // log_time auto-filled
                    ];

                    $log_id = $this->model_activitylog->create_log($log_data);

                    if ($log_id) {
                        log_message('info', "Added log: Create Product. ID: {$log_id}");
                    } else {
                        log_message('error', "Failed to Add Log: Create Product for user: {$user_name}");
                    }
                }


                $this->session->set_flashdata('success', 'Successfully created');
                redirect('products/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/create', 'refresh');
            }
        } else {
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;

                $value = $this->model_attributes->getAttributeValueData($v['id']);

                $attributes_final_data[$k]['attribute_value'] = $value;
            }

            $this->data['attributes'] = $attributes_final_data;
            $this->data['brands'] = $this->model_brands->getActiveBrands();
            $this->data['category'] = $this->model_category->getActiveCategroy();
            $this->data['stores'] = $this->model_stores->getActiveStore();

            $this->render_template('products/create', $this->data);
        }
    }

    public function upload_image()
    {
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] = uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('product_image')) {
            $error = $this->upload->display_errors();
            $path = 'box.png'; // Path to your default image
            return $path;
        } else {
            $data = array('upload_data' => $this->upload->data());
            $type = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            $path = $config['upload_path'] . '/' . $config['file_name'] . '.' . $type;
            return $path;
        }
    }

    public function update2($product_id)
    {
        if (!in_array('updateProduct2', $this->permission)) {
            redirect('edit2', 'refresh');
        }

        if (!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('part_number', 'Part Number', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('low_quantity', 'Low Quantity', 'trim|required');
        $this->form_validation->set_rules('high_quantity', 'High Quantity', 'trim|required');
        $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('product_name'),
                'part_number' => $this->input->post('part_number'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                'brand_id' => json_encode($this->input->post('brands')),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'low_quantity' => $this->input->post('low_quantity'),
                'high_quantity' => $this->input->post('high_quantity'),
            );

            if ($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);

                $this->model_products->update($upload_image, $product_id);
            }

            $update = $this->model_products->update($data, $product_id);
            if ($update == true) {



                // Creating Log
                $user_name = $this->session->userdata('email');

                if ($user_name) {
                    $log_data = [
                        'user_name'    => $user_name,
                        'action_type'  => 'Update',
                        'description'  => "Update Product: [{$product_id}]"
                        // log_time auto-filled
                    ];

                    $log_id = $this->model_activitylog->create_log($log_data);

                    if ($log_id) {
                        log_message('info', "Added log: Update Products. ID: {$log_id}");
                    } else {
                        log_message('error', "Failed to Add Log: Update Products for user: {$user_name}");
                    }
                }


                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/' . $product_id, 'refresh');
            }
        } else {
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;

                $value = $this->model_attributes->getAttributeValueData($v['id']);

                $attributes_final_data[$k]['attribute_value'] = $value;
            }

            $this->data['attributes'] = $attributes_final_data;
            $this->data['brands'] = $this->model_brands->getActiveBrands();
            $this->data['category'] = $this->model_category->getActiveCategroy();
            $this->data['stores'] = $this->model_stores->getActiveStore();

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit2', $this->data);
        }
    }

    public function update($product_id)
    {
        if (!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('part_number', 'Part Number', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('low_quantity', 'Low Quantity', 'trim|required');
        $this->form_validation->set_rules('high_quantity', 'High Quantity', 'trim|required');
        $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('product_name'),
                'part_number' => $this->input->post('part_number'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                'brand_id' => json_encode($this->input->post('brands')),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'low_quantity' => $this->input->post('low_quantity'),
                'high_quantity' => $this->input->post('high_quantity'),
            );

            if ($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);

                $this->model_products->update($upload_image, $product_id);
            }

            $update = $this->model_products->update($data, $product_id);
            if ($update == true) {




                // Creating Log
                $user_name = $this->session->userdata('email');

                if ($user_name) {
                    $log_data = [
                        'user_name'    => $user_name,
                        'action_type'  => 'Update',
                        'description'  => "Update Product: [{$product_id}]"
                        // log_time auto-filled
                    ];

                    $log_id = $this->model_activitylog->create_log($log_data);

                    if ($log_id) {
                        log_message('info', "Added log: Update Products. ID: {$log_id}");
                    } else {
                        log_message('error', "Failed to Add Log: Update Products for user: {$user_name}");
                    }
                }



                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/' . $product_id, 'refresh');
            }
        } else {
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;

                $value = $this->model_attributes->getAttributeValueData($v['id']);

                $attributes_final_data[$k]['attribute_value'] = $value;
            }

            $this->data['attributes'] = $attributes_final_data;
            $this->data['brands'] = $this->model_brands->getActiveBrands();
            $this->data['category'] = $this->model_category->getActiveCategroy();
            $this->data['stores'] = $this->model_stores->getActiveStore();

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data);
        }
    }

    public function remove()
    {
        if (!in_array('deleteProduct', $this->permission)) {
            echo json_encode(['success' => false, 'messages' => "You don't have permission to delete products."]);
            return;
        }

        $product_id = $this->input->post('product_id');

        if (empty($product_id)) {
            echo json_encode(['success' => false, 'messages' => 'Product ID is required.']);
            return;
        }

        // Call the model method to delete the product
        $result = $this->model_products->remove($product_id);

        if ($result) {



            // Creating Log
            $user_name = $this->session->userdata('email');

            if ($user_name) {
                $log_data = [
                    'user_name'    => $user_name,
                    'action_type'  => 'Delete',
                    'description'  => "Delete Product: [{$product_id}]"
                    // log_time auto-filled
                ];

                $log_id = $this->model_activitylog->create_log($log_data);

                if ($log_id) {
                    log_message('info', "Added log: Delete Products. ID: {$log_id}");
                } else {
                    log_message('error', "Failed to Add Log: Delete Products for user: {$user_name}");
                }
            }


            echo json_encode(['success' => true, 'messages' => 'Product deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'messages' => 'Failed to delete the product.']);
        }
    }
}
