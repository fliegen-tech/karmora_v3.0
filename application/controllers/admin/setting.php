<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class setting extends CI_Controller {

    public $page = 'setting';
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
        $this->load->model('commonmodel');
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->helper('string');
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

        $res = $this->commonmodel->getSingleRecord("select * from tbl_settings");
        $data['keywords'] = $res->meta_keywords;
        $data['title'] = $res->meta_tite;
        $data['description'] = $res->meta_description;
        $data['page'] = $this->page;
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/setting/showsettings', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
        //$this->load->view('admin/setting/showsettings.php',$data);
    }

    /**
     * will save record
     *
     */
    public function save() {

        $data['settings_menu'] = 1;

        $meta_title = $this->input->post('meta_title');
        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        //$_SESSION['posted_video_id']= $video_id;
        $this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
        $this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'required');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['page'] = $this->page;
            $data['header'] = $this->load->view('admin/header', $data, TRUE);
            $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
            $data['content'] = $this->load->view('admin/setting/showsettings', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            $datas = array(
                'meta_tite' => $meta_title,
                'meta_keywords' => $meta_keyword,
                'meta_description' => $meta_description,
            );
            $this->db->where('id', 2);
            $this->db->update('tbl_settings', $datas);
            $_SESSION['successmessage'] = '<span align="center" class="successmessage" style="color:green;margin-left:250px;">Settings Updates Successfully</span>';
            redirect(base_url("admin/setting/index"));
            exit;
        }
    }

}
