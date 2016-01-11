<?php

class reportmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //this function will fetch page details of a specific page from DB
    public function getUserId($traking_id) {
        $query = "SELECT pk_user_id FROM tbl_users WHERE user_subid ='" . $traking_id . "'";

        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row()->pk_user_id;
        } else {
            return '';
        }
    }

    public function getNetworkId($net_name) {
        $query = "SELECT pk_affiliate_network_id FROM tbl_affiliate_network WHERE affiliate_network_name ='" . $net_name . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row()->pk_affiliate_network_id;
        } else {
            return '';
        }
    }

    public function getFileName($id) {
        $query = "SELECT user_sales_file_name_import FROM tbl_sales_file WHERE pk_user_sales_file_id =" . $id;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getFirstEntry($user_id) {
        $query = "SELECT user_account_cash_back_properties_commission_percentage AS comm_percentage,
					typ.pk_user_account_type_id as account_type_id
						FROM tbl_user_to_user_account_type_log lg 
							JOIN tbl_user_account_type typ 
								ON  typ.pk_user_account_type_id=lg.fk_user_account_type_id 
							JOIN  tbl_user_account_cash_back_properties cbp 
								ON typ.fk_user_account_cash_back_properties_id=cbp.pk_user_account_cash_back_properties_id 
						WHERE fk_user_id=" . $user_id . " AND typ.user_account_type_status='Active'";

        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getComessionPercenatgeSecond($user_id, $account_type_first) {
        $query = "SELECT user_account_allowed_community_override_commission as allowed_commession,mycom.referrer as reffer_id
						 FROM view_my_community mycom 
						 JOIN tbl_user_to_user_account_type_log lg
							ON mycom.referrer=lg.fk_user_id
						JOIN  tbl_user_account_allowed_community alwcom
							ON lg.fk_user_account_type_id=alwcom.fk_tbl_user_account_type_id_this
								AND alwcom.fk_tbl_user_account_type_id_registration_allowed=" . $account_type_first . " 
						WHERE mycom.user_id=" . $user_id;


        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function insertData($table_name, $data) {

        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function saveToCashBack($fk_user_id, $amount, $sale_id, $reffer = "") {
        if ($reffer == "") {
            $this->db->conn_id->exec("insert into tbl_user_cash_back(fk_user_id,"
                    . "user_cash_back_amount,user_cash_back_status,fk_sales_id) VALUES(" . $fk_user_id . ",TRUNCATE(" . $amount . ",2),'pending'," . $sale_id . ")");
        } else {

            $this->db->conn_id->exec("insert into tbl_user_cash_back(fk_user_id,"
                    . "user_cash_back_amount,fk_user_id_referral,user_cash_back_status,fk_sales_id) VALUES(" . $fk_user_id . ", TRUNCATE(" . $amount . ",2)," . $reffer . ",'pending'," . $sale_id . ")");
        }
        return $this->db->conn_id->lastInsertId();
    }

    public function saveToCob($cob, $sale_id) {

        $this->db->conn_id->exec("insert into tbl_cob(fk_business_id,"
                . "cob_amount,cob_status,fk_sale_id) VALUES(1, TRUNCATE(" . $cob . ",2),'pending'," . $sale_id . ")");

        return $this->db->conn_id->lastInsertId();
    }

    public function getAllSales($page, $limit, $filter) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit

        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        if ($filter == "" || $filter == 'all') {
            $query = "SELECT s.*,a.affiliate_network_name from tbl_sales s,tbl_affiliate_network a Where 		
				a.pk_affiliate_network_id=s.fk_affiliate_network_id AND	sales_processing_status='processed'  ORDER BY pk_sales_id DESC $strLimit";
        } else {
            $query = "SELECT s.*,a.affiliate_network_name from tbl_sales s,tbl_affiliate_network a Where 
		  			a.pk_affiliate_network_id=s.fk_affiliate_network_id AND sales_processing_status='processed' AND 
					sales_cashback_payment_status='$filter'  
		           ORDER BY pk_sales_id DESC $strLimit";
        }
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }

    public function getCountAllSales($filter) {


        if ($filter == "" || $filter == 'all') {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_sales where sales_processing_status='processed'";
        } else {
            $queryStr = "SELECT COUNT(1) as num_rows FROM tbl_sales where sales_processing_status='processed' AND  
			             sales_cashback_payment_status='$filter'";
        }

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function fetchAllSales() {
        $sql = "select * from tbl_sales where sales_processing_status = 'pending' AND sales_payment_type = 'cashback'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getBusinessType($userId) {
        $sql = "SELECT get_account_type_business_id(get_user_account_type($userId)) as business_type";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getCommPercentage($userId) {
        $sql = "select get_user_cash_back_percentage_with_user_id($userId) as comm_percentage";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function checkAccountType($userId) {
        $sql = "SELECT get_user_account_type($userId) as account_type";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getReferrer($userId) {
        $sql = "select fk_user_id_referrer from tbl_users where pk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($result) > 0) {
            return $result[0]->fk_user_id_referrer;
        } else {
            return FALSE;
        }
    }

    public function checkOverRideCommissionAllowed($ref_id) {
        $sql = "SELECT cp.user_account_cash_back_properties_override_commission_allowed AS commission_allowed FROM tbl_user_account_type ut
                                LEFT JOIN tbl_user_account_cash_back_properties AS cp
                                ON ut.fk_user_account_cash_back_properties_id = cp.pk_user_account_cash_back_properties_id  
                                WHERE ut.pk_user_account_type_id =  get_user_account_type($ref_id)";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result[0]['commission_allowed'] === 'True') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getGoodKarmoraPercentage($userId, $refId) {
        $sql = "select get_user_good_karmora_percentage_with_user_id($userId,$refId) as good_karmora_percentage";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0]['good_karmora_percentage'];
        } else {
            return FALSE;
        }
    }

    public function insertCashBackFirst($data) {
        $user_id = $data['fk_user_id'];
        $cash_back_amount = $data['cash_back_amount'];
        //$referrer_id = $data['referrer_id'];
        $sales_id = $data['sales_id'];
        $sql = "insert into tbl_user_cash_back SET "
                . "fk_user_id   =   $user_id,"
                . "user_cash_back_amount    =   $cash_back_amount,"
                . "fk_sales_id  =   $sales_id,"
                . "user_cash_back_created_date = NOW()";

        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return $this->db->conn_id->lastInsertId();
        } else {
            return FALSE;
        }
    }

    public function insertCashBackSecond($data) {
        $user_id = $data['user_id'];
        $cash_back_amount = $data['cash_back_amount'];
        $sales_id = $data['sales_id'];
        $referral_id = $data['referral'];

        $sql = "insert into tbl_user_cash_back SET "
                . "fk_user_id   =   $user_id,"
                . "user_cash_back_amount    =   $cash_back_amount,"
                . "fk_sales_id  =   $sales_id,"
                . "fk_user_id_referral  =   $referral_id,"
                . "user_cash_back_created_date = NOW()";

        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return $this->db->conn_id->lastInsertId();
        } else {
            return FALSE;
        }
    }

    public function insertCob($data) {
        $business_id = $data['business_id'];
        $cob_amount = $data['cob_amount'];
        $sales_id = $data['sales_id'];

        $sql = "insert into tbl_cob set "
                . "fk_business_id   =   $business_id,"
                . "cob_amount   =   $cob_amount,"
                . "fk_sale_id   =   $sales_id,"
                . "cob_create_date = NOW()";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return $this->db->conn_id->lastInsertId();
        } else {
            return FALSE;
        }
    }

    public function getFundraisingReferrer($userId) {
        $sql = "SELECT fk_user_id_referrer AS fo_referrer FROM tbl_users WHERE pk_user_id = 
                            CASE 
                            WHEN get_user_account_type($userId) IN (7,9)
                            THEN
                            get_fundraising_org_of_with_user_id($userId)
                            ELSE
                            $userId
                            END
                            ";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if (count($result) > 0) {
            return $result[0]->fo_referrer;
        } else {
            return FALSE;
        }
    }

    public function getFundraising($userId) {
        $sql = "SELECT get_fundraising_org_of_with_user_id($userId) AS fundraising";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($result) > 0) {
            return $result[0]->fundraising;
        } else {
            return FALSE;
        }
    }

    public function changeSalesStatus($salesId) {
        $sql = "update tbl_sales set "
                . "sales_processing_status = 'processed' "
                . "where pk_sales_id = $salesId";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function changeSalesStatusToConflict($salesId) {
        $sql = "update tbl_sales set "
                . "sales_processing_status = 'conflict' "
                . "where pk_sales_id = $salesId";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllUserwhoMadeCommission($date = NULL) {
        $date === NULL ? $date = 'NOW()' : '';

        $query = "SELECT s.fk_user_id AS 'member_id', CONCAT(u.user_first_name,' ',u.user_last_name) AS 'full_name' ,
u.user_email AS 'memeber_email' FROM 
tbl_sales AS s 
LEFT JOIN tbl_email_type_to_user_relation AS etr 
ON s.fk_user_id = etr.fk_user_id 
LEFT JOIN tbl_users AS u 
ON s.fk_user_id = u.pk_user_id 
WHERE etr.email_type_to_user_relation_status = 'active' 
AND etr.fk_email_type_id = 1
AND DATE(s.sales_create_date) = DATE(NOW()) GROUP BY s.fk_user_id";
        
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        count($result) > 0 ? $response = $result : $response = FALSE;

        return $response;
    }
    
     public function checkEmailType($userId,$emailType) {
        $sql   =   "select * from tbl_email_type_to_user_relation as etr "
                . "LEFT JOIN tbl_users as u ON etr.fk_user_id = u.pk_user_id"
                . "where etr.fk_user_id = $userId "
                 . "AND etr.fk_email_type_id    =   $emailType "
                 . "AND etr.email_type_to_user_relation_status = 'Active'"
                . "AND u.user_status = 'Active'";
        $statement  = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result =   $statement->fetchAll(PDO::FETCH_ASSOC);
                if(count($result)>0) {
                    return TRUE;
                }
                else {
                    return FALSE;
                }
     }

}

?>