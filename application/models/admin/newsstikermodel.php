<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class newsstikermodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * will get all the records
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function gethieveryone($page = 1, $limit = 10) {

        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT * from tbl_news_ticker ORDER BY news_ticker_create_date
								DESC $strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else
            return '';
    }

    public function getEditAccountType($id) {
        $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_news_ticker'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    /**
     * will get count of all the records 
     */
    public function getCountSticker() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_news_ticker";
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getEditSticker($id) {
        $query = "SELECT * FROM tbl_news_ticker WHERE  pk_news_ticker_id = " . $id . " ";
        $QueryR = $this->db->query($query);
        $row = $QueryR->row();
        return $row;
    }

// for user Type
    public function getUserAccountType() {
        $queryStr = " SELECT * FROM tbl_user_account_type";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

	public function getSearch($page=1,$limit=10,$search_string){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		$queryStr 	= " SELECT * from tbl_news_ticker where news_ticker_title LIKE '%".$search_string."%' ORDER BY news_ticker_create_date
						DESC $strLimit";
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	
    /**
     * will get count of all the records 
     */
    public function getCountSerchSticker($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_news_ticker where news_ticker_title LIKE '%".$search_string."%'";
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

}

?>