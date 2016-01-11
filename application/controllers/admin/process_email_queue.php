<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class process_email_queue extends karmora {

    public $page = 'reporting';
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
        $this->load->library('email');
        $this->load->helper('string');
        $this->data = "";
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    /**
     * This is the default function of a controller
     */
    public function index() {

        echo 'Email Queue Processing Script' . '<br>' .
        'Email Queue Processing Started At: ' . date('m-d-Y H:i:s');
        $getNoOfEmalisToProcess = 30;
        $emailList = $this->getEmailList($getNoOfEmalisToProcess);
        foreach ($emailList as $key => $emailInfo) {
            $to = $emailInfo['email_queue_recipient'];
            $subject = $emailInfo['email_queue_subject'];
            $message = $emailInfo['email_queue_message'];
            $from = $emailInfo['email_queue_from'];
            
            echo '<br>=========== Email Send Try Start ====================';
            $emailSent = $this->send_mail($to, $subject, $message, $from);
            if ($emailSent) {

                $this->delEmailRow($emailInfo['pk_email_queue_id']);
                echo '<br>Email sent to: ' . $emailInfo['email_queue_recipient'] . '<br>' .
                'email queue id: ' . $emailInfo['pk_email_queue_id'] .
                '<br>Email Sent Time: ' . date('m-d-Y H:i:s');
            } else {
                echo '<br>Failed to send email: ' . $emailInfo['email_queue_recipient'] . '<br>' .
                'email queue id: ' . $emailInfo['pk_email_queue_id'] .
                '<br>Email Failed Try Time: ' . date('m-d-Y H:i:s');
            }
            echo '<br>=========== Email Send Try End ====================<br>';
//            sleep($waitTime);
        }
        echo '<br>Email Queue Processing Ended At: ' . date('m-d-Y H:i:s');
        exit;
    }

    private function getEmailList($limit = 30) {
        $query = "SELECT * FROM tbl_email_queue WHERE 1 LIMIT $limit";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        count($result) > 0 ? $response = $result : $response = FALSE;

        return $response;
    }

    private function delEmailRow($id) {
        $query = "DELETE FROM tbl_email_queue WHERE pk_email_queue_id = $id";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        return;
    }

}
