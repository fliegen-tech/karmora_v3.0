<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usermodel
 *
 * @author WAQAS
 */
class usermodel extends CI_Model {

    public function getAllUsers($page, $limit) {

        $lowerLimit = ($page - 1) * $limit; //creating the lower limit

        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT  *
FROM tbl_users " . $strLimit;


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    // function to get user for current page 
    public function getThisUsers($page, $limit, $user_id) {

        $lowerLimit = ($page - 1) * $limit; //creating the lower limit

        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = "select * from tbl_users 
          " . $strLimit;

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    // function to get count of users  
    public function getCountAllUsers() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_users";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $Row = $queryRS->row();
            return $Row->num_rows;
        } else {
            return '';
        }
    }

    // function to get user for ID
    public function getSingleUser($userID) {


        $queryStr = "select *, p.profile_pic AS 'profile_user_picture_image_name' from tbl_users u LEFT JOIN view_affiliate_banner_info_profile_picture p ON u.pk_user_id= p.id  where pk_user_id ='".$userID."' AND p.profile_pic_status = 'active'";
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
      // function to get user for ID
    public function getRefralUser($userID) {


        $queryStr = "select user_username from tbl_users  where pk_user_id ='".$userID."'";
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
     public function updateUser($passarg,$UserID) {
//              echo "<pre>";
//              print_r($passarg);
//              exit;
            $sql = "UPDATE tbl_users SET `user_first_name`=:user_first_name,`user_last_name`=:user_last_name,`user_subid`=:user_subid, "
                    . "`user_amazon_active`=:user_amazon_active,`user_status`=:user_status where `pk_user_id`   =   $UserID";
            $statement = $this->db->conn_id->prepare($sql);
            $statement->bindParam(':user_first_name', $passarg['user_first_name'], PDO::PARAM_STR);
            $statement->bindParam(':user_last_name', $passarg['user_last_name'], PDO::PARAM_STR);
            $statement->bindParam(':user_subid', $passarg['user_subid'], PDO::PARAM_STR);
            $statement->bindParam(':user_amazon_active', $passarg['user_amazon_active'], PDO::PARAM_STR);
            $statement->bindParam(':user_status', $passarg['user_status'], PDO::PARAM_STR);
            
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        
    }
    
       // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        echo $queryStr = " SELECT * FROM tbl_users where user_first_name LIKE '%" . $search_string . "%' OR user_last_name LIKE '%" . $search_string . "%'
							$strLimit";
        
        
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
     public function getCountSerchUser($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_users where user_first_name LIKE '%" . $search_string . "%' OR user_last_name LIKE '%" . $search_string . "%' ";
        
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }
    
        public function searchUser($page = 1, $limit = 10, $search_string,$search_string_2) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
         $queryStr = " SELECT * FROM tbl_users where ".$search_string." LIKE '%" . $search_string_2 . "%' $strLimit";
        
        
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
     public function getCountMatchUser($search_string,$search_string_2) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_users where ".$search_string." LIKE '%" . $search_string_2 . "%'";
        
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

}
