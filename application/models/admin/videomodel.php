<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class videomodel extends CI_Model
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
	public function getAllVideos(){
		$queryStr 	= " SELECT * from tbl_video ORDER BY video_create_date
						DESC";
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	
	public function getEditAccountType($id) {
      $queryStr = " SELECT * FROM tbl_relation_with_user_account_type where fk_table_name_id = " . $id . " AND relation_with_user_account_type_table_name = 'tbl_video'";
       
       $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
	public function getSearch($page=1,$limit=10,$search_string){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		$queryStr 	= " SELECT * from tbl_video where video_title LIKE '%".$search_string."%' ORDER BY video_create_date
						DESC $strLimit";
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
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

	/**
	 * will get count of all the records 
	 */
	public function getCountAllVideos($search_string){
		if($search_string!=''){
			$queryStr    = "SELECT COUNT(1) as num_rows FROM tbl_video where video_title LIKE '%".$search_string."%'  ";
		}else{
			 $queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_video';
			}
                        
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
           
		return $Row->num_rows; 
	}
	/**
	 * will get count of all the records 
	 */
	public function getCoverPhoto($video_id){
		$queryStr    = "SELECT video_cover_photo  FROM tbl_video Where pk_video_id=".$video_id;
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $queryRS->result_array(); 
	}

	/**
	 * will get info of video 
	 */
	public function getvideoInfo($video_id){
		$queryStr    = "SELECT * from tbl_video WHERE pk_video_id=".$video_id."";
		$queryRS	 = $this->db->query($queryStr);
		if($queryRS->num_rows() > 0){
		   return  $queryRS->row();
		}else{
		  return '';
		}
	}
	
	/**
	 * will get First 4 records records
	 * @return array of records
	 */
	public function getFreshVideos(){
		$queryStr 	= " SELECT * from tbl_video ORDER BY creation_datetime
						DESC LIMIT 4";
		$queryRS	= $this->db->query($queryStr);
		
		 
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	
        
        public function getVideoCategories(){
		$queryStr 	= " SELECT * from tbl_category Where category_parent_id=9";
		$queryRS	= $this->db->query($queryStr);
	
		if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
		
	}
	
	public function getEditVideo($id) {
      $queryStr = " SELECT * FROM tbl_video_to_category where fk_video_id = " . $id ;
       
       $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
}
?>