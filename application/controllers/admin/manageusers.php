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
class manageusers extends karmora {

    public $page = 'manageusers';
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
        $this->load->model('admin/usermodel');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
    
    public function index($page = 1, $limit = 20) {
        
         $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $users = $this->usermodel->getAllUsers($page, $limit);
        $data['users'] =  $users;
        //echo "<pre>";
       // print_r($coupons);
       // exit;
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/manageusers/index');
        $data['paging'] = paging_generate($this->usermodel->getCountAllUsers(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/users/grid_all', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
    }
     // function to show user details
    public function UserDetails($userID) {
      $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $user = $this->usermodel->getSingleUser($userID);
        $refral = $this->usermodel->getRefralUser($user[0]['fk_user_id_referrer']);
        $data['user'] =  $user;
        $data['refral'] =  $refral;
        $data['content'] = $this->load->view('admin/users/singleuser', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
    }
    // function to edit user
      public function UserEdit($userID) {
         
      $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $user = $this->usermodel->getSingleUser($userID);
        $refral = $this->usermodel->getRefralUser($user[0]['fk_user_id_referrer']);
        if (isset($_POST['submit'])) {
         
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('user_username', 'Username', 'trim|required');
            $this->form_validation->set_rules('user_subid', 'SID', 'trim|required');
            $this->form_validation->set_rules('user_registration_date', 'Member Since', 'trim|required');
            $this->form_validation->set_rules('user_email', 'Email', 'required');
            $this->form_validation->set_rules('user_amazon_active', 'Amazon Status', 'required');
            $this->form_validation->set_rules('user_status', 'Status', 'required');
            

            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $user_first_name = $this->input->post('user_first_name');
                $user_last_name = $this->input->post('user_last_name');
                   $user_username = $this->input->post('user_username');
                $user_subid = $this->input->post('user_subid');   
                $user_registration_date = $this->input->post('user_registration_date');
                $user_email = $this->input->post('user_email');
                   $user_amazon_active = $this->input->post('user_amazon_active');
                $user_status = $this->input->post('user_status');
                
                $datas=array( 'user_first_name' => $user_first_name,
                'user_last_name' => $user_last_name,
                   'user_username' => $user_username,
                'user_subid' => $user_subid,   
                'user_registration_date' => $user_registration_date,
                'user_email' => $user_email,
                'user_amazon_active' => $user_amazon_active,
                'user_status' => $user_status
                    
                );
                $this->usermodel->updateUser($datas,$user[0]['fk_user_id_referrer']);
                
            }
        }
        $data['user'] =  $user;
        $data['refral'] =  $refral;
        $data['content'] = $this->load->view('admin/users/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
    }
    
        public function getSearchString($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['search_me']) && ($_POST['search_me'] != '')) {
            $search_string = $_POST['search'];
            $users = $this->usermodel->getSearch($page, $limit, $search_string);
            
            $data['users'] =  $users;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/manageusers/index');
            $data['paging'] = paging_generate($this->usermodel->getCountSerchUser($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;

        $data['content'] = $this->load->view('admin/users/grid_all', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/manageusers/index'));
        }
    }
    
    public function searchUser($page = 1, $limit = 20) {
         $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        
        if (isset($_POST['user_key']) && ($_POST['user_key'] != '')) {
            
            $search_string = $_POST['user_col'];
            $search_string_2 = $_POST['user_key'];
            $users = $this->usermodel->searchUser($page, $limit, $search_string,$search_string_2);
            
            $data['users'] =  $users;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/manageusers/search');
            $data['paging'] = paging_generate($this->usermodel->getCountMatchUser($search_string,$search_string_2), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
        }
        $data['content'] = $this->load->view('admin/users/grid_search', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        
        
    }
}
