<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manualemailqueue extends karmora {

    public $page = 'Custom Email Queue';
    protected $validate_banner_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model(array('commonmodel', 'admin/manualemailqueuemodel'));
        $this->load->library('image_lib');
        $this->load->library('email');
        $this->load->helper('string');
        $this->data = "";
        $this->page = 'Custom Email Queue';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');

        $this->load->helper('paging');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    public function index() {
        if ($this->session->userdata('admin_data')) {
            
        } else {
            $this->login();
        }
        $emailId = 79;
        echo '<pre>';

        $emailType = $this->manualemailqueuemodel->getEmailTypeId($emailId);

        $emailTypeArr = $this->manualemailqueuemodel->getAllEamilTypes();

        if (!in_array($emailType, $emailTypeArr)) {
            echo 'Email type not found for email ID : ' . $emailId;
        } else {
//           uncomment below after done.
//            $emailsList = $this->manualemailqueuemodel->usersEmailsListForEmailType($emailType);
            
            $emailsList = array('syedt@karmora.com', 'irfank@karmora.com');
           
            if (count($emailsList) < 1) {
                echo 'No email address found to send email.';
            } else {
                $email_data = $this->commonmodel->getemailInfo($emailId);
                $tags = array("{treasure-image}");
                $replace = array("https://www.karmora.com/public/images/treasures.png");

                $subject = $email_data->email_title;
                
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
//                echo $message;
                foreach($emailsList as $email){
                    $this->createEmailQueue($email, $subject, $message, 'no-reply@karmora.com');
                    echo '<br> email queued for Email Address: '.$email;
                    
                }
            }
        }
        exit;
    }

    private function createEmailQueue($to, $subject, $message, $from) {
        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {

            $data = array(
                'email_queue_recipient' => $to,
                'email_queue_from' => $from,
                'email_queue_subject' => $subject,
                'email_queue_message' => $message
            );
            $this->db->insert('tbl_email_queue', $data);
        }
    }
    
    public function timeCheck(){
        echo '========= Application Server =========<br>'. 'Time Stamp:'. date('m-d-Y h:i:sa').'<br>';
        $dbTime = $this->db->select("NOW() as tstamp")->get();
        echo '<br>========= Database Server =========<br>'. 'Time Stamp:'. $dbTime->row()->tstamp.'<br>';
        
        exit;
        
    }

}
