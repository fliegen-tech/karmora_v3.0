<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class storemodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getCategories($category_id) {
        $query = 'SELECT * FROM tbl_category 
        			WHERE category_parent_id = (SELECT pk_category_id 
        											FROM tbl_category 
        											WHERE pk_category_id = "' . $category_id . '") 
        			ORDER BY category_title ASC';


        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetTrendingStore($fk_user_account_type_id, $alias) {
        $whereClause = null;

        if (strtolower($alias) !== 'all') {
            $whereClause = " AND trending.category_alias = '" . $alias . "'";
        }
        $query = "SELECT * 
						FROM view_stores_list_trending AS trending
						WHERE trending.acc_type_id = " . $fk_user_account_type_id . $whereClause;

        //echo $query;exit;

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetTrendingStoreTitle($store_id) {

        $query = "Select store_title,store_url from view_stores_list_trending where store_id = '" . $store_id . "'";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function CheckCatAlias($alias = null) {
        if (!is_null($alias)) {
            $query = "SELECT cat.category_alias FROM tbl_category AS cat WHERE cat.category_alias = '$alias'";
            $rs = $this->db->query($query);
            $alias_chek = $rs->row();
        }

        if (empty($alias_chek) or is_null($alias)) {
            $response = 'all';
        } else {
            $response = $alias_chek->category_alias;
        }

        return $response;
    }

    public function GetStore($fk_user_account_type_id, $alias, $usesr_id = null) {


        if ($alias !== 'all') {
            $whereClause = " AND view_stores_list_stores.category_alias ='$alias'";
            //$condation = "AND category_alias = '" . $alias . "'";
        } else {
            $whereClause = '';
        }
        if (is_null($usesr_id)) {

            $usesr_id = 0;
        }

        $query = "SELECT view_stores_list_stores.*,tbl_favorties.fk_store_id
                            FROM view_stores_list_stores
                            LEFT JOIN tbl_favorties
                            ON view_stores_list_stores.store_id=tbl_favorties.fk_store_id AND tbl_favorties.fk_user_id = " . $usesr_id . "
                            WHERE view_stores_list_stores.acc_type_id = $fk_user_account_type_id $whereClause
                            ORDER BY view_stores_list_stores.store_title ASC"; 


        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetsearchStore($fk_user_account_type_id, $store_title) {

        $store_title = addslashes(str_replace('%20', ' ', $store_title));

        $query = "SELECT * 
						FROM view_stores_list_stores 
						WHERE acc_type_id = " . $fk_user_account_type_id . " AND store_title LIKE '" . $store_title . "%' GROUP BY store_id order by store_title ASC LIMIT 15";
        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetAllStore($fk_user_account_type_id) {
        $query = "SELECT * 
						FROM view_stores_list_stores 
						WHERE acc_type_id = " . $fk_user_account_type_id . "";

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetStoreTitle($store_id, $fk_user_account_type_id) {

        $query = "Select store_title,store_url from view_stores_list_stores where store_id = '" . $store_id . "' and acc_type_id= " . $fk_user_account_type_id;
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function GetStoreInfo($store_id, $acc_type_id) {

        $storeTypeId = $this->storemodel->getStoreTypeId($store_id);

        switch ($storeTypeId) {
            case "5":
                $table = 'view_stores_list_trending';
                break;
            case "6":
                $table = 'view_stores_list_stores';
                break;
            case "73":
                $table = 'view_stores_list_special_deals';
                break;
            default:
                redirect(base_url());
                break;
        }

        $query = "SELECT DISTINCT vs.affiliate_network_id AS 'fk_affiliate_network_id', vs.store_id, vs.store_title, vs.store_url, vs.store_image, vs.store_description,s.coupon_title
					FROM $table AS vs ,tbl_store AS s
					WHERE vs.acc_type_id = $acc_type_id AND vs.store_id = $store_id AND s.pk_store_id = vs.store_id";
        //echo $query; exit;


        $rsQuery = $this->db->query($query);

        if ($rsQuery->num_rows() > 0) {
            $response = $rsQuery->row();
        } else {
            $response = false;
        }

        return $response;
    }

    public function GetMemberInfo($memberId) {
        $query = "SELECT v_pic.profile_pic	
					FROM tbl_users AS u
					JOIN view_affiliate_banner_info_profile_picture AS v_pic ON u.pk_user_id = v_pic.id
					WHERE u.pk_user_id = $memberId";

        $rsQuery = $this->db->query($query);

        if ($rsQuery->num_rows() > 0) {
            $response = $rsQuery->row();
        } else {
            $response = false;
        }

        return $response;
    }

    public function GetTrendingStoreInfo($store_id, $acc_type_id) {
        $query = "SELECT v_st.store_id, v_st.store_title, v_st.store_alias, v_st.store_image
					FROM view_stores_list_trending AS v_st
					WHERE v_st.acc_type_id = $acc_type_id AND v_st.store_id = $store_id";
        $rsQuery = $this->db->query($query);

        if ($rsQuery->num_rows() > 0) {
            $response = $rsQuery->row();
        } else {
            $response = false;
        }

        return $response;
    }

    // for tresure store
    public function GetAlredayDetail($fk_store_id, $fk_tresure_id, $fk_user_id, $setting) {
        $condation = '';
        if ($setting == 'Fixed') {
            $condation = " AND wc_stats.fk_user_id = " . $fk_user_id;
        }
//        $query = "SELECT 
//				CASE 
//					WHEN (
//						SELECT COUNT(wc_stats.winnerchest_statics_pk_id)
//						FROM tbl_winner_chest_statistics AS wc_stats
//						WHERE wc_stats.fk_store_id = " . $fk_store_id . " AND
//							wc_stats.fk_tresure_id = " . $fk_tresure_id . " 
//							" . $condation . "
//						) >0
//						THEN 'false'
//						ELSE 'true'
//						END AS tc_won
//						";
        $query = "SELECT 
                    CASE WHEN (COUNT(winnerchest_statics_pk_id)) > 0
                            THEN 'false' 
                            ELSE (
                                    SELECT 
                                    CASE 
                                        WHEN ( 
                                            SELECT COUNT(wc_stats.winnerchest_statics_pk_id) 
                                            FROM tbl_winner_chest_statistics AS wc_stats 
                                            WHERE wc_stats.fk_store_id = " . $fk_store_id . " AND 
                                                    wc_stats.fk_tresure_id = " . $fk_tresure_id . "  
                                                    " . $condation . " ) >0 
                                        THEN 'false' 
                                        ELSE 'true' 
                                    END AS tc_won1
                                )
                    END AS tc_won
                 FROM tbl_winner_chest_statistics AS wc_stats
                 WHERE wc_stats.fk_user_id = " . $fk_user_id . " AND TIMEDIFF(NOW(),`winning_date`) < '24:00:00'"
                ;
       
        $queryRS = $this->db->query($query);
        $Row = $queryRS->row();
        
        return $Row->tc_won;
    }

    public function GettresureDetail($tresure_chest_id, $store_id) {
         $query = "SELECT wc.*,gif.winner_chest_gift_amount AS amount FROM tbl_winner_chest_gift AS gif , 
                                                tbl_winner_chest AS wc  RIGHT JOIN tbl_winner_chest_to_store AS wcs 
                                                ON wc.tresure_chest_id = wcs.fk_chest_id 
                                                LEFT JOIN tbl_store AS s ON wcs.fk_store_id = s.pk_store_id 
                                                WHERE s.store_status = 'active' AND wc.status = 1 AND wc.quantity > 0
                                                AND wc.tresure_chest_id = " . $tresure_chest_id . " AND 
						wcs.fk_store_id = " . $store_id . "  
                                                AND wc.fk_winner_chest_id = gif.pk_winner_chest_gift_product_id limit 1"; 
        $rsQuery = $this->db->query($query);

        if ($rsQuery->num_rows() > 0) {
            $response = $rsQuery->row();
        } else {
            $response = false;
        }

        return $response;
    }

    public function GetallChest($storeId) {
        $query = "SELECT tresure_chest_id 
                    FROM tbl_winner_chest AS wc 
                    LEFT JOIN tbl_winner_chest_to_store AS wcs on wc.tresure_chest_id = wcs.fk_chest_id
                    where wcs.fk_store_id = $storeId";

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function GetallChestforStore($storeId = NULL) {
        if ($storeId !== NULL) {
            $query = "SELECT fk_chest_id AS tresure_chest_id FROM tbl_winner_chest_to_store WHERE fk_store_id = $storeId";

            $QueryR = $this->db->query($query);

            $response = $QueryR->result_array();
        } else {
            $response = NULL;
        }
        return $response;
    }

    // function to get all coupons
    public function GetCoupons($couponTitle, $networkId, $user_id = NULL) {
        if (is_null($user_id)) {
            $user_id = 2;
        }
        $query = "SELECT tbl_coupon.* ,tbl_favorties_coupons.pk_favortie_coupon_id
            FROM tbl_coupon LEFT JOIN tbl_favorties_coupons 
            ON tbl_favorties_coupons.fk_coupon_id = tbl_coupon.pk_coupons_id
            AND tbl_favorties_coupons.fk_user_id = $user_id
            WHERE tbl_coupon.coupons_storetitle = '" . $couponTitle . "'
                AND tbl_coupon.fk_affiliate_network_id = " . $networkId . "
                AND tbl_coupon.coupons_expiredate >= NOW()
                GROUP BY tbl_coupon.pk_coupons_id 
                   ORDER BY tbl_coupon.coupons_begindate ASC";

        $QueryR = $this->db->query($query);

        if ($QueryR->num_rows() > 0) {
            $array = $QueryR->result_array();
            return $array;
        } else {
            return false;
        }
    }

    public function getCommissionPercentage($storeid, $acc_type_id) {
        $sql = "SELECT * from tbl_store_to_user_account_type where fk_store_id = $storeid AND fk_user_account_type_id = $acc_type_id";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    // function to get all coupons
    public function GetfavourtiesStores($fk_store_id, $fk_user_id) {

        $query = "SELECT * 
			    	FROM tbl_favorties 
			     	WHERE fk_user_id = '" . $fk_user_id . "' AND fk_store_id = '" . $fk_store_id . "'";

        $QueryR = $this->db->query($query);

        if ($QueryR->num_rows() > 0) {
            $array = $QueryR->result_array();
            return $array;
        } else {
            return false;
        }
    }

    public function GetfavourtieStore($user_id) {


        $query = "SELECT view_stores_list_stores.*,fv.fk_store_id,fv.fk_user_id FROM view_stores_list_stores,tbl_favorties AS fv 
							WHERE fv.fk_store_id = view_stores_list_stores.store_id AND fv.fk_user_id = " . $user_id . "  
							GROUP BY fv.fk_store_id
							ORDER BY view_stores_list_stores.store_title ASC";

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function getStoreTypeId($storeId) {
        $query = "SELECT c.category_parent_id
                    FROM tbl_store_to_category AS sc
                    LEFT JOIN tbl_category AS c ON sc.fk_category_id = c.pk_category_id
                    WHERE sc.fk_store_id = $storeId";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result[0]['category_parent_id'];
        } else {
            return FALSE;
        }
    }

    public function checkFavorite($userId) {
        $sql = "select * from tbl_favorties where fk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getSpecialStores($fk_user_account_type_id, $alias) {
        $whereClause = null;

        if (strtolower($alias) !== 'all') {
            $whereClause = " AND special_deals.category_alias = '" . $alias . "'";
        }
        $query = "SELECT * 
						FROM view_stores_list_special_deals AS special_deals
						WHERE special_deals.acc_type_id = " . $fk_user_account_type_id . $whereClause;

        //echo $query;exit;

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function categoryDetails($alias) {
        $sql = "select * from tbl_category where category_alias    =   '$alias'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

    public function getCouponDetailById($couponId) {

        $sql = "select * from tbl_coupon where pk_coupons_id    =   $couponId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result[0];
        } else {
            return FALSE;
        }
    }
    
     public function GetExtensionDetail() {
        $query = "SELECT sd.cash_back_percentage,sd.store_title,sd.store_id FROM view_stores_list_stores AS sd GROUP BY store_id";
         $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

}

?>