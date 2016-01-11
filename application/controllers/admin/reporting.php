<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporting extends karmora {

    public $page = 'reporting';
    protected $validate_banner_id = '';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model(array('admin/bannerModel', 'commonmodel', 'admin/reportmodel'));
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->load->library('email');
        $this->load->helper('string');
        $this->data = "";
        $this->page = 'reporting';
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->helper('url');

        $this->load->helper('paging');
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    /**
     * This is the default function of a controller
     */
    public function index() {
        $search_string = '';
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['submit'])) {


            $uploadpath = './public/admin/uploads/reports/sales_report/';
            $config['upload_path'] = $uploadpath;
            $config['allowed_types'] = '*';
            //$config['max_size'] = '10000000';

            if ($_FILES["csv_file"]["name"] == '') {

                $data['image_error'] = "please select a file to upload";
            } else {

                $datas = array(
                    'user_sales_file_name' => $_FILES["csv_file"]["name"],
                    'user_sales_file_import_status' => 'No'
                        //'banner_ads_create_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_sales_file', $datas
                );
                $insertId = $this->db->insert_id();
                //$this->db->insert('tbl_banner_ads', $datas);
                $photo_name = 'report_' . $insertId;
                $config['file_name'] = $photo_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('csv_file')) {
                    $data = array('msg' => $this->upload->display_errors());
                }
                $uploaddata = $this->upload->data();
                $datas = array(
                    'user_sales_file_name_import' => $uploaddata['file_name']
                );
                $this->db->where('pk_user_sales_file_id', $insertId);
                $this->db->update('tbl_sales_file', $datas);

                $data['successmessage'] = 'Banner Created Sucefully';
                redirect('admin/reporting/view/' . $insertId);
            }
        }
        $data['content'] = $this->load->view('admin/reporting/form', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function view($file_id) {
        $file_name = $this->reportmodel->getFileName($file_id)->user_sales_file_name_import;
        $data['page'] = $this->page;
        $data['file_id'] = $file_id;
        /*         * **reading csv  *** */
        $record = array();
        $header = array();
        $i = 1;
        $file = fopen(base_url() . 'public/admin/uploads/reports/sales_report/' . $file_name, "r");
        while (!feof($file)) {
            if ($i == 1) {
                array_push($header, fgetcsv($file));
            }
            $i++;
            array_push($record, fgetcsv($file));
        }
        fclose($file);
        $header = reset($header);
        $j = 0;
        foreach ($record as $rec) {
            $i = 0;
            if (is_array($rec)) {
                $coun = count($rec);
                foreach ($rec as $r) {
                    ${'ar_' . $i}[$j] = str_replace("&quot;", "", $r);
                    $i++;
                }
            }
            $j++;
        }
        for ($i = 0; $i < $coun; $i++) {

            $data['ar'][$i] = ${'ar_' . $i};
        }
        if (isset($_POST['submit'])) {
            for ($i = 0; $i <= 7; $i++) {

                $final[$i] = ${'ar_' . $_POST[$i]};
            }
            $calculated = array();
            foreach ($final as $fin) {
                $i = 0;
                foreach ($fin as $f) {
                    $calculated[$i][] = $f;
                    $i++;
                }
            }
            $data['calculated'] = $calculated;
            $data['content'] = $this->load->view('admin/reporting/calculated', $data, TRUE);
        } else {
            $data['file_name'] = $file_name;
            $data['headings'] = $header;
            $data['content'] = $this->load->view('admin/reporting/view', $data, TRUE);
        }
        $data['header'] = $this->header;
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $data['footer'] = $this->footer;
        $this->load->view('admin/template', $data);
    }

    /*     * *****function for ajax call****** */

    public function change($val, $file_name) {
        $record = array();
        $header = array();
        $i = 1;
        $file = fopen(base_url() . 'public/admin/uploads/reports/sales_report/' . $file_name, "r");
        while (!feof($file)) {
            if ($i == 1) {
                array_push($header, fgetcsv($file));
            }
            $i++;
            array_push($record, fgetcsv($file));
        }
        fclose($file);
        $header = reset($header);
        $j = 0;
        foreach ($record as $rec) {
            $i = 0;
            if (is_array($rec)) {
                $coun = count($rec);
                foreach ($rec as $r) {
                    ${'ar_' . $i}[$j] = $r;
                    $i++;
                }
            }
            $j++;
        }
        ?>
        <?php foreach (${'ar_' . $val} as $ss) { ?>
            <div style="overflow: hidden; height: 20px;"><?php
                echo $ss;
                ?></div>
            <?php
        }
    }

    /*     * *save in tbl_sales** */

    public function save() {

        if (isset($_POST['submit'])) {
            $calculated = json_decode($_POST['calculated']);
            echo "<pre>";
            print_r($calculated);
            $arraytoinsert = array_chunk($calculated, 8);
            //var_dump($arraytoinsert);exit;
            $file_id = $_POST['file_id'];
            $this->db->trans_start();
            foreach ($arraytoinsert as $arr) {
                $sale_date = date('Y-m-d', strtotime($arr[6]));
                $user_id = $this->reportmodel->getUserId(trim($arr[0]));
                $affiliate_network_id = $this->reportmodel->getNetworkId($arr[5]);
                $cashbackper = ($arr[3] / $arr[2]) * 100;
                $arr[3] < 0 ? $cashback_payment_status = 'Returned' : $cashback_payment_status = 'Pending';
                $data = array(
                    'sales_tracking_id' => $arr[0],
                    'fk_sales_file_id' => $file_id,
                    'sales_transection_id' => $arr[7],
                    'fk_user_id' => $user_id,
                    'sales_product_description' => $this->db->escape($arr[1]),
                    'sales_sale_amount' => round($arr[2], 2),
                    'sales_kash_back_percentage' => round($cashbackper, 2),
                    'sales_total_amount' => round($arr[3], 2),
                    'sales_advertiser_name' => $arr[4],
                    'fk_affiliate_network_id' => $affiliate_network_id,
                    'sales_cashback_payment_status' => $cashback_payment_status,
                    'sale_date' => $sale_date,
                    'sales_create_date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_sales', $data);
                // var_dump( $this->db->insert('tbl_sales', $data));
                // echo $this->db->last_query()."<br />";
                //var_dump($this->db->trans_status());
            }
            //exit;
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('success', '<div class="alert alert-danger" role="alert">There Were Some Errors</div>');
            } else {

                $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Sales Added Sucessfully</div>');
                $data = array('user_sales_file_import_status' => 'Yes');
                $this->db->where('pk_user_sales_file_id', $file_id);
                $this->db->update('tbl_sales_file', $data);
            }
        }
        redirect('admin/reporting/index');
    }

    public function process_cashback() {
        // get all sales
        $sales = $this->reportmodel->fetchAllSales();
//        echo '<pre>';
//        print_r($sales);
//        echo '</pre>';
//        exit;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                // get business type for each user

                $business_type = $this->reportmodel->getBusinessType($sale['fk_user_id']);
                if ($business_type !== FALSE) {
                    foreach ($business_type as $business_type) {
                        if ($business_type['business_type'] === '2') {
                            // all fundraising taka tukk will be done here

                            $comm_percentage = $this->reportmodel->getCommPercentage($sale['fk_user_id']);

                            foreach ($comm_percentage as $comm_percentage) {
                                $cash_back_amount = (floatval($comm_percentage['comm_percentage']) / 100) * $sale['sales_total_amount'];
                                $remaining_amount = floatval($sale['sales_total_amount']) - floatval($cash_back_amount);

                                $dataArray = array(
                                    'fk_user_id' => $sale['fk_user_id'],
                                    'cash_back_amount' => $cash_back_amount,
                                    'sales_id' => $sale['pk_sales_id'],
                                    'user_cash_back_status' => $sale['sales_cashback_payment_status']
                                );

                                $insert_id_cash_back = $this->reportmodel->insertCashBackFirst($dataArray);
                                // get referrer of fundraising

                                $referrrer_id = $this->reportmodel->getReferrer($sale['fk_user_id']);
                                //echo $referrrer_id;
                                // check account type of referrer

                                echo "=====================Section Start==================<br />";
                                echo "user id = " . $sale['fk_user_id'] . "<br />";
                                echo "total amount for fundraising = " . $sale['sales_total_amount'] . "<br />";
                                echo "cash back for fundraising= " . $cash_back_amount . "<br />";
                                echo "Remaining amount for fundraising = " . $remaining_amount . "<br />";
                                echo "Referrer ID = " . $referrrer_id . "<br />";
                                echo "<br />========================================== <br />";
                                // check account type of current user
                                $accoun_type = $this->reportmodel->checkAccountType($sale['fk_user_id']);
                                foreach ($accoun_type as $accoun_type) {
                                    if ($accoun_type['account_type'] !== '6') {
                                        // get fundraising of current user
                                        $fundraising = $this->reportmodel->getFundraising($sale['fk_user_id']);
                                        echo "Fundraising of current user is = " . $fundraising . "<br />";
                                        $over_ride_allowed = $this->reportmodel->checkOverRideCommissionAllowed($fundraising);
                                        if ($over_ride_allowed) {
                                            $good_karmora_percentage = $this->reportmodel->getGoodKarmoraPercentage($sale['fk_user_id'], $referrrer_id);
                                            $good_karmora_amount = (floatval($good_karmora_percentage) / 100) * $cash_back_amount;
                                            $remaining_amount = floatval($remaining_amount) - floatval($good_karmora_amount);
                                            echo "good karmora percentage for fundraising = " . $good_karmora_percentage . "<br />";
                                            echo "good karmora amount for fundraising = " . $good_karmora_amount . "<br />";
                                            echo "Remaining Amount = " . $remaining_amount . "<br />";
                                            // inserting good karmora for fundraising
                                            $dataArray = array(
                                                'user_id' => $fundraising,
                                                'cash_back_amount' => $good_karmora_amount,
                                                'sales_id' => $sale['pk_sales_id'],
                                                'referral' => $sale['fk_user_id'],
                                                'user_cash_back_status' => $sale['sales_cashback_payment_status']
                                            );
                                            $insert_id_good_karmora = $this->reportmodel->insertCashBackSecond($dataArray);
                                        }
                                    } else {
                                        echo "its fundraising <br />";
                                        $fundraising = $sale['fk_user_id'];
                                    }
                                    $firstReferrer = $this->reportmodel->getFundraisingReferrer($sale['fk_user_id']);
                                    echo "First referrer    =   " . $firstReferrer . "<br />";
                                    $over_ride_allowed_referrer = $this->reportmodel->checkOverRideCommissionAllowed($firstReferrer);
                                    if ($over_ride_allowed_referrer) {
                                        $good_karmora_percentage_referrer = $this->reportmodel->getGoodKarmoraPercentage($fundraising, $firstReferrer);
                                        $good_karmora_amount_referrer = (floatval($good_karmora_percentage_referrer) / 100) * $cash_back_amount;
                                        $remaining_amount = floatval($remaining_amount) - floatval($good_karmora_amount_referrer);
                                        echo "good karmora percentage for fundraising Referrer = " . $good_karmora_percentage_referrer . "<br />";
                                        echo "good karmora amount for fundraising = " . $good_karmora_amount_referrer . "<br />";
                                        echo "Remaining Amount = " . $remaining_amount . "<br />";
                                        // inserting good karmora for first referrer
                                        $dataArray = array(
                                            'user_id' => $firstReferrer,
                                            'cash_back_amount' => $good_karmora_amount_referrer,
                                            'sales_id' => $sale['pk_sales_id'],
                                            'referral' => $sale['fk_user_id'],
                                            'user_cash_back_status' => $sale['sales_cashback_payment_status']
                                        );
                                        $insert_id_good_karmora = $this->reportmodel->insertCashBackSecond($dataArray);
                                    } else {
                                        echo "not allowed<br />";
                                    }
                                }
                                $cob = $remaining_amount;
                                // data for tbl_cob
                                $dataArray = array(
                                    'business_id' => $business_type['business_type'],
                                    'cob_amount' => $cob,
                                    'sales_id' => $sale['pk_sales_id'],
                                    'cob_status' => $sale['sales_cashback_payment_status']
                                );
                                $insert_cob = $this->reportmodel->insertCob($dataArray);
                                echo "Cost of doing business = " . $cob . "<br />";

                                echo "===============================<br />";

                                echo "============================================<br />";
                                echo "==================Section End======================<br />";
                            }
                        } else if ($business_type['business_type'] === '1') {
                            // all commercial taka tukk will be done here
                            // calculating percentage
                            $comm_percentage = $this->reportmodel->getCommPercentage($sale['fk_user_id']);
                            foreach ($comm_percentage as $comm_percentage) {
                                $cash_back_amount = (floatval($comm_percentage['comm_percentage']) / 100) * $sale['sales_total_amount'];
                                $remaining_amount = floatval($sale['sales_total_amount']) - floatval($cash_back_amount);
                                $good_karmora_amount = '';
                                echo "total=" . $sale['sales_total_amount'] . "<br />";
                                echo "cash back=" . $cash_back_amount . "<br />";
                                echo "remaining=" . $remaining_amount . "<br />";
                                echo "============================= <br />";
                                // checking account type of current user
                                $account_type = $this->reportmodel->checkAccountType($sale['fk_user_id']);

                                foreach ($account_type as $account_type) {

                                    // insert into cash back
                                    $dataArray = array(
                                        'fk_user_id' => $sale['fk_user_id'],
                                        'cash_back_amount' => $cash_back_amount,
                                        'sales_id' => $sale['pk_sales_id'],
                                        'user_cash_back_status' => $sale['sales_cashback_payment_status']
                                    );

                                    $insert_id_cash_back = $this->reportmodel->insertCashBackFirst($dataArray);

                                    if ($account_type['account_type'] !== '8') {
                                        // getting referrer of current user

                                        $referrer_id = $this->reportmodel->getReferrer($sale['fk_user_id']);

                                        // good karmor insertion
                                        //check account type

                                        $over_ride_allowed = $this->reportmodel->checkOverRideCommissionAllowed($referrer_id);
                                        if ($over_ride_allowed) {
                                            $good_karmora_percentage = $this->reportmodel->getGoodKarmoraPercentage($sale['fk_user_id'], $referrer_id);
                                            $good_karmora_amount = (floatval($good_karmora_percentage) / 100) * $cash_back_amount;
                                            $remaining_amount = floatval($remaining_amount) - floatval($good_karmora_amount);
                                            
                                            $dataArray = array(
                                                'user_id' => $referrer_id,
                                                'cash_back_amount' => $good_karmora_amount,
                                                'sales_id' => $sale['pk_sales_id'],
                                                'referral' => $sale['fk_user_id'],
                                                'user_cash_back_status' => $sale['sales_cashback_payment_status']
                                            );
                                            $insert_id_good_karmora = $this->reportmodel->insertCashBackSecond($dataArray);
                                        }
                                    }
                                    $cob = $remaining_amount;
                                    // data for tbl_cob
                                    $dataArray = array(
                                        'business_id' => $business_type['business_type'],
                                        'cob_amount' => $cob,
                                        'sales_id' => $sale['pk_sales_id'],
                                        'cob_status' => $sale['sales_cashback_payment_status']
                                    );
                                    $insert_cob = $this->reportmodel->insertCob($dataArray);
                                    echo "Cost of doing business = " . $cob . "<br />";
                                    echo "Good Karmora= " . $good_karmora_amount . "<br />";
                                    echo "===============================<br />";
                                }
                            }
                        }
                    }
                    // change process status for sales
                    $this->reportmodel->changeSalesStatus($sale['pk_sales_id']);
                } else {
                    $this->reportmodel->changeSalesStatusToConflict($sale['pk_sales_id']);
                }
            }
            exit;
        }
    }

    public function sales_payment_status($filter = "", $page = 1, $limit = 10) {


        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $search_string = '';
        $sales = $this->reportmodel->getAllSales($page, $limit, $filter);

        $data['sales'] = $sales;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }
        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/reporting/sales_payment_status/' . $filter);
        $data['paging'] = paging_generate($this->reportmodel->getCountAllSales($filter), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;

        $data['content'] = $this->load->view('admin/reporting/sales', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function changestatus($sale_id = '', $current_status = '', $page = 1, $limit = 10, $filter) {

        if ($current_status === "pending") {
            $data = array('sales_cashback_payment_status' => 'available');
        } else if ($current_status === "available") {
            $data = array('sales_cashback_payment_status' => 'pending');
        }
        $this->db->where('pk_sales_id', $sale_id);
        $this->db->update('tbl_sales', $data);

        $_SESSION['successmessage'] = 'Sales Status Changed Successfully';
        $this->session->set_flashdata('successmessage', '<div class="alert alert-info">Sales Status Changed Successfully</div>');
        redirect(base_url('admin/reporting/sales_payment_status/' . $filter . '/' . $page . '/' . $limt));
        exit;
    }

    public function queue_commissions_emails() {

        $listOfMembersToSendCommissionsEmail = $this->reportmodel->getAllUserwhoMadeCommission('NOW()');


        if ($listOfMembersToSendCommissionsEmail !== FALSE) {
            $count = 0;

            foreach ($listOfMembersToSendCommissionsEmail as $Member => $values) {

                $accountType = $this->db->select('get_user_account_type(' . $values['member_id'] . ') as accType')->get();
                $businessId = $this->db->select('get_account_type_business_id(' . $accountType->row()->accType . ') as businessId')->get();


                if ($businessId->row()->businessId === '1') {
                    // commercial commissions email
                    $email_data = $this->commonmodel->getemailInfo(6);

                    $subject = $email_data->email_title;
                    $to = $values['memeber_email'];
                    $replace = array($values['full_name'], base_url('cash-back'));
                    $tags = array("{full-name}", "{cash-back}");
                    $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $values['member_id']);

                    $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');

                    echo '<br>==================== Section' . $count . 'start =========================<br>' .
                    'User Id = ' . $values['member_id'] . '<br />' .
                    'Commission email queued for: ' . $values['full_name'] . '<br>' .
                    'Email address: ' . $values['memeber_email'] . '<br>' .
                    '==================== Section End =========================<br>';

                    // get referrer for this user
                    $referrrer_id = $this->reportmodel->getReferrer($values['member_id']);
                    // get user details of referrer
                    //echo $referrrer_id."<br />";
                    $referrer_details = $this->commonmodel->getUserDeta($referrrer_id);
                    //echo "<pre>";
                    //echo "referrer data";
                    //print_r($referrer_details);
                    //echo "======================================";
                    $referrer_email = $referrer_details->user_email;
                    // check community email for referrer
                    $checkCommunityEmail = $this->reportmodel->checkEmailType($referrrer_id, 2);
                    if ($checkCommunityEmail) {
                        $email_data = $this->commonmodel->getemailInfo(74);
                        $to = $referrer_email;
                        $replace = array($referrer_details->user_first_name . " " . $referrer_details->user_last_name, base_url('upgrade-info'));
                        $tags = array("{name}", "{upgrade-url}");
                        $subject = $email_data->email_title;
                        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
                        //     echo $message;
                        $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');
                    }
                    $count++;
                } elseif ($businessId->row()->businessId === '2') {
                    //fundraising commissions email
                    if ($accountType->row()->accType === '9') {

                        $ambassdorId = $this->reportmodel->getReferrer($values['member_id']);
                        $fundraisingId = $this->db->select('get_fundraising_org_of_with_user_id(' . $values['member_id'] . ') as fundId')->get();
                        $fundraisingName = $this->getCharityName($fundraisingId->row()->fundId);
                        $commercialReffer = $this->reportmodel->getReferrer($fundraisingId->row()->fundId);

                        $this->sendEmail56($values['member_id'], $fundraisingName);
                        $this->sendEmail53($ambassdorId, $fundraisingName);
                        $this->sendEmail53($fundraisingId->row()->fundId, $fundraisingName);
                        $this->sendEmail54($commercialReffer, $fundraisingName);
                    } elseif ($accountType->row()->accType === '7') {

                        $fundraisingId = $this->db->select('get_fundraising_org_of_with_user_id(' . $values['member_id'] . ') as fundId')->get();
                        $fundraisingName = $this->getCharityName($fundraisingId->row()->fundId);
                        $commercialReffer = $this->reportmodel->getReferrer($fundraisingId->row()->fundId);
                        $this->sendEmail56($values['member_id'], $fundraisingName);
                        $this->sendEmail55($fundraisingId->row()->fundId, $fundraisingName);
                        $this->sendEmail54($commercialReffer, $fundraisingName);
                    } elseif ($accountType->row()->accType === '6') {

                        $fundraisingName = $this->getCharityName($values['member_id']);
                        $this->sendEmail55($values['member_id'], $fundraisingName);
                        $commercialReffer = $this->reportmodel->getReferrer($values['member_id']);
                        $this->sendEmail54($commercialReffer, $fundraisingName);
                    }
                    $count++;
                }
            }

            // create email for referrer

            echo 'Number of emails queued: ' . $count . '<br> Commissions email queue created.';
            exit;
        } else {
            echo 'No Emails Found to send Commissions email.';
            exit;
        }
    }

    private function createCommissionsEmailQueue($to, $subject, $message, $from) {
        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {

            $data = array(
                'email_queue_recipient' => $to,
                'email_queue_from' => $from,
                'email_queue_subject' => $subject,
                'email_queue_message' => $message
            );
            $this->db->insert('tbl_email_queue', $data);
        }
    }

    private function getFullname($userId) {
        $name = $this->db->select('get_user_full_name(' . $userId . ') as fullName')->get();
        $response = count($name->row()) > 0 ? $name->row()->fullName : FALSE;
        return $response;
    }

    private function getCharityName($id) {
        $charityName = $this->db->select('fundraising_name')->from('tbl_users')->where('pk_user_id', $id)->limit(1)->get();
        $response = count($charityName->row()) > 0 ? $charityName->row()->fundraising_name : FALSE;
        return $response;
    }

    // Cash Back on Community Webstores to FO & Ambassador
    private function sendEmail53($id, $charityName) {
        $checkCommunityEmail = $this->reportmodel->checkEmailType($id, 2);
        if ($checkCommunityEmail) {
            $userData = $this->commonmodel->getUserDeta($id);
            $email_data = $this->commonmodel->getemailInfo(53);
            $to = $userData->user_email;
            $name = $this->getFullname($id);
            $replace = array($name, $charityName);
            $tags = array("{first-name}", "{charity-name}");
            $subject = $email_data->email_title;
            $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id);
            //     echo $message;
            $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');
            echo '<br>==================== Section start - Community Webstores to FO & Ambassador =========================<br>' .
            'User Id = ' . $id . '<br />' .
            'Commission email queued for: ' . $name . '<br>' .
            'Email address: ' . $to . '<br>' .
            '==================== Section End =========================<br>';
        }
    }

    //Cash Back on Personal Amabassador or Shopper Webstore
    private function sendEmail56($id, $charityName) {

        $userData = $this->commonmodel->getUserDeta($id);
        $email_data = $this->commonmodel->getemailInfo(56);
        $to = $userData->user_email;
        $name = $this->getFullname($id);
        $replace = array($name, $charityName);
        $tags = array("{full-name}", "{charity-name}");
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id);
        $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');
        echo '<br>==================== Section start - Personal Amabassador or Shopper Webstore =========================<br>' .
        'User Id = ' . $id . '<br />' .
        'Commission email queued for: ' . $name . '<br>' .
        'Email address: ' . $to . '<br>' .
        '==================== Section End =========================<br>';
    }

    //Cash Back on Main FO Webstore
    private function sendEmail55($id, $charityName) {

        $userData = $this->commonmodel->getUserDeta($id);
        $email_data = $this->commonmodel->getemailInfo(55);
        $to = $userData->user_email;
        $name = $this->getFullname($id);
        $replace = array($name, $charityName);
        $tags = array("{full-name}", "{charity-name}");
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id);
        $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');
        echo '<br>==================== Section start - Main FO Webstore =========================<br>' .
        'User Id = ' . $id . '<br />' .
        'Commission email queued for: ' . $name . '<br>' .
        'Email address: ' . $to . '<br>' .
        '==================== Section End =========================<br>';
    }

    //Cash Back on Community Webstores to Webstore Owner
    private function sendEmail54($id, $charityName) {
        $checkCommunityEmail = $this->reportmodel->checkEmailType($id, 2);

        if ($checkCommunityEmail) {
            $userData = $this->commonmodel->getUserDeta($id);
            $email_data = $this->commonmodel->getemailInfo(55);
            $to = $userData->user_email;
            $replace = array($userData->user_first_name, $charityName);
            $tags = array("{full-name}", "{charity-name}");
            $subject = $email_data->email_title;
            $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id);
            $this->createCommissionsEmailQueue($to, $subject, $message, 'noreply@karmora.com');
            echo '<br>==================== Section start - Community Webstores to Webstore Owner=========================<br>' .
            'User Id = ' . $id . '<br />' .
            'Commission email queued for: ' . $name . '<br>' .
            'Email address: ' . $to . '<br>' .
            '==================== Section End =========================<br>';
        }
    }

}
