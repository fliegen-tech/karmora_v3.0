<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tresurechest extends karmora {

    
    public $data;
    	
	
	public function __construct() {
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('tresurechestmodel');
        $this->load->model('commonmodel');
       
        
    }
    public function index($username=NULL) {
		
        $this->verifyUser($username);
        /// Win Cold Hard Cash
        $Win_Cold_Hard_Cash = 1;
        $data['Win_Cold_Hard_Cash'] = $this->tresurechestmodel->getTresures($Win_Cold_Hard_Cash);
        
        /// Win Gift Cards
        $Win_Gift_Cards = 2;
        $data['Win_Gift_Cards'] = $this->tresurechestmodel->getTresures($Win_Gift_Cards);
        
        /// Win Exclusive Products
        $Win_Exclusive_Products = 3;
        $data['Win_Exclusive_Products'] = $this->tresurechestmodel->getTresures($Win_Exclusive_Products);
        
        $winnerArray = $this->tresurechestmodel->getWinner();
        $data['winner'] = $winnerArray;
        $this->loadLayout($data,'frontend/tresurechest/content');
    }

}