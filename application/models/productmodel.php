<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class productmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    
    public function getproductdetail($pk_product_id) {
         $queryStr = " SELECT * FROM tbl_products WHERE pk_product_id = ".$pk_product_id;
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getproducts() {
         $queryStr = " SELECT * FROM tbl_products";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function getproductsImages($product_id) {
          $queryStr = " SELECT * FROM tbl_product_album where fk_product_id = ".$product_id;
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}

