<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mangepostmodel extends CI_Model
{
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
	public function getAllPost($page=1,$limit=10){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		 $queryStr 	= " SELECT tbl_blog_posts.* ,op.admin_operator_username as username , COUNT(tbl_blog_comments.pk_comment_id )AS 
						comment_count FROM tbl_admin_operator op,tbl_blog_posts LEFT JOIN tbl_blog_comments 
						ON tbl_blog_posts.pk_post_id=tbl_blog_comments.fk_post_id 
						WHERE op.pk_admin_operator_id = tbl_blog_posts.fk_user_id GROUP BY tbl_blog_posts.pk_post_id
						 ORDER BY tbl_blog_posts.pk_post_id DESC ".$strLimit;
						
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	

    // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = "  SELECT tbl_blog_posts.* ,op.admin_operator_username as username , COUNT(tbl_blog_comments.pk_comment_id )AS 
						comment_count FROM tbl_admin_operator op,tbl_blog_posts LEFT JOIN tbl_blog_comments 
						ON tbl_blog_posts.pk_post_id=tbl_blog_comments.fk_post_id 
						WHERE op.pk_admin_operator_id = tbl_blog_posts.fk_user_id and tbl_blog_posts.post_title LIKE '%" . $search_string . "%' GROUP BY tbl_blog_posts.pk_post_id
						 ORDER BY tbl_blog_posts.pk_post_id DESC ".$strLimit;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	
	
	public function getCountAllPost()
	{
		$queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_blog_posts';
		
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	public function getCountAllSerchPost($search_string)
	{
		$queryStr    = "SELECT COUNT(1) as num_rows FROM tbl_blog_posts where post_title LIKE '%" . $search_string . "%'";
		
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	
	public function getAllComment($page=1,$limit=10){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		$queryStr 	= "SELECT tbl_blog_comments.*,tbl_users.user_username 
							FROM tbl_blog_comments,tbl_users WHERE tbl_blog_comments.fk_user_id = tbl_users.pk_user_id 
							ORDER BY tbl_blog_comments.pk_comment_id DESC $strLimit"; 
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	
	
	public function getCountAllComment()
	{
		$queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_blog_comments';
		
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	public function getblogCategory(){
		
		$queryStr 	= "SELECT * From tbl_category where category_parent_id = 8"; 
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	public function getFeaturedBlogs(){
		
		 $queryStr 	= "SELECT fk_blog_id From tbl_featured_blog"; 
	
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
	
		   $res=$queryRS->result_array();
		   return array($res[0]['fk_blog_id'],$res[1]['fk_blog_id']);
		}else
			return '';	
		
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
	
	
	public function getpostInfo($post_id) {
        $query = "SELECT * FROM tbl_blog_posts WHERE  pk_post_id = " . $post_id . " ";
        $QueryR = $this->db->query($query);

        $row = $QueryR->row();

        return $row;
    }
	 public function getPostComments($post_id) {
        $queryStr = "SELECT * FROM tbl_blog_comments Where fk_post_id=".$post_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	
	 public function getFeaturedBlog() {
         $queryStr = "SELECT fk_blog_id from tbl_featured_blog";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
			$res=$queryRS->result_array();
            return array($res[0]['fk_blog_id'],$res[1]['fk_blog_id']);
        } else {
            return '';
        }
    }
}
?>