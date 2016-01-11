<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class managecashmeout extends CI_Controller {

    public $page = 'managecashmeout';
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
        $this->page = 'managecashmeout';
        $this->load->library('form_validation');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/managecashmeoutmodel', 'commonmodel'));
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
            $AllChest = $this->managecashmeoutmodel->getSearch($page, $limit, $search_string);
            $data['AllChest'] = $AllChest;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/mangwinnerchest/index');
            $data['paging'] = paging_generate($this->managecashmeoutmodel->getCountAllchest($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/managewinnerchest/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/mangwinnerchest/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {
        $search_string = '';
        $AllChest = $this->managecashmeoutmodel->getAllchest($page, $limit);
        $data['AllChest'] = $AllChest;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managewinnerchest/index');
        $data['paging'] = paging_generate($this->managecashmeoutmodel->getCountAllchest($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/managewinnerchest/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function deleteuser($winnerchest_statics_pk_id = '') {

        $this->db->where('winnerchest_statics_pk_id', $winnerchest_statics_pk_id);
        $this->db->delete('tbl_winner_chest_statistics');

        $_SESSION['successmessage'] = 'Winnerchest User Deleted Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/tresureuser'));
    }

    
    public function changeUserStatus($winnerchest_statics_pk_id = '', $current_status = '') {
        $data = array('status' => $current_status);
        $this->db->where('winnerchest_statics_pk_id', $winnerchest_statics_pk_id);
        $this->db->update('tbl_winner_chest_statistics', $data);
        $_SESSION['successmessage'] = 'Winnerchest User Status Changed Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/tresureuser'));
    }

}
