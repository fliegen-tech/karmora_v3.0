<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class banner extends CI_Controller {

    public $page = 'banner';
    protected $validate_banner_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model(array('admin/bannerModel', 'commonmodel'));
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->helper('string');
        $this->data = "";
        $this->page = 'banner';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');
        $this->load->helper('paging');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

   
    /**
     * This is the default function of a controller 
     */
    public function index() {
        
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $banner = $this->bannerModel->getAllbanner();
        
        $data['banner'] = $banner;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        $data['content'] = $this->load->view('admin/banner/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
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

    public function add() {

        $data['page'] = $this->page;
        $data['affilate'] = $this->bannerModel->getAffiliate();
        $data['UserAccountType'] = $this->bannerModel->getUserAccountType();
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;

        if (isset($_POST['submit'])) {

            $banner_ads_banner_type = $this->input->post('banner_ads_banner_type');
            $this->form_validation->set_rules('banner_ads_banner_type', 'Banner Type', 'trim|required');
            $this->form_validation->set_rules('banner_ads_use_sid', 'Use Sid', 'trim|required');
            $this->form_validation->set_rules('banner_ads_status', 'Status', 'trim|required');
            $this->form_validation->set_rules('fk_user_account_type_id', 'User Account', 'required');
            $this->form_validation->set_rules('banner_ads_position', 'Postion', 'is_unique[tbl_banner_ads.banner_ads_position]');
            $this->form_validation->set_rules('banner_ads_title', 'Title', 'trim|required|is_unique[tbl_banner_ads.banner_ads_title]');
            if ($banner_ads_banner_type == 'Slider') {
                $this->form_validation->set_rules('photo_file', 'Image', 'callback_slider_upload');
            }
            $banner_ads_use_sid = $this->input->post('banner_ads_use_sid');
            $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
            if (($fk_affiliate_network_id == '0') || ($fk_affiliate_network_id == '')) {
                $this->form_validation->set_rules('banner_ads_redirect_url', 'Url', 'required');
            }
            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $banner_ads_banner_type = $this->input->post('banner_ads_banner_type');
                $banner_ads_use_sid = $this->input->post('banner_ads_use_sid');
                $banner_ads_status = $this->input->post('banner_ads_status');
                $banner_ads_title = $this->input->post('banner_ads_title');
                $fk_affiliate_network_id = $this->input->post('fk_affiliate_network_id');
                $banner_ads_redirect_url = $this->input->post('banner_ads_redirect_url');
                $banner_ads_alt = $this->input->post('banner_ads_alt');
		$banner_ads_position = $this->input->post('banner_ads_position');


                $uploadpath = './public/images/banner';
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000000';

                if ($_FILES["photo_file"]["name"] == '') {
                    $data['image_error'] = "please select a file to upload";
                } else {

                    $datas = array(
                        'banner_ads_title' => $banner_ads_title,
                        'banner_ads_alt' => $banner_ads_alt,
                        'banner_ads_redirect_url' => $banner_ads_redirect_url,
                        'banner_ads_status' => $banner_ads_status,
                        'banner_ads_banner_type' => $banner_ads_banner_type,
                        'fk_affiliate_network_id' => $fk_affiliate_network_id,
                        'banner_ads_use_sid' => $banner_ads_use_sid,
                        'banner_ads_position' => $banner_ads_position,
                        'banner_ads_create_date' => date("Y-m-d H:i:s")
                    );
                    $insertId = $this->bannerModel->add($datas);

                    //$this->db->insert('tbl_banner_ads', $datas);
                    $photo_name = $banner_ads_title . '_' . $insertId;
                    $config['file_name'] = $photo_name;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('photo_file');
                    $uploaddata = $this->upload->data();
                    $dataI = array(
                        'banner_ads_image' => $uploaddata['file_name']
                    );
                    $this->db->where('pk_banner_ads_id', $insertId);
                    $this->db->update('tbl_banner_ads', $dataI);
                    $config = array(
                        'source_image' => $uploaddata['full_path'],
                        'new_image' => $uploadpath . '\thumb',
                        'maintain_ratio' => true,
                        'height' => 200
                    );
                    //here is the second thumbnail, notice the call for the initialize() function again
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $fk_table_name_id = $insertId;
                    $relation_with_user_account_type_table_name = 'tbl_banner_ads';
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
                    $data['successmessage'] = 'Banner Created Sucefully';
                    redirect('admin/banner/index');
                }
            }
        }
        //$data['page'] = $this->page;
        $data['content'] = $this->load->view('admin/banner/add', $data, TRUE);

        $this->load->view('admin/template', $data);
    }

    // edit
    public function edit($pk_banner_ads_id) {
	$data['controller']=$this;
        $data['page'] = $this->page;
        $data['header'] = $this->load->view('admin/header', $this->data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $data['template'] = $this->load->view('admin/template', $this->data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $this->data, TRUE);
        $data['UserAccountType'] = $this->bannerModel->getUserAccountType();
        $data['affilate']        = $this->bannerModel->getAffiliate();
        $data['EditAccountType'] = $this->bannerModel->getEditAccountType($pk_banner_ads_id);
        

        $row = $this->bannerModel->getEditBanner($pk_banner_ads_id); //die;
        if (empty($row)) {

            show_404();
        }

        $data['banner_ads_use_sid'] = $row->banner_ads_use_sid;
        $data['banner_ads_image'] = $row->banner_ads_image;
        $data['banner_ads_banner_type'] = $row->banner_ads_banner_type;
        $data['banner_ads_title'] = $banner_ads_title = $row->banner_ads_title;
    	$data['banner_ads_alt'] = $banner_ads_alt = $row->banner_ads_alt;
	$data['banner_ads_redirect_url'] = $banner_ads_redirect_url = $row->banner_ads_redirect_url;
        $data['banner_ads_postion'] = $banner_ads_postion = $row->banner_ads_position;
        
         $this->validate_banner_id = $pk_banner_ads_id;
        
        if (isset($_POST['submit'])) {
	    $this->form_validation->set_rules('fk_user_account_type_id', 'User Account', 'required');
            $this->form_validation->set_rules('banner_ads_postion', 'Postion', 'callback_duplicate_postion_check');
            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run() == FALSE) {
                 echo 123;die;
            } else { // no errors now to save the data
            
            $banner_ads_use_sid = $this->input->post('banner_ads_use_sid');
            $user_account_types = $this->input->post('fk_user_account_type_id');
	    $banner_ads_redirect_url = $this->input->post('banner_ads_redirect_url');
            $banner_ads_postion = $this->input->post('banner_ads_postion');
            $datas = array(
                'banner_ads_use_sid' => $banner_ads_use_sid,
                'banner_ads_position' => $banner_ads_postion,
                'banner_ads_redirect_url' => $banner_ads_redirect_url,
                'banner_ads_create_date' => date("Y-m-d H:i:s")
            );
            $this->db->where('pk_banner_ads_id', $pk_banner_ads_id);
            $this->db->update('tbl_banner_ads', $datas);
            $where = array('fk_table_name_id ' => $pk_banner_ads_id, 'relation_with_user_account_type_table_name ' => 'tbl_banner_ads');
            $this->db->where($where);
            $this->db->delete('tbl_relation_with_user_account_type');
            foreach ($user_account_types as $uat) {

                $datas = array(
                    'relation_with_user_account_type_table_name' => 'tbl_banner_ads',
                    'fk_user_account_type_id' => $uat,
                    'fk_table_name_id' => $pk_banner_ads_id,
                    'relation_with_user_account_type_status' => 'Active',
                    'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_relation_with_user_account_type', $datas);
            }

            $data['EditAccountType'] = $this->bannerModel->getEditAccountType($pk_banner_ads_id);
            $data['successmessage'] = 'Banner Status Updated Sucefully';
            }
        }
        //$data['page'] = $this->page;

        $this->load->view('admin/banner/edit', $data);
    }

    // this function upload a fix width and height for slider

    function slider_upload($width, $height) {
        if (isset($_FILES['photo_file']) && !empty($_FILES['photo_file']['name'])) {
            list($width, $height, $type, $attr) = getimagesize($_FILES['photo_file']['tmp_name']);

            if ($width == 635 && $height == 319) {
                return true;
            } else {
                $this->form_validation->set_message('slider_upload', "Please select image size of 635 x 319.");
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('slider_upload', "Image is required!");
            return false;
        }
    }
 //////////////////////////deleta function start ///////////

    public function delete($pk_banner_ads_id = '', $image = '') {

        if ($pk_banner_ads_id == '') {
            show_404();
        }

        unlink(FCPATH . 'public/images/banner/' . $image);
        unlink(FCPATH . 'public/images/banner/thumb/' . $image);
        $this->db->where('pk_banner_ads_id', $pk_banner_ads_id);
        $this->db->delete('tbl_banner_ads');
        $where = array('fk_table_name_id ' => $pk_banner_ads_id, 'relation_with_user_account_type_table_name ' => 'tbl_banner_ads');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type');

        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Banner Deleted Successfully</div>');
        redirect(base_url('admin/banner/index/'));
    }

    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($pk_banner_ads_id = '', $current_status = '') {
       if ($pk_banner_ads_id == '' || $current_status == '') {
            show_404();
        }
        $status = 1;

        if ($current_status == 1) {
            $status = 0;
        }
        $data = array('banner_ads_status' => $status);
        $this->db->where('pk_banner_ads_id', $pk_banner_ads_id);
        $this->db->update('tbl_banner_ads', $data);
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Banner Status Changed Successfully</div>');
        redirect(base_url('admin/banner/index/'));
    }
    public function duplicate_postion_check($banner_ads_postion) {

        $response = $this->commonmodel->isRecordAlreadyExist('banner_ads_position', $banner_ads_postion, 'pk_banner_ads_id', $this->validate_banner_id, 'tbl_banner_ads');

        if ($response == 1) {
            $this->form_validation->set_message('duplicate_postion_check', 'Sorry %s you have provided already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
