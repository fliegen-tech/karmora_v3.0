<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends karmora {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        if ($this->session->userdata('front_data')) {
            
        } else {
            redirect(base_url());
        }
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('usermodel');
        $this->load->model('homemodel');
        $this->load->model('commonmodel');
        $this->load->library('form_validation');
    }

    public function profile($username = NULL) {
        $this->verifyUser($username);
        $userDetailA = $this->commonmodel->getUserDetails($username);
        $userDetail = reset($userDetailA);
        $pk_user_id = $userDetail['pk_user_id'];
        $emailTypes = $this->usermodel->getUserEmails($pk_user_id);
        $data['email_types'] = $emailTypes;
        $userAddress = $this->usermodel->getMemberCurrentAddress($pk_user_id);
        $data['pic'] = $this->usermodel->checkProfilePic($pk_user_id);
        //var_dump($data['pic']);die;
        $data['address'] = $userAddress['address'];
        $data['countriesList'] = $userAddress['countriesList'];
        $data['statesList'] = $userAddress['statesOfCurrentAddressCountry'];
        $data['userData'] = $userDetail;
        $data['nav'] = $this->load->view('frontend/layout/partials/reporting_nav', $data, TRUE);
        $this->loadLayout($data, 'frontend/user/profile');
    }

    public function uploadPicture($username = NULL) {
        $this->verifyUser($username);
        $userData = $this->commonmodel->getUserDetails($username);
        $pk_user_id = $userData[0]['pk_user_id'];
        $uploadpath = './public/images/profile-pic/' . $pk_user_id;
        @mkdir($uploadpath, 755);
        $filename = $userData[0]['user_username'] . rand(0, 3);

        $config['file_name'] = $filename;
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upl')) {
            
        } else {
            $this->uploadExtra($pk_user_id);
        }
    }

    public function uploadExtra($pk_user_id) {

        $upload_data = $this->upload->data();

        $user_pic = $this->usermodel->checkProfilePic($pk_user_id);

        if ($user_pic) {
            //echo "pic exists";
            $this->db->where('fk_user_id', $pk_user_id);
            $this->db->update('tbl_user_profile_picture', array('profile_user_picture_status' => 'Inactive'));
            $data = array(
                'picname' => $upload_data['file_name']
            );
            $this->usermodel->setProfilePic($pk_user_id, $data);
        } else {
            // inserting user picture into database
            $data = array(
                'picname' => $upload_data['file_name']
            );
            $this->usermodel->setProfilePic($pk_user_id, $data);
        }
        echo '{"status":"success"}';
        exit;
        redirect(base_url() . 'profile');
        exit;
    }

    public function manageemail($username = NULL) {
        $this->verifyUser($username);
        $userId = $this->input->post('userId');
        if (!empty($_POST['emails'])) {

            $string = implode(",", $_POST['emails']);
            $this->usermodel->changeEmailSub($string, $userId);
        } else {
            $this->usermodel->changeEmailAll($userId);
        }
        $this->session->set_flashdata('email_succ', 'Changes Saved');
        redirect(base_url() . 'profile');
    }

    public function editProfile($username = NULL) {
        $this->verifyUser($username);
        $userDetail = $this->commonmodel->getUserDetails($username);
        $current_password = $userDetail[0]['user_password'];
        if ($_POST) {

            if (isset($_POST['action']) && $_POST['action'] === "edit_profile") {
                    $this->action_edit_profile();
            } elseif (isset($_POST['action']) && $_POST['action'] === "change_password") {
                    $this->action_change_password($userDetail,$current_password);
            } elseif (isset($_POST['action']) && $_POST['action'] === "address_update") {
                    $this->action_address_update();
            }
        }
    }
    
    public function action_edit_profile() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('profile_err', $this->form_validation->error_string());
            redirect(base_url() . "profile");
        } else {
            $this->usermodel->editprofile($this->input->post());
            $this->session->set_flashdata('success', 'Profile Edited');
            redirect(base_url() . "profile");
        }
    }
    
    public function action_change_password($userDetail,$current_password) {
                $this->form_validation->set_rules('password', 'Password', 'required|trim');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');
                if ($this->form_validation->run() === FALSE || md5($this->input->post('curr_password')) !== $current_password) {
                    // echo validation_errors();exit;
                    $this->session->set_flashdata('pass_err', 'Password Miss match');
                    redirect(base_url() . "profile");
                } else {
                    $this->usermodel->changePassword($this->input->post(), $userDetail[0]['pk_user_id']);
                    $this->session->set_flashdata('pass_succ', 'Password Changed');
                    redirect(base_url() . "profile");
                }
    }
    
    public function action_address_update() {

        $this->form_validation->set_rules('street_address', 'Street Address', 'required|trim');
        $this->form_validation->set_rules('street_address_2', 'Street Address', 'trim');
        $this->form_validation->set_rules('country', 'Country', 'required|trim');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone No', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('address_err', $this->form_validation->error_string());
            redirect(base_url() . "profile");
        } else {
            $this->update_address_function();
        }
    }
    
    public function update_address_function() {
            $post = $this->input->post();
            $arState = explode('-.-', $post['state']);
            $arCity = $post['city'];

            $address['countryId'] = $post['country'];
            $address['stateId'] = end($arState);
            $address['city'] = $arCity;
            $address['zipCode'] = $post['zipcode'];
            $address['streetAddress'] = $post['street_address'];
            $address['streetAddress_2'] = NULL;
            $phone = $post['phone'];
            if (isset($post['street_address_2'])) {
                $address['streetAddress_2'] = $post['street_address_2'];
            }
            $address['userId'] = $post['userId'];
            $validatecsc = $this->usermodel->validateCountryStateCity($address);
            $this->usermodel->updatePhone($address['userId'], $phone);
            $this->redirect_address($address,$validatecsc);
           
    }
    
    public function redirect_address($address,$validatecsc) {
        
         if ($validatecsc === false) {
                $address['cityId'] = $validatecsc['city_id'];
                $this->usermodel->updateAddress($address);
                $this->session->set_flashdata('address_success', 'Address updated successfully.');
                redirect(base_url('profile'));
            } else {
                $this->session->set_flashdata('address_err', 'No change in address.');
               redirect(base_url('profile'));
            }
    }

}

/* Location: ./application/controllers/welcome.php */