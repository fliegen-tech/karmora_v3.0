<?php

class manualemailqueuemodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function usersEmailsListForEmailType($emailType) {

        $emailsArray = array();
        $this->db->select('user_email');
        $this->db->from('tbl_email_type_to_user_relation');
        $this->db->join('tbl_email_type', 'tbl_email_type_to_user_relation.fk_email_type_id = tbl_email_type.pk_email_type_id', 'left');
        $this->db->join('tbl_users', 'tbl_email_type_to_user_relation.fk_user_id = tbl_users.pk_user_id', 'left');
        $this->db->where('tbl_email_type_to_user_relation.email_type_to_user_relation_status', 'active');
        $this->db->where('tbl_email_type.email_type_status', 'active');
        $this->db->where('tbl_email_type.email_type_title', $emailType);
        $emailList = $this->db->get()->result_array();

        if (count($emailList) > 0) {
            foreach ($emailList as $row) {
                foreach ($row as $element => $email) {
                    array_push($emailsArray, $email);
                }
            }
        }
        $response = count($emailsArray) > 0 ? $emailsArray : FALSE;

        return $response;
    }

    public function getEmailTypeId($emailId) {

        $emailType = $this->db->select('email_required')->from('tbl_email')->where('pk_email_id', $emailId)->limit(1)->get();
//        print_r($emailType);
        $response = count($emailType->row()) > 0 ? $emailType->row()->email_required : FALSE;
//        var_dump($response);
//        exit;
        return $response;
    }

    public function getAllEamilTypes() {
        $emailTypesArray = array();
        $emailTypes = $this->db->select('email_type_title')->from('tbl_email_type')->get()->result_array();

        if (count($emailTypes) > 0) {
            foreach ($emailTypes as $row) {
                foreach ($row as $et => $val) {
                    array_push($emailTypesArray, strtolower($val));
                }
            }
        }

        $response = count($emailTypesArray) > 0 ? $emailTypesArray : FALSE;
        return $response;
    }

    public function getUserId($traking_id) {
        $query = "SELECT pk_user_id FROM tbl_users WHERE user_subid ='" . $traking_id . "'";

        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row()->pk_user_id;
        } else {
            return '';
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

    public function checkEmailType($userId, $emailType) {
        $sql = "select * from tbl_email_type_to_user_relation where fk_user_id = $userId "
                . "AND fk_email_type_id    =   $emailType "
                . "AND email_type_to_user_relation_status = 'Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>