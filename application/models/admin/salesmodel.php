<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usermodel
 *
 * @author WAQAS
 */
class salesmodel extends CI_Model {

    public function getAllSales() {



        $queryStr = " SELECT sal.*,us.user_username FROM tbl_sales AS sal ,tbl_users AS us
                        WHERE us.pk_user_id = sal.fk_user_id";


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    // function to get count of users  
    public function getCountAllSales() {
        $queryStr = "SELECT COUNT(sal.pk_sales_id) AS num_rows FROM tbl_sales AS sal ,tbl_users AS us
                      WHERE us.pk_user_id = sal.fk_user_id";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $Row = $queryRS->row();
            return $Row->num_rows;
        } else {
            return '';
        }
    }

    public function getCountSerchSales($search_string) {
        $queryStr = "SELECT COUNT(sal.pk_sales_id) AS num_rows FROM tbl_sales AS sal ,tbl_users AS us
                      WHERE us.pk_user_id = sal.fk_user_id and sales_advertiser_name LIKE '%" . $search_string . "%' OR sales_tracking_id LIKE '%" . $search_string . "%' ";

        $queryRS = $this->db->query($queryStr);
        $Row = $queryRS->row();
        return $Row->num_rows;
    }

    public function searchSales($page = 1, $limit = 10, $search_string) {
        $lowerLimit = ($page - 1) * $limit; //creating the lower limit
        $strLimit = " LIMIT $lowerLimit, $limit"; //limit string
        $queryStr = " SELECT sal.*,us.user_username FROM tbl_sales AS sal ,tbl_users AS us
                        WHERE us.pk_user_id = sal.fk_user_id and sales_advertiser_name LIKE '%" . $search_string . "%' OR sales_tracking_id LIKE '%" . $search_string . "%' $strLimit";


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getSaleCobDetail($sale_id) {
        $queryStr = "SELECT cob.pk_cob_id,cob.cob_amount,cob.cob_status,bus.business_title,sale.*,us.user_username 
                        FROM tbl_cob AS cob ,tbl_business AS bus , tbl_sales AS sale ,tbl_users AS us 
                        WHERE bus.pk_business_id = cob.fk_business_id 
                        AND sale.fk_user_id = us.pk_user_id AND sale.pk_sales_id =  ". $sale_id." GROUP BY sale.pk_sales_id ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            $Row = $queryRS->row();
            return $Row;
        } else {
            return '';
        }
    }

    public function getCsvSales($start_date,$end_date) {
        $condation = '';
        if ($start_date != '') {
            $condation .='and sal.sale_date >= "' . $start_date . '"';
        }
        if ($end_date != '') {
            $condation .= 'and sal.sale_date <= "' . $end_date . '"';
        }


        $queryStr = " SELECT sal.pk_sales_id,sal.sales_tracking_id,sal.sales_transection_id,sal.sales_sale_amount,sal.sales_kash_back_percentage,
                        sal.sales_total_amount,sal.sales_advertiser_name,sal.fk_affiliate_network_id,
                        sal.sales_create_date,
                        sal.sales_processing_status,sal.sales_cashback_payment_status,sal.sales_payment_type,
                        us.user_username FROM tbl_sales AS sal ,tbl_users AS us
                        WHERE us.pk_user_id = sal.fk_user_id $condation";


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    
    public function getcahbackSales($sale_id) {



        $queryStr = "SELECT us.user_username ,cashback.* ,acl.fk_user_account_type_id
                        FROM tbl_user_cash_back AS cashback , tbl_user_to_user_account_type_log AS acl,
                        tbl_users AS us
                        WHERE us.pk_user_id = cashback.fk_user_id 
                        AND acl.fk_user_id = us.pk_user_id
                        AND acl.user_account_log_status = 'Active'
                        AND cashback.fk_sales_id = ".$sale_id;


        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}
