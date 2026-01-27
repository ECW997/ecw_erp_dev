<?php
class AccountMasterinfo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function getAccountMasters($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_account_master_v1', $params, $headers);
    }

    public function getAccountMaster($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_account_master_v1', ['id' => $id], $headers);
    }

    public function createAccountMaster($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'finance_account_master_v1', $form_data, $headers);
    }

    public function updateAccountMaster($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'finance_account_master_v1', array_merge(['id' => $id], $form_data), $headers);
    }

    public function deleteAccountMaster($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'finance_account_master_v1', ['id' => $id], $headers);
    }

    public function getAccountTree($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_account_master_tree_v1', [], $headers);
    }
}

