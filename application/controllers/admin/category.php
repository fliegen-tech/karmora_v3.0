<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author usman
 */
class Category extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;
    public $page = 'category';

    public function __construct() {
	session_start();
        parent::__construct();
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');
	$this->load->model(array('admin/categoryModel', 'commonmodel'));
        $this->load->helper('paging');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }
	
   

    public function index($filter="") {
		
	if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $data['page'] = $this->page;
        
        $categoryData = $this->categoryModel->getCategoryList($filter);
	$data['parrent_cats'] = $this->categoryModel->getParrents();
		
        $data['catData'] = $categoryData;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/category/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function addCategory() {
        $this->load->library('form_validation');
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $this->load->model('admin/categoryModel');
        $data['catData'] = $this->categoryModel->getParrents();
        $data['UserAccountType'] = $this->categoryModel->getUserAccountType();
        $data['content'] = $this->load->view('admin/category/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        if (isset($_POST['action']) && $this->input->post('action') === 'add_category') {
            
            $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
            $this->form_validation->set_rules('fk_user_account_type_id', 'User Account Type', 'required');
            $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
            if ($this->form_validation->run() === FALSE) {
                
            } else {
                $formData = $this->input->post();
                $last_id    =   $this->categoryModel->addCategory($formData);
                
                // image uplaoding
                echo $last_id;
                echo "<pre>";
                print_r($_FILES); 
                $exploded   = explode("/", $_FILES['cat_image']['type']);
                
                $photo_name = $this->input->post('cat_name') . '_' . $last_id;
                 
                 $uploadpath = './public/images/categories';
                 
                 $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000000';
                 $config['file_name'] = $photo_name;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('cat_image');
                    $uploaddata = $this->upload->data();
                    
                    $filename   =   $uploaddata['file_name'];
                    $filename   =   $filename;
                    $datas = array(
                        'category_image' => $filename
                    );
                    $this->db->where('pk_category_id', $last_id);
                    $this->db->update('tbl_category', $datas);
                   
                // image uploading  ends here
                
                $fk_table_name_id = $this->db->insert_id();
                $relation_with_user_account_type_table_name = 'tbl_category';
                $fk_user_account_type_id;
                foreach ($fk_user_account_type_id as $ac) {
                    $datas = array(
                        'relation_with_user_account_type_table_name' => $relation_with_user_account_type_table_name,
                        'fk_user_account_type_id' => $ac['fk_user_account_type_id'],
                        'fk_table_name_id' => $fk_table_name_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }
                redirect('admin/category/index');
            }
        }
        $this->load->view('admin/template', $data);
    }
	
    public function in_array_r($needle, $haystack) {
        $found = false;
        if(!empty($haystack)){
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
        }
        return $found;
    }

    public function status($pk_category_id = '', $current_status = '',$filter="") {
        if ($pk_category_id === '' || $current_status === '') {
            show_404();
        }
        if ($current_status === "Active") {
            $data = array('category_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('category_status' => 'Active');
        }
        $this->db->where('pk_category_id', $pk_category_id);
        $this->db->update('tbl_category', $data);
        redirect(base_url('admin/category/index/'.$filter));
    }

    public function delete($pk_category_id = '',$filter="") {
        if ($pk_category_id == '') {
            show_404();
        }
        $this->db->where('pk_category_id', $pk_category_id);
        $this->db->delete('tbl_category');
        $where = array('fk_table_name_id ' => $pk_category_id, 'relation_with_user_account_type_table_name ' => 'tbl_category');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type');

         redirect(base_url('admin/category/index/'.$filter));
    }

    public function editCategory($id) {
        $data['controller']=$this;   
        $this->load->library('form_validation');
        $data['header'] = $this->header;
        $data['class'] = "active-category";
        $data['footer'] = $this->footer;
        $this->load->model('admin/categoryModel');
        $data['UserAccountType'] = $this->categoryModel->getUserAccountType();
       
        $editrow = $this->categoryModel->getById($id);
        $data['EditAccountType'] = $this->categoryModel->getEditAccountType($id);
        
        
        
        $data['category_title'] = $category_title_edit = $editrow->category_title;
        $data['category_id'] = $id;
        $data['category_status'] = $category_status_edit = $editrow->category_status;
        $data['category_description']   =   $category_status_edit   =   $editrow->category_description;
        $data['cat_image']  =   $category_status_edit   =   $editrow->category_image;
        $this->form_validation->set_rules('fk_user_account_type_id','Account Types','required');
        
        $data['content'] = $this->load->view('admin/category/edit', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        if (isset($_POST['action']) && $this->input->post('action') === "edit_category") {
            
            $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
            if ($this->form_validation->run() === FALSE) {
                //echo "false"; exit;
            } else {
//                echo "<pre>";
//                print_r($_POST); exit;
                $user_account_types = $this->input->post('fk_user_account_type_id');
                $formData = $this->input->post();
                $this->categoryModel->editCategory($id, $formData);
                $where = array('fk_table_name_id ' => $id, 'relation_with_user_account_type_table_name ' => 'tbl_category');
               
                $this->db->where($where);
                $this->db->delete('tbl_relation_with_user_account_type');
                foreach ($user_account_types as $uat){
                    
                   $datas = array(
                            'relation_with_user_account_type_table_name' => 'tbl_category',
                            'fk_user_account_type_id' => $uat,
                            'fk_table_name_id' => $id,
                            'relation_with_user_account_type_status' => 'Active',
                            'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('tbl_relation_with_user_account_type', $datas);
                    
                }
                if(isset($_FILES) && $_FILES['cat_image']['name']    !== "") {
                    // image uplaoding
                
                $exploded   = explode("/", $_FILES['cat_image']['type']);
                if($exploded[1] === "jpeg") {
                    $exploded[1] = "jpg";
                }
                $photo_name = $this->input->post('cat_name') . '_' . $id;
                // echo $photo_name; exit;
                 $uploadpath = './public/images/categories';
                 
                 $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000000';
                 $config['file_name'] = $photo_name.".".$exploded[1];
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('cat_image');
                    $uploaddata = $this->upload->data();
                    //echo "<pre>";
                    //print_r($uploaddata);
                    
                    $filename   =   $uploaddata['file_name'];
                    
                    $filename   =   $filename;
                   // echo $filename; exit;
                    $datas = array(
                        'category_image' => $filename
                    );
                    $this->db->where('pk_category_id', $id);
                    $this->db->update('tbl_category', $datas);
                   
                // image uploading  ends here
                }
                
                 redirect(base_url('admin/category/index'));
            }
        }
        $this->load->view('admin/template', $data);
    }

}
