<?php
 /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of top
 *
 * @author Usman
 */
class karmora extends CI_Controller {

    public $themeUrl = "http://staging3.karmora.com/public";
    public $current_affiliate = '';
    public $currentSubid = '525659344c44e';
    public $userId = 2;
    private $founder = 2;
    /*
     * $currentUser contain below information for the current user
     * 1) pk_user_id as userid
     * 2) user_subid as subid
     * 3) user_username as username
     */
    public $currentUser;

    public function __construct() {
        parent::__construct();
        $this->load->model('commonmodel');
        $this->load->model('homemodel');
        $this->load->library('pagination');
        $this->data['themeUrl'] = $this->themeUrl;
        $this->data['currentSubid'] = $this->currentSubid;

        $this->currentUser = $this->commonmodel->getFounder($this->founder);
    }

    public function verifyUser($username = NULL) {
//        check if user is logged in set baseURL for signed in user else set baseURL for username passed in URLs
        $userVerifySuccess = !$this->checkUserLogin() ?
                /*
                 * check if username is not null, if username is empty set user global vars to default values 
                 */
                is_null($username) ? TRUE : $this->checkUsername($username) :
                /*
                 * if user is logged in user is verified already, set value to TRUE 
                 */
                TRUE;
        $this->setBaseUrl($userVerifySuccess);
        if(isset($this->session->userdata['front_data']['id']) && $username != $this->currentUser['username']){
            redirect(base_url());
        }elseif(!$userVerifySuccess){
            redirect(base_url());
        }
        return $userVerifySuccess;
    }

// set new baseURL and redirect to it
    private function setBaseUrl($verify) {
        if ($verify && $this->currentUser['userid']!= $this->founder) {
            $this->config->set_item('base_url', base_url($this->currentUser['username']));
        }
        return;
    }

    private function checkUsername($username) {
        /*
         * check if username is valid and is active in database also check if return is false. 
         * if not false remove the top array from the returned value.
         */
        $userDetail = is_null($username) ? FALSE : $this->getUserDetails($username);
        $this->currentUser = $userDetail !== FALSE ? $this->setGlobalValArrayFromUserDetail($userDetail) : $this->setDefaultValues();
        return $userDetail == FALSE ? FALSE : TRUE;
    }

//    set values from user detail array
    private function setGlobalValArrayFromUserDetail($data) {
        $vals = reset($data);
        //echo '<pre>';        print_r($vals); die;
        $response = array(
            'userid' => $vals ['pk_user_id'],
            'subid' => $vals ['user_subid'],
            'user_first_name' => $vals ['user_first_name'],
            'user_last_name' => $vals ['user_last_name'],
            'user_email' => $vals ['user_email'],
            'username' => $vals ['user_username'],
            'user_phone_no' => $vals ['user_phone_no'],
            'user_account_type_id' => $vals ['fk_user_account_type_id'],
            'user_account_type_title' => $vals ['user_account_type_title'],
        );
        return $response;
    }

//    function to set defaul values for user global variables
    private function setDefaultValues() {
        return  $this->commonmodel->getFounder($this->founder);
    }

// function to check if user is logged in
    private function checkUserLogin() {
        if (isset($this->session->userdata['front_data'])) {
            $response = TRUE;
            $this->currentUser = array(
                'userid' => $this->session->userdata['front_data']['id'],
                'subid' => $this->session->userdata['front_data']['subid'],
                'username' => $this->session->userdata['front_data']['username'],
                'user_email' => $this->session->userdata['front_data']['email'],
                'user_phone_no' => $this->session->userdata['front_data']['user_phone_no'],
                'user_first_name' => $this->session->userdata['front_data']['user_first_name'],
                'user_last_name' => $this->session->userdata['front_data']['user_last_name'],
                'user_account_type_id' => $this->session->userdata['front_data']['user_account_type_id'],
                'user_account_type_title' => $this->session->userdata['front_data']['user_account_type_title'],
            );
        } else {
            $response = FALSE;
        }
        return $response;
    }
    
    public function getUserDetails($username) {

        $data = $this->commonmodel->getUserDetails($username);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    // this function check user_account type id
    public function checkUserAccounttype($user_id) {
        //echo $user_id;
        $row = $this->commonmodel->getAccounttype($user_id);
        if (!empty($row)) {
            $fk_user_account_type_id = $row->fk_user_account_type_id;
            return $fk_user_account_type_id;
        } else {
            show_404();
        }
    }

    public function prepURL($affiliateNetworkId = null, $url = null) {
        //echo 'in else<br>';
        $subIdElement = $this->commonmodel->getAffiliateNetworkSubidElement($affiliateNetworkId);

        $element = explode('=', $subIdElement->url_var);
        $element[1] = $this->currentSubid;
        $elementWithSubid = implode('=', $element);
        // check url have parameter or not
        $checkParam = parse_url($url);
        if (isset($checkParam['query'])) {
            //Has query params
            $response = $url . $elementWithSubid;
        } else {
            //Has no query params

            $newUrl = str_replace('&', '?', $elementWithSubid);
            $response = $url . $newUrl;
        }
        return $response;
    }

  

    /* ------------Start Email Functions------------------ */

    public function prepEmailContent($tags, $replace, $title, $content, $userId = NULL, $header_text) {

        $userAccType = $userId !== NULL ? $this->db->select('get_account_type_business_id(get_user_account_type(' . $userId . ')) AS business_id')->get() : NULL;
        $data['title'] = $title;
        $data['email_header'] = $header_text . "<br />";
        if ($userAccType === NULL || $userAccType->row()->business_id === '1') {
            $header = $this->load->view('email/emailheader', $data, TRUE);
        } elseif ($userAccType->row()->business_id === '2') {
            $header = $this->load->view('email/emailheader_fundraising', $data, TRUE);
        }
        $footer = $this->load->view('email/emailfooter', '', TRUE);

        $message = $header;
        $message .= str_replace($tags, $replace, $content);
        return $message.= $footer;
    }

    public function prepShareEmailContent($tags, $replace, $title, $content, $userId = NULL) {
        $userAccType = $userId !== NULL ? $this->db->select('get_account_type_business_id(get_user_account_type(' . $userId . ')) AS business_id')->get() : NULL;

        if ($userAccType === NULL || $userAccType->row()->business_id === '1') {
            $header = $this->load->view('email/emailheader', $data, TRUE);
        } elseif ($userAccType->row()->business_id === '2') {
            $header = $this->load->view('email/emailheader_fundraising', $data, TRUE);
        }
        $footer = $this->load->view('email/email_sharefooter', '', TRUE);

        $data['title'] = $title;
        $message = $header;
        $message .= str_replace($tags, $replace, $content);
        return $message.= $footer;
    }

    public function send_mail($to, $subject, $message, $from = "noreply@karmora.com") {
//        return true;
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $from_title = 'Karmora';
        $this->load->library('email');
        $this->email->initialize($config);
        if ($from != 'noreply@karmora.com') {
            $from_title = $from;
        } else {
            $from_title = 'Karmora';
        }
        $this->email->from($from, $from_title);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();

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
    
    // this function Get category List According To Account Type
    public function GetCategories($fk_user_account_type_id) {

        $row = $this->commonmodel->getATCategory($fk_user_account_type_id);
        if (!empty($row)) {
            return $row;
        } else {
            return '';
        }
    }

    /* ------------End Email Functions------------------ */

      
    /* ------------Load Layout Functions------------------ */

    public function loadLayout($data,$content_path) {
        $data['header'] = $this->load->view('frontend/layout/header_home', $data, TRUE);
        $data['footer'] = $this->load->view('frontend/layout/footer_home', $data, TRUE);
        $data['content'] = $this->load->view($content_path, $data, TRUE);
        $this->load->view('frontend/layout/template', $data);
       
    }
}
