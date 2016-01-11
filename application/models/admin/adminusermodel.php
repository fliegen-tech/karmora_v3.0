<?php

class adminusermodel extends CI_Model {

    public function __construct() {
        
    }

    /**
     * will get all the records
     *
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function getAllUsers($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT u.*,c.category_title FROM tbl_admin_operator u ,tbl_category c
                                            WHERE u.fk_category_id = c.pk_category_id
							ORDER BY u.admin_operator_create_date
							DESC 
							$strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
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
      $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_admin_operator'";
       
       $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {

        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = "  SELECT u.*,c.category_title FROM tbl_admin_operator u ,tbl_category c
                                            WHERE u.fk_category_id = c.pk_category_id
							and u.admin_operator_username LIKE '%" . $search_string . "%'
							ORDER BY u.admin_operator_create_date
							DESC 
							$strLimit";
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
    public function getCountAllUsers($search_string) {
        if ($search_string != '') {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_admin_operator where admin_operator_first_name LIKE '%" . $search_string . "%' or admin_operator_username LIKE '%" . $search_string . "%' ";
        } else {
            $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_admin_operator';
        }
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getEditUser($id) {
        $query = "SELECT * FROM tbl_admin_operator WHERE  pk_admin_operator_id = " . $id . " ";
        $QueryR = $this->db->query($query);

        $row = $QueryR->row();

        return $row;
    }

    public function RecordAlreadyExist($username, $email) {
        $query = "SELECT admin_operator_username,admin_operator_email FROM tbl_admin_operator 
						   WHERE admin_operator_username='" . $username . "' 
							AND admin_operator_email = '" . $email . "'";
        $QueryR = $this->db->query($query);
        if (!empty($QueryR)) {
            return $row = $QueryR->row();
        } else {
            return '';
        }
    }

    public function getadmincategory($category_id) {
          $query = 'SELECT * FROM tbl_category WHERE category_parent_id = (SELECT pk_category_id FROM tbl_category WHERE pk_category_id = "' . $category_id . '")';

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

}
