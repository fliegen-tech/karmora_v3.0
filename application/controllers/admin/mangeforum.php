<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mangeforum extends CI_Controller {

    public $page = 'mangeforum';
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
        $this->load->library('form_validation');
        $this->page = 'mangeforum';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/mangeforummodel', 'commonmodel'));
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
        if (isset($_POST['search_me']) && ($_POST['search_me']!='')) {
            $search_string = $_POST['search'];
            $AllForum = $this->mangeforummodel->getSearch($page, $limit, $search_string);
        	 $data['AllForum']  = $AllForum;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/mangeforum/index');
        $data['paging'] = paging_generate($this->mangeforummodel->getCountSerchForum($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/forum/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
		 }else{
			redirect(base_url('admin/mangeforum/index'));
			 }
    }
	

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {

         $AllForum 			= $this->mangeforummodel->getAllForum($page, $limit);
		 $data['AllForum']  = $AllForum;
		 
		 
		// generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('mangeforum/index');
        $data['paging'] = paging_generate($this->mangeforummodel->getCountAllForum(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/forum/grid', $data, TRUE);
		$data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);

       

    }
    
    
    
    public function edit($forum_pk_id) {

        
        $ForumDetail = $this->mangeforummodel->getForummdeatil($forum_pk_id);
        $data['user_username'] = $ForumDetail->user_username;
        $data['forum_qu_title'] = $ForumDetail->forum_qu_title;
        $data['forum_question'] = $ForumDetail->forum_question;
        $data['forum_creation_time'] = $ForumDetail->forum_creation_time;
        $data['comment_count'] = $ForumDetail->comment_count;
        

        if (isset($_POST['submit'])) {



            $this->form_validation->set_rules('forum_description', 'Description', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $forum_description = $this->input->post('forum_description');
                $datas = array(
                    'forum_question' => $forum_description
                );
                $this->db->where('forum_pk_id', $forum_pk_id);
                $this->db->update('tbl_forum', $datas);
                redirect('admin/mangeforum/index');
            }
        }

        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['content'] = $this->load->view('admin/forum/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

	
	    /**
     * This is the default function of a controller 
     */
    public function comment($page = 1, $limit = 20) {

         $AllComment 			= $this->mangeforummodel->getAllComment($page, $limit);
		 $data['AllComment']    = $AllComment;
		 
		 
		// generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('mangeforum/comment');
        $data['paging'] = paging_generate($this->mangeforummodel->getCountAllComment(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/forum/comment', $data, TRUE);
		$data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);

       

    }



    public function delete($forum_pk_id = '',  $page = 1, $limit = 10) {

        if ($forum_pk_id == '') {
            show_404();
        }

        $this->db->where('forum_pk_id', $forum_pk_id);
        $this->db->delete('tbl_forum');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Forum Deleted Successfully</div>');
        redirect(base_url('admin/mangeforum/index/' . $page . '/' . $limit));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($forum_pk_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($forum_pk_id == '' || $current_status == '') {
            show_404();
        }
        $status = 1;

        if ($current_status == 1) {
            $status = 0;
        }
        $data = array('forum_status' => $status);
        $this->db->where('forum_pk_id', $forum_pk_id);
        $this->db->update('tbl_forum', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Forum Status Changed Successfully</div>');
        redirect(base_url('admin/mangeforum/index/' . $page . '/' . $limit));
    }
	
	
	
	// for comments
	
	
	
    public function deleteComm($tbl_forum_pk_comment_id = '',  $page = 1, $limit = 10) {

        if ($tbl_forum_pk_comment_id == '') {
            show_404();
        }

        $this->db->where('tbl_forum_pk_comment_id', $tbl_forum_pk_comment_id);
        $this->db->delete('tbl_forum_comments');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Forum Deleted Successfully</div>');
        redirect(base_url('admin/mangeforum/comment/' . $page . '/' . $limit));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeCommStatus($tbl_forum_pk_comment_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($tbl_forum_pk_comment_id == '' || $current_status == '') {
            show_404();
        }
        $status = 1;

        if ($current_status == 1) {
            $status = 0;
        }
        $data = array('tbl_forum_comments_status' => $status);
        $this->db->where('tbl_forum_pk_comment_id', $tbl_forum_pk_comment_id);
        $this->db->update('tbl_forum_comments', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Forum Status Changed Successfully</div>');
        redirect(base_url('admin/mangeforum/comment/' . $page . '/' . $limit));
    }


}
