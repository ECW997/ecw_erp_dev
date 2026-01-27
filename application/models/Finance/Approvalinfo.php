<?php
class Approvalinfo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function getApprovals($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_approval_v1', $params, $headers);
    }

    public function getApproval($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_approval_v1', ['id' => $id], $headers);
    }

    public function createApproval($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'finance_approval_v1', $form_data, $headers);
    }

    public function approveRequest($api_token, $id, $remarks = null) {
        $headers = get_api_headers($api_token);
        $data = $remarks ? ['approval_remarks' => $remarks] : [];
        return call_api('POST', 'finance_approval_approve_v1', array_merge(['id' => $id], $data), $headers);
    }

    public function rejectRequest($api_token, $id, $remarks) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'finance_approval_reject_v1', ['id' => $id, 'rejection_remarks' => $remarks], $headers);
    }

    public function getPendingApprovals($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'finance_approval_pending_v1', [], $headers);
    }
}

