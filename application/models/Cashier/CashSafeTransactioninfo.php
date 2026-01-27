<?php
class CashSafeTransactioninfo extends CI_Model{

    public function getAllCashSafeTransactions($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', '/v1/cashier/cash_safe_v1', $params, $headers);
    }

    public function getCashSafeTransaction($api_token, $id) {
        $headers = get_api_headers($api_token);
        // Use direct endpoint path to avoid config lookup issues
        return call_api('GET', '/v1/cashier/cash_safe_v1/' . $id, [], $headers);
    }

    public function createCashSafeTransaction($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', '/v1/cashier/cash_safe_v1', $form_data, $headers);
    }

    public function updateCashSafeTransaction($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', '/v1/cashier/cash_safe_v1/' . $id, $form_data, $headers);
    }

    public function deleteCashSafeTransaction($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', '/v1/cashier/cash_safe_v1/' . $id, [], $headers);
    }

    public function confirmCashSafeTransaction($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', '/v1/cashier/cash_safe_v1/' . $id . '/confirm', [], $headers);
    }

    public function approveCashSafeTransaction($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', '/v1/cashier/cash_safe_v1/' . $id . '/approve', [], $headers);
    }

    public function cancelCashSafeTransaction($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', '/v1/cashier/cash_safe_v1/' . $id . '/cancel', [], $headers);
    }

    public function getCashSafeTransactionSummary($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', '/v1/cashier/cash_safe/summary_v1', $params, $headers);
    }

    public function getCashSafeTransactionOptions($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', '/v1/cashier/cash_safe/options_v1', [], $headers);
    }

    public function getCashSafeTransactionDatatable($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('POST', '/v1/cashier/cash_safe/datatable_v1', $params, $headers);
    }
}
