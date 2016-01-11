<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news_sticker extends CI_Controller {

    public $page = 'news_sticker';
    public $data;
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;

    /**
     * Constructor of a login 
     */
    function __construct() {
        parent::__construct(); //call to parent constructor
        session_start();
        $this->load->helper(array('form', 'url'));
        // load model(s)
        $this->load->model(array('admin/newsstikermodel', 'commonmodel'));
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->data = "";
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
        //$this->load->library('menunodes');
    }

    /** 	
     * This is the default function of a controller 
     */
    public function index() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $hi_everyone = $this->newsstikermodel->gethieveryone();
        $data['hi_everyone'] = $hi_everyone;

        // for showing messagae
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $data['content'] = $this->load->view('admin/news_sticker/show', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function in_array_r($needle, $haystack) {
        $found = false;
        foreach ($haystack as $item) {
            if ($item === $needle) {
                $found = true;
                break;
            } elseif (is_array($item)) {
                unset($item['pk_relation_with_user_account_type_id']);
                unset($item['fk_table_name_id']);
                $found = $this->in_array_r($needle, $item);
                if ($found) {
                    break;
                }
            }
        }
        return $found;
    }

    /**
     * will save record
     *
     */
    public function save($id) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        $data['everyone_menu'] = 1;

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required|max_length[150]');
        $this->form_validation->set_rules('fk_user_account_type_id', 'Account Types', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['content'] = $this->load->view('admin/news_sticker/edit', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
            $this->load->view('admin/template', $data);
        } else { // no errors now to save the data
            $title = $this->input->post('title');
            $description = $this->input->post('description');


            $datas = array(
                'news_ticker_title' => $title,
                'news_ticker_description' => $description
            );

            $this->db->where('pk_news_ticker_id', $id);
            $this->db->update('tbl_news_ticker', $datas);
            $user_account_types = $this->input->post('fk_user_account_type_id');
            $where = array('fk_table_name_id ' => $id, 'relation_with_user_account_type_table_name ' => 'tbl_news_ticker');
            $this->db->where($where);
            $this->db->delete('tbl_relation_with_user_account_type');
            $user_account_types = $this->input->post('fk_user_account_type_id');
            foreach ($user_account_types as $uat) {

                $datas = array(
                    'relation_with_user_account_type_table_name' => 'tbl_news_ticker',
                    'fk_user_account_type_id' => $uat,
                    'fk_table_name_id' => $id,
                    'relation_with_user_account_type_status' => 'Active',
                    'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_relation_with_user_account_type', $datas);
            }

            $_SESSION['successmessage'] = 'News Sticker Info Updated Successfully';

            redirect(base_url('admin/news_sticker/index'));
        }
    }

    /**
     * will show the form for Adding new record
     */
    public function add() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['UserAccountType'] = $this->newsstikermodel->getUserAccountType();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required|max_length[150]');
            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $title = $this->input->post('title');
                $description = $this->input->post('description');


                $datas = array(
                    'news_ticker_title' => $title,
                    'news_ticker_description' => $description,
                    'news_ticker_status' => 'active',
                    'news_ticker_create_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('tbl_news_ticker', $datas);
                $fk_table_name_id = $this->db->insert_id();
                $relation_with_user_account_type_table_name = 'tbl_news_ticker';
                $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
                $counter = count($fk_user_account_type_id);
                for ($i = 0; $i < $counter; $i++) {
                    $datas = array(
                        'relation_with_user_account_type_table_name' => $relation_with_user_account_type_table_name,
                        'fk_user_account_type_id' => $fk_user_account_type_id[$i],
                        'fk_table_name_id' => $fk_table_name_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }

                $_SESSION['successmessage'] = 'News Sticker Inserted Successfully';
            }
            redirect(base_url('admin/news_sticker/index'));
            exit;
        }
        $data['content'] = $this->load->view('admin/news_sticker/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    /**
     * will show the form to edit record
     *
     * @param integer $page_id
     */
    public function edit($id) {
        $data['controller'] = $this;
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['ne_id'] = $id;
        $data['footer'] = $this->footer;
        $data['UserAccountType'] = $this->newsstikermodel->getUserAccountType();
        $data['EditAccountType'] = $this->newsstikermodel->getEditAccountType($id);
        $hi_everyone = $this->newsstikermodel->getEditSticker($id);

        $data['title'] = $hi_everyone->news_ticker_title;
        $data['description'] = $hi_everyone->news_ticker_description;
        $data['content'] = $this->load->view('admin/news_sticker/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    //////////////////////////deleta function start ///////////

    public function delete($id = '') {

        if ($id == '') {
            show_404();
        }
        $this->db->where('pk_news_ticker_id', $id);
        $this->db->delete('tbl_news_ticker');

        $where = array('fk_table_name_id ' => $id, 'relation_with_user_account_type_table_name ' => 'tbl_news_ticker');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type', $where);

        $_SESSION['successmessage'] = 'News Sticker Deleted Successfully';
        redirect(base_url('admin/news_sticker/index/'));
        exit;
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function status($id = '', $status = '') {
        if ($id == '' || $status == '') {
            show_404();
        }
        if ($status === "Active") {
            $data = array('news_ticker_status' => 'Inactive');
        } else if ($status === "Inactive") {
            $data = array('news_ticker_status' => 'Active');
        }

        $this->db->where('pk_news_ticker_id', $id);
        $this->db->update('tbl_news_ticker', $data);

        $_SESSION['successmessage'] = 'News Sticker Status Changed Successfully</div>';
        redirect(base_url('admin/news_sticker/index/'));
        exit;
    }

}
