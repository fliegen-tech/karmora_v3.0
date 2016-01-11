<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manageraiseit extends karmora {

    public $page = 'manageraiseit';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    /**
     * Constructor of a login 
     */
    function __construct() {
       // echo "all is well"; exit;
        parent::__construct(); //call to parent constructor
        session_start();
        $this->load->helper(array('form', 'url'));
        // load model(s)
        $this->data = "";
        $this->page = 'manageraiseit';
        $this->load->library('form_validation');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/manageraiseitmodel', 'commonmodel'));
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
        if (isset($_POST['search_me']) && ($_POST['search_me'] != '')) {
            $search_string = $_POST['search'];
            $Allfundazaing = $this->manageraiseitmodel->getSearch($page, $limit, $search_string);
            $data['fundazaing'] = $Allfundazaing;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/manageraiseit/index');
            $data['paging'] = paging_generate($this->manageraiseitmodel->getCountAllfundazaing($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/manageraiseit/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/manageraiseit/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {
        $search_string = '';
        $Allfundazaing = $this->manageraiseitmodel->getAllfundazaing($page, $limit);
        $data['fundazaing'] = $Allfundazaing;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/manageraiseit/index');
        $data['paging'] = paging_generate($this->manageraiseitmodel->getCountAllfundazaing($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/manageraiseit/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function delete($pk_fundrasing_application_id = '') {

        $this->db->where('pk_fundrasing_application_id', $pk_fundrasing_application_id);
        $this->db->delete('tbl_fundrasing_application');

        $_SESSION['successmessage'] = 'Raise It Deleted Successfully</div>';
        redirect(base_url('admin/manageraiseit'));
    }

    ////////////////////////// delte function end /////////////
    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function setStatus($pk_fundrasing_application_id = '', $current_status = '') {
        if ($current_status == 'active') {
            redirect(base_url('admin/manageraiseit/approved/' . $pk_fundrasing_application_id));
        }
        if($current_status === 'declined'){
            
            $user_detail = $this->manageraiseitmodel->getfundazaingDetail($pk_fundrasing_application_id);
           
            $first_name = $user_detail->first_name;
            $last_name = $user_detail->last_name;
            $refreal_id = $user_detail->refreal_id;
            $email_address = $user_detail->email_address;
            $fundraising_name   =   $user_detail->organization_name;
            // send to fundrasing
            $email_data = $this->commonmodel->getemailInfo(61);
                $tags = array(
                    "{fname-lname}",
                    "{live-chat}",
                    "{fundraising}",
                    "{blog_url}"
                    
                );
                $replace = array(
                    $first_name.' '.$last_name,
                    'http://www.karmora.com/liveSupport/',
                    $fundraising_name,
                    base_url('blog')
                );
            
                $subject = $email_data->email_title;
                $orignal_base_url = base_url();
                //$this->config->set_item('base_url', base_url($user_username));
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description); 
               
                $this->config->set_item('base_url', $orignal_base_url); 
                $to = $email_address;
               
                $this->send_mail($to, $subject, $message);

                $refrer_detail = $this->commonmodel->getRefferName($refreal_id);
                $user_email = $refrer_detail->user_email;
                
                    // send to refrer
                    $this->send_mail($user_email, $subject, $message);
                    $this->send_mail('fundraising@karmora.com', $subject, $message);
                    
//                $email_data = $this->commonmodel->getemailInfo(37);
//                $tags = array(
//                    "{fname-lname}",
//                    "{live-chat}"
//                );
//                $replace = array(
//                    $first_name.' '.$last_name,
//                    'http://www.karmora.com/liveSupport/'
//                );
//            
//                $subject = $email_data->email_title;
//                $orignal_base_url = base_url();
//                //$this->config->set_item('base_url', base_url($user_username));
//                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description); 
//                $this->config->set_item('base_url', $orignal_base_url); 
//                //$to = $user_email;
//                $this->send_mail($user_email, $subject, $message);
                
        }

        $data = array('status' => $current_status);
        $this->db->where('pk_fundrasing_application_id', $pk_fundrasing_application_id);
        $this->db->update('tbl_fundrasing_application', $data);
        $_SESSION['successmessage'] = 'Raise It Status Changed Successfully</div>';
        redirect(base_url('admin/manageraiseit'));
    }

    public function approved($pk_fundrasing_application_id) {
        $data = '';
        $account_type_id = 10;
        //echo $pk_fundrasing_application_id; die;
         $fundazaingDetail = $this->manageraiseitmodel->getfundazaingDetail($pk_fundrasing_application_id);
//        echo "<pre>";
//        print_r($fundazaingDetail); exit;
         $refreal_id = $fundazaingDetail->refreal_id;
        $data['phone_no'] = $phone_no = $fundazaingDetail->phone_no;
        $data['email_address'] = $email_address = $fundazaingDetail->email_address;
        $data['organization_name'] = $organization_name = $fundazaingDetail->organization_name;
        $data['first_name'] =   $first_name =   $fundazaingDetail->first_name;
        $data['last_name']  =   $last_name  =   $fundazaingDetail->last_name;
        
//        $fo_goal    =   $fundazaingDetail->fundraising_goal;
//        $campaign_description   =   $fundazaingDetail->about_campaign;
//        $about_member   =   $fundazaingDetail->comments;
//        $fundraising_type_selection   =   $fundazaingDetail->fundraising_type_selection;
        if (isset($_POST['submit'])) {
            
      
            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $user_username = $this->input->post('user_username');
            $user_first_name = $this->input->post('user_first_name');
            $user_last_name = $this->input->post('user_last_name');
            $email_address = $this->input->post('email_address');
            $fundraising_name   = $this->input->post('organization_name');
            

            $this->form_validation->set_rules('user_username', 'User Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email|is_unique[tbl_users.user_email]');
            $this->form_validation->set_rules('user_first_name', 'Fist Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|min_length[2]');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                //print_r(form_error()); echo form_error(); die;
            } else {  // no errors now to save the data
                
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                $millisecondsS = round(microtime(true) * 1000);
                $milliseconds  = substr($millisecondsS,9);
                //$username = $this->input->post('username');
                //$fk_user_id_referrer = $this->input->post('affliate_hidden_id');
                $orignal_pass = 'karmora'.$milliseconds.'_'.$user_first_name;
                //$orignal_pass = $this->input->post('password');
                $password = md5($orignal_pass);

                $data = array(
                    'fundraising_name'  =>  $fundraising_name,
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_username' => $user_username,
                    'user_email' => $email_address,
                    'user_phone_no' => $phone_no,
                    'user_password' => $password,
                    'user_registration_ip_address' => $ip,
                    'user_subid' => uniqid(),
                    'user_status' => 'Active',
                    'fk_user_id_referrer' => $refreal_id,
                    'user_amazon_active' => 'Inactive',
                    'first_login' => 0
                    
                );
                
              $user_id    = $this->manageraiseitmodel->addFundraising($data);
              
                 
                // update username
                $username = 1000 + $user_id;
                $dataUpdate = array('user_username' => $username);
                $this->db->where('pk_user_id', $user_id);
                $this->db->update('tbl_users', $dataUpdate);
                
                if($fundraising_type_selection === 1){
                    $account_type_id = 11;
                }
                else if($fundraising_type_selection === 2){
                    $account_type_id = 10;
                }
                $dataA = array(
                    'fk_user_id' => $user_id,
                    'fk_user_account_type_id' => $account_type_id,
                    'user_account_log_status' => 'Active',
                    'user_account_log_create_date' => date("Y-m-d")
                );
                $this->db->insert('tbl_user_to_user_account_type_log', $dataA);
                
                //updating campaign
                /*
                $data_campaign   =   array(
                    'fk_user_id'    =>  $user_id,
                    'compaign_title'    =>  $organization_name,
                    'compaign_description'  =>  $campaign_description,
                    'compaign_amount'   =>  $fo_goal,
                    'compaign_status'   => 'Active',
                    'compaign_type' => 'basic'
                );
                $this->db->set('compaign_start_date', 'NOW()', FALSE);
                $this->db->set('compaign_create_date', 'NOW()', FALSE);
                $this->db->set('compaign_end_date', 'DATE_ADD(NOW(), INTERVAL 1 YEAR)', FALSE);
                $this->db->insert('tbl_compaign', $data_campaign);
                //$compaign_id = $this->db->last_insert_id();
                $compaign_id    = $this->db->insert_id();
                //echo $compaign_id; exit;
                $current_date = date('Y-m-d 00:00:00');
                $data_campaign_tar   =   array(
                    'fk_compaign_id'    =>  $compaign_id,
                    'fk_user_id_assigned_to'    =>  $user_id,
                    'compaign_targets_amount'  =>  $fo_goal,
                    'compaign_targets_assigned_date' => $current_date
                );
                $this->db->insert('tbl_compaign_targets', $data_campaign_tar);
                //echo $this->db->last_query(); exit;
                
                // insert into about member
                $data_about_array   =   array(
                    'fk_user_id'    =>  $user_id,
                    'about_member'    =>  $about_member,
                    );
                 $this->db->set('creation_date_time', 'NOW()', FALSE);
                 $this->db->insert('tbl_about_member', $data_about_array);
                 */
                // update funrasing
                
                $dataU = array('status' => 'active','user_id' => $user_id);
                $this->db->where('pk_fundrasing_application_id', $pk_fundrasing_application_id);
                $this->db->update('tbl_fundrasing_application', $dataU);
                $refrer_detail = $this->commonmodel->getRefferName($refreal_id);
                $refer_username = $refrer_detail->user_username;
                $user_email = $refrer_detail->user_email;
                $refer_name =   $refrer_detail->user_first_name." ".$refrer_detail->user_last_name;
                /// send to user
                $email_data = $this->commonmodel->getemailInfo(51);
                $tags = array(
                    "{fname-lname}",
                    "{Name-of-charity}",
                    "{charity-url}",
                    "{user-name}",
                    "{user-password}",
                    "{refer-name}",
                    "{refer-email}",
                    "{live-chat}",
                    "{blog_url}"
                );
                $replace = array(
                    $user_first_name.' '.$user_last_name,
                    $user_username,
                    base_url($user_username),
                    $user_username,
                    $orignal_pass,
                    $refer_username,
                    $user_email,
                    'http://www.karmora.com/liveSupport/',
                     base_url('blog')
                );
            
                $subject = $email_data->email_title;
                $orignal_base_url = base_url();
                $this->config->set_item('base_url', base_url($user_username));
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
                //echo $message;
                $this->config->set_item('base_url', $orignal_base_url); 
                $to = $email_address;
                $this->send_mail($to, $subject, $message);
                //$this->send_mail($email_address, 'Congratulations! FREE Fund-Shopping Application has been Approved!', $message);

            // send to refrer
                
                $email_data = $this->commonmodel->getemailInfo(60);
                $tags = array(
                    "{Fundraising Promoter}",
                    "{Name-of-charity}",
                    "{charity-url}",
                    "{org-name}"
                );
                $replace = array(
                    $refer_name,
                    $fundraising_name,
                    base_url($user_username),
                    $organization_name
                    );
            
                $subject = $email_data->email_title;
                $orignal_base_url = base_url();
                $this->config->set_item('base_url', base_url($user_username));
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
                //echo $message; exit;
                $this->config->set_item('base_url', $orignal_base_url); 
                $to = $user_email;
                $this->send_mail($to, $subject, $message);
                
                
                
//                $data = array(
//                    'fk_user_id' => $user_id,
//                    'about_member' => 'Please add introduction about your organisation.',
//                    'STATUS' => 1,
//                    'creation_date_time' => date("Y-m-d")
//                );
//                $this->db->insert('tbl_about_member', $data);
                
                
		$_SESSION['successmessage'] = 'Fund Rasing user Added  Successfully</div>';
                redirect(base_url('admin/manageraiseit'));

                
            }
        }
        

        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/manageraiseit/approved', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

}
