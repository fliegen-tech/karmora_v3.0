<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class karmoramall extends karmora {

    
    public $data ;
    
    
    public function __construct() {

        parent::__construct();
       	$this->data['themeUrl'] = $this->themeUrl;
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('homemodel');
        $this->load->model('commonmodel');
        
        
    }
    public function index($username = NULL) {
            $data           =  '';
            $this->verifyUser($username);
            $detail = $this->currentUser;
            $data['categories'] = $this->GetCategories($detail['user_account_type_id']);
            $data['sliders']           = $this->getslider($detail['user_account_type_id']);
            $data['banner_detail']     = $this->manageBannerDetail($detail);
            $this->loadLayout($data,'frontend/karmoramall/content');
            
    }
    public function getslider($fk_user_account_type_id){
        
        $sliders = $this->homemodel->getACSliders($fk_user_account_type_id);

        $first = true;
        foreach ($sliders as $slide) {
            if ($first === true) {
                reset($sliders);
                $first = false;
            }

            if ($sliders[key($sliders)]['use_sid'] === 'Yes' && $sliders[key($sliders)]['affiliate_network_id'] !== '0') {
                $sliders[key($sliders)]['url'] = $this->prepURL($slide['affiliate_network_id'], $slide['url']);
            }
            next($sliders);
        }
        
        return $sliders;
    }
    public function manageBannerDetail($detail){
      $user_banner_array = array(); 
      $user_banner_array['username']               = $detail['username'];
      $user_banner_array['userid']                 = $detail['userid'];
      $user_banner_array['user_account_type']      = $detail['user_account_type_title'];
      $user_banner_loc   = $this->commonmodel->getuser_location($detail['userid']);
      $user_banner_image = $this->homemodel->checkimage($detail['userid']);
      if(!empty($user_banner_loc)){
        $user_banner_array['member_location']  = $user_banner_loc->_member_location;
      }else{
        $user_banner_array['member_location']  = 'Scottsdale, Az';  
      }
      if(!empty($user_banner_image)){
        $user_banner_array['profile_pic']      = $user_banner_image->profile_pic;
      }
      return $user_banner_array;
    }

}

/* Location: ./application/controllers/welcome.php */