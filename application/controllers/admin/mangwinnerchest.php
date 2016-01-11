<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mangwinnerchest extends CI_Controller {

    public $page = 'mangwinnerchest';
    private $template;
    private $header;
    private $footer;
    private $sidebar;
    private $content;
    public $data;

    /**
     * Constructor of a login 
     */
    function __construct() {
        parent::__construct(); //call to parent constructor
        session_start();
        $this->load->helper(array('form', 'url'));
        // load model(s)
        $this->data = "";
        $this->page = 'mangwinnerchest';
        $this->load->library('form_validation');
        $this->header = $this->load->view('admin/header', $this->data, TRUE);
        $this->template = $this->load->view('admin/template', $this->data, TRUE);
        $this->footer = $this->load->view('admin/footer', $this->data, TRUE);
        $this->load->model(array('admin/managewinnerchestmodel', 'commonmodel'));
        if (!isset($this->session->userdata) || !$this->session->userdata('admin_data')) {
            redirect('admin/index');
        }
    }

    /**
     * This is  function of a seraching 
     */
    public function getSearchString($page = 1, $limit = 20) {
        $data['page'] = $this->page;
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        if (isset($_POST['search_me']) && ($_POST['search_me'] != '')) {
            $search_string = $_POST['search'];
            $AllChest = $this->managewinnerchestmodel->getSearch($page, $limit, $search_string);
            $data['AllChest'] = $AllChest;

            // generate paging
            $this->load->helper('paging');
            $datagridURL = site_url('admin/mangwinnerchest/index');
            $data['paging'] = paging_generate($this->managewinnerchestmodel->getCountAllchest($search_string), $page, $limit, 5, $datagridURL);
            $data['datagridURL'] = $datagridURL;
            $data['currentpage'] = $page;
            $data['rowslimit'] = $limit;
            $data['content'] = $this->load->view('admin/managewinnerchest/grid', $data, TRUE);
            $data['sidebar'] = $this->load->view('admin/sidebar', $this->page, TRUE);
            $this->load->view('admin/template', $data);
        } else {
            redirect(base_url('admin/mangwinnerchest/index'));
        }
    }

    /**
     * This is the default function of a controller 
     */
    public function index($page = 1, $limit = 20) {
        $search_string = '';
        $AllChest = $this->managewinnerchestmodel->getAllchest($page, $limit);
        $data['AllChest'] = $AllChest;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managewinnerchest/index');
        $data['paging'] = paging_generate($this->managewinnerchestmodel->getCountAllchest($search_string), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/managewinnerchest/grid', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function add() {
        $data = '';

        if (isset($_POST['submit'])) {

            $str_time = $this->input->post('str_time');
            $end_time = $this->input->post('end_time');


            $setting = $this->input->post('setting');
            if ($setting == 'Fixed') {
                $this->form_validation->set_rules('store_id[]', 'Store', 'trim|required');
            }

            $this->form_validation->set_rules('limit', 'Limit', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
            $this->form_validation->set_rules('str_time', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('end_time', 'End Date', 'trim|required|callback_timecheck');

            if ($this->form_validation->run() == FALSE) {
                
            } else { // no errors now to save the data
                $store_type = $this->input->post('store_type');
                $setting = $this->input->post('setting');
                $store_id = $this->input->post('store_id');

                if ($setting == 'Random') {
                    $store_id = 0;
                }

                $limit = $this->input->post('limit');
                $amount = $this->input->post('amount');
                $quantity = $this->input->post('quantity');
                $str_time = $this->input->post('str_time');
                $end_time = $this->input->post('end_time');
                $str_time = date('Y-m-d', strtotime($str_time));
                $end_time = date('Y-m-d', strtotime($end_time));

                $datas = array(
                    'amount' => $amount,
                    'quantity' => $quantity,
                    'setting' => $setting,
                    'store_limit' => $limit,
                    'start_date' => $str_time,
                    'end_date' => $end_time
                );
                $this->db->insert('tbl_winner_chest', $datas);
                $tresure_chest_id = $this->db->insert_id();

                $counter = count($store_id);
                for ($i = 0; $i < $counter; $i++) {
                    $tbl_winner_chest_to_store = array(
                        'fk_store_id' => $store_id[$i],
                        'fk_chest_id' => $tresure_chest_id,
                        'status' => 1
                    );
                    $this->db->insert('tbl_winner_chest_to_store', $tbl_winner_chest_to_store);
                }


                if (count($store_type) > 1) {
                    if ($store_type[0] == 1) {

                        $datas = array(array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 1
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 2
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 5
                            ),
                        );
                        $this->db->insert_batch('tbl_winner_chest_to_user_account_type', $datas);
                    }
                    if ($store_type[1] == 6) {

                        $datas = array(array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 6
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 7
                        ));
                        $this->db->insert_batch('tbl_winner_chest_to_user_account_type', $datas);
                    }
                } else {
                    if ($store_type[0] == 1) {

                        $datas = array(array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 1
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 2
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 5
                            ),
                        );
                        $this->db->insert_batch('tbl_winner_chest_to_user_account_type', $datas);
                    } else if ($store_type[0] == 6) {

                        $datas = array(array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 6
                            ),
                            array(
                                'fk_chest_id' => $tresure_chest_id,
                                'fk_user_account_id' => 7
                        ));
                        $this->db->insert_batch('tbl_winner_chest_to_user_account_type', $datas);
                    }
                }
                $this->db->insert_batch('tbl_winner_chest_to_user_account_type', $datas);
                $_SESSION['successmessage'] = 'Chest Added Successfully';
                $data['successmessage'] = $_SESSION['successmessage'];
                //$this->session->set_flashdata('successmessage', '<div class="alert alert-info">Post Updated Successfully</div>');
                // redirect('admin/managepost/index');
            }
        }
        $stores = $this->managewinnerchestmodel->getAllStores();
        $data['store'] = $stores;
        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/managewinnerchest/add', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);

        $this->load->view('admin/template', $data);
    }

    public function delete($tresure_chest_id = '') {

        $this->db->where('tresure_chest_id', $tresure_chest_id);
        $this->db->delete('tbl_winner_chest');

        $this->db->where('fk_chest_id', $tresure_chest_id);
        $this->db->delete('tbl_winner_chest_to_user_account_type');

        $this->db->where('fk_chest_id', $tresure_chest_id);
        $this->db->delete('tbl_winner_chest_to_store');

        $_SESSION['successmessage'] = 'Winner Chest Deleted Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/index'));
    }

    ////////////////////////// delte function end /////////////
    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeStatus($tresure_chest_id = '', $current_status = '') {

        $data = array('status' => $current_status);
        $this->db->where('tresure_chest_id', $tresure_chest_id);
        $this->db->update('tbl_winner_chest', $data);
        $_SESSION['successmessage'] = 'Chest Status Changed Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/index'));
    }

    /**
     *  callback function for checking duplicate username
     */
    public function timecheck($end_time) {
        $str_time = $this->input->post('str_time');

        $timeFirst = strtotime($str_time);
        $timeSecond = strtotime($end_time);
        $differenceInSeconds = $timeSecond - $timeFirst;
        $days = floor($differenceInSeconds / (60 * 60 * 24));

        if ($days <= 0) {
            $this->form_validation->set_message('timecheck', 'Sorry %s Greter Then Less Date');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //This function will check the stores type function from ajex call 
    public function StoreType($parent_id = '') {
        $stores = $this->managewinnerchestmodel->getStoretype($parent_id);
        $data['store'] = $stores;
        $this->load->view('admin/managewinnerchest/parent_page', $data);
    }

    //This function will use for random function
    public function random($tresure_chest_id = '', $limit) {

        $this->db->where('fk_chest_id', $tresure_chest_id);
        $this->db->delete('tbl_winner_chest_to_store');

        $accounttype = $this->managewinnerchestmodel->getaccounttype($tresure_chest_id);
        if ($accounttype != '') {
            $stores = $this->managewinnerchestmodel->getrandomStores($accounttype, $limit);
            foreach ($stores as $st) {
                $tbl_winner_chest_to_store = array(
                    'fk_store_id' => $st['fk_store_id'],
                    'fk_chest_id' => $tresure_chest_id,
                    'status' => 1
                );
                $this->db->insert('tbl_winner_chest_to_store', $tbl_winner_chest_to_store);
            }
        }

        $_SESSION['successmessage'] = 'Random Store Added Successfully';
        redirect(base_url('admin/mangwinnerchest/index'));
    }

    public function tresureuser($page = 1, $limit = 20) {
        $search_string = '';
        $AllChestU = $this->managewinnerchestmodel->getAllTresureUser($page, $limit);
        $data['AllChest'] = $AllChestU;

        if (isset($_SESSION['successmessage'])) {
            $data['successmessage'] = $_SESSION['successmessage'];
            unset($_SESSION['successmessage']);
        }


        // generate paging
        $this->load->helper('paging');
        $datagridURL = site_url('admin/managewinnerchest/tresureuser');
        $data['paging'] = paging_generate($this->managewinnerchestmodel->getCountTresureUser(), $page, $limit, 5, $datagridURL);
        $data['datagridURL'] = $datagridURL;
        $data['currentpage'] = $page;
        $data['rowslimit'] = $limit;
        $data['page'] = $this->page;


        $data['header'] = $this->load->view('admin/header', $data, TRUE);
        $data['footer'] = $this->load->view('admin/footer', $data, TRUE);
        $data['content'] = $this->load->view('admin/managewinnerchest/user', $data, TRUE);
        $data['sidebar'] = $this->load->view('admin/sidebar', $data, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function deleteuser($winnerchest_statics_pk_id = '') {

        $this->db->where('winnerchest_statics_pk_id', $winnerchest_statics_pk_id);
        $this->db->delete('tbl_winner_chest_statistics');

        $_SESSION['successmessage'] = 'Winnerchest User Deleted Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/tresureuser'));
    }

    ////////////////////////// delte function end /////////////
    ////////////////////////// delte function end /////////////

    /**
     * will change status of record
     */
    public function changeUserStatus($winnerchest_statics_pk_id = '', $current_status = '') {
        $data = array('status' => $current_status);
        $this->db->where('winnerchest_statics_pk_id', $winnerchest_statics_pk_id);
        $this->db->update('tbl_winner_chest_statistics', $data);
        $_SESSION['successmessage'] = 'Winnerchest User Status Changed Successfully</div>';
        redirect(base_url('admin/mangwinnerchest/tresureuser'));
    }

}
