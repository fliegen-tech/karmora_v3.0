<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of managecoupons
 *
 * @author WAQAS
 */
class managecoupons extends karmora {

    public $page = 'managecoupons';
    private $header;
    private $content;
    private $sidebar;
    private $footer;
    private $template;
    public $data;

    function __construct() {
        parent::__construct();
        $this->data = "";
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model('admin/coupansmodel');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
     public function allCoupons($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $this->load->model('admin/coupansmodel');
        $coupons = $this->coupansmodel->getAllcoupons($page, $limit);
        $data['coupons'] = $coupons;
        //echo "<pre>";
       // print_r($coupons);
       // exit;
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managecoupons/allCoupons');
        $data['paging'] = paging_generate($this->coupansmodel->getCountAllCoupons(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/coupons/grid_all', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }
    
    public function index($page = 1, $limit = 20) {
       
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $this->load->model('admin/coupansmodel');
        $coupons = $this->coupansmodel->getConflicted($page, $limit);
        $data['coupons'] = $coupons;
        
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managecoupons/index');
        $data['paging'] = paging_generate($this->coupansmodel->getCountCoupons(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/coupons/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }
    // MNR COde
     /*
     * linkShareCoupons function used to store coupons/deals (linkShare Network) info into database  
     */

    public function linkShareCoupons() {
        $this->load->library('simplexml');
        // xml url
        $xmlRaw = file_get_contents("http://couponfeed.linksynergy.com/coupon?token=142b402600b08d9b7aff97b085c165e678ef417528c6b262fb148c925441ae7f&network=1");

        //use the method to parse the data from xml
        $xmlData = $this->simplexml->xml_parse($xmlRaw);
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        if(!empty($xmlData)){
            for ($row = 0; $row < sizeof($xmlData['link']); $row++) {
                $title = $xmlData['link'][$row]['advertisername'];
                $description = $xmlData['link'][$row]['offerdescription'];
                $code = '';
                $begin = '';
                $expire = '';
                $fk_affiliate_network_id = 1;
                if (isset($xmlData['link'][$row]['couponcode'])) {
                    $code = $xmlData['link'][$row]['couponcode'];
                }
                if (isset($xmlData['link'][$row]['offerstartdate'])) {
                    $begin = $xmlData['link'][$row]['offerstartdate'];
                }
                if (isset($xmlData['link'][$row]['offerenddate'])) {
                    $expire = $xmlData['link'][$row]['offerenddate'];
                }
                $link = $xmlData['link'][$row]['clickurl'];

                if ($code === '' || $begin === '' || $expire === '') {

                    $couponData = array(
                        'title' => $title,
                        'description' => $description,
                        'code' => $code,
                        'begin' => $begin,
                        'expire' => $expire,
                        'link' => $link,
                        'resaon' => 'code',
                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                    );
                    //$queryConflictCoupon[]= '("'.$title.'","'.$description.'","'.$code.'","'.$begin.'","'.$expire.'","'.$link.'","code",'.$fk_affiliate_network_id.')'; 
                    $this->coupansmodel->addConflictCoupon($couponData);
                } else {
                    $store = $this->coupansmodel->checkStore($title);
                    if ($store) {
                        //echo date('Y-m-d H:i:s',strtotime($begin));die;
                        $couponData = array(
                            'title' => $title,
                            'description' => $description,
                            'code' => $code,
                            'begin' => $begin,
                            'expire' => $expire,
                            'link' => $link,
                            'fk_affiliate_network_id'=>$fk_affiliate_network_id
                        );
                        $result = $this->coupansmodel->addCoupan($couponData);
                        
                    } else {

                        $couponData = array(
                            'title' => $title,
                            'description' => $description,
                            'code' => $code,
                            'begin' => $begin,
                            'expire' => $expire,
                            'link' => $link,
                            'resaon' => 'title',
                            'fk_affiliate_network_id'=>$fk_affiliate_network_id
                        );
                        $this->coupansmodel->addConflictCoupon($couponData);
                    }
                }
            }
            $data['msg'] =  '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>';
            $this->session->flashdata('datafeed','<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>');
        }else{
             $data['msg'] = '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>';
            $this->session->flashdata('datafeed','<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>');
        }
        $data['content'] = $this->load->view('admin/coupons/import_view', $data, TRUE);
        $this->load->view('admin/template', $data);
        
    }

    /*     * ************************************ Link Share Coupon Insertion End************************************** */

    /*
     * papperJamCoupons function used to store coupons/deals (linkShare Network) info into database  
     */

    public function papperJamCoupons() {

        $this->load->library('RSSParser', array('url' => 'http://feeds.pepperjamnetwork.com/coupon/rss20/?affiliate_id=101746', 'life' => 2));
        $datas = $this->rssparser->getFeed();
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        if(!empty($datas)){
            
            for ($row = 0; $row <sizeof($datas); $row++) {


                $couponTitle = explode('-', $datas[$row]['title']);
                $title = $couponTitle[0];
                $description = $couponTitle[1];
                $link = $datas[$row]['link'];
                $code = '';
                $begin = '';
                $expire = '';
                $fk_affiliate_network_id = 3;
                preg_match("/(Code.*Expire:\s\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/", $datas[$row]['description'], $matches);
                $description_array = explode("<br/>", $matches[1]);

                if (!empty($description_array)) {
                    // coupon code
                    $code_array = explode(":", $description_array[0]);
                    if (count($code_array) > 1) {
                        $code = $code_array[1];
                    }
                    // begin date

                    $begin_array = explode("n:", $description_array[1]);
                    if (count($begin_array) > 1) {
                        $begin = $begin_array[1];
                    }
                    // expire date
                    $expire_array = explode("e:", $description_array[2]);
                    if (count($expire_array) > 1) {
                        $expire = $expire_array[1];
                    }
                }

                // if code, begin date or expire date is empty store coupon info into tbl_coupon_conflicted
                // else insert coupons info into tbl_coupon table
                if ($code === '' || $begin === '' || $expire === '') {

                    $couponData = array(
                        'title' => $title,
                        'description' => $description,
                        'code' => $code,
                        'begin' => $begin,
                        'expire' => $expire,
                        'link' => $link,
                        'resaon' => 'code',
                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                    );
                    // confliclted coupons insertion call
                    $this->coupansmodel->addConflictCoupon($couponData);
                } else {
                    //check store info table have coupons title or not
                    // if coupon title  found then insert coupon into tbl_coupon
                    //else insert couponinto tbl_coupon-conflicted
                    $store = $this->coupansmodel->checkStore($couponTitle[0]);

                    // check if store 
                    if ($store) {
                        //echo date('Y-m-d H:i:s',strtotime($begin));die;
                        $couponData = array(
                            'title' => $title,
                            'description' => $description,
                            'code' => $code,
                            'begin' => $begin,
                            'expire' => $expire,
                            'link' => $link,
                            'fk_affiliate_network_id'=>$fk_affiliate_network_id
                        );
                        $result = $this->coupansmodel->addCoupan($couponData);
                        
                    } else {

                        $couponData = array(
                            'title' => $title,
                            'description' => $description,
                            'code' => $code,
                            'begin' => $begin,
                            'expire' => $expire,
                            'link' => $link,
                            'resaon' => 'title',
                            'fk_affiliate_network_id'=>$fk_affiliate_network_id
                        );
                        $this->coupansmodel->addConflictCoupon($couponData);
                    }
                }

            }
            $data['msg'] =  '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>';
            $this->session->flashdata('datafeed','<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>');
        }else{
            $data['msg'] = '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>';
            $this->session->flashdata('datafeed','<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>');
        }
        $data['content'] = $this->load->view('admin/coupons/import_view', $data, TRUE);
        $this->load->view('admin/template', $data);
        
    }
    //MNR COde
    public function importCoupons() {
        
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $this->load->model('admin/coupansmodel');
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        // Code to import data from CJ
        if (isset($_FILES["import_file"])) {
            if ($_FILES["import_file"]["name"] != '') {
                $uploadpath = './public/admin/uploads/csv_files';
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '600000000';
                $file_name = $_FILES["import_file"]["name"];
                $config['file_name'] = $file_name;
                $this->load->library('upload', $config);
                $flag = $this->upload->do_upload('import_file');
                $uploaddata = $this->upload->data();
                
                $path_to_file =base_url("public/admin/uploads/csv_files") ."/". $file_name;
                
                $fh = fopen($path_to_file, 'r');
                if ($fh) {
                    $i=0;
                    while (( $row = fgetcsv($fh) ) !== false) {
                        if (!empty($row[0]) && $i>0) {
                            
                            $array = explode("-",$row[0]);
                            $title                      =   $array[0];
                            $description                =   '';
                            $code                       =   '';
                            $begin                      =   '';
                            $expire                     =   '';
                            $link                       =   '';
                            $fk_affiliate_network_id    =   2;
                            if(isset($row[4])){
                                $description    =   $row[4];
                            }
                            if(isset($row[14])){
                                $code           =   $row[14];
                            }
                            if(isset($row[15])){
                                $begin          =   $row[15];
                            }
                            if(isset($row[16])){
                                $expire         =   $row[16];
                            }
                            if(isset($row[12])){
                                $link           =   $row[12];
                            }
                            // if code, begin date or expire date is empty store coupon info into tbl_coupon_conflicted
                            // else insert coupons info into tbl_coupon table
                            if ($code === '' || $begin === '' || $expire === '') {

                                $couponData = array(
                                    'title' => $title,
                                    'description' => $description,
                                    'code' => $code,
                                    'begin' => $begin,
                                    'expire' => $expire,
                                    'link' => $link,
                                    'resaon' => 'code',
                                    'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                );
                                // confliclted coupons insertion call
                                $result = $this->coupansmodel->addConflictCoupon($couponData);
                                if ($result) {
                                    $data['successmessage'] = " Datafeeds imported successfully";
                                } else {
                                    $data['error'] = "Error while importing datafeeds";
                                }
                            }else{
                                //check store info table have coupons title or not
                                // if coupon title  found then insert coupon into tbl_coupon
                                //else insert couponinto tbl_coupon-conflicted
                                $store = $this->coupansmodel->checkStore($title);

                                // check if store 
                                if ($store) {
                                    //echo date('Y-m-d H:i:s',strtotime($begin));die;
                                    $couponData = array(
                                        'title' => $title,
                                        'description' => $description,
                                        'code' => $code,
                                        'begin' => $begin,
                                        'expire' => $expire,
                                        'link' => $link,
                                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                    );
                                    $result = $this->coupansmodel->addCoupan($couponData);
                                    if ($result) {
                                        $data['successmessage'] = " Datafeeds imported successfully";
                                    } else {
                                        $data['error'] = "Error while importing datafeeds";
                                    }
                                } else {

                                    $couponData = array(
                                        'title' => $title,
                                        'description' => $description,
                                        'code' => $code,
                                        'begin' => $begin,
                                        'expire' => $expire,
                                        'link' => $link,
                                        'resaon' => 'title',
                                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                    );
                                    $result = $this->coupansmodel->addConflictCoupon($couponData);
                                    if ($result) {
                                        $data['successmessage'] = " Datafeeds imported successfully";
                                    } else {
                                        $data['error'] = "Error while importing datafeeds";
                                    }
                                }
                            }
                        }
                    $i++;  
                    }                     
                    fclose($fh);
                    $data['msg'] =  '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>';
                    $this->session->flashdata('datafeed','<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>');
                } else {
                    //echo "Null";
                    $data['msg'] = '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>';
                    $this->session->flashdata('datafeed','<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>');
                }
                
            }
            
        }
        
        // Code to import data from flex offers
        
        if (isset($_FILES["import_file_2"])) {
            
            if ($_FILES["import_file_2"]["name"] != '') {
                
                $uploadpath = './public/admin/uploads/csv_files';
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '800000000';
                $file_name = $_FILES["import_file_2"]["name"];
                $config['file_name'] = $file_name;
                $this->load->library('upload', $config);
                $flag = $this->upload->do_upload('import_file_2');
                /*$imageData = $this->upload->data();
                echo '<pre>';
                print_r($imageData);
                echo $this->upload->display_errors();
                die;*/
                $path_to_file = base_url('public/admin/uploads/csv_files'). "/" . $file_name;
                
                $fh = fopen($path_to_file, 'r');
                if ($fh) {
                    $row = fgetcsv($fh);
                    
                    //echo '<pre>';
                    //print_r($fh);
                    //print_r($row);
                    //exit;
                    $i=0;
                    $queryConflictCoupon = array();
                    $queryCoupon = array();
                    while (( $row = fgetcsv($fh) ) !== false) {
                        if (!empty($row[1]) && $i>0)
                        {
                            
                            $array = explode("-",$row[1]);
                            $title                      =   $array[0];
                            $description                =   '';
                            $code                       =   '';
                            $begin                      =   '';
                            $expire                     =   '';
                            $link                       =   '';
                            $fk_affiliate_network_id    =   4;
                            if(isset($row[3])){
                                $description    =   $row[3];
                            }
                            if(isset($row[6])){
                                $code           =   $row[6];
                            }
                            if(isset($row[4])){
                                $begin          =   $row[4];
                            }
                            if(isset($row[5])){
                                $expire         =   $row[5];
                            }
                            if(isset($row[10])){
                                $link           =   $row[10];
                            }
                            // if code, begin date or expire date is empty store coupon info into tbl_coupon_conflicted
                            // else insert coupons info into tbl_coupon table
                            if ($code === '' || $begin === '' || $expire === '') {

                                $couponData = array(
                                    'title' => $title,
                                    'description' => $description,
                                    'code' => $code,
                                    'begin' => $begin,
                                    'expire' => $expire,
                                    'link' => $link,
                                    'resaon' => 'code',
                                    'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                );
                                //$queryConflictCoupon[]= '("'.$title.'","'.$description.'","'.$code.'","'.$begin.'","'.$expire.'","'.$link.'","code",'.$fk_affiliate_network_id.')'; 
                                // confliclted coupons insertion call
                                $result = $this->coupansmodel->addConflictCoupon($couponData);
                                
                            }else{
                                //check store info table have coupons title or not
                                // if coupon title  found then insert coupon into tbl_coupon
                                //else insert couponinto tbl_coupon-conflicted
                                $store = $this->coupansmodel->checkStore($title);

                                // check if store 
                                if ($store) {
                                    //echo date('Y-m-d H:i:s',strtotime($begin));die;
                                    $couponData = array(
                                        'title' => $title,
                                        'description' => $description,
                                        'code' => $code,
                                        'begin' => $begin,
                                        'expire' => $expire,
                                        'link' => $link,
                                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                    );
                                    //$queryCoupon[]= '("'.$title.'","'.$description.'","'.$code.'","'.$begin.'","'.$expire.'","'.$link.'",'.$fk_affiliate_network_id.')'; 
                                    $result = $this->coupansmodel->addCoupan($couponData);
                                    
                                } else {

                                    $couponData = array(
                                        'title' => $title,
                                        'description' => $description,
                                        'code' => $code,
                                        'begin' => $begin,
                                        'expire' => $expire,
                                        'link' => $link,
                                        'resaon' => 'title',
                                        'fk_affiliate_network_id'=>$fk_affiliate_network_id
                                    );
                                    
                                    //$queryConflictCoupon[]= '("'.$title.'","'.$description.'","'.$code.'","'.$begin.'","'.$expire.'","'.$link.'","title",'.$fk_affiliate_network_id.')'; 
                                    $result = $this->coupansmodel->addConflictCoupon($couponData);
                                    
                                }
                            }
                        }
                        $i++;
                    }
                    fclose($fh);
                    $data['msg'] =  '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>';
                    $this->session->flashdata('datafeed','<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>');
                } else {
                    //echo "Null";
                    $data['msg'] = '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>';
                    $this->session->flashdata('datafeed','<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>');
                }
                
            }
            
        }
        
        $data['content'] = $this->load->view('admin/coupons/import_view', $data, TRUE);
        $this->load->view('admin/template', $data);
        
    }
    
     /**
     * This is  function of a seraching 
     */
    public function getSearchString($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['search_me']) && ($_POST['search_me'] != '')) {
            $search_string = $_POST['search'];
            $coupons = $this->coupansmodel->getSearch($page, $limit, $search_string);
            $data['coupons'] = $coupons;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/managecoupons/index');
            $data['paging'] = paging_generate($this->coupansmodel->getCountSerchCoupon($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;

            $data['content'] = $this->load->view('admin/coupons/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/managecoupon/index'));
        }
    }

    public function FMTC() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $this->load->model('admin/coupansmodel');
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);

        $cAPIKey = "2b7afde87c5c88f715d1d92c08c6fb73";

        //-----------------------------------------------------------------------
        // The call below will return all of your active deals and return it in the JSON format.
        //-----------------------------------------------------------------------
        $cURL = "http://services.formetocoupon.com/v2/getDeals?key=" . $cAPIKey . "&format=JSON";


        //-----------------------------------------------------------------------
        // Make the CURL call to return the feed results
        //-----------------------------------------------------------------------
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cURL);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1800);
        $cReturn = curl_exec($ch);

        $aJSON = json_decode($cReturn, TRUE);
        if (!$aJSON) {
            // Error!
            $data['msg'] = '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>';
            $this->session->flashdata('datafeed', '<div class="alert alert-danger" role="alert">Error while importing datafeeds</div>');
        } else {
            $conflictedCoupons = array();
            $validCoupons = array();
            foreach ($aJSON as $aFeed) {
                //echo '<pre>';
                $cStDate = '0000-00-00 00:00:00';
                $cEnDate = '0000-00-00 00:00:00';
                $sdate = str_replace('T', ' ', $aFeed['dtStartDate']);
                $cStDate = substr_replace($sdate, '', -6);
                $edate = str_replace('T', ' ', $aFeed['dtEndDate']);
                $cEnDate = substr_replace($edate, '', -6);
                if ($aFeed['cStatus']) {



                    $var = (htmlspecialchars_decode($aFeed['cLabel']) == $aFeed['cLabel']) ? htmlspecialchars($aFeed['cLabel']) : $aFeed['cLabel'];
                    $label = str_replace(array("'", '\"', "&quot;"), "\'", htmlspecialchars($aFeed['cLabel']));

                    $var1 = (htmlspecialchars_decode($aFeed['cMerchant']) == $aFeed['cMerchant']) ? htmlspecialchars($aFeed['cMerchant']) : $aFeed['cMerchant'];
                    $storeName = str_replace(array("'", '\"', "&quot;"), "\'", htmlspecialchars($aFeed['cMerchant']));
                    $cNetwork = $this->coupansmodel->checkStoreNetwork($aFeed['cMerchant']);
                    if (!empty($cNetwork)) {
                        $network = $cNetwork['cNetwork'];
                        if ($network === 4) {
                            if ($aFeed['cNetwork'] === 'LS') {
                                $network = 1;
                            } else if ($aFeed['cNetwork'] === 'CJ') {
                                $network = 3;
                            } else if ($aFeed['cNetwork'] === 'PJ') {
                                $network = 2;
                            }
                        }
                    } else {
                        if ($aFeed['cNetwork'] === 'LS') {
                            $network = 1;
                        } else if ($aFeed['cNetwork'] === 'CJ') {
                            $network = 2;
                        } else if ($aFeed['cNetwork'] === 'PJ') {
                            $network = 3;
                        }
                    }
                    if ($aFeed['dtStartDate'] === '' || $aFeed['dtEndDate'] === '') {

                        $conflictedCoupons[] = "('" . $storeName . "','" . $label . "','" . $aFeed['cCode'] . "','" . $cStDate . "','" . $cEnDate . "','" . $aFeed['cAffiliateURL'] . "','Yes','" . $network . "','Code')";
                    } else {
                        $store = $this->coupansmodel->checkStore($aFeed['cMerchant']);
                        if ($store) {
                            $validCoupons[] = "('" . $storeName . "','" . $label . "','" . $aFeed['cCode'] . "','" . $cStDate . "','" . $cEnDate . "','" . $aFeed['cAffiliateURL'] . "','Yes','" . $network . "')";
                        } else {
                            $conflictedCoupons[] = "('" . $storeName . "','" . $label . "','" . $aFeed['cCode'] . "','" . $cStDate . "','" . $cEnDate . "','" . $aFeed['cAffiliateURL'] . "','Yes','" . $network . "','Title')";
                        }
                    }
                }
            }
            //echo '<pre>';
            //print_r($conflictedCoupons);
            //print_r($validCoupons);
            //exit;

            if (!empty($conflictedCoupons)) {
                $this->coupansmodel->addFMTCConflictCoupon($conflictedCoupons);
            }
            //exit;
            if (!empty($validCoupons)) {
                $result = $this->coupansmodel->addFMTCCoupan($validCoupons);
            }
            $data['msg'] = '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>';
            $this->session->flashdata('datafeed', '<div class="alert alert-success" role="alert">Datafeeds imported successfully</div>');
            //print_r($aFeed);
            //print_r($validCoupons);
        } // END if($aJSON)
        //exit;
        $data['content'] = $this->load->view('admin/coupons/import_view', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

 public function truncate(){

 	
        $this->db->truncate('tbl_coupon'); 
        $this->db->truncate('tbl_coupon_conflicted'); 
        $this->db->truncate('tbl_coupon_raw'); 
        //tbl_coupon,tbl_coupon_conflicted,tbl_coupon_raw
	$data['msg'] = '<div class="alert alert-success" role="alert">Successfully truncated</div>';
            $this->session->flashdata('datafeed', '<div class="alert alert-success" role="alert">Successfully truncated</div>');

	redirect(base_url("admin/managecoupons"));
    }


//    public function conflictedCoupons($page = 1, $limit = 20) {
//        $data['page'] = $this->page;
//        $data['header'] = $this->header;
//        $data['footer'] = $this->footer;
//        $stores = $this->storemodel->getconflicted($page, $limit);
//
//        exit;
//
//        if (isset($_SESSION['successmessage'])) {
//            $data['successmessage'] = $_SESSION['successmessage'];
//            unset($_SESSION['successmessage']);
//        }
//        // generate paging
//        $this->load->helper('paging');
//        $datagridURL = site_url('store/index');
//        $data['paging'] = paging_generate($this->storemodel->getCountAllStore(), $page, $limit, 5, $datagridURL);
//        $data['datagridURL'] = $datagridURL;
//        $data['currentpage'] = $page;
//        $data['rowslimit'] = $limit;
//        $data['content'] = $this->load->view('admin/store/grid', $data, TRUE);
//        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
//        $this->load->view('admin/template', $data);
//    }
    

}
