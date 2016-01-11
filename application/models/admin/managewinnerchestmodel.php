<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class managewinnerchestmodel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 

	
	public function getAllStores() {
        $queryStr = " SELECT s.store_id AS pk_store_id,s.store_title ,wcs.fk_chest_id 
                        FROM view_stores_list_stores AS s
                        LEFT JOIN tbl_winner_chest_to_store AS wcs ON s.store_id = wcs.fk_store_id
                        LEFT JOIN tbl_winner_chest AS wc ON wcs.fk_chest_id = wc.tresure_chest_id
                        WHERE ISNULL(wcs.fk_chest_id) GROUP BY s.store_id ORDER BY s.store_title ASC";
        $queryRS = $this->db->query($queryStr);
		if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }
	 //this function will fetch page details of a specific page from DB
    public function getStoretype($parent_id) {
         $query = "SELECT s.store_id AS pk_store_id,s.store_title ,wcs.fk_chest_id 
                        FROM view_stores_list_stores AS s
                        LEFT JOIN tbl_winner_chest_to_store AS wcs ON s.store_id = wcs.fk_store_id
                        LEFT JOIN tbl_winner_chest AS wc ON wcs.fk_chest_id = wc.tresure_chest_id
                        WHERE ISNULL(wcs.fk_chest_id) GROUP BY s.store_id ORDER BY s.store_title ASC";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }
	
	public function getAllchest() {
        $queryStr = " SELECT * FROM tbl_winner_chest 
							ORDER BY tresure_chest_id
							DESC 
							";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    
	
	public function getrandomStores($tresure_chest_id,$limit) {
       
	    $queryStr = " SELECT fk_store_id FROM tbl_store_to_user_account_type 
	   						WHERE fk_store_id NOT IN(SELECT fk_store_id FROM tbl_winner_chest_statistics) 
							AND  fk_user_account_type_id = ".$tresure_chest_id." 
							GROUP BY fk_store_id ORDER BY RAND() LIMIT ".$limit ;
		$queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	
    public function getaccounttype($tresure_chest_id) {
		
        $queryStr = "SELECT fk_user_account_id FROM tbl_winner_chest_to_user_account_type where fk_chest_id = ".$tresure_chest_id." LIMIT 1 " ;

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->fk_user_account_id;
    }
	
	public function getAllTresureUser($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT tbl_winner_chest_statistics.*,tbl_users.user_first_name,tbl_users.user_last_name,tbl_users.user_username,
							tbl_store.store_title
							FROM tbl_winner_chest_statistics,tbl_users,tbl_store
							WHERE tbl_store.pk_store_id = tbl_winner_chest_statistics.fk_store_id
							AND  tbl_winner_chest_statistics.fk_user_id = tbl_users.pk_user_id 
							ORDER BY tbl_winner_chest_statistics.winnerchest_statics_pk_id
							DESC 
							$strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getCountTresureUser() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_winner_chest_statistics';
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }
    
    public function getAllgiftType() {
        $queryStr = "SELECT * FROM tbl_winner_chest_gift_type";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function getAllAccountType() {
        $queryStr = "SELECT * FROM tbl_user_account_type where user_account_type_status = 'Active'  "; 
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function getGiftsReletedType($gift_type_id) {
        $queryStr = "SELECT * FROM tbl_winner_chest_gift where fk_winner_chest_gift_type_id = $gift_type_id  "; 
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    
    
    public function getAllgifts() {
        $queryStr = "SELECT gtype.winner_chest_gift_type,gift.* FROM tbl_winner_chest_gift AS gift , 
                        tbl_winner_chest_gift_type AS gtype
                        WHERE gtype.pk_winner_chest_gift_type_id = gift.fk_winner_chest_gift_type_id";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	
}
 
?>