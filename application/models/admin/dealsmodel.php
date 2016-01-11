<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dealsmodel
 *
 * @author Baig
 */
class dealsmodel extends CI_Model {

    public function getParentCategories() {
        // change parent category id to your parent category id
        $sql = "select * from tbl_category  where category_parent_id = 73";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getAllStoresByCategory($cat_id = NULL) {
        $sql = "SELECT * FROM tbl_store AS s LEFT JOIN tbl_store_to_category AS sc ON s.pk_store_id = sc.fk_store_id LEFT JOIN tbl_category AS c ON sc.fk_category_id = c.pk_category_id
                                WHERE sc.fk_category_id =  $cat_id AND store_status = 'Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getStoresById($id) {
        $sql = "select * from tbl_store where pk_store_id = $id AND store_status = 'Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        print_r($result); exit;
        if (count($result) > 0) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

    public function getCategoryDetail($id) {
        $sql = "select * from tbl_category where pk_category_id = $id";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

    public function getUsers() {
        $sql = "SELECT fk_user_id FROM tbl_email_type_to_user_relation WHERE fk_email_type_id = 5 AND email_type_to_user_relation_status ='Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getUserEmail($user_id) {
        $sql = "SELECT
                    `u`.`user_email` AS `email`
                    FROM ((`karmora_v2_2`.`tbl_users` `u`
                    LEFT JOIN `karmora_v2_2`.`tbl_user_to_user_account_type_log` `acc_log`
                    ON ((`u`.`pk_user_id` = `acc_log`.`fk_user_id`)))
                    LEFT JOIN `karmora_v2_2`.`tbl_user_account_type` `acc_type`
                    ON ((`acc_log`.`fk_user_account_type_id` = `acc_type`.`pk_user_account_type_id`)))
                    WHERE (`acc_log`.`user_account_log_status` = 'active') AND acc_log.`fk_user_account_type_id` =" . $user_id . " AND u.user_status = 'Active'";
        

        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

}
