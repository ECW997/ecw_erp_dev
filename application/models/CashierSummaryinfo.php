<?php
class CashierSummaryinfo extends CI_Model{

    public function getShiftSummaries($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_summary_v1', $form_data, $headers);
    }
}