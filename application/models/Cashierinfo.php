<?php
class Cashierinfo extends CI_Model{

    public function checkCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_v1', $form_data, $headers);
    }

    public function startCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_v1', $form_data, $headers);
    }

    public function closeCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_v1', $form_data, $headers);
    }

    public function getCashierShiftRecDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_v1', $id, $headers);
    }

    public function updateShiftOpeningBalances($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'update_shift_opening_balance_v1', $form_data, $headers);
    }

    public function approveShiftOpeningBalances($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'approve_shift_opening_balance_v1', $form_data, $headers);
    }
}