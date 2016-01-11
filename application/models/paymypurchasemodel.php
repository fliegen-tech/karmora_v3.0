<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PaymypurchaseModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getUserSales($user_id) {
        $queryStr = "SELECT * FROM tbl_sales WHERE fk_user_id = '" . $user_id . "' GROUP BY sales_advertiser_name";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getVoteDeatil($fk_prmotion_id) {
        $queryStr = "Select sum(votes_count) as votes from tbl_prmotion_votes where fk_prmotion_id =" . $fk_prmotion_id.' ORDER BY vote_pk_id DESC limit 1';
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row()->votes;
        } else {
            return '';
        }
    }

    public function getVoteIpDeatil($fk_prmotion_id, $ip) {
        $queryStr = "Select * from tbl_prmotion_votes where fk_prmotion_id = '" . $fk_prmotion_id . "' and ip = '" . $ip . "' ORDER BY vote_pk_id DESC limit 1";
        $result = $this->db->query($queryStr);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getpromotion_id($fk_user_id) {
        $queryStr = "Select promation_pk_id,media,video_type  from tbl_promations where fk_user_id =" . $fk_user_id . " and status = 1 and promation_type = 'paymypurchase' ORDER BY promation_pk_id DESC LIMIT 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getUserPromotions($userId) {
        $queryStr = "Select promation_pk_id,media,video_type, promotion_image  from tbl_promations where fk_user_id = " . $userId . " and status = 1 and promation_type = 'paymypurchase' ORDER BY promation_pk_id DESC LIMIT 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getUserPendingPromotions($userId) {
        $queryStr = "Select promation_pk_id,media,video_type,status  from tbl_promations where fk_user_id = " . $userId . " and status != 1 and promation_type = 'paymypurchase' ORDER BY promation_pk_id DESC LIMIT 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

     public function getUserdetailOnsucess($userId) {
       $queryStr = "SELECT u.user_first_name,u.user_last_name ,vabi.user_account_type_title AS 'member_level',pro.*,vabl._member_location AS 'location'
                        FROM view_affiliate_banner_info_profile_picture AS pro , tbl_users AS u 
                        LEFT JOIN view_affiliate_banner_info AS vabi ON u.pk_user_id = vabi.pk_user_id
                        LEFT JOIN view_affiliate_banner_info_location AS vabl ON u.pk_user_id = vabl._member_id
                        WHERE  pro.profile_pic_status = 'Active' AND u.pk_user_id = ".$userId." GROUP BY u.pk_user_id "; 
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getPromtionalVideo() {
        $queryStr = "Select promation_pk_id,media,video_type  from tbl_promations where status = 1 and promation_type = 'paymypurchase'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function promotionalVediosWithVoteCount(){
        $query = "SELECT tp.*,sum(tpv.votes_count) as votescount FROM tbl_promations AS tp
LEFT JOIN tbl_prmotion_votes AS tpv ON tpv.fk_prmotion_id = tp.promation_pk_id WHERE tp.status =1 AND tp.promation_type = 'paymypurchase' 
group by tp.promation_pk_id";
        $queryRS = $this->db->query($query);
        if($queryRS->num_rows() > 0){
            return $queryRS->result_array();
        }else{
            return NULL;
        }
    }
    
    public function get_promtion_detail($promtion_type_id) {
        $queryStr = "SELECT * FROM tbl_promation_logs AS pl WHERE pl.promotion_status = 'active' 
                        AND pl.promotion_start_date <= NOW() 
                        AND NOW() < pl.promotion_end_date 
                        AND pl.fk_promotion_type_id = ". $promtion_type_id ." ORDER BY pl.pk_promotion_logs_id DESC LIMIT 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    
}

?>