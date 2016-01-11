<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin_user extends CI_Controller {

    public $page = 'admin_user';
    protected $validate_user_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    public function __construct() {
        parent::__construct();
        $this->data = "";
        session_start();
        $this->load->helper('url');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/adminusermodel', 'commonmodel'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
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
            $Users = $this->adminusermodel->getSearch($page, $limit, $search_string);
        	$data['users'] = $Users;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/admin_user/index');
        $data['paging'] = paging_generate($this->adminusermodel->getCountAllUsers($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/admin_user/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
		 }else{
			redirect(base_url('admin/admin_user/index'));
			 }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {
        $search_string = '';
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $Users = $this->adminusermodel->getAllUsers($page, $limit);
        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $Users = $this->adminusermodel->getSearch($page, $limit, $search_string);
        }
        $data['users'] = $Users;
        //if($Users != 1 && empty($Users)){
        // redirect(base_url('admin_user'));
        //}
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin_user/index');
        $data['paging'] = paging_generate($this->adminusermodel->getCountAllUsers($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;

        $data['content'] = $this->load->view('admin/admin_user/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function add() {
		$data['controller'] = $this;
		$data['EditAccountType'] ='';
        $admin_category_id = 4; // change the name of parent category which is in ur database
        $data['fk_category_id'] = '0';
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        $data['admin_data_user'] = $this->adminusermodel->getadmincategory($admin_category_id);
        $data['UserAccountType'] = $this->adminusermodel->getUserAccountType();

        $data['user_id'] = '';
        if (isset($_POST['submit'])) {
            $password = $this->input->post('admin_user_password');
            $confirm_password = $this->input->post('admin_user_confirm_password');
            $this->form_validation->set_rules('admin_user_username', 'Username', 'trim|required|min_length[2]|is_unique[tbl_admin_operator.admin_operator_username]');
            $this->form_validation->set_rules('admin_user_first_name', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('admin_user_last_name', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('admin_user_list', 'User List', 'required');
            $this->form_validation->set_rules('admin_user_password', 'Password', 'trim|required|min_length[3]|matches[admin_user_confirm_password]');
            if ($password != '') {
                $this->form_validation->set_rules('admin_user_confirm_password', 'Confirm Password', 'trim|required|min_length[3]');
            }
            $this->form_validation->set_rules('admin_user_email', 'Email', 'trim|required|valid_email|is_unique[tbl_admin_operator.admin_operator_email]');

            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $username = $this->input->post('admin_user_username');
                $email = $this->input->post('admin_user_email');
                $admin_user_first_name = $this->input->post('admin_user_first_name');
                $admin_user_last_name = $this->input->post('admin_user_last_name');
                $admin_user_list = $this->input->post('admin_user_list');
                $datas = array(
                    'admin_operator_username' => $username,
                    'admin_operator_first_name' => $admin_user_first_name,
                    'admin_operator_last_name' => $admin_user_last_name,
                    'admin_operator_email' => $email,
                    'admin_operator_password' => md5($password),
                    'admin_operator_account_status' => 'Active',
                    'admin_operator_create_date' => date("Y-m-d H:i:s"),
                    'fk_category_id' => $admin_user_list
                );
                $this->db->insert('tbl_admin_operator', $datas);

                $fk_table_name_id = $this->db->insert_id();
                $relation_with_user_account_type_table_name = 'tbl_admin_operator';
                $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
                foreach ($fk_user_account_type_id as $ac) {
                    $datas = array(
                        'relation_with_user_account_type_table_name' => $relation_with_user_account_type_table_name,
                        'fk_user_account_type_id' => $ac,
                        'fk_table_name_id' => $fk_table_name_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }



                $data['successmessage'] = 'Opretor Created Sucefully';
                $emailContent = $this->getEmailContent($username, $admin_user_first_name, $admin_user_last_name, $email, $password);
                $this->load->library('email');
                $adminemail = $email; // change it to admin email
                $this->email->from($adminemail);
                $this->email->to($adminemail);
                $this->email->subject('Registered Detail');
                $this->email->message($emailContent);
                @$this->email->send();
            }
        }
        $data['page'] = $this->page;

        $data['content'] = $this->load->view('admin/admin_user/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    ///edit/////

    public function edit($user_id) {
        $data['controller'] = $this;
        $admin_category_name = 'operator'; // change the name of parent category which is in ur database
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['user_id'] = $user_id;
        $data['admin_data_user'] = $this->adminusermodel->getadmincategory($admin_category_name);
        $data['UserAccountType'] = $this->adminusermodel->getUserAccountType();

        $row = $this->adminusermodel->getEditUser($user_id); //die;
        //echo '<pre>';print_r($row);exit;
        if (empty($row)) {

            show_404();
        }
        $this->validate_user_id = $user_id;
        $data['user_id'] = $row->pk_admin_operator_id;
        $data['admin_user_username'] = $row->admin_operator_username;
        $data['admin_user_first_name'] = $row->admin_operator_first_name;
        $data['admin_user_last_name'] = $row->admin_operator_last_name;
        $data['admin_user_email'] = $row->admin_operator_email;
        $data['password'] = $row->admin_operator_password;
        $data['fk_category_id'] = $row->fk_category_id;
		$data['EditAccountType'] = $this->adminusermodel->getEditAccountType($user_id);

        if (isset($_POST['submit'])) {


            $this->form_validation->set_rules('admin_user_username', 'Username', 'trim|required|min_length[2]|callback_duplicate_check');
            $this->form_validation->set_rules('admin_user_email', 'Email', 'trim|required|valid_email|callback_duplicate_email_check');
            $this->form_validation->set_rules('admin_user_first_name', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('admin_user_last_name', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('admin_user_list', 'User List', 'required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $username = $this->input->post('admin_user_username');
                $user_account_types = $this->input->post('fk_user_account_type_id');
                $email = $this->input->post('admin_user_email');
                $admin_user_first_name = $this->input->post('admin_user_first_name');
                $admin_user_last_name = $this->input->post('admin_user_last_name');
                $admin_user_list = $this->input->post('admin_user_list');

                $datas = array(
                    'admin_operator_username' => $username,
                    'admin_operator_first_name' => $admin_user_first_name,
                    'admin_operator_last_name' => $admin_user_last_name,
                    'admin_operator_email' => $email,
                    'admin_operator_account_status' => 'Active',
                    'admin_operator_create_date' => date("Y-m-d H:i:s"),
                    'fk_category_id' => $admin_user_list
                );


                $this->db->where('pk_admin_operator_id', $user_id);
                $this->db->update('tbl_admin_operator', $datas);
                $where = array('fk_table_name_id ' => $user_id, 'relation_with_user_account_type_table_name ' => 'tbl_admin_operator');
                $this->db->where($where);
                $this->db->delete('tbl_relation_with_user_account_type');
                foreach ($user_account_types as $uat) {

                    $datas = array(
                        'relation_with_user_account_type_table_name' => 'tbl_admin_operator',
                        'fk_user_account_type_id' => $uat,
                        'fk_table_name_id' => $user_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }


                // unset($_SESSION['for_validation_user_id']);

                $data['successmessage'] = 'Opertor Updated Sucefully';
            }
        }
        $data['EditAccountType'] = $this->adminusermodel->getEditAccountType($user_id);
        $data['content'] = $this->load->view('admin/admin_user/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    /**
     *  callback function for checking duplicate username
     */
    public function duplicate_check($username) {

        $response = $this->commonmodel->isRecordAlreadyExist('admin_user_username', $username, 'pk_admin_user_id', $this->validate_user_id, 'tbl_admin_user');

        if ($response == 1) {
            $this->form_validation->set_message('duplicate_check', 'Sorry %s you have provided already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function in_array_r($needle, $haystack) {
        $found = false;
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
        return $found;
    }

    /**
     *  callback function for checking duplicate email
     */
    public function duplicate_email_check($email) {

        $response = $this->commonmodel->isRecordAlreadyExist('admin_user_email', $email, 'pk_admin_user_id', $this->validate_user_id, 'tbl_admin_user');

        if ($response == 1) {
            $this->form_validation->set_message('duplicate_email_check', 'Sorry %s you have provided already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /////// is already function end
    //////////////////////////deleta function start ///////////

    public function delete($pk_admin_user_id = '', $page = 1, $limit = 10) {

        if ($pk_admin_user_id == '') {
            show_404();
        }
        $this->db->where('pk_admin_operator_id', $pk_admin_user_id);
        $this->db->delete('tbl_admin_operator');

        $where = array('fk_table_name_id ' => $pk_admin_user_id, 'relation_with_user_account_type_table_name ' => 'tbl_admin_operator');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type', $data);

        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Opertor Deleted Successfully</div>';
        redirect(base_url('admin/admin_user/index/' . $page . '/' . $limit));
        exit;
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function admin_status($current_status, $pk_admin_user_id) {


        $data = array('admin_operator_account_status' => $current_status);
        $this->db->where('pk_admin_operator_id', $pk_admin_user_id);
        $this->db->update('tbl_admin_operator', $data);
        echo 'Status Changed Sucefully';
    }

    ////////////////////////// Change Status function end /////////////
    // email contact function for sending mail

    public function getEmailContent($username, $admin_user_first_name, $admin_user_last_name, $email, $password) {

        $content = "";
        $content .= "<p>Dear User,</p>
						 <p>You Have Register By Super Admin. Following are the details: </p>
						 <p><b>Name:</b> " . $username . "</p>
						 <p><b>First Name:</b> " . $admin_user_first_name . "</p>
						 <p><b>Last Name:</b> " . $admin_user_last_name . "</p>
						 <p><b>Email:</b> " . $email . "</p>
						 <p><b>Password:</b> " . $password . "</p>
						 <p><b>Url:</b> " . base_url('admin/index') . "</p>
						 <p>Thanks</p>";
        return $content;
    }

}
