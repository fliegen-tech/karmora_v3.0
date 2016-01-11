<?php

class storemodel extends CI_Model {

    public function __construct() {
        
    }

    /**
     * will get all the records
     *
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function getAllstore() {
        //$lowerLimit = ($page - 1) * $limit; //creating the lower limit
        //$strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT DISTINCT store.*, (SELECT cat.category_alias FROM tbl_category AS cat WHERE cat.pk_category_id = category.category_parent_id ) AS cat_parent_alias
        FROM tbl_store AS store 
		JOIN tbl_store_to_category AS sc ON store.pk_store_id = sc.fk_store_id
		LEFT JOIN tbl_category AS category ON sc.fk_category_id = category.pk_category_id
		WHERE 1";
							
        $queryRS = $this->db->query($queryStr);
       
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getfilterStore($page = 1, $limit = 10, $ajexcall) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        //echo $ajexcall;
        if($ajexcall === 'trending') {
            $cat_id =   5;
        }
        else if($ajexcall === 'stores') {
            $cat_id = 6;
        }
        else if($ajexcall === 'special_deals') {
            $cat_id = 96;
        }
        $table = ' view_stores_list_' . $ajexcall;
         $queryStr = " SELECT DISTINCT *, (SELECT cat.category_alias FROM tbl_category AS cat WHERE cat.pk_category_id = category.category_parent_id ) AS cat_parent_alias
        FROM tbl_store AS store 
		JOIN tbl_store_to_category AS sc ON store.pk_store_id = sc.fk_store_id
		LEFT JOIN tbl_category AS category ON sc.fk_category_id = category.pk_category_id
		WHERE category.category_parent_id = $cat_id
	    order by  store.store_title ASC
							$strLimit";
       
       
       $queryRS = $this->db->query($queryStr);
        
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
      public function getOffers() {
        
        $ajexcall === 'special_deals';
            $cat_id = 73;
        
        $table = ' view_stores_list_' . $ajexcall;
         $queryStr = " SELECT DISTINCT *, (SELECT cat.category_alias FROM tbl_category AS cat WHERE cat.pk_category_id = category.category_parent_id ) AS cat_parent_alias
        FROM tbl_store AS store 
		JOIN tbl_store_to_category AS sc ON store.pk_store_id = sc.fk_store_id
		LEFT JOIN tbl_category AS category ON sc.fk_category_id = category.pk_category_id
		WHERE category.category_parent_id = $cat_id
	    order by  store.store_title ASC
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
    public function getCountAllStore($filter="") {
        if($filter!=""){
        if($filter == 'trending') {
            $cat_id =   5;
        }
        else if($filter == 'stores') {
            $cat_id = 6;
        }
        
        $queryStr = "SELECT  COUNT(1) as num_rows FROM tbl_store AS store 
                JOIN tbl_store_to_category AS sc ON store.pk_store_id = sc.fk_store_id
		LEFT JOIN tbl_category AS category ON sc.fk_category_id = category.pk_category_id
		WHERE category.category_parent_id =".$cat_id;
     
   
        }else{
            
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_store";   
            
        }
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getStoreInfo($id) {
        $query = "SELECT * FROM tbl_store WHERE  pk_store_id = " . $id . " ";
        $QueryR = $this->db->query($query);

        $row = $QueryR->row();

        return $row;
    }

    public function getAffiliate() {
        $query = 'SELECT * FROM tbl_affiliate_network ';

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    //this function will fetch page details of a specific page from DB
    public function getStoretype($parent_id) {
        $query = "SELECT * FROM tbl_category WHERE category_parent_id = " . $parent_id;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }

    public function getCategories($category_id) {
        $query = 'SELECT * FROM tbl_category WHERE category_parent_id = (SELECT pk_category_id FROM tbl_category WHERE pk_category_id = "' . $category_id . '") ';

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function getEditStoreType($category_id) {
        $query = 'SELECT s.store_title, cat.category_title,  cat.category_parent_id
					FROM tbl_store AS s
					JOIN tbl_store_to_category AS r_sc ON s.pk_store_id = r_sc.fk_store_id
					JOIN tbl_category AS cat ON r_sc.fk_category_id = cat.pk_category_id
					WHERE s.pk_store_id = ' . $category_id;

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function getAccountToStores($store_id) {
        $query = 'SELECT r.*,r.pk_store_to_user_account_type_id as rel_id,
                        a.user_account_type_title as account_title,
                        r.store_to_user_account_type_commission_percentage as com_per 
                    FROM tbl_store s,tbl_user_account_type a,tbl_store_to_user_account_type r 
                    WHERE s.pk_store_id=r.fk_store_id AND a.pk_user_account_type_id=r.fk_user_account_type_id AND s.pk_store_id=' . $store_id;

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function getCategoryToStores($store_id) {
        $query = 'SELECT r.*,
                        c.category_title       
                    FROM tbl_store s,tbl_store_to_category r,tbl_category c 
                    WHERE s.pk_store_id=r.fk_store_id AND c.pk_category_id=r.fk_category_id AND s.pk_store_id=' . $store_id;

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    public function getAccountTypes($store_id) {
        $query = 'SELECT * FROM tbl_user_account_type Where pk_user_account_type_id NOT '
                . 'IN(select fk_user_account_type_id from tbl_store_to_user_account_type where fk_store_id=' . $store_id . ') ';

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
//        $queryStr = " SELECT * FROM tbl_store where store_title LIKE '%" . $search_string . "%'
//							ORDER BY store_create_date
//							DESC 
//							$strLimit";
        $queryStr = "SELECT DISTINCT s.*, (SELECT c.category_alias FROM tbl_category AS c 
                                                        WHERE c.pk_category_id = (SELECT cp.category_parent_id FROM tbl_category AS cp 
                                                                WHERE cp.pk_category_id = sc.fk_category_id)) AS cat_parent_alias
                    FROM tbl_store AS s
                    JOIN tbl_store_to_category AS sc ON s.pk_store_id = sc.fk_store_id
                    WHERE store_title LIKE '%" . $search_string . "%'
                    ORDER BY store_create_date DESC 
                    $strLimit";
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getCountSerchstore($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_store  where store_title LIKE '%" . $search_string . "%' ";
        
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }
    
    public function getStoreToCatRelation($storeId ,$catId)
    {
        $query = "SELECT * FROM tbl_store_to_category AS sc WHERE sc.fk_store_id = $storeId AND sc.fk_category_id = $catId";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(count($data)>0) {
                $response =  TRUE;
        }
        else {
                $response = FALSE;
        }
        return $response;
    }
    
    public function getStoreToAccTypeRelation($storeId ,$accType)
    {
        $query = "SELECT * FROM tbl_store_to_user_account_type AS sa WHERE sa.fk_store_id = $storeId AND sa.fk_user_account_type_id = $accType";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(count($data)>0) {
                $response =  TRUE;
        }
        else {
                $response = FALSE;
        }
        return $response;
    }
}
