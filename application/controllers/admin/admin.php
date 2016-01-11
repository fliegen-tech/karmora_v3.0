<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Usmna
 */
class Admin extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    //private $loginModel;
    /**
     * Constructor of a login 
     */
    function __construct() {


        parent::__construct(); //call to parent constructor
        $this->data = "";
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');

        // $this->loginModel    =   $this->load->model('admin/loginModel');

        session_start();
    }

    /**
     * will show the dashborad
     * index function default function of Admin Controller
     */
    public function index() {

        if ($this->session->userdata('admin_data')) {

            $data['header'] = $this->header;
            $data['footer'] = $this->footer;
            $data['content'] = $this->load->view('admin/content', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);

            $this->load->view('admin/template', $data);
        } else {
            $this->login();
        }
    }

    /**
     * This is the login function of a controller 
     */
    public function login() {


        $data = '';
        if (isset($_POST['submit'])) {
            $this->load->model('admin/loginModel');
            $username = '';
            $password = '';
            $errors = '';
           
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($username == '') {
               
                $data['username_error'] = 'Username is Required';
            }

            if ($password == '') {
                
                $data['password_error'] = 'Password is Required';
            }

            if ($username == '' && $password == '') {
                
                $data['password_error'] = '';
                $data['username_error'] = '';
                $data['general_error'] = 'Please enter Username and Password to proceed';
            }

            if ($username != '' && $password != '') {
                
               $row = $this->loginModel->verifyUser($username, $password);

                if (!empty($row)) {

                    $adminSessionData = '';
                    foreach ($row as $adminData) {
                        $adminSessionData['id'] = $adminData['pk_admin_operator_id'];
                        $adminSessionData['username'] = $adminData['admin_operator_username'];
                        $adminSessionData['email'] = $adminData['admin_operator_email'];
                        $adminSessionData['status'] = $adminData['admin_operator_account_status'];
                        $adminSessionData['name'] = $adminData['admin_operator_first_name'] . " " . $adminData['admin_operator_last_name'];
                    }
                        $this->session->set_userdata('admin_data',$adminSessionData);

                    redirect(base_url('admin/index'));
                } else {
                    $data['general_error'] = 'Invalid Credentials';
                }
            }
        }
        $data['title'] = "Karmora - Admin Panel Login";
        $this->load->view('admin/login', $data);
    }

    /**
     * will destroy session n logout user
     *
     */
    public function logout() {
        $data = '';
        $adminSessionData['id'] = '';
        $adminSessionData['username'] = '';
        $adminSessionData['email'] = '';
        $adminSessionData['status'] = '';
        $this->session->unset_userdata('admin_data'); // unset your sessions
        $this->session->sess_destroy();
        redirect('admin/login', $data);
    }

}

