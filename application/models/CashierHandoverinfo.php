<?php
class CashierHandoverinfo extends CI_Model{

    public function getHandoverLogs($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_handover_v1', $form_data, $headers);
    }

    public function updateHandoverAmount($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_handover_v1', $form_data, $headers);
    }
}