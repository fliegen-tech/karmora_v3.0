<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class video extends CI_Controller {

    public $page = 'video';
    protected $validate_video_id = '';
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
        $this->page = 'video';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/videomodel', 'commonmodel'));
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->helper('string');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index() {

        $this->all(1, 12);
    }


    public function all() {
        $data['page'] = $this->page;
        $search_string = '';
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        
        if (isset($_SESSION['posted_video_id'])) {
            unset($_SESSION['posted_video_id']);
        }
        $videos = $this->videomodel->getAllVideos();
        $data['videos'] = $videos;
        $data['content'] = $this->load->view('admin/videos/manage', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    /////**front end albums view**////
    public function video_gallary($page = 1, $limit = 12) {
        $album = $this->videomodel->getAllVideos($page, $limit);
        $data['video'] = $album;
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('video/video_gallary');
        $data['paging'] = paging_generate($this->videomodel->getCountAllVideos(), $page, $limit, 5, $datagridURL);
        $data['pagingcombo'] = pagingcombo_generate($limit);
        $data['currentpage'] = $page;
        $data['title'] = 'Videos';
        $data['rowslimit'] = $limit;
        $this->load->view('videos/video_gallary', $data);
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
     * will show the form for Adding new record
     */
    public function add() {

        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['page'] = $this->page;
        $data['UserAccountType'] = $this->videomodel->getUserAccountType();
        $data['videocats'] = $this->videomodel->getVideoCategories();
        $data['video_id'] = 0;
        $data['content'] = $this->load->view('admin/videos/add', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    /**
     * will show the form to edit record
     *
     * @param integer $page_id
     */
    public function edit($video_id = '') {
        $data['controller'] = $this;
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $data['page'] = $this->page;

        if ($video_id == '') {
            show_404();
            exit;
        }
        $video_id = intval($video_id);
        if ($video_id == '') {
            show_404();
            exit;
        }
        #get the record from the database against the particular record
        $row = $this->videomodel->getvideoInfo($video_id);
        if (empty($row)) {
            show_404();
            exit;
        }
        $data['UserAccountType'] = $this->videomodel->getUserAccountType();
        $data['EditAccountType'] = $this->videomodel->getEditAccountType($video_id);
        $data['videocats'] = $this->videomodel->getVideoCategories();
        $data['EditVideo'] = $this->videomodel->getEditVideo($video_id);
        $data['video_id'] = $row->pk_video_id;
        $data['video_title'] = $row->video_title;
        $data['video_link'] = $row->video_url;
        $data['content'] = $this->load->view('admin/videos/add', $data, TRUE);

        $this->load->view('admin/template', $data);
    }

    /**
     * will save record
     *
     */
    public function save() {
		if(!isset($video_id)){
			
			$data['video_id'] = 0;
			}
        $data['header'] = $this->load->view('admin/header', $this->data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $data['template'] = $this->load->view('admin/template', $this->data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $this->data, TRUE);
        $data['UserAccountType'] = $this->videomodel->getUserAccountType();

        $data['videos_menu'] = 1;
        $video_id = $this->input->post('video_id');
        $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
        $_SESSION['posted_video_id'] = $video_id;
        $uploadpath = './public/images/video_cover_image';
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000000';
        $this->form_validation->set_rules('video_title', 'Video field', 'required');
        $this->form_validation->set_rules('video_link', 'Video link', 'required');
        if ($this->form_validation->run() == FALSE) {

            $data['content'] = $this->load->view('admin/videos/add', $data, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            
            $video_title = $this->input->post('video_title');
            $video_link = $this->input->post('video_link');
            if (false === strpos($video_link, '://')) {
                $video_link = 'http://' . $video_link;
            }
            if ($_FILES["cover_photo"]["name"] == '') {
                $picture = "default.jpg";
            } else {
                $path_info = pathinfo($_FILES["cover_photo"]["name"]);
                 $extention = $path_info['extension'];
                $filename = 'cover_' . time();
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->do_upload('cover_photo');
                $uploaddata = $this->upload->data();
                $picture = $filename . '.' . $extention;
                $temp = $uploaddata['full_path']; 
                //here is the second thumbnail, notice the call for the initialize() function again
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
/*                $config = array(
                    'source_image' => $temp,
                    'new_image' => './public/images/video_cover_image/thumb_large',
                    'maintain_ratio' => true,
                    'height' => 190,
                    'width' => 190,
                );
                //here is the second thumbnail, notice the call for the initialize() function again
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                unlink($temp);
*/            }
            if ($video_id == 0) { //add case
                $datas = array(
                    'video_title' => $video_title,
                    'video_url' => $video_link,
                    'video_cover_photo' => $picture,
                    'video_status' => 1,
                    'video_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_video', $datas);
                $fk_table_name_id = $this->db->insert_id();
                $relation_with_user_account_type_table_name = 'tbl_video';
                $fk_user_account_type_id = $this->input->post('fk_user_account_type_id');
                $vide_cat = $this->input->post('video_cat');
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
                $counter = count($vide_cat);
                   for ($i = 0; $i < $counter; $i++) {
                    $datas = array(
                        'fk_video_id' => $fk_table_name_id,
                        'fk_category_id' => $vide_cat[$i],
                        'video_to_category_relation_status' => 'Active',
                        'video_to_category_create_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_video_to_category', $datas);
                    
                   }                    


                $_SESSION['successmessage'] = 'Video Added Successfully';
                redirect(base_url("admin/video/index"));
                exit;
            } else {  //edit case
                 
                 
               
                if ($picture == "default.jpg") {
                    $datas = array(
                        'video_title' => $video_title,
                        'video_url' => $video_link,
                        'video_create_date' => date("Y-m-d H:i:s")
                    );
                } else {
                    $row = $this->videomodel->getCoverPhoto($video_id);
                    if ($row[0]['cover_photo'] != 'default.jpg') {
                        unlink('./public/images/video_cover_image/' . $row[0]['video_cover_photo']);
                    }
                    $datas = array(
                        'video_title' => $video_title,
                        'video_url' => $video_link,
                        'video_cover_photo' => $picture
                    );
                }

                $this->db->where('pk_video_id', $video_id);
                $this->db->update('tbl_video', $datas);
                $user_account_types = $this->input->post('fk_user_account_type_id');
                $where = array('fk_table_name_id ' => $video_id, 'relation_with_user_account_type_table_name ' => 'tbl_video');
                $this->db->where($where);
                $this->db->delete('tbl_relation_with_user_account_type');
                foreach ($user_account_types as $uat) {

                    $datas = array(
                        'relation_with_user_account_type_table_name' => 'tbl_video',
                        'fk_user_account_type_id' => $uat,
                        'fk_table_name_id' => $video_id,
                        'relation_with_user_account_type_status' => 'Active',
                        'relation_with_user_account_type_create_date' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('tbl_relation_with_user_account_type', $datas);
                }
                
                
                $this->db->where('fk_video_id',$video_id);
                $this->db->delete('tbl_video_to_category'); 
                
                $video_cat = $this->input->post('video_cat');
               
                $counter = count($video_cat);
                for ($i = 0; $i < $counter; $i++) {
                    $datas = array(
                        'fk_video_id' => $video_id,
                        'fk_category_id' => $video_cat[$i],
                        'video_to_category_relation_status' => 'Active',
                        'video_to_category_create_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('tbl_video_to_category', $datas);
                    
                   }          
                
                $_SESSION['successmessage'] = '<div align="center"  class="successmessage">Video Info Updated Successfully</div>';
                redirect(base_url('admin/video/index'));
            }
        }
    }

    /**
     * change status
     */
    public function changestatus($video_id = '', $current_status = '') {
        if ($current_status === "Active") {
            $data = array('video_status' => 'Inactive');
        } else if ($current_status === "Inactive") {
            $data = array('video_status' => 'Active');
        }
        $this->db->where('pk_video_id', $video_id);
        $this->db->update('tbl_video', $data);

        $_SESSION['successmessage'] = 'Video Status Changed Successfully';
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Video Status Changed Successfully</div>');
        redirect(base_url('admin/video/all/'));
        exit;
    }

    /**
     * will delete a record
     */
    public function delete($video_id = '', $cover_photo) {
        if ($video_id == '') {
            show_404();
        }
        $this->db->where('pk_video_id', $video_id);
        $this->db->delete('tbl_video');
        if ($cover_photo != 'default.jpg') {
            @unlink('./public/video_uploads/' . $cover_photo);
        }
        $where = array('fk_table_name_id ' => $video_id, 'relation_with_user_account_type_table_name ' => 'tbl_video');
        $this->db->where($where);
        $this->db->delete('tbl_relation_with_user_account_type', $data);
        
        $this->db->where('fk_video_id',$video_id);
        $this->db->delete('tbl_video_to_category'); 
                
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Video Deleted Successfully Successfully</div>');
        redirect(base_url('admin/video/all/'));
        exit;
    }

    /**
     * will show the form for Adding new record
     */
    public function view($photo_id) {
        $photos_info = $this->photomodel->getPhotosInfo($photo_id);
        $data['photo'] = $photos_info;

        $this->load->view('admin/photos/view', $data);
    }

}
