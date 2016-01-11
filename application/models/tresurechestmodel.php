<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tresurechestModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getTresures($gift_type_id) {

        $queryStr = 'SELECT winer.*,wc.* ,wt.winner_chest_gift_type
                        FROM tbl_winner_chest AS winer ,
                        tbl_winner_chest_gift AS wc, tbl_winner_chest_gift_type AS wt
                        WHERE winer.fk_winner_chest_id = wc.pk_winner_chest_gift_product_id
                        AND wt.pk_winner_chest_gift_type_id = wc.fk_winner_chest_gift_type_id
                        AND wt.pk_winner_chest_gift_type_id = '.$gift_type_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getWinner() {
        $queryStr = 'SELECT wc_sta.winning_date,us.user_first_name,us.user_last_name,st.pk_store_id, 
                            cgf.winner_chest_gift_amount AS amount ,win_st.pk_chets_to_store_id,ac.user_account_type_title 
                            FROM tbl_winner_chest_statistics AS wc_sta, tbl_users AS us , tbl_store AS st , tbl_winner_chest AS wc, 
                            tbl_winner_chest_to_store AS win_st , tbl_user_account_type AS ac , 
                            tbl_winner_chest_to_user_account_type AS win_ac ,tbl_winner_chest_gift AS cgf
                            WHERE wc_sta.fk_store_id=st.pk_store_id AND wc_sta.fk_user_id = us.pk_user_id 
                            AND wc.tresure_chest_id = wc_sta.fk_tresure_id 
                            AND win_st.fk_chest_id = wc.tresure_chest_id 
                            AND win_st.fk_store_id = st.pk_store_id 
                            AND ac.pk_user_account_type_id = win_ac.fk_user_account_id 
                            AND win_ac.fk_chest_id = wc_sta.fk_tresure_id 
                            AND cgf.pk_winner_chest_gift_product_id = wc.fk_winner_chest_id
                            GROUP BY wc_sta.winnerchest_statics_pk_id'; 

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}

?>