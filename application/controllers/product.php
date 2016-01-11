<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class product extends karmora {

    
    public $data ;
    public $page = 'product';
    
    public function __construct() {

        parent::__construct();
       	
        $this->data['themeUrl'] = $this->themeUrl;
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('productmodel');
        $this->load->model('commonmodel');
        
        
    }

    public function index() {
            
            $data                  =  '';
            $data['products']      = $this->productmodel->getproducts();
            $this->loadLayout($data,'frontend/product/product_content');
            
    }
    
    public function product_detail($pk_product_id) {
            
            $data           =  '';
            
            $data['product_detail']      = $this->productmodel->getproductdetail($pk_product_id);
            if(empty($data['product_detail'])){
                redirect(base_url());
            }
            $this->loadLayout($data,'frontend/product/detail');
            
    }
    

  
    
   
}

/* Location: ./application/controllers/product.php */