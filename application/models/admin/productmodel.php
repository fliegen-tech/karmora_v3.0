<?php

class productModel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //This function will fetch detail of all product from DB
    public function getAllproduct() {

        $queryStr = " SELECT * FROM tbl_products ORDER BY product_creation_date_time DESC";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getEditproduct($product_id) {

        $query = "SELECT * FROM tbl_products Where pk_product_id = " . $product_id;
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    // function for PDO
    public function add($data) {

        $sql = "INSERT INTO tbl_products SET "
                . "product_name =   :product_title,"
                . "product_sku =   :product_sku,"
                . "fk_magento_id  =   :fk_magento_id,"
                . "product_short_description    =   :product_short_description,"
                . "prodcut_description    =   :product_description,"
                . "product_price   =   :product_price,"
                . "product_image   = :product_image,"
                . "product_creation_date_time   =   :product_creation_date_time,"
                . "product_updation_date_time   =   :product_updation_date_time";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':product_title', $data['product_title'], PDO::PARAM_STR);
        $statement->bindParam(':product_sku', $data['product_sku'], PDO::PARAM_STR);
        $statement->bindParam(':fk_magento_id', $data['fk_magento_id'], PDO::PARAM_STR);
        $statement->bindParam(':product_short_description', $data['product_short_description'], PDO::PARAM_STR);
        $statement->bindParam(':product_description', $data['product_description'], PDO::PARAM_STR);
        $statement->bindParam(':product_price', $data['product_price'], PDO::PARAM_STR);
        $statement->bindParam(':product_image', $data['product_image'], PDO::PARAM_STR);
        $statement->bindParam(':product_creation_date_time', $data['product_creation_date_time'], PDO::PARAM_STR);
        $statement->bindParam(':product_updation_date_time', $data['product_updation_date_time'], PDO::PARAM_STR);
        //echo $this->parms($sql, $data);
        if ($result = $statement->execute()) {
            $inserId = $this->db->conn_id->lastInsertId();
            return $inserId;
        } else {
            return FALSE;
        }
    }

    /*Update magento product to karmora db*/
    public function update($data) {
        $sql = "UPDATE tbl_products SET "
                    . "product_name                 =   :product_title,"
                    . "product_sku                  =   :product_sku,"
                    . "fk_magento_id                =   :fk_magento_id,"
                    . "product_short_description    =   :product_short_description,"
                    . "prodcut_description          =   :product_description,"
                    . "product_price                =   :product_price,"
                    . "product_image                =   :product_image,"
                    . "product_updation_date_time   =   :product_updation_date_time"
                    . " WHERE fk_magento_id         =   :product_id";

        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':product_title', $data['product_title'], PDO::PARAM_STR);
        $statement->bindParam(':product_sku', $data['product_sku'], PDO::PARAM_STR);
        $statement->bindParam(':fk_magento_id', $data['fk_magento_id'], PDO::PARAM_STR);
        $statement->bindParam(':product_short_description', $data['product_short_description'], PDO::PARAM_STR);
        $statement->bindParam(':product_description', $data['product_description'], PDO::PARAM_STR);
        $statement->bindParam(':product_price', $data['product_price'], PDO::PARAM_STR);
        $statement->bindParam(':product_image', $data['product_image'], PDO::PARAM_STR);
        $statement->bindParam(':product_updation_date_time', $data['product_updation_date_time'], PDO::PARAM_STR);
        $statement->bindParam(':product_id', $data['product_id'], PDO::PARAM_STR);
        //echo $this->parms($sql, $data);
        if ($result = $statement->execute()) {
            $inserId = $this->db->conn_id->lastInsertId();
            return $inserId;
        } else {
            return FALSE;
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
    
     public function getProductCategories(){
		$queryStr 	= " SELECT * from tbl_category Where category_parent_id = 78";
		$queryRS	= $this->db->query($queryStr);
	
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
    public function getEditProductCategories($id) {
      $queryStr = " SELECT * FROM tbl_relation_product_with_category where fk_product_id = " . $id ;
       
       $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }    

}
