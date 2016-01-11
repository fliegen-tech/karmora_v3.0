<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menu extends CI_Controller {

    public $page = 'menu';
    protected $validate_video_id = '';
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
        $search_string = '';
        session_start();
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
        $this->page = 'menu';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/menumodel', 'commonmodel'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
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
            $banner = $this->menumodel->getSearch($page, $limit, $search_string);
        	$data['banner'] = $banner;

        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/menu/index');
        $data['paging'] = paging_generate($this->menumodel->getCountAllmenu($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/menu/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
		 }else{
			redirect(base_url('admin/menu/index'));
			 }
    }

    public function index($page = 1, $limit = 10) {
        $data['page'] = $this->page;
        $search_string = '';
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $menus = $this->menumodel->getAllMenu($page, $limit);

        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $menus = $this->menumodel->getSearch($page, $limit, $search_string);
        }

        $data['menus'] = $menus;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('menu/index');
        $data['paging'] = paging_generate($this->menumodel->getCountAllmenu($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;

        $data['content'] = $this->load->view('admin/menu/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will add a menu in DB
    public function add() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $menu_title = $this->input->post('menu_title');
            $menu_status = $this->input->post('menu_status');
            $menu_items_url = $this->input->post('menu_items_url');

            $this->form_validation->set_rules('menu_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('menu_items_url', 'Url', 'required');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $alias = strtolower($menu_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '_', $alias);

                $datas = array(
                    'menu_title' => $menu_title,
                    'menu_alias' => $alias,
                    'menu_items_url' => $menu_items_url,
                    'menu_status' => $menu_status,
                    'menu_create_date' => date("Y-m-d H:i:s")
                );


                $this->db->insert('tbl_menu', $datas);

                $data['successmessage'] = 'Menu Created Sucefully';
            }
        }
        $data['content'] = $this->load->view('admin/menu/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will add a menu item in DB
    public function itemadd() {
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['menulist'] = $this->menumodel->getmenulist();
        if (isset($_POST['submit'])) {

            $menu_items_title = $this->input->post('menu_items_title');
            $menu_items_status = $this->input->post('menu_items_status');
            $menu_items_inheritance = $this->input->post('menu_items_inheritance');
            $menu_items_parent_id = $this->input->post('menu_items_parent_id');
            $fk_menu_id = $this->input->post('fk_menu_id');
            $menu_item_position = $this->input->post('menu_item_position');
            $this->form_validation->set_rules('menu_items_title', 'Title', 'trim|required|is_unique[tbl_menu_items.menu_items_title]');
            $this->form_validation->set_rules('menu_item_position', 'Postion', 'trim|required|is_unique[tbl_menu_items.menu_item_position]');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $alias = strtolower($menu_items_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '_', $alias);

                $datas = array(
                    'menu_items_title' => $menu_items_title,
                    'menu_items_alias' => $alias,
                    'menu_items_status' => $menu_items_status,
                    'menu_items_inheritance' => $menu_items_inheritance,
                    'menu_items_parent_id' => $menu_items_parent_id,
                    'menu_item_position' => $menu_item_position,
                    'menu_items_create_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('tbl_menu_items', $datas);
                $fk_menu_item_id = $this->db->insert_id();
                $counter = count($fk_menu_id);

                for ($i = 0; $i < $counter; $i++) {
                    $dataM = array(
                        'fk_menu_item_id' => $fk_menu_item_id,
                        'fk_menu_id' => $fk_menu_id[$i],
                        'menu_item_to_menu_create_id' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_menu_item_to_menu', $dataM);
                }
                $data['successmessage'] = 'Menu Item Created Sucefully';
            }
        }
        $data['page'] = 'item';
        $data['content'] = $this->load->view('admin/menu/menu_item/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function edit($menu_id = '') {

        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['page'] = $this->page;

        if ($menu_id == '') {
            show_404();
            exit;
        }
        $menu_id = intval($menu_id);
        if ($menu_id == '') {
            show_404();
            exit;
        }
        #get the record from the database against the particular record
        $row = $this->menumodel->getmenuInfo($menu_id);
        if (empty($row)) {
            show_404();
            exit;
        }

        $data['menu_title'] = $row->menu_title;
        $data['menu_status'] = $row->menu_status;

        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $menu_title = $this->input->post('menu_title');
            $menu_status = $this->input->post('menu_status');

            $this->form_validation->set_rules('menu_title', 'Title', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $alias = strtolower($menu_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '_', $alias);

                $datas = array(
                    'menu_title' => $menu_title,
                    'menu_alias' => $alias,
                    'menu_status' => $menu_status,
                    'menu_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->where('pk_menu_id', $menu_id);
                $this->db->update('tbl_menu', $datas);

                $data['successmessage'] = 'Menu Updated Sucefully';
            }
        }


        $data['content'] = $this->load->view('admin/menu/edit', $data, TRUE);

        $this->load->view('admin/template', $data);
    }

    //this function will get the list of menu itme
    public function item($page = 1, $limit = 10) {
        $search_string = '';
        $data['page'] = $this->page;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $menuitms = $this->menumodel->getAllItemMenu($page, $limit);

        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $menuitms = $this->menumodel->getItemSearch($page, $limit, $search_string);
        }

        $data['menuitms'] = $menuitms;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('menu/item');
        $data['paging'] = paging_generate($this->menumodel->getCountAllitemmenu($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = 'item';
        $data['content'] = $this->load->view('admin/menu/menu_item/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will add a menu location in DB
    public function locationadd() {
        $data['page'] = $this->page;
        $data['UserAccountType'] = $this->menumodel->getUserAccountType();
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['menulist'] = $this->menumodel->getmenulist();
        $data['pagelist'] = $this->menumodel->getpagelist();
        $data['UserAccountType'] = $this->menumodel->getUserAccountType();
        if (isset($_POST['submit'])) {

            //$data['limtePages'] 	=  $this->pagemodel->getIntereatedpage($page_inheritance);
            $menu_location_title = $this->input->post('menu_location_title');
            $menu_location_status = $this->input->post('menu_location_status');
            $fk_page_id = $this->input->post('fk_page_id');
            $fk_menu_id = $this->input->post('fk_menu_id');
            $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');

            $this->form_validation->set_rules('menu_location_title', 'Title', 'trim|required');

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE) {
                
            } else {  // no errors now to save the data
                $alias = strtolower($menu_location_title);
                $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
                $alias = str_replace(array('\'', '"'), '', $alias);
                $alias = str_replace("\\", " ", $alias);
                $alias = str_replace("-", " ", $alias);
                $alias = str_replace("!", " ", $alias);
                $alias = str_replace(' ', '_', $alias);

                $datas = array(
                    'menu_location_title' => $menu_location_title,
                    'menu_location_alias' => $alias,
                    'menu_location_status' => $menu_location_status,
                    'fk_page_id' => $fk_page_id,
                    'fk_menu_id' => $fk_menu_id,
                    'menu_location_create_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('tbl_menu_location', $datas);
                $fk_table_name_id = $this->db->insert_id();
                $relation_with_user_account_type_table_name = 'tbl_menu_location';
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



                //$data['successmessage'] = 'Menu Location Created Sucefully';
				$_SESSION['successmessage'] = 'Menu Location Created Sucefully';
                redirect(base_url('admin/menu/location'));
            }
        }
        $data['page'] = 'location';
        $data['content'] = $this->load->view('admin/menu/location/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //this function will get the list of menu itme
    public function location($page = 1, $limit = 10) {
        $data['page'] = $this->page;
        $search_string = '';
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $menulocations = $this->menumodel->getAllItemMenuLocation($page, $limit);
        if (isset($_POST['search_me'])) {
            $search_string = $this->getSearchString();
            $menulocations = $this->menumodel->getMenuLocationSearch($page, $limit, $search_string);
        }

        $data['menulocations'] = $menulocations;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('menu/location');
        $data['paging'] = paging_generate($this->menumodel->getCountAllLocationmenu($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = 'location';
        $data['content'] = $this->load->view('admin/menu/location/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    //This function will check the inertance function from ajex call on page add
    public function inheritance($page_inheritance = '') {
        if ($page_inheritance == 'Top') {
            $data['parent_none'] = 1;
        } else {
            $data['limtePages'] = $this->menumodel->getIntereatedpage($page_inheritance);
        }
        $this->load->view('admin/menu/menu_item/parent_page', $data);
    }

    //This function will delete a specific record from DB
    public function delete($pk_menu_id = '', $page = 1, $limit = 10) {
        if ($pk_menu_id == '') {
            show_404();
        }
        $this->db->where('pk_menu_id', $pk_menu_id);
        $this->db->delete('tbl_menu');
        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Deleted Successfully</div>';
        redirect(base_url('admin/menu/index/' . $page . '/' . $limit));
    }

    //This function will change status of a page
    public function status($pk_menu_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_menu_id == '' || $current_status == '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('menu_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('menu_status' => 'Active');
        }

        $this->db->where('pk_menu_id', $pk_menu_id);
        $this->db->update('tbl_menu', $data);

        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Status Updated Successfully</div>';
        redirect(base_url('admin/menu/index/' . $page . '/' . $limit));
    }

    //This function will delete a specific record from DB
    public function itemdelete($pk_menu_items_id = '', $page = 1, $limit = 10) {
        if ($pk_menu_items_id == '') {
            show_404();
        }
        $this->db->where('pk_menu_items_id', $pk_menu_items_id);
        $this->db->delete('tbl_menu_items');

        $this->db->where('fk_menu_item_id', $pk_menu_items_id);
        $this->db->delete('tbl_menu_item_to_menu', $data);

        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Item Deleted Successfully</div>';
        redirect(base_url('admin/menu/item/' . $page . '/' . $limit));
    }

    //This function will change status of a page
    public function itemstatus($pk_menu_items_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_menu_items_id == '' || $current_status == '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('menu_items_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('menu_items_status' => 'Active');
        }
        $this->db->where('pk_menu_items_id', $pk_menu_items_id);
        $this->db->update('tbl_menu_items', $data);

        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Item Status Updated Successfully</div>';
        redirect(base_url('admin/menu/item/' . $page . '/' . $limit));
    }

    //This function will delete a specific record from DB
    public function locationdelete($pk_menu_location_id = '', $page = 1, $limit = 10) {
        if ($pk_menu_location_id == '') {
            show_404();
        }
        $this->db->where('pk_menu_location_id', $pk_menu_location_id);
        $this->db->delete('tbl_menu_location');
        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Item Deleted Successfully</div>';
        redirect(base_url('admin/menu/location/' . $page . '/' . $limit));
    }

    //This function will change status of a page
    public function locatiobstatus($pk_menu_location_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_menu_location_id == '' || $current_status == '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('menu_location_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('menu_location_status' => 'Active');
        }

        $this->db->where('pk_menu_location_id', $pk_menu_location_id);
        $this->db->update('tbl_menu_location', $data);

        $_SESSION['successmessage'] = '<div align="center" class="successmessage">Menu Item Status Updated Successfully</div>';
        redirect(base_url('admin/menu/location/' . $page . '/' . $limit));
    }

}

/* Location: ./application/controllers/pages.php */