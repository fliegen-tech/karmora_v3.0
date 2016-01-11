<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class store extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;
    public $page = 'store';

    public function __construct() {
        parent::__construct();
        /* session_start();
          if (!isset($_SESSION['user_id'])) {
          redirect(base_url('login'));
          exit;
          } */
        $this->data = "";
        $this->load->helper('url');
        $this->load->model(array('admin/storemodel', 'commonmodel'));
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->helper('string');
        $this->data = "";
        $this->page = 'store';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
///// note change the category ids in add.php of treading and store
    public function index($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $stores = $this->storemodel->getAllstore($page, $limit);
        $data['stores'] = $stores;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('store/index');
        $data['paging'] = paging_generate($this->storemodel->getCountAllStore(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['content'] = $this->load->view('admin/store/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }
	
	// change also the category id of treding store

    public function add() {
        $data['page'] = $this->page;
        $admin_treading_store_id = 5 ; // change the name of category id of treading which is in ur database
        $data['affilate'] = $this->storemodel->getAffiliate();
        $data['categories'] = $this->storemodel->getCategories($admin_treading_store_id);
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;

        //$data['admin_data_user'] =  $this->adminusermodel->getadmincategory($admin_category_name);
        //$data['user_id'] = '';
        if (isset($_POST['submit'])) {
			
            $this->form_validation->set_rules('fk_affiliate_network_id', 'Affiliate Network', 'trim|required');
            $this->form_validation->set_rules('categories', 'Category', 'required');
            $this->form_validation->set_rules('store_use_sid', 'Use Sid', 'trim|required');
            $this->form_validation->set_rules('store_status', 'Status', 'trim|required');
            $this->form_validation->set_rules('store_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('store_url', 'Url', 'required');

            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
                $store_use_sid = $this->input->post('store_use_sid');
                $categories = $this->input->post('categories');
                $store_status = $this->input->post('store_status');
                $store_title = $this->input->post('store_title');
			    $store_featured = $this->input->post('store_featured');
                $store_url = $this->input->post('store_url');
				$menu_items_inheritance = $this->input->post('menu_items_inheritance'); 
				
				if($menu_items_inheritance==5){
                	$uploadpath = './public/images/trending_store';
				}else{
					$uploadpath = './public/images/store';
					}
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000000';

                if ($_FILES["photo_file"]["name"] == '') {
                    $data['image_error'] = "please select a file to upload";
                } else {
                    $alias = strtolower($store_title);
                    $alias = preg_replace('!\s+!', ' ', $alias);
                    $alias = str_replace(' ', '_', $alias);
                    $datas = array(
                        'store_title' => $store_title,
                        'store_alias' => $alias,
                        'store_url' => $store_url,
                        'store_use_sid' => $store_use_sid,
						'store_featured' => $store_featured,
                        'store_status' => $store_status,
                        'fk_affiliate_network_id' => $fk_affiliate_network_id,
                        'store_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_store', $datas);
                    $store_id = $this->db->insert_id();
                    $photo_name = $store_title . '_' . $store_id;

                    foreach ($categories as $cat) {
                        $data = array(
                            'fk_store_id' => $store_id,
                            'fk_category_id' => $cat,
                            'store_to_category_relation_status' => 'Inactive',
                            'store_to_category_create_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('tbl_store_to_category', $data);
                    }
                   
                    $config['file_name'] = $photo_name;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('photo_file');
                    $uploaddata = $this->upload->data();
                    $datas = array(
                        'store_image' => $uploaddata['file_name']
                    );
                   
                    $this->db->where('pk_store_id', $store_id);
                    $this->db->update('tbl_store', $datas);
                    $config = array(
                        'source_image' => $uploaddata['full_path'],
                        'new_image' => $uploadpath . '\thumb',
                        'maintain_ratio' => true,
                        'height' => 40
                    );
                    //here is the second thumbnail, notice the call for the initialize() function again
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Added Successfully</div>');
                    redirect(base_url('admin/store/edit/' . $store_id));
                }
            }
        }

        $data['content'] = $this->load->view('admin/store/add', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    // edit
    public function edit($store_id) {
		$data['EditStoreType']   = $EditStoreType = $this->storemodel->getEditStoreType($store_id);
		print_r($data['EditStoreType']);
		$parent_id 			   	 = $EditStoreType[0]['category_parent_id'];
		$data['parent_id']	   	 =  $parent_id;
        $admin_treading_store_id = $parent_id ; // change the name of category id of treading which is in ur database
        $data['categories'] = $this->storemodel->getCategories($admin_treading_store_id);
        $data['store_id'] = $store_id;
		$data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['affilate'] = $this->storemodel->getAffiliate();
       
        $data['accounttypes'] = $this->storemodel->getAccountTypes($store_id);
        $data['account_to_stores'] = $this->storemodel->getAccountToStores($store_id);
        $data['categories_to_stores'] = $this->storemodel->getCategoryToStores($store_id);
        
        $data['controller']=$this;    
        $row = $this->storemodel->getStoreInfo($store_id); //die;
        if (empty($row)) {

            show_404();
        }

        $data['store_title'] = $row->store_title;
        $data['store_alias'] = $row->store_alias;
        $data['store_url'] = $row->store_url;
        $data['store_image'] = $store_image = $row->store_image;
        $data['store_use_sid'] = $row->store_use_sid;
        $data['store_status'] = $row->store_status;
		$data['store_featured'] = $row->store_featured;
        $data['affiliate_network_id'] = $row->fk_affiliate_network_id;
        $data['store_id'] = $store_id;
        //$data['user_id'] = '';
        if (isset($_POST['submit'])) {
            $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
            $categories_array = $this->input->post('categories_array');
            $store_use_sid = $this->input->post('store_use_sid');
            $store_status = $this->input->post('store_status');
            $store_title = $this->input->post('store_title');
            $store_url = $this->input->post('store_url');
			$store_featured = $this->input->post('store_featured');
            $datas = array(
                'store_title' => $store_title,
                'store_url' => $store_url,
				'store_featured' => $store_featured,
                'store_use_sid' => $store_use_sid,
                'fk_affiliate_network_id' => $fk_affiliate_network_id
            );
            $this->db->where('pk_store_id', $store_id);
            $this->db->update('tbl_store', $datas);
            $this->db->where('fk_store_id', $store_id);
            $this->db->delete('tbl_store_to_category');
            foreach ($categories_array as $cat) {
                        $datas = array(
                            'fk_store_id' => $store_id,
                            'fk_category_id' => $cat,
                            'store_to_category_relation_status' => 'Inactive',
                            'store_to_category_create_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('tbl_store_to_category', $datas);
                    }
            $data['categories_to_stores'] = $this->storemodel->getCategoryToStores($store_id);
			 
			if ($_FILES["photo_file"]["name"] != '') {
				$uploadpath = './public/images/store';
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000000';
				$photo_name = $store_title . '_' . $store_id;
				
				        $config['file_name'] = $photo_name;
						$this->load->library('upload', $config);
						$this->upload->do_upload('photo_file');
						$uploaddata = $this->upload->data();
						$datas = array(
							'store_image' => $uploaddata['file_name']
						);
					   
						$this->db->where('pk_store_id', $store_id);
						$this->db->update('tbl_store', $datas);
						$config = array(
							'source_image' => $uploaddata['full_path'],
							'new_image' => $uploadpath . '\thumb',
							'maintain_ratio' => true,
							'height' => 40,
						);
						//here is the second thumbnail, notice the call for the initialize() function again
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
			}
					
            $data['successmessage'] = 'Store  Updated Sucefully';
        }
        //$data['page'] = $this->page;
        
        $data['content'] = $this->load->view('admin/store/edit', $data, TRUE);
        
        $this->load->view('admin/template', $data);
    }

    public function in_array_r($needle, $haystack) {
    $found = false;
    foreach ($haystack as $item) {
    if ($item === $needle) { 
            $found = true; 
            break; 
        } elseif (is_array($item)) {
            unset($item['pk_store_to_category_id']);
            unset($item['fk_store_id']);
            $found = $this->in_array_r($needle, $item); 
            if($found) { 
                break; 
            } 
        }    
    }
    return $found;
}

	    //This function will check the inertance function from ajex call on page add
    public function StoreType($parent_id = '') {
        $data['categories'] = $this->storemodel->getStoretype($parent_id);
        $this->load->view('admin/store/parent_page', $data);
    }


    public function assign_accounttype() {

        if (isset($_POST['submit'])) {
            $store_id = $this->input->post('store_id');
            $account_type = $this->input->post('account_type');
            $com_per = $this->input->post('com_per');

            if ($account_type != "" AND $com_per != "") {
                $datas = array(
                    'fk_store_id' => $store_id,
                    'fk_user_account_type_id' => $account_type,
                    'store_to_user_account_type_commission_percentage' => $com_per,
                    'store_to_user_account_type_relation_status' => 'Active',
                    'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_store_to_user_account_type', $datas);

                $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Account Type Assigned Successfully</div>');
            } else {

                $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Account Type was not assigned </div>');
            }
        }
        redirect(base_url('admin/store/edit/' . $store_id));
    }

    //////////////////////////deleta function start ///////////

    public function delete($pk_store_id = '', $image = '', $page = 1, $limit = 10) {

        if ($pk_store_id == '') {
            show_404();
        }
        unlink(FCPATH . 'public/images/store/' . $image);
        unlink(FCPATH . 'public/images/store/thumb/' . $image);
        $this->db->where('fk_store_id', $pk_store_id);
        $this->db->delete('tbl_store_to_category');
        $this->db->where('fk_store_id', $pk_store_id);
        $this->db->delete('tbl_store_to_user_account_type');
        $this->db->where('pk_store_id', $pk_store_id);
        $this->db->delete('tbl_store');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Deleted Successfully</div>');
        redirect(base_url('admin/store/index/' . $page . '/' . $limit));
    }

    public function delete_account($pk_store_to_user_account_type_id, $store_id) {

        if ($pk_store_to_user_account_type_id == '') {
            show_404();
        }
        $this->db->where('pk_store_to_user_account_type_id', $pk_store_to_user_account_type_id);
        $this->db->delete('tbl_store_to_user_account_type');
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info"> Deleted Successfully</div>');
        redirect(base_url('admin/store/edit/' . $store_id));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function change_visibility_option($pk_store_to_category_id,$store_id,$current_status) {
        if ($pk_store_to_category_id == '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('store_to_category_relation_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('store_to_category_relation_status' => 'Active');
        }

        $this->db->where('pk_store_to_category_id', $pk_store_to_category_id);
        $this->db->update('tbl_store_to_category', $data);

        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Visibility Option Changed Successfully</div>');
        redirect(base_url('admin/store/edit/' . $store_id));
    }
    
    public function changestatus($pk_store_id = '', $current_status = '', $page = 1, $limit = 10) {
        if ($pk_store_id == '' || $current_status == '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('store_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('store_status' => 'Active');
        }

        $this->db->where('pk_store_id', $pk_store_id);
        $this->db->update('tbl_store', $data);

        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Status Changed Successfully</div>');
        redirect(base_url('admin/store/index/' . $page . '/' . $limit));
    }

}
