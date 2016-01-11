<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoryModel
 *
 * @author waqas
 */
class accounttypemodel extends CI_Model {

    public function getAccountTypeList($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $sql = "SELECT ac.*,b.user_account_billing_properties_title AS billing_title,
				c.user_account_cash_back_properties_title AS cash_back_title,p.user_account_properties_title AS properties_title,
				bu.business_title AS business_title
				FROM tbl_user_account_type ac ,tbl_user_account_billing_properties b ,tbl_user_account_cash_back_properties c,
				tbl_user_account_properties p, tbl_business bu 
				WHERE ac.fk_business_id = bu.pk_business_id 
				AND ac.fk_user_account_billing_properties_id = b.pk_user_account_billing_properties 
				AND ac.fk_user_account_cash_back_properties_id = c.pk_user_account_cash_back_properties_id
				AND ac.fk_user_account_properties_id = p.pk_user_account_properties_id
                ORDER BY ac.pk_user_account_type_id DESC $strLimit";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT ac.*,b.user_account_billing_properties_title AS billing_title,
						c.user_account_cash_back_properties_title AS cash_back_title,p.user_account_properties_title AS properties_title,
						bu.business_title AS business_title
						FROM tbl_user_account_type ac ,tbl_user_account_billing_properties b ,tbl_user_account_cash_back_properties c,
						tbl_user_account_properties p, tbl_business bu 
						WHERE ac.fk_business_id = bu.pk_business_id 
						AND ac.fk_user_account_billing_properties_id = b.pk_user_account_billing_properties 
						AND ac.fk_user_account_cash_back_properties_id = c.pk_user_account_cash_back_properties_id
						AND ac.fk_user_account_properties_id = p.pk_user_account_properties_id
						AND ac.user_account_type_title LIKE '%" . $search_string . "%'
						ORDER BY ac.pk_user_account_type_id DESC $strLimit";
        
		$queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	
    public function getCountSerchAccountType($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_type where user_account_type_title LIKE '%" . $search_string . "%'";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getUserAccountPropList($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $sql = "SELECT * from tbl_user_account_properties"
                . " ORDER BY pk_user_account_properties_id DESC $strLimit";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getCountAllAccountType() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_type";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getCountAllUserAccountProp() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_properties";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getById($id) {
        $sql = "SELECT * FROM tbl_category where pk_category_id = $id";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return false;
        }
    }

    public function getUserAccountBillingList($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $sql = "SELECT * from tbl_user_account_billing_properties"
                . " ORDER BY pk_user_account_billing_properties DESC $strLimit";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getCountAllUserAccountBilling() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_billing_properties";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getUserAccountCashBackList($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $sql = "SELECT * from tbl_user_account_cash_back_properties"
                . " ORDER BY pk_user_account_cash_back_properties_id DESC $strLimit";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getCountAllUserCashBack() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_cash_back_properties";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function get_account_properties() {
        $sql = "SELECT * from tbl_user_account_properties"
                . " ORDER BY pk_user_account_properties_id DESC";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getCountAllUserAccountType() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_user_account_type";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function get_billing_properties() {
        $sql = "SELECT * from tbl_user_account_billing_properties"
                . " ORDER BY pk_user_account_billing_properties DESC";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function get_business() {
        $sql = "SELECT * from tbl_business"
                . " ORDER BY pk_business_id DESC";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function get_account_cash_back() {
        $sql = "SELECT * from tbl_user_account_cash_back_properties"
                . " ORDER BY pk_user_account_cash_back_properties_id DESC";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
