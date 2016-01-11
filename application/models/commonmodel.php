<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class commonmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getFounder($userId){
        $query = "SELECT ulog.fk_user_account_type_id as user_account_type_id,u.pk_user_id AS userid,u.user_username AS username,u.user_subid AS subid,ac.user_account_type_title,u.*
			FROM 
				tbl_users AS u ,tbl_user_account_type AS ac,
				tbl_user_to_user_account_type_log AS ulog  
			WHERE ulog.fk_user_id = u.pk_user_id AND u.pk_user_id = $userId
			AND ac.pk_user_account_type_id = ulog.fk_user_account_type_id
			AND ac.user_account_type_status != 'Inactive' GROUP BY u.pk_user_id";
        $queryRS = $this->db->query($query);
        $response = $queryRS->result_array();
//        echo '<pre>';        var_dump(reset($response)); die;
        return reset($response);
    }
    
    // function to get user details
    public function getUserDetails($username) {

        $sql = "SELECT ulog.fk_user_account_type_id,ac.user_account_type_title,u.* 
			FROM 
				tbl_users AS u ,tbl_user_account_type AS ac,
				tbl_user_to_user_account_type_log AS ulog  
			WHERE ulog.fk_user_id = u.pk_user_id AND u.user_username = :username 
			AND ac.pk_user_account_type_id = ulog.fk_user_account_type_id
			AND ac.user_account_type_status != 'Inactive' GROUP BY u.pk_user_id";
        $staement = $this->db->conn_id->prepare($sql);
        $staement->bindParam(':username', $username, PDO::PARAM_STR);

        $staement->execute();

        $data = $staement->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
    
    public function getuser_banner_deatail($user_id) {

        $sql = "select * from view_affiliate_banner_info where _member_id ='" . $user_id . "'";
        $queryRS = $this->db->query($sql);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    
    public function getuser_location($user_id) {

        $sql = "select * from view_affiliate_banner_info_location where _member_id ='" . $user_id . "'";
        $queryRS = $this->db->query($sql);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    
    public function isRecordAlreadyExist($record_field, $record, $record_id_field, $record_id, $table) {
        $query = 'SELECT * from ' . $table . ' WHERE ' . $record_field . '="' . $record . '" AND ' . $record_id_field . '!=' . $record_id;

        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Modified by Noman Rauf 5/1/2016
     * Check product already in db or not
     */

    public function isProductAlreadyExist($record_field, $record, $table) {
        $query = 'SELECT * from ' . $table . ' WHERE ' . $record_field . '="' . $record . '"';

        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getaccountInfo($user_id) {

        $query = "SELECT * FROM users Where user_id = " . $user_id;
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function visitor_country() {
        $ip = $_SERVER["REMOTE_ADDR"];
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        $result = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))
                ->geoplugin_countryCode;
        return $result <> NULL ? $result : "Unknown";
    }

    public function verifyUser($username) {

        $query = "Select pk_user_id, user_subid from view_affiliate_banner_info where user_username='" . $username . "' AND user_status = 'Active'";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAccounttype($user_id) {

        $query = "Select fk_user_account_type_id from tbl_user_to_user_account_type_log where fk_user_id='" . $user_id . "' And user_account_log_status = 'Active' ";

        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function curPageURL() {
        $pageURL = 'http';
        if (@$_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
    public function checkUpgradeEnable($accTypeId) {
        $query = "SELECT ap.user_account_properties_account_upgrade AS 'allowed_upgrade'
					FROM tbl_user_account_properties AS ap
					JOIN tbl_user_account_type AS acc_type ON ap.pk_user_account_properties_id = acc_type.fk_user_account_properties_id
					WHERE acc_type.pk_user_account_type_id = '" . $accTypeId . "'";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data[0]['allowed_upgrade'];
        } else {
            $response = false;
        }
        return $response;
    }
    
     public function getemailInfo($id) {
        $query = "select * from tbl_email where pk_email_id=" . $id;
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }
    
    public function getATCategory($fk_user_account_type_id) {

        $query = "Select * from view_store_category_list where acc_type_id = " . $fk_user_account_type_id;
        $queryRS = $this->db->query($query);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getAffiliateNetworkSubidElement($affiliateNetworkId) {
        $query = "SELECT an.affiliate_network_base_url AS url_var
					FROM tbl_affiliate_network AS an
					WHERE an.pk_affiliate_network_id = $affiliateNetworkId";

        $rsQuery = $this->db->query($query);

        if ($rsQuery->num_rows() > 0) {
            $response = $rsQuery->row();
        } else {
            redirect(base_url());
        }

        return $response;
    }
    
    public function insertKarmoraMemberExfil($memberId,$store_id, $storeTitle, $storeUrl, $memberIp) {

        //echo $memberId.'<br>'.$storeTitle.'<br>'.$storeUrl.'<br>'.$memberIp;exit;

        $data = array(
            'fk_user_id' => $memberId,
            'user_exit_karmora_redirect_to_store_name' => $storeTitle,
            'user_exit_karmora_redirect_to_store_url' => $storeUrl,
            'user_exit_karmora_redirect_to_store_id' => $store_id,
            'user_exit_karmora_redirect_to_store_user_ip_address' => $memberIp
        );

        $this->db->insert('tbl_user_exit_karmora_redirect_to_store', $data);
        return;
    }
    public function getNewsTicker($acc_type_id) {
        $queryStr = " SELECT * FROM view_news_ticker WHERE acc_type_id = " . $acc_type_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}

