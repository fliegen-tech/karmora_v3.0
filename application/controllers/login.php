<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends karmora {

    /**
     * Constructor of a login 
     */
    function __construct() {
        parent::__construct(); //call to parent constructor
        session_start();
        $this->load->helper('url');
        $this->load->model('admin/loginmodel');
        $this->load->model('commonmodel');
        $this->load->library('form_validation');
    }

    /**
     * This is the default function of a controller 
     */
    public function index() {

        if ($_POST) { 
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($username != '' && $password != '') {
                $hpassword = md5($password);
                $row = $this->loginmodel->frontendVerifyUser($username, $hpassword);
                if ($row) {
                    $username = $row[0]['user_username'];
                    $this->config->set_item('base_url', base_url() . "$username");
                    $userSessionData = $this->set_session_login($row);
                    $this->session->set_userdata('front_data', $userSessionData);
                    $redirect = substr($_POST['redirectUrl'], 1);
                    $response = array('msg' => "1", 'data' => base_url(), 'redirect' => $redirect);
                    echo json_encode($response);
                    exit;
                } else {
                        $response = array('msg' => "0");
                        echo json_encode($response);
                        exit;
                }
                    } else if ($username === "" && $password === "") {
                        $response = array('msg' => "0");
                        echo json_encode($response);
                        exit;
                    } else if ($username === "" || $password === "") {
                                $response = array('msg' => "0");
                                echo json_encode($response);
                                exit;
                    }
        }
    }
    function logout() {
       
        $this->session->unset_userdata('front_data'); // unset your sessions
        $this->session->sess_destroy();
        unset($_SESSion['username']);
        unset($_SESSION['id']);

        redirect(base_url());
    }
    public function signup($username = null) {
        $casual_signup_id =  5;
        $this->verifyUser($username);
        $detail = $this->currentUser;
        if ($_POST) {
            $this->form_validation->set_rules('user_name', 'Name', 'required');
            $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_duplicate_email_check');
            if ($this->form_validation->run() == FALSE) {
                $error = validation_errors();
                $response = array('msg' => "2", 'data' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name = $this->input->post('user_name');
                $exp_name = explode(" ", $name);
                $f_name = $name;
                $l_name = '';
                if (count($exp_name) > 1) {
                    $f_name = $exp_name[0];
                    $l_name = $exp_name[1];
                }
                $millisecondsS = round(microtime(true) * 1000);
                $milliseconds  = substr($millisecondsS,9);
                $username      = '1000-'.$f_name.'-'.$milliseconds.''.substr(uniqid('', true),5,2); 
                $email = $this->input->post('email_address');
                $orignal_pass = 'karmora'.$milliseconds.'_'.$f_name;
                $password = md5($orignal_pass);
                $heardAboutKarmora = $this->input->post('heard_about_karmora');
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

                $data = array(
                    'user_first_name' => $f_name,
                    'user_last_name' => $l_name,
                    'user_username' => $username,
                    'user_email' => $email,
                    'user_password' => $password,
                    'user_registration_ip_address' => $ip,
                    'user_subid' => uniqid(),
                    'user_status' => 'Active',
                    'fk_user_id_referrer' => $detail['userid'],
                    'fk_heard_about_karmora_id' => $heardAboutKarmora,
                    'user_registration_date' => date("Y-m-d")
                );
                $this->db->insert('tbl_users', $data);
                $user_id = $this->db->insert_id();
                 
                // update username
                $username = 1000 + $user_id;
                $dataUpdate = array('user_username' => $username);
                $this->db->where('pk_user_id', $user_id);
                $this->db->update('tbl_users', $dataUpdate);
                
                 
                $dataLog = array(
                    'fk_user_id' => $user_id,
                    'fk_user_account_type_id' => $casual_signup_id,
                    'user_account_log_status' => 'Active',
                    'user_account_log_create_date' => date("Y-m-d")
                );
                
                $this->db->insert('tbl_user_to_user_account_type_log', $dataLog);
                $this->config->set_item('base_url', base_url() . "$username");
                $row = $this->loginmodel->frontendVerifyUser($username, $password);
                $userSessionData = $this->set_session_login($row);
                $this->session->set_userdata('front_data', $userSessionData);
                $response = array('msg' => "1", 'data' => base_url());
                echo json_encode($response); die;
            }
        }
    }
    public function duplicate_email_check($email) {
        
        
        $response = $this->commonmodel->isRecordAlreadyExist('user_email', $email, 'pk_user_id', 0, 'tbl_users');

        if ($response == 1) {
            $this->form_validation->set_message('duplicate_email_check', 'This email address already exists, please choose another email address');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function set_session_login($row){
        $userSessionData = '';
        $user_detail  = $this->commonmodel->getFounder($row[0]['pk_user_id']);
        foreach ($row as $userData) {
                        $userSessionData['id'] = $userData['pk_user_id'];
                        $userSessionData['user_account_type_id'] = $user_detail['user_account_type_id'];
                        $userSessionData['user_account_type_title'] = $user_detail['user_account_type_title'];
                        $userSessionData['username'] = $userData['user_username'];
                        $userSessionData['email'] = $userData['user_email'];
                        $userSessionData['user_phone_no'] = $userData['user_phone_no'];
                        $userSessionData['status'] = $userData['user_status'];
                        $userSessionData['user_first_name'] = $userData['user_first_name'] ; 
                        $userSessionData['user_last_name']  = $userData['user_last_name'];
                        $userSessionData['subid'] = $userData['user_subid'];
        }
        return $userSessionData;
    }

}
