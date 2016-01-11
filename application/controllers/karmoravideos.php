<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of karmoravideos
 *
 * @author Syed
 */

class karmoravideos extends karmora{
    //put your code here
    public $data;
    
    public function __construct() {
        parent::__construct();
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('commonmodel');
        $this->load->model('karmoravideomodel');
    }
    
    public function index($username = NULL )
    {
        $this->verifyUser($username);
        //select all Karmora Videos
        $data['karmoraVideos'] = $this->karmoravideomodel->getKarmoraVideos(71);
        $this->loadLayout($data,'frontend/video/content');
    }
    
    
}
