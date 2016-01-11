<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends CI_Controller {

    public $page = 'pages';
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

        $this->load->model(array('admin/pagemodel', 'commonmodel'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->data = "";
        $this->page = 'banner';
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
        if (isset($_POST['search_me']) && ($_POST['search_me']!='')) {
            $search_string = $_POST['search'];
            $Pages = $this->pagemodel->getSearch($page, $limit, $search_string);
        	$data['Pages_grid'] = $Pages;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/pages/index');
        $data['paging'] = paging_generate($this->pagemodel->getCountAllpages($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/pages/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
		 }else{
			redirect(base_url('admin/pages/index'));
			 }
    }

    public function index($page = 1, $limit = 10) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $search_string = '';
        $Pages = $this->pagemodel->getAllPages($page, $limit);
        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $Pages = $this->pagemodel->getSearch($page, $limit, $search_string);
        }
        $data['Pages_grid'] = $Pages;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('pages/index');
        $data['paging'] = paging_generate($this->pagemodel->getCountAllpages($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;

        $data['content'] = $this->load->view('admin/pages/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will add a page in DB
    public function add() {

        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
	$data['UserAccountType'] = $this->pagemodel->getUserAccountType();
        $data['Category'] = $this->pagemodel->getPageCategories();

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $page_title = $this->input->post('page_title');
            $page_content = $this->input->post('page_content');
            $page_status = $this->input->post('page_status');
            $page_parent_id = $this->input->post('page_parent_id');
            $page_inheritance = $this->input->post('page_inheritance');
            $fk_user_account_type_id = $this->input->post('fk_user_account_type_id'); 
            $pk_category_id = $this->input->post('pk_category_id');
            $this->form_validation->set_rules('pk_category_id', 'Category', 'trim|required');
            $this->form_validation->set_rules('page_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('page_content', 'Content', 'trim|required|min_length[3]');


            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $alias = strtolower($page_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '-', $alias);

                $datas = array(
                    'page_title' => $page_title,
                    'page_alias' => $alias,
                    'page_content' => $page_content,
                    'page_status' => $page_status,
                    'page_create_date' => date("Y-m-d H:i:s"),
                    'page_parent_id' => $page_parent_id,
                    'page_inheritance' => $page_inheritance,
                    'fk_category_id' => $pk_category_id,
                    'page_version' => 1,
                    'page_current_version' => 'True'
                );

				//$fk_user_account_type_id = $this->input->post('fk_user_account_type_id'); 
                $this->db->insert('tbl_page', $datas);
				$fk_table_name_id							 = $this->db->insert_id(); 
				$relation_with_user_account_type_table_name  = 'tbl_page';
				$fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
				$counter 			= count($fk_user_account_type_id);
				for($i=0;$i<$counter;$i++){
				$datas = array(
                    'relation_with_user_account_type_table_name' => $relation_with_user_account_type_table_name,
                    'fk_user_account_type_id' => $fk_user_account_type_id[$i],
                    'fk_table_name_id' => $fk_table_name_id,
                    'relation_with_user_account_type_status' => 'Active',
                    'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('tbl_relation_with_user_account_type', $datas);
				}
				
				

                 $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Page Added Successfully</div>');
				 redirect(base_url('admin/pages/index'));
            }
        }
        $data['content'] = $this->load->view('admin/pages/add', $data, TRUE);

        
		 $this->load->view('admin/template', $data);
    }

    public function edit($page_id) {
		
		$data['controller'] = $this;
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
	$data['UserAccountType'] = $this->pagemodel->getUserAccountType();
        $data['EditAccountType'] = $this->pagemodel->getEditAccountType($page_id);
        $data['Category'] = $this->pagemodel->getPageCategories();

        $page_id = intval($page_id);
        if ($page_id == '') {
            show_404();
            exit;
        }
        #get the record from the database against the particular record
        $row = $this->pagemodel->getSinglePageDetail($page_id);
        if (empty($row)) {
            show_404();
            exit;
        }
        $this->validate_page_id = $page_id;

        $data['page_title'] = $page_title_edit = $row->page_title;
        $data['page_content'] = $page_content_edit = $row->page_content;
        $data['page_status'] = $page_status_edit = $row->page_status;
        $data['page_parent_id'] = $page_parent_id_edit = $row->page_parent_id;
        $data['page_inheritance'] = $page_inheritance_edit = $row->page_inheritance;
        $data['fk_category_id'] = $fk_category_id_edit = $row->fk_category_id;
        $page_inheritance_old = $row->page_inheritance;
        $page_version = $row->page_version;
        $page_current_version = $row->page_current_version;

        if ($page_inheritance_old == 'Top') {
            $data['parent_none'] = 1;
        } else {
            $data['limtePages'] = $this->pagemodel->getIntereatedpage($page_inheritance_old);
        }

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $page_title = $this->input->post('page_title');
            $page_content = $this->input->post('page_content');
            $page_status = $this->input->post('page_status');
            $page_parent_id = $this->input->post('page_parent_id');
            $page_inheritance = $this->input->post('page_inheritance');
            $user_account_types = $this->input->post('fk_user_account_type_id');
            $pk_category_id = $this->input->post('pk_category_id');
            $this->form_validation->set_rules('pk_category_id', 'Category', 'trim|required');
            
            $this->form_validation->set_rules('page_content', 'Content', 'trim|required|min_length[3]');


            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                
                $alias = strtolower($page_title_edit);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '-', $alias);

                $datas = array(
                    'page_title' => $page_title_edit.'_'.$page_version,
                    'page_alias' => $alias .'_'. $page_version,
                    'page_version' => $page_version,
                    'page_current_version' => 'False'
                );

                $this->db->where('pk_page_id', $page_id);
                $this->db->update('tbl_page', $datas);

                $alias = strtolower($page_title_edit);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '-', $alias);
                $version = ($page_version + 1);

                $dataIns = array(
                    'page_title' => $page_title_edit,
                    'page_alias' => $alias,
                    'page_content' => $page_content,
                    'page_status' => $page_status_edit,
                    'page_create_date' => date("Y-m-d H:i:s"),
                    'page_parent_id' => $page_parent_id_edit,
                    'page_inheritance' => $page_inheritance_edit,
                    'page_version' => $version,
                    'fk_category_id' => $pk_category_id,
                    'page_current_version' => 'True'
                );

                $this->db->insert('tbl_page', $dataIns);
				$fk_table_name_id							 = $this->db->insert_id(); 
                $where = array('fk_table_name_id ' => $page_id, 'relation_with_user_account_type_table_name ' => 'tbl_page');
                $this->db->where($where);
                $this->db->delete('tbl_relation_with_user_account_type');
                foreach ($user_account_types as $uat) {

                    $datas = array(
                        'relation_with_user_account_type_table_name' => 'tbl_page',
                        'fk_user_account_type_id' => $uat,
                        'fk_table_name_id' => $fk_table_name_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }
				
                $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Page Updated Successfully</div>');
                redirect(base_url('admin/pages/index'));
            }
        }


		$data['EditAccountType'] = $this->pagemodel->getEditAccountType($page_id);
        $data['content'] = $this->load->view('admin/pages/edit', $data, TRUE);
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


    //This function will check the inertance function from ajex call on page add
    public function inheritance($page_inheritance = '') {
        if ($page_inheritance == 'Top') {
            $data['parent_none'] = 1;
        } else {
            $data['limtePages'] = $this->pagemodel->getIntereatedpage($page_inheritance);
        }
        $this->load->view('admin/pages/parent_page', $data);
    }

    //This function will delete a specific record from DB
    public function delete($page_id = '', $page = 1, $limit = 10) {
        if ($page_id == '') {
            show_404();
        }
        $this->db->where('pk_page_id', $page_id);
        $this->db->delete('tbl_page');
		
		$where = array('fk_table_name_id ' => $page_id , 'relation_with_user_account_type_table_name ' => 'tbl_page');
		$this->db->where($where);
		$this->db->delete('tbl_relation_with_user_account_type');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Page Deleted Successfully</div>');
        redirect(base_url('admin/pages/index/' . $page . '/' . $limit));
    }

    //This function will change status of a page
    public function status($page_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($page_id == '' || $current_status == '') {
            show_404();
        }

        $data = array('status' => $current_status, 'updated_date_time' => date("Y-m-d H:i:s"));
        $this->db->where('page_id', $page_id);
        $this->db->update('pages', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Status Changed Successfully</div>');
        redirect(base_url('admin/pages/index/' . $page . '/' . $limit));
    }

}

/* Location: ./application/controllers/pages.php */