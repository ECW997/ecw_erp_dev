<?php
class Adjustmentinfo extends CI_Model{

    public function getAdjustments($api_token, $shift_id = null, $include_series2 = 0) {
        $headers = get_api_headers($api_token);
        $params = [];
        if ($shift_id) {
            $params['shift_id'] = $shift_id;
        }
        if ($include_series2) {
            $params['include_series2'] = $include_series2;
        }
        return call_api('GET', 'cashier_shift_adjustment_v1', $params, $headers);
    }

    public function createAdjustment($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_shift_adjustment_v1', $form_data, $headers);
    }

    public function updateAdjustment($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        $form_data['recordID'] = $id;
        return call_api('PUT', 'cashier_shift_adjustment_v1', $form_data, $headers);
    }

    public function deleteAdjustment($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'cashier_shift_adjustment_v1', $id, $headers);
    }

    public function getAdjustmentById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_adjustment_v1', $id, $headers);
    }

    public function getAdjustmentsDatatable($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_shift_adjustment_datatable_v1', $form_data, $headers);
    }
}

