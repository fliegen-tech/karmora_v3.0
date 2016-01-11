<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoryModel
 *
 * @author Baig
 */
class categoryModel extends CI_Model {

    public function getCategoryList($filter = '') {
       if ($filter == '' || $filter == 'all') {
            $sql = "SELECT category.*, parent.category_title AS parent_title FROM tbl_category category LEFT JOIN tbl_category parent ON category.category_parent_id = parent.pk_category_id"
                    . " ORDER BY category.category_title";
        } else {
            $sql = "SELECT c.*,p.category_title as parent_title  FROM tbl_category c JOIN tbl_category p ON c.category_parent_id = p.pk_category_id  WHERE c.category_parent_id=$filter"
                    . " ORDER BY c.category_title ";
        }

        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) >= 1) {
            return $data;
        } else {
            return FALSE;
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

    public function getParrents() {
        $queryStr = " SELECT * FROM tbl_category Where category_parent_id=0";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getEditAccountType($id) {
        $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_category'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getCountAllCategory($filter) {
        if ($filter == '' || $filter == 'all') {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_category";
        } else {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_category Where category_parent_id=" . $filter;
        }
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    // function to add categories

    public function addCategory($postArray) {
        // preparing data 
        
        $cat_name = $postArray['cat_name'];
        $cat_status = $postArray['cat_status'];
        $parent_id = $postArray['parent_cat'];
        $cat_description    =   $postArray['page_content'];
        
        $alias = strtolower($cat_name);
        $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
        $alias = str_replace(array('\'', '"'), '', $alias);
        $alias = str_replace("\\", " ", $alias);
        $alias = str_replace("-", " ", $alias);
        $alias = str_replace("!", " ", $alias);
        $category_alias = str_replace(' ', '_', $alias);
        $postArray['category_alias'] = $category_alias;
        $sql = "INSERT INTO tbl_category SET `category_title` = :cat_name  , `category_alias` = :category_alias , `category_status`= :cat_status, `category_parent_id` = $parent_id, "
                . "category_description =   '$cat_description'";
        $statement = $this->db->conn_id->prepare($sql);
        
        $statement->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
        $statement->bindParam(':cat_status', $cat_status, PDO::PARAM_STR);
        $statement->bindParam(':category_alias', $category_alias, PDO::PARAM_STR);
        //$statement->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        //$statement->bindParam(':cat_description',$cat_description, PDO::PARAM_STR);
        //echo $this->parms($sql, $postArray);
        if ($statement->execute()) {
            
            return $this->db->conn_id->lastInsertId();
        } else {
            return FALSE;
        }
    }

    //this function will fetch page details of a specific page from DB
    public function getById($id) {
        $query = "SELECT * FROM tbl_category WHERE pk_category_id=" . $id . ";";
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function editCategory($id, $postArray) {
        
        
        $cat_name = $postArray['cat_name'];
        $cat_status = $postArray['cat_status'];
        $parent_id = $postArray['parent_cat'];
        $description    = $this->db->escape($postArray['page_content']);

        $alias = strtolower($cat_name);
        $alias = preg_replace('!\s+!', ' ', html_entity_decode($alias, ENT_QUOTES));
        $alias = str_replace(array('\'', '"'), '', $alias);
        $alias = str_replace("\\", " ", $alias);
        $alias = str_replace("-", " ", $alias);
        $alias = str_replace("!", " ", $alias);
        $category_alias = str_replace(' ', '_', $alias);
        $postArray['category_alias'] = $category_alias;

        //echo "<pre>";
        //print_r($postArray);
        $sql = "UPDATE tbl_category set"
                . "`category_title`= :cat_name,"
                . "`category_alias` = :category_alias ,"
                . "`category_status`  =   :cat_status,"
                . "`category_description`   =   $description"                
                . " where `pk_category_id`   =   $id";
        //echo $id . "<br />";
        //echo $this->parms($sql, $postArray); exit;
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
        $statement->bindParam(':category_alias', $category_alias, PDO::PARAM_STR);
        $statement->bindParam(':cat_status', $cat_status, PDO::PARAM_STR);
        //$statement->bindParam(':parent_id', $parent_id, PDO::PARAM_STR);
        //$statement->bindParam(':cat_description',$description, PDO::PARAM_LOB);
        //$statement->bindParam(':id', $id, PDO::PARAM_STR);
         //echo $this->parms($sql,$postArray);
         //echo "<br />";
        if ($statement->execute()) {
            return true;
           // echo "executed"; exit;
        } else {
            return FALSE;
            //echo "not executed"; exit;
        }
        
    }

    // function to debug PDO queries
    private function parms($string, $data) {
        $indexed = $data == array_values($data);
        foreach ($data as $k => $v) {
            if (is_string($v))
                $v = "'$v'";
            if ($indexed)
                $string = preg_replace('/\?/', $v, $string, 1);
            else
                $string = str_replace(":$k", $v, $string);
        }
        return $string;
    }

    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = "SELECT category.*, parent.category_title AS parent_title FROM tbl_category category LEFT JOIN tbl_category parent ON category.category_parent_id = parent.pk_category_id
							where category.category_title LIKE '%" . $search_string . "%' 
							ORDER BY category.category_title  
							DESC 
							$strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getCountAllserchCategory($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_category where category_title LIKE '%" . $search_string . "%' ";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

}
