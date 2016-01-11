<?php

class bannermodel extends CI_Model {

    public function __construct() {
        
    }

    /**
     * will get all the records
     *
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function getAllbanner() {
        
        $queryStr = " SELECT * FROM tbl_banner_ads ORDER BY banner_ads_create_date DESC";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getEditAccountType($id) {
        $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_banner_ads'";

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

    /**
     * will get count of all the records 
     */
    
    public function getEditBanner($id) {
        $query = "SELECT * FROM tbl_banner_ads WHERE  pk_banner_ads_id = " . $id . " ";
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

    // function for PDO
    public function add($data) {

        $sql = "INSERT INTO tbl_banner_ads SET "
                . "banner_ads_title =   :banner_ads_title,"
                . "banner_ads_alt =   :banner_ads_alt,"
                . "banner_ads_position =   :banner_ads_position,"
                . "banner_ads_redirect_url  =   :banner_ads_redirect_url,"
                . "banner_ads_status    =   :banner_ads_status,"
                . "banner_ads_banner_type   =   :banner_ads_banner_type,"
                . "fk_affiliate_network_id  =   :fk_affiliate_network_id,"
                . "banner_ads_use_sid   =   :banner_ads_use_sid,"
                . "banner_ads_create_date   =   :banner_ads_create_date";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':banner_ads_title', $data['banner_ads_title'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_alt', $data['banner_ads_alt'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_position', $data['banner_ads_position'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_redirect_url', $data['banner_ads_redirect_url'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_status', $data['banner_ads_status'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_banner_type', $data['banner_ads_banner_type'], PDO::PARAM_STR);
        $statement->bindParam(':fk_affiliate_network_id', $data['fk_affiliate_network_id'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_use_sid', $data['banner_ads_use_sid'], PDO::PARAM_STR);
        $statement->bindParam(':banner_ads_create_date', $data['banner_ads_create_date'], PDO::PARAM_STR);
        //echo $this->parms($sql, $data); die;
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

}
