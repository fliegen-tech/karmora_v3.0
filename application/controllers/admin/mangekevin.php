<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mangekevin extends karmora {

    public $page = 'mangewhereiskevin';
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
        $this->page = 'mangekevin';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/managewhereiskevinmodel', 'commonmodel'));
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
            $AllWinit = $this->managewhereiskevinmodel->getSearch($page, $limit, $search_string);
            $data['AllWinit'] = $AllWinit;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/mangekevin/index');
            $data['paging'] = paging_generate($this->managewhereiskevinmodel->getCountSerchprize($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/mangewhereiskevin/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/mangekevin/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {

        $AllWinit = $this->managewhereiskevinmodel->getAllwintit($page, $limit);
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangekevin/index');
        $data['paging'] = paging_generate($this->managewhereiskevinmodel->getCountAllwintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/mangewhereiskevin/grid', $data, TRUE);
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
        redirect(base_url('admin/mangekevin/index'));
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
             $userDetail = $this->commonmodel->getUsernameFromPromotion($promation_pk_id);
           
            $userFullName = $userDetail->first_name . " " . $userDetail->last_name;
             $imgPath = base_url() . "public/images/mix/share-wikk.jpg";
            // Create Image From Existing File
            $jpg_image = imagecreatefromjpeg($imgPath);
           
            // Allocate A Color For The Text
            $color = imagecolorallocate($jpg_image, 233, 87, 0);
            //putenv('GDFONTPATH=' . realpath('.'));
            //$font_path  =   'Oswald';
            // Set Path to Font File
            $font_path = FCPATH . "public/fonts/Myriad Pro.ttf"; 
            //echo $font_path = base_url()."/public/fonts/Myriad Pro.TTF";
            // Set Text to Be Printed On Image
            //$text = "NOW SHOWING";

            // Print Text On Image
            
            //$imagettf = imagettftext($jpg_image, 16, 0, 57, 140, $color, $font_path, $text);
            
            // printing name of user
            $text = $userFullName;
            $imagettf = imagettftext($jpg_image, 8, 0, 100, 150, $color, $font_path, $text);
            // printing video name
           
            
            //saving image
            $saveToPath = FCPATH . "public/images/promotions/whereiskarmorakevin/" . $promation_pk_id . ".jpg";

            $savedImage = imagejpeg($jpg_image, $saveToPath);
           // var_dump($savedImage);
           
            $data = array('promotion_image' => $promation_pk_id.".jpg");


        $this->db->where('promation_pk_id', $promation_pk_id);
        $this->db->update('tbl_promations', $data);

            $email_data = $this->commonmodel->getemailInfo(28);
            $tags = array(
                "{sharepage-url}",
                "{vote-page-url}"
            );
            $replace = array(
                base_url($username . '/WhereIsKarmoraKevin/sharetowin'),
                base_url($username . '/WhereIsKarmoraKevin/vote')
            );
        } elseif ($current_status == 2) {

            $email_data = $this->commonmodel->getemailInfo(25);
            $tags = array(
                "{kavin-rules-url}",
                "{forum-kavin-url}"
            );
            $replace = array(
                base_url($username . '/kevin-rules'),
                base_url($username . '/forum/#pay4mypurchase')
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
        redirect(base_url('admin/mangekevin/index'));
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
        $datagridURL = base_url('mangekevin/index');
        $data['datagridURL'] = $datagridURL;
        $data['paging'] = paging_generate($this->managewhereiskevinmodel->getCountStatus($statusF), $page, $limit, 5, $datagridURL);
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;

        $AllWinit = $this->managewhereiskevinmodel->getStatusFVideo($statusF, $page, $limit);

        $data['AllWinit'] = $AllWinit;
        if (empty($data['AllWinit'])) {
            echo 'No Record Found';
            die;
        }
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        echo $data['content'] = $this->load->view('admin/mangewhereiskevin/inner', $data, TRUE);
    }

    public function approved($page = 1, $limit = 20) {

        $AllWinit = $this->managewhereiskevinmodel->getapprovewintit($page, $limit);
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangekevin/index');
        $data['paging'] = paging_generate($this->managewhereiskevinmodel->getCountapprovewintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/mangewhereiskevin/approve', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function rejected($page = 1, $limit = 20) {

        $AllWinit = $this->managewhereiskevinmodel->getrejectedwintit($page, $limit);
        $data['AllWinit'] = $AllWinit;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangekevin/index');
        $data['paging'] = paging_generate($this->managewhereiskevinmodel->getCountrejectedwintit(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/mangewhereiskevin/rejected', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

}
