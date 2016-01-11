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
class emailqmodel extends CI_Model {

    public function getAllEmailq() {



        $queryStr = " SELECT * FROM tbl_email_queue";


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

}
