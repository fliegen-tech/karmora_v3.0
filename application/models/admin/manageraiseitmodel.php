<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manageraiseitmodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAllfundazaing($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT fa.* , ts.user_address_state_title 
                            FROM tbl_fundrasing_application AS fa ,tbl_user_address_state AS ts
                            WHERE
                            ts.pk_user_address_state_id = fa.organization_state_id
                              $strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT fa.* , ts.user_address_state_title 
                            FROM tbl_fundrasing_application AS fa ,tbl_user_address_state AS ts
                            WHERE
                            ts.pk_user_address_state_id = fa.organization_state_id
						AND fa.organization_name LIKE '%" . $search_string . "%' $strLimit";
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
    public function getCountAllfundazaing($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_fundrasing_application where organization_name LIKE '%" . $search_string . "%'";
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getfundazaingDetail($pk_fundrasing_application_id) {


        $queryStr = "SELECT fa.* , ts.user_address_state_title 
                            FROM tbl_fundrasing_application AS fa ,tbl_user_address_state AS ts
                            WHERE
                            ts.pk_user_address_state_id = fa.organization_state_id 
                            AND fa.pk_fundrasing_application_id = " . $pk_fundrasing_application_id;
        $queryRS = $this->db->query($queryStr);
        $row = $queryRS->row();

        return $row;
    }
    
    public function addFundraising($data) {
         // echo "<pre>";
          
          //print_r($data); exit;
        
        $referrer_id    =   $data['fk_user_id_referrer'];
        $registration_date  =   $data['user_registration_date'];
        $first_name =   $data['user_first_name'];
        $last_name  =   $data['user_last_name'];
        $username   =   $data['user_username'];
        $phone_num  =   $data['user_phone_no'];
        $user_email =   $data['user_email'];
        $user_password  =   $data['user_password'];
        $ip_address =   $data['user_registration_ip_address'];
        $subid  =   $data['user_subid'];
        $status =   $data['user_status'];
        $amazon_active  =   $data['user_amazon_active'];
        $first_login    =   $data['first_login'];
        $fundraising_name   =   $data['fundraising_name'];
        
      $sql    =   "insert into tbl_users set "
                . "user_first_name = '$first_name',"
                . "user_last_name    =   '$last_name',"
                . "user_username    =   '$username',"
                . "user_phone_no    =   '$phone_num',"
                . "user_email   =   '$user_email',"
                . "user_password    =   '$user_password',"
                . "user_registration_ip_address =   '$ip_address',"
                . "user_subid   =   '$subid',"
                . "user_status  =   '$status',"
                . "fk_user_id_referrer = $referrer_id,"
                . "user_amazon_active = '$amazon_active',"
                . "first_login  =   $first_login,"
               . "fundraising_name  =   '$fundraising_name',"
                . "user_registration_date   =   now()";
        $statement  = $this->db->conn_id->prepare($sql);
        
        //echo $this->parms($sql, $data); exit;
        if($statement->execute()) {
            return $this->db->conn_id->lastInsertId();
        }
        else {
            return FALSE;
        }
    }
    
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

?>