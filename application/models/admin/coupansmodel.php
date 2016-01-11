<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of coupansmodal
 *
 * @author 
 */
class coupansmodel extends CI_Model {

    //put your code here
    public function addCoupans($passarg, $fk_key) {
        $queryStr = "SELECT * FROM tbl_coupon_raw WHERE coupons_storetitle='" . $passarg['title'] . "' AND "
                . "coupons_storedescription='" . $passarg['description'] . "' AND coupons_code='" . $passarg['code'] . "' AND "
                . "coupons_storelink='" . $passarg['link'] . "' AND fk_affiliate_network_id='" . $fk_key . "'";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() == 0) {
            $sql = "INSERT INTO tbl_coupon_raw SET `coupons_storetitle` = :title  , `coupons_storedescription` = :description ,"
                    . " `coupons_code`= :code, `coupons_begindate` = :begin, `coupons_expiredate` = :expire, "
                    . "`coupons_storelink` = :link, `fk_affiliate_network_id`=:key";
            $statement = $this->db->conn_id->prepare($sql);
            $statement->bindParam(':title', $passarg['title'], PDO::PARAM_STR);
            $statement->bindParam(':description', $passarg['description'], PDO::PARAM_STR);
            $statement->bindParam(':code', $passarg['code'], PDO::PARAM_STR);
            $statement->bindParam(':begin', $passarg['begin'], PDO::PARAM_STR);
            $statement->bindParam(':expire', $passarg['expire'], PDO::PARAM_STR);
            $statement->bindParam(':link', $passarg['link'], PDO::PARAM_STR);
            $statement->bindParam(':key', $fk_key, PDO::PARAM_STR);

            if ($statement->execute()) {

                return true;
            } else {

                return false;
            }
        }
    }

    public function filterCoupons() {
        $queryStr = "SELECT *
FROM tbl_coupon_raw AS c
INNER JOIN tbl_store AS s ON c.coupons_storetitle = s.store_title
WHERE c.fk_affiliate_network_id=s.fk_affiliate_network_id ";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $validCoupon = $queryRS->result_array();

            foreach ($validCoupon as $row) {
                $queryStr = "SELECT * FROM tbl_coupon WHERE coupons_storetitle='" . $row['coupons_storetitle'] . "' AND coupons_storedescription='" . $row['coupons_storedescription'] . "' AND coupons_code='" . $row['coupons_code'] . "' AND coupons_storelink='" . $row['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $row['fk_affiliate_network_id'] . "' ";
                $queryRS = $this->db->query($queryStr);

                if ($queryRS->num_rows() == 0) {
                    $this->addCoupansInner($row);
                }
            }
        } else {
            return '';
        }
//		 $queryStr   =   "SELECT *
//FROM tbl_coupon_raw AS c
//LEFT JOIN tbl_store AS s ON c.coupons_storetitle = s.store_title
//WHERE s.store_title IS NULL
//UNION 
//SELECT *
//FROM tbl_coupon_raw AS c
//LEFT JOIN tbl_store AS s ON c.fk_affiliate_network_id = s.fk_affiliate_network_id
//WHERE s.fk_affiliate_network_id IS NULL ";
        $queryStr = "SELECT c.coupons_storetitle, c.coupons_storedescription, c.coupons_code,c.coupons_begindate,c.coupons_expiredate, c.coupons_storelink, c.fk_affiliate_network_id 
FROM tbl_coupon_raw AS c
LEFT JOIN tbl_store AS s ON c.coupons_storetitle = s.store_title
WHERE s.store_title IS NULL";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $conflict = "Title";
            $conflicCoupon = $queryRS->result_array();
            foreach ($conflicCoupon as $row) {
                $queryStr = "SELECT * FROM tbl_coupon_conflicted WHERE coupons_storetitle='" . $row['coupons_storetitle'] . "' AND coupons_storedescription='" . $row['coupons_storedescription'] . "' AND coupons_code='" . $row['coupons_code'] . "' AND coupons_storelink='" . $row['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $row['fk_affiliate_network_id'] . "' ";
                $queryRS = $this->db->query($queryStr);

                if ($queryRS->num_rows() == 0) {
                    $this->addCoupansConflicted($row, $conflict);
                }
            }
        } else {
            return '';
        } // end of code to fill coupons table

        $queryStr = "SELECT c.coupons_storetitle, c.coupons_storedescription, c.coupons_code,c.coupons_begindate,c.coupons_expiredate, c.coupons_storelink, c.fk_affiliate_network_id 
FROM tbl_coupon_raw AS c
LEFT JOIN tbl_store AS s ON c.fk_affiliate_network_id = s.fk_affiliate_network_id
WHERE s.fk_affiliate_network_id IS NULL";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $conflict = "Network Affiliation";
            $conflicCoupon = $queryRS->result_array();
            foreach ($conflicCoupon as $row) {
                $queryStr = "SELECT * FROM tbl_coupon_conflicted WHERE coupons_storetitle='" . $row['coupons_storetitle'] . "' AND coupons_storedescription='" . $row['coupons_storedescription'] . "' AND coupons_code='" . $row['coupons_code'] . "' AND coupons_storelink='" . $row['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $row['fk_affiliate_network_id'] . "' ";
                $queryRS = $this->db->query($queryStr);

                if ($queryRS->num_rows() == 0) {
                    $this->addCoupansConflicted($row, $conflict);
                }
            }
        } else {
            return '';
        }
    }

    public function addCoupansInner($passarg) {
        $queryStr = "SELECT * FROM tbl_coupon WHERE coupons_storetitle='" . $passarg['coupons_storetitle'] . "' AND "
                . "coupons_storedescription='" . $passarg['coupons_storedescription'] . "' AND coupons_code='" . $passarg['coupons_code'] . "' AND "
                . "coupons_storelink='" . $passarg['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $passarg['fk_affiliate_network_id'] . "' ";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() == 0) {
            $sql = "INSERT INTO tbl_coupon SET `coupons_storetitle`=:title,`coupons_storedescription`=:description,`coupons_code`=:code, `coupons_begindate`=:begin,`coupons_expiredate`=:expire,`coupons_storelink`=:link,`fk_affiliate_network_id`=:key";
            $statement = $this->db->conn_id->prepare($sql);
            $statement->bindParam(':title', $passarg['coupons_storetitle'], PDO::PARAM_STR);
            $statement->bindParam(':description', $passarg['coupons_storedescription'], PDO::PARAM_STR);
            $statement->bindParam(':code', $passarg['coupons_code'], PDO::PARAM_STR);
            $statement->bindParam(':begin', $passarg['coupons_begindate'], PDO::PARAM_STR);
            $statement->bindParam(':expire', $passarg['coupons_expiredate'], PDO::PARAM_STR);
            $statement->bindParam(':link', $passarg['coupons_storelink'], PDO::PARAM_STR);
            $statement->bindParam(':key', $passarg['fk_affiliate_network_id'], PDO::PARAM_STR);

            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function addCoupansConflicted($passarg, $conflict) {

        $queryStr = "SELECT * FROM tbl_coupon WHERE coupons_storetitle='" . $passarg['coupons_storetitle'] . "' AND "
                . "coupons_storedescription='" . $passarg['coupons_storedescription'] . "' AND coupons_code='" . $passarg['coupons_code'] . "' AND "
                . "coupons_storelink='" . $passarg['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $passarg['fk_affiliate_network_id'] . "' ";

        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() == 0) {
            $sql = "INSERT INTO tbl_coupon_conflicted SET `coupons_storetitle`=:title,`coupons_storedescription`=:description,`coupons_code`=:code, "
                    . "`coupons_begindate`=:begin,`coupons_expiredate`=:expire,`coupons_storelink`=:link,`fk_affiliate_network_id`=:key,"
                    . "`coupons_conflict`=:conflict";
            $statement = $this->db->conn_id->prepare($sql);
            $statement->bindParam(':title', $passarg['coupons_storetitle'], PDO::PARAM_STR);
            $statement->bindParam(':description', $passarg['coupons_storedescription'], PDO::PARAM_STR);
            $statement->bindParam(':code', $passarg['coupons_code'], PDO::PARAM_STR);
            $statement->bindParam(':begin', $passarg['coupons_begindate'], PDO::PARAM_STR);
            $statement->bindParam(':expire', $passarg['coupons_expiredate'], PDO::PARAM_STR);
            $statement->bindParam(':link', $passarg['coupons_storelink'], PDO::PARAM_STR);
            $statement->bindParam(':key', $passarg['fk_affiliate_network_id'], PDO::PARAM_STR);
            $statement->bindParam(':conflict', $conflict, PDO::PARAM_STR);
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // function to get coupons for current page for conflicted
    public function getConflicted($page, $limit) {
        $queryStr = "ALTER TABLE tbl_coupon_conflicted ADD INDEX coupons_storetitle (coupons_storetitle)";
        $queryRS = $this->db->query($queryStr);
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit

        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        //$queryStr = "SELECT * FROM view_coupons " . $strLimit; // Query for view
        $queryStr = "SELECT  *
FROM tbl_coupon_conflicted " . $strLimit;


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    // function to get coupons for current page for conflicted
    public function getAllcoupons($page, $limit) {
        $queryStr = "ALTER TABLE tbl_coupon ADD INDEX coupons_storetitle (coupons_storetitle)";
        $queryRS = $this->db->query($queryStr);
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit

        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        //$queryStr = "SELECT * FROM view_coupons " . $strLimit; // Query for view
        $queryStr = "SELECT  *
FROM tbl_coupon " . $strLimit;


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    // function to get count of coupons  
    public function getCountCoupons() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_coupon_conflicted where coupons_status ='Yes'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $Row = $queryRS->row();
            return $Row->num_rows;
        } else {
            return '';
        }
    }

    // function to get count of coupons  
    public function getCountAllCoupons() {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_coupon where coupons_status ='Yes'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $Row = $queryRS->row();
            return $Row->num_rows;
        } else {
            return '';
        }
    }

    public function removeConflict($datas) {

        $queryStr = "SELECT * FROM tbl_coupon_conflicted WHERE coupons_storetitle='" . $datas['store_title'] . "'"
                . "AND fk_affiliate_network_id='" . $datas['fk_affiliate_network_id'] . "' ";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() > 0) {
            $validCoupon = $queryRS->result_array();
            foreach ($validCoupon as $row) {
                $queryStr = "SELECT * FROM tbl_coupon WHERE coupons_storetitle='" . $row['coupons_storetitle'] . "' AND coupons_storedescription='" . $row['coupons_storedescription'] . "' AND coupons_code='" . $row['coupons_code'] . "' AND coupons_storelink='" . $row['coupons_storelink'] . "' AND fk_affiliate_network_id='" . $row['fk_affiliate_network_id'] . "' ";
                $queryRS = $this->db->query($queryStr);
                if ($queryRS->num_rows() == 0) {
                    $this->addCoupansInner($row);
                    $this->deleteConlicted($row['pk_coupons_id']);
                }
            }
        }
    }

    public function deleteConlicted($id) {

        $queryStr = " Delete from tbl_coupon_conflicted WHERE pk_coupons_id='" . $id . "'";
        $this->db->query($queryStr);
    }
    
     // for searching
    public function getSearch($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT * FROM tbl_coupon_conflicted where coupons_storetitle LIKE '%" . $search_string . "%' 
							$strLimit";
        
        
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function getCountSerchCoupon($search_string) {
        $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_coupon_conflicted  where coupons_storetitle LIKE '%" . $search_string . "%' ";
        
        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }
    //MNR CODE
    /*
     * addCoupans function is used to add coupons detail into tbl_coupon
     * @param $couponDetails array
     * return boolen true/false
     */
    
    public function addCoupan($couponDetails) {
        
        
        if(!empty($couponDetails["begin"])){
            $BEGIN = date("Y-m-d H:i:s",strtotime($couponDetails["begin"]));
        }else{
            $BEGIN  = '0000-00-00 00:00:00';
        }
        if(!empty($couponDetails["expire"])){
            $EXPIRE = date("Y-m-d H:i:s",strtotime($couponDetails["expire"]));
        }else{
            $EXPIRE = '0000-00-00 00:00:00';
        }
        $sql = "INSERT INTO 
                    tbl_coupon (
                            coupons_storetitle,
                            coupons_storedescription,
                            coupons_code,
                            coupons_begindate,
                            coupons_expiredate,
                            coupons_storelink,
                            fk_affiliate_network_id
                        )
                    VALUES  (
                            :title,
                            :description,
                            :code,
                            '".$BEGIN."',
                            '".$EXPIRE."',
                            :link,
                            ".$couponDetails['fk_affiliate_network_id']."
                        )";
        
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':title', $couponDetails['title'], PDO::PARAM_STR);
        $statement->bindParam(':description', $couponDetails['description'], PDO::PARAM_STR);
        $statement->bindParam(':code', $couponDetails['code'], PDO::PARAM_STR);
        //$statement->bindParam(':begin', date('Y-m-d H:i:s',strtotime($couponDetails['begin'])), PDO::PARAM_STR);
        //$statement->bindParam(':expire', date('Y-m-d H:i:s',strtotime($couponDetails['expire'])), PDO::PARAM_STR);
        $statement->bindParam(':link', $couponDetails['link'], PDO::PARAM_STR);
        //$statement->bindParam(':networkId', $couponDetails['fk_affiliate_network_id'], PDO::PARAM_STR);
        
        $result = $statement->execute();
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * addConflictCoupon function is used to add coupons detail into tbl_coupon_conflicted
     * @param $couponDetails array
     * return boolen true/false
     */
    public function addConflictCoupon($couponDetails) {
        //$BEGIN = date("Y-m-d H:i:s",strtotime($couponDetails["begin"]));
        //$EXPIRE = date("Y-m-d H:i:s",strtotime($couponDetails["expire"]));
        if(!empty($couponDetails["begin"])){
            $BEGIN = date("Y-m-d H:i:s",strtotime($couponDetails["begin"]));
        }else{
            $BEGIN  = '0000-00-00 00:00:00';
        }
        if(!empty($couponDetails["expire"])){
            $EXPIRE = date("Y-m-d H:i:s",strtotime($couponDetails["expire"]));
        }else{
            $EXPIRE = '0000-00-00 00:00:00';
        }
        $sql = "INSERT INTO
                    tbl_coupon_conflicted (
                            coupons_storetitle,
                            coupons_storedescription,
                            coupons_code,
                            coupons_begindate,
                            coupons_expiredate,
                            coupons_storelink,
                            coupons_conflict,
                            fk_affiliate_network_id
                        )
                    VALUES (
                            :title,
                            :description,
                            :code,
                            '".$BEGIN."',
                            '".$EXPIRE."',
                            :link,
                            :resaon,
                            ".$couponDetails['fk_affiliate_network_id']."
                        )";
        
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':title', $couponDetails['title'], PDO::PARAM_STR);
        $statement->bindParam(':description', $couponDetails['description'], PDO::PARAM_STR);
        $statement->bindParam(':code', $couponDetails['code'], PDO::PARAM_STR);
        //$statement->bindParam(':begin', date('Y-m-d H:i:s',strtotime($couponDetails['begin'])), PDO::PARAM_STR);
        //$statement->bindParam(':expire', date('Y-m-d H:i:s',strtotime($couponDetails['expire'])), PDO::PARAM_STR);
        $statement->bindParam(':link', $couponDetails['link'], PDO::PARAM_STR);
        $statement->bindParam(':resaon', $couponDetails['resaon'], PDO::PARAM_STR);
        //$statement->bindParam(':networkId', $couponDetails['fk_affiliate_network_id'], PDO::PARAM_STR);
        
        $result = $statement->execute();
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * checkStore function is used to check coupon title already have in data base or not
     * @param $couponTitle string coupon title
     * return boolen true/false
     */
    public function checkStore($couponTitle) {
        
        $sql = "SELECT 
                    pk_store_id
                FROM 
                    tbl_store
                WHERE
                    coupon_title = :title";
                
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute(array(':title'=>$couponTitle));
        if ($statement->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }
    public function checkStoreNetwork($couponTitle) {
        
        $sql = "SELECT 
                    fk_affiliate_network_id As cNetwork
                FROM 
                    tbl_store
                WHERE
                    coupon_title = :title";
                
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute(array(':title'=>$couponTitle));
        if ($statement->rowCount()>0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return '';
        }
    }
    //MNR CODE
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
    
    
    //MNR CODE
    /*
     * addCoupans function is used to add coupons detail into tbl_coupon
     * @param $couponDetails array
     * return boolen true/false
     */

    public function addFMTCCoupan($couponDetails) {



        $query = "INSERT INTO tbl_coupon( 
                                    coupons_storetitle,
                                    coupons_storedescription,
                                    coupons_code,
                                    coupons_begindate,
                                    coupons_expiredate,
                                    coupons_storelink,
                                    coupons_status,
                                    fk_affiliate_network_id
                                ) VALUES " . implode(',', $couponDetails);
        $statement = $this->db->conn_id->prepare($query);
        $result = $statement->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * addConflictCoupon function is used to add coupons detail into tbl_coupon_conflicted
     * @param $couponDetails array
     * return boolen true/false
     */

    public function addFMTCConflictCoupon($couponDetails) {

        
        $query = "INSERT INTO tbl_coupon_conflicted( 
                                    coupons_storetitle,
                                    coupons_storedescription,
                                    coupons_code,
                                    coupons_begindate,
                                    coupons_expiredate,
                                    coupons_storelink,
                                    coupons_status,
                                    fk_affiliate_network_id,
                                    coupons_conflict
                                ) VALUES " . implode(',', $couponDetails);
        $statement = $this->db->conn_id->prepare($query);
        $result = $statement->execute();
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
