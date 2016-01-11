<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Ibm
 */
class managedeals extends CI_Controller {

    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    //private $loginModel;
    /**
     * Constructor of a login 
     */
    function __construct() {

        
        parent::__construct(); //call to parent constructor
        $this->data = "";
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');

        // $this->loginModel    =   $this->load->model('admin/loginModel');

        session_start();
    }

    /**
     * will show the dashborad
     * index function default function of Admin Controller
     */
    public function index() {
        
       

            $data['header'] = $this->header;
            $data['footer'] = $this->footer;
            $data['content'] = $this->load->view('admin/deal/content', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);

            $this->load->view('admin/template', $data);
        
    }

    

}

?>
