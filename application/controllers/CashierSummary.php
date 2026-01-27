<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierSummary extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Summaryinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        // Get summaries for current user's shifts (filtered by cashier_id from token)
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['shift_summaries'] = $this->Summaryinfo->getShiftSummaries($this->api_token,[]);

        $this->load->view('Cashier/Summary', $result);
    }

    public function getShiftSummaries() {
        // Returns summaries filtered by current user (handled by backend API)
        // Accept include_series2 parameter to show Series 2 data (is_confirm = 0)
        $include_series2 = $this->input->get('include_series2') ?: 0;
        $params = ['include_series2' => $include_series2];
        $response = $this->Summaryinfo->getShiftSummaries($this->api_token, $params);
        echo json_encode($response);
    }

    public function getSummaryById($id) {
        $response = $this->Summaryinfo->getSummaryById($this->api_token, $id);
        echo json_encode($response);
    }

    public function datatable() {
        // Get all POST data from DataTables request
        $postData = $this->input->post();
        $response = $this->Summaryinfo->getShiftSummariesDatatable($this->api_token, $postData);
        echo json_encode($response);
    }

    /**
     * Get cash book summary for a shift
     */
    public function getCashBookSummary($shiftId) {
        $response = $this->Summaryinfo->getCashBookSummary($this->api_token, $shiftId);
        echo json_encode($response);
    }

    /**
     * Get calculated cash book summary (real-time calculation)
     */
    public function getCalculatedSummary($shiftId) {
        $response = $this->Summaryinfo->getCalculatedSummary($this->api_token, $shiftId);
        echo json_encode($response);
    }

    /**
     * Save cash book summary (create or update)
     */
    public function saveCashBookSummary($shiftId) {
        $response = $this->Summaryinfo->saveCashBookSummary($this->api_token, $shiftId);
        echo json_encode($response);
    }
}
