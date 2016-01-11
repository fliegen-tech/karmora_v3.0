<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class paymypurchase extends karmora {

    public $data;

  
    public function __construct() {
        parent::__construct();

        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('PaymypurchaseModel','ShareModel','usermodel'));
        $this->load->library('form_validation');
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->library('email');
        $this->load->model('commonmodel');
        $this->load->helpers('globals_helper');
        $this->load->helpers('oauth_helper');
    }

    public function index($username = NULL) {
        $userId = '';
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        if (isset($_SESSION['login_messgae'])) {
            $data['login'] = $_SESSION['login_messgae'];
            unset($_SESSION['login_messgae']);
        }
        if (isset($this->session->userdata['front_data']['id'])) { $userId = $this->session->userdata['front_data']['id']; }
        if ($userId != '') { 
            $deatil = $this->PaymypurchaseModel->getUserPromotions($User_detail['userid']);
                    if (!empty($deatil)) {
                        redirect(base_url('Pay4MyPurchase/approved'));
                    } else {
                        $pendingUserEntry = $this->PaymypurchaseModel->getUserPendingPromotions($User_detail['userid']);
                        if (!empty($pendingUserEntry)) { 
                            if($pendingUserEntry->status == 2 ){
                               $data['reject_approval'] = TRUE;  
                            }else{
                               $data['pending_approval'] = TRUE;
                            }
                        } else { 
                                $data['pending_approval'] = FALSE;
                            }
                    }
        }  
        $promotionalVedios = $this->PaymypurchaseModel->promotionalVediosWithVoteCount();
        $data['promotionalVideos'] = $promotionalVedios;
        $this->loadLayout($data, 'frontend/paymypurchase/home_page');
        
    }

    public function submit($username = NULL) {
        $data = '';
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        $userId = $this->session->userdata['front_data']['id'];
        if ($userId == '') {
            $_SESSION['login_messgae'] = 2;
            redirect(base_url('Pay4MyPurchase'));
            die;
        }
        $deatil = $this->PaymypurchaseModel->getUserPromotions($User_detail['userid']);
        if (!empty($deatil)) {
            redirect(base_url('Pay4MyPurchase/approved'));
            die;
        }
        $Pdeatil = $this->PaymypurchaseModel->getUserPendingPromotions($User_detail['userid']);
        if (!empty($Pdeatil)) { 
            if($Pdeatil->status != 2 ){
                redirect(base_url('Pay4MyPurchase'));
            }
        }

        
        if (isset($_POST['submit'])) {
            
            $email_address = $User_detail['user_email'];
            $video_type = $this->input->post('video_type');
            $media = $this->input->post('url');
            $content = $this->input->post('detail');
            $this->form_validation->set_rules('agrement', 'Agrement', 'required');
            $this->form_validation->set_rules('url', 'Url', 'trim|required');
            $this->form_validation->set_rules('detail', 'Content', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
            } else { // no errors now to save the data
                $ip = $_SERVER['REMOTE_ADDR'];
                $datas = array(
                    'fk_user_id' => $User_detail['userid'],
                    'video_type' => $video_type,
                    'media' => $media,
                    'content' => $content,
                    'email_address' => $email_address,
                    'ip' => $ip,
                    'promation_type' => 'paymypurchase'
                );

                $this->db->insert('tbl_promations', $datas);
               
                if ($this->db->affected_rows() > 0) {

                    $email_data = $this->commonmodel->getemailInfo(29);
                    $tags = array("{forum-pay4-url}");
                    $replace = array(base_url('forum/topic/54'));
                    $subject = $email_data->email_title;
                    $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $User_detail['userid']);
                    $to = $email_address;
                    $this->send_mail($to, $subject, $message);
                    $data['message'] = 'message';
                } else {
                    
                }
            }
        }
        
        $this->loadLayout($data, 'frontend/paymypurchase/submit');
        
    }

    public function vote($username = NULL) {
        
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        if (!is_null($username)) {
            // for user picture and name
            $UserdetailOnsucess = $this->PaymypurchaseModel->getUserdetailOnsucess($User_detail['userid']);
            if (!empty($UserdetailOnsucess)) {
                $data['user_first_name'] = $UserdetailOnsucess->user_first_name;
                $data['user_last_name'] = $UserdetailOnsucess->user_last_name;
                $data['profile_pic'] = $UserdetailOnsucess->profile_pic;
                $data['member_level'] = $UserdetailOnsucess->member_level;
                $data['location'] = $UserdetailOnsucess->location;
            }
        
         // for get promtion id
            $fk_prmotion_id_array = $this->PaymypurchaseModel->getpromotion_id($User_detail['userid']);
            $fk_prmotion_id = $fk_prmotion_id_array->promation_pk_id;
            $media = $fk_prmotion_id_array->media;
            $video_type = $fk_prmotion_id_array->video_type;

            $data['media'] = $media;
            $data['video_type'] = $video_type;
            $data['fk_prmotion_id'] = $fk_prmotion_id;

            if (!empty($fk_prmotion_id_array)) {
                $votesCount = $this->PaymypurchaseModel->getVoteDeatil($fk_prmotion_id);
                $data['votesCount'] = $votesCount;
                $data['fk_prmotion_id'] = $fk_prmotion_id;
            } else {
                redirect(base_url('Pay4MyPurchase'));
                die;
            }
            $data['javescrip_check'] = 3;
            $this->loadLayout($data, 'frontend/paymypurchase/vote');
            
        } else {
            $_SESSION['login_messgae'] = '2';
            redirect(base_url('Pay4MyPurchase'));
            die;
        }
    }

    public function karmora_likes( $fk_prmotion_id, $username=NULL) {

        $ip = $_SERVER['REMOTE_ADDR'];
        $votesdetail = $this->PaymypurchaseModel->getVoteIpDeatil($fk_prmotion_id, $ip);
        if (empty($votesdetail)) {

            $datas = array(
                'fk_prmotion_id' => $fk_prmotion_id,
                'votes_count' => 1,
                'ip' => $ip
            );

            $this->db->insert('tbl_prmotion_votes', $datas);

            echo $votesCount = $this->PaymypurchaseModel->getVoteDeatil($fk_prmotion_id);
            die;
        } else {
            $from_time = $votesdetail->cretaion_date_time;
            $to_time = date('Y-m-d H:i:s');
            $to_time = strtotime($to_time);
            $from_time = strtotime($from_time);
            $time = round(abs($to_time - $from_time) / (24 * 60 * 60), 2);
            if ($time >= 1) {
                $datas = array(
                    'fk_prmotion_id' => $fk_prmotion_id,
                    'votes_count' => 1,
                    'ip' => $ip
                );

                $this->db->insert('tbl_prmotion_votes', $datas);

                echo $votesCount = $this->PaymypurchaseModel->getVoteDeatil($fk_prmotion_id);
                die;
            } else {
                echo 'my';
                die;
            }
            die;
        }
    }

    public function sharetowin($username = NULL) {
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        if (!is_null($username)) {
            $userId = $this->session->userdata['front_data']['id'];
            if ($userId == '') {
                $_SESSION['login_messgae'] = '2';
                redirect(base_url('Pay4MyPurchase'));
                die;
            }
            if (isset($this->session->userdata['front_data'])) {
                $userId = $this->session->userdata['front_data']['id'];
                $automated_list = $this->ShareModel->get_auto_list($userId);
                $data['automated_list'] = $automated_list;
            }
            
            $data['username'] = $username;
            $data['ShopperInvited'] = $this->ShareModel->getShopperInvited($userId);
            $data['ShopperCommunity'] = $this->ShareModel->getShopperCommunity($userId);
            $data['aboutJoining'] = $this->ShareModel->getaboutJoiningCommunity($userId);
            
        } else {
            $_SESSION['login_messgae'] = '2';
            redirect(base_url('Pay4MyPurchase'));
            die;
        }

        $deatil = $this->PaymypurchaseModel->getUserPromotions($User_detail['userid']);

        if (!empty($deatil)) {
            $data['promotion_id'] = $deatil->promation_pk_id;
            $data['image'] = $deatil->promotion_image;
            $data['media_url'] = $deatil->media;
            $data['video_type'] = $deatil->video_type;
            $data['cusurl'] = base_url('Pay4MyPurchase/vote');
        } else {
            redirect(base_url('Pay4MyPurchase'));
            die;
        }
        
        if (!empty($_POST)) {
            $friends_name = $this->input->post('friends_name');
            $friends_emails = $this->input->post('friends_email');




            //$this->form_validation->set_rules('friends_email', 'To Share Enter Atleast one Email', 'callback_atleast_one');
            $this->form_validation->set_error_delimiters('', '');
            $query = array();
                $error_data = array();
                $i = 0;
                foreach ($friends_emails as $key => $value) {
                    
                    $user = $this->check_email($value, $User_detail['userid']);

                    if ($user) {
                        $query[] = '("' . $value . '",' . $User_detail['userid'] . ',"others")';
                        //echo 'insert into email_contacts (email,sender_id,email_type) values '.implode(',', $data);
                    } else {
                        $error_data[] = $friends_name[$i] . ' is already invited.';
                    }
                    $i++;
                }
                $msg = '';
                

                if (!empty($query)) { 
                    $queryStr = "INSERT  
                                    INTO 
                                        tbl_email_contacts(email,sender_id,email_type) 
                                        VALUES " . implode(',', $query);
                    $this->db->query($queryStr);
                   $fullName = $this->db->select('get_user_full_name('.$User_detail['userid'].') as full_name')->get();
                   $email_data = $this->commonmodel->getemailInfo(58);
                    $tags = array("{vote-url}", "{contact-name}", "{photo-vote-image}", "{full-name}");
                    $replace = array(base_url('Pay4MyPurchase/vote'), '', $this->themeUrl.'/images/promotions/pay4mypurchase/'.$data['promotion_id'].'.jpg', $fullName->row()->full_name );
                    // 
                    $subject = $email_data->email_title; 
                    
                    $message = $this->prepShareEmailContent($tags, $replace, $subject, $email_data->email_description, $User_detail['userid']); //
                   
                    $this->create_queue($friends_emails, $subject, $message, $User_detail['user_email']);
                    $msg = 'success';
                }
                if (!empty($error_data)) {

                    $msg = '<div class="alert alert-warning" role="alert">';

                    foreach ($error_data as $key => $value) {
                        $msg .= '<p>' . $value . '</p>';
                    }
                    $msg .= '</div>';
                }
                $this->session->set_flashdata('friends_msg', $msg);
                header("location:" . $_SERVER['HTTP_REFERER']);
            
        }
        $this->loadLayout($data, 'frontend/paymypurchase/share-to-win');
        
    }

    public function atleast_one($emails) {
        foreach ($emails as $email) {

            if ($email != "") {
                return true;
            }
        }
        $this->form_validation->set_message('atleast_one', 'Enter aleast one email');
        return false;
    }

    public function approved($username = NULL) {
        
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        $userId = $this->session->userdata['front_data']['id'];
            if ($userId == '') {
                $_SESSION['login_messgae'] = '2';
                redirect(base_url('Pay4MyPurchase'));
               
            }
        $deatil = $this->PaymypurchaseModel->getUserPromotions($User_detail['userid']);
        if (!empty($deatil)) {
            $data['media_url'] = $deatil->media;
            $video_type = $deatil->video_type;
            $data['video_type'] = $video_type;
            $data['cusurl'] = base_url('Pay4MyPurchase/vote');
        } else {
            redirect(base_url('Pay4MyPurchase'));
            
        }

        $this->loadLayout($data, 'frontend/paymypurchase/approved');
        
    }

    public function participated($username = NULL) {
        $this->verifyUser($username);
        $User_detail = $this->currentUser;
        $userId = $this->session->userdata['front_data']['id'];
        if ($userId == '') {
            $_SESSION['login_messgae'] = '2';
            redirect(base_url('Pay4MyPurchase'));

        }
        
        $this->loadLayout($data, 'frontend/paymypurchase/particpated');

    }

    public function check_email($email, $senderId) {


        $invitedUser = $this->checkInvitedUser($email, $senderId);
        return $invitedUser;
    }
   
}
