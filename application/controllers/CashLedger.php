<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashLedger extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('CashierTransactionLedgerinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['transactions'] = $this->CashierTransactionLedgerinfo->getTransactionLedgers($this->api_token,[]);

		$this->load->view('cashier_transaction_ledger', $result);

	}

}

?>