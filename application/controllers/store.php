<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store extends karmora {

    public $data;
    

    public function __construct() {
        parent::__construct();

        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->helper('url');
        $this->load->model(array('storemodel', 'homemodel' , 'commonmodel'));
        $this->load->library('pagination');
    }

    public function index() {
        echo 'All stores requested';
    }

    public function trendingStore($alias = NULL, $username = NULL) {

        $this->verifyUser($username);
        $detail = $this->currentUser;
        if (isset($this->session->userdata['front_data']['id'])) {
            $favoutieStore = $this->homemodel->GetfavourtiesStores($detail['userid']);
            if (!empty($favoutieStore)) {
                $data['favrteStores'] = 'favrteStores';
                $data['favrtecat'] = $favoutieStore;
            }
        }
        
        // for Trending Store
        $data['description'] = 'Trending Stores on Karmora are a combination of small, mid-size and brand named retailers offering great deals and cash back on the seasons’ hottest offerings!  Join Karmora for FREE and get cash back on over 1,700 stores!';
        $TrendingStore = $this->storemodel->GetTrendingStore($detail['user_account_type_id'], $alias);
       
        $data['TrendingStore'] = $TrendingStore;
        $data['alias'] = $alias;

         //for left side nav category 

        $categories = $this->GetCategories($detail['user_account_type_id']);
        $data['categories'] = $categories;


        $category_detail = $this->storemodel->categoryDetails($alias);
        $data['category_detail'] = $category_detail;
        $this->loadLayout($data,'frontend/store/trendingStoreList');
    }

    public function allStore($store_alias = NULL, $username = NULL) {
        $storeArray = '';
        $this->verifyUser($username);
        $detail = $this->currentUser;
        //echo '<pre>'; print_r($detail); die;
      
        $data['store_alis_url'] = $store_alias;
        

        $categories = $this->GetCategories($detail['user_account_type_id']);
        
        $data['categories'] = $categories;
        if (isset($this->session->userdata['front_data']['id']) && ($store_alias === 'favourtie') ) {
            $data['category_all_stores'] = $this->storemodel->GetfavourtieStore($detail['userid']);
            $alias = 'favourtie';
        } else {
            $alias = $this->storemodel->CheckCatAlias($store_alias);
            $data['category_all_stores'] = $this->storemodel->GetStore($detail['user_account_type_id'], $alias, $detail['userid']);
        }
        if ($alias === 'all') {
            $data['category_title'] = 'All';
        } else if ($alias === 'favourtie') {
            $data['category_title'] = 'Favortie';
        } else {
            !empty($data['category_all_stores']) ? $data['category_title'] = $data['category_all_stores'][0]['category_title'] : '';
        }

        if (!empty($data['category_all_stores'])) {
            $data['StoreArry'] = $data['category_all_stores'];

            foreach ($data['StoreArry'] as $store) {
                $store_title = $store['store_title'] . "<br />";
                $curr = current(str_split($store_title));

                if (!preg_match("/^[a-zA-Z]$/", $curr)) {
                    $storeArray['0-9'][$store_title] = $store;
                } else {
                    $storeArray[strtoupper($curr)][$store_title] = $store;
                }
            }
            $data['storeArray'] = $storeArray;
            
        }
        $this->loadLayout($data,'frontend/store/storelist');
    }

    function array_sort($array, $type = 'asc') {
        $result = array();
        foreach ($array as $var => $val) {
            $set = false;
            foreach ($result as $var2 => $val2) {
                if ($set == false) {
                    if ($val > $val2 && $type == 'desc' || $val < $val2 && $type == 'asc') {
                        $temp = array();
                        foreach ($result as $var3 => $val3) {
                            if ($var3 == $var2)
                                $set = true;
                            if ($set) {
                                $temp[$var3] = $val3;
                                unset($result[$var3]);
                            }
                        }
                        $result[$var] = $val;
                        foreach ($temp as $var3 => $val3) {
                            $result[$var3] = $val3;
                        }
                    }
                }
            }
            if (!$set) {
                $result[$var] = $val;
            }
        }
        return $result;
    }

    public function storeVisit($store_id = NULL, $username = NULL) {

        $this->verifyUser($username);
        $detail = $this->currentUser;
        $member_id = $detail['userid'];
        // for tresurechest
        $setting = '';
        $tc_id = '';
        $data['login_check'] = '';
        
        $accType = $this->db->select('get_user_account_type(' . $member_id . ') as accType')->get();
        
        if (!empty($accType) && $accType->row()->accType !== '8') {
            
            $Alltresure = $this->storemodel->GetallChest($store_id);
            if(!empty($Alltresure)){
            $oneDimensionalArray = array_map('current', $Alltresure);
            $rand_keys = array_rand($oneDimensionalArray, 1);
            $tc_id = $oneDimensionalArray[$rand_keys];
            $GetAlltresure = $this->storemodel->GettresureDetail($tc_id, $store_id);
            }else{
               $GetAlltresure = ''; 
            }
            
           if (!empty($GetAlltresure)) {
                //echo "all is well"; exit;
                $setting = $GetAlltresure->setting;
                $amount = $GetAlltresure->amount;
                $quantity = $GetAlltresure->quantity;
                $this->verifyUser($username);
                $detail = $this->currentUser;
                $userId = $detail['userid'];
                //echo $userId; exit;
                if (isset($this->session->userdata['front_data']['id'])) {
                    $userAlredy = $this->storemodel->GetAlredayDetail($store_id, $tc_id, $userId, $setting);
                    if ($userAlredy === 'true') {
                        // insert into statics
                        $datas = array(
                            'fk_user_id' => $userId,
                            'fk_store_id' => $store_id,
                            'fk_tresure_id' => $tc_id,
                            'quantity' => 1,
                            'winning_prize' => $amount,
                            'setting' => $setting,
                            'winning_date' => date('Y-m-d H:i:s'),
                            'status' => 'Pending'
                        );
                        $this->db->insert('tbl_winner_chest_statistics', $datas);
                        $userTracingId = $this->db->select('user_subid')->from('tbl_users')->where('pk_user_id', $userId)->get();
                        $transectionId = 'C' . $tc_id . 'S' . $store_id . 'U' . $userId;

                        $userSubId = $userTracingId->row()->user_subid;

                        $insertSaleArray = array(
                            "sales_tracking_id" => $userSubId,
                            "fk_sales_file_id" => 0,
                            "sales_transection_id" => $transectionId,
                            "fk_user_id" => $userId,
                            "sales_product_description" => 'Karmora Treasure Chest Winner',
                            "sales_sale_amount" => $amount,
                            "sales_kash_back_percentage" => 0,
                            "sales_total_amount" => $amount,
                            "sales_advertiser_name" => 'karmora',
                            "fk_affiliate_network_id" => 0,
                            "sale_date" => date('Y-m-d'),
                            "sales_create_date" => date('Y-m-d H:i:s'),
                            "sales_processing_status" => 'pending',
                            "sales_cashback_payment_status" => 'pending',
                            "sales_payment_type" => 'treasurehunt',
                        );
                        $this->db->insert('tbl_sales', $insertSaleArray);
//                    
                        


                        // 	update quantity into table chest
                        $Uquantity = $quantity - 1;
                        $data = array('quantity' => $Uquantity);
                        $this->db->where('tresure_chest_id', $tc_id);
                        $this->db->update('tbl_winner_chest', $data);
                        $data['prize'] = $amount;
                    }
                }
            }
        }
        // end of trsure chest

        if (!isset($this->session->userdata['front_data']['id'])) {
            $data['login_check'] = 'login';
        }
        
        $storeTitle = $this->storemodel->GetStoreInfo($store_id, $detail['user_account_type_id']);

        if ($storeTitle != false) {
            $data['title'] = $storeTitle->store_title;
            $data['url'] = $storeTitle->store_url;
            $data['affiliateNetworkId'] = $storeTitle->fk_affiliate_network_id;
        } else {
            redirect(base_url());
        }

         $data['url'] = $this->prepURL($data['affiliateNetworkId'], $data['url']); 

        $profilePic = $this->storemodel->GetMemberInfo($member_id);
        if ($profilePic != false) {
            $data['profilePic'] = $profilePic->profile_pic;
        } else {
            $data['profilePic'] = 'default.png';
        }

        //record members exiting Karmora to adevertizer
        $memberIP = $_SERVER['REMOTE_ADDR'];
        $this->commonmodel->insertKarmoraMemberExfil($member_id,$store_id, $data['title'], $data['url'], $memberIP);
        $this->loadLayout($data,'frontend/store/thanku');
    }

    public function trendingStoreInfo($store_id = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $trendingStore = $this->storemodel->GetTrendingStoreInfo($store_id, $detail['user_account_type_id']);
        $data['description'] = "Trending Stores on Karmora are a combination of small, mid-size and brand named retailers offering great deals and cash back on the seasons’ hottest offerings!  Join Karmora for FREE and get cash back on over 1,700 stores!";
        if ($trendingStore != false) {
            $data['storeTitle'] = $trendingStore->store_title;
            $data['storeImage'] = $trendingStore->store_image;
        } else {
            header('location:' . base_url());
        }
        $this->loadLayout($data,'frontend/store/trendingstoreinfo');
    }

// function for store search
    public function store_search($store_title = NULL, $username = NULL) {
        if (is_null($store_title)) {
            show_404();
        }
        $html = '';
        $this->verifyUser($username);
        $detail = $this->currentUser;
        
        $category_all_stores = $this->storemodel->GetsearchStore($detail['user_account_type_id'], $store_title);
        if (!empty($category_all_stores)) {

            foreach ($category_all_stores as $search) {

                $html .= '<a href="' . base_url('store-visit') . '/' . $search['store_id'] . '" class="list_hover" target="_blank"><li class="list_filed"><span>' . $search['store_title'] . '</span>&nbsp; &nbsp;<span>' . $search['cash_back_percentage'] . '</span></li></a>';
            }
        } else {
            $html .= "No search results";
        }
        echo $html;
    }

// function for store details
    public function storeDetail($storeId, $username = NULL) {

        $data['login_check'] = '';
        $data['alredyFavourite'] = '';
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        $acc_type_id = $detail['user_account_type_id'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            $data['login_check'] = 'login';
        }
        $favoutieStored = $this->homemodel->GetfavourtiesStoresCheck($userId);
        //echo $pk
        if (isset($this->session->userdata['front_data']['id']) && (!empty($favoutieStored))) {

            $data['favrteStores'] = 'favrteStores';
            $data['favrtecat'] = $favoutieStored;
        }

        $favoutieStore = $this->storemodel->GetfavourtiesStores($storeId, $userId);

        if (!empty($favoutieStore)) {
            $data['alredyFavourite'] = 'alredyFavourite';
        }
        
        $categories = $this->GetCategories($acc_type_id);
        $data['categories'] = $categories;

        $categories_top_stores = $this->homemodel->getTopCategoryStores($acc_type_id);

        if (empty($categories_top_stores)) {
            $data['top_stores'] = false;
        } else {
            $data['top_stores'] = $this->sortStoreByCategory($categories_top_stores);
        }

        $storeTitle = $this->storemodel->GetStoreInfo($storeId, $acc_type_id);
        $commission = $this->storemodel->getCommissionPercentage($storeId, $acc_type_id);

        $data['comm_percentage'] = $commission[0]['store_to_user_account_type_commission_percentage'];

        $title = $storeTitle->coupon_title;
        $networkId = $storeTitle->fk_affiliate_network_id;
        $couponData = $this->storemodel->GetCoupons($title, $networkId, $userId);

        if ($storeTitle != false) {
            $data['title'] = $storeTitle->store_title;
            $data['url'] = $storeTitle->store_url;
            $data['affiliateNetworkId'] = $storeTitle->fk_affiliate_network_id;
            $data['image'] = $storeTitle->store_image;
            $data['description'] = $storeTitle->store_description;
        } else {
            redirect(base_url());
        }
        $data['storeId'] = $storeId;
        $data['coupon'] = $couponData;
        $this->loadLayout($data,'frontend/store/store_detail');
    }

    // function for store search
    public function storeSearch($storeTitleA = NULL, $username = NULL) {


        $storeTitle = str_replace(33, '\\', str_replace(22, '/', urldecode($storeTitleA)));
        if (is_null($storeTitle)) {
            // redirect(base_url()); die;
        }
        $html = '';
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $category_all_stores = $this->storemodel->GetsearchStore($detail['user_account_type_id'], $storeTitle);
        if (!empty($category_all_stores)) {
            echo '<br>';
            foreach ($category_all_stores as $search) {

                $html .= '<a href="' . base_url('store-detail') . '/' . $search['store_id'] . '" class="pull-left" target="_blank"><li class="search_list_rzlt"><span class="store-title">' . $search['store_title'] . '</span>&nbsp; &nbsp;<span class="store-cashback">' . $search['cash_back_percentage'] . '</span></li></a>';
            }
        } else {
            $html .= "No search results";
        }
        echo $html;
        exit;
    }

    public function favourtie($storeId = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('storeDetail/' . $storeId));
        }
        
        if (empty($userId)) {
            redirect(base_url('storeDetail/' . $storeId));
            die;
        } else {
            $datas = array(
                'fk_user_id' => $userId,
                'fk_store_id' => $storeId,
                'creation_date_time' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_favorties', $datas);
            redirect(base_url('store-detail/' . $storeId));
            die;
        }
    }

    public function sortStoreByCategory($storesArray) {
        $sortedStoreArray = array();
        foreach ($storesArray as $store) {
            if (!isset($sortedStoreArray[$store['category_alias']])) {
                $sortedStoreArray[$store['category_alias']] = array();
            }

            array_push($sortedStoreArray[$store['category_alias']], $store);
        }

        return $sortedStoreArray;
    }

    public function Unfavourtie($storeId = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('storeDetail/' . $storeId));
        }
            $where = array('fk_user_id ' => $userId, 'fk_store_id ' => $storeId);
            $this->db->where($where);
            $this->db->delete('tbl_favorties');
            redirect(base_url('store-detail/' . $storeId));
            die;
        
    }

    public function SUnfavourtie($storeId = NULL, $url = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('storeDetail/' . $storeId));
        }
            $where = array('fk_user_id ' => $userId, 'fk_store_id ' => $storeId);
            $this->db->where($where);
            $this->db->delete('tbl_favorties');
            redirect(base_url('store/' . $url));
            die;
        
    }

    public function Sfavourtie($storeId = NULL, $url = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('storeDetail/' . $storeId));
        }
        $datas = array(
                'fk_user_id' => $userId,
                'fk_store_id' => $storeId,
                'creation_date_time' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_favorties', $datas);
            //var_dump($datas);exit;
            redirect(base_url('store/' . $url));
            die;
        
    }

    // for coupons favoutire
    public function Cofavourtie($fk_coupon_id = NULL, $url = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('store-detail/' . $url));
        }
        $datas = array(
                'fk_user_id' => $userId,
                'fk_coupon_id' => $fk_coupon_id,
                'creation_date_time' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_favorties_coupons', $datas);
            redirect(base_url('store-detail/' . $url));
            die;
        
    }

    // for coupons  Unfavoutire
    public function CoUnfavourtie($fk_coupon_id = NULL, $url = NULL, $username = NULL) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userId = $detail['userid'];
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url('store-detail/' . $url));
        }
        $where = array('fk_user_id ' => $userId, 'fk_coupon_id ' => $fk_coupon_id);
            $this->db->where($where);
            $this->db->delete('tbl_favorties_coupons', $data);
            redirect(base_url('store-detail/' . $url));
            die;
        
    }

    public function specialDeals($alias = NULL, $username = NULL) {

        $this->verifyUser($username);
        $detail = $this->currentUser;
        if ($alias === 'smokin_hot_deals') {
            $data['description'] = 'Karmora Smokin Hot Deals make ya jump back and want to kiss yoself!  Check out these great deals combined with special online coupons for extra savings!  Join Karmora for FREE and get cash back on over 1,700 stores!';
        } else if ($alias === 'cash_o_palooza') {
            $data['description'] = 'Karmora Cash-O-Palooza Deals are special cash back deals on name brand advertisers.  You won’t find higher cash back anytime, anywhere, ever!  Join Karmora for FREE and get cash back on over 1,700 stores!';
        }

        // for Trending Store
        $deals = $this->storemodel->getSpecialStores($detail['user_account_type_id'], $alias);

        $data['deals'] = $deals;
        $data['alias'] = $alias;
        $category_detail = $this->storemodel->categoryDetails($alias);
        $data['category_detail'] = $category_detail;
        $this->loadLayout($data,'frontend/offers/content');
    }

}
