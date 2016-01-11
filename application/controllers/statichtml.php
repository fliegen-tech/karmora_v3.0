<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class statichtml extends karmora {

    
    public $data ;
    public function __construct() {

        parent::__construct();
       	$this->data['themeUrl'] = $this->themeUrl;
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('homemodel');
        $this->load->model('commonmodel');
        
        
    }
    public function karmorakash($username = NULL) {
            $data           =  '';
            $this->verifyUser($username);
            $this->loadLayout($data,'frontend/statichtml/karmorakash');
            
    }
    public function aboutus($username = NULL) {
            $data           =  '';
            $this->verifyUser($username);
            $this->loadLayout($data,'frontend/statichtml/aboutus');
            
    }
    public function cashbackextension($username = NULL) {
            $data           =  '';
            $this->verifyUser($username);
            $this->loadLayout($data,'frontend/statichtml/extension_cahback');
            
    }
    public function howtowin($username = NULL) {
            $data           =  '';
            $this->verifyUser($username);
            $this->loadLayout($data,'frontend/statichtml/howtowin');
            
    }


}

/* Location: ./application/controllers/welcome.php */