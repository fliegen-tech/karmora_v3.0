<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class managepost extends CI_Controller {

    public $page = 'managepost';
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
        $this->page = 'managepost';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->library('form_validation');
        $this->load->model(array('admin/mangepostmodel', 'commonmodel'));
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
            $AllPost = $this->mangepostmodel->getSearch($page, $limit, $search_string);
            $data['AllPost'] = $AllPost;

            $data['featured_blog'] = $this->mangepostmodel->getFeaturedBlog();

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('f_blog', 'Post Content', 'callback_featured_check');

                if ($this->form_validation->run() == FALSE) {
                    
                } else {
                    $fb = $this->input->post('f_blog');
                    for ($i = 0; $i < 3; $i++) {
                        $pdata = array('fk_blog_id' => $fb[$i]);
                        $this->db->where('pk_featured_blog_id', ($i + 1));
                        $this->db->update('tbl_featured_blog', $pdata);
                        $data['featured_blog'] = $this->mangepostmodel->getFeaturedBlog();
                    }
                }
            }


            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/managepost/index');
            $data['paging'] = paging_generate($this->mangepostmodel->getCountAllSerchPost($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/blog/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/managepost/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $AllPost = $this->mangepostmodel->getAllPost($page, $limit);
        $data['AllPost'] = $AllPost;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managepost/index');
        $data['paging'] = paging_generate($this->mangepostmodel->getCountAllPost(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
        $data['featured_blog'] = $this->mangepostmodel->getFeaturedBlog();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('f_blog', 'Post Content', 'callback_featured_check');

            if ($this->form_validation->run() == FALSE) {
                
            } else {

                $fb = $this->input->post('f_blog');

                for ($i = 0; $i < 3; $i++) {
                    $pdata = array('fk_blog_id' => $fb[$i]);
                    $this->db->where('pk_featured_blog_id', ($i + 1));
                    $this->db->update('tbl_featured_blog', $pdata);
                    $data['featured_blog'] = $this->mangepostmodel->getFeaturedBlog();
                }
            }
        }
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/blog/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function featured_check($str) {


        if (count($str) != 3) {
            $this->form_validation->set_message('featured_check', 'please select Three blogs as a Featured Blog');
            return false;
        } else
            return true;
    }

    public function add() {



        $data['blogCategory'] = $this->mangepostmodel->getblogCategory();
        //$data['UserAccountType']  = $this->mangepostmodel->getUserAccountType();
        if (isset($_POST['submit'])) {



            $this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');
            $this->form_validation->set_rules('post_content', 'Post Content', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $post_title = $this->input->post('post_title');
                $post_content = $this->input->post('post_content');
                $status = $this->input->post('status');
                $sesssion_data = $this->session->userdata('admin_data');
                $categories = $this->input->post('categories');
                if (!empty($categories)) {
                    $commaListCat = implode(',', $categories);
                } else
                    $commaListCat = "";
                $datas = array(
                    'fk_user_id' => $sesssion_data['id'],
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'categories' => $commaListCat,
                    'status' => $status,
                    'post_create_datetime' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_blog_posts', $datas);
                $_SESSION['successmessage'] = 'Post Created Sucefully';
                //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Post Created Sucefully</div>');
                redirect('admin/managepost/index');
            }
        }

        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/blog/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function edit($post_id) {

        $data['blogCategory'] = $this->mangepostmodel->getblogCategory();
        $AllComment = $this->mangepostmodel->getPostComments($post_id);
        $data['AllComment'] = $AllComment;
        $postInfo = $this->mangepostmodel->getpostInfo($post_id);
        $data['post_title'] = $postInfo->post_title;
        $data['status'] = $postInfo->status;
        $data['categories'] = explode(',', $postInfo->categories);
        $data['post_content'] = $postInfo->post_content;
        $data['status'] = $postInfo->status;

        if (isset($_POST['submit'])) {



            $this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');
            $this->form_validation->set_rules('post_content', 'Post Content', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $post_title = $this->input->post('post_title');
                $post_content = $this->input->post('post_content');
                $status = $this->input->post('status');
                $categories = $this->input->post('categories');
                if (!empty($categories)) {
                    $commaListCat = implode(',', $categories);
                } else{
                    $commaListCat = "";
                }
                $sesssion_data = $this->session->userdata('admin_data');
                $datas = array(
                    'fk_user_id' => $sesssion_data['id'],
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'categories' => $commaListCat,
                    'status' => $status,
                );
                $this->db->where('pk_post_id', $post_id);
                $this->db->update('tbl_blog_posts', $datas);
                $_SESSION['successmessage'] = 'Post Updated Successfully';
                //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Post Updated Successfully</div>');
                redirect('admin/managepost/index');
            }
        }

        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['content'] = $this->load->view('admin/blog/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function comment($page = 1, $limit = 20) {

        $AllComment = $this->mangepostmodel->getAllComment($page, $limit);
        $data['AllComment'] = $AllComment;


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('managepost/comment');
        $data['paging'] = paging_generate($this->mangepostmodel->getCountAllComment(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/blog/comment', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function delete($pk_post_id = '', $page = 1, $limit = 10) {

        if ($pk_post_id == '') {
            show_404();
        }

        $this->db->where('pk_post_id', $pk_post_id);
        $this->db->delete('tbl_blog_posts');
        $_SESSION['successmessage'] = 'Blog Deleted Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Blog Deleted Successfully</div>');
        redirect(base_url('admin/managepost/index/' . $page . '/' . $limit));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($pk_post_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_post_id == '' || $current_status == '') {
            show_404();
        }

        $data = array('status' => $current_status);
        $this->db->where('pk_post_id', $pk_post_id);
        $this->db->update('tbl_blog_posts', $data);
        $_SESSION['successmessage'] = 'Blog Status Changed Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Blog Status Changed Successfully</div>');
        redirect(base_url('admin/managepost/index/' . $page . '/' . $limit));
    }

    // for comments



    public function deleteComm($pk_comment_id = '', $page = 1, $limit = 10) {

        if ($pk_comment_id == '') {
            show_404();
        }

        $this->db->where('pk_comment_id', $pk_comment_id);
        $this->db->delete('tbl_blog_comments');
        $_SESSION['successmessage'] = 'Comment Deleted Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Comment Deleted Successfully</div>');
        redirect(base_url('admin/managepost/comment/' . $page . '/' . $limit));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeCommStatus($pk_comment_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_comment_id == '' || $current_status == '') {
            show_404();
        }
        $data = array('status' => $current_status);
        $this->db->where('pk_comment_id', $pk_comment_id);
        $this->db->update('tbl_blog_comments', $data);
        $_SESSION['successmessage'] = 'Comment Status Changed Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Comment Status Changed Successfully</div>');
        redirect(base_url('admin/managepost/comment/' . $page . '/' . $limit));
    }

    public function preview() {

        if ($_POST['submit']) {
            $data['user'] = $this->session->userdata('admin_data');

            $data['post_title'] = $this->input->post('post_title');
            $data['post_content'] = $this->input->post('post_content');

            $this->form_validation->set_rules('post_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('post_content', 'Content', 'trim|required');

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $this->load->view('admin/blog/preview', $data);
            }
        }
    }

}
