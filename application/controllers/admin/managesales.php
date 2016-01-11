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
class managesales extends karmora {

    public $page = 'managesales';
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
        $this->load->model('admin/salesmodel');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
    
    /**
     * This is  function of a seraching 
     */
    public function getSearchString($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['search_me']) && ($_POST['search_me']!='')) {
            $search_string = $_POST['search'];
            $sales = $this->salesmodel->searchSales($page, $limit, $search_string);
            $data['sales'] = $sales;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managesales/index');
        $data['paging'] = paging_generate($this->salesmodel->getCountSerchSales($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/sales/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        }else{
                redirect(base_url('admin/managesales/index'));
	    }
    }
    
    public function index() {
        
         $data['page']   = $this->page;
         $data['header'] = $this->header;
         $data['footer'] = $this->footer;
        $data['content'] = $this->load->view('admin/sales/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
    }
    
    
    public function getsales() {
        //echo 123; die;
        $data =array();
         
         $data['data']  = $this->salesmodel->getAllSales();
         
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
    
    public function cashback($sale_id) {
      
        $data['cashbacksales'] = $this->salesmodel->getcahbackSales($sale_id);
        
        return $data['cashbacksales'];
    }
    
    public function treasurehunt($sale_id) {
      
        //$data['cashbacksales'] = $this->salesmodel->getcahbackSales($sale_id);
        //echo 123; die;
        return $sale_id; 
    }
    
    public function downloadData() {
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['content'] = $this->load->view('admin/sales/downloadcsv', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
       
    }
    public function downloadcsv() {
        
        $start_date  = $_POST['start_date'] ; 
        $end_date    = $_POST['end_date'] ;
        if ($start_date != '') {
                    $start_date = date('Y-m-d', strtotime($start_date));
                }
        
        if ($end_date != '') {
                   $end_date = date('Y-m-d', strtotime($end_date));
                }
        $row = $this->salesmodel->getCsvSales($start_date,$end_date);        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        
        // output the column headings
        fputcsv($output, array('Sale Id', 'Tracking Id', 'Transection Id',  'Sale Amount','kash Back Percentage','Total Amount','Advertiser Name','Affiliate Network Id','SalesCreateDate','Processing Status','Cashback Payment Status','Payment Type','Username'));
        if(!empty($row)){
            foreach ($row as $da){
               /* 
                $familyCount = $this->usermodel->getUserfamilyMember($da['user_id']);
                if(!empty($familyCount)){
                $familyCountB = $familyCount->male_counter;
                $familyCountG = $familyCount->female_counter;
                }else{
                $familyCountB = 0;
                $familyCountG = 0;  
                }
                
                array_push($da,$familyCountB,$familyCountG); */
                 //echo '<pre>';print_r($da); die;
                fputcsv($output, $da);
            }
        }else{
            'No Record Found';
        }
        exit;
    }
     
   
}
