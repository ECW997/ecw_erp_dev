<?php
class CashierDebitorinfo extends CI_Model{

    public function debtorInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_debitor_v1', $form_data, $headers);
    }

    public function debtorUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_debitor_v1', $form_data, $headers);
    }

    public function debtorEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_debitor_v1', $id, $headers);
    }

    public function debtorDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'cashier_debitor_v1', $id, $headers);
    }

    public function debtorTransferToCredit($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_debitor_transfer_v1', $form_data, $headers);
    }

    public function debtorOrCreditPDF($api_token,$type,$params = []) {
        $headers = get_api_headers($api_token);
        $queryString = '';
        if (!empty($params)) {
            $queryString = '?' . http_build_query($params);
        }

        return call_api('GET', 'cashier_debitor_pdf_v1', $type.$queryString, $headers);
    }
}