<?php 
class menumodel extends CI_Model {


    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	//This function will fetch detail of all pages from DB
	function getAllMenu($page,$limit){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = "SELECT * from tbl_menu order by menu_create_date DESC $strLimit";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	
	//This function will fetch detail search from DB
	function getSearch($page,$limit,$serch_string){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = "SELECT * from tbl_menu where menu_title LIKE '%".$serch_string."%' order by menu_create_date DESC $strLimit";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	    // for user Type
    public function getUserAccountType() {
     echo   $queryStr = " SELECT * FROM tbl_user_account_type";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }


	public function getmenuInfo($menu_id){
		$queryStr    = "SELECT * from tbl_menu WHERE pk_menu_id=".$menu_id."";
		$queryRS	 = $this->db->query($queryStr);
		if($queryRS->num_rows() > 0){
		   return  $queryRS->row();
		}else{
		  return '';
		}
	}
        
	//This function will fetch detail of all pages from DB
	function getAllItemMenu($page,$limit){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = "SELECT c.*,d.menu_items_title AS parent_title  FROM tbl_menu_items c
						LEFT JOIN tbl_menu_items d  ON c.menu_items_parent_id = d.pk_menu_items_id ORDER BY c.menu_items_create_date DESC $strLimit";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	
//This function will fetch detail search from DB
	function getItemSearch($page,$limit,$serch_string){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = "SELECT c.*,d.menu_items_title AS parent_title  FROM tbl_menu_items c
						LEFT JOIN tbl_menu_items d  ON c.menu_items_parent_id = d.pk_menu_items_id where c.menu_items_title LIKE '%".$serch_string."%'  ORDER BY c.menu_items_create_date DESC $strLimit";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	
	public function getCountAllitemmenu($search_string='')
	{
		
		if($search_string!=''){
			$queryStr    = "SELECT COUNT(1) as num_rows FROM tbl_menu_items where menu_items_title LIKE '%".$search_string."%'  ";
		}else{
			$queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_menu_items';
			}
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	public function getCountAllmenu($search_string='')
	{
		if($search_string!=''){
			$queryStr    = "SELECT COUNT(1) as num_rows FROM tbl_menu where menu_title LIKE '%".$search_string."%'  ";
		}else{
			$queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_menu';
			}
		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	public function getCountAllLocationmenu($search_string='')
	{
		if($search_string!=''){
			$queryStr    = "SELECT COUNT(1) as num_rows FROM tbl_menu_location where menu_location_title LIKE '%".$search_string."%'  ";
		}else{
			$queryStr    = 'SELECT COUNT(1) as num_rows FROM tbl_menu_location';
			}

		$queryRS	 = $this->db->query($queryStr);
		$Row         = $queryRS->row();
		return $Row->num_rows; 
	}
	
	//this function will fetch page details of a specific page from DB
	public function getSinglePageDetail($id){
		$query	= "SELECT * FROM tbl_page WHERE pk_page_id=".$id.";";
		$result	= $this->db->query($query);
		
		if($result->num_rows() > 0){
		   return  $result->row();
		}else{
		  return '';
		}
	}
	
	
	//this function will fetch page details of a specific page from DB
	public function getIntereatedpage($page_inheritance){
		$query	= "SELECT * FROM tbl_menu_items WHERE menu_items_inheritance != 'Child'";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	//this function will fetch page details of a specific page from DB
	public function getmenulist(){
		$query	= "SELECT * FROM tbl_menu WHERE menu_status != 'Inactive'";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	//This function will fetch detail of all pages from DB
	function getAllItemMenuLocation($page,$limit){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = " SELECT m.*,p.page_title,me.menu_title FROM tbl_menu_location m , tbl_page p , tbl_menu me
						WHERE m.fk_menu_id = me.pk_menu_id AND m.fk_page_id = p.pk_page_id
					 	ORDER BY m.menu_location_create_date  DESC $strLimit";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
//This function will fetch detail search from DB
	function getMenuLocationSearch($page,$limit,$serch_string){
		$lowerLimit = ($page - 1)*$limit;//creating the lower limit
		$strLimit 	= " LIMIT $lowerLimit, $limit";//limit string
		
		$query = " SELECT m.*,p.page_title,me.menu_title FROM tbl_menu_location m , tbl_page p , tbl_menu me
						WHERE m.fk_menu_id = me.pk_menu_id AND m.fk_page_id = p.pk_page_id and m.menu_location_title LIKE '%".$serch_string."%'
					 	ORDER BY m.menu_location_create_date  DESC $strLimit";
						
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}
	
	
		//this function will fetch page details of a specific page from DB
	public function getpagelist(){
		$query	= "SELECT * FROM tbl_page WHERE page_status = 'Published' and page_current_version = 1";
		$result = $this->db->query($query);
		if($result->num_rows() > 0){
		   return $result->result_array();
		}else{
		  return '';
		}
	}

    
}
?>