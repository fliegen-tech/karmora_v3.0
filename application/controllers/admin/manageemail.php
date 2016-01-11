<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manageemail extends CI_Controller {

    public $page = 'emails';
    protected $validate_page_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->data = "";
        session_start();
        /* if(!$this->session->userdata('admin_id')) { 
          redirect(base_url('admin'));exit;
          }
          if($this->session->userdata('user_type') != 1) {  //validate user
          redirect(base_url('home'));exit;
          } */

        $this->load->model(array('admin/emailmodel', 'commonmodel'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->data = "";
        $this->page = 'email';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
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
            $Pages = $this->emailmodel->getSearch($page, $limit, $search_string);
            $data['Pages_grid'] = $Pages;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/manageemail/index');
            $data['paging'] = paging_generate($this->emailmodel->getCountAllemails($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/emails/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/pages/index'));
        }
    }

    public function index($page = 1, $limit = 10) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $search_string = '';
        $emails = $this->emailmodel->getAllEmails($page, $limit);
     
        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $emails = $this->emailmodel->getSearch($page, $limit, $search_string);
        }
        $data['emails'] = $emails;
            
        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/manageemail/index');
        $data['paging'] = paging_generate($this->emailmodel->getCountAllemails($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;
       
        
        $data['content'] = $this->load->view('admin/emails/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will add a page in DB
    public function add() {
          $data['controller']=$this;     
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['UserAccountType'] = $this->emailmodel->getUserAccountType();
        

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $email_title = $this->input->post('email_title');
            $email_content = $this->input->post('email_content');
			 $email_type = $this->input->post('email_type');
            
			$fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
                        $email_header   = $this->input->post('email_header');

            $this->form_validation->set_rules('email_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('email_content', 'Content', 'trim|required');
			
			
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
               
            } else {  // no errors now to save the data
                $datas = array(
                    'email_title' => $email_title,
                    'email_description' => $email_content,
                    'email_required'=>$email_type,
                    'email_status' => 'Active',
                    'email_create_date' => date("Y-m-d H:i:s"),
                    'email_header_text' => $email_header,
                );

                //$fk_user_account_type_id = $this->input->post('fk_user_account_type_id'); 
                $this->db->insert('tbl_email', $datas);
                $fk_table_name_id = $this->db->insert_id();
             
				foreach ($fk_user_account_type_id as $uat) {

                    $datas = array(
                        'relation_with_user_account_type_table_name' => 'tbl_email',
                        'fk_user_account_type_id' => $uat,
                        'fk_table_name_id' => $fk_table_name_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );	

                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }



                $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Email Added Successfully</div>');
                redirect(base_url('admin/manageemail/index'));
            }
        }
        $data['content'] = $this->load->view('admin/emails/add', $data, TRUE);


        $this->load->view('admin/template', $data);
    }

    public function edit($email_id) {
        
        $data['controller'] = $this;
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['UserAccountType'] = $this->emailmodel->getUserAccountType();
        $data['EditAccountType'] = $this->emailmodel->getEditAccountType($email_id);

		if(empty($data['EditAccountType'])){
			$data['EditAccountType']=array();
			}

		if(empty($data['EditAccountType'])){
			$data['EditAccountType']=array();
			}
        $data['email_id']=$email_id;

        $email_id = intval($email_id);
        if ($email_id == '') {
            show_404();
            exit;
        }
        #get the record from the database against the particular record
        $row = $this->emailmodel->getSingleEmailDetail($email_id);
        if (empty($row)) {
            show_404();
            exit;
        }
        

        $data['email_title'] = $page_title_edit = $row->email_title;
        $data['email_header'] = $page_header_edit = $row->email_header_text;
        $data['email_content'] = $page_content_edit = $row->email_description;
        $data['email_status'] = $page_status_edit = $row->email_status;
        $data['email_type'] = $page_parent_id_edit = $row->email_required;

       

        if (isset($_POST['submit'])) {

            
            $email_title = $this->input->post('email_title');
            $email_content = $this->input->post('email_content');
            $email_type = $this->input->post('email_type');
            $email_header   = $this->input->post('email_header');
            $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
            $this->form_validation->set_rules('email_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('email_content', 'Content', 'trim|required');



            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
               

                $datas = array(
                     'email_title' => $email_title,
                    'email_description' => $email_content,
                    'email_required'=>$email_type,
                    'email_header_text' => $email_header,
                );

                $this->db->where('pk_email_id', $email_id);
                $this->db->update('tbl_email', $datas);


       
                $where = array('fk_table_name_id ' => $email_id, 'relation_with_user_account_type_table_name ' => 'tbl_email');
                $this->db->where($where);
                $this->db->delete('tbl_relation_with_user_account_type');
                foreach ($fk_user_account_type_id as $uat) {

                    $datas = array(
                        'relation_with_user_account_type_table_name' => 'tbl_email',
                        'fk_user_account_type_id' => $uat,
                        'fk_table_name_id' => $email_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }

                $_SESSION['successmessage'] = 'Email Updated Successfully';
				redirect('admin/manageemail/index');
               // redirect(base_url('admin/manageemail/index'));
            }
        }

         $row = $this->emailmodel->getSingleEmailDetail($email_id);
         $data['email_type'] = $page_parent_id_edit = $row->email_required; 
        $data['EditAccountType'] = $this->emailmodel->getEditAccountType($email_id);
        $data['content'] = $this->load->view('admin/emails/edit', $data, TRUE);
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



    //This function will delete a specific record from DB
    public function delete($email_id = '', $page = 1, $limit = 10) {
		
        if ($email_id == '') {
            show_404();
        }
        $this->db->where('pk_email_id', $email_id);
        $this->db->delete('tbl_email');

        $where = array('fk_table_name_id ' => $email_id, 'relation_with_user_account_type_table_name ' => 'tbl_email');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Email Deleted Successfully</div>');
        redirect(base_url('admin/manageemail/index/' . $page . '/' . $limit));
    }

    //This function will change status of a page
    public function status($email_id = '', $current_status = '', $page = 1, $limit = 10) {
		
        if ($email_id == '' || $current_status == '') {
            show_404();
        }

        $data = array('status' => $current_status, 'updated_date_time' => date("Y-m-d H:i:s"));
        $this->db->where('email_id', $email_id);
        $this->db->update('tbl_email', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Status Changed Successfully</div>');
        redirect(base_url('admin/manageemail/index/' . $page . '/' . $limit));
    }

    public function preview(){
       
        if(isset($_POST['submit'])){
           $data['email_title'] = $this->input->post('email_title');
            $data['email_content'] = $this->input->post('email_content');
            $data['email_header']   = $this->input->post('email_header');
            $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');

            $this->form_validation->set_rules('email_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('email_content', 'Content', 'trim|required|min_length[3]');

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
               
            } else {     
            
                $this->load->view('admin/emails/preview',$data);
                
            }
            }
        
        }
       
    }
    



/* Location: ./application/controllers/pages.php */