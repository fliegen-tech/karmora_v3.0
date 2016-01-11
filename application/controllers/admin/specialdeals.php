<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of specialdeals
 *
 * @author Baig
 */
class specialdeals extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;
    public $page = 'store';

    public function __construct() {
        parent::__construct();
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        } else {
            $this->data = "";
            $this->load->helper('url');
            $this->load->model(array('admin/dealsmodel', 'commonmodel','admin/emailmodel'));
            $this->load->library('pagination');
            $this->load->library('form_validation');
            $this->load->library('image_lib');
            $this->load->helper('string');
            $this->data = "";
            $this->page = 'deals';
            $this->header = $this->load->view('admin/header', $this->data, TRUE);
            $this->template = $this->load->view('admin/template', $this->data, TRUE);
            $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        }
    }
    
    public function index() {
        echo "all is well"; exit;
    }
    public function compose($ajaxcall = '', $page = 1, $limit = 20) {
            
        $data['page']    = $this->page;
       $data['header']  = $this->header;
       $data['footer']  = $this->footer;
       $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
       
               
       $data['UserAccountType'] = $this->emailmodel->getUserAccountType();
       $parent_cat  = $this->dealsmodel->getParentCategories();
       
       $data['parent_cat']  =   $parent_cat;
       
       if($ajaxcall == "") {
           
           $ajaxcall = 76;
       }
       $stores  = $this->dealsmodel->getAllStoresByCategory($ajaxcall);
       
        $data['stores'] =   $stores;
        
       $data['content'] = $this->load->view('admin/specialdeals/grid' ,$data, TRUE);
       $this->load->view('admin/template', $data);
    }
    
    public function composeEmail() {
//        echo "<pre>";
//        print_r($_POST);
        $cat_id =   $_POST['cat_id'];
        $data['email_header']   =   $_POST['email_header'];
        $category   = $this->dealsmodel->getCategoryDetail($cat_id);
        $data['banner'] =   $category['category_image'];
        $data['description']    =   $category['category_description'];
        $store_detail   =   array();
        $count  =   0;
        foreach($_POST['store'] as $store) {
            // get store details
            $store_detail[$count]   = $this->dealsmodel->getStoresById($store);
            
            
            
            $count++;
        }
        $data['store']  = $store_detail;
        // create email content
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Karmora <noreply@karmora.com>' . "\r\n";
        $composed_email = $this->load->view('admin/specialdeals/preview', $data, TRUE);
        //echo $composed_email; exit;
        //$this->send_mail("ahmedb@karmora.com", "Karmora Specials", $composed_email);
        //$this->send_mail("irfank@karmora.com", "Karmora Specials", $composed_email);
       //exit;
        ////mail("baig772@gmail.com", "Karmora Special Deals", $composed_email, $headers);
        //mail("ahmed.baig@fliegentech.com", "Karmora Special Deals", $composed_email);
        //mail("naveeda@karmora.com", "Karmora Special Deals", $composed_email);
        //$this->load->view('admin/specialdeals/preview',$data);
        // creating email   
        
          // get all users with marketing email active
        $user   = $this->dealsmodel->getUsers();
        $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
        echo '<pre>';
        //print_r($fk_user_account_type_id);
        foreach ($fk_user_account_type_id as $uat) {
            //echo $uat;
            $user_emails = $this->dealsmodel->getUserEmail($uat);
            foreach($user_emails as $key => $value){
                $emails[]= $value['email'];
            }
            //print_r($emails);
            $this->create_queue($emails, $_POST['subject'], $composed_email, 'noreply@karmora.com');  
            array_splice($emails, 0, count($emails));
            //echo 'after slice';
            //print_r($emails);
            //echo 'after slice';
            //print_r($email);
            //$datas = array(
                    //'email_queue_recipient' => $user_email['user_email'],
                    //'email_queue_from' => "noreply@karmora.com",
                    //'email_queue_subject'   =>  "Special Deals from Karmora",
                    //'email_queue_message' => $composed_email,
                    //'email_queue_create_date' => date("Y-m-d H:i:s"),
                //);
            //$this->db->insert('tbl_email_queue', $datas);
            //echo $fk_table_name_id = $this->db->insert_id();
            //echo "<br />";
            
        }
        
        
        redirect(base_url('admin/specialdeals/compose'));
        //exit;

                //$fk_user_account_type_id = $this->input->post('fk_user_account_type_id'); 
               // $this->db->insert('tbl_email_queue', $datas);
                
               //echo $fk_table_name_id = $this->db->insert_id(); exit;
        //exit;
    }
    
     private function send_mail($to, $subject, $message, $from = "noreply@karmora.com") {
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from($from, 'Karmora');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        //echo $this->email->print_debugger();
    }
    public function create_queue($recipient_emails, $subject, $message, $from) {

        foreach ($recipient_emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $data = array(
                    'email_queue_recipient' => $email,
                    'email_queue_from' => $from,
                    'email_queue_subject' => $subject,
                    'email_queue_message' => $message
                );

                $this->db->insert('tbl_email_queue', $data);
            }
        }
    }

}
