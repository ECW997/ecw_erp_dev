<?php
class IouSettlementinfo extends CI_Model{

    public function getSettlements($api_token, $shift_id = null) {
        $headers = get_api_headers($api_token);
        $params = $shift_id ? ['shift_id' => $shift_id] : [];
        return call_api('GET', 'iou_settlement_v1', $params, $headers);
    }

    public function getSettlementById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'iou_settlement_v1', $id, $headers);
    }

    public function createSettlement($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'iou_settlement_v1', $form_data, $headers);
    }

    public function updateSettlement($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        $form_data['recordID'] = $id;
        return call_api('PUT', 'iou_settlement_v1', $form_data, $headers);
    }

    public function deleteSettlement($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'iou_settlement_v1', $id, $headers);
    }

    public function getOutstandingIous($api_token, $shift_id = null) {
        $headers = get_api_headers($api_token);
        $params = $shift_id ? ['shift_id' => $shift_id] : [];
        return call_api('GET', 'outstanding_ious_v1', $params, $headers);
    }

    /**
     * Get settlements for DataTables server-side processing
     */
    public function getSettlementsDatatable($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'iou_settlement_datatable_v1', $params, $headers);
    }

    /**
     * Get outstanding IOUs for DataTables server-side processing
     */
    public function getOutstandingIousDatatable($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'outstanding_ious_datatable_v1', $params, $headers);
    }
}

