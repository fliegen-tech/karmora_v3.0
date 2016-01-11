<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class managewhereiskevinmodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAllwintit($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.promation_type = 'whereiskevin' and tbl_promations.status = 0   ORDER BY tbl_promations.promation_pk_id DESC  $strLimit";
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
        $queryStr = " SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
					  where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.status = 0 and tbl_promations.promation_type = 'whereiskevin' and   tbl_users.user_username LIKE '%" . $search_string . "%' group by tbl_promations.fk_user_id 
					  ORDER BY tbl_promations.promation_pk_id DESC  $strLimit";
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
    public function getCountSerchprize($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_promations where promation_type = 'whereiskevin'";
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getCountAllwintit() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where promation_type = "whereiskevin" and status = 0 ';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getCountStatus($status) {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where status = ' . $status . ' and promation_type = "whereiskevin"';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getStatusFVideo($status, $page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.status = " . $status . " and tbl_promations.promation_type = 'whereiskevin' ORDER BY tbl_promations.promation_pk_id DESC  $strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    public function getapprovewintit($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT tbl_promations.*,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id  and tbl_promations.status =1 and tbl_promations.promation_type = 'whereiskevin' ORDER BY tbl_promations.promation_pk_id DESC  $strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    public function getrejectedwintit($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string

        $queryStr = "SELECT tbl_promations.*,LEFT(tbl_promations.comments, 100) AS detail,tbl_users.user_username FROM tbl_promations,tbl_users
						where tbl_users.pk_user_id = tbl_promations.fk_user_id and tbl_promations.status = 2 and tbl_promations.promation_type = 'whereiskevin' ORDER BY tbl_promations.promation_pk_id DESC  $strLimit";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    public function getCountapprovewintit() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where status =1 and promation_type = "whereiskevin"';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getCountrejectedwintit() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_promations where status =2 and promation_type = "whereiskevin"';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }
    
    public function getVideoDetail($promotionId) {
        $sql   =   "select content from tbl_promations where promation_pk_id = $promotionId";
        $statement  = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result =   $statement->fetchAll(PDO::FETCH_ASSOC);
        if(count($result)>0) {
            return $result[0]['content'];
        }
        else {
            return FALSE;
        }
    }

}

?>