<?php

class pagemodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //This function will fetch detail of all pages from DB
    function getAllPages($page, $limit) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $query = "SELECT c.*,d.page_title AS parent_title  FROM tbl_page c
						LEFT JOIN tbl_page d  ON c.page_parent_id = d.pk_page_id WHERE c.page_current_version=1 ORDER BY c.page_create_date DESC $strLimit";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }

    //This function will fetch detail of serch
    function getSearch($page, $limit, $serch_string) {

        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $query = "SELECT c.*,d.page_title AS parent_title  FROM tbl_page c
						LEFT JOIN tbl_page d  ON c.page_parent_id = d.pk_page_id WHERE c.page_current_version=1 And c.page_title LIKE '%" . $serch_string . "%' ORDER BY c.page_create_date DESC $strLimit";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
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

    public function getEditAccountType($id) {
        $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_page'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getCountAllpages($search_string = '') {
        if ($search_string != '') {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_page where page_current_version=1 and page_title LIKE '%" . $search_string . "%'  ";
        } else {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_page where page_current_version=1";
        }

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    //this function will fetch page details of a specific page from DB
    public function getSinglePageDetail($id) {
        $query = "SELECT * FROM tbl_page WHERE pk_page_id=" . $id . ";";
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    //this function will fetch page details of a specific page from DB
    public function getIntereatedpage($page_inheritance) {
        $query = "SELECT * FROM tbl_page WHERE page_inheritance != 'Last'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }

    public function getPageCategories() {
        $queryStr = " SELECT * from tbl_category Where category_parent_id=10";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

}

?>