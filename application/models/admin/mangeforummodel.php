<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mangeforummodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * will get all the records
     *
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function getAllForum($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT tbl_forum.* ,tbl_users.user_username , COUNT(tbl_forum_comments.tbl_forum_pk_comment_id )AS comment_count 
								FROM tbl_users,tbl_forum LEFT JOIN tbl_forum_comments 
								ON tbl_forum.forum_pk_id=tbl_forum_comments.tbl_forum_fk_qusetion_id
								WHERE tbl_users.pk_user_id = tbl_forum.forum_fk_user_id
								GROUP BY tbl_forum.forum_pk_id 
								ORDER BY tbl_forum.forum_pk_id DESC  $strLimit";
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
        $queryStr = " SELECT tbl_forum.* ,tbl_users.user_username , COUNT(tbl_forum_comments.tbl_forum_pk_comment_id )AS comment_count 
								FROM tbl_users,tbl_forum LEFT JOIN tbl_forum_comments 
								ON tbl_forum.forum_pk_id=tbl_forum_comments.tbl_forum_fk_qusetion_id
								WHERE tbl_users.pk_user_id = tbl_forum.forum_fk_user_id and  tbl_forum.forum_qu_title LIKE '%" . $search_string . "%'
								GROUP BY tbl_forum.forum_pk_id 
								ORDER BY tbl_forum.forum_pk_id DESC  $strLimit";
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
    public function getCountSerchForum($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_forum where forum_qu_title LIKE '%" . $search_string . "%'";
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getCountAllForum() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_forum';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getAllComment($page = 1, $limit = 10) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT tbl_forum_comments.*,tbl_users.user_username
						FROM tbl_forum_comments,tbl_users 
						WHERE tbl_forum_comments.tbl_forum_fk_user_id = tbl_users.pk_user_id
						ORDER BY tbl_forum_comments.tbl_forum_pk_comment_id DESC  $strLimit";
        $queryRS = $this->db->query($queryStr);


        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }

    public function getCountAllComment() {
        $queryStr = 'SELECT COUNT(1) as num_rows FROM tbl_forum_comments';

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function getForummdeatil($forum_pk_id) {

        $queryStr = "SELECT tbl_forum.* ,tbl_users.user_username , 
                        COUNT(tbl_forum_comments.tbl_forum_pk_comment_id )AS comment_count 
                        FROM tbl_users,tbl_forum LEFT JOIN tbl_forum_comments 
                        ON tbl_forum.forum_pk_id=tbl_forum_comments.tbl_forum_fk_qusetion_id 
                        WHERE tbl_users.pk_user_id = tbl_forum.forum_fk_user_id  AND tbl_forum.forum_pk_id = ".$forum_pk_id."
                        GROUP BY tbl_forum.forum_pk_id ORDER BY tbl_forum.forum_pk_id ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

}

?>