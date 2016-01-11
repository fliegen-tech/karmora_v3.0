<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class managestore extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;
    public $page = 'store';

    public function __construct() {
        parent::__construct();
        session_start();
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

    /**
     * This is  function of a seraching 
     */
    public function getSearchString($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['search_me']) && ($_POST['search_me'] != '')) {
            $search_string = $_POST['search'];
            $stores = $this->storemodel->getSearch($page, $limit, $search_string);
            $data['stores'] = $stores;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/managestore/index');
            $data['paging'] = paging_generate($this->storemodel->getCountSerchstore($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;

            $data['content'] = $this->load->view('admin/store/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/managestore/index'));
        }
    }

    ///// note change the category ids in add.php of treading and store
    public function index() {


        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['content'] = $this->load->view('admin/store/grid', $data, TRUE);
        $this->load->view('admin/template', $data);
    }
    
    public function getstores(){
        $data =array();
         
         $data['data']  = $this->storemodel->getAllstore();
         
         //$data['data']  =  $sales;
         echo json_encode($data); die;
    }

    // change also the category id of treding store

    public function add() {
        $data['page'] = $this->page;
        $admin_treading_store_id = 5; // change the name of category id of treading which is in ur database
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
            $this->form_validation->set_rules('coupon_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('store_url', 'Url', 'required');
            $this->form_validation->set_rules('image_name', 'Image Name', 'required');
            $this->form_validation->set_rules('image_title', 'Image Title', 'required');
            $this->form_validation->set_rules('image_alt', 'Image Alt', 'required');
            $this->form_validation->set_rules('about_store', 'About Store', 'required');

            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
                $store_use_sid = $this->input->post('store_use_sid');
                $categories = $this->input->post('categories');
                $store_status = $this->input->post('store_status');
                $store_title = $this->input->post('store_title');
                $coupon_title = $this->input->post('coupon_title');
                $image_name = $this->input->post('image_name');
//                $store_featured = $this->input->post('store_featured');
                $store_url = $this->input->post('store_url');
                $web_url = $this->input->post('web_url');
                $image_title = $this->input->post('image_title');
                $image_alt = $this->input->post('image_alt');
                $about_store = $this->input->post('about_store');
                $menu_items_inheritance = $this->input->post('menu_items_inheritance');
                //var_dump($menu_items_inheritance); exit;
                if ($menu_items_inheritance == 5) {
                    $uploadpath = './public/images/trending_store';
                } else if($menu_items_inheritance === '6') {
                    $uploadpath = './public/images/store';
                }
                else if($menu_items_inheritance === '73') {
                    $uploadpath =   './public/images/special_deals';
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
                        'coupon_title' => $coupon_title,
                        'store_alias' => $alias,
                        'store_url' => $store_url,
                        'web_url' => $web_url,
                        'store_image_title' => $image_title,
                        'store_image_alt' => $image_alt,
                        'store_about' => $about_store,
                        'store_use_sid' => $store_use_sid,
//                        'store_featured' => $store_featured,
                        'store_status' => $store_status,
                        'fk_affiliate_network_id' => $fk_affiliate_network_id,
                        'store_create_date' => date("Y-m-d H:i:s")
                    );
                    
                    $this->db->insert('tbl_store', $datas);
                    $store_id = $this->db->insert_id();
                    $photo_name = $image_name . '_' . $store_id;

                    foreach ($categories as $cat) {
                        $data = array(
                            'fk_store_id' => $store_id,
                            'fk_category_id' => $cat,
                            /* 'store_to_category_relation_status' => 'Inactive', */
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
                        'new_image' => $uploadpath . '/thumb',
                        'maintain_ratio' => false,
                        'height' => 158,
                        'width' => 158
                    );
                    //here is the second thumbnail, notice the call for the initialize() function again
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    //$_SESSION['successmessage'] = 'Store Added Successfully';
                    $_SESSION['successmessage'] = '<div class="alert alert-info">Store Added Successfully</div>';
                    // $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Added Successfully</div>');
                    redirect(base_url('admin/managestore/edit/' . $store_id));
                }
            }
        }

        $data['content'] = $this->load->view('admin/store/add', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    // edit
    public function edit($store_id) {
        $data['EditStoreType'] = $EditStoreType = $this->storemodel->getEditStoreType($store_id);
        //print_r($data['EditStoreType']);
        $parent_id = $EditStoreType[0]['category_parent_id'];
        $data['parent_id'] = $parent_id;
        $admin_treading_store_id = $parent_id; // change the name of category id of treading which is in ur database
        $data['categories'] = $this->storemodel->getCategories($admin_treading_store_id);
        $data['store_id'] = $store_id;
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['affilate'] = $this->storemodel->getAffiliate();
        $data['accounttypes'] = $this->storemodel->getAccountTypes($store_id);
        $data['account_to_stores'] = $this->storemodel->getAccountToStores($store_id);

        $have = array();
        foreach ($data['account_to_stores'] as $sto) {

            $have[] = $sto['fk_user_account_type_id'];
        }

        $data['have'] = $have;
        $data['categories_to_stores'] = $this->storemodel->getCategoryToStores($store_id);

        $data['controller'] = $this;
        $row = $this->storemodel->getStoreInfo($store_id); //die;
        if (empty($row)) {

            show_404();
        }
        
        $data['store_title'] = $row->store_title;
        $data['coupon_title'] = $row->coupon_title;
        $data['store_alias'] = $row->store_alias;
        $data['web_url'] = $row->web_url;
        $data['store_url'] = $row->store_url;
        $data['image_title'] = $row->store_image_title;
        $data['image_alt'] = $row->store_image_alt;
        $data['store_image'] = $store_image = $row->store_image;
        $data['store_use_sid'] = $row->store_use_sid;
        $data['store_status'] = $row->store_status;
        $data['about_store'] = $row->store_about;
        $data['store_featured'] = $row->store_featured;
        $data['affiliate_network_id'] = $row->fk_affiliate_network_id;
        $data['store_id'] = $store_id;
        //$data['user_id'] = '';
        

        if (isset($_POST['submit'])) {
            
            $this->form_validation->set_rules('store_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('coupon_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('store_url', 'Url', 'required');
            $this->form_validation->set_rules('image_title', 'Image Title', 'required');
            $this->form_validation->set_rules('image_alt', 'Image Alt', 'required');
            $this->form_validation->set_rules('about_store', 'About Store', 'required');

            if ($this->form_validation->run() == FALSE) {
                
            } else {

                $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
                $categories_array = $this->input->post('categories_array');
                $store_use_sid = $this->input->post('store_use_sid');
                $store_status = $this->input->post('store_status');
                $store_title = $this->input->post('store_title');
                $web_url = $this->input->post('web_url');
                $coupon_title = $this->input->post('coupon_title');
                $store_url = $this->input->post('store_url');
                $store_featured = $this->input->post('store_featured');
                $image_title = $this->input->post('image_title');
                $image_alt = $this->input->post('image_alt');
                $about_store = $this->input->post('about_store');
                $datas = array(
                    'store_title' => $store_title,
                    'coupon_title' => $coupon_title,
                    'store_url' => $store_url,
                    'web_url' => $web_url,
                    'store_featured' => $store_featured,
                    'store_image_title' => $image_title,
                    'store_image_alt' => $image_alt,
                    'store_about' => $about_store,
                    'store_use_sid' => $store_use_sid,
                    'fk_affiliate_network_id' => $fk_affiliate_network_id
                );
                
                
                $this->db->where('pk_store_id', $store_id);
                $this->db->update('tbl_store', $datas);
                $this->load->model('admin/coupansmodel');
                $this->coupansmodel->removeConflict($datas);
                $this->db->where('fk_store_id', $store_id);
                //$this->db->delete('tbl_store_to_category');
//                echo "<pre>";
//                print_r($categories_array);
//                $where  =   "fk_store_id = $store_id";
//                $this->db->delete('tbl_store_to_category', $where);
//                foreach ($categories_array as $cat) {
//                    $this->storemodel->updateCategory($cat,$store_id);
//                }
//                exit;
                $where  =   "fk_store_id = $store_id";
                $this->db->delete('tbl_store_to_category', $where);
                foreach ($categories_array as $cat) {
                    //if(!$this->storemodel->getStoreToCatRelation($store_id, $cat))
                    //{
                        
                        $datas = array(
                            'fk_store_id' => $store_id,
                            'fk_category_id' => $cat,
                            /* 'store_to_category_relation_status' => 'Active', */
                            'store_to_category_create_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('tbl_store_to_category', $datas);
                    //}
                    //echo "<pre>";
                    //print_r($datas);
                    
                }
                
                $data['categories_to_stores'] = $this->storemodel->getCategoryToStores($store_id);
                
                if ($change_name = $this->input->post('change_name') == 1) {
                    $this->form_validation->set_rules('image_name', 'Image Name', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        
                    } else {
                        $image_name = $this->input->post('image_name');

                        if ($_FILES["photo_file"]["name"] != '') {
                            
                            $menu_items_inheritance = $this->input->post('menu_items_inheritance');
                            if ($menu_items_inheritance == 5) {
                                $uploadpath = './public/images/trending_store';
                            } else if($menu_items_inheritance === '6') {
                                $uploadpath = './public/images/store';
                            }
                            else if($menu_items_inheritance === '73') {
                                $uploadpath =   './public/images/special_deals/';
                            }
                            
                            
                            $config['upload_path'] = $uploadpath;
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['max_size'] = '10000000';
                            $photo_name = $image_name . '_' . $store_id;
                            
                            $config['file_name'] = $photo_name;
                            $this->load->library('upload', $config);
                            $this->upload->do_upload('photo_file');
                            $uploaddata = $this->upload->data();
                            
                            
                            $datas = array(
                                'store_image' => $uploaddata['file_name']
                            );

                            $this->db->where('pk_store_id', $store_id);
                            $this->db->update('tbl_store', $datas);
                            
                            $thumb = array(
                                'source_image' => $uploaddata['full_path'],
                                'new_image' => $uploadpath . '\thumb',
                                'maintain_ratio' => false,
                                'height' => 158,
                                'width' => 158
                            );
                            
                            //here is the second thumbnail, notice the call for the initialize() function again
                            $this->image_lib->initialize($thumb);
                            $this->image_lib->resize();
                            
                            //$data['store_image'] = $uploaddata['file_name'];
                            
                            
                        }
                    }
                }
                $data['successmessage'] = 'Store  Updated Sucefully';
                
            }
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
                if ($found) {
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
                
                
                //var_dump($account_type);exit;
                if ($account_type === '1') {

                    $AccTypeArr = array(1, 2, 5, 8, 10);
                    foreach ($AccTypeArr as $acType) {
                        if (!$this->storemodel->getStoreToAccTypeRelation($store_id, $acType)) {
                            $data = array(
                                'fk_store_id' => $store_id,
                                'fk_user_account_type_id' => $acType,
                                'store_to_user_account_type_commission_percentage' => $com_per,
                                'store_to_user_account_type_relation_status' => 'Active',
                                'store_to_user_account_type_create_date' => date("Y-m-d H:i:s"));
                            $this->db->insert('tbl_store_to_user_account_type', $data);
                        }else{
                            $data = array();
                            $data['store_to_user_account_type_commission_percentage'] = $com_per;
                            $data['store_to_user_account_type_create_date']           = date("Y-m-d H:i:s");
                            
                            $this->db->where(array('fk_store_id' => $store_id,'fk_user_account_type_id' => $acType));
                            $this->db->update('tbl_store_to_user_account_type',$data);
                        }
                    }

//                    $datas = array(array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 1,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                        ),
//                        array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 2,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                        ),
//                        array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 5,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                        ),
//                        array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 8,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                        ),
//                    );
                } elseif ($account_type === '2') {
                    $AccTypeArr = array(6, 7,9);
                    foreach ($AccTypeArr as $acType) {
                        if (!$this->storemodel->getStoreToAccTypeRelation($store_id, $acType)) {
                            $data = array(
                                'fk_store_id' => $store_id,
                                'fk_user_account_type_id' => $acType,
                                'store_to_user_account_type_commission_percentage' => $com_per,
                                'store_to_user_account_type_relation_status' => 'Active',
                                'store_to_user_account_type_create_date' => date("Y-m-d H:i:s"));
                            $this->db->insert('tbl_store_to_user_account_type', $data);
                        }else{
                            $data = array();
                            $data['store_to_user_account_type_commission_percentage'] = $com_per;
                            $data['store_to_user_account_type_create_date']           = date("Y-m-d H:i:s");
                            
                            $this->db->where(array('fk_store_id' => $store_id,'fk_user_account_type_id' => $acType));
                            $this->db->update('tbl_store_to_user_account_type',$data);
                        }
                    }

//                    $datas = array(array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 6,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                        ),
//                        array(
//                            'fk_store_id' => $store_id,
//                            'fk_user_account_type_id' => 7,
//                            'store_to_user_account_type_commission_percentage' => $com_per,
//                            'store_to_user_account_type_relation_status' => 'Active',
//                            'store_to_user_account_type_create_date' => date("Y-m-d H:i:s")
//                    ));
                }

                //$this->db->insert_batch('tbl_store_to_user_account_type', $datas);
                $_SESSION['successmessage'] = 'Account Type Assigned Successfully';
                //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Account Type Assigned Successfully</div>');
            } else {
                $_SESSION['successmessage'] = 'Account Type was not assigned';
                //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Account Type was not assigned </div>');
            }
        }
        redirect(base_url('admin/managestore/edit/' . $store_id));
    }

    //////////////////////////deleta function start ///////////

    public function delete($pk_store_id = '', $image = '') {

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
        $_SESSION['successmessage'] = 'Store Deleted Successfully';exit;
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Deleted Successfully</div>');
        //redirect(base_url('admin/managestore/index/' . $filter . '/' . $page . '/' . $limit));
    }

    public function delete_account($pk_store_to_user_account_type_id, $store_id) {

        if ($pk_store_to_user_account_type_id == '') {
            show_404();
        }
        $this->db->where('pk_store_to_user_account_type_id', $pk_store_to_user_account_type_id);
        $this->db->delete('tbl_store_to_user_account_type');
        $_SESSION['successmessage'] = 'Deleted Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info"> Deleted Successfully</div>');
        redirect(base_url('admin/managestore/edit/' . $store_id));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function change_visibility_option($pk_store_to_category_id, $store_id, $current_status) {
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

        $_SESSION['successmessage'] = 'Visibility Option Changed Successfully';
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Visibility Option Changed Successfully</div>');
        redirect(base_url('admin/managestore/edit/' . $store_id));
    }

    public function changestatus($pk_store_id = '', $current_status = '') {
        
        if ($pk_store_id == '' || $current_status == '') {
            show_404();
        }
        if ($current_status === "active") {
            $data = array('store_status' => 'Inactive');
            $msg  = 'Inactive';
        } else if ($current_status === "inactive") {
            $data = array('store_status' => 'Active');
            $msg  = 'Active';
        }

        $this->db->where('pk_store_id', $pk_store_id);
        $this->db->update('tbl_store', $data);
        echo $msg;exit;
        //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Store Status Changed Successfully</div>');
        //redirect(base_url('admin/managestore/index/' . $filter . '/' . $page . '/' . $limit));
    }

    public function filterStore($page = 1, $limit = 20, $ajexcall = '') {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if ($ajexcall != '') {
            $stores = $this->storemodel->getfilterStore($page, $limit, $ajexcall);
            $data['stores'] = $stores;
            echo $data['content'] = $this->load->view('admin/store/grid', $data, TRUE);
            echo $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            echo $this->load->view('admin/template', $data);
            die;
        }
    }

}
