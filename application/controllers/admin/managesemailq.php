<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manageusers
 *
 * @author WAQAS
 */
class managesemailq extends karmora {

    public $page = 'managesemailq';
    private $header;
    private $content;
    private $sidebar;
    private $footer;
    private $template;
    public $data;

    function __construct() {
        parent::__construct();
        $this->data = "";
        $this->load->library('form_validation');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model('admin/emailqmodel');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
    
    /**
     * This is  function of a seraching 
     */
    
    public function index() {
        
         
         if(isset($_POST['delete'])){
             $post_arrayA = $_POST['delete_email'];
             if(!empty($post_arrayA)){
                 foreach ($post_arrayA as $deletAr){
                     $this->db->where('pk_email_queue_id', $deletAr);
                     $this->db->delete('tbl_email_queue');
                 }
            }
         }
         $data['page']   = $this->page;
         $data['header'] = $this->header;
         $data['footer'] = $this->footer;
         $data['content'] = $this->load->view('admin/emailq/grid', $data, TRUE);
         $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
         $this->load->view('admin/template', $data);
        
    }
    
    
    public function getemailq() {
        //echo 123; die;
        $data =array();
         
         $data['data']  = $this->emailqmodel->getAllEmailq();
         
         //$data['data']  =  $sales;
         echo json_encode($data); die;
        
        
    }
    
    // function to show user details
    
    public function getsaleDetail($sale_id) {
        $data['page']   = $this->page;
        
        $cob_detail     = $this->salesmodel->getSaleCobDetail($sale_id);
        if(!empty($cob_detail)){
            $data['cob_amount']             = $cob_amount = $cob_detail->cob_amount;
            $data['cob_status']             = $cob_status = $cob_detail->cob_status;
            $data['business_title']         = $business_title = $cob_detail->business_title;
            $data['user_username']          = $user_username = $cob_detail->user_username;
            $data['sales_transection_id']   = $sales_transection_id = $cob_detail->sales_transection_id;
            $data['sales_sale_amount']      = $sales_sale_amount = $cob_detail->sales_sale_amount;
            $data['sales_kash_back_percentage']     = $sales_kash_back_percentage = $cob_detail->sales_kash_back_percentage;
            $data['sales_total_amount']             = $sales_total_amount = $cob_detail->sales_total_amount;
            $data['sales_advertiser_name']          = $sales_advertiser_name = $cob_detail->sales_advertiser_name;
            $data['sales_processing_status']        = $sales_processing_status = $cob_detail->sales_processing_status;
            $data['sales_cashback_payment_status']  = $sales_cashback_payment_status = $cob_detail->sales_cashback_payment_status;
            $data['sales_payment_type']             = $sales_payment_type = $cob_detail->sales_payment_type;
            $data['sales_create_date']              = $sales_create_date = $cob_detail->sales_create_date;
            
        }
        
        $Sale_type_array   = $this->$sales_payment_type($sale_id);
        $data['Sale_type'] = $Sale_type_array;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['content'] = $this->load->view('admin/sales/detail', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
        
        
    }

   
}
