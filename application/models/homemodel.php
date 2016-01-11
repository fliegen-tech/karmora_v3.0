<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class homemodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getACSliders($acc_type_id) {
         $queryStr = " SELECT * FROM view_slider WHERE acc_type_id = " . $acc_type_id." order by banner_ads_position asc ";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getfeturedproduct() {
         $queryStr = " SELECT * FROM tbl_products order by pk_product_id desc limit 4 ";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function checkimage($member_id) {
        $queryStr = " SELECT * FROM view_affiliate_banner_info_profile_picture WHERE id = " . $member_id. " AND profile_pic_status = 'Active'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getFeturdStores($acc_type_id) {
        $queryStr = " SELECT * FROM view_stores_list_featured WHERE acc_type_id = " . $acc_type_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function GetfavourtiesStoresCheck($fk_user_id) {

        $query = "SELECT tbl_favorties.*,view_stores_list_stores.store_title 
					FROM tbl_favorties,view_stores_list_stores WHERE tbl_favorties.fk_user_id = ".$fk_user_id." 
					AND tbl_favorties.fk_store_id = view_stores_list_stores.store_id
					GROUP BY tbl_favorties.fk_store_id ORDER BY tbl_favorties.pk_favortie_id DESC LIMIT 5 ";

        $QueryR = $this->db->query($query);

        if ($QueryR->num_rows() > 0) {
            $array = $QueryR->result_array();
            return $array;
        } else {
            return false;
        }
    }
    public function getTopCategoryStores($acc_type_id){
    	$query = "SELECT ls.store_id, ls.store_title, ls.cash_back_percentage, ls.category_alias
					FROM view_stores_list_stores AS ls
					WHERE ls.acc_type_id = $acc_type_id AND ls.top_store = 'active'";
    	$result = $this->db->query($query);
    	return $result->result_array();
    }
     public function GetfavourtiesStores($fk_user_id) {

        $query = "SELECT tbl_favorties.*,view_stores_list_stores.store_title 
					FROM tbl_favorties,view_stores_list_stores WHERE tbl_favorties.fk_user_id = ".$fk_user_id." 
					AND tbl_favorties.fk_store_id = view_stores_list_stores.store_id
					GROUP BY tbl_favorties.fk_store_id ORDER BY tbl_favorties.pk_favortie_id DESC LIMIT 5 ";

        $QueryR = $this->db->query($query);

        if ($QueryR->num_rows() > 0) {
            $array = $QueryR->result_array();
            return $array;
        } else {
            return false;
        }
    }
    public function getScirber($email){
        
        $queryStr    = "SELECT * from tbl_subscribers WHERE subscriber_email = '".$email."'";
        $queryRS     = $this->db->query($queryStr);
        if($queryRS->num_rows() > 0){
           return  $queryRS->row();
        }else{
           return '';
        }
    }

}

