<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierSummary extends CI_Controller {
    protected $api_token;

    public function __construct() {
        parent::__construct();
        $this->load->model('Cashierinfo');
        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
    }

    public function index() {
        $result['summaries'] = $this->Cashierinfo->getShiftSummaries($this->api_token);
        $this->load->view('cashier_summary/index', $result);
    }
}
