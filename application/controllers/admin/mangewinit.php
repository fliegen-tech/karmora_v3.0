<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mangewinit extends karmora {

    public $page = 'mangewinit';
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
        parent::__construct(); //call to parent constructor
        session_start();
        $this->load->helper(array('form', 'url'));
        // load model(s)
        $this->data = "";
        $this->page = 'mangewinit';
        $this->load->library('form_validation');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/managewinitmodel', 'commonmodel'));
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
            $AllWinit = $this->managewinitmodel->getSearch($page, $limit, $search_string);
            $data['AllWinit'] = $AllWinit;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/mangewinit/index');
            $data['paging'] = paging_generate($this->managewinitmodel->getCountSerchprize($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/winit/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/mangewinit/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {

        $AllWinit = $this->managewinitmodel->getAllwintit($page, $limit);

        /* echo '<pre>';
          print_r($AllWinit);
          exit; */
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangewinit/index');
        $data['paging'] = paging_generate($this->managewinitmodel->getCountAllwintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/winit/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function delete($promation_pk_id = '') {

        if ($promation_pk_id == '') {
            show_404();
        }

        $this->db->where('promation_pk_id', $promation_pk_id);
        $this->db->delete('tbl_promations');
        $_SESSION['successmessage'] = 'Video Deleted Successfully</div>';
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Video Deleted Successfully</div>');
        redirect(base_url('admin/mangewinit/index'));
    }

    ////////////////////////// delte function end /////////////
    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($promation_pk_id = '', $current_status = '') {

        if ($promation_pk_id == '' || $current_status == '') {
            show_404();
        }
        $data = array('status' => $current_status);


        $this->db->where('promation_pk_id', $promation_pk_id);
        $this->db->update('tbl_promations', $data);
        $userdata = $this->commonmodel->getUsernameFromPromotion($promation_pk_id);
        $username = $userdata->username;
        $useremail = $userdata->usermemail;
        if ($current_status === "1") {
            // get name of contestant

            $userDetail = $this->commonmodel->getUsernameFromPromotion($promation_pk_id);

            $userFullName = $userDetail->first_name . " " . $userDetail->last_name;
            $imgPath = base_url() . "public/images/mix/theatre.jpg";
            // Create Image From Existing File
            $jpg_image = imagecreatefromjpeg($imgPath);

            // Allocate A Color For The Text
            $color = imagecolorallocate($jpg_image, 102, 20, 99);
            //putenv('GDFONTPATH=' . realpath('.'));
            //$font_path  =   'Oswald';
            // Set Path to Font File
            $font_path = FCPATH . "public/fonts/Myriad Pro.ttf";
            //echo $font_path = base_url()."/public/fonts/Myriad Pro.TTF";
            // Set Text to Be Printed On Image
            $text = "NOW SHOWING";

            // Print Text On Image

            $imagettf = imagettftext($jpg_image, 16, 0, 57, 140, $color, $font_path, $text);

            // printing name of user
            $text = "by, " . $userFullName;
            $imagettf = imagettftext($jpg_image, 13, 0, 60, 180, $color, $font_path, $text);
            // printing video name
            $video_name = $this->managewinitmodel->getVideoDetail($promation_pk_id);
            $video_name = substr($video_name, 0, 23);
            $text = $video_name;
            $strlen = strlen($video_name);
            $xaxis = 0;
            if ($strlen <= 10) {
                $xaxis = 87;
            } else if ($strlen > 10) {
                $xaxis = 60;
            }
            //echo $xaxis;
            $imagettf = imagettftext($jpg_image, 13, 0, $xaxis, 160, $color, $font_path, $text);

            $text = "Private Screening - CLICK HERE";

            $imagettf = imagettftext($jpg_image, 12, 0, 25, 200, $color, $font_path, $text);
            //saving image
            $saveToPath = FCPATH . "public/images/promotions/pay4mypurchase/" . $promation_pk_id . ".jpg";
            

            $savedImage = imagejpeg($jpg_image, $saveToPath);
            // var_dump($savedImage);

            $data = array('promotion_image' => $promation_pk_id . ".jpg");


            $this->db->where('promation_pk_id', $promation_pk_id);
            $this->db->update('tbl_promations', $data);

            $email_data = $this->commonmodel->getemailInfo(77);
            $tags = array(
                "{sharepage-url}",
                "{vote-page-url}",
                "{forum-pay4-url}"
            );
            $replace = array(
                base_url($username . '/Pay4MyPurchase/sharetowin'),
                base_url($username . '/Pay4MyPurchase/vote'),
                base_url($username . '/forum')
            );
        } elseif ($current_status == 2) {

            $email_data = $this->commonmodel->getemailInfo(30);
            $tags = array(
                "{pay4-rules-url}",
                "{forum-pay4-url}"
            );
            $replace = array(
                base_url($username . '/pay4mypurchase-rules'),
                base_url($username . '/forum')
            );
        }
        $subject = $email_data->email_title;
        $orignal_base_url = base_url();
        $this->config->set_item('base_url', base_url($username));
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
        $this->config->set_item('base_url', $orignal_base_url);
        $to = $useremail;
        $this->send_mail($to, $subject, $message);

        $_SESSION['successmessage'] = 'Video Status Changed Successfully</div>';
        redirect(base_url('admin/mangewinit/index'));
    }

    public function reasonD($promation_pk_id = '') {
        if ($promation_pk_id == '') {
            show_404();
        }
        $name = $this->session->userdata('username');
        if ($name != '') {
            $username = $name;
        } else {
            $username = 'admin';
        }
        $reason = $_POST['reason'];
        $by_user = $username;
        $data = array('comments' => $reason, 'by_user' => $by_user);
        $this->db->where('promation_pk_id', $promation_pk_id);
        $this->db->update('tbl_promations', $data);
        //$_SESSION['successmessage'] = 1;
        //redirect(base_url('afuser/sales/'.$stats_id.'/'.$page.'/'.$limit));exit;
    }

    public function fliterS($statusF, $page = 1, $limit = 20) {

        $data = '';
        // generate paging
        $this->load->helper('paging');
        $datagridURL = base_url('mangewinit/index');
        $data['datagridURL'] = $datagridURL;
        $data['paging'] = paging_generate($this->managewinitmodel->getCountStatus($statusF), $page, $limit, 5, $datagridURL);
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;

        $AllWinit = $this->managewinitmodel->getStatusFVideo($statusF, $page, $limit);

        $data['AllWinit'] = $AllWinit;
        if (empty($data['AllWinit'])) {
            echo 'No Record Found';
            die;
        }
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        echo $data['content'] = $this->load->view('admin/winit/inner', $data, TRUE);
    }

    public function approved($page = 1, $limit = 20) {

        $AllWinit = $this->managewinitmodel->getapprovewintit($page, $limit);
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangewinit/index');
        $data['paging'] = paging_generate($this->managewinitmodel->getCountapprovewintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/winit/approve', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function rejected($page = 1, $limit = 20) {

        $AllWinit = $this->managewinitmodel->getrejectedwintit($page, $limit);
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangewinit/index');
        $data['paging'] = paging_generate($this->managewinitmodel->getCountrejectedwintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/winit/rejected', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function assigndate() {
        $promtion = $this->managewinitmodel->getpromtion();
        $data['promtions'] = $promtion;
        if (isset($_POST['submit'])) {

            $promotion_start_date = $this->input->post('promotion_start_date');
            $promotion_end_date = $this->input->post('promotion_end_date');
            $fk_promotion_type_id = $this->input->post('fk_promotion_type_id');
            $promotion_status     = $this->input->post('promotion_status');
            $this->form_validation->set_rules('promotion_start_date', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('promotion_end_date', 'End date', 'trim|required');
            $this->form_validation->set_rules('promotion_status', 'Status', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
               

                $promotion_start_date = date('Y-m-d', strtotime($promotion_start_date));
                $promotion_end_date   = date('Y-m-d', strtotime($promotion_end_date));

                $datas = array(
                    'fk_promotion_type_id' => $fk_promotion_type_id,
                    'promotion_status' => $promotion_status,
                    'promotion_start_date' => $promotion_start_date,
                    'promotion_end_date' => $promotion_end_date
                );
                $this->db->insert('tbl_promation_logs', $datas);
                $data['successmessage'] = 'promotion date Updated Successfully';
            }
        }
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/winit/assigndate', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }
    
    public function edit($promtion_id=NULL) {
        //echo $promtion_id; die;
        if($promtion_id==''){
            redirect(base_url('mangewinit/index'));
        }
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $editrow = $this->managewinitmodel->getpromtionedit($promtion_id);
        $data['fk_user_id'] = $fk_user_id = $editrow->fk_user_id;
        $data['user_username'] = $user_username = $editrow->user_username;
        $data['video_type'] = $video_type = $editrow->video_type;
        $data['media'] = $media = $editrow->media;
        $data['email_address']   =   $email_address   =   $editrow->email_address;
        
        if(isset($_POST['submit'])){
            
            $type_change = $this->input->post('type_change');
            $datas = array(
                    'video_type' => $type_change
                );
                $this->db->where('promation_pk_id', $promtion_id);
                $this->db->update('tbl_promations', $datas);
                $data['successmessage'] = 'Pay4MyPurchase Updated Successfully';
        }
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/winit/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
        
        
    }

}
