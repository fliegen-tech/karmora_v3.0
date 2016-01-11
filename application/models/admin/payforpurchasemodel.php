<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class payforpurchasemodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAllpayforpurchase() {
        
        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.promation_type = 'paymypurchase'   ORDER BY tbl_promations.promation_pk_id DESC ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }



    public function getStatusFVideo($status) {
        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.status = " . $status . " and tbl_promations.promation_type = 'paymypurchase'  ORDER BY tbl_promations.promation_pk_id DESC";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() > 0) {

            //return $queryRS->result_array();
        } else {
            return '';
        }
    }


    public function getCountapprovewintit() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where status =1 and promation_type = "paymypurchase" ';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        if (!empty($Row)) {
            $response = $Row->num_rows;
        } else {
            $response = false;
        }
        return $response;
    }

    public function getCountrejectedwintit() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where status =2 and promation_type = "paymypurchase"';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        if (!empty($Row)) {
            $response = $Row->num_rows;
        } else {
            $response = false;
        }
        return $response;
    }

    public function getVideoDetail($promotionId) {
        $sql = "select content from tbl_promations where promation_pk_id = $promotionId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0]['content'];
        } else {
            return FALSE;
        }
    }

    public function getpromtion() {

        $queryStr = "SELECT * FROM tbl_promation_type ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    public function getpromtionedit($promtion_id) {

        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
                            WHERE tbl_users.pk_user_id = tbl_promations.fk_user_id
                            AND tbl_promations.promation_type = 'paymypurchase' AND tbl_promations.promation_pk_id = " . $promtion_id . "  
                            ";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() > 0) {

            return $queryRS->row();
        } else
            return '';
    }
    
    public function getUsernameFromPromotion($id) {
        $query = "select u.user_username as username,u.user_email as usermemail, u.user_first_name as first_name, u.user_last_name as last_name  from tbl_users u,tbl_promations p where u.pk_user_id=p.fk_user_id AND p.promation_pk_id=" . $id;
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

}

?>