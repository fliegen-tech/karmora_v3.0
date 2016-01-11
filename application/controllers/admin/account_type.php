<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account_type
 *
 * @waqas saeed
 */
class account_type extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;
    public $page = 'account_type';

    public function __construct() {
		session_start();
        parent::__construct();
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('paging');
        $this->load->model('admin/accounttypemodel');
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
            $useraccountprop = $this->accounttypemodel->getSearch($page, $limit, $search_string);
        	$data['useraccountprop'] = $useraccountprop;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('account_type/index');
        $data['paging'] = paging_generate($this->accounttypemodel->getCountSerchAccountType($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/account_types/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
		 }else{
			redirect(base_url('admin/account_type/index'));
			 }
    }

    public function index($page = 1, $limit = 20) {
		
		 if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $data['page'] = $this->page;
        $useraccountprop = $this->accounttypemodel->getAccountTypeList();
        $data['useraccountprop'] = $useraccountprop;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $datagridURL = site_url('admin/account_type/index');
        $data['paging'] = paging_generate($this->accounttypemodel->getCountAllUserAccountType(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/account_types/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        // paging 

        $this->load->view('admin/template', $data);
    }

    public function addAccountType() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        $data['account_properties'] = $this->accounttypemodel->get_account_properties();
        $data['billing_properties'] = $this->accounttypemodel->get_billing_properties();
        $data['account_cash_back'] = $this->accounttypemodel->get_account_cash_back();
        $data['business'] = $this->accounttypemodel->get_business();


        if (isset($_POST['submit'])) {


            $user_account_type_title = $this->input->post('user_account_type_title');
            $fk_user_account_properties_id = $this->input->post('fk_user_account_properties_id');
            $fk_user_account_billing_properties_id = $this->input->post('fk_user_account_billing_properties_id');
            $fk_user_account_cash_back_properties_id = $this->input->post('fk_user_account_cash_back_properties_id');
            $fk_business_id = $this->input->post('fk_business_id');
            $user_account_type_status = $this->input->post('user_account_type_status');

            $this->form_validation->set_rules('user_account_type_title', 'Account Type Title', 'trim|required|is_unique[tbl_user_account_type.user_account_type_title]');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $datas = array(
                    'user_account_type_title' => $user_account_type_title,
                    'fk_user_account_properties_id' => $fk_user_account_properties_id,
                    'fk_user_account_billing_properties_id' => $fk_user_account_billing_properties_id,
                    'fk_user_account_cash_back_properties_id' => $fk_user_account_cash_back_properties_id,
                    'fk_business_id' => $fk_business_id,
                    'user_account_type_status' => $user_account_type_status,
                    'user_account_type_create_date' => date("Y-m-d H:i:s")
                );


                $this->db->insert('tbl_user_account_type', $datas);

                $data['successmessage'] = 'Account Type Created Sucefully';
            }
        }
        $data['content'] = $this->load->view('admin/account_types/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function AccountTypeStatus($pk_user_account_type_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_user_account_type_id === '' || $current_status === '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('user_account_type_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('user_account_type_status' => 'Active');
        }
        $this->db->where('pk_user_account_type_id', $pk_user_account_type_id);
        $this->db->update('tbl_user_account_type', $data);
        $_SESSION['successmessage'] = 'Account Type Status Updated Successfully';
        redirect(base_url('admin/account_type/index/' . $page . '/' . $limit));
    }

    public function AccountTypeDelete($pk_user_account_type_id = '', $page = 1, $limit = 10) {
        if ($pk_user_account_type_id == '') {
            show_404();
        }
        $this->db->where('pk_user_account_type_id', $pk_user_account_type_id);
        $this->db->delete('tbl_user_account_type', $data);
        $_SESSION['successmessage'] = 'Account Type Deleted Successfully';
        redirect(base_url('admin/account_type/index/' . $page . '/' . $limit));
    }

    ///////////////////////////////////////
    // Accout Propties module start /////////////////

    public function userAccountProperties($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $this->load->model('admin/accounttypemodel');
        $useraccountprop = $this->accounttypemodel->getUserAccountPropList();
        $data['useraccountprop'] = $useraccountprop;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $datagridURL = site_url('admin/account_type/userAccountProperties');
        $data['paging'] = paging_generate($this->accounttypemodel->getCountAllUserAccountProp(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/account_types/account_properties/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        // paging 

        $this->load->view('admin/template', $data);
    }

    //this function will add a menu in DB
    public function addAccountProperties() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $user_account_properties_title = $this->input->post('user_account_properties_title');
            $user_account_properties_account_type = $this->input->post('user_account_properties_account_type');
            $user_account_properties_create_community = $this->input->post('user_account_properties_create_community');
            $user_account_properties_account_upgrade = $this->input->post('user_account_properties_account_upgrade');
            $user_account_properties_access_training_material = $this->input->post('user_account_properties_access_training_material');
            $user_account_properties_access_promotional_material = $this->input->post('user_account_properties_access_promotional_material');
            $user_account_properties_status = $this->input->post('user_account_properties_status');

            $this->form_validation->set_rules('user_account_properties_title', 'Properties Title', 'trim|required|is_unique[tbl_user_account_properties.user_account_properties_title]');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $datas = array(
                    'user_account_properties_title' => $user_account_properties_title,
                    'user_account_properties_account_type' => $user_account_properties_account_type,
                    'user_account_properties_create_community' => $user_account_properties_create_community,
                    'user_account_properties_account_upgrade' => $user_account_properties_account_upgrade,
                    'user_account_properties_access_training_material' => $user_account_properties_access_training_material,
                    'user_account_properties_access_promotional_material' => $user_account_properties_access_promotional_material,
                    'user_account_properties_status' => $user_account_properties_status,
                    'user_account_properties_create_date' => date("Y-m-d H:i:s")
                );


                $this->db->insert('tbl_user_account_properties', $datas);

                $data['successmessage'] = 'Account Type Created Sucefully';
            }
        }
        $data['content'] = $this->load->view('admin/account_types/account_properties/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function AccountPropertiesStatus($pk_user_account_properties_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_user_account_properties_id === '' || $current_status === '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('user_account_properties_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('user_account_properties_status' => 'Active');
        }
        $this->db->where('pk_user_account_properties_id', $pk_user_account_properties_id);
        $this->db->update('tbl_user_account_properties', $data);
        $_SESSION['successmessage'] = 'Account Properties Status Updated Successfully';
        redirect(base_url('admin/account_type/userAccountProperties/' . $page . '/' . $limit));
    }

    public function AccountPropertiesDelete($pk_user_account_properties_id = '', $page = 1, $limit = 10) {
        if ($pk_user_account_properties_id == '') {
            show_404();
        }
        $this->db->where('pk_user_account_properties_id', $pk_user_account_properties_id);
        $this->db->delete('tbl_user_account_properties', $data);
        $_SESSION['successmessage'] = 'Account Properties Deleted Successfully';
        redirect(base_url('admin/account_type/userAccountProperties/' . $page . '/' . $limit));
    }

    // Accout Propties module End /////////////////
    // Accout billing Propties module start /////////////////

    public function userBillingProperties($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $this->load->model('admin/accounttypemodel');
        $useraccountprop = $this->accounttypemodel->getUserAccountBillingList();
        $data['useraccountprop'] = $useraccountprop;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $datagridURL = site_url('admin/account_type/userBillingProperties');
        $data['paging'] = paging_generate($this->accounttypemodel->getCountAllUserAccountBilling(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/account_types/account_billing_properties/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        // paging 

        $this->load->view('admin/template', $data);
    }

    //this function will add a menu in DB
    public function addBillingProperties() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $user_account_billing_properties_title = $this->input->post('user_account_billing_properties_title');
            $user_account_billing_properties_arb_type = $this->input->post('user_account_billing_properties_arb_type');
            $user_account_billing_properties_amount = $this->input->post('user_account_billing_properties_amount');

            $this->form_validation->set_rules('user_account_billing_properties_title', 'Billing Title', 'trim|required|is_unique[tbl_user_account_billing_properties.user_account_billing_properties_title]');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $datas = array(
                    'user_account_billing_properties_title' => $user_account_billing_properties_title,
                    'user_account_billing_properties_arb_type' => $user_account_billing_properties_arb_type,
                    'user_account_billing_properties_amount' => $user_account_billing_properties_amount,
                    'user_account_billing_properties_create_date' => date("Y-m-d H:i:s")
                );


                $this->db->insert('tbl_user_account_billing_properties', $datas);

                $data['successmessage'] = 'Billing Type Created Sucefully';
            }
        }
        $data['content'] = $this->load->view('admin/account_types/account_billing_properties/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function BillingPropertiesDelete($pk_user_account_billing_properties = '', $page = 1, $limit = 10) {
        if ($pk_user_account_billing_properties == '') {
            show_404();
        }
        $this->db->where('pk_user_account_billing_properties', $pk_user_account_billing_properties);
        $this->db->delete('tbl_user_account_billing_properties', $data);
        $_SESSION['successmessage'] = 'Billing Properties Deleted Successfully';
        redirect(base_url('admin/account_type/userBillingProperties/' . $page . '/' . $limit));
    }

    // Accout  billing Propties module End /////////////////
    // Accout Cash  Back Propties module start /////////////////

    public function userCashBackProperties($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $this->load->model('admin/accounttypemodel');
        $useraccountprop = $this->accounttypemodel->getUserAccountCashBackList();
        $data['useraccountprop'] = $useraccountprop;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $datagridURL = site_url('admin/account_type/userCashBackProperties');
        $data['paging'] = paging_generate($this->accounttypemodel->getCountAllUserCashBack(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/account_types/account_cash_back_properties/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        // paging 

        $this->load->view('admin/template', $data);
    }

    //this function will add a menu in DB
    public function addCashBackProperties() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $user_account_cash_back_properties_title = $this->input->post('user_account_cash_back_properties_title');
            $user_account_cash_back_properties_cashback_allowed = $this->input->post('user_account_cash_back_properties_cashback_allowed');
            $user_account_cash_back_properties_override_commission_allowed = $this->input->post('user_account_cash_back_properties_override_commission_allowed');
            $user_account_cash_back_properties_referal_bonus_allowed = $this->input->post('user_account_cash_back_properties_referal_bonus_allowed');
            $user_account_cash_back_properties_commission_percentage = $this->input->post('user_account_cash_back_properties_commission_percentage');
            $user_account_cash_back_properties_referal_bonus_percentage = $this->input->post('user_account_cash_back_properties_referal_bonus_percentage');
            $user_account_cash_back_properties_cob_percentage = $this->input->post('user_account_cash_back_properties_cob_percentage');


            $this->form_validation->set_rules('user_account_cash_back_properties_title', 'CashBack Title', 'trim|required|is_unique[tbl_user_account_cash_back_properties.user_account_cash_back_properties_title]');
            $this->form_validation->set_rules('user_account_cash_back_properties_commission_percentage', 'Commission Percentage', 'trim|required');
            $this->form_validation->set_rules('user_account_cash_back_properties_referal_bonus_percentage', 'Referal Bonus Percentage', 'trim|required');
            $this->form_validation->set_rules('user_account_cash_back_properties_cob_percentage', 'Cob Percentage', 'trim|required');

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $datas = array(
                    'user_account_cash_back_properties_title' => $user_account_cash_back_properties_title,
                    'user_account_cash_back_properties_cashback_allowed' => $user_account_cash_back_properties_cashback_allowed,
                    'user_account_cash_back_properties_override_commission_allowed' => $user_account_cash_back_properties_override_commission_allowed,
                    'user_account_cash_back_properties_referal_bonus_allowed' => $user_account_cash_back_properties_referal_bonus_allowed,
                    'user_account_cash_back_properties_commission_percentage' => $user_account_cash_back_properties_commission_percentage,
                    'user_account_cash_back_properties_referal_bonus_percentage' => $user_account_cash_back_properties_referal_bonus_percentage,
                    'user_account_cash_back_properties_cob_percentage' => $user_account_cash_back_properties_cob_percentage,
                    'user_account_cash_back_properties_create_date' => date("Y-m-d H:i:s")
                );


                $this->db->insert('tbl_user_account_cash_back_properties', $datas);

                $data['successmessage'] = 'Cash Back Created Sucefully';
            }
        }
        $data['content'] = $this->load->view('admin/account_types/account_cash_back_properties/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function CashBackPropertiesDelete($pk_user_account_cash_back_properties_id = '', $page = 1, $limit = 10) {
        if ($pk_user_account_cash_back_properties_id == '') {
            show_404();
        }
        $this->db->where('pk_user_account_cash_back_properties_id', $pk_user_account_cash_back_properties_id);
        $this->db->delete('tbl_user_account_cash_back_properties', $data);
        $_SESSION['successmessage'] = 'CashBack Properties Deleted Successfully';
        redirect(base_url('admin/account_type/userCashBackProperties/' . $page . '/' . $limit));
    }

    // Accout  Cash  Back  Propties module End /////////////////
}
