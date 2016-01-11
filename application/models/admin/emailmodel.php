<?php

class emailmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //This function will fetch detail of all pages from DB
    function getAllEmails($page, $limit) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $query = "SELECT * from tbl_email ORDER BY email_create_date DESC $strLimit";
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

        $query = "SELECT * from tbl_email And email_title LIKE '%" . $serch_string . "%' ORDER BY email_create_date DESC $strLimit";
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
      $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_email'";
       
       $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getCountAllemails($search_string = '') {
        if ($search_string != '') {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_email Where email_title LIKE '%" . $search_string . "%'  ";
        } else {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_email";
        }

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    //this function will fetch page details of a specific page from DB
    public function getSingleEmailDetail($id) {
      $query = "SELECT * FROM tbl_email WHERE pk_email_id=" . $id . ";";
     
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

}

?>