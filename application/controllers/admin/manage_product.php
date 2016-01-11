<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manage_product extends CI_Controller {

    public $page = 'manage_product';
    protected $validate_product_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    public function __construct() {

        parent::__construct();

        $this->load->helper('url');
        $this->load->model(array('admin/productModel', 'commonmodel'));
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->helper('string');
        $this->data = "";
        $this->page = 'manage_product';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    /**
     * This is the default function of a controller
     */
    public function index() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $products = $this->productModel->getAllproduct();

        $data['products'] = $products;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $data['content'] = $this->load->view('admin/product/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function add() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;

        $data['page'] = $this->page;
        /**
         * User: Muhammad Noman Rauf
         * Date: 12/30/2015
         * Time: 1:26 AM
         * Rest api call to get products
         */

        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        $time_start = microtime(true);

        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,'http://staging3.karmora.com/magento/api/rest/products');
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $products = curl_exec($curl_handle);
        curl_close($curl_handle);
        if (empty($products)){
            print "Nothing returned from url.<p>";
        }
        else{
            $allProduct = json_decode($products);
            foreach($allProduct as $product){
                $product_magento_id = $product->entity_id;
                $product_name = $product->name;
                $product_sku = $product->sku;
                $product_description = $product->description;
                $product_short_description = $product->short_description;
                $product_price = $product->final_price_without_tax;
                $product_image = $product->image_url;
                $product_creation_date_time = date('Y-m-d H:m:i');
                $product_updation_date_time = date('Y-m-d H:m:i');
                $product_info = array(
                    'product_title' => $product_name,
                    'fk_magento_id' => $product_magento_id,
                    'product_sku'    => $product_sku,
                    'product_price'=> $product_price,
                    'product_description'    => $product_description,
                    'product_short_description'    => $product_short_description,
                    'product_image'=>$product_image
                );
                $product_exist = $this->commonmodel->isProductAlreadyExist('fk_magento_id',$product_magento_id,'tbl_products');
                if($product_exist){
                    $product_info['product_id'] = $product_magento_id;
                    $product_info['product_updation_date_time'] = $product_updation_date_time;
                    $resultVal = $this->productModel->update($product_info);
                }else{
                    $product_info['product_updation_date_time'] = $product_updation_date_time;
                    $product_info['product_creation_date_time'] = $product_creation_date_time;
                    $resultVal = $this->productModel->add($product_info);
                }
            }
        }

        redirect(base_url('admin/product'));
        $time_end = microtime(true);

        //dividing with 60 will give the execution time in minutes other wise seconds
        $execution_time = ($time_end - $time_start)/60;

        //execution time of the script
        echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';

        //$data['content'] = $this->load->view('admin/product/add', $data, TRUE);
        //$this->load->view('admin/template', $data);
    }

    /*
     * View Product function is used to view all details
     * @param int $pk_product_id
     * return std object $product_detail
     */
    public function details($pk_product_id){
        $id =  $pk_product_id;
        if($id!=''){

            $data['product_detail'] = $this->productModel->getEditproduct($id);
            if(isset($_POST['submit'])){
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $proxy = new SoapClient('http://staging3.karmora.com/magento/api/v2_soap/?wsdl');

                $sessionId = $proxy->login('karmora', 'karmoraguniev555F');

                $result = $proxy->catalogProductCustomOptionAdd(
                    $sessionId,
                    $data['product_detail']->fk_magento_id,
                    array('title' => 'Level 1',
                        'type' => 'field',
                        'sort_order' => '1',
                        'is_require' => 1,
                        'additional_fields' => array(
                            array(
                                'price' => '15',
                                'price_type' => 'fixed',
                                'sku' => ''
                            )
                        )
                    )
                );
                echo "<pre>";
                print_r($result);
                die;
            }
            $data['page'] = $this->page;
            $data['header'] = $this->header;
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $data['footer'] = $this->footer;
            $data['content'] = $this->load->view('admin/product/view', $data, TRUE);
            $this->load->view('admin/template', $data);
        }else{
            redirect(base_url('admin/product'));
        }
    }

    // edit
    public function edit($pk_product_id) {
        $data['controller'] = $this;

        $data['page'] = $this->page;
        $data['header'] = $this->load->view('admin/header', $this->data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $data['template'] = $this->load->view('admin/template', $this->data, TRUE);
        $data['footer']     = $this->load->view('admin/footer', $this->data, TRUE);
        $data['product_cat'] = $this->productModel->getProductCategories(); //die;
        $data['pk_product_id'] = $pk_product_id;
        $data['Edit_product_ca']   = $this->productModel->getEditProductCategories($pk_product_id);
        $row = $this->productModel->getEditproduct($pk_product_id); //die;
        if (empty($row)) {

            show_404();
        }

        $data['product_title'] = $row->product_title;
        $data['product_image'] = $row->product_image;
        $data['product_is_fetured'] = $row->product_is_fetured;
        $data['product_price'] = $row->product_price;
        $data['product_detail'] = $row->product_detail;
        $data['product_short_description'] = $row->product_short_description;
        $data['product_meta_tag'] = $row->product_meta_tag;
        $data['product_meta_description'] = $row->product_meta_description;
        $data['product_how_to_use'] = $row->product_how_to_use;
        $data['product_ingredients'] = $row->product_ingredients;


        $this->validate_product_id = $pk_product_id;

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('product_title', 'Product Title', 'required');
            $this->form_validation->set_rules('product_price', 'Product Price', 'required');
            $this->form_validation->set_rules('product_short_description', 'Product Short Detail', 'required');
            $this->form_validation->set_rules('product_detail', 'Product Detail', 'required');
            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {

            } else { // no errors now to save the data
                $product_title = $this->input->post('product_title');
                $product_is_fetured = $this->input->post('product_is_fetured');
                $product_price = $this->input->post('product_price');
                $product_detail = $this->input->post('product_detail');
                $product_short_description = $this->input->post('product_short_description');
                $product_meta_tag = $this->input->post('product_meta_tag');
                $product_meta_description = $this->input->post('product_meta_description');
                $product_how_to_use = $this->input->post('product_how_to_use');
                $product_ingredients = $this->input->post('product_ingredients');


                $alias = strtolower($product_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '-', $alias);

                $datas = array(
                    'product_title' => $product_title,
                    'product_alias' => $alias,
                    'product_is_fetured' => $product_is_fetured,
                    'product_price' => $product_price,
                    'product_detail' => $product_detail,
                    'product_how_to_use' => $product_how_to_use,
                    'product_ingredients' => $product_ingredients,
                    'product_short_description' => $product_short_description,
                    'product_meta_tag' => $product_meta_tag,
                    'product_meta_description' => $product_meta_description,
                    'product_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->where('pk_product_id', $pk_product_id);
                $this->db->update('tbl_product', $datas);

                //echo  $this->db->last_query(); die;
                $data['successmessage'] = 'Product Updated Sucefully';
            }
        }
        //$data['page'] = $this->page;

        $this->load->view('admin/product/edit', $data);
    }

    public function album($pk_product_id) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        $row = $this->productModel->getEditproduct($pk_product_id); //die;

        $data['product_title'] = $row->product_title;
        $data['pk_product_id'] = $pk_product_id;
        $data['product_image'] = $row->product_image;
        $data['product_is_fetured'] = $row->product_is_fetured;
        $data['product_price'] = $row->product_price;
        $data['product_sku'] = $row->product_sku;
        $data['product_detail'] = $row->product_detail;
        $data['product_short_description'] = $row->product_short_description;
        $data['product_create_date'] = $row->product_create_date;
        $data['product_status'] = $row->product_status;

        if (isset($_POST['submit'])) {
            $error = array();
            $extension = array("jpeg", "jpg", "png", "gif");
            foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
                $random_number = rand();
                $file_name = $_FILES["files"]["name"][$key];
                $file_tmp = $_FILES["files"]["tmp_name"][$key];
                $ext = substr($file_name, strrpos($file_name, '.') + 1);
                $picname = $pk_product_id . "_album_" . $random_number . '.' . $ext;
                $upload_path = './public/images/product/' . $pk_product_id . '/album/';
                if (!file_exists($upload_path)) {
                    @mkdir($upload_path, 755);
                }
                $pic_data = $pk_product_id . "/album/" . $picname;

                if (in_array($ext, $extension)) {

                    move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], $upload_path . $picname);
                    $data = array(
                        'fk_product_id' => $pk_product_id,
                        'product_album_image' => $pic_data,
                        'product_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_product_album', $data);
                } else {
                    array_push($error, "$file_name, ");
                }
            }
            redirect('admin/product/album/' . $pk_product_id);
        }

        $data['content'] = $this->load->view('admin/product/addalbum', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function delete($pk_product_id = '', $image = '') {

        if ($pk_product_id == '') {
            show_404();
        }

        unlink(FCPATH . 'public/images/product/'.$pk_product_id.'/product_no_' . $image);
        $this->db->where('pk_product_id', $pk_product_id);
        $this->db->delete('tbl_product');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Product Deleted Successfully</div>');
        redirect(base_url('admin/product/index/'));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($pk_product_id = '', $current_status = '') {
        if ($pk_product_id == '' || $current_status == '') {
            show_404();
        }
        $status = '1';
        if ($current_status == 'Active') {
            $status = '0';
        }
        $data = array('product_status' => $status);
        $this->db->where('pk_product_id', $pk_product_id);
        $this->db->update('tbl_product', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Product Status Changed Successfully</div>');
        redirect(base_url('admin/product/index/'));
    }

    public function in_array_r($needle, $haystack) {
        $found = false;
        if(!empty($haystack)){
            foreach ($haystack as $item) {
                if ($item === $needle) {
                    $found = true;
                    break;
                } elseif (is_array($item)) {
                    unset($item['pk_relation_with_user_account_type_id']);
                    unset($item['fk_table_name_id']);
                    $found = $this->in_array_r($needle, $item);
                    if ($found) {
                        break;
                    }
                }
            }
        }
        return $found;

    }

}